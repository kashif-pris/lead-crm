<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use TCG\Voyager\Facades\Voyager;

use App\Models\Plot;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\InstallmentType;

use App\FormDocument;
use App\Models\Document;
use App\Models\TransferNominee;


use App\Block;
use App\Feature;
use App\Agent;

use App\Models\Booking;
use App\Models\Nominee;
use App\Models\Message;
use App\Models\Downpayment;
use App\Models\InstallmentMaster;
use App\Models\InstallmentDetails;

use App\Models\FinancialYear;
use App\Models\FinancialYearDetail;

use ReflectionClass;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;




class TransferController extends Controller
{
    
    
    public function index()
    {
        if (Auth::user()->hasPermission('browse_transfer')) {
            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            $transfer = Transfer::with('customerFrom','customerTo','plots','users','usersUpdate')->get();

           
            return view('transfer.record',compact('dataType','transfer'));
        }else{
      
            $this->authorize('browse_transfer');
        }
     
    }
        
   


    public function create()
    {
        if (Auth::user()->hasPermission('add_transfer')) {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $latest = Transfer::latest()->first();
        if(isset($latest)){
            $ser_num = $latest->ser_num + 1;
        }else{
            $ser_num = 1;
        } 
        $tunure = InstallmentType::all();
        $bank = Bank::all();
        $agents = Agent::select('id','name')->get();

        $years = FinancialYear::get();

        $plots = Plot::where('is_booked',1)->get();
        $customers = Customer::all();
        $doc = FormDocument::where('form_id',15)->get();
        $fee = DB::table('fee_setup')->where('id',15)->first()->fee;
        return view('transfer.create',compact('agents','tunure','bank','ser_num','dataType','plots','customers','customers','doc','fee','years'));

    }else{
      
        $this->authorize('add_transfer');
    }
    }
    

 
    public function store(Request $request)
    {
        if (Auth::user()->hasPermission('add_transfer')) {

            $monthDetail = FinancialYearDetail::where('GLFinancialYear',$request->year)->where('Description',$request->month)->first()->MonthStart;
                
           $lastId = Transfer::orderByDesc('id')->limit(1)->first();
            if(isset($lastId)){
                $transfer_id_inc = ++ explode('-',$lastId->transfer_id)[3];
                $transfer_id = "INS-".explode(",",$request->month)[1]."-".explode('-',$monthDetail)[1]."-".$transfer_id_inc;
            
            }else{
                $transfer_id =  "Tra-".explode(",",$request->month)[1]."-".explode('-',$monthDetail)[1]."-T0001";
            }
            //   dd($transfer_id);
        Transfer::where('booking_id',$request->booking_id)->update(['is_active'=>False]);
        $transfer = Transfer::create([
            'booking_id' => $request->booking_id,
            'plot_id' => $request->plot,
            'agent_id' => $request->agent,
            'from_customer' => $request->customer_from,
            'to_customer' => $request->customer_to,

            'FinancialYear' => $request->year,
            'ins_Month' => $request->month,
            'transfer_id' => $transfer_id,

            'down_payment' => $request->downpayment,
            'total_installments' => $request->totalInstallments,
            'paid_installments' => $request->totalPaidInstallments,
            'remaining_amount' => $request->remainingAmount,
            'total_amount' => $request->totalAmount,

            'ref_num' => $request->ref_num,
            'ser_num' => $request->ser_num,
            'fee' => $request->fee,
            'status' => 0,
            'created_by' => Auth::user()->id,
            'is_active' => True
        ]);

        DownPayment::create([
            'booking_id' => $request->booking_id   ,
            'transfer_id' => $transfer->id   ,

            'FinancialYear' => $request->year,
            'ins_Month' => $request->month,

            
            'amount' => $request->down_payment  ,
            'token_amount' => 0 ,
            'p_type' => $request->payment_type  ,
            'p_method' => $request->payment_method  ,
            'bank_id' => $request->bank  ,
            'receipt' => $request->receipt  ,
            'cheque' => $request->cheque  ,
            'p_order' => $request->pay_order  ,
            'date' => $request->date  

      ]);



        foreach($request['addmore'] as $i => $item){
            TransferNominee::create([
              'transfer_id' => $transfer->id   ,
              'name' => $request['addmore'][$i]['name']   ,
              'son_of' => $request['addmore'][$i]['so']    ,
              'relation' => $request['addmore'][$i]['relation']   ,
              'phone' => $request['addmore'][$i]['phone']   ,
              'cnic' => $request['addmore'][$i]['cnic']   
            ]);
        }

        $plot = Plot::where('id',$request->plot)->first()->name;
        $customerFrom = Customer::where('sal_customer_id',$request->customer_from)->first()->sal_customer_name;
        $customerFrom_num = Customer::where('sal_customer_id',$request->customer_from)->first()->sal_customer_cell;
        $customerTo = Customer::where('sal_customer_id',$request->customer_to)->first()->sal_customer_name;
  
          foreach($request->file  as $key => $item){
              $path = "Storage/Files/".$plot."/".$customerFrom."/Transfer";
              $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
              $item->move($path,$doc_name);
  
              Document::create([
                
                  "customer_id" => $request->customer_from,
                  "event_id" => $request->formID[$key],
                  "event_value" => $transfer->id,
                  "file_id" => $request->file_id[$key],
                  "file" => $doc_name,
                  "path" => $path
              ]);
          }
          
          foreach($request->file_to  as $key => $item){
            $path = "Storage/Files/".$plot."/".$customerTo."/Transfer";
            $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
            $item->move($path,$doc_name);

            Document::create([
                "customer_id" => $request->customer_to,
                "event_id" => $request->formID[$key],
                "event_value" => $transfer->id,
                "file_id" => $request->file_id[$key],
                "file" => $doc_name,
                "path" => $path
            ]);
        }

        $mobile = $customerFrom_num;
        $message = "Mr . ".$customerFrom." Your Plot (".$plot.") has been transfered to Mr. (".$customerTo.").";
        $path = '/admin/transfer/record';
        $return_message = 'Transfer has been created successfully';
        

        return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);


      
    }else{
      
        $this->authorize('add_transfer');
    }

    }

 
    public function show($id,Transfer $transfer)
    {
        if (Auth::user()->hasPermission('read_transfer')) {
        
        $transfer = Transfer::with(['customerFrom','customerTo','plots','transferNominees'])->where('id',$id)->first()->toArray();
        // dd($transfer);
      
      
        $block = Block::where('id',$transfer['plots']['bl_id'])->first()->toArray();
        $size = DB::table('categories')->where('id',$transfer['plots']['size'])->first();
        $categories =  DB::table('categories')->get();
        $feature = Feature::all();
        $booking = Booking::where('plot_id',$transfer['plot_id'])->get()->toArray();

         $downPayment = DownPayment::where('transfer_id',$id)->first()->amount;
         
       
         $feature_array = json_decode($transfer['plots']['feature']);
       
        
        return view('pdf_froms.transfer',compact('downPayment','booking','transfer','block','size','transfer','feature_array','feature','categories','id'));
    }else{
      
        $this->authorize('read_transfer');
    }
    }

  
    public function edit($id,Transfer $transfer)
    {
        if (Auth::user()->hasPermission('edit_transfer')) {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        
         $transfer = Transfer::with(['customerFrom','customerTo','plots','transferNominees'])->where('id',$id)->first();
         $feature =  json_decode($transfer->plots->feature);
         $agents = Agent::select('id','name')->get();
               
         $array = [];

         if(isset($feature)){
            foreach($feature as $item){
            
                $new = DB::table('features')->where('id',$item)->first()->name;
                array_push($array,$new);
             }

        }else{
            $array = ['not avaiable'];
        }
         
        $plots = Plot::where('is_booked',1)->get();
        $customers = Customer::all();

                 $doc = FormDocument::leftJoin('documents','documents.file_id','form_documents.id')
                    ->where('documents.event_value',$id)
                    ->where('documents.customer_id',$transfer['from_customer'])
                    ->select('form_documents.*','documents.id as new','documents.path','documents.file')
                    ->get();
                    // dd($doc);

                    $to = FormDocument::leftJoin('documents','documents.file_id','form_documents.id')
                    ->where('documents.event_value',$id)
                    ->where('documents.customer_id',$transfer['to_customer'])
                    ->select('form_documents.*','documents.id as new','documents.path','documents.file')
                    ->get();

        return view('transfer.edit',compact('array','agents','dataType','plots','customers','customers','to','doc','transfer','id'));
    }else{
      
        $this->authorize('edit_transfer');
    }
    }


    public function update(Request $request, $id)
    {
        if (Auth::user()->hasPermission('edit_transfer')) {
        //  dd($request->all());
        //  dd(explode(',', $request->month)[0] , explode(',', $request->month)[1]);
        $transfer = Transfer::where('id',$id)->update([
            'plot_id' => $request->plot,
            'from_customer' => $request->customer_from,
            'to_customer' => $request->customer_to,
            'agent_id' => $request->agent,

            // 'financial_year' => $request->year,
            // 'month' => $request->month,
            // 'transfer_id' => "TRA-2021-07-T0001",

            'ref_num' => $request->ref_num,
            'ser_num' => $request->ser_num,
            'fee' => $request->fee,
            // 'updated_by' => Auth::user()->id
        ]);
     
        

        TransferNominee::where('transfer_id',$id)->delete();
        foreach($request['addmore'] as $i => $item){
            TransferNominee::create([
              'transfer_id' => $id   ,
              'name' => $request['addmore'][$i]['name']   ,
              'son_of' => $request['addmore'][$i]['so']    ,
              'relation' => $request['addmore'][$i]['relation']   ,
              'phone' => $request['addmore'][$i]['phone']   ,
              'cnic' => $request['addmore'][$i]['cnic']   
            ]);
        }

       

        $plot = Plot::where('id',$request->plot)->first()->name;
        $customerFrom = Customer::where('sal_customer_id',$request->customer_from)->first();
        $customerTo = Customer::where('sal_customer_id',$request->customer_to)->first();

        if(isset($request->file_from)){
  
          foreach($request->file_from  as $key => $item){
              $path = "Storage/Files/".$plot."/".$customerFrom->name."/Transfer";
              $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
              $item->move($path,$doc_name);

              Document::where('id',$request->file_id_from[$key])->update([
                  "customer_id" => $request->customer_from,
                  "file" => $doc_name,
                  "path" => $path
              ]);
          }
        }

        
        if(isset($request->file_to)){

          foreach($request->file_to  as $key => $item){
          
            $path = "Storage/Files/".$plot."/".$customerTo->name."/Transfer";
            $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
            $item->move($path,$doc_name);

            Document::where('id',$request->file_id_to[$key])->update([
                "customer_id" => $request->customer_to,
                "file" => $doc_name,
                "path" => $path
            ]);
        }
    }
        return redirect('/admin/transfer/record')->with('message','Record has been Created ... !');

    }else{
      
        $this->authorize('edit_transfer');
    }
    }


    public function doc($id){
        if (Auth::user()->hasPermission('read_transfer')) {

        $transfer = Transfer::where('id',$id)->first();
        $from =Document::leftJoin('form_documents','form_documents.id','documents.file_id')
        ->where('event_value',$id)->where('event_id',15)->where('customer_id',$transfer->from_customer)->get();

        $to =Document::leftJoin('form_documents','form_documents.id','documents.file_id')
        ->where('event_value',$id)->where('event_id',15)->where('customer_id',$transfer->to_customer)->get();
        // dd($from,$to);
     
        return view('transfer.application-attach-form',compact('to','from','id'));
    }else{
      
        $this->authorize('read_transfer');
    }
    }


    public function destroy($id,Transfer $transfer)
    {
        if (Auth::user()->hasPermission('delete_transfer')) {

        $transfer->where('id',$id)->delete();
        TransferNominee::where('transfer_id',$id)->delete();

        Document::leftJoin('form_documents','form_documents.id','documents.file_id')
        ->where('event_value',$id)->where('event_id',15)->delete();

        return redirect('/admin/transfer/record')->with('message','Record has been Deleted ... !');
    }else{
      
        $this->authorize('delete_transfer');
    }
   
    }
    public function approve($id,Transfer $transfer)
    {
        $bookingID = Transfer::where('id',$id)->first()->booking_id;
        $bookingTransfer = Transfer::where('id',$id)->first();
        $downPayment = Booking::where('id',$bookingID)->first()->DownPayment;

        $paidAmount = Booking::where('id',$bookingID)->first()->PaidAmount;
        $RemainingAmount = InstallmentMaster::where('FormNo',$bookingID)->first()->RemainingAmount;

   
        if (Auth::user()->hasPermission('read_transfer')) {
       
       
        Transfer::where('id',$id)->update([
            'status'=>1 ,
            'updated_by' => Auth::user()->id
        ]);

        $qr = new ApiController();
        $qr->generate_qrcode($bookingTransfer->getTable(), $bookingTransfer->ref_num, $downPayment , $paidAmount);
        return redirect('/admin/transfer/record')->with('message','Transfer Request has been Approved ... !');
    }else{
      
        $this->authorize('read_transfer');
    }
    }
    public function unapprove(Request $request)
    {
        if (Auth::user()->hasPermission('read_transfer')) {

            $transfer = Transfer::where('id',$request->id)->first();
            
            Message::create([
                  'event_id' => 15,
                  'event_value' => $transfer->id,
                  'msg_from' => Auth::user()->id,
                  'msg_to' => $transfer->created_by,
                  'subject' => $request->subject,
                  'message' => $request->message,
                  'path' => $request->path,
                  'status' => 0
            ]);
          Transfer::where('id',$request->id)->update(['status'=>2]);
        return redirect('/admin/transfer/record')->with('message','Transfer Request has been Unapproved ... !');
    }else{
      
        $this->authorize('read_transfer');
    }



    }

    public function searchyear(Request $request){
        $id = $request->yearID;
        $months = FinancialYearDetail::where('GLFinancialYear',$id)->where('IsActive',True)->get();
        return $months;
     }



    // ajax
    public function search(Request $request){
       
        $id = $request->plot;
        $plot = DB::table('plots')
        ->leftJoin('categories','categories.id','plots.size')
        ->leftJoin('bookings','bookings.plot_id','plots.id')
        ->leftJoin('InstallmentMaster','InstallmentMaster.FormNo','bookings.id')
        ->leftJoin('blocks','blocks.id','plots.bl_id')
        ->leftJoin('projects','projects.id','plots.pr_id')
        ->where('plots.id',$id)
        ->select('plots.status','categories.name','bookings.id as booking_id','bookings.customer_id','plots.price','blocks.name as bl_name','projects.project_name as project','plots.feature')
        ->first();

         $check = Transfer::where('booking_id',$plot->booking_id)->orderByDesc('id')->first();

         if(isset($check)){
            $plot->customer_id = $check->to_customer;
         }
         
        

        $installments = new InstallmentMaster();
        $installmentMaster = $installments->where('FormNo',$plot->booking_id)->with('details')->first();
        if($installmentMaster){
            $totalInstallments =  $installments->where('InstallmentId',$installmentMaster->InstallmentId)->first()->TotalInstallments;
            $totalPaidInstallments =  $installments->where('InstallmentId',$installmentMaster->InstallmentId)->first()->TotalPaidInstallments;
            $downPayment = Booking::where('id',$plot->booking_id)->first()->DownPayment;
            $remainingAmount = $installments->where('InstallmentId',$installmentMaster->InstallmentId)->first()->RemainingAmount;
            $paidAmount = Booking::where('id',$plot->booking_id)->first()->PaidAmount;
            
            if($plot->status == "commercial"){
                $request->fee = 15000;
                $fees = explode(" ",$plot->name)[0] * $request->fee;
            }else{
                $fees = explode(" ",$plot->name)[0] * $request->fee;
            }
            
        
            $customer = Customer::where('sal_customer_id',$plot->customer_id)->first();
            
            $html = '<option value="'.$customer->sal_customer_id.'" >'.$customer->sal_customer_name.'</option>';
            
            $feature =  json_decode($plot->feature);
            $array = [];

            if(isset($feature)){
                foreach($feature as $item){
                
                    $new = DB::table('features')->where('id',$item)->first()->name;
                    array_push($array,$new);
                }

                }else{
                    $array = ['not avaiable'];
                }
                
            $size = [
                'booking_id'=>$plot->booking_id,
                'size' => $plot->name,
                'price' => $plot->price,
                'fees' => $fees,
                'plot_status' => $plot->status,
                'numprice' => number_format($plot->price),
                'block' => $plot->bl_name,
                'project' => $plot->project,
                'feature' => $array,
                'html' => $html,
                'son_of' => $customer->sal_customer_cont_person,
                'phone' => $customer->sal_customer_cell,
                'email' => $customer->sal_customer_email,
                'cnic' => $customer->sal_customer_email,
                'downpayment'=> $downPayment,
                'totalInstallments'=>$totalInstallments,
                'totalPaidInstallments'=>$totalPaidInstallments,
                'remainingAmount'=>$remainingAmount,




            ];
        }else{
            $size =[];
        }

        $sizes = json_encode($size);
        return $sizes;      
    }



    public function certificate($id,Transfer $transfer)
    {
        if (Auth::user()->hasPermission('read_transfer')) {
            $transfer = Transfer::with(['customerFrom','customerTo','plots','transferNominees'])->where('id',$id)->first()->toArray();
          //  dd($transfer);
            return view('pdf_froms.transfer_letter',compact('transfer'));
    }else{
      
        $this->authorize('read_transfer');
    }
    }
}
