<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Operasi;
use App\Models\Semester;
use App\Models\Pengaduan;
use App\Events\ImageProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class OperasiController extends Controller
{
    public $semester_id = [];

    public function lists()
    {
        return Operasi::first();
    }

    public function ubahAksesUser()
    {
        $operasi = Operasi::first();
        if ($operasi->akses_user == false) {
            $operasi->update([
                'akses_user' => true,
            ]);
            return [
                'status' => true
            ];
        } else {
            $operasi->update([
                'akses_user' => false,
            ]);
            return [
                'status' => false
            ];
        }
    }

    public function naikanSemester()
    {
        $semester = DB::table('semester')->latest()->first();
        if ($semester->nama == 1) {
            Semester::create([
                'nama' => 2,
                'tahun_ajaran' => $semester->tahun_ajaran
            ]);
        } else {
            $tahun_ajaran_baru = (intval(substr($semester->tahun_ajaran, 5, 4))) . '-' . (intval(substr($semester->tahun_ajaran, 5, 4)) + 1);
            Semester::create([
                'nama' => 1,
                'tahun_ajaran' => $tahun_ajaran_baru
            ]);
            Siswa::where('tingkat_id', '!=', 4)->increment('tingkat_id', 1);
        }
    }

    public function bersihDataSiswa()
    {
        $tidak_terhapus = 0;
        $terhapus = 0;
        $rows = Siswa::where('tingkat_id', 4)->get();
        foreach ($rows as $row) {
            if (count($row->user) > 0) {
                $tidak_terhapus += 1;
            } else {
                foreach ($row->pengaduan as $pengaduan) {
                    event(new ImageProcess('', 'app/main/image/pengaduan/', $pengaduan->gambar, 'destroy'));
                }
                $row->penebusan()->delete();
                $row->pengaduan()->delete();
                $row->poin()->detach();
                $row->delete();
                $terhapus += 1;
            }
        }
        return [
            'tidak_terhapus' => $tidak_terhapus,
            'terhapus' => $terhapus,
        ];
    }

    public function bersihDataPengaduan()
    {
        $tidak_terhapus = 0;
        $terhapus = 0;
        $rows = Pengaduan::where('status', true)->get();
        foreach ($rows as $row) {
            event(new ImageProcess('', 'app/main/assets/image/pengaduan/', $row->gambar, 'destroy'));
            $row->delete();
            $terhapus += 1;
        }
        return [
            'tidak_terhapus' => $tidak_terhapus,
            'terhapus' => $terhapus,
        ];
    }

    public function getLaporan(Request $request)
    {
        $tehad = [];
        $tbody = [];
        if (strstr($request->value, '-')) {
            $semester = Semester::where('tahun_ajaran', $request->value)->get();
        } else {
            $semester = Semester::where('id', $request->value)->get();
        }
        if (count($semester) == 0) {
            return [
                'status' => 'laporan kosong'
            ];
        } else {
            foreach ($semester as $hasil) {
                $this->semester_id [] = $hasil->id;
            }
            if ($request->type == 'poin') {
                $title = 'Laporan Poin Siswa';
                $rows = Siswa::whereHas('poin', function (Builder $query) {
                    $query->whereIn('semester_id', $this->semester_id);
                })->with(['tingkat', 'kelas', 'poin' => function ($poin) {
                    $poin->whereIn('semester_id', $this->semester_id);
                }])->get();
                $tehad = [
                    ['field' => 'nama', 'label' => 'Nama', 'width' => '200px'],
                    ['field' => 'nis', 'label' => 'NIS', 'width' => '150px'],
                    ['field' => 'kelas', 'label' => 'Kelas', 'width' => '150px'],
                    ['field' => 'kode_poin', 'label' => 'Kode Poin', 'width' => '150px'],
                    ['field' => 'nilai_poin', 'label' => 'Nilai Poin', 'width' => '150px'],
                    ['field' => 'frekuensi', 'label' => 'Frekuensi', 'width' => '150px'],
                    ['field' => 'total_poin', 'label' => 'Total Poin', 'width' => '150px'],
                    ['field' => 'deskripsi_poin', 'label' => 'Deskripsi Poin', 'width' => '200px'],
                ];
                foreach ($rows as $siswa) {
                    foreach ($siswa->poin as $poin) {
                        $key = array_search($poin->kode, array_column($tbody, 'kode_poin'));
                        if (false !== $key) {
                            $tbody[$key]['frekuensi'] += 1;
                            $tbody[$key]['total_poin'] = $tbody[$key]['frekuensi'] * $tbody[$key]['nilai_poin'];
                        } else {
                            $tbody [] = [
                                'nama' => $siswa->nama,
                                'nis' => $siswa->nis,
                                'kelas' => $siswa->tingkat->nama . '-' . $siswa->kelas->nama,
                                'kode_poin' => $poin->kode,
                                'nilai_poin' => $poin->nilai,
                                'frekuensi' => 1,
                                'total_poin' => 1 * $poin->nilai,
                                'deskripsi_poin' => $poin->deskripsi
                            ];
                        }
                    }
                }
            } else {
                $title = 'Laporan Penebusan Siswa';
                $rows = Siswa::whereHas('penebusan', function (Builder $query) {
                    $query->with(['penghargaan']);
                    $query->whereIn('semester_id', $this->semester_id);
                })->with(['tingkat', 'kelas'])->get();
                $tehad = [
                    ['field' => 'nama', 'label' => 'Nama', 'width' => '200px'],
                    ['field' => 'nis', 'label' => 'NIS', 'width' => '150px'],
                    ['field' => 'kelas', 'label' => 'Kelas', 'width' => '150px'],
                    ['field' => 'kode_penghargaan', 'label' => 'Kode Penghargaan', 'width' => '150px'],
                    ['field' => 'nilai_penghargaan', 'label' => 'Nilai Penghargaan', 'width' => '150px'],
                    ['field' => 'frekuensi', 'label' => 'Frekuensi', 'width' => '150px'],
                    ['field' => 'total_penghargaan', 'label' => 'Total Penghargaan', 'width' => '150px'],
                    ['field' => 'deskripsi_penghargaan', 'label' => 'Deskripsi Penghargaan', 'width' => '200px'],
                ];
                foreach ($rows as $siswa) {
                    foreach ($siswa->penebusan as $penebusan) {
                        $key = array_search($penebusan->penghargaan->kode, array_column($tbody, 'kode_penghargaan'));
                        if (false !== $key) {
                            $tbody[$key]['frekuensi'] += 1;
                            $tbody[$key]['total_penghargaan'] = $tbody[$key]['frekuensi'] * $tbody[$key]['nilai_penghargaan'];
                        } else {
                            $tbody [] = [
                                'nama' => $siswa->nama,
                                'nis' => $siswa->nis,
                                'kelas' => $siswa->tingkat->nama . '-' . $siswa->kelas->nama,
                                'kode_penghargaan' => $penebusan->penghargaan->kode,
                                'nilai_penghargaan' => $penebusan->penghargaan->nilai,
                                'frekuensi' => 1,
                                'total_penghargaan' => 1 * $penebusan->penghargaan->nilai,
                                'deskripsi_penghargaan' => $penebusan->penghargaan->deskripsi
                            ];
                        }
                    }
                }
            }
        }
        return [
            'title' => $title,
            'thead' => $tehad,
            'tbody' => $tbody
        ];
    }
}
