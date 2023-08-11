<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Semester;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class UserController extends Controller
{
    public function data ()
    {
        $siswa = Siswa::find(session('user')['id']);
        $rows_poin = [];
        foreach ($siswa->poin->where('pivot.semester_id', Semester::latest()->first()->id) as $poin) {
            $rows_poin [] = $poin;
        }
        return [
            'card' => [
                'total_poin' => $siswa->totalPoin(),
                'total_penebusan' => $siswa->totalPenebusan(),
                'total_pelanggaran' => $siswa->totalPelanggaran(),
            ],
            'table' => $rows_poin
        ];
    }

    public function login(Request $request)
    {
        $guru = Guru::where('nip', $request->identitas)->where('kode', $request->kode)->first();
        $siswa = Siswa::where('nis', $request->identitas)->where('kode', $request->kode)->first();
        if (($guru == null) && ($siswa == null)) {
            Toastr::error('NIS atau Kode Salah.', '', $this->toastrOptions());
            return redirect()->route('user.login');
        } else if (($guru != null) && ($siswa == null)) {
            session()->put('user', [
                'id' => $guru->id,
                'nama' => $guru->nama,
                'kode' => $guru->kode,
                'status' => 'guru',
            ]);
            return redirect()->route('pengaduan.create');
        } else if (($guru == null) && ($siswa != null)) {
            session()->put('user', [
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'kode' => $siswa->kode,
                'status' => 'siswa',
            ]);
            return redirect()->route('dashboard.user');
        }
    }

    public function logout()
    {
        session()->forget('user');
        Toastr::success('Anda berhasil logout', '', $this->toastrOptions());
        return redirect()->route('user.login')->with('message', 'Anda berhasil logout.');
    }

    public function ubahKode(Request $request)
    {
        session()->forget('user');
        if ($request->status == 'guru') {
            $user = Guru::find($request->id);
            $status = 'guru';
        } else {
            $user = Siswa::find($request->id);
            $status = 'siswa';
        }
        $user->update([
            'kode' => $request->kode
        ]);
        session()->put('user', [
            'id' => $user->id,
            'nama' => $user->nama,
            'kode' => $user->kode,
            'status' => $status,
        ]);
    }

    private function toastrOptions ()
    {
        return [
            "closeButton" => false,
            "debug" => false,
            "newestOnTop" => false,
            "progressBar" => false,
            "positionClass" => "toast-top-right",
            "preventDuplicates" => false,
            "onclick" => null,
            "showDuration" => "300",
            "hideDuration" => "1000",
            "timeOut" => "5000",
            "extendedTimeOut" => "1000",
            "showEasing" => "swing",
            "hideEasing" => "linear",
            "showMethod" => "fadeIn",
            "hideMethod" => "fadeOut"
        ];
    }
}
