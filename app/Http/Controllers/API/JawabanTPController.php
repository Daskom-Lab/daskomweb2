<?php

namespace App\Http\Controllers\API;

use App\Models\JawabanTp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JawabanTPController extends Controller
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
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'jawaban' => 'required|string',
                'soal_id' => 'required',
                'praktikan_id' => 'required',
                'modul_id' => 'required',
            ]);
            JawabanTp::where('praktikan_id', $validateData['praktikan_id'])
                ->where('modul_id', $validateData['modul_id'])
                ->where('soal_id', $validateData['soal_id'])
                ->delete();
            JawabanTp::create([
                'jawaban' => $validateData['jawaban'],
                'soal_id' => $validateData['soal_id'],
                'praktikan_id' => $validateData['praktikan_id'],
                'modul_id' => $validateData['modul_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Jawaban berhasil disimpan.",
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat menyimpan jawaban.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        try {
            $jawaban = JawabanTp::where('praktikan_id', auth('sanctum')->user()->id)
                ->where('modul_id', $idModul)
                ->get();
            if ($jawaban->isEmpty()) {
                return response()->json([
                    "status" => "success",
                    "message" => "Tidak ada jawaban",
                ]);
            }
            return response()->json([
                "status" => "success",
                "jawaban_tp" => $jawaban,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat mengambil data jawaban.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    public function showAsisten($idPraktikan, $idModul)
    {
        try {
            $jawaban = JawabanTp::where('praktikan_id', $idPraktikan)
                ->where('modul_id', $idModul)
                ->get();
            if ($jawaban->isEmpty()) {
                return response()->json([
                    "status" => "success",
                    "message" => "Tidak ada jawaban",
                ]);
            }
            return response()->json([
                "status" => "success",
                "jawaban_tp" => $jawaban,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat mengambil data jawaban.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
