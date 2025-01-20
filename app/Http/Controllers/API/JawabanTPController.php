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

        $jawaban = JawabanTp::where('praktikan_id', $request->input('0.praktikan_id'))
        ->where('modul_id', $request->input('0.modul_id'))
        ->where('soal_id', $request->input('0.soal_id'))
        ->delete();

        $request->validate([
            'jawaban' => 'required|string',
            'soal_id' => 'required',
            'praktikan_id' => 'required',
            'modul_id' => 'required',
        ]);

        $data = $request->all();
        for ($i = 0; $i < count($data); $i++) { {
                JawabanTp::create([
                    'jawaban' => $request->$data[$i]['jawaban'] ?? '-',
                    'soal_id' => $request->$data[$i]['soal_id'],
                    'praktikan_id' => $request->$data[$i]['praktikan_id'] ?? Auth::guard('praktikan')->user()->id,
                    'modul_id' => $request->$data[$i]['modul_id'],
                    'crated_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                "status" => "success",
                'messages' => "Berhasil menambahkan jawaban"
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        $jawaban = JawabanTp::where('praktikan_id', Auth::guard('praktikan')->user()->id)
        ->where('modul_id', $idModul)->get();
        if ($jawaban->isEmpty()) {
            return response()->json([
                "status" => "success",
                'messages' => "Tidak ada jawaban"
            ]);
        } else {
            return response()->json([
                "status" => "success",
                "jawaban_tp" => $jawaban
            ]);
        }
    }

    public function showAsisten($idPraktikan, $idModul)
    {
        $jawaban = JawabanTp::where('praktikan_id', $idPraktikan)->where('modul_id', $idModul)->get();
        if ($jawaban->isEmpty()) {
            return response()->json([
                "status" => "success",
                'messages' => "Tidak ada jawaban"
            ]);
        } else {
            return response()->json([
                "status" => "success",
                "jawaban_tp" => $jawaban
            ]);
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
