<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\Customer;
use\App\Models\Plot;
use\App\Models\Token;
use\App\Models\Leads;
use App\Models\FinancialYear;
use App\Models\FinancialYearDetail;

use App\Models\User;
use Config;
use Auth;

use TCG\Voyager\Facades\Voyager;

class TokenController extends Controller
{
    
    public function index()
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $tokens = Token::with('customers','plots')->get();
       
        return view('token.record',compact('tokens','dataType'));
    }


    public function create()
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $years = FinancialYear::get();
        $plots = Plot::where('is_booked','0')->get();
        $customers = Leads::where('status','Token Leads')->get();
        return view('token.create',compact('dataType','years','plots','customers'));
    }

  
    public function store(Request $request)
    {
        // dd($request->all());
        $new = array_merge($request->all() + ['created_by' =>  Auth::user()->id , 'status' => 1]);
        $customer = Token::create($request->all());

        $plot =  Plot::where('id',$request->plot_id)->first()->name;
        $plot_status =  Plot::where('id',$request->plot_id)->first();
        $plot_status->status = 'Token';
        $plot_status->save();
        $customer =  Leads::where('id',$request->customer_id)->first();
       
        $customer->status = @config::get('app.lead_status')['voyager-phone-04'];
        $mobile = $customer->phone;
        $message = "Mr . ".$customer->name." You have given token of ".$request->amount." against Plot (".$plot."). Its expiry date is ".$request->expriry_date;
        $path = '/admin/tokens/record'; 
        $return_message = 'Token has been created successfully';
        $customer->save();
     
        return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);
        
    }

  
    public function show($id)
    {
        // dd($id);
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $customer = Token::where('id',$id)->first();
        $customers = Leads::where('status','Token Leads')->get();
        return view('customers.record',compact('dataType','customer','customers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $token = Token::where('id',$id)->first();

        $years = FinancialYear::get();
        $plots = Plot::where('is_booked','0')->get();
        $customers = Leads::where('status','Token Leads')->get();
        return view('token.create',compact('dataType','token','years','plots','customers'));
    }

  
    public function update(Request $request, $id)
    {
    //    dd($request->all());
        $customer = Token::where('id',$id)->update($request->all());

        return redirect('/admin/tokens/record')->with('message','Token has been Updated ... !');
    }

    public function destroy($id)
    {
        Token::where('id',$id)->delete();
        return redirect('/admin/tokens/record')->with('message','Token has been Deleted ... !');
    }
    public function OfficPrice($id){
        // return $id;
        $office_price = Plot::where('id',$id)->select('price')->first();
        return  $office_price;
    }
}
