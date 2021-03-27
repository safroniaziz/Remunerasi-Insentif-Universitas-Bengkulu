<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IsianRubrik extends Model
{
    protected $fillable = [
        'pengguna_rubrik_id','nomor_sk','periode_id','isian_1','isian_2','isian_3','isian_4','isian_5','isian_6','isian_7','isian_8','isian_9','isian_10','file_upload','status_validasi'
    ];
}
