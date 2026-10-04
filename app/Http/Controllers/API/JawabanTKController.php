<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JawabanTk;
use App\Models\Modul;
use App\Models\Praktikan;
use App\Models\SoalOpsi;
use App\Models\SoalTk;
use App\Services\Praktikum\DifficultyQuestionRandomizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JawabanTKController extends Controller
{
    public function index(): void {}

    public function __construct(private DifficultyQuestionRandomizer $randomizer) {}

    public function showAsisten(int $praktikanId, int $modulId): JsonResponse
    {
        try {
            $cache = Cache::store((string) config('cache.snapshot_store', 'redis'));

            $snapshotKey = "autosave_snapshot:{$praktikanId}:{$modulId}:tk_questions";
            $snapshot = $cache->get($snapshotKey);
            $questionIds = collect($snapshot['question_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->filter(fn ($id) => $id > 0)
                ->unique()
                ->values();

            $jawaban = JawabanTk::with('soal_tk')
                ->where('praktikan_id', $praktikanId)
                ->where('modul_id', $modulId)
                ->get()
                ->keyBy('soal_id');

            if ($questionIds->isEmpty()) {
                $questionIds = $jawaban
                    ->keys()
                    ->map(fn ($id) => (int) $id)
                    ->values();
            }

            $soals = SoalTk::with('options')
                ->where('modul_id', $modulId)
                ->whereIn('id', $questionIds)
                ->get()
                ->keyBy('id');

            $data = $questionIds
                ->map(function (int $questionId) use ($soals, $jawaban) {
                    $soal = $soals->get($questionId);

                    if (! $soal) {
                        return null;
                    }

                    $item = $jawaban->get($questionId);

                    $options = $soal->options
                        ->map(fn (SoalOpsi $opsi) => [
                            'id' => $opsi->id,
                            'text' => $opsi->text,
                            'is_correct' => $opsi->id === $soal->opsi_benar_id,
                        ])
                        ->values()
                        ->all();

                    return [
                        'soal_id' => $soal->id,
                        'pertanyaan' => $soal->pertanyaan,
                        'selected_opsi_id' => $item?->opsi_id,
                        'opsi_benar_id' => $soal->opsi_benar_id,
                        'options' => $options,
                    ];
                })
                ->filter()
                ->values();

            $praktikan = Praktikan::find($praktikanId);
            $totalQuestions = $this->randomizer->scoreTotal($praktikan, $modulId, 'tk', SoalTk::class);
            $correctAnswers = $jawaban
                ->filter(fn (JawabanTk $item) => $item->soal_tk && $item->opsi_id === $item->soal_tk->opsi_benar_id)
                ->count();

            return response()->json([
                'success' => true,
                'jawaban_tk' => $data,
                'total_questions' => $totalQuestions,
                'correct_answers' => $correctAnswers,
                'score' => $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data jawaban.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'praktikan_id' => ['required', 'integer'],
            'modul_id' => ['required', 'integer'],
            'answers' => ['present', 'array'],
            'answers.*.soal_id' => ['required', 'integer', 'exists:soal_tks,id', 'distinct'],
            'answers.*.opsi_id' => ['required', 'integer', 'exists:soal_opsis,id'],
        ]);

        $praktikanId = (int) $validated['praktikan_id'];
        $modulId = (int) $validated['modul_id'];

        try {
            DB::transaction(function () use ($validated, $praktikanId, $modulId) {
                JawabanTk::where('praktikan_id', $praktikanId)
                    ->where('modul_id', $modulId)
                    ->delete();

                foreach ($validated['answers'] as $index => $answer) {
                    $soal = SoalTk::with('options')->find($answer['soal_id']);

                    if (! $soal || $soal->modul_id !== $modulId) {
                        throw ValidationException::withMessages([
                            "answers.{$index}.soal_id" => 'Soal tidak valid untuk modul ini.',
                        ]);
                    }

                    $option = $soal->options->firstWhere('id', $answer['opsi_id']);
                    if (! $option || $option->soal_type !== SoalOpsi::TYPE_TK) {
                        throw ValidationException::withMessages([
                            "answers.{$index}.opsi_id" => 'Opsi tidak valid untuk soal ini.',
                        ]);
                    }

                    JawabanTk::create([
                        'praktikan_id' => $praktikanId,
                        'modul_id' => $modulId,
                        'soal_id' => $soal->id,
                        'opsi_id' => $option->id,
                    ]);
                }
            });

            $jawaban = JawabanTk::with('soal_tk')
                ->where('praktikan_id', $praktikanId)
                ->where('modul_id', $modulId)
                ->get();

            $correct = $jawaban->filter(fn (JawabanTk $item) => $item->opsi_id === $item->soal_tk?->opsi_benar_id)->count();
            $totalQuestions = $this->randomizer->scoreTotal(
                auth('praktikan')->user(),
                $modulId,
                'tk',
                SoalTk::class
            );
            $nilai = $totalQuestions > 0 ? round(($correct / $totalQuestions) * 100, 2) : 0;

            return response()->json([
                'status' => 'success',
                'nilai_tk' => $nilai,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data jawaban TK.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function score(int $praktikanId, int $modulId): JsonResponse
    {
        $praktikan = auth('praktikan')->user();

        if (! $praktikan || $praktikan->id !== $praktikanId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak diizinkan mengakses nilai modul ini.',
            ], 403);
        }

        try {
            $totalQuestions = $this->randomizer->scoreTotal(
                auth('praktikan')->user(),
                $modulId,
                'tk',
                SoalTk::class
            );

            if ($totalQuestions === 0) {
                return response()->json([
                    'status' => 'success',
                    'score' => 0,
                    'correct_answers' => 0,
                    'total_questions' => 0,
                ]);
            }

            $jawaban = JawabanTk::with('soal_tk')
                ->where('praktikan_id', $praktikanId)
                ->where('modul_id', $modulId)
                ->get();

            $correctAnswers = $jawaban
                ->filter(fn (JawabanTk $item) => $item->soal_tk && $item->opsi_id === $item->soal_tk->opsi_benar_id)
                ->count();

            $score = $correctAnswers > 0
                ? round(($correctAnswers / $totalQuestions) * 100, 2)
                : 0;

            return response()->json([
                'status' => 'success',
                'score' => $score,
                'correct_answers' => $correctAnswers,
                'total_questions' => $totalQuestions,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menghitung nilai TK.',
            ], 500);
        }
    }

    public function analysis(int $modulId): JsonResponse
    {
        try {
            $questions = SoalTk::with('options')
                ->where('modul_id', $modulId)
                ->get();

            if ($questions->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'summary' => [
                        'total_questions' => 0,
                        'total_responses' => 0,
                        'respondent_count' => 0,
                    ],
                    'questions' => [],
                ]);
            }

            $optionCounts = JawabanTk::select('soal_id', 'opsi_id', DB::raw('COUNT(*) as total'))
                ->where('modul_id', $modulId)
                ->groupBy('soal_id', 'opsi_id')
                ->get()
                ->groupBy('soal_id');

            $respondentCount = JawabanTk::where('modul_id', $modulId)
                ->distinct('praktikan_id')
                ->count('praktikan_id');

            $questionsPayload = $questions->map(function (SoalTk $soal) use ($optionCounts) {
                $optionStats = $optionCounts->get($soal->id, collect());
                $totalResponses = (int) $optionStats->sum('total');

                $options = $soal->options
                    ->map(function (SoalOpsi $option) use ($optionStats, $totalResponses, $soal) {
                        $count = (int) ($optionStats->firstWhere('opsi_id', $option->id)?->total ?? 0);
                        $percentage = $totalResponses > 0
                            ? round(($count / $totalResponses) * 100, 2)
                            : 0;

                        return [
                            'id' => $option->id,
                            'text' => $option->text,
                            'count' => $count,
                            'percentage' => $percentage,
                            'is_correct' => $option->id === $soal->opsi_benar_id,
                        ];
                    })
                    ->values();

                return [
                    'soal_id' => $soal->id,
                    'pertanyaan' => $soal->pertanyaan,
                    'total_responses' => $totalResponses,
                    'options' => $options,
                ];
            });

            $totalResponses = $questionsPayload->sum('total_responses');

            return response()->json([
                'success' => true,
                'summary' => [
                    'total_questions' => $questions->count(),
                    'total_responses' => $totalResponses,
                    'respondent_count' => $respondentCount,
                ],
                'questions' => $questionsPayload,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghitung analisis jawaban TK.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $modulId): JsonResponse
    {
        try {
            $modul = Modul::findOrFail($modulId);

            if (! $modul->isQuestionTypeUnlocked('tk')) {
                return response()->json([
                    'status' => 'locked',
                    'message' => 'Jawaban masih terkunci.',
                ], 403);
            }

            $praktikan = auth('praktikan')->user();

            if (! $praktikan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized.',
                ], 401);
            }

            $jawaban = JawabanTk::with(['soal_tk.options'])
                ->where('praktikan_id', $praktikan->id)
                ->where('modul_id', $modulId)
                ->get();

            if ($jawaban->isEmpty()) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Tidak ada jawaban untuk modul ini.',
                ], 404);
            }

            $data = $jawaban->map(function (JawabanTk $item) {
                $soal = $item->soal_tk;
                $options = $soal?->options->map(fn (SoalOpsi $opsi) => [
                    'id' => $opsi->id,
                    'text' => $opsi->text,
                    'is_correct' => $opsi->id === $soal->opsi_benar_id,
                ]);

                return [
                    'soal_id' => $item->soal_id,
                    'pertanyaan' => $soal?->pertanyaan,
                    'selected_opsi_id' => $item->opsi_id,
                    'opsi_benar_id' => $soal?->opsi_benar_id,
                    'options' => $options,
                ];
            });

            return response()->json([
                'status' => 'success',
                'jawaban_tk' => $data,
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data jawaban.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
