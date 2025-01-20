<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SoalTp;
use Illuminate\Http\Request;

class SoalTPController extends Controller
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
            "soal" => "required|string",
            "isEssay" => "required|boolean",
            "isProgram" => "required|boolean",
        ]);

        $soal = SoalTp::create([
            "modul_id" => $id,
            "soal" => $request->soal,
            "isEssay" => $request->isEssay,
            "isProgram" => $request->isProgram,
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
        $all_tp = SoalTp::where("modul_id", $id)->get();
        return response()->json([
            "message" => "Soal TP retrieved successfully.",
            "soalTp" => $all_tp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)//soal id
    {
        $request->validate([
            "modul_id" => "required|integer",
            "isEssay" => "required|boolean",
            "isProgram" => "required|boolean",
            "soal" => "required|string",
        ]);
        if ($request->soal != $request->oldSoal)
            foreach (SoalTp::all() as $value)
                if ($value->soal === $request->soal)
                    return '{"message": "Soal ' . $request->soal . ' sudah terdaftar"}';

        $soal = SoalTp::find($id);
        $soal->modul_id = $request->modul_id;
        $soal->isEssay = $request->isEssay;
        $soal->isProgram = $request->isProgram;
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
        $soal = SoalTp::find($id);
        $soal->delete();
        return response()->json([
            "status" => "success"
        ]);
    }

    public function reset()
    {
        SoalTp::truncate();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
