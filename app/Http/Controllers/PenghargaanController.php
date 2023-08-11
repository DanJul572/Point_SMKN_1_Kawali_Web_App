<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use Illuminate\Http\Request;

class PenghargaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login')->except(['search', 'cek']);    
    }

    public function lists()
    {
        return Penghargaan::all();
    }

    public function search(Request $request)
    {
        return Penghargaan::where('kode', 'like', '%' . $request->keyword . '%')->orWhere('deskripsi', 'like', '%' . $request->keyword . '%')->get();
    }

    public function store(Request $request)
    {
        $penghargaan = Penghargaan::where('kode', $request->kode)->first();
        if ($penghargaan != null) {
            return [
                'status' => 'ada'
            ];
        } else {
            $penghargaan = Penghargaan::create($request->all());
            return [
                'id' => $penghargaan->id
            ];
        }
    }

    public function update(Request $request, Penghargaan $penghargaan)
    {
        $cek_penghargaan = Penghargaan::where('id', '!=', $penghargaan->id)->where('kode', $request->kode)->first();
        if ($cek_penghargaan != null) {
            return [
                'status' => 'sudah ada'
            ];
        } else {
            $penghargaan->update($request->all());
        }
    }

    public function destroy(Penghargaan $penghargaan)
    {
        if (count($penghargaan->penebusan) > 0) {
            return [
                'status' => 'relasi tersedia'
            ];
        } else {
            $penghargaan->delete();
        }
    }
}
