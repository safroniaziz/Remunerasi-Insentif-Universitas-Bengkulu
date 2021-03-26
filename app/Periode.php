<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = [
        'masa_kinerja','periode_pembayaran','status'
    ];
}
