<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Models\JadwalJaga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalJagaController extends Controller
{
    public function index(){
        $jadwal = JadwalJaga::leftjoin('kelas', 'kelas.id', '=', 'jadwal_jagas.kelas_id')
                ->leftjoin('asistens', 'asistens.id', '=', 'jadwal_jagas.asisten_id')
                ->select(
                    'jadwal_jagas.id',
                    'kelas_id',
                    'asisten_id',
                    'kode',
                    'kelas',
                )
                ->get();

        return response()->json([
            'message' => 'list jadwal jaga',
            'data'=>$jadwal
        ], 200);
    }


    public function store(Request $request){
        $request->validate([
            'kelas_id' => 'required|integer',
            'asisten_id' => 'required|integer',
        ]);

        foreach (JadwalJaga::all() as $jadwal){
            if ($request->kelas_id === $jadwal->kelas_id && $request->asisten_id === $jadwal->asisten_id)
                return response()->json(['message' => 'asisten ini sudah ada di jadwal']);
        }

        JadwalJaga::create([
            'kelas_id'     => $request->kelas_id,
            'asisten_id'   => $request->asisten_id,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return response()->json(['message' => 'Berhasil menambahkan jadwal']);
    }

    public function update(Request $request, $id){
       //
    }

    public function destroy($id){
        $jadwal = JadwalJaga::find($id);
        $jadwal->delete();

        return response()->json(['mesage' => 'berhasil dihapus']);
    }
}
                  