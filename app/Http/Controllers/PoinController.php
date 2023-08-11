<?php

namespace App\Http\Controllers;

use App\Models\Poin;
use App\Models\Siswa;
use App\Models\Semester;
use Illuminate\Http\Request;

class PoinController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login')->except(['search', 'cek']);    
    }

    public function lists()
    {
        return Poin::all();
    }

    public function search(Request $request)
    {
        return Poin::where('kode', 'like', '%' . $request->keyword . '%')->orWhere('deskripsi', 'like', '%' . $request->keyword . '%')->get();
    }

    public function store(Request $request)
    {
        $poin = Poin::where('kode', $request->kode)->first();
        if ($poin != null) {
            return [
                'status' => 'ada'
            ];
        } else {
            $poin = Poin::create($request->all());
            return [
                'id' => $poin->id
            ];
        }
    }

    public function update(Request $request, Poin $poin)
    {
        $cek_poin = Poin::where('id', '!=', $poin->id)->where('kode', $request->kode)->first();
        if ($cek_poin != null) {
            return [
                'status' => 'sudah ada'
            ];
        } else {
            $poin->update($request->all());
        }
    }

    public function destroy(poin $poin)
    {
        if ((count($poin->siswa) > 0) || (count($poin->pengaduan) > 0)) {
            return [
                'status' => 'relasi tersedia'
            ];
        } else {
            $poin->delete();
        }
    }

    public function siswa(Request $request)
    {
        $siswa = Siswa::find($request->siswa_id);
        $semester = Semester::latest()->first();
        $siswa->poin()->attach([
            [
                'poin_id' => $request->poin_id,
                'semester_id' => $semester->id,
            ],
        ]);
    }

    public function cek(Request $request)
    {
        $siswa = Siswa::where('nis', $request->nis)->first();
        if ($siswa == null) {
            return [
                'status' => 'tidak ada'
            ];
        } else {
            return [
                'nama' => $siswa->nama,
                'total_poin' => $siswa->totalPoin()
            ];
        }
    }
}
