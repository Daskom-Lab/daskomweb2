<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Models\SoalTk;
use App\Models\Modul;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SoalTKController extends Controller
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
                "modul_id" => "required|integer|exists:moduls,id",
                "pengantar" => "nullable|string|max:255",
                "kodingan" => "nullable|string|max:1000",
                "pertanyaan" => "required|string|max:500",
                "jawaban_benar" => "required|string|max:255",
                "jawaban_salah1" => "required|string|max:255",
                "jawaban_salah2" => "required|string|max:255",
                "jawaban_salah3" => "required|string|max:255",
            ]);
            // Cek jika modul dengan ID tersebut ada
            $modul = Modul::find($id);
            if (!$modul) {
                return response()->json([
                    "message" => "Modul dengan ID $id tidak ditemukan.",
                ], 404);
            }
            // Cek duplikasi pertanyaan
            $existingSoal = SoalTk::where('modul_id', $id)
                ->where('pertanyaan', $request->pertanyaan)
                ->first();
            if ($existingSoal) {
                return response()->json([
                    "message" => "Soal dengan pertanyaan yang sama sudah terdaftar.",
                ], 400);
            }
            // Menyimpan data soal
            $soal = SoalTk::create([
                "modul_id" => $id,
                "pengantar" => $request->pengantar ?? "empty",
                "kodingan" => $request->kodingan ?? "empty",
                "pertanyaan" => $request->pertanyaan,
                "jawaban_benar" => $request->jawaban_benar,
                "jawaban_salah1" => $request->jawaban_salah1,
                "jawaban_salah2" => $request->jawaban_salah2,
                "jawaban_salah3" => $request->jawaban_salah3,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
            return response()->json([
                "status" => "success",
                "data" => $soal,
            ], 200);
        } catch (\Exception $e) {
            // Menangani kesalahan yang terjadi pada proses penyimpanan
            return response()->json([
                "message" => "Terjadi kesalahan saat menyimpan soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    
    public function show($modul_id, $kelas_id)
    {
        try {
            // Validasi kelas
            $kelas = Kelas::find($kelas_id);
            if (!$kelas) {
                return response()->json([
                    "message" => "Kelas dengan ID $kelas_id tidak ditemukan.",
                ], 404);
            }
            // Validasi modul
            $modul = Modul::find($modul_id);
            if (!$modul) {
                return response()->json([
                    "message" => "Modul dengan ID $modul_id tidak ditemukan.",
                ], 404);
            }
            // Mengambil soal sesuai kelas
            if (substr($kelas->kelas, 0, 3) === 'TOT') {
                $all_soal = SoalTk::where('modul_id', $modul_id)->get();
            } else {
                $all_soal = SoalTk::where('modul_id', $modul_id)->inRandomOrder()->take(10)->get();
            }
            // Jika tidak ada soal yang ditemukan
            if ($all_soal->isEmpty()) {
                return response()->json([
                    "message" => "Tidak ada soal untuk modul ID $modul_id.",
                ], 404);
            }
            // Format soal
            $soal_tk = $all_soal->map(function ($soal) {
                return [
                    'id' => $soal->id,
                    'pengantar' => $soal->pengantar,
                    'kodingan' => $soal->kodingan,
                    'pertanyaan' => $soal->pertanyaan,
                    'modul_id' => $soal->modul_id,
                    'pilihan1' => $soal->jawaban_benar,
                    'pilihan2' => $soal->jawaban_salah1,
                    'pilihan3' => $soal->jawaban_salah2,
                    'pilihan4' => $soal->jawaban_salah3,
                ];
            });
            return response()->json([
                "message" => "Soal retrieved successfully.",
                "soalTK" => $soal_tk,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat mengambil soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                "modul_id" => "required|integer|exists:moduls,id",
                "pengantar" => "nullable|string|max:255",
                "kodingan" => "nullable|string|max:1000",
                "pertanyaan" => "required|string|max:500",
                "jawaban_benar" => "required|string|max:255",
                "jawaban_salah1" => "required|string|max:255",
                "jawaban_salah2" => "required|string|max:255",
                "jawaban_salah3" => "required|string|max:255",
            ]);
            // Cek apakah soal ada
            $soal = SoalTk::find($id);
            if (!$soal) {
                return response()->json([
                    "message" => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            // Cek jika pertanyaan sudah ada
            $existingSoal = SoalTk::where('modul_id', $soal->modul_id)
                ->where('pertanyaan', $request->pertanyaan)
                ->first();
            if ($existingSoal && $existingSoal->id !== $soal->id) {
                return response()->json([
                    "message" => "Soal dengan pertanyaan yang sama sudah terdaftar.",
                ], 400);
            }
            // Update soal
            $soal->modul_id = $request->modul_id;
            $soal->pengantar = $request->pengantar ?? $soal->pengantar;
            $soal->kodingan = $request->kodingan ?? $soal->kodingan;
            $soal->pertanyaan = $request->pertanyaan;
            $soal->jawaban_benar = $request->jawaban_benar;
            $soal->jawaban_salah1 = $request->jawaban_salah1;
            $soal->jawaban_salah2 = $request->jawaban_salah2;
            $soal->jawaban_salah3 = $request->jawaban_salah3;
            $soal->save();
            return response()->json([
                "status" => "success",
                "data" => $soal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat memperbarui soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Cek apakah soal ada
            $soal = SoalTk::find($id);
            if (!$soal) {
                return response()->json([
                    "message" => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            // Hapus soal
            $soal->delete();
            return response()->json([
                "status" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat menghapus soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    
    public function reset()
    {
        try {
            SoalTk::truncate();
            return response()->json([
                "status" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat mereset soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    
}
