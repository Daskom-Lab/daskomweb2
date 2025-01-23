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
        try {
            $request->validate([
                '0.praktikan_id' => 'required|integer',
                '0.modul_id' => 'required|integer',
                '*.soal_id' => 'required|integer',
                '*.jawaban' => 'nullable|string',
            ]);
            JawabanTa::where('praktikan_id', $request->input('0.praktikan_id'))
                ->where('modul_id', $request->input('0.modul_id'))
                ->delete();
            foreach ($request->all() as $index => $data) {
                JawabanTa::create([
                    'praktikan_id' => $data['praktikan_id'],
                    'modul_id' => $data['modul_id'],
                    'soal_id' => $data['soal_id'],
                    'jawaban' => empty($data['jawaban']) ? '-' : $data['jawaban'],
                ]);
            }
            $allJawabanTa = JawabanTa::where('praktikan_id', $request->input('0.praktikan_id'))
                ->where('modul_id', $request->input('0.modul_id'))
                ->get();
            $nilaiTaCorrect = 0;
            foreach ($allJawabanTa as $jawaban) {
                $currentSoal = SoalTa::find($jawaban->soal_id);
                if ($currentSoal && $jawaban->jawaban === $currentSoal->jawaban_benar) {
                    $nilaiTaCorrect++;
                }
            }
            $nilaiTA = count($allJawabanTa) > 0 ? ($nilaiTaCorrect / count($allJawabanTa)) * 100 : 0;
            return response()->json([
                "status" => "success",
                "nilai_ta" => $nilaiTA,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Validasi gagal.",
                "errors" => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat menyimpan jawaban TA.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $modul = Modul::findOrFail($id);
            if ($modul->isUnlocked) {
                // Mengambil jawaban TA berdasarkan praktikan_id dan modul_id
                $jawaban = JawabanTa::where('jawaban_tas.praktikan_id', auth('sanctum')->user()->id)
                    ->where('jawaban_tas.modul_id', $id)
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
                if ($jawaban->isEmpty()) {
                    return response()->json([
                        "message" => "Tidak ada jawaban"
                    ]);
                }
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data jawaban',
                'error' => $e->getMessage(),
            ], 500);
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
