<?php

namespace App\Http\Controllers\API;

use App\Models\JenisPolling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisPollingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jenis_polling = JenisPolling::all();
            return response()->json([
                'status' => 'success',
                'polling' => $jenis_polling,
                'message' => 'Jenis Polling retrieved successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve Jenis Polling.',
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
