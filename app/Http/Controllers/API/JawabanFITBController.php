<?php

namespace App\Http\Controllers\API;

use App\Models\Modul;
use App\Models\JawabanFitb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JawabanFITBController extends Controller
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
            JawabanFitb::where('praktikan_id', $request->input('0.praktikan_id'))
                ->where('modul_id', $request->input('0.modul_id'))
                ->delete();
            for ($i = 0; $i < count($request->all()); $i++) {
                JawabanFitb::create([
                    'praktikan_id' => $request->input($i . '.praktikan_id'),
                    'modul_id' => $request->input($i . '.modul_id'),
                    'soal_id' => $request->input($i . '.soal_id'),
                    'jawaban' => $request->input($i . '.jawaban') == '' ? '-' : $request->input($i . '.jawaban'),
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        try {
            $modul = Modul::findOrFail($idModul);
            if ($modul->isUnlocked) {
                $jawaban = JawabanFitb::where('praktikan_id', auth('sanctum')->user()->id)
                    ->where('modul_id', $idModul)
                    ->get();
                return response()->json([
                    "status" => "success",
                    "jawaban_fitb" => $jawaban,
                    "message" => "Jawaban berhasil diambil."
                ], 200);
            }
            return response()->json([
                "status" => "success",
                "message" => "Jawaban masih terkunci."
            ], 403);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Modul tidak ditemukan.",
                "error" => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat mengambil data.",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    

    public function showAsisten($idPraktikan, $idModul){
        try{
            $jawaban = JawabanFitb::where('praktikan_id', $idPraktikan)->where('modul_id', $idModul)->get();
            return response()->json([
                "status" => "success",
                "jawaban_fitb" => $jawaban
            ]);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response() -> json([
                'status' => 'notSucces' ,
                'message' => 'Jawaban FITB tidak ditemukan hubungi FYN/JIN',
                'error' => $e->getMessage(),
            ],404);
        }catch(\Exception $e){
            return response() -> json([
                'status' => 'Failed',
                'message' => 'Gagal menumukan jawaban',
                "error" => $e->getMessage(),
            ],505);
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
