<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index(){
        $periodes = Periode::all();
        return view('admin/periode.index',compact('periodes'));
    }

    public function post(Request $request){
        $this->validate($request,[
            'masa_kinerja'   =>  'required',
            'periode_pembayaran'   =>  'required',
        ]);

        Periode::create([
            'masa_kinerja'       =>  $request->masa_kinerja,
            'periode_pembayaran'       =>  $request->periode_pembayaran,
            'status'       =>  'nonaktif'
        ]);

        return redirect()->route('admin.periode')->with(['success' =>  'periode berhasil ditambahkan']);
    }
    public function nonaktifkanStatus($id){
        Periode::where('id',$id)->update([
            'status'    =>  'nonaktif'
        ]);
        return redirect()->route('admin.periode')->with(['success' =>  'Periode Berhasil Di Nonaktifkan !!']);
    }

    public function aktifkanStatus($id){
        Periode::where('id',$id)->update([
            'status'    =>  'aktif'
        ]);
        Periode::where('id','!=',$id)->update([
            'status'    =>  'nonaktif'
        ]);
        return redirect()->route('admin.periode')->with(['success' =>  'Periode Berhasil Di Aktifkan !!']);
    }

    public function delete(Request $request){
        $periode = Periode::find($request->id);
        Periode::where('id',$request->id)->delete();
        return redirect()->route('admin.periode')->with(['success'   =>  'periode berhasil dihapus']);
    }
}
