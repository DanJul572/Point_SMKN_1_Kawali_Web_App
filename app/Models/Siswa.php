<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['nama', 'nis', 'kode', 'tingkat_id', 'kelas_id'];

    public function poin()
    {
        return $this->belongsToMany(Poin::class)->withPivot(['semester_id']);
    }

    public function penebusan()
    {
        return $this->hasMany(Penebusan::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }

    public function user()
    {
        return $this->morphMany(Pengaduan::class, 'user');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    public function totalPoin()
    {
        $semester = DB::table('semester')->latest()->first();
        $total_poin = $this->poin->where('pivot.semester_id', $semester->id)->sum('nilai');
        return $total_poin - $this->totalPenebusan();
    }

    public function totalPenebusan()
    {
        $total_penebusan = 0;
        $semester = DB::table('semester')->latest()->first();
        foreach ($this->penebusan->where('semester_id', $semester->id) as $penebusan) {
            $total_penebusan += $penebusan->penghargaan->nilai;
        }
        return $total_penebusan;
    }

    public function totalPelanggaran()
    {
        $total_penebusan = 0;
        $semester = DB::table('semester')->latest()->first();
        return $this->poin->where('pivot.semester_id', $semester->id)->count();
    }

    public function sanksi()
    {
        foreach (DB::table('sanksi')->orderBy('minimal_poin', 'desc')->get() as $sanksi) {
            if ($this->totalPoin() >= $sanksi->minimal_poin) {
                return $sanksi;
            }
        }
    }

}
