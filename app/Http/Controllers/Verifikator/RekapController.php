<?php

namespace App\Http\Controllers\verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rekapitulasi;

class RekapController extends Controller
{
    public function index(){
        $data['rekapitulasi']=Rekapitulasi::all();
        return view('verifikator.rekap_data.rekap_data',$data);
    }
}
