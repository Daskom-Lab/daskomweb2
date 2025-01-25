<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Models\SoalTa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SoalTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                "modul_id" => "required|integer",
                "pengantar" => "nullable|string",
                "kodingan" => "nullable|string",
                "pertanyaan" => "required|string",
                "jawaban_benar" => "required|string",
                "jawaban_salah1" => "required|string",
                "jawaban_salah2" => "required|string",
                "jawaban_salah3" => "required|string",
            ]);
            // Cek duplikasi soal
            $existingSoal = SoalTa::where('modul_id', $id)
                ->where('pertanyaan', $request->pertanyaan)
                ->first();
            if ($existingSoal) {
                return response()->json([
                    "message" => "Soal dengan pertanyaan yang sama sudah terdaftar.",
                ], 400);
            }
            $soal = SoalTa::create([
                "modul_id" => $id,
                "pengantar" => $request->pengantar ?? "empty",
                "kodingan" => $request->kodingan ?? "empty",
                "pertanyaan" => $request->pertanyaan,
                "jawaban_benar" => $request->jawaban_benar,
                "jawaban_salah1" => $request->jawaban_salah1,
                "jawaban_salah2" => $request->jawaban_salah2,
                "jawaban_salah3" => $request->jawaban_salah3,
            ]);
            return response()->json([
                "status" => "success",
                "data" => $soal,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat menyimpan soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($modul_id, $kelas_id)
    {
        try {
            $kelas = Kelas::find($kelas_id);
            if (!$kelas) {
                return response()->json([
                    "message" => "Kelas dengan ID $kelas_id tidak ditemukan.",
                ], 404);
            }
            if (substr($kelas->kelas, 0, 3) === 'TOT') {
                $all_soal = SoalTa::where('modul_id', $modul_id)->get();
            } else {
                $all_soal = SoalTa::where('modul_id', $modul_id)->inRandomOrder()->take(10)->get();
                $all_soal = $all_soal->map(function ($soal) {
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
            }
            if ($all_soal->isEmpty()) {
                return response()->json([
                    "message" => "Tidak ada soal untuk modul ID $modul_id.",
                ], 404);
            }
            return response()->json([
                "message" => "Soal retrieved successfully.",
                "soalTA" => $all_soal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat mengambil soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                "modul_id" => "required|integer",
                "pengantar" => "required|string",
                "kodingan" => "required|string",
                "pertanyaan" => "required|string",
                "jawaban_benar" => "required|string",
                "jawaban_salah1" => "required|string",
                "jawaban_salah2" => "required|string",
                "jawaban_salah3" => "required|string",
            ]);
            $soal = SoalTa::find($id);
            if (!$soal) {
                return response()->json([
                    "message" => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            // Cek duplikasi soal
            $duplicateSoal = SoalTa::where('modul_id', $request->modul_id)
                ->where('pertanyaan', $request->pertanyaan)
                ->where('id', '!=', $id)
                ->first();
            if ($duplicateSoal) {
                return response()->json([
                    "message" => "Soal dengan pertanyaan yang sama sudah terdaftar.",
                ], 400);
            }
            $soal->update($request->all());
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
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $soal = SoalTa::find($id);
            if (!$soal) {
                return response()->json([
                    "message" => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
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
            SoalTa::truncate();
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
