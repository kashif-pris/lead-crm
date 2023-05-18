<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class ChartOfAccountController extends Controller
{
    public function create(){
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        return view('accounts.create',compact('dataType'));
    }


    public function record(){
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        return view('accounts.record',compact('dataType'));
    }
}
