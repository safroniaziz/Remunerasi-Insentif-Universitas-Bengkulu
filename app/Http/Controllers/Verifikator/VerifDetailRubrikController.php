<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DetailIsianRubrik;
use App\IsianRubrik;

class VerifDetailRubrikController extends Controller
{
    public function index($id){
        $data['isian_rubrik']=IsianRubrik::findorfail($id);
        $data['detail_rubriks']=DetailIsianRubrik::where('isian_rubrik_id',$id)->get();
        return view('verifikator.data_remun.verifdetailrubrik',$data);
    }
}
