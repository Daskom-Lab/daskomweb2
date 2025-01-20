<?php

namespace App\Http\Controllers\API;

use App\Models\Modul;
use App\Models\SoalTk;
use App\Models\JawabanTk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JawabanTKController extends Controller
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
        JawabanTk::where('praktikan_id', $request->input('0.praktikan_id'))
        ->where('modul_id', $request->input('0.modul_id'))
        ->delete();

        for ($i = 0; $i < count($request->all()); $i++) {

            JawabanTk::create([
                'praktikan_id'  => $request->input($i . '.praktikan_id'),
                'modul_id'      => $request->input($i . '.modul_id'),
                'soal_id'       => $request->input($i . '.soal_id'),
                'jawaban'       => $request->input($i . '.jawaban') == '' ? '-' : $request->input($i . '.jawaban'),
            ]);
        }

        $allJawabanTk = JawabanTk::where('praktikan_id', $request->input('0.praktikan_id'))
        ->where('modul_id', $request->input('0.modul_id'))
        ->get();

        $nilaiTkCorrect = 0;
        foreach ($allJawabanTk as $j) {
            $currentSoal = SoalTk::find($j->soal_id);
            if ($j->jawaban == $currentSoal->jawaban_benar)
                $nilaiTkCorrect++;
        }

        $nilaiTK = ($nilaiTkCorrect / count($allJawabanTk)) * 100;

        return response()->json([
            "status" => "success",
            "nilai_tk" => $nilaiTK
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        $modul = Modul::findOrFail($idModul);
        if ($modul->isUnlocked) {
            $jawaban = JawabanTk::where('jawaban_tks.praktikan_id', auth('sanctum')->user()->id)
            ->where('jawaban_tks.modul_id', $idModul) // Specify the table for modul_id
            ->leftJoin('soal_tks', 'soal_tks.id', '=', 'jawaban_tks.soal_id')
            ->select(
                'soal_tks.pertanyaan as pertanyaan',
                'soal_tks.pengantar as pengantar',
                'soal_tks.kodingan as kodingan',
                'soal_tks.jawaban_salah1 as jawaban_salah1',
                'soal_tks.jawaban_salah2 as jawaban_salah2',
                'soal_tks.jawaban_salah3 as jawaban_salah3',
                'soal_tks.jawaban_benar as jawaban_benar',
                'jawaban_tks.soal_id as soal_id',
                'jawaban_tks.jawaban as jawaban'
            )
            ->get();

            if ($jawaban->isEmpty()) {
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
                'jawaban_tk' => $mappedJawaban,
            ]);
        }
        return response()->json([
            "status" => "success",
            'messages' => "Jawaban Masih Terkunci"
        ]);
        
    }
      
}
