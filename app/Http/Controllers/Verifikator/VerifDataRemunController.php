<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Rubrik;
use App\IsianRubrik;
use App\Periode;
use App\Unit;

class VerifDataRemunController extends Controller
{
    public function index(){
        $data['data_rubriks']=Rubrik::all();
        $data['rubriks']=Rubrik::has('isianrubrik')->get();
        $data['periodes']=Periode::where('status','aktif')->get();
        $data['units']=Unit::all();
        return view('verifikator.data_remun.dataremunisasi',$data);
    }
    public function verifikasi($id,Request $request){
        if($request->status=='ditolak'){
            IsianRubrik::where('id',$id)->update([
                'status_validasi'=>'ditolak',
            ]);
        }
        else{
            IsianRubrik::where('id',$id)->update([
                'status_validasi'=>'terverifikasi',
            ]);
        }
        return redirect()->route('verifikator.dataremun')->with(['success' =>  'Data isian rubrik berhasil dikirim']);
    }
}
