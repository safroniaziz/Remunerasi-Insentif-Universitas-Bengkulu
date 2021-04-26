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
        $data['data_rubriks']=Rubrik::all();
        $data['rubriks']=Rubrik::has('isianrubrik')->get();
        $data['periodes']=Periode::where('status','aktif')->get();
        return view('operator.data_remun.dataremun',$data);

    }
    public function store(Request $request){
        $this->validate($request,[
            'id_rubrik'   =>  'required',
            'no_sk'   =>  'required',
            'id_periode'   =>  'required',
            'file' => 'required|max:10000|mimes:doc,docx',
        ],[
            'required' => 'Data tidak boleh kosong'
        ]);
        // $nama_file=null;
        // if ($request->hasFile('file_isian')){
        //     $nama_file=$request->id_rubrik.'-'.date("Y-m-d").'-'.uniqid().'-'.$request->id_periode.'.'.$request->file_isian->getClientOriginalExtension();
        //     $request->file('file_isian')->storeAs('',$nama_file,"google");
        //     $file = collect(Storage::cloud()->listContents('', false))
        //         ->where('type', '=', 'file')
        //         ->where('filename', '=', pathinfo($nama_file, PATHINFO_FILENAME))
        //         ->where('extension', '=', pathinfo($nama_file, PATHINFO_EXTENSION))
        //         ->sortBy('timestamp')
        //         ->last();
        // }
        $isian_kolom=array_combine($request->isian_angka,$request->nama_kolom);
        $isian_rubrik=array(
            'rubrik_id'       =>  $request->id_rubrik,
            'nomor_sk'       =>  $request->no_sk,
            'periode_id'       =>  $request->id_periode,
            'file_upload'       =>  $request->id_file,
            'status_validasi'       =>  "nonaktif",
        );
        $data=array_merge($isian_rubrik,$isian_kolom);
        IsianRubrik::create($data);
        return redirect()->route('operator.dataremun')->with(['success' =>  'Data isian rubrik berhasil ditambahkan']);
    }

    public function status($id){
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
        $data=IsianRubrik::findorfail($id);
        Storage::cloud()->delete($data->file_upload);
        $data->delete();
        return redirect()->route('operator.dataremun')->with(['success' =>  'Data berhasil dihapus']);
    }

    public function download($fileid){
        $file = collect(Storage::cloud()->listContents('', false))
                ->where('type', '=', 'file')
                ->where('path', '=', pathinfo($fileid, PATHINFO_FILENAME))
                ->last();
        $response=Storage::cloud()->download($fileid,$file['name']);
        $response->send();
    }

    public function kolom_rubrik(Request $request){
        $data=Rubrik::find($request->id);
        return response()->json($data, 200);
    }
    public function hapus_file(Request $request){
        json_encode($request);
        $cek=Storage::cloud()->delete($request->id);
        return response()->json($request->id, 200);
    }
    public function upload(Request $request){
        $this->validate($request,[
            'file_isian' => 'required|max : 100|mimes:pdf,jpeg',
        ],[
            'required' => 'Data tidak boleh kosong',
            'mimes'=> 'file harus tipe :values'
        ]);
        if ($request->hasFile('file_isian')){
            $nama_file=date("Y-m-d").'-'.uniqid().'-'.$request->file_isian->getClientOriginalName();
            $request->file('file_isian')->storeAs('',$nama_file,"google");
            $file = collect(Storage::cloud()->listContents('', false))
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($nama_file, PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($nama_file, PATHINFO_EXTENSION))
                ->sortBy('timestamp')
                ->last();
        }
        return response()->json(['id'=>$file['path'],'file_drive'=>$file['name'],'file_asli'=>$request->file_isian->getClientOriginalName()]);
    }

    public function edit($id){
        $data['data_rubriks']=Rubrik::all();
        $data['rubriks']=Rubrik::has('isianrubrik')->get();
        $data['periodes']=Periode::where('status','aktif')->get();
        $data['data']=IsianRubrik::where('id',$id)->first();
        return view('operator.data_remun.edit_dataremun',$data);
    }

    public function update($id,Request $request){

    }
}
