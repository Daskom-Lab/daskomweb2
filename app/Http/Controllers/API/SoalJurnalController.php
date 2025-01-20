<?php

namespace App\Http\Controllers\API;

use App\Models\SoalJurnal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $request->validate([
            "modul_id" => "required|integer",
            "pengantar" => "required|string",
            "soal" => "required|string",
        ]);

        $soal = SoalJurnal::create([
            "modul_id" => $id,
            "pengantar" => $request->pengantar,
            "kodingan" => $request->kodingan? $request->kodingan : "empty",
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
        $all_jurnal= SoalJurnal::where("modul_id", $id)->get();
        return response()->json([
            "message" => "Soal Jurnal retrieved successfully.",
            "soalJurnal" => $all_jurnal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "modul_id" => "required|integer",
            "pengantar" => "required|string",
            "soal" => "required|string",
        ]);
        if ($request->soal != $request->oldSoal)
            foreach (SoalJurnal::all() as $value)
                if ($value->soal === $request->soal)
                    return '{"message": "Soal ' . $request->soal . ' sudah terdaftar"}';

        $soal = SoalJurnal::find($id);
        $soal->modul_id = $request->modul_id;
        $soal->pengantar = $request->pengantar;
        $soal->soal = $request->soal;
        $soal->updated_at = now();
        $soal->save();

        return response()->json([
            "message" => "Soal berhasil diupdate",
            "data" => $soal,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $soal = SoalJurnal::find($id);  
        $soal->delete();
        return response()->json([
            "status" => "success"
        ]);
    }

    public function reset()
    {
        SoalJurnal::truncate();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
