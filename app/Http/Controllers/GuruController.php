<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Imports\GuruImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login');
    }

    public function lists()
    {
        return Guru::orderBy('nama', 'asc')->get();
    }

    public function store(Request $request)
    {
        $guru = Guru::where('nip', $request->nip)->first();
        if ($guru != null) {
            return [
                'status' => 'ada'
            ];
        } else {
            $guru = Guru::create([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'kode' => 'kodesaya'
            ]);
            return [
                'id' => $guru->id
            ];
        }
    }

    public function update(Request $request, Guru $guru)
    {
        $cek_guru = Guru::where('id', '!=', $guru->id)->where('nip', $request->nip)->first();
        if ($cek_guru != null) {
            return [
                'status' => 'sudah ada'
            ];
        } else {
            $guru->update($request->all());
        }
    }

    public function ubahKode(Request $request, Guru $guru)
    {
        $guru->update(['kode' => $request->kode]);
    }

    public function import(Request $request) 
    {
        Excel::import(new GuruImport, $request->guru);
        return redirect()->route('guru.index');
    }

    public function destroy(Guru $guru)
    {
        if (count($guru->pengaduan) > 0) {
            return [
                'status' => 'relasi tersedia'
            ];
        } else {
            $guru->delete();
        }
    }
}
