<?php

namespace App\Http\Controllers\API;

use App\Models\Asisten;
use App\Models\Polling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PollingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asisten_id' => 'required|integer|exists:asistens,id',
            'polling_id' => 'required|integer|exists:jenis_pollings,id',
            'praktikan_id' => 'required|integer|exists:praktikans,id',
        ]);
        try {
            $polling = Polling::where('praktikan_id', $request->praktikan_id)
                ->where('polling_id', $request->polling_id)
                ->first();
            if ($polling) {
                $polling->update([
                    'asisten_id' => $request->asisten_id,
                ]);
                return response()->json([
                    'message' => 'Polling updated successfully.'
                ], 200);
            } else {
                Polling::create([
                    'asisten_id' => $request->asisten_id,
                    'polling_id' => $request->polling_id,
                    'praktikan_id' => $request->praktikan_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                return response()->json([
                    'message' => 'Polling created successfully.'
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing the request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $asisten = DB::table('pollings')
                ->leftJoin('jenis_pollings', 'jenis_pollings.id', '=', 'pollings.polling_id')
                ->leftJoin('asistens', 'asistens.id', '=', 'pollings.asisten_id')
                ->where('pollings.praktikan_id', $id)
                ->select('asistens.kode', DB::raw('count(pollings.id) as total'))
                ->groupBy('asistens.kode')
                ->get();
            return response()->json([
                'asisten' => $asisten,
                'message' => 'Poll count by assistant code retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)//praktikan
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
