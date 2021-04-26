<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailIsianRubrik extends Model
{
    protected $fillable =[
        'isian_rubrik_id','nip','keterangan','rate_remun'
    ];

    public function isianrubrik()
    {
        return $this->belongsTo('App\IsianRubrik');
    }
}
