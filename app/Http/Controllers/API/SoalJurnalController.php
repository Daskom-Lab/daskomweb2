<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SoalJurnal;
use Illuminate\Http\Request;

class SoalJurnalController extends Controller
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
            $validated = $request->validate([
                'soal' => 'required|string|max:10000',
                'enable_file_upload' => 'sometimes|boolean',
            ]);
            // Cek duplikasi soal
            $existingSoal = SoalJurnal::where('modul_id', $id)
                ->where('soal', $request->soal)
                ->first();
            if ($existingSoal) {
                return response()->json([
                    'message' => 'Soal dengan soal yang sama sudah terdaftar.',
                ], 400);
            }
            $soal = SoalJurnal::create([
                'modul_id' => $id,
                'soal' => $validated['soal'],
                'enable_file_upload' => $request->boolean('enable_file_upload'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Soal berhasil ditambahkan',
                'data' => $soal,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $all_jurnal = SoalJurnal::where('modul_id', $id)->get();
            if ($all_jurnal->isEmpty()) {
                return response()->json([
                    'message' => "Soal dengan modul ID $id tidak ditemukan, atau mungkin belum ada inputan sama sekali :(",
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'modul_id' => 'required|integer|exists:moduls,id',
                'soal' => 'required|string|max:10000',
                'enable_file_upload' => 'sometimes|boolean',
            ]);
            $soal = SoalJurnal::find($id);
            if (! $soal) {
                return response()->json([
                    'message' => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            // Cek duplikasi soal baru
            $duplicateSoal = SoalJurnal::where('modul_id', $request->modul_id)
                ->where('soal', $request->soal)
                ->where('id', '!=', $id)
                ->first();
            if ($duplicateSoal) {
                return response()->json([
                    'message' => 'Soal sudah terdaftar.',
                ], 400);
            }
            $soal->update([
                'modul_id' => $validated['modul_id'],
                'soal' => $validated['soal'],
                'enable_file_upload' => array_key_exists('enable_file_upload', $validated)
                    ? $request->boolean('enable_file_upload')
                    : ($soal->enable_file_upload ?? false),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Soal berhasil diupdate.',
                'data' => $soal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $soal = SoalJurnal::find($id);
            if (! $soal) {
                return response()->json([
                    'message' => "Soal dengan ID $id tidak ditemukan.",
                ], 404);
            }
            $soal->delete();

            return response()->json([
                'message' => 'Soal berhasil dihapus.',
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
            SoalJurnal::truncate();

            return response()->json([
                'message' => 'Semua soal berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus semua soal.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
