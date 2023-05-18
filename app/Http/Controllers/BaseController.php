<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leads;
use Auth;

class BaseController extends Controller
{
    public function add_leads(Request $request)
{
    $validated = $request->validate([
    
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'project_name' => 'required',
        'city' => 'required',
        'status' => 'required',
        'description' => 'required',
        'source' => 'required',
        'response' => 'required',
        'partner' => 'required',


    ]);

    if($request->status == ''){
        $status = 'New Leads';
    }else{
        $status = $request->status;
    }
    $full_number = $request->phone_number;
    $customer = Leads::create([

        'name' => $request->name,
        'email' => $request->email,
        'phone' => $full_number,
        'project_name' => $request->project_name,
        'city' => $request->city,
        'status' => $status,
        'description' => $request->description,
        'allocated_to' => $request->allocate_to,
        'source' => $request->source,
        'response' => $request->response,
        'created_by' => Auth::user()->id,
        'partner' => $request->partner,
    ]);
    return  $customer;

}
}
