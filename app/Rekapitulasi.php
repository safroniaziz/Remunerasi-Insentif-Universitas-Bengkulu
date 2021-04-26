<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekapitulasi extends Model
{
    public function periode()
    {
        return $this->belongsTo('App\Periode');
    }
}
