<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\Tugaspendahuluan;
use Illuminate\Http\Request;

class TugasPendahuluanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tugas = Tugaspendahuluan::leftJoin('moduls', 'moduls.id', '=', 'tugaspendahuluans.modul_id')
                ->select('tugaspendahuluans.*', 'moduls.nama_modul')
                ->get();
            if ($tugas->isEmpty()) {
                return response()->json([
                    "message" => "Tidak ada tugas ditemukan.",
                ], 404);
            }
            return response()->json([
                "status" => "success",
                "data" => $tugas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Terjadi kesalahan saat mengambil data tugas.",
                "error" => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'data' => 'required|array',
            'data.*.id' => 'required|integer|exists:tugaspendahuluans,id',
            'data.*.isActive' => 'required|integer|in:0,1',
        ]);
        try {
            $updatedTugas = []; 
            foreach ($request->data as $item) {
                $tugas = Tugaspendahuluan::find($item['id']);
                
                if (!$tugas) {
                    return response()->json([
                        'message' => "Tugas dengan ID {$item['id']} tidak ditemukan.",
                    ], 404); 
                }
                $tugas->isActive = $item['isActive'];
                $tugas->updated_at = now();
                $tugas->save();
                $updatedTugas[] = $tugas;
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $updatedTugas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate tugas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
