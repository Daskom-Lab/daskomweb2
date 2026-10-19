<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Praktikan;
use App\Models\SoalOpsi;
use App\Models\SoalTk;
use App\Services\Praktikum\DifficultyQuestionRandomizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SoalTKController extends Controller
{
    public function index(): void {}

    public function __construct(private DifficultyQuestionRandomizer $randomizer) {}

    public function store(Request $request, int $modulId): JsonResponse
    {
        $validated = $this->validateStore($request, $modulId);

        try {
            $soal = DB::transaction(function () use ($validated, $modulId) {
                $soal = SoalTk::create([
                    'modul_id' => $modulId,
                    'pertanyaan' => $validated['pertanyaan'],
                ]);

                $optionIds = $this->syncOptions($soal, $validated['options']);
                $this->applyOptionReferences($soal, $optionIds, $validated['correct_option']);

                return $soal->load('options');
            });

            return response()->json([
                'status' => 'success',
                'data' => $this->formatAssistantSoal($soal),
            ], 200);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, int $modulId): JsonResponse
    {
        $modul = Modul::find($modulId);
        if (! $modul) {
            return response()->json(['message' => "Modul dengan ID {$modulId} tidak ditemukan."], 404);
        }

        $user = auth('praktikan')->user();
        $query = SoalTk::with('options')->where('modul_id', $modulId);
        $ids = collect(Arr::wrap($request->query('question_ids')))
            ->flatMap(fn ($value) => is_array($value) ? $value : explode(',', (string) $value))
            ->map(fn ($value) => (int) $value)
            ->filter(fn ($value) => $value > 0)
            ->values();

        if ($user) {
            if ($this->randomizer->isTot($user)) {
                $soals = (clone $query)->orderBy('id')->get();
            } else {
                $counts = $this->randomizer->counts($modulId, 'ta');

                if ($ids->isEmpty()) {
                    if ($counts) {
                        $soals = $this->randomizer->randomize(clone $query, $counts);
                    } else {
                        $target = min(10, (clone $query)->count());
                        $soals = (clone $query)->inRandomOrder()->take($target)->get();
                    }
                } elseif ($counts) {
                    $soals = $this->randomizer->restore(clone $query, $ids, $counts);
                } else {
                    $target = min(10, (clone $query)->count());
                    $byId = (clone $query)->whereIn('id', $ids)->get()->keyBy('id');
                    $soals = $ids->map(fn ($id) => $byId->get($id))->filter()->take($target)->values();
                    $needed = max(0, $target - $soals->count());

                    if ($needed) {
                        $extra = (clone $query)->whereNotIn('id', $soals->pluck('id'))->inRandomOrder()->take($needed)->get();
                        $soals = $soals->merge($extra)->values();
                    }
                }
            }

            $data = $soals->map(fn (SoalTk $soal) => $this->formatPraktikanSoal($soal))->values();
        } else {
            if ($ids->isNotEmpty()) {
                $byId = (clone $query)->whereIn('id', $ids)->get()->keyBy('id');
                $soals = $ids->map(fn ($id) => $byId->get($id))->filter()->values();
            } else {
                $soals = $query->get();
            }

            $data = $soals->map(fn (SoalTk $soal) => $this->formatAssistantSoal($soal))->values();
        }

        return response()->json([
            'message' => 'Soal retrieved successfully.',
            'data' => $data,
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $soal = SoalTk::with('options')->find($id);

        if (! $soal) {
            return response()->json([
                'message' => "Soal dengan ID {$id} tidak ditemukan.",
            ], 404);
        }

        $validated = $this->validateUpdate($request, $soal);

        try {
            $soal = DB::transaction(function () use ($validated, $soal) {
                $soal->update([
                    'modul_id' => $validated['modul_id'],
                    'pertanyaan' => $validated['pertanyaan'],
                    'difficulty' => $validated['difficulty'] ?? $soal->difficulty,
                ]);

                $optionIds = $this->syncOptions($soal, $validated['options']);
                $this->applyOptionReferences($soal, $optionIds, $validated['correct_option']);

                return $soal->load('options');
            });

            return response()->json([
                'status' => 'success',
                'data' => $this->formatAssistantSoal($soal),
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $soal = SoalTk::find($id);
        if (! $soal) {
            return response()->json([
                'message' => "Soal dengan ID {$id} tidak ditemukan.",
            ], 404);
        }

        $soal->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function reset(): JsonResponse
    {
        try {
            DB::transaction(function () {
                SoalOpsi::where('soal_type', SoalOpsi::TYPE_TK)->delete();
                SoalTk::query()->delete();
            });

            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mereset soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function validateStore(Request $request, int $modulId): array
    {
        return $request->validate([
            'pertanyaan' => [
                'required',
                'string',
                'max:10000',
                Rule::unique('soal_tks', 'pertanyaan')
                    ->where(fn ($query) => $query->where('modul_id', $modulId)),
            ],
            'difficulty' => ['nullable', Rule::in(['easy', 'medium', 'hard'])],
            'options' => ['required', 'array', 'size:4'],
            'options.*.text' => ['required', 'string', 'max:10000'],
            'correct_option' => ['required', 'integer', 'between:0,3'],
        ]);
    }

    private function validateUpdate(Request $request, SoalTk $soal): array
    {
        $modulId = (int) $request->input('modul_id', $soal->modul_id);

        return $request->validate([
            'modul_id' => ['required', 'integer', 'exists:moduls,id'],
            'pertanyaan' => [
                'required',
                'string',
                'max:10000',
                Rule::unique('soal_tks', 'pertanyaan')
                    ->where(fn ($query) => $query->where('modul_id', $modulId))
                    ->ignore($soal->id),
            ],
            'difficulty' => ['sometimes', 'nullable', Rule::in(['easy', 'medium', 'hard'])],
            'options' => ['required', 'array', 'size:4'],
            'options.*.id' => ['nullable', 'integer', 'exists:soal_opsis,id'],
            'options.*.text' => ['required', 'string', 'max:10000'],
            'correct_option' => ['required', 'integer', 'between:0,3'],
        ]);
    }

    /**
     * @return array<int, int>
     */
    private function syncOptions(SoalTk $soal, array $options): array
    {
        $existing = $soal->options()->get()->keyBy('id');
        $optionIds = [];

        foreach ($options as $index => $optionData) {
            $optionId = $optionData['id'] ?? null;
            $option = null;

            if ($optionId) {
                $option = $existing->get($optionId);
                if (! $option) {
                    throw ValidationException::withMessages([
                        "options.{$index}.id" => 'Opsi tidak valid untuk soal ini.',
                    ]);
                }
            } else {
                $option = new SoalOpsi([
                    'soal_type' => SoalOpsi::TYPE_TK,
                    'soal_id' => $soal->id,
                ]);
            }

            $option->text = $optionData['text'];
            $option->soal_type = SoalOpsi::TYPE_TK;
            $option->soal_id = $soal->id;
            $option->save();

            $optionIds[$index] = $option->id;
            $existing->forget($option->id);
        }

        foreach ($existing as $option) {
            $option->delete();
        }

        return $optionIds;
    }

    /**
     * @param  array<int, int>  $optionIds
     */
    private function applyOptionReferences(SoalTk $soal, array $optionIds, int $correctIndex): void
    {
        if (! array_key_exists($correctIndex, $optionIds)) {
            throw ValidationException::withMessages([
                'correct_option' => 'Opsi benar tidak valid.',
            ]);
        }

        $soal->update([
            'opsi1_id' => $optionIds[0] ?? null,
            'opsi2_id' => $optionIds[1] ?? null,
            'opsi3_id' => $optionIds[2] ?? null,
            'opsi_benar_id' => $optionIds[$correctIndex],
        ]);
    }

    private function formatAssistantSoal(SoalTk $soal): array
    {
        $orderedIds = array_values(array_filter([
            $soal->opsi1_id,
            $soal->opsi2_id,
            $soal->opsi3_id,
        ]));

        $optionsById = $soal->relationLoaded('options')
            ? $soal->options->keyBy('id')
            : $soal->options()->get()->keyBy('id');

        $orderedOptions = collect($orderedIds)
            ->map(fn (int $id) => $optionsById->get($id))
            ->filter()
            ->values()
            ->map(function (SoalOpsi $opsi) use ($soal) {
                return [
                    'id' => $opsi->id,
                    'text' => $opsi->text,
                    'is_correct' => $opsi->id === $soal->opsi_benar_id,
                ];
            })
            ->values();

        $remainingOptions = $optionsById
            ->reject(fn (SoalOpsi $opsi) => in_array($opsi->id, $orderedIds, true))
            ->map(function (SoalOpsi $opsi) use ($soal) {
                return [
                    'id' => $opsi->id,
                    'text' => $opsi->text,
                    'is_correct' => $opsi->id === $soal->opsi_benar_id,
                ];
            })
            ->values();

        $options = $orderedOptions->merge($remainingOptions)->values();

        return [
            'id' => $soal->id,
            'pertanyaan' => $soal->pertanyaan,
            'difficulty' => $soal->difficulty,
            'modul_id' => $soal->modul_id,
            'opsi_benar_id' => $soal->opsi_benar_id,
            'options' => $options,
        ];
    }

    private function formatPraktikanSoal(SoalTk $soal): array
    {
        $options = $soal->options->map(fn (SoalOpsi $opsi) => [
            'id' => $opsi->id,
            'text' => $opsi->text,
        ])->shuffle()->values();

        return [
            'id' => $soal->id,
            'pertanyaan' => $soal->pertanyaan,
            'difficulty' => $soal->difficulty,
            'modul_id' => $soal->modul_id,
            'options' => $options,
        ];
    }

    private function isTotPraktikan(?Praktikan $praktikan): bool
    {
        if (! $praktikan) {
            return false;
        }

        $praktikan->loadMissing('kelas');
        $kelas = $praktikan->kelas;

        if ($kelas && $kelas->is_tot !== null) {
            return (bool) $kelas->is_tot;
        }

        $kelasName = strtoupper($kelas->kelas ?? '');

        return $kelasName !== '' && str_contains($kelasName, 'TOT');
    }
}
