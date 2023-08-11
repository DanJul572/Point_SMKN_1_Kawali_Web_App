<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    protected $table = 'penghargaan';
    protected $fillable = ['kode', 'deskripsi', 'nilai'];

    public function penebusan()
    {
        return $this->hasMany(Penebusan::class);
    }
}
