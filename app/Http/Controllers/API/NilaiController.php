<?php

namespace App\Http\Controllers\API;

use App\Models\Nilai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Auth;

class NilaiController extends Controller
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
            'tp'=>'required|numeric',
            'ta'=>'required|numeric',
            'd1'=>'required|numeric',
            'd2'=>'required|numeric',
            'd3'=>'required|numeric',
            'd4'=>'required|numeric',
            'l1'=>'required|numeric',
            'l2'=>'required|numeric', 
            'modul_id' => 'required|numeric',
            'asisten_id'=>'required|numeric',
            'kelas_id'=>'required|numeric',
            'praktikan_id'=>'required|numeric',
        ]);
        
        $avg = ($request->tp+$request->ta+$request->d1+$request->d2+$request->d3+$request->d4+$request->l1+$request->l2)/8;
        // dd($avg);

        $nilai = Nilai::create([
            'tp'=>$request->tp,
            'ta'=>$request->ta,
            'd1'=>$request->d1,
            'd2'=>$request->d2,
            'd3'=>$request->d3,
            'd4'=>$request->d4,
            'l1'=>$request->l1,
            'l2'=>$request->l2 ,
            'avg'=>$avg,
            'modul_id'=>$request->modul_id,
            'asisten_id'=>$request->asisten_id,
            'kelas_id'=>$request->kelas_id,
            'praktikan_id'=>$request->praktikan_id
        ]);

        return response()->json(['message'=>'nilai berhasil di tambahkan'],200);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $nilai = Nilai::where('praktikan_id', auth('praktikan')->user()->id)->get();
        return response()->json([
            'nilai' => $nilai
        ]);
    }
    public function showAsisten($idPraktikan, $idModul)
    {
        $nilai = Nilai::where('praktikan_id', $idPraktikan)->where('modul_id', $idModul)->where('asisten_id', auth('asisten')->user()->id)->first();
        return response()->json([
            'nilai' => $nilai
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $nilai = Nilai::find($id);
        $request->validate([
            'tp'=>'required|numeric',
            'ta'=>'required|numeric',
            'd1'=>'required|numeric',
            'd2'=>'required|numeric',
            'd3'=>'required|numeric',
            'd4'=>'required|numeric',
            'l1'=>'required|numeric',
            'l2'=>'required|numeric', 
            'modul_id' => 'required|integer',
            'asisten_id'=>'required|integer',
            'kelas_id'=>'required|integer',
            'praktikan_id'=>'required|integer', 
        ]);

        $avg = ($request->tp+$request->ta+$request->d1+$request->d2+$request->d3+$request->d4+$request->l1+$request->l2)/8;
        $nilai->tp = $request->tp;
        $nilai->ta = $request->ta;
        $nilai->d1 = $request->d1;
        $nilai->d2 = $request->d2;
        $nilai->d3 = $request->d3;
        $nilai->d4 = $request->d4;
        $nilai->l1 = $request->l1;
        $nilai->l2 = $request->l2;
        $nilai->avg = $avg;
        $nilai->modul_id = $request->modul_id;
        $nilai->asisten_id = $request->asisten_id;
        $nilai->kelas_id = $request->kelas_id;
        $nilai->praktikan_id = $request->praktikan_id;
        $nilai->save();

        return response()->json(['message'=>'nilai berhasil di ubah'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
