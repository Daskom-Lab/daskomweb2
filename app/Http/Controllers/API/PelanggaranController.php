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
        $asisten = Asisten::withCount('pelanggaranCount')->get();
        return response()->json([
            'asisten' => $asisten,
            'message' => 'Asisten retrieved successfully.'
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)//simpan pelanggaran abis feedback praktikan
    {
        $request->validate([
            'asisten_id' => 'required|integer',
            // 'asisten_id' => Auth::guard('asisten')->user()->id,
            'pelanggaran_id' => 'required|integer',
        ]);

        $pelanggaran = Pelanggaran::create([
            'asisten_id' => $request->asisten_id,
            'pelanggaran_id' => $request->pelanggaran_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Pelanggaran saved successfully.'
        ]);
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
        $pelanggaran = Pelanggaran::where('asisten_id', $id)->first();
        $pelanggaran->delete();
        return response()->json([
            'message' => 'Pelanggaran deleted successfully.'
        ]);
    }

    public function reset()
    {
        Pelanggaran::truncate();
        return response()->json([
            "status" => "success"
        ], 200);
    }
}
