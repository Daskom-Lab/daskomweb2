<?php

namespace App\Http\Controllers\API;

use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Deadline;
use App\Models\LaporanPj;
use App\Models\Praktikan;
use App\Models\Praktikum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{

    public function index(){
        $kelas = Kelas::all();
        return response()->json([
            'message'=>'Kelas retrieved successfully.',
            'kelas' => $kelas
        ], 200);
    }

    public function store(Request $request){
        $request->validate([
            'kelas' => 'required|string|unique:kelas,kelas',
            'shift' => 'required|integer',
            'hari'  => 'required|string',
            'totalGroup' => 'required|integer',
            'isEnglish' => 'required|integer',
        ]);

        $modulEng = Modul::where('isEnglish', $request->isEnglish)->get();
        $modulReg = Modul::where('isEnglish', !$request->isEnglish)->get();

        if($modulEng->isEmpty() && $modulReg->isEmpty())
            return response()->json(['message'=>'Modul belum ada, silahkan tambahkan modul terlebih dahulu']);

        $countSameShift = Kelas::where('shift', $request->shift)->where('hari', $request->hari)->count();
        foreach(Kelas::all() as $kelas)
            if($countSameShift >= 2)
                return response()->json(['message'=>"shift ini sudah ada 2"]);

        $kelas = Kelas::create([
            'kelas' => Str::upper($request->kelas),
            'shift' => $request->shift,
            'hari' => Str::upper($request->hari),
            'totalGroup' => $request->totalGroup,
            'isEnglish' => $request->isEnglish,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if(boolval($request->isEnglish)){
            foreach($modulEng as $modul){
                $praktikum = Praktikum::create([
                    'kelas_id' => $kelas->id,
                    'modul_id' => $modul->id,
                    "start_time" => "00:00",
                    "end_time" => "00:00",
                    "isActive" => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $deadline = Deadline::create([
                    'praktikums_id' => $praktikum->id,
                    'start_TA' => "00:00",
                    'end_TA' => "00:00", 
                    'start_jurnal' => "00:00",
                    'end_jurnal' => "00:00",
                    'start_TM' => "00:00",
                    'end_TM' => "00:00",
                    'start_TK' => "00:00",
                    'end_TK' => "00:00",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }else{
            foreach ($modulReg as $modul) {
                $praktikum = Praktikum::create([
                    'kelas_id' => $kelas->id,
                    'modul_id' => $modul->id,
                    "start_time" => "00:00",
                    "end_time" => "00:00",
                    "isActive" => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $deadline = Deadline::create([
                    'praktikums_id' => $praktikum->id,
                    'start_TA' => "00:00",
                    'end_TA' => "00:00",
                    'start_jurnal' => "00:00",
                    'end_jurnal' => "00:00",
                    'start_TM' => "00:00",
                    'end_TM' => "00:00",
                    'start_TK' => "00:00",
                    'end_TK' => "00:00",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        return response()->json([
            'message' => 'kelas berhasil di tambahkan'
        ], 200);
    }

    public function update(Request $request, $id){
        $kelas = Kelas::find($id);
        $request->validate([
            'kelas'  => 'required|min:8|max:10|string',
            'hari'   => 'required|string',
            'shift'  => 'required|integer',
            'totalGroup' => 'required|min:1|max:20|integer',
        ]);

        foreach (Kelas::all() as $kelas)
            if ($request->shift === $kelas->shift && $request->day === $kelas->day)
                return response()->json(['message' => "shift ini sudah ada"]);

        $kelas->kelas = strtoupper($request->kelas);
        $kelas->hari = strtoupper($request->hari);
        $kelas->shift = $request->shift;
        $kelas->totalGroup = $request->totalGroup;
        $kelas->updated_at = now();
        $kelas->save();

        return response()->json(['message' => 'kelas berhasil di update']);
    }

    public function destroy($id){
        $kelas = Kelas::findOrFail($id);
        // Retrieve all praktikums related to the kelas
        $praktikummoduls = Praktikum::where('kelas_id', $kelas->id)->get();

        foreach ($praktikummoduls as $praktikummodul) {
            // Retrieve all laporan_pjs related to each praktikum
            $laporans = LaporanPj::where('praktikum_id', $praktikummodul->id)->get();

            // Delete each laporan_pj
            foreach ($laporans as $laporan) {
                $laporan->delete();
            }

            // Delete the praktikum
            $praktikummodul->delete();
        }

        // Finally, delete the kelas
        $kelas->delete();

        return response()->json(['message'=>'kelas berhasil dihapus']);
    }

    public function reset(){
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Praktikan::all()->each(function ($praktikan) {
            // Delete all related records for each Praktikan
            $praktikan->feedback()->delete();
            $praktikan->jawaban_fitbs()->delete();
            $praktikan->jawaban_jurnals()->delete();
            $praktikan->jawaban_mandiris()->delete();
            $praktikan->jawaban_tas()->delete();
            $praktikan->jawaban_tks()->delete();
            $praktikan->jawaban_tps()->delete();
            $praktikan->kumpul_tps()->delete();
            $praktikan->laporan_praktikans()->delete();
            $praktikan->nilais()->delete();
            $praktikan->pollings()->delete();
            $praktikan->temp_jawabantps()->delete();
        });

        // Truncate the related tables (reset auto increment counter)
        DB::table('feedback')->truncate();
        DB::table('jawaban_fitbs')->truncate();
        DB::table('jawaban_jurnals')->truncate();
        DB::table('jawaban_mandiris')->truncate();
        DB::table('jawaban_tas')->truncate();
        DB::table('jawaban_tks')->truncate();
        DB::table('jawaban_tps')->truncate();
        DB::table('kumpul_tps')->truncate();
        DB::table('laporan_praktikans')->truncate();
        DB::table('nilais')->truncate();
        DB::table('pollings')->truncate();
        DB::table('temp_jawabantps')->truncate();

        // Truncate the main Praktikan table
        DB::table('praktikans')->truncate();

        Kelas::all()->each(function ($kelas) {
            // Delete all related records for each Kelas
            $kelas->feedback()->delete();
            $kelas->jadwal_jagas()->delete();
            $kelas->kumpul_tps()->delete();
            $kelas->nilais()->delete();
            $kelas->praktikans()->delete();
            $kelas->praktikums()->delete();
        });

        // Truncate the related tables (reset auto increment counter)
        DB::table('feedback')->truncate();
        DB::table('jadwal_jagas')->truncate();
        DB::table('kumpul_tps')->truncate();
        DB::table('nilais')->truncate();
        DB::table('praktikans')->truncate();
        DB::table('praktikums')->truncate();
        DB::table('laporan_pjs')->truncate();

        // Truncate the main Kelas table
        DB::table('kelas')->truncate();
        Kelas::truncate();
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return response()->json([
            'message' => 'kelas berhasil direset'
        ], 200);
    }
}
