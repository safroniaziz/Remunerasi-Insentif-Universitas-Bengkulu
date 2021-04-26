<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = [
        'masa_kinerja','periode_pembayaran','status'
    ];

    public function isianrubrik()
    {
        return $this->hasOne('App\IsianRubrik');
    }
    public function rekapitulasi(){
        return $this->hasMany('App\Rekapitulasi');
    }
}
