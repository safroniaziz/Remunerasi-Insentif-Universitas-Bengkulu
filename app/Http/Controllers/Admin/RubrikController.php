<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rubrik;
use Illuminate\Http\Request;

class RubrikController extends Controller
{
    public function index(){
        $rubriks = Rubrik::all();
        return view('admin/rubrik.index',compact('rubriks'));
    }
}
