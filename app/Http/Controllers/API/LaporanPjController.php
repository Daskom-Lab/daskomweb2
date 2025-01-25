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
        try {
            $laporan = LaporanPj::leftJoin('praktikums', 'praktikums.id', '=', 'laporan_pjs.praktikum_id')
                ->leftJoin('moduls', 'moduls.id', '=', 'praktikums.modul_id')
                ->select('laporan_pjs.*', 'praktikums.nama_praktikum', 'moduls.nama_modul')
                ->get();
            return response()->json([
                'laporan' => $laporan,
                'message' => 'Laporan retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve laporan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $laporan = LaporanPj::leftJoin('praktikums', 'praktikums.id', '=', 'laporan_pjs.praktikum_id')
                ->leftJoin('moduls', 'moduls.id', '=', 'praktikums.modul_id')
                ->select('laporan_pjs.*', 'praktikums.nama_praktikum', 'moduls.nama_modul')
                ->where('moduls.id', $id)
                ->get();
            return response()->json([
                'laporan' => $laporan,
                'message' => 'Laporan retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve laporan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request, $idKelas)
    {
        try {
            // Cari kelas
            $kelas = Kelas::findOrFail($idKelas);
            // Validasi input
            $validatedData = $request->validate([
                'pj_id' => 'required|integer',
                'praktikum_id' => 'required|integer|exists:praktikums,id',
                'laporan' => 'required|string|min:50',
                'allasisten_id' => 'nullable|string',
                'modul_id' => 'required|integer|exists:moduls,id',
            ]);
            // Buat laporan
            $laporan = LaporanPj::create([
                'allasisten_id' => $validatedData['allasisten_id'] ?? '',
                'hari' => $kelas->hari,
                'shift' => $kelas->shift,
                'laporan' => $validatedData['laporan'],
                'praktikum_id' => $validatedData['praktikum_id'],
                'pj_id' => auth('sanctum')->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Buat history jaga untuk PJ
            HistoryJaga::create([
                'asisten_id' => auth('sanctum')->user()->id,
                'laporan_pj_id' => $laporan->id,
                'modul_id' => $validatedData['modul_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Buat history jaga untuk semua asisten (jika ada)
            if (!empty($validatedData['allasisten_id'])) {
                $allasisten = explode('-', $validatedData['allasisten_id']);
                foreach ($allasisten as $asisten) {
                    $asistenData = Asisten::where('kode', $asisten)->first();
                    if ($asistenData) {
                        HistoryJaga::create([
                            'asisten_id' => $asistenData->id,
                            'laporan_pj_id' => $laporan->id,
                            'modul_id' => $validatedData['modul_id'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
            return response()->json([
                'laporan' => $laporan->id,
                'message' => 'Laporan created successfully.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Kelas not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create laporan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        try {
            // Cari laporan berdasarkan ID
            $laporan = LaporanPj::findOrFail($id);
            // Hapus laporan
            $laporan->delete();
            return response()->json([
                'message' => 'Laporan deleted successfully.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Laporan not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete laporan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    


}
