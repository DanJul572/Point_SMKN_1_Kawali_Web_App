<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $fillable = ['poin_id', 'siswa_id', 'user_id', 'user_type', 'status', 'gambar'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function poin()
    {
        return $this->belongsTo(Poin::class);
    }

    public function user()
    {
        return $this->morphTo();
    }
}
