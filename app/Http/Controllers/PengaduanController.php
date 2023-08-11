<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use App\Events\ImageProcess;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.tidak.login')->except(['store']);
    }

    public function lists()
    {
        return Pengaduan::with(['user', 'poin', 'siswa' => function ($query) {
            $query->with(['tingkat', 'kelas'])->get();
        }])->latest()->get();
    }

    public function store(Request $request)
    {
        $file_name = Str::random() . '.jpg';
        event(new ImageProcess($request->form['gambar'], 'app/main/image/pengaduan/', $file_name, 'put'));
        if ($request->user['status'] == 'guru') {
            $user = Guru::find($request->user['id']);
        } else {
            $user = Siswa::find($request->user['id']);
        }
        $user->user()->create([
            'poin_id' => $request->form['poin']['id'],
            'siswa_id' => $request->form['siswa']['id'],
            'gambar' => $file_name,
            'status' => false
        ]);
    }

    public function konfirmasi(Pengaduan $pengaduan)
    {
        $pengaduan->update(['status' => true]);
        $siswa = Siswa::find($pengaduan->siswa_id);
        $semester = Semester::latest()->first();
        $siswa->poin()->attach([
            [
                'poin_id' => $pengaduan->poin_id,
                'semester_id' => $semester->id,
            ],
        ]);
    }

    public function destroy(Pengaduan $pengaduan)
    {
        event(new ImageProcess('', 'app/main/image/pengaduan/', $pengaduan->gambar, 'destroy'));
        $pengaduan->delete();
    }
}
