<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Models\SoalTa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SoalTAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
            "pertanyaan" => "required|string",
            "jawaban_benar" => "required|string",
            "jawaban_salah1" => "required|string",
            "jawaban_salah2" => "required|string",
            "jawaban_salah3" => "required|string",
        ]);

        $soal = SoalTa::create([
            "modul_id" => $id,
            "pengantar" => $request->pengantar? $request->pengantar : "empty",
            "kodingan" => $request->kodingan? $request->kodingan : "empty",
            "pertanyaan" => $request->pertanyaan,
            "jawaban_benar" => $request->jawaban_benar,
            "jawaban_salah1" => $request->jawaban_salah1,
            "jawaban_salah2" => $request->jawaban_salah2,
            "jawaban_salah3" => $request->jawaban_salah3,
        ]);

        return response()->json([
            "status" => "success",
            "data" => $soal,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($modul_id, $kelas_id)
    {
         if(substr(Kelas::where('id', $kelas_id)->first()->kelas, 0, 3) === 'TOT') {

            $all_soal = SoalTa::where('modul_id', $modul_id)->get();

        } else {
            $all_soal = SoalTa::where('modul_id', $modul_id)->inRandomOrder()->take(10)->get();
            $soal_ta= $all_soal->map(function ($soal) {
                return [
                    'id' => $soal->id,
                    "pengantar"  => $soal->pengantar,
                    "kodingan"   => $soal->kodingan,
                    "pertanyaan" => $soal->pertanyaan,
                    'modul_id'   => $soal->modul_id,
                    'pilihan1'   => $soal->jawaban_benar,
                    'pilihan2'   => $soal->jawaban_salah1,
                    'pilihan3'   => $soal->jawaban_salah2,
                    'pilihan4'   => $soal->jawaban_salah3,
                ];
            });
        }
        return response()->json([
            'message'=> 'soal retrieved successfully.',
            'soalTA' => $soal_ta?? $all_soal,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "modul_id" => "required|integer",
            "pengantar" => "required|string",
            "kodingan" => "required|string",
            "pertanyaan" => "required|string",
            "jawaban_benar" => "required|string",
            "jawaban_salah1" => "required|string",
            "jawaban_salah2" => "required|string",
            "jawaban_salah3" => "required|string",
        ]);
        if ($request->pertanyaan != $request->oldPertanyaan)
            foreach (SoalTa::all() as $value)
                if ($value->pertanyaan === $request->pertanyaan && $value->pengantar === $request->pengantar && $value->kodingan === $request->kodingan)
                    return '{"message": "Soal ' . $request->pertanyaan . ' sudah terdaftar"}';

        $soal = SoalTa::find($id);
        $soal->modul_id = $request->modul_id;
        $soal->pengantar = $request->pengantar;
        $soal->kodingan = $request->kodingan;
        $soal->pertanyaan = $request->pertanyaan;
        $soal->jawaban_benar = $request->jawaban_benar;
        $soal->jawaban_salah1 = $request->jawaban_salah1;
        $soal->jawaban_salah2 = $request->jawaban_salah2;
        $soal->jawaban_salah3 = $request->jawaban_salah3;
        $soal->save();

        return response()->json([
            "status" => "success",
            "data" => $soal,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $soal = SoalTa::find($id);
        $soal->delete();
        return response()->json([
            "status" => "success"
        ],200);
    }

    public function reset()
    {
        SoalTa::truncate();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
