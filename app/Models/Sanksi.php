<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    protected $table = 'sanksi';
    protected $fillable = ['minimal_poin', 'keterangan'];
}
