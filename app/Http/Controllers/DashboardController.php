<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login');
    }

    public function data()
    {
        $semester = DB::table('semester')->latest()->first();
        return [
            'card' => [
                'count_siswa' => DB::table('siswa')->count(),
                'count_guru' => DB::table('guru')->count(),
                'count_pengaduan' => DB::table('pengaduan')->where('status', false)->count(),
                'semester' => $semester->nama,
                'tahun_ajaran' => $semester->tahun_ajaran,
            ],
            'table' => $this->poinTertinggi(),
        ];
    }

    private function poinTertinggi()
    {
        $siswa_db = Siswa::all();
        if (count($siswa_db) == 0) {
            return [];
        } else {
            $array = [];
            foreach ($siswa_db as $siswa) {
                $array [] = [
                    'id' => $siswa->nama,
                    'nama' => $siswa->nama,
                    'nis' => $siswa->nis,
                    'kelas' => $siswa->tingkat->nama . '-' . $siswa->kelas->nama,
                    'total_poin' => $siswa->totalPoin(),
                ];
            }
            $collection = collect($array)->sortByDesc('total_poin');
            $collection->splice(20);
            return $collection->all();
        }
    }
}
