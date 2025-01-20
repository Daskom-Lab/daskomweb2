<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Models\Asisten;
use App\Models\LaporanPj;
use App\Models\JadwalJaga;
use App\Models\HistoryJaga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LaporanPjController extends Controller
{
    public function index()
    {
        //ini buat aslab
        $laporan = LaporanPj::leftjoin('praktikums', 'praktikums.id', '=', 'laporan_pjs.praktikum_id')
        ->leftjoin('moduls', 'moduls.id', '=', 'praktikums.modul_id')
        ->select('laporan_pjs.*', 'praktikums.*', 'moduls.*')->get();

        return response()->json([
            'laporan' => $laporan,
            'message' => 'Laporan retrieved successfully.'
        ], 200);
    }

    public function show($id){
        //ini buat aslab jg
        $laporan = LaporanPj::leftjoin('praktikums', 'praktikums.id', '=', 'laporan_pjs.praktikum_id')
        ->leftjoin('moduls', 'moduls.id', '=', 'praktikums.modul_id')
        ->select('laporan_pjs.*', 'praktikums.*', 'moduls.*')
        ->where('moduls.id', $id)
        ->get();

        return response()->json([
            'laporan' => $laporan,
            'message' => 'Laporan retrieved successfully.'
        ], 200);
    }

    public function store(Request $request, $idKelas) //pake kelas id
    {
        //cari kelas
        $kelas = Kelas::findOrFail($idKelas);

        //validasi input
        $request->validate([
            'pj_id' => 'required|integer',
            'praktikum_id' => 'required|integer',
            'laporan' => 'required|string|min:50',
            'allasisten_id' => 'required|string',
            'modul_id' => 'required|integer',
        ]);

        //buat laporan
        $laporan = LaporanPj::create([
            'allasisten_id' => $request->allasisten_id??'',
            'hari' => $kelas->hari,
            'shift' => $kelas->shift,
            'laporan' => $request->laporan,
            'praktikum_id' => $request->praktikum_id,
            'pj_id' => auth('sanctum')->user()->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //buat history jaga
        HistoryJaga::create([
            'asisten_id' => auth('sanctum')->user()->id,
            'laporan_pj_id' =>$laporan->id,
            'modul_id' => $request->modul_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        if ($request->allasisten_id != '') {
            foreach (explode('-', $request->allasisten_id) as $asisten) {
                HistoryJaga::create([
                    'asisten_id' => Asisten::where('kode', $asisten)->first()->id,
                    'laporan_pj_id' => $laporan->id,
                    'modul_id' => $request->modul_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }


        return response()->json([
            'laporan' => $laporan->id,
            'message' => 'Laporan created successfully.'
        ], 200);

    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        $laporan = LaporanPj::findOrFail($id);
        $laporan->delete();

        return response()->json([
            'message' => 'Laporan deleted successfully.'
        ], 200);
    }


}
