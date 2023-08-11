<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poin extends Model
{
    protected $table = 'poin';
    protected $fillable = ['kode', 'deskripsi', 'nilai'];

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class);
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
