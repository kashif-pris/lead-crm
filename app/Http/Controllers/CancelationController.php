<?php

namespace App\Http\Controllers;

use App\Models\Cancelation;


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


use App\Block;
use App\Feature;
use App\Agent;

use App\Models\Booking;
use App\Models\Nominee;
use App\Models\Downpayment;
use App\Models\Message;
use App\Models\Merge;

use ReflectionClass;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;


class CancelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        if (Auth::user()->hasPermission('browse_cancelation')) {
            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            $merge = Cancelation::with('booking','users','usersUpdate')->get();
            
           // dd($merge);
            return view('cancelation.record',compact('merge','dataType'));
        }else{
      
            $this->authorize('browse_cancelation');
        }


    }

    function getBookings($id){
            return Booking::where('customer_id',$id)->with('plots')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasPermission('browse_cancelation')) {
            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            $plots = Plot::all();
            $customers = Customer::all();
            $doc = FormDocument::where('form_id',19)->get();
            $fee = DB::table('fee_setup')->where('id',16)->first()->fee;
        return view('cancelation.create',compact('plots','slug','dataType','doc','fee','customers'));
        }else{
      
            $this->authorize('browse_cancelation');
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
        // dd($request->all());
        $merge = Cancelation::create([
              'booking_id' => $request->booking_id, 
              'fee' => $request->fee,
              'status' => 0 ,  
              'reason' => $request->reason,  
              'created_by' => Auth::user()->id  
        ]);

        $plot = Plot::where('id',Booking::where('id',$request->booking_id)->first()->plot_id)->first()->name;
        $customer = Customer::where('sal_customer_id',$request->customer)->first();
  
          foreach($request->file  as $key => $item){
              $path = "Storage/Files/".$plot."/".$customer->sal_customer_name."/Cancelation";
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

                 
        $mobile = $customer->phone_1;
        $message = "Mr . ".$customer->sal_customer_name." Your Plot (".$plot.") has been canceled.";
        $path = '/admin/cancelation/record';
        $return_message = 'Record has been Created ... !';
        

        return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merge  $merge
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        if (Auth::user()->hasPermission('read_cancelation')) {
            $slug = 'cancelation';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            $plot = Cancelation::find($id)->with(['booking'])->first();
            $doc =Document::leftJoin('form_documents','form_documents.id','documents.file_id')
            ->where('event_value',$id)->where('event_id',16)->get();
            $fee = DB::table('fee_setup')->where('id',19)->first()->fee;
            // dd($plot->booking->plots->name);
        return view('cancelation.preview',compact('plot','slug','dataType','doc','fee','id'));
        }else{
      
            $this->authorize('read_cancelation');
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
        if (Auth::user()->hasPermission('edit_cancelation')) {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $merge = Merge::with('customers','plotFirst','plotSecond')->where('id',$id)->first();
    // dd($merge);
        $plots = Plot::all();
        $customers = Customer::all();
        $fee = DB::table('fee_setup')->where('id',16)->first()->fee;

                 $doc = FormDocument::leftJoin('documents','documents.file_id','form_documents.id')
                    ->where('documents.event_value',$id)
                    ->where('documents.event_id',16)
                    ->select('form_documents.*','documents.id as new','documents.path','documents.file')
                    ->get();
                  

        return view('merge.edit',compact('dataType','plots','customers','doc','merge','id','fee'));
    }else{
      
        $this->authorize('edit_cancelation');
    }
    }
    public function update($id , Request $request){
        if (Auth::user()->hasPermission('edit_cancelation')) {
               
                     
                 $merge = Merge::where('id',$id)->update([
                    'customer_id' => $request->customer  , 
                    'plot_first' => $request->plot_1  , 
                    'plot_second' => $request->plot_2  , 
                    'fee' => $request->fee  , 
                    'status' => $request->status  , 
                    'updated_by' => Auth::user()->id  
                 ]);

               
          
          
                 $plot = Plot::where('id',$request->plot_1)->first()->name;
                 $customer = Customer::where('id',$request->customer)->first();
         
                 if(isset($request->file)){
           
                   foreach($request->file  as $key => $item){
                       $path = "Storage/Files/".$plot."/".$customer->name."/Merge";
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

                    $this->authorize('edit_cancelation');
                }
            }


    public function docs($id){

        if (Auth::user()->hasPermission('read_cancelation')) {
        $doc =Document::leftJoin('form_documents','form_documents.id','documents.file_id')
        ->where('event_value',$id)->where('event_id',16)->get();
        return view('merge.application-attach-form',compact('doc','id'));
    }else{
      
        $this->authorize('read_cancelation');
    }
    }


    public function destroy($id){
       // dd($id);
        if (Auth::user()->hasPermission('delete_cancelation')) {
            Cancelation::where('id',$id)->delete();

        return back()->with('message','Record has been Deleted ... !');
    }else{

        $this->authorize('delete_cancelation');
    }
    }

    public function approve($id)
    {
    
        if (Auth::user()->hasPermission('read_cancelation')) {
            $data = Cancelation::where('id',$id)->first()->booking_id;
            $booking = Booking::where('id',$data)->first();
            Booking::where('id',$booking->id)->update(['status' => 3,'updated_by' => Auth::user()->id]);
            // dd($booking)->;
            Plot::where('id',$booking->plot_id)->update(['is_booked' => 0]);

            Cancelation::where('id',$id)->update([
            'status'=>1 ,
            'updated_by' => Auth::user()->id
        ]);
        return redirect('/admin/cancelation/record')->with('message','Cancelation Request has been Approved ... !');
    }else{
      
        $this->authorize('read_cancelation');
    }
    }

    public function unapprove(Request $request)
    {
        if (Auth::user()->hasPermission('read_cancelation')) {
            $cancelation = Cancelation::where('id',$request->id)->first();
            Message::create([
                  'event_id' => 19,
                  'event_value' => $cancelation->id,
                  'msg_from' => Auth::user()->id,
                  'msg_to' => $cancelation->created_by,
                  'subject' => $request->subject,
                  'message' => $request->message,
                  'path' => $request->path,
                  'status' => 0
            ]);
            Cancelation::where('id',$request->id)->update(['status'=>2 , 'updated_by' => Auth::user()->id]);
        return redirect('/admin/cancelation/record')->with('message','Cancelation Request has been Unapproved ... !');
    }else{
      
        $this->authorize('read_cancelation');
    }

}



    public function certificate($id,Merge $merge)
    {
        if (Auth::user()->hasPermission('read_cancelation')) {
            $merge = Merge::with('customers','plotFirst','plotSecond')->where('id',$id)->first()->toArray();
            dd($merge);
            return view('pdf_froms.merge',compact('merge'));
    }else{
      
        $this->authorize('read_cancelation');
    }
    }

}
