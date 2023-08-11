<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Semester;
use App\Models\Penghargaan;
use Illuminate\Http\Request;

class PenebusanController extends Controller
{
    public function siswa(Request $request)
    {
        $siswa = Siswa::find($request->siswa_id);
        $penghargaan = Penghargaan::find($request->penghargaan_id);
        $semester = Semester::latest()->first();
        if ($penghargaan->nilai >= $siswa->totalPoin()) {
            $siswa->poin()->detach();
            $siswa->penebusan()->delete();
            return [
                'status' => 'hapus'
            ];
        } else {
            $siswa->penebusan()->create([
                'penghargaan_id' => $request->penghargaan_id,
                'frekuensi' => 1,
                'semester_id' => $semester->id,
            ]);
            return [
                'status' => 'ubah'
            ];
        }
    }
}
