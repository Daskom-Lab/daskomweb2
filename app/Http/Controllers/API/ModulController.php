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
    }

    public function show($id) {
        $modul = Modul::leftjoin('resources', 'resources.modul_id', '=', 'moduls.id')->select('judul', 'poin1', 'poin2', 'poin3', 'isEnglish', 'isUnlocked', 'moduls.id as idM', 'resource.id as idR', 'modul_link', 'ppt_link')
                ->where('moduls.id', $id)->first();
        return response()->json([
            'modul' => $modul,
            'message' => 'Modul retrieved successfully.'
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|unique:moduls|string',
            'poin1' => 'required|string',
            'poin2' => 'nullable|string',
            'poin3' => 'nullable|string',
            'isEnglish' => 'required|integer',
            'isUnlocked'  => 'required|integer',
            'modul_link'=> 'required|string',
            'ppt_link'  => 'required|string',
            'video_link'  => 'required|string',
        ]);

        $modul = Modul::create([
            'judul'     => $request->judul,
            'poin1' => $request->poin1,
            'poin2' => $request->poin2,
            'poin3' => $request->poin3,
            'isEnglish' => $request->isEnglish,
            'isUnlocked'  => $request->isUnlocked,
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
            'isActive' => 0
        ]);


        return response()->json([
            'message' => 'modul berhasil ditambah',
        ], 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'judul'     => 'required|unique:moduls|string',
            'poin1' => 'required|string',
            'poin2' => 'nullable|string',
            'poin3' => 'nullable|string',
            'isEnglish' => 'required|integer',
            'isUnlocked'  => 'required|integer',
            'modul_link'=> 'required|string',
            'ppt_link'  => 'required|string',
            'video_link'  => 'required|string',
        ]);

        if ($request->judul != $request->oldJudul)
            foreach (Modul::all() as $modul => $value)
                if ($value->judul === $request->judul)
                    return '{"message": "Judul ' . $request->judul . ' sudah terdaftar"}';

        $modul = Modul::findOrFail($id);
        $resource = Resource::where('modul_id', $modul->id)->first();
        $resource->modul_link = $request->modul_link;
        $resource->ppt_link = $request->ppt_link;
        $modul->judul = $request->judul;
        $modul->poin1 = $request->poin1;
        $modul->poin2 = $request->poin2;
        $modul->poin3 = $request->poin3;
        $modul->isEnglish = $request->isEnglish;
        $modul->isUnlocked = $request->isUnlocked;
        $modul->save();
        $resource->save();

        return response()->json([
            'message' => 'modul berhasil di update'
        ], 200);
    }

    public function destroy($id){
        $modul = Modul::findOrFail($id);
        $modul->delete();

        return response()->json([
            'message' => 'modul berhasil dihapus'
        ], 200);
    }

    public function reset(){
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete related data in all related tables
        Modul::query()->delete(); // Deletes all records in `moduls` table and cascades to related data if set up

        // Alternatively, truncate related tables directly if cascading is not set up
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

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return response()->json(['message' => 'Modul table and related data reset successfully.'], 200);
    }

    public function updateStatus(Request $request){
        $data =  $request->all();
        for ($i = 0; $i < count($data); $i++) {
            $modul = Modul::findOrFail($data[$i]["id"]);
            $modul->isUnlocked = $data[$i]["isUnlocked"];
            $modul->updated_at = now();
            $modul->save();
        }

        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }
}
