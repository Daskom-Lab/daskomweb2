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
        $validatedData = $request->validate([
            'tp'           => 'required|numeric|min:0|max:100',
            'ta'           => 'required|numeric|min:0|max:100',
            'd1'           => 'required|numeric|min:0|max:100',
            'd2'           => 'required|numeric|min:0|max:100',
            'd3'           => 'required|numeric|min:0|max:100',
            'd4'           => 'required|numeric|min:0|max:100',
            'l1'           => 'required|numeric|min:0|max:100',
            'l2'           => 'required|numeric|min:0|max:100',
            'modul_id'     => 'required|exists:moduls,id',
            'asisten_id'   => 'required|exists:asistens,id',
            'kelas_id'     => 'required|exists:kelas,id',
            'praktikan_id' => 'required|exists:praktikans,id',
        ]);
        try {
            $avg = (
                $validatedData['tp'] +
                $validatedData['ta'] +
                $validatedData['d1'] +
                $validatedData['d2'] +
                $validatedData['d3'] +
                $validatedData['d4'] +
                $validatedData['l1'] +
                $validatedData['l2']
            ) / 8;
            $nilai = Nilai::create([
                'tp'           => $validatedData['tp'],
                'ta'           => $validatedData['ta'],
                'd1'           => $validatedData['d1'],
                'd2'           => $validatedData['d2'],
                'd3'           => $validatedData['d3'],
                'd4'           => $validatedData['d4'],
                'l1'           => $validatedData['l1'],
                'l2'           => $validatedData['l2'],
                'avg'          => $avg,
                'modul_id'     => $validatedData['modul_id'],
                'asisten_id'   => $validatedData['asisten_id'],
                'kelas_id'     => $validatedData['kelas_id'],
                'praktikan_id' => $validatedData['praktikan_id'],
            ]);
            return response()->json([
                'message' => 'Nilai berhasil ditambahkan.',
                'data'    => $nilai,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan nilai.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $nilai = Nilai::where('praktikan_id', auth('sanctum')->user()->id)->get();
            if ($nilai->isEmpty()) {
                return response()->json([
                    'message' => 'Data nilai tidak ditemukan untuk praktikan ini.',
                ], 404);
            }
            return response()->json([
                'nilai' => $nilai,
                'message' => 'Data nilai berhasil diambil.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data nilai.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function showAsisten($idPraktikan, $idModul)
    {
        try {
            $nilai = Nilai::where('praktikan_id', $idPraktikan)
                ->where('modul_id', $idModul)
                ->where('asisten_id', auth('asisten')->user()->id)
                ->first();
            if (!$nilai) {
                return response()->json([
                    'message' => 'Data nilai tidak ditemukan untuk kombinasi praktikan, modul, dan asisten ini.',
                ], 404);
            }
            return response()->json([
                'nilai' => $nilai,
                'message' => 'Data nilai berhasil diambil.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data nilai.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function validateRequest(Request $request)
    {
        return $request->validate([
            'tp' => 'required|numeric|min:0|max:100',
            'ta' => 'required|numeric|min:0|max:100',
            'd1' => 'required|numeric|min:0|max:100',
            'd2' => 'required|numeric|min:0|max:100',
            'd3' => 'required|numeric|min:0|max:100',
            'd4' => 'required|numeric|min:0|max:100',
            'l1' => 'required|numeric|min:0|max:100',
            'l2' => 'required|numeric|min:0|max:100',
            'modul_id' => 'required|exists:moduls,id',
            'asisten_id' => 'required|exists:asistens,id',
            'kelas_id' => 'required|exists:kelas,id',
            'praktikan_id' => 'required|exists:praktikans,id',
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $nilai = Nilai::find($id);
            if (!$nilai) {
                return response()->json([
                    'message' => 'Data nilai dengan ID ' . $id . ' tidak ditemukan.'
                ], 404);
            }
            $validatedData = $this->validateRequest($request);
            $avg = (
                $validatedData['tp'] +
                $validatedData['ta'] +
                $validatedData['d1'] +
                $validatedData['d2'] +
                $validatedData['d3'] +
                $validatedData['d4'] +
                $validatedData['l1'] +
                $validatedData['l2']
            ) / 8;
            $nilai->update(array_merge($validatedData, ['avg' => $avg]));
            return response()->json([
                'message' => 'Data nilai berhasil diperbarui.',
                'nilai' => $nilai,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data nilai.',
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
