<?php

namespace App\Http\Controllers\API;

use App\Models\Modul;
use Illuminate\Http\Request;
use App\Models\JawabanJurnal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JawabanJurnalController extends Controller
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
            $request->validate([
                '0.praktikan_id' => 'required|integer',
                '0.modul_id' => 'required|integer',
                '*.soal_id' => 'required|integer',
                '*.jawaban' => 'nullable|string',
            ]);
            JawabanJurnal::where('praktikan_id', $request->input('0.praktikan_id'))
                ->where('modul_id', $request->input('0.modul_id'))
                ->delete();
            foreach ($request->all() as $index => $data) {
                JawabanJurnal::create([
                    'praktikan_id' => $data['praktikan_id'],
                    'modul_id' => $data['modul_id'],
                    'soal_id' => $data['soal_id'],
                    'jawaban' => empty($data['jawaban']) ? '-' : $data['jawaban'],
                ]);
            }
            return response()->json([
                "status" => "success",
                "message" => "Jawaban jurnal berhasil disimpan."
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Validasi gagal.",
                "errors" => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat menyimpan jawaban jurnal.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        try{
            $modul = Modul::findOrFail($idModul);
            if($modul->isUnlocked){
                $jawaban = JawabanJurnal::where('praktikan_id', auth('sanctum')->user()->id)->where('modul_id', $idModul)->get();
                return response()->json([
                    "status" => "success",
                    'message' => "Jawaban Jurnal Berhasil diambil",
                    "jawaban_jurnal" => $jawaban,
                ],200);
            }
            return response()->json([
                "status" => "success",
                'messages' => "Jawaban Masih Terkunci"
            ],403);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response() -> json([
                "status" => "error",
                "message" => "Modul Tidak ditemukan Hub ATC",
                "error" => $e->getMessage(),
            ],404);
        }catch(\Exception $e) {
            return response() -> json([
                "status" => "error",
                "message" => "Terjadi Kesalahan saat mengambil data",
                "error" => $e->getMessage(),
            ],500);
        }
    }

    public function showAsisten($idPraktikan, $idModul)
    {
        try{
            $jawaban = JawabanJurnal::where('praktikan_id', $idPraktikan)->where('modul_id', $idModul)->get();
            return response()->json([
                "status" => "success",
                "jawaban_jurnal" => $jawaban
            ],200);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response() -> json([
                "error" => "error",
                "message" => "jawaban tidak ditemukan ",
                "error" => $e->getMessage(),
            ],404);
        }catch(\Exception $e) {
            return response()-> json([
                "status" => "error",
                "message" => "terjadi kesalahan saat mengambil data",
                "error" => $e->getMessage(),
            ],500);
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
