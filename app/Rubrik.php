<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubrik extends Model
{
    public function isianrubrik(){
        return $this->hasMany('App\IsianRubrik');
    }
}
