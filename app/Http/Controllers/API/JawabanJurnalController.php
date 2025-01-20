<?php

namespace App\Http\Controllers\API;

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
        JawabanJurnal::where('praktikan_id', $request->input('0.praktikan_id'))
        ->where('modul_id', $request->input('0.modul_id'))
        ->delete();
        for ($i = 0; $i < count($request->all()); $i++) {

            JawabanJurnal::create([
                'praktikan_id'  => $request->input($i . '.praktikan_id'),
                'modul_id'      => $request->input($i . '.modul_id'),
                'soal_id'       => $request->input($i . '.soal_id'),
                'jawaban'       => $request->input($i . '.jawaban') == '' ? '-' : $request->input($i . '.jawaban'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        $jawaban = JawabanJurnal::where('praktikan_id', Auth::guard('praktikan')->user()->id)->where('modul_id', $idModul)->get();
        return response()->json([
            "status" => "success",
            "jawaban_jurnal" => $jawaban
        ]);
    }

    public function showAsisten($idPraktikan, $idModul)
    {
        $jawaban = JawabanJurnal::where('praktikan_id', $idPraktikan)->where('modul_id', $idModul)->get();
        return response()->json([
            "status" => "success",
            "jawaban_jurnal" => $jawaban
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
