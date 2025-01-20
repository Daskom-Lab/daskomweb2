<?php

namespace App\Http\Controllers\API;

use App\Models\Asisten;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AsistenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //buat card asistens & foto polling
    {
        $asisten = Asisten::leftJoin('roles', 'roles.id', '=', 'asistens.role_id')
        ->select('nama', 'kode', 'roles.name as role', 'role_id', 'nomor_telepon', 'id_line', 'instagram', 'deskripsi')
        ->get();
        return response()->json([
            'asisten' => $asisten,
            'message' => 'Asisten retrieved successfully.'
        ], 200);
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
    public function update(Request $request) //edit profile
    {
        $request->validate([  
            'nomor_telepon' => 'required',    
            'id_line' => 'required',    
            'instagram' => 'required',    
            'deskripsi' => 'required',    
        ]);

        $asisten = Asisten::find(auth('sanctum')->user()->id);
        $asisten->nomor_telepon = $request->nomor_telepon;
        $asisten->id_line = $request->id_line;
        $asisten->instagram = $request->instagram;
        $asisten->deskripsi = $request->deskripsi;
        $asisten->save();
        return response()->json([
            'message' => 'Asisten updated successfully.'
        ], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
