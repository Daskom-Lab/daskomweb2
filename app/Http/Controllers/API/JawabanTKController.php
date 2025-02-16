<?php

namespace App\Http\Controllers\API;

use App\Models\Modul;
use App\Models\SoalTk;
use App\Models\JawabanTk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $request->validate([
                '*.praktikan_id' => 'required|integer',
                '*.modul_id' => 'required|integer',
                '*.soal_id' => 'required|integer',
                '*.jawaban' => 'nullable|string',
            ]);
            JawabanTk::where('praktikan_id', $request->input('0.praktikan_id'))
                ->where('modul_id', $request->input('0.modul_id'))
                ->delete();
            foreach ($request->all() as $data) {
                JawabanTk::create([
                    'praktikan_id' => $data['praktikan_id'],
                    'modul_id' => $data['modul_id'],
                    'soal_id' => $data['soal_id'],
                    'jawaban' => $data['jawaban'] == '' ? '-' : $data['jawaban'],
                ]);
            }
            $allJawabanTk = JawabanTk::where('praktikan_id', $request->input('0.praktikan_id'))
                ->where('modul_id', $request->input('0.modul_id'))
                ->get();
            if ($allJawabanTk->isEmpty()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Tidak ada jawaban yang ditemukan setelah penyimpanan.",
                ], 404);
            }
            $nilaiTkCorrect = 0;
            foreach ($allJawabanTk as $j) {
                $currentSoal = SoalTk::find($j->soal_id);
                if ($currentSoal && $j->jawaban == $currentSoal->jawaban_benar) {
                    $nilaiTkCorrect++;
                }
            }
            $totalJawaban = count($allJawabanTk);
            $nilaiTK = $totalJawaban > 0 ? ($nilaiTkCorrect / $totalJawaban) * 100 : 0;
            return response()->json([
                "status" => "success",
                "nilai_tk" => $nilaiTK,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "status" => "error",
                "message" => "Validasi input gagal.",
                "errors" => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Terjadi kesalahan saat menyimpan data jawaban TK.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show($idModul)
    {
        try {
            if (!is_numeric($idModul)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID Modul tidak valid.'
                ], 400);
            }
            $modul = Modul::findOrFail($idModul);
            if (!$modul->isUnlocked) {
                return response()->json([
                    "status" => "locked",
                    'message' => "Jawaban masih terkunci."
                ], 403);
            }
            $jawaban = JawabanTk::where('jawaban_tks.praktikan_id', auth('sanctum')->user()->id)
                ->where('jawaban_tks.modul_id', $idModul)
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
                    "status" => "not_found",
                    "message" => "Tidak ada jawaban untuk modul ini."
                ], 404);
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
                'jawaban_tk' => $mappedJawaban,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Modul tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
