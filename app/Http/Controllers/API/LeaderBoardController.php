<?php

namespace App\Http\Controllers\API;

use App\Models\Praktikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LeaderBoardController extends Controller
{
    private function getLeaderboardData($kelasId = null)
    {
        $query = DB::table('praktikans')
            ->leftJoin('nilais', 'praktikans.id', '=', 'nilais.praktikan_id')
            ->leftJoin('kelas', 'praktikans.kelas_id', '=', 'kelas.id')
            ->select(
                'praktikans.id',
                'praktikans.nama',
                'praktikans.nim',
                'kelas.kelas',
                DB::raw('AVG(nilais.avg) as average_nilai')
            )
            ->groupBy('praktikans.id', 'praktikans.nama', 'praktikans.nim', 'kelas.kelas')
            ->orderBy('average_nilai', 'desc');
        if ($kelasId) {
            $query->where('praktikans.kelas_id', $kelasId);
        }
        return $query->get();
    }

    public function index()
    {
        $leaderboard = $this->getLeaderboardData();
        return response()->json([
            'status' => 'success',
            'leaderboard' => $leaderboard,
            'message' => 'Leaderboard retrieved successfully.'
        ], 200);
    }

    public function show($id)
    {
        $leaderboard = $this->getLeaderboardData($id);
        // Check if leaderboard is empty
        if ($leaderboard->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada data untuk kelas dengan ID ini.',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'leaderboard' => $leaderboard,
            'message' => 'Leaderboard retrieved successfully.'
        ], 200);
    }
}
