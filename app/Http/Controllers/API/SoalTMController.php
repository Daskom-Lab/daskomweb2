<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Praktikan;
use App\Models\SoalMandiri;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SoalTMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'soal' => 'required|string|max:10000',
            ]);
            // Menyimpan soal baru
            $soal = SoalMandiri::create([
                'modul_id' => $id,
                'soal' => $request->soal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Soal berhasil ditambahkan',
                'data' => $soal,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan soal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, int $id)
    {
        try {
            $user = auth('praktikan')->user();
            $query = SoalMandiri::where('modul_id', $id);

            $questionIds = collect(Arr::wrap($request->query('question_ids')))
                ->flatMap(fn ($value) => is_array($value) ? $value : explode(',', (string) $value))
                ->map(fn ($value) => (int) $value)
                ->filter(fn ($value) => $value > 0)
                ->values();

            if ($user) {
                if ($questionIds->isNotEmpty()) {
                    $soals = (clone $query)
                        ->whereIn('id', $questionIds)
                        ->get()
                        ->keyBy('id');

                    $ordered = $questionIds
                        ->map(fn ($value) => $soals->get($value))
                        ->filter();

                    $missingCount = max(0, $questionIds->count() - $ordered->count());

                    if ($missingCount > 0) {
                        $fallback = (clone $query)
                            ->whereNotIn('id', $questionIds)
                            ->inRandomOrder()
                            ->take($missingCount)
                            ->get();

                        $ordered = $ordered->merge($fallback);
                    }

                    $all_jurnal = $ordered;
                } else {
                    $limit = $this->isTotPraktikan($user) ? 3 : 1;
                    $all_jurnal = (clone $query)->inRandomOrder()->take($limit)->get();
                }
            } else {
                $all_jurnal = $questionIds->isNotEmpty()
                    ? (clone $query)->whereIn('id', $questionIds)->get()
                    : $query->get();
            }
            // Cek apakah soal ditemukan
            if ($all_jurnal->isEmpty()) {
                return response()->json([
                    'message' => "Tidak ada soal ditemukan untuk modul ID $id.",
                ], 404);
            }

            return response()->json([
                'message' => 'Soal Jurnal retrieved successfully.',
                'data' => $all_jurnal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            // Validasi input
            $request->validate([
                'modul_id' => 'required|integer|exists:moduls,id',
                'soal' => 'required|string|max:10000',
            ]);
            $soal = SoalMandiri::find($id);
            if (! $soal) {
                return response()->json([
                    'message' => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            if ($request->soal != $request->oldSoal) {
                $existingSoal = SoalMandiri::where('soal', $request->soal)->first();
                if ($existingSoal) {
                    return response()->json([
                        'message' => 'Soal dengan pertanyaan tersebut sudah terdaftar.',
                    ], 400);
                }
            }
            // Update soal
            $soal->update([
                'modul_id' => $request->modul_id,
                'soal' => $request->soal,
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Soal berhasil diupdate',
                'data' => $soal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $soal = SoalMandiri::find($id);
            if (! $soal) {
                return response()->json([
                    'message' => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            $soal->delete();

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function reset()
    {
        try {
            SoalMandiri::truncate();

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mereset soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
