<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Asisten;
use App\Models\HistoryJaga;
use Illuminate\Http\Request;

class HistoryJagaController extends Controller
{
    public function index()
    {
        try {
            $history = HistoryJaga::leftJoin('moduls', 'moduls.id', '=', 'history_jagas.modul_id')
                ->leftJoin('laporan_pjs', 'laporan_pjs.id', '=', 'history_jagas.laporan_pj_id')
                ->leftJoin('praktikums', 'praktikums.id', '=', 'laporan_pjs.praktikum_id')
                ->leftJoin('kelas', 'kelas.id', '=', 'praktikums.kelas_id')
                ->select(
                    'history_jagas.*',
                    'moduls.judul as modul_judul',
                    'laporan_pjs.laporan as laporan',
                    'kelas.kelas as kelas',
                    'kelas.hari as hari',
                    'kelas.shift as shift'
                )
                ->where('history_jagas.asisten_id', 1)
                ->get();
            return response()->json([
                'success' => true,
                'history' => $history,
                'message' => 'History retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving history.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function store(Request $request)
    {
        try {
            $request->validate([
                'hari' => 'required|string',
                'shift' => 'required|integer',
                'allasisten_id' => 'required|string',
                'modul_id' => 'required|integer',
                'laporan_pj_id' => 'required|integer',
            ]);
            HistoryJaga::create([
                'asisten_id' => auth('sanctum')->user()->id,
                'hari' => $request->hari,
                'shift' => $request->shift,
                'laporan_pj_id' => $request->laporan_pj_id,
                'modul_id' => $request->modul_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if ($request->allasisten_id != '') {
                foreach (explode('-', $request->allasisten_id) as $asisten) {
                    $asistenData = Asisten::where('kode', $asisten)->first();
                    if ($asistenData) {
                        HistoryJaga::create([
                            'asisten_id' => $asistenData->id,
                            'hari' => $request->hari,
                            'shift' => $request->shift,
                            'laporan_pj_id' => $request->laporan_pj_id,
                            'modul_id' => $request->modul_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'History created successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating history.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
