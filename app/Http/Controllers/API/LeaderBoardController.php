<?php

namespace App\Http\Controllers\API;

use App\Models\Praktikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LeaderBoardController extends Controller
{
    public function index()
    {
       $leaderboard =  DB::table('praktikans')
        ->leftJoin('nilais', 'praktikans.id', '=', 'nilais.praktikan_id')
        ->leftJoin('kelas', 'praktikans.kelas_id', '=', 'kelas.id')
        ->select('praktikans.id', 'praktikans.nama', 'praktikans.nim', 'kelas.kelas', DB::raw('AVG(nilais.avg) as average_nilai'))
        ->groupBy('praktikans.id', 'praktikans.nama')
        ->orderBy('average_nilai', 'desc')
        ->get();
        return response()->json([
            'leaderboard' => $leaderboard
        ]);
    }

    public function show($id)
    {
        $leaderboard =  DB::table('praktikans')
        ->leftJoin('nilais', 'praktikans.id', '=', 'nilais.praktikan_id')
        ->leftJoin('kelas', 'praktikans.kelas_id', '=', 'kelas.id')
        ->select('praktikans.id', 'praktikans.nama', 'praktikans.nim', 'kelas.kelas', DB::raw('AVG(nilais.avg) as average_nilai'))
        ->where('praktikans.kelas_id', $id)
        ->groupBy('praktikans.id', 'praktikans.nama')
        ->orderBy('average_nilai', 'desc')
        ->get();
        return response()->json([
            'leaderboard' => $leaderboard
        ]);
    }
}
