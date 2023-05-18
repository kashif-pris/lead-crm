<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Models\Customer;
use\App\Models\Visitor;
use\App\Models\CustomerDetail;
use\App\Models\Leads;
use TCG\Voyager\Facades\Voyager;

class CustomerController extends Controller
{
    
    public function index()
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $customers = Customer::get();
        return view('customers.record',compact('customers','dataType'));
    }


    public function create()
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $Visitors = Visitor::all();
        // dd($Visitors);
        return view('customers.create',compact('dataType','Visitors'));
    }

  
    public function store(Request $request)
    {
        //  dd($request->all());
        $customer = Customer::create([
            'GroupId' => 1  ,
            'CompanyId' => 8 ,
            'sal_cust_cat_id' => null   ,
            'sal_customer_name' => $request->name   ,
            'sal_customer_cnic' => $request->cnic   ,
            'sal_customer_cont_person' => $request->nickname   ,
            'sal_customer_desig' => null  ,
            'sal_customer_cc_to' => null   ,
            'sal_customer_address_1' => $request->address_1   ,
            'sal_customer_address_2' => $request->address_2   ,
            'sal_customer_country' => $request->Country   ,
            'sal_customer_city' => $request->city   ,
            'sal_customer_stateprov' => $request->province   ,
            'sal_customer_postalcode' => $request->postal_code   ,
            'sal_customer_voice' => null   ,
            'sal_customer_cell' => $request->phone   ,
            'sal_customer_fax' => $request->fax   ,
            'sal_customer_email' => $request->email   ,
            'sal_customer_webUrl' => null  ,
            'sal_customer_gst' => $request->gst   ,
            'sal_customer_tax' => $request->tax   ,
            'sal_AccountCode' => $request->account_code   ,
            'sal_sub_ledger_code' => $request->ledger_code   ,
            'sal_customer_is_active' => true  
        ]);

        return redirect('/admin/customer/record')->with('message','Customer has been created ... !');
        
    }

  
    public function show($id)
    {
        // dd($id);
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $customer = Leads::where('id',$id)->first();
        $customers = Leads::get();
        $Visitors = Visitor::all();
        // dd($Visitors);
        return view('customers.record',compact('dataType','customer','customers','Visitors'));
    }
    public function getVisitor($id)
    {
       // return $id;
        $visitors = Visitor::where('id',$id)->first();
        return json_encode($visitors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $customer = Customer::where('sal_customer_id',$id)->first();
        $Visitors = Visitor::all();
        //  dd($customer);
        return view('customers.create',compact('dataType','customer','Visitors'));
    }

  
    public function update(Request $request, $id)
    {
        
       
        $customer = Customer::where('sal_customer_id',$id)->update([
            'GroupId' => 1  ,
            'CompanyId' => 8 ,
            'sal_cust_cat_id' => null   ,
            'sal_customer_name' => $request->name   ,
            'sal_customer_cont_person' => $request->nickname   ,
            'sal_customer_cnic' => $request->cnic   ,
            'sal_customer_desig' => null  ,
            'sal_customer_cc_to' => null   ,
            'sal_customer_address_1' => $request->address_1   ,
            'sal_customer_address_2' => $request->address_2   ,
            'sal_customer_country' => $request->Country   ,
            'sal_customer_city' => $request->city   ,
            'sal_customer_stateprov' => $request->province   ,
            'sal_customer_postalcode' => $request->postal_code   ,
            'sal_customer_voice' => null   ,
            'sal_customer_cell' => $request->phone   ,
            'sal_customer_fax' => $request->fax   ,
            'sal_customer_email' => $request->email   ,
            'sal_customer_webUrl' => null  ,
            'sal_customer_gst' => $request->gst   ,
            'sal_customer_tax' => $request->tax   ,
            'sal_AccountCode' => $request->account_code   ,
            'sal_sub_ledger_code' => $request->ledger_code   ,
            'sal_customer_is_active' => true  
        ]);

        return redirect('/admin/customer/record')->with('message','Customer has been Updated ... !');
    }

    public function destroy($id)
    {
        Customer::where('sal_customer_id',$id)->delete();
        return redirect('/admin/customer/record')->with('message','Customer has been Deleted ... !');
    }
}
