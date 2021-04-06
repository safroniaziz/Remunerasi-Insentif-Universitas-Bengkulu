<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DetailIsianRubrik;
use App\IsianRubrik;

class DetailRubrikController extends Controller
{
    public function index($id){
        $data['isian']=collect(IsianRubrik::findorfail($id))->toArray();
        $data['isian_rubrik']=IsianRubrik::findorfail($id);
        $data['rubriks']=collect($data['isian_rubrik']->rubrik)->toArray();
        $data['detail_rubriks']=DetailIsianRubrik::where('isian_rubrik_id',$id)->get();
        return view('operator.data_remun.detailrubrik',$data);
    }

    public function store(Request $request,$id){
        $this->validate($request,[
            'rate_remun'   =>  'required',
            'nip'   =>  'required',
            'keterangan'   =>  'required',
        ]);
        DetailIsianRubrik::create([
            'isian_rubrik_id'=> $id,
            'nip' => $request->nip,
            'rate_remun'=> $request->rate_remun,
            'keterangan'=>nl2br($request->keterangan),
        ]);
        return redirect()->route('operator.detailrubrik',$id)->with(['success' =>  'Data Detail isian rubrik berhasil ditambahkan']);
    }

    public function destroy(Request $request,$id){
        DetailIsianRubrik::where('id',$request->id_detail_rubrik)->delete();
        return redirect()->route('operator.detailrubrik',$id)->with(['success' =>  'Data Detail isian rubrik berhasil dihapus']);
    }
}
