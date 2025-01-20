<?php

namespace App\Http\Controllers\API;

use App\Models\Modul;
use App\Models\SoalTa;
use App\Models\JawabanTa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JawabanTAController extends Controller
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
        JawabanTa::where('praktikan_id', $request->input('0.praktikan_id'))
        ->where('modul_id', $request->input('0.modul_id'))
        ->delete();

        for ($i = 0; $i < count($request->all()); $i++) {

            JawabanTa::create([
                'praktikan_id'  => $request->input($i . '.praktikan_id'),
                'modul_id'      => $request->input($i . '.modul_id'),
                'soal_id'       => $request->input($i . '.soal_id'),
                'jawaban'       => $request->input($i . '.jawaban') == '' ? '-' : $request->input($i . '.jawaban'),
            ]);
        }

        $allJawabanTa = JawabanTa::where('praktikan_id', $request->input('0.praktikan_id'))
        ->where('modul_id', $request->input('0.modul_id'))
        ->get();

        $nilaiTaCorrect = 0;
        foreach ($allJawabanTa as $j) {
            $currentSoal = SoalTa::find($j->soal_id);
            if ($j->jawaban == $currentSoal->jawaban_benar)
                $nilaiTaCorrect++;
        }

        $nilaiTA = ($nilaiTaCorrect / count($allJawabanTa)) * 100;

        return response()->json([
            "status" => "success",
            "nilai_ta" => $nilaiTA
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $modul = Modul::findOrFail($id);
        if ($modul->isUnlocked) {
            $jawaban = JawabanTa::where('jawaban_tas.praktikan_id', auth('sanctum')->user()->id)
            ->where('jawaban_tas.modul_id', $id) // Specify the table for modul_id
            ->leftJoin('soal_tas', 'soal_tas.id', '=', 'jawaban_tas.soal_id')
            ->select(
                'soal_tas.pertanyaan as pertanyaan',
                'soal_tas.pengantar as pengantar',
                'soal_tas.kodingan as kodingan',
                'soal_tas.jawaban_salah1 as jawaban_salah1',
                'soal_tas.jawaban_salah2 as jawaban_salah2',
                'soal_tas.jawaban_salah3 as jawaban_salah3',
                'soal_tas.jawaban_benar as jawaban_benar',
                'jawaban_tas.soal_id as soal_id',
                'jawaban_tas.jawaban as jawaban'
            )
            ->get();
    
            if($jawaban->isEmpty()){
                return response()->json([
                    "message" => "Tidak ada jawaban"
                ]);
            }
    
            // Map the data to associate jawaban1-4 with soal_ta id
            $mappedJawaban = $jawaban->map(function ($item) {
                return [
                    'pertanyaan' => $item->pertanyaan,
                    'pengantar' => $item->pengantar,
                    'kodingan' => $item->kodingan,
                    'soal_id' => $item->soal_id,
                    'jawaban' => $item->jawaban,
                    'jawaban1' => $item->jawaban_salah2,
                    'jawaban2' => $item->jawaban_salah3,
                    'jawaban3' => $item->jawaban_benar,
                    'jawaban4' => $item->jawaban_salah1,
                ];
            });
    
            return response()->json([
                'status' => 'success',
                'jawaban_ta' => $mappedJawaban,
            ]);

        }
        return response()->json([
            "status" => "success",
            'messages' => "Jawaban Masih Terkunci"
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
