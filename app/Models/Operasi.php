<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operasi extends Model
{
    protected $table = 'operasi';
    protected $fillable = ['akses_user'];
}
