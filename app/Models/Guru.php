<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $fillable = ['nama', 'nip', 'kode'];

    public function user()
    {
        return $this->morphMany(Pengaduan::class, 'user');
    }

    public function pengaduan()
    {
        return $this->morphMany(Pengaduan::class, 'user');
    }
}
