<?php

namespace App\Http\Controllers\API;

use App\Models\Praktikum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use function Termwind\parse;

class PraktikumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //no needed
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //udah di store kelas
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $praktikum = Praktikum::leftJoin('moduls', 'praktikums.modul_id', '=', 'moduls.id')
                ->select('praktikums.*', 'moduls.*')
                ->where('kelas_id', $id)
                ->get();
            return response()->json([
                'praktikum' => $praktikum,
                'message' => 'praktikum retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the praktikum.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $currentTime = Carbon::now();
            $request->validate([
                'start_TA' => 'nullable|date_format:d-m-Y H:i',
                'end_TK' => 'nullable|date_format:d-m-Y H:i',
            ]);
            $praktikum = Praktikum::find($id);
            if (!$praktikum) {
                return response()->json([
                    'message' => 'Praktikum not found.'
                ], 404);
            }
            $start = $request->start_TA ? Carbon::createFromFormat('d-m-Y H:i', $request->start_TA) : null;
            $end = $request->end_TK ? Carbon::createFromFormat('d-m-Y H:i', $request->end_TK) : null;
            if (boolval($praktikum->isActive)) {
                if ($end && $currentTime->greaterThan($end)) {
                    $praktikum->isActive = 0;
                    $praktikum->start_time = $start ? $start->format('Y-m-d H:i:s') : $praktikum->start_time;
                    $praktikum->end_time = $end->format('Y-m-d H:i:s');
                    $praktikum->save();
                    return response()->json(['message' => 'Status praktikum berhasil diubah'], 200);
                } else {
                    return response()->json(['message' => 'No changes made to status'], 200);
                }
            } else {
                $praktikum->isActive = 1;
                $praktikum->start_time = $currentTime->format('Y-m-d H:i:s');
                $praktikum->save();
                return response()->json(['message' => 'Status praktikum berhasil diubah'], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the praktikum.',
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
