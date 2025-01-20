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
        $tugas = Tugaspendahuluan::leftJoin('moduls', 'moduls.id', '=', 'tugaspendahuluans.modul_id')->get();
        return response()->json([
            "status" => "success",
            "data" => $tugas,
        ]);
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
            'isActive' => 'required|integer',
        ]);
        $data =  $request->all();
        for($i = 0; $i < count($data); $i++){
            $tugas = Tugaspendahuluan::find($data[$i]["id"]);
            $tugas->isActive = $data[$i]["isActive"];
            $tugas->updated_at = now();
            $tugas->save();
        }

        return response()->json([
            "status" => "success",
            "data" => $tugas,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
