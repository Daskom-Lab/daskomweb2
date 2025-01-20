<?php

namespace App\Http\Controllers\API;

use App\Models\SoalFitb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SoalFITBController extends Controller
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
        $request->validate([
            "modul_id" => "required|integer",
            "pengantar" => "required|string",
            "kodingan" => "required|string",
            "soal" => "required|string",
        ]);

        $soal = SoalFitb::create([
            "modul_id" => $id,
            "pengantar" => $request->pengantar,
            "kodingan" => $request->kodingan,
            "soal" => $request->soal,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        return response()->json([
            "message" => "Soal berhasil ditambahkan",
            "data" => $soal,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $all_fitb = SoalFitb::where("modul_id", $id)->get();
        return response()->json([
            "message" => "Soal FITB retrieved successfully.",
            "soalFitb" => $all_fitb,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request ->validate([
            "modul_id" => "required|integer",
            "pengantar" => "required|string",
            "kodingan" => "required|string",
            "soal" => "required|string",
        ]); 

        if ($request->soal != $request->oldSoal)
            foreach (SoalFitb::all() as $value)
                if ($value->soal === $request->soal && $value->pengantar === $request->pengantar && $value->kodingan === $request->kodingan)
                    return '{"message": "Soal ' . $request->soal . ' sudah terdaftar"}';

        $soal = SoalFitb::find($id);
        $soal->modul_id = $request->modul_id;
        $soal->pengantar = $request->pengantar;
        $soal->kodingan = $request->kodingan;
        $soal->soal = $request->soal;
        $soal->updated_at = now();
        $soal->save();

        return response()->json([
            "message" => "Soal berhasil diperbarui",
            "data" => $soal,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $soal = SoalFitb::find($id);
        $soal->delete();
        return response()->json([
            "status" => "success"
        ],200);
    }

    public function reset(){
        SoalFitb::truncate();
        return response()->json([
            "status" => "success"
        ],200);
    }
}
