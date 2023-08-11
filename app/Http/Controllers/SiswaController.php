<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Semester;
use App\Events\ImageProcess;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;

class SiswaController extends Controller
{
    public $semester_id;

    public function __construct()
    {
        $this->middleware('admin.tidak.login')->except(['search', 'ubahKode']);
    }

    public function lists(Request $request)
    {
        return Siswa::with(['tingkat', 'kelas'])
        ->where('tingkat_id', $request->tingkat_id)
        ->where('kelas_id', $request->kelas_id)
        ->get();
    }

    public function store(Request $request)
    {
        $cek_siswa = Siswa::where('nis', $request->nis)->first();
        if ($cek_siswa != null) {
            return [
                'status' => 'sudah ada'
            ];
        } else {
            $siswa = Siswa::create([
                'nama' => $request->nama,
                'nis' => $request->nis,
                'tingkat_id' => $request->tingkat_id,
                'kelas_id' => $request->kelas_id,
                'kode' => 'kodesaya'
            ]);
            return $siswa->id;
        }
    }

    public function ubahKode(Request $request, Siswa $siswa)
    {
        $siswa->update(['kode' => $request->kode]);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $cek_siswa = Siswa::where('id', '!=', $siswa->id)->where('nis', $request->nis)->first();
        if ($cek_siswa != null) {
            return [
                'status' => 'sudah ada'
            ];
        } else {
            $siswa->update($request->all());
        }
    }

    public function search(Request $request)
    {
        return Siswa::with(['kelas', 'tingkat'])
        ->where('nama', 'like', '%' . $request->keyword . '%')
        ->orWhere('nis', 'like', '%' . $request->keyword . '%')
        ->get();
    }

    public function poin(Request $request)
    {
        $rows = [];
        $this->semester_id = Semester::latest()->first()->id;
        $siswa = Siswa::whereHas('poin', function (Builder $query) {
            $query->where('semester_id', $this->semester_id);
        })
        ->where('tingkat_id', $request->tingkat_id)
        ->where('kelas_id', $request->kelas_id)
        ->with(['tingkat', 'kelas', 'poin'])->get();
        foreach ($siswa as $hasil) {
            $hasil->total_poin = $hasil->totalPoin();
            $hasil->total_penebusan = $hasil->totalPenebusan();
            $hasil->sanksi = $hasil->sanksi();
            $rows [] = $hasil;
        }
        return $rows;
    }

    public function penebusan(Request $request)
    {
        $rows = [];
        $this->semester_id = Semester::latest()->first()->id;
        $siswa = Siswa::whereHas('poin', function (Builder $query) {
            $query->where('semester_id', $this->semester_id);
        })->with(['tingkat', 'kelas', 'penebusan' => function ($penebusan) {
            $penebusan->where('semester_id', $this->semester_id);
        }])
        ->where('tingkat_id', $request->tingkat_id)
        ->where('kelas_id', $request->kelas_id)
        ->get();
        foreach ($siswa as $hasil) {
            $hasil->total_poin = $hasil->totalPoin();
            $hasil->total_penebusan = $hasil->totalPenebusan();
            $hasil->sanksi = $hasil->sanksi();
            $rows [] = $hasil;
        }
        return $rows;
    }

    public function destroy(Siswa $siswa)
    {
        if (count($siswa->user) > 0) {
            return [
                'status' => 'relasi tersedia'
            ];
        } else {
            foreach ($siswa->pengaduan as $pengaduan) {
                event(new ImageProcess('', 'app/main/image/pengaduan/', $pengaduan->gambar, 'destroy'));
            }
            $siswa->penebusan()->delete();
            $siswa->pengaduan()->delete();
            $siswa->poin()->detach();
            $siswa->delete();
        }
    }

    public function hapusBanyak(Request $request)
    {
        $tidak_terhapus = [];
        $terhapus = [];
        foreach ($request->id as $id) {
            $siswa = Siswa::find($id);
            if (count($siswa->user) > 0) {
                $tidak_terhapus [] = $id;
            } else {
                foreach ($siswa->pengaduan as $pengaduan) {
                    event(new ImageProcess('', 'app/main/image/pengaduan/', $pengaduan->gambar, 'destroy'));
                }
                $siswa->penebusan()->delete();
                $siswa->pengaduan()->delete();
                $siswa->poin()->detach();
                $siswa->delete();
                $terhapus [] = $id;
            }
        }
        return [
            'tidak_terhapus' => $tidak_terhapus,
            'terhapus' => $terhapus,
        ];
    }

    public function import() 
    {
        Excel::import(new SiswaImport, request()->file('siswa'));
        return redirect()->route('siswa.index');
    }

    public function form()
    {
        return [
            'tingkat' => DB::table('tingkat')->orderBy('nama', 'asc')->get(),
            'kelas' => DB::table('kelas')->orderBy('nama', 'asc')->get(),
        ];
    }
}
