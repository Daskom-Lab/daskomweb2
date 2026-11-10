<?php

namespace App\Http\Controllers\API;

use App\Events\ActivePraktikumBroadcast;
use App\Events\PraktikumProgressUpdated;
use App\Events\PraktikumStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\LaporanPraktikan;
use App\Models\Praktikum;
use App\Services\Praktikum\QuestionProgressService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PraktikumController extends Controller
{
    private const PHASES = [
        'preparation',
        'ta',
        'fitb_jurnal',
        'mandiri',
        'tk',
        'feedback',
    ];

    public function index(Request $request): JsonResponse
    {
        try {
            $data = Praktikum::with(['modul', 'kelas', 'pj'])
                ->when($request->filled('kelas_id'), fn ($q) => $q->where('kelas_id', $request->kelas_id))
                ->when($request->filled('modul_id'), fn ($q) => $q->where('modul_id', $request->modul_id))
                ->when($request->filled('dk'), fn ($q) => $q->where('dk', $request->dk))
                ->orderBy('kelas_id')
                ->orderBy('dk')
                ->orderBy('modul_id')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Praktikum retrieved successfully.',
                'data' => $data,
                'phases' => self::PHASES,
            ]);
        } catch (\Throwable $e) {
            return $this->serverError($e);
        }
    }

    public function show(Request $request, int $kelasId): JsonResponse
    {
        try {
            $data = Praktikum::with(['modul', 'kelas', 'pj'])
                ->where('kelas_id', $kelasId)
                ->when($request->filled('modul_id'), fn ($q) => $q->where('modul_id', $request->modul_id))
                ->when($request->filled('dk'), fn ($q) => $q->where('dk', $request->dk))
                ->orderBy('dk')
                ->orderBy('modul_id')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Praktikum retrieved successfully.',
                'data' => $data,
                'phases' => self::PHASES,
            ]);
        } catch (\Throwable $e) {
            return $this->serverError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'modul_id' => 'required|exists:moduls,id',
            'dk' => 'required|string|in:DK1,DK2',
        ]);

        $praktikum = Praktikum::firstOrCreate(
            [
                'kelas_id' => $data['kelas_id'],
                'modul_id' => $data['modul_id'],
                'dk' => $data['dk'],
            ],
            [
                'status' => 'idle',
                'current_phase' => self::PHASES[0],
                'phase_elapsed_seconds' => 0,
                'phase_started_at' => null,
                'isActive' => false,
                'started_at' => null,
                'ended_at' => null,
                'report_notes' => null,
                'report_submitted_at' => null,
                'pj_id' => null,
            ]
        );

        $praktikum->load(['modul', 'kelas', 'pj']);

        return response()->json([
            'status' => 'success',
            'message' => $praktikum->wasRecentlyCreated
                ? 'Praktikum created successfully.'
                : 'Praktikum already exists.',
            'data' => $praktikum,
        ], $praktikum->wasRecentlyCreated ? 201 : 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'action' => 'required|string|in:start,pause,resume,next,exit,report',
            'phase' => 'nullable|string',
            'report_notes' => 'required_if:action,report|string|min:3|max:65535',
        ]);

        $phase = $data['phase'] ?? null;

        if ($phase !== null && ! in_array($phase, self::PHASES, true)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phase is not valid.',
            ], 422);
        }

        $praktikum = Praktikum::with(['modul', 'kelas', 'pj'])->find($id);

        if (! $praktikum) {
            return response()->json([
                'status' => 'error',
                'message' => 'Praktikum not found.',
            ], 404);
        }

        $now = Carbon::now();
        $pjId = $data['action'] === 'report'
            ? optional($request->user('asisten'))->id ?? optional(Auth::user())->id
            : null;

        try {
            match ($data['action']) {
                'start' => $this->start($praktikum, $phase ?? self::PHASES[0], $now),
                'pause' => $this->pause($praktikum, $now),
                'resume' => $this->resume($praktikum, $now),
                'next' => $this->next($praktikum, $phase, $now),
                'exit' => $this->exit($praktikum, $now),
                'report' => $this->report($praktikum, $data['report_notes'], $now, $pjId),
            };
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return $this->serverError($e);
        }

        $praktikum = $praktikum->fresh(['modul', 'kelas', 'pj']);

        broadcast(new PraktikumStatusUpdated($praktikum));

        $progress = app(QuestionProgressService::class)
            ->buildForPraktikum($praktikum);

        broadcast(new PraktikumProgressUpdated(
            $praktikum->id,
            $progress
        ));

        broadcast(new ActivePraktikumBroadcast);

        return response()->json([
            'status' => 'success',
            'message' => 'Praktikum updated successfully.',
            'data' => $praktikum,
            'phases' => self::PHASES,
        ]);
    }

    private function start(
        Praktikum $praktikum,
        string $phase,
        Carbon $now
    ): void {
        $running = Praktikum::where('kelas_id', $praktikum->kelas_id)
            ->where('dk', $praktikum->dk)
            ->where('id', '!=', $praktikum->id)
            ->whereIn('status', ['running', 'paused'])
            ->first();

        if ($running) {
            throw new \InvalidArgumentException(
                'Tidak dapat memulai praktikum. Terdapat praktikum lain yang sedang berjalan untuk kelas ini.'
            );
        }

        $praktikum->fill([
            'isActive' => true,
            'status' => 'running',
            'current_phase' => $phase,
            'started_at' => $now,
            'ended_at' => null,
            'report_notes' => null,
            'report_submitted_at' => null,
            'pj_id' => optional(Auth::user())->id,
        ]);

        $this->resetTiming($praktikum, $now);
        $praktikum->save();
    }

    private function pause(Praktikum $praktikum, Carbon $now): void
    {
        if ($praktikum->status !== 'running') {
            throw new \InvalidArgumentException(
                'Praktikum is not running.'
            );
        }

        $praktikum->status = 'paused';
        $praktikum->isActive = false;
        $praktikum->ended_at = $now;

        $this->freezeTiming($praktikum, $now);
        $praktikum->save();
    }

    private function resume(Praktikum $praktikum, Carbon $now): void
    {
        if ($praktikum->status !== 'paused') {
            throw new \InvalidArgumentException(
                'Praktikum is not paused.'
            );
        }

        $elapsed = 0;

        if ($praktikum->started_at) {
            $reference = $praktikum->ended_at ?? $now;
            $elapsed = (int) abs(
                $praktikum->started_at->diffInSeconds($reference, absolute: true)
            );
        }

        $praktikum->status = 'running';
        $praktikum->isActive = true;
        $praktikum->started_at = $now->copy()->subSeconds($elapsed);
        $praktikum->ended_at = null;
        $praktikum->phase_started_at = $now;
        $praktikum->save();
    }

    private function next(
        Praktikum $praktikum,
        ?string $phase,
        Carbon $now
    ): void {
        if ($phase !== null) {
            $index = array_search($phase, self::PHASES, true);

            if ($index === false) {
                throw new \InvalidArgumentException(
                    'Invalid phase provided.'
                );
            }

            if ($index === count(self::PHASES) - 1) {
                $praktikum->status = 'completed';
                $praktikum->isActive = false;
                $praktikum->current_phase = $phase;
                $praktikum->ended_at = $now;
                $this->freezeTiming($praktikum, $now);
            } else {
                $this->moveToPhase(
                    $praktikum,
                    $phase,
                    $now
                );
            }

            $praktikum->save();

            return;
        }

        $current = $praktikum->current_phase ?? self::PHASES[0];
        $index = array_search($current, self::PHASES, true);

        if ($index === false) {
            throw new \InvalidArgumentException(
                'Current phase is invalid.'
            );
        }

        if ($index === count(self::PHASES) - 1) {
            $praktikum->status = 'completed';
            $praktikum->isActive = false;
            $praktikum->ended_at = $now;

            $this->freezeTiming($praktikum, $now);
        } else {
            $this->moveToPhase(
                $praktikum,
                self::PHASES[$index + 1],
                $now
            );
        }

        $praktikum->save();
    }

    private function moveToPhase(
        Praktikum $praktikum,
        string $phase,
        Carbon $now
    ): void {
        if ($praktikum->started_at) {
            $reference = $praktikum->ended_at ?? $now;
            $elapsed = (int) abs(
                $praktikum->started_at->diffInSeconds($reference, absolute: true)
            );

            $praktikum->started_at =
                $now->copy()->subSeconds($elapsed);
        }

        $praktikum->current_phase = $phase;
        $praktikum->status = 'running';
        $praktikum->isActive = true;
        $praktikum->ended_at = null;

        $this->resetTiming($praktikum, $now);
    }

    private function exit(Praktikum $praktikum, Carbon $now): void
    {
        $praktikum->status = 'exited';
        $praktikum->isActive = false;
        $praktikum->ended_at = $now;

        $this->freezeTiming($praktikum, $now);
        $praktikum->save();
    }

    private function report(
        Praktikum $praktikum,
        string $notes,
        Carbon $now,
        ?int $pjId
    ): void {
        if ($praktikum->status !== 'completed') {
            throw new \InvalidArgumentException(
                'Laporan hanya dapat diisi setelah praktikum selesai.'
            );
        }

        $notes = trim($notes);

        if ($notes === '') {
            throw new \InvalidArgumentException(
                'Isi laporan tidak boleh kosong.'
            );
        }

        $praktikum->report_notes = $notes;
        $praktikum->report_submitted_at = $now;
        $praktikum->pj_id = $pjId;
        $praktikum->save();
    }

    public function checkPraktikum(Request $request): JsonResponse
    {
        try {
            $user = $request->user('praktikan');

            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized. Praktikan not authenticated.',
                ], 401);
            }

            if (! $user->kelas_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Praktikan does not have an assigned kelas.',
                ], 400);
            }

            if (! $user->dk) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Praktikan belum memilih DK. Silakan pilih DK terlebih dahulu.',
                    'dk_required' => true,
                    'data' => null,
                    'phases' => self::PHASES,
                    'feedback_pending' => false,
                    'feedback_modul_id' => null,
                    'feedback_asisten_id' => null,
                ]);
            }

            $active = Praktikum::with(['modul', 'kelas', 'pj'])
                ->where('kelas_id', $user->kelas_id)
                ->where('dk', $user->dk)
                ->where('isActive', true)
                ->whereIn('status', ['running', 'paused'])
                ->first();

            $completed = Praktikum::with(['modul', 'kelas', 'pj'])
                ->where('kelas_id', $user->kelas_id)
                ->where('dk', $user->dk)
                ->where('status', 'completed')
                ->orderByDesc('ended_at')
                ->orderByDesc('updated_at')
                ->first();

            $feedbackPending = false;
            $feedbackModulId = null;
            $feedbackAsistenId = null;

            /*
             * Feedback must belong to THIS run.
             *
             * Old feedback for the same practitioner/module must not
             * suppress feedback after the prakticum is started again.
             */
            if ($completed) {
                $feedbackQuery = LaporanPraktikan::query()
                    ->where('praktikan_id', $user->id)
                    ->where('modul_id', $completed->modul_id);

                if ($completed->started_at) {
                    $feedbackQuery->where(
                        'updated_at',
                        '>=',
                        $completed->started_at
                    );
                }

                if (! $feedbackQuery->exists()) {
                    $feedbackPending = true;
                    $feedbackModulId = $completed->modul_id;
                    $feedbackAsistenId = $completed->pj_id;
                }
            }

            /*
             * Important for TK:
             *
             * entering feedback marks the prakticum completed and
             * isActive=false. While feedback is still pending, return
             * that completed praktikum as `data` so PraktikumPage can
             * observe the TK -> feedback transition and show TK score.
             */
            $display = $active ??
                ($feedbackPending ? $completed : null);

            if ($display) {
                $sameModule =
                    $feedbackPending &&
                    $feedbackModulId !== null &&
                    (int) $display->modul_id ===
                        (int) $feedbackModulId;

                $display->setAttribute(
                    'feedback_pending',
                    $sameModule
                );

                $display->setAttribute(
                    'feedback_modul_id',
                    $feedbackModulId
                );

                $display->setAttribute(
                    'feedback_asisten_id',
                    $feedbackAsistenId
                );
            }

            return response()->json([
                'status' => 'success',
                'message' => $active
                    ? 'Active praktikum found.'
                    : ($feedbackPending
                        ? 'Praktikum completed. Feedback pending.'
                        : 'No active praktikum for this kelas.'),
                'data' => $display,
                'phases' => self::PHASES,
                'feedback_pending' => $feedbackPending,
                'feedback_modul_id' => $feedbackModulId,
                'feedback_asisten_id' => $feedbackAsistenId,
            ]);
        } catch (\Throwable $e) {
            return $this->serverError($e);
        }
    }

    public function storeDk(Request $request): JsonResponse
    {
        $data = $request->validate([
            'dk' => 'required|string|in:DK1,DK2',
        ]);

        $user = $request->user('praktikan');

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Praktikan not authenticated.',
            ], 401);
        }

        $user->dk = $data['dk'];
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'DK berhasil disimpan.',
            'dk' => $user->dk,
        ]);
    }

    public function history(Request $request): JsonResponse
    {
        try {
            $data = Praktikum::with(['modul', 'kelas', 'pj'])
                ->whereNotNull('report_notes')
                ->when($request->filled('kelas_id'), fn ($q) => $q->where('kelas_id', $request->kelas_id))
                ->when($request->filled('modul_id'), fn ($q) => $q->where('modul_id', $request->modul_id))
                ->orderByDesc('report_submitted_at')
                ->orderByDesc('updated_at')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'History retrieved successfully.',
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            return $this->serverError($e);
        }
    }

    private function elapsed(
        Praktikum $praktikum,
        Carbon $now
    ): int {
        $seconds = max(
            0,
            (int) ($praktikum->phase_elapsed_seconds ?? 0)
        );

        if ($praktikum->phase_started_at instanceof Carbon) {
            $seconds += (int) abs(
                $praktikum->phase_started_at->diffInSeconds($now, absolute: true)
            );
        }

        return $seconds;
    }

    private function resetTiming(
        Praktikum $praktikum,
        Carbon $now
    ): void {
        $praktikum->phase_elapsed_seconds = 0;
        $praktikum->phase_started_at = $now;
    }

    private function freezeTiming(
        Praktikum $praktikum,
        Carbon $now
    ): void {
        $praktikum->phase_elapsed_seconds =
            $this->elapsed($praktikum, $now);

        $praktikum->phase_started_at = null;
    }

    private function serverError(\Throwable $e): JsonResponse
    {
        report($e);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while processing the request.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
