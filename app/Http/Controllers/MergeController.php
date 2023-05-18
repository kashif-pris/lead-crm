<?php

namespace App\Http\Controllers;

use App\Models\Merge;


use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use TCG\Voyager\Facades\Voyager;

use App\Models\Plot;
use App\Models\Customer;

use App\FormDocument;
use App\Models\Document;
use App\Models\TransferNominee;
use App\Models\Message;



use App\Block;
use App\Feature;
use App\Agent;

use App\Models\Booking;
use App\Models\Nominee;
use App\Models\Downpayment;

use ReflectionClass;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;


class MergeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        if (Auth::user()->hasPermission('browse_transfer')) {

            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            $merge = Merge::with('customers','plotFirst','plotSecond','agents')->get();
           
            return view('merge.record',compact('merge','dataType'));
        }else{
      
            $this->authorize('browse_transfer');
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasPermission('browse_transfer')) {
            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

            $latest = Merge::latest()->first();
          
            if(isset($latest)){
                $ser_num = $latest->ser_num + 1;
            }else{
                $ser_num = 1;
            }


            $plots = Plot::all();
            $agents = Agent::all();
            $customers = Customer::all();
            $doc = FormDocument::where('form_id',16)->get();
            $fee = DB::table('fee_setup')->where('id',16)->first()->fee;
        return view('merge.create',compact('ser_num','plots','slug','dataType','doc','fee','customers','agents'));
        }else{
      
            $this->authorize('browse_transfer');
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $merge = Merge::create([
              'customer_id' => $request->customer  , 
              'agent_id' => $request->agent  , 
              'ser_num' => $request->ser_num  , 
              'ref_num' => $request->ref_num  , 
              'plot_first' => $request->plot_1  , 
              'plot_second' => $request->plot_2  , 
              'fee' => (int) $request->fee  , 
              'created_by' => Auth::user()->id  
        ]);

        $plot = Plot::where('id',$request->plot_1)->first()->name;
        $plot2 = Plot::where('id',$request->plot_2)->first()->name;
        $customer = Customer::where('sal_customer_id',$request->customer)->first();
  
          foreach($request->file  as $key => $item){
              $path = "Storage/Files/".$plot."/".$customer->sal_customer_name."/Merge";
              $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
              $item->move($path,$doc_name);
  
              Document::create([
                  "customer_id" => $request->customer,
                  "event_id" => $request->formID[$key],
                  "event_value" => $merge->id,
                  "file_id" => $request->file_id[$key],
                  "file" => $doc_name,
                  "path" => $path
              ]);
          }

        $mobile = $customer->sal_customer_cell;
        $message = "Mr . ".$customer->sal_customer_name." Your Plot (".$plot.") has been merged with plot (".$plot2.").";
        $path = '/admin/merge/record';
        $return_message = 'Merge has been created successfully';
        

        return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);
  
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merge  $merge
     * @return \Illuminate\Http\Response
     */
    public function show($id , Merge $merge)
    {
        if (Auth::user()->hasPermission('read_merge')) {
            $merge = Merge::with('customers','plotFirst','plotSecond')->where('id',$id)->first();
            
           
            return view('merge.view',compact('merge','id'));
    }else{
      
        $this->authorize('read_merge');
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merge  $merge
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Merge $transfer)
    {
        if (Auth::user()->hasPermission('edit_transfer')) {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $merge = Merge::with('customers','plotFirst','plotSecond')->where('id',$id)->first();
    
        $plots = Plot::all();
        $customers = Customer::all();
        $agents = Agent::all();
        $fee = DB::table('fee_setup')->where('id',16)->first()->fee;

                 $doc = FormDocument::leftJoin('documents','documents.file_id','form_documents.id')
                    ->where('documents.event_value',$id)
                    ->where('documents.event_id',16)
                    ->select('form_documents.*','documents.id as new','documents.path','documents.file')
                    ->get();
                  

        return view('merge.edit',compact('dataType','plots','customers','doc','merge','id','fee','agents'));
    }else{
      
        $this->authorize('edit_transfer');
    }
    }
    public function update($id , Request $request){
        if (Auth::user()->hasPermission('edit_merge')) {
               
                     
                 $merge = Merge::where('id',$id)->update([
                    'customer_id' => $request->customer  , 
                    'agent_id' => $request->agent  , 
                    'plot_first' => $request->plot_1  , 
                    'plot_second' => $request->plot_2  , 
                    'fee' => $request->fee  , 
                    'status' => $request->status  , 
                    'updated_by' => Auth::user()->id  
                 ]);

               
          
          
                 $plot = Plot::where('id',$request->plot_1)->first()->name;
                 $customer = Customer::where('sal_customer_id',$request->customer)->first();
         
                 if(isset($request->file)){
           
                   foreach($request->file  as $key => $item){
                       $path = "Storage/Files/".$plot."/".$customer->sal_customer_name."/Merge";
                       $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
                       $item->move($path,$doc_name);
         
                       Document::where('id',$request->file_id[$key])->update([
                           "customer_id" => $request->customer,
                           "file" => $doc_name,
                           "path" => $path
                       ]);
                   }
                 }

                  return back()->with('message','Record has been Updated ... !');

                }else{

                    $this->authorize('edit_merge');
                }
            }


    public function docs($id){

        if (Auth::user()->hasPermission('read_merge')) {
        $doc =Document::leftJoin('form_documents','form_documents.id','documents.file_id')
        ->where('event_value',$id)->where('event_id',16)->get();
        return view('merge.application-attach-form',compact('doc','id'));
    }else{
      
        $this->authorize('read_merge');
    }
    }


    public function destroy($id){
        if (Auth::user()->hasPermission('delete_merge')) {
        Merge::where('id',$id)->delete();

        return back()->with('message','Record has been Deleted ... !');
    }else{

        $this->authorize('delete_merge');
    }
    }

    public function certificate($id,Merge $merge)
    {
        if (Auth::user()->hasPermission('read_merge')) {
            $merge = Merge::with('customers','plotFirst','plotSecond')->where('id',$id)->first()->toArray();
            dd($merge);
            return view('pdf_froms.merge',compact('merge'));
    }else{
      
        $this->authorize('read_merge');
    }
    }



    public function approve($id)
    {
        if (Auth::user()->hasPermission('read_merge')) {
        Merge::where('id',$id)->update([
            'status'=>1 ,
            'updated_by' => Auth::user()->id
        ]);
        return redirect('/admin/merge/record')->with('message','Merge Request has been Approved ... !');
    }else{
      
        $this->authorize('read_merge');
    }
    }

    public function reject(Request $request)
    {
        if (Auth::user()->hasPermission('read_merge')) {
            
            $merge = Merge::where('id',$request->id)->first();
            Message::create([
                  'event_id' => 16,
                  'event_value' => $merge->id,
                  'msg_from' => Auth::user()->id,
                  'msg_to' => $merge->created_by,
                  'subject' => $request->subject,
                  'message' => $request->message,
                  'path' => $request->path,
                  'status' => 0
            ]);
            Merge::where('id',$request->id)->update(['status'=>2]);
            return redirect('/admin/merge/record')->with('message','Merge Request has been Rejected ... !');
            }else{
            
                $this->authorize('read_merge');
        }
      }

     
       public function customerSearch(Request $request){
      
        $customer = Customer::where('sal_customer_id',$request->customerID)->first();
        $plots = Booking::with('plots')->where('customer_id',$request->customerID)->get();
        $client_data = [
            'id' =>  $request->customerID,
            'cn' =>  $customer->sal_customer_id ,
            'so' =>  $customer->sal_customer_cont_person ,
            'phone' =>  $customer->sal_customer_cell,
            'email' =>  $customer->sal_customer_email ,
             'plots' => $plots
        ];
        

        return $client_data;
        
    }



}
