<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Deadline;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeadlineController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $deadline = Deadline::where('praktikums_id', $id)->first();
            if (!$deadline) {
                return response()->json([
                    'success' => false,
                    'message' => 'Deadline is empty.'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'deadline' => $deadline,
                'message' => 'Deadline retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the deadline.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $deadline = Deadline::where('praktikums_id', $id)->first();
        
        try {
            $deadline = Deadline::where('praktikums_id', $id)->first();
            
            if (!$deadline) {
                return response()->json(['message' => 'Deadline not found'], 404);
            }

            
            $request->validate([
                'start_TA' => 'required|date_format:d-m-Y H:i|before:now',
                'end_TA' => 'required|date_format:d-m-Y H:i|after:start_TA',
                'start_TK' => 'required|date_format:d-m-Y H:i|after:now',  
                'end_TK' => 'required|date_format:d-m-Y H:i|after:start_TK',  
                'start_TM' => 'required|date_format:d-m-Y H:i|after:now',  
                'end_TM' => 'required|date_format:d-m-Y H:i|after:start_TM',  
                'start_jurnal' => 'required|date_format:d-m-Y H:i|after:now',  
                'end_jurnal' => 'required|date_format:d-m-Y H:i|after:start_jurnal',  
            ]);
            $startTA = Carbon::createFromFormat('d-m-Y H:i', $request->start_TA)->format('Y-m-d H:i:s');
            $endTA = Carbon::createFromFormat('d-m-Y H:i', $request->end_TA)->format('Y-m-d H:i:s');
            $startTK = Carbon::createFromFormat('d-m-Y H:i', $request->start_TK)->format('Y-m-d H:i:s');
            $endTK = Carbon::createFromFormat('d-m-Y H:i', $request->end_TK)->format('Y-m-d H:i:s');
            $startJurnal = Carbon::createFromFormat('d-m-Y H:i', $request->start_jurnal)->format('Y-m-d H:i:s');
            $endJurnal = Carbon::createFromFormat('d-m-Y H:i', $request->end_jurnal)->format('Y-m-d H:i:s');
            $startTM = Carbon::createFromFormat('d-m-Y H:i', $request->start_TM)->format('Y-m-d H:i:s');
            $endTM = Carbon::createFromFormat('d-m-Y H:i', $request->end_TM)->format('Y-m-d H:i:s');

            $deadline->start_TA = $startTA;
            $deadline->end_TA = $endTA;
            $deadline->start_TK = $startTK;
            $deadline->end_TK = $endTK;
            $deadline->start_TM = $startTM;
            $deadline->end_TM = $endTM;
            $deadline->start_jurnal = $startJurnal;
            $deadline->end_jurnal = $endJurnal;
            $deadline->updated_at = now();
            $deadline->save();

            return response()->json([
                'deadline' => $deadline,
                'message' => 'Deadline successfully updated'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
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

    public function reset($idPraktikum)
    {
        try {
            $praktikum = Praktikum::findOrFail($idPraktikum);
            if ($praktikum->isActive) {
                $deadline = Deadline::where('praktikums_id', $idPraktikum)->first();
                if (!$deadline) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Deadline not found for the specified Praktikum.'
                    ], 404);
                }
                $timeString = "00:00";
                $time = Carbon::createFromFormat('H:i', $timeString);
                $praktikum->isActive = 0;
                $deadline->start_TA = $time;
                $deadline->end_TA = $time;
                $deadline->start_TK = $time;
                $deadline->end_TK = $time;
                $deadline->start_TM = $time;
                $deadline->end_TM = $time;
                $deadline->start_jurnal = $time;
                $deadline->end_jurnal = $time;
                $deadline->updated_at = now();
                $praktikum->updated_at = now();
                $praktikum->save();
                $deadline->save();
                return response()->json([
                    'success' => true,
                    'deadline' => $deadline,
                    'message' => 'Deadline successfully reset.'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Praktikum is not active.'
                ], 400);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Praktikum not found.',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while resetting the deadline.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}
