<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Asisten;
use App\Models\HistoryJaga;
use Illuminate\Http\Request;

class HistoryJagaController extends Controller
{
    public function index(){
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
            'history' => $history,
            'message' => 'History retrieved successfully.'
        ], 200);
    }

   public function store(Request $request){

       //punya pj kelas
        $request->validate([
            'hari' => 'required|string',
            'shift' => 'required|integer',
            'allasisten_id' => 'required|string',    
            'modul_id' => 'required|integer',
            'laporan_pj_id' => 'required|integer'
        ]);

        HistoryJaga::create([
            'asisten_id' => auth()->guard('asisten')->user()->id,
            'hari' => $request->hari,
            'shift' => $request->shift,
            'laporan_pj_id' => $request->laporan_pj_id,
            'modul_id' => $request->modul_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        if($request->allasisten_id != ''){
            foreach(explode('-', $request->allasisten_id) as $asisten){
                HistoryJaga::create([
                    'asisten_id' => Asisten::where('kode', $asisten)->first()->id,
                    'hari' => $request->hari,
                    'shift' => $request->shift,
                    'laporan_pj_id' => $request->laporan_pj_id,
                    'modul_id' => $request->modul_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return response()->json([
            'message' => 'History created successfully.'
        ], 200);
   }
}
