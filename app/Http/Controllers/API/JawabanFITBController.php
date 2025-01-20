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
        JawabanFitb::where('praktikan_id', $request->input('0.praktikan_id'))
        ->where('modul_id', $request->input('0.modul_id'))
        ->delete();
        for ($i = 0; $i < count($request->all()); $i++) {

            JawabanFitb::create([
                'praktikan_id'  => $request->input($i . '.praktikan_id'),
                'modul_id'      => $request->input($i . '.modul_id'),
                'soal_id'       => $request->input($i . '.soal_id'),
                'jawaban'       => $request->input($i . '.jawaban') == '' ? '-' : $request->input($i . '.jawaban'),
            ]);
        }

        return response()->json([
            "status" => "success"
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        $modul = Modul::findOrFail($idModul);
        if($modul->isUnlocked){
            $jawaban = JawabanFitb::where('praktikan_id', auth('sanctum')->user()->id)
            ->where('modul_id', $idModul)->get();
            return response()->json([
                "status" => "success",
                "jawaban_fitb" => $jawaban
            ]);
        }
        return response()->json([
            "status" => "success",
            'messages' => "Jawaban Masih Terkunci"
        ]);
    }

    public function showAsisten($idPraktikan, $idModul){
        $jawaban = JawabanFitb::where('praktikan_id', $idPraktikan)->where('modul_id', $idModul)->get();
        return response()->json([
            "status" => "success",
            "jawaban_fitb" => $jawaban
        ]);
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
