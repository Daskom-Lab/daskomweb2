<?php

namespace App\Http\Controllers\API\TP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SoalTp;

class SoalTpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request -> validate([
            'modul_id' => 'required|exists:moduls,id',
            'soal' => 'required|string',
            'isEssay' => 'nullable|boolean',
            'isProgram'=> 'nullable|boolean',
        ]);
        try{
            $soal = SoalTp::create([
                'modul_id' => $validated['modul_id'],
                'soal' => $validated['soal'],
                'isEssay' => $validated['isEssay'],
                'isProgram' => $validated['isProgram'],
            ]);
            return response() -> json([
                'succes' => true,
                'message' => 'Modul Berhasil Dibuat',
                'soalTp' => $soal, 
            ],201);
        }catch (\Exception $e){
            return response()->json([
                'succes' => false,
                'message' => "Terjadi Kesalahan Saat Membuat Soal TP",
                'error' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $soal = SoalTp::findOrFail($id);
            return response() -> json([
                'succes' => true,
                'message' => 'Soal Tp Berhasil Ditampilkan',
                'soalTp' => $soal,
            ]);
        }catch(\illuminate\Database\Eloquent\ModelNotFoundException){
            return response() -> json([
                'succes' => false,
                'message' => 'Soal TP tidak ditemukan'
            ],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request -> validate([
            'modul_id' => 'required|exists:moduls,id',
            'soal' => 'required|string',
            'isEssay' => 'nullable|boolean',
            'isProgram'=> 'nullable|boolean',
        ]);
        try{
            $soal = SoalTp::findOrFail($id);
            
            $soal->update(array_filter([
                "modul_id" => $validated['modul_id'] ?? null,
                'soal' => $validated['soal'] ?? null,
                'isEssay' => $validated['isEssay'] ?? null,
                'isProgram' => $validated['isProgram'] ?? null
            ]));
            return response() -> json([
                'succes' => true,
                'message' => 'Soal Tp Berhasil Diperbarui',
                'soalTp' => $soal,
            ],200);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response() -> json([
                'succes' => false,
                'message' => 'Soal TP Tidak Ditemukan',
                'eror' => $e->getMessage(),
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $soal = SoalTp::findOrFail($id);
            $soal -> delete();
            return response() -> json([
                'succes' => true,
                'message'=> "Soal Tp Berhasil Dihapus",
            ]);
        }catch(\illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response() -> json([
                'succes' => false,
                'message' => 'Soal Tp tidak ditemukan',
                'error' => $e->getMessage(),
            ],404);
        }catch(\Exception $e){
            return response()->json([
                'succes' => false,
                'message' => 'Terjadi Kesalahan Saat Menghapus Soal',
                'error' => $e->getMessage(),
            ],500);
        }
    }
}
