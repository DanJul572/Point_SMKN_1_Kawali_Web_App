<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penebusan extends Model
{
    protected $table = 'penebusan';
    protected $fillable = ['siswa_id', 'penghargaan_id', 'semester_id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function penghargaan()
    {
        return $this->belongsTo(Penghargaan::class);
    }
}
