<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Models\JadwalJaga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JadwalJagaController extends Controller
{
    public function index()
    {
        try {
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
                'message' => 'List jadwal jaga',
                'data' => $jadwal,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil data jadwal jaga',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'kelas_id' => 'required|integer',
                'asisten_id' => 'required|integer',
            ]);
            foreach (JadwalJaga::all() as $jadwal) {
                if ($request->kelas_id === $jadwal->kelas_id && $request->asisten_id === $jadwal->asisten_id) {
                    return response()->json([
                        'message' => 'Asisten ini sudah ada di jadwal',
                    ], 400);
                }
            }
            JadwalJaga::create([
                'kelas_id' => $request->kelas_id,
                'asisten_id' => $request->asisten_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json(['message' => 'Berhasil menambahkan jadwal'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan jadwal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id){
       //
    }

    public function destroy($id)
    {
        try {
            $jadwal = JadwalJaga::findOrFail($id);
            $jadwal->delete();
            return response()->json([
                'message' => 'Berhasil dihapus',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Jadwal tidak ditemukan',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghapus jadwal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}