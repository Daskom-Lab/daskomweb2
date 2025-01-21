<?php

namespace App\Http\Controllers\API;

use App\Models\Asisten;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AsistenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //buat card asistens & foto polling
    {
        try {
            $asisten = Asisten::leftJoin('roles', 'roles.id', '=', 'asistens.role_id')
                ->select('nama', 'kode', 'roles.name as role', 'role_id', 'nomor_telepon', 'id_line', 'instagram', 'deskripsi')
                ->get();
            return response()->json([
                'success' => true,
                'asisten' => $asisten,
                'message' => 'Asisten retrieved successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Asisten.',
                'error' => $e->getMessage(),
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
        $request->validate([
            'nomor_telepon' => 'required|string',
            'id_line' => 'required|string',
            'instagram' => 'required|string',
            'deskripsi' => 'required|string',
        ]);
        try {
            $asisten = Asisten::find(auth('sanctum')->user()->id);
            if (!$asisten) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asisten not found.',
                ], 404);
            }
            $asisten->nomor_telepon = $request->nomor_telepon;
            $asisten->id_line = $request->id_line;
            $asisten->instagram = $request->instagram;
            $asisten->deskripsi = $request->deskripsi;
            $asisten->save();
            return response()->json([
                'success' => true,
                'message' => 'Asisten updated successfully.',
                'asisten' => $asisten,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Asisten.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $asisten = Asisten::findOrFail($id);
            $role = Role::findOrFail($asisten->role_id);
            $asisten->removeRole($role->name);
            $asisten->delete();
            return response()->json([
                'success' => true,
                'message' => 'Asisten deleted successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Asisten or Role not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Asisten.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
