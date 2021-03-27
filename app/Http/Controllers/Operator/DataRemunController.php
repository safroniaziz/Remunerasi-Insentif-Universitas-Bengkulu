<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Rubrik;
use App\IsianRubrik;
use App\Periode;
use App\Unit;

class DataRemunController extends Controller
{
    public function index(){
        $data['rubriks']=Rubrik::all();
        $data['isian_rubriks']=IsianRubrik::all();
        $data['periodes']=Periode::all();
        $data['units']=Unit::all();
        return view('operator.data_remun.dataremun',$data);
    }
    public function store(Request $request){
        $this->validate($request,[
            'id_rubrik'   =>  'required',
            'no_sk'   =>  'required',
            'id_periode'   =>  'required',
        ]);
        $nama_file=null;
        if ($request->hasFile('file_isian')){
            $nama_file=$request->id_rubrik.'-'.date("Y-m-d").'-'.uniqid().'-'.$request->id_periode.'.'.$request->file_isian->getClientOriginalExtension();
            $request->file('file_isian')->storeAs('',$nama_file,"folder_public");
            $request->file('file_isian')->storeAs('',$nama_file,"google");
        }
        IsianRubrik::create([
            'pengguna_rubrik_id'       =>  $request->id_rubrik,
            'nomor_sk'       =>  $request->no_sk,
            'periode_id'       =>  $request->id_periode,
            'file_upload'       =>  $nama_file,
            'status_validasi'       =>  "nonaktif",
        ]);
        return redirect()->route('operator.dataremun')->with(['success' =>  'Data isian rubrik berhasil ditambahkan']);
    }

    public function status(Request $request,$id){
        IsianRubrik::where('id',$id)->update([
            'status_validasi'=>'aktif',
        ]);
        return redirect()->route('operator.dataremun')->with(['success' =>  'Data isian rubrik berhasil dikirim']);
    }

    public function tambah_isian(Request $request){
        IsianRubrik::where('id',$request->isian_id)->update([
            'isian_1'=>$request->isian,
        ]);
        return redirect()->route('operator.dataremun')->with(['success' =>  'isian rubrik berhasil ditambahkan']);
    }

    public function destroy($id){
        IsianRubrik::where('id',$id)->delete();
        return redirect()->route('operator.dataremun')->with(['success' =>  'Data berhasil dihapus']);
    }
}
