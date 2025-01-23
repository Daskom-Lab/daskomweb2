<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\JawabanMandiri;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JawabanTMController extends Controller
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
            $validatedData = $request->validate([
                'praktikan_id' => 'required|integer',
                'modul_id' => 'required|integer',
                'jawaban' => 'required|string',
                'soal_id' => 'required|integer',
            ]);
            JawabanMandiri::where('praktikan_id', $validatedData['praktikan_id'])
                ->where('modul_id', $validatedData['modul_id'])
                ->delete();
            $jawaban = JawabanMandiri::create([
                'praktikan_id' => $validatedData['praktikan_id'],
                'modul_id' => $validatedData['modul_id'],
                'soal_id' => $validatedData['soal_id'],
                'jawaban' => $validatedData['jawaban'] ?? '-',
            ]);
            return response()->json([
                "status" => "success",
                "message" => "Jawaban berhasil disimpan",
                "data" => $jawaban
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Validasi gagal",
                "errors" => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat menyimpan jawaban",
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
            $jawaban = JawabanMandiri::where('praktikan_id', auth('sanctum')->user()->id)
                ->where('modul_id', $idModul)
                ->get();
            if ($jawaban->isEmpty()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Jawaban tidak ditemukan untuk modul ini."
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "jawaban_mandiri" => $jawaban
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat mengambil jawaban.",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function showAsisten($idPraktikan, $idModul)
    {
        try {
            $jawaban = JawabanMandiri::where('praktikan_id', $idPraktikan)
                ->where('modul_id', $idModul)
                ->get();
            if ($jawaban->isEmpty()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Jawaban tidak ditemukan untuk praktikan dan modul ini."
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "jawaban_mandiri" => $jawaban
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat mengambil jawaban.",
                "error" => $e->getMessage()
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
