<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login');
    }

    public function lists()
    {
        return Sanksi::orderBy('minimal_poin', 'asc')->get();
    }

    public function store(Request $request)
    {
        $sanksi = Sanksi::where('minimal_poin', $request->minimal_poin)->first();
        if ($sanksi != null) {
            return [
                'status' => 'ada'
            ];
        } else {
            $sanksi = Sanksi::create($request->all());
            return [
                'id' => $sanksi->id
            ];
        }
    }

    public function update(Request $request, Sanksi $sanksi)
    {
        $cek_sanksi = Sanksi::where('id', '!=', $sanksi->id)->where('minimal_poin', $request->minimal_poin)->first();
        if ($cek_sanksi != null) {
            return [
                'status' => 'sudah ada'
            ];
        } else {
            $sanksi->update($request->all());
        }
    }

    public function destroy(Sanksi $sanksi)
    {
        $sanksi->delete();
    }
}
