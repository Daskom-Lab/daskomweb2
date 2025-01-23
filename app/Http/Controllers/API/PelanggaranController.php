<?php

namespace App\Http\Controllers\API;

use App\Models\Asisten;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $asisten = Asisten::withCount('pelanggaranCount')->get();
    
            if ($asisten->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada data asisten yang ditemukan.',
                ], 404);
            }
    
            return response()->json([
                'asisten' => $asisten,
                'message' => 'Data asisten berhasil diambil.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data asisten.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'asisten_id' => 'required|exists:asistens,id',
                'pelanggaran_id' => 'required|exists:pelanggarans,id',
            ]);
            // Simpan pelanggaran
            $pelanggaran = Pelanggaran::create([
                'asisten_id' => $validatedData['asisten_id'],
                'pelanggaran_id' => $validatedData['pelanggaran_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return response()->json([
                'message' => 'Pelanggaran berhasil disimpan.',
                'data' => $pelanggaran,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan pelanggaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy($id)
    {
        try {
            // Cari data pelanggaran berdasarkan asisten_id
            $pelanggaran = Pelanggaran::where('asisten_id', $id)->first();
            if (!$pelanggaran) {
                return response()->json([
                    'message' => 'Data pelanggaran dengan asisten ID ' . $id . ' tidak ditemukan.',
                ], 404);
            }
            $pelanggaran->delete();
            return response()->json([
                'message' => 'Data pelanggaran berhasil dihapus.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data pelanggaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function reset()
    {
        try {
            Pelanggaran::truncate();
            return response()->json([
                'message' => 'Semua data pelanggaran berhasil dihapus.',
                'status' => 'success',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus semua data pelanggaran.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
