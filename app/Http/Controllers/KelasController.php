<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login');
    }

    public function lists()
    {
        return Kelas::orderBy('nama', 'asc')->get();
    }

    public function store(Request $request)
    {
        $cek_kelas = Kelas::where('nama', strtoupper($request->nama))->first();
        if ($cek_kelas != null) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $kelas = Kelas::create([
                'nama' => strtoupper($request->nama)
            ]);
            return $kelas->id;
        }
    }

    public function update(Request $request, Kelas $kelas)
    {
        $cek_kelas = Kelas::where('id', '!=', $kelas->id)->where('nama', strtoupper($request->nama))->first();
        if ($cek_kelas != null) {
            return [
                'status' => 'tersedia'
            ];
        } else {
            $kelas->update($request->all());
        }
    }

    public function destroy(Kelas $kelas)
    {
        if (count($kelas->siswa) > 0) {
            return [
                'status' => 'relasi tersedia'
            ];
        } else {
            $kelas->delete();
        }
    }
}
