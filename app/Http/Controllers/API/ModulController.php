<?php

namespace App\Http\Controllers\API;

use App\Models\Modul;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Models\Tugaspendahuluan;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ModulResource;
use App\Http\Controllers\API\BaseController as BaseController;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModulController extends BaseController
{
    public function index() {
        try {
            $moduls = Modul::leftJoin('resources', 'resources.modul_id', '=', 'moduls.id')
                ->select(
                    'judul',
                    'poin1',
                    'poin2',
                    'poin3',
                    'isEnglish', 
                    'isUnlocked',
                    'moduls.id as idM',
                    'resources.id as idR',
                    'resources.modul_link',
                    'resources.ppt_link'
                )
                ->get();
            return response()->json([
                'modul' => $moduls, 
                'message' => 'Moduls retrieved successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving moduls.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function show($id) {
        try {
            // Mengambil modul dengan eager loading relasi 'resource'
            $modul = Modul::with('resource')
                ->select('judul', 'poin1', 'poin2', 'poin3', 'isEnglish', 'isUnlocked', 'moduls.id as idM')
                ->where('moduls.id', $id)
                ->first();
            if (!$modul) {
                return response()->json([
                    'message' => 'Modul tidak ditemukan.'
                ], 404); 
            }
            $modul->resource_id = $modul->resource->id ?? null;
            $modul->modul_link = $modul->resource->modul_link ?? null;
            $modul->ppt_link = $modul->resource->ppt_link ?? null;
            return response()->json([
                'modul' => $modul,
                'message' => 'Modul berhasil diambil.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil modul.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    public function store(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'judul' => 'required|unique:moduls|string',
            'poin1' => 'required|string',
            'poin2' => 'nullable|string',
            'poin3' => 'nullable|string',
            'isEnglish' => 'required|integer',
            'isUnlocked' => 'required|integer',
            'modul_link' => 'required|string',
            'ppt_link' => 'required|string',
            'video_link' => 'required|string',
        ]);
        try {
            $modul = Modul::create([
                'judul' => $request->judul,
                'poin1' => $request->poin1,
                'poin2' => $request->poin2,
                'poin3' => $request->poin3,
                'isEnglish' => $request->isEnglish,
                'isUnlocked' => $request->isUnlocked,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Resource::create([
                'modul_id' => $modul->id,
                'modul_link' => $request->modul_link,
                'ppt_link' => $request->ppt_link,
                'video_link' => $request->video_link,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Tugaspendahuluan::create([
                'modul_id' => $modul->id,
                'pembahasan' => "empty",
                'isActive' => 0,
            ]);
            return response()->json([
                'message' => 'Modul berhasil ditambah.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menambahkan modul.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'poin1' => 'required|string',
            'poin2' => 'nullable|string',
            'poin3' => 'nullable|string',
            'isEnglish' => 'required|integer',
            'isUnlocked' => 'required|integer',
            'modul_link' => 'required|string',
            'ppt_link' => 'required|string',
            'video_link' => 'required|string',
        ]);
        try {
            if ($request->judul !== $request->oldJudul) {
                $existingModul = Modul::where('judul', $request->judul)->first();
                if ($existingModul) {
                    return response()->json([
                        'message' => 'Judul "' . $request->judul . '" sudah terdaftar.',
                    ], 400);
                }
            }
            $modul = Modul::findOrFail($id);
            $resource = Resource::where('modul_id', $modul->id)->first();
            $modul->judul = $request->judul;
            $modul->poin1 = $request->poin1;
            $modul->poin2 = $request->poin2;
            $modul->poin3 = $request->poin3;
            $modul->isEnglish = $request->isEnglish;
            $modul->isUnlocked = $request->isUnlocked;
            $modul->save();
            $resource->modul_link = $request->modul_link;
            $resource->ppt_link = $request->ppt_link;
            $resource->video_link = $request->video_link;
            $resource->save();
            return response()->json([
                'message' => 'Modul berhasil diupdate.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate modul.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function destroy($id){
        $modul = Modul::findOrFail($id);
        $modul->delete();

        return response()->json([
            'message' => 'modul berhasil dihapus'
        ], 200);
    }

    public function reset(){
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Modul::query()->delete(); 
            DB::table('history_jagas')->truncate();
            DB::table('jawaban_fitbs')->truncate();
            DB::table('jawaban_jurnals')->truncate();
            DB::table('jawaban_mandiris')->truncate();
            DB::table('jawaban_tas')->truncate();
            DB::table('jawaban_tks')->truncate();
            DB::table('jawaban_tps')->truncate();
            DB::table('kumpul_tps')->truncate();
            DB::table('laporan_pjs')->truncate();
            DB::table('laporan_praktikans')->truncate();
            DB::table('nilais')->truncate();
            DB::table('praktikums')->truncate();
            DB::table('resources')->truncate();
            DB::table('soal_fitbs')->truncate();
            DB::table('soal_jurnals')->truncate();
            DB::table('soal_mandiris')->truncate();
            DB::table('soal_tas')->truncate();
            DB::table('soal_tks')->truncate();
            DB::table('soal_tps')->truncate();
            DB::table('temp_jawabantps')->truncate();
            DB::table('tugaspendahuluans')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return response()->json(['message' => 'Modul table and related data reset successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during the reset process.',
                'error' => $e->getMessage(),
            ], 500); // Server error
        }
    }
    

    public function updateStatus(Request $request)
    {
        $data = $request->all();
        if (empty($data)) {
            return response()->json([
                'message' => 'No data provided.',
            ], 400); 
        }
    
        foreach ($data as $item) {
            if (!isset($item['id']) || !isset($item['isUnlocked'])) {
                return response()->json([
                    'message' => 'Missing required fields: id or isUnlocked.',
                ], 400); 
            }
            $modul = Modul::find($item['id']);
            if (!$modul) {
                return response()->json([
                    'message' => "Modul with ID {$item['id']} not found.",
                ], 404);
            }
            $modul->isUnlocked = $item['isUnlocked'];
            $modul->updated_at = now();
            $modul->save();
        }
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200); 
    }
    
}
