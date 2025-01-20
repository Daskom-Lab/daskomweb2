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
        JawabanMandiri::where('praktikan_id', $request->praktikan_id)
        ->where('modul_id', $request->modul_id)
        ->delete();
        $request->validate([
            'jawaban' => 'required',
            'soal_id' => 'required',
        ]);

        $jawaban = JawabanMandiri::create([
            'jawaban' => $request->jawaban??'-',
            'soal_id' => $request->soal_id,
            'praktikan_id' => $request->praktikan_id,
            'modul_id' => $request->modul_id
        ]);

        return response()->json([
            "status" => "success"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {   
        $jawaban = JawabanMandiri::where('praktikan_id', auth('sanctum')->user()->id)->where('modul_id', $idModul)->get();
        return response()->json([
            "status" => "success",
            "jawaban_mandiri" => $jawaban
        ]);
    }


    public function showAsisten($idPraktikan,$idModul)
    {
        $jawaban = JawabanMandiri::where('praktikan_id', $idPraktikan)->where('modul_id', $idModul)->get();
        return response()->json([
            "status" => "success",
            "jawaban_mandiri" => $jawaban
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
