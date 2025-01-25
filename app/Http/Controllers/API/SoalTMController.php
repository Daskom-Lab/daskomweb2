<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SoalMandiri;
use Illuminate\Http\Request;

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
                "modul_id" => "required|integer|exists:moduls,id",
                "pengantar" => "required|string|max:255",
                "soal" => "required|string|max:1000",
            ]);
            // Menyimpan soal baru
            $soal = SoalMandiri::create([
                "modul_id" => $id,
                "pengantar" => $request->pengantar,
                "kodingan" => $request->kodingan ?? "empty",
                "soal" => $request->soal,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
            return response()->json([
                "message" => "Soal berhasil ditambahkan",
                "data" => $soal,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat menambahkan soal",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            // Mengambil semua soal berdasarkan modul_id
            $all_jurnal = SoalMandiri::where("modul_id", $id)->get();
            // Cek apakah soal ditemukan
            if ($all_jurnal->isEmpty()) {
                return response()->json([
                    "message" => "Tidak ada soal ditemukan untuk modul ID $id.",
                ], 404);
            }
            return response()->json([
                "message" => "Soal Jurnal retrieved successfully.",
                "soalJurnal" => $all_jurnal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat mengambil soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            // Validasi input
            $request->validate([
                "modul_id" => "required|integer|exists:moduls,id",
                "pengantar" => "required|string|max:255",
                "soal" => "required|string|max:1000",
            ]);
            $soal = SoalMandiri::find($id);
            if (!$soal) {
                return response()->json([
                    "message" => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            if ($request->soal != $request->oldSoal) {
                $existingSoal = SoalMandiri::where('soal', $request->soal)->first();
                if ($existingSoal) {
                    return response()->json([
                        "message" => "Soal dengan pertanyaan tersebut sudah terdaftar.",
                    ], 400);
                }
            }
            // Update soal
            $soal->modul_id = $request->modul_id;
            $soal->pengantar = $request->pengantar;
            $soal->soal = $request->soal;
            $soal->updated_at = now();
            $soal->save();
            return response()->json([
                "message" => "Soal berhasil diupdate",
                "data" => $soal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat memperbarui soal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $soal = SoalMandiri::find($id);
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
            SoalMandiri::truncate();
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
