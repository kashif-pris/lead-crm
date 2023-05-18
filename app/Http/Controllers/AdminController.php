<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;
use Auth;
use Redirect;
use TCG\Voyager\Database\Schema\SchemaManager;
// use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;
use TCG\Voyager\Facades\Voyager;
use App\Jobs\SendMessage;

use App\Models\Plot;
use App\Block;
use App\Feature;
use App\Agent;
use File;
use PDF;

use App\Models\FinancialYear;
use App\Models\User;
use App\Models\FinancialYearDetail;

use Carbon\Carbon;
use App\Models\InstallmentMaster;
use App\Models\InstallmentDetails;
use App\Models\Bank;
use App\Models\InstallmentType;
use App\Models\Customer;
use App\Models\Visitor;
use App\Models\Message;
use App\Models\Booking;
use App\Models\Nominee;
use App\Models\Downpayment;
use App\Models\Token;
use App\Models\Leads;
use App\Models\Document;
use App\FormDocument;

class AdminController extends Controller
{
    public function VisitorIndex(){
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $visitor = Visitor::all();
        $view = 'visitors.visitor-record';
        return Voyager::view($view)->with(compact('dataType','slug','visitor'));

    }
    public function VisitorShow($id){

        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $visitor = Visitor::where('id',$id)->first();
       // dd($visitor);
        $view = 'visitors.visitor-data';
        return Voyager::view($view)->with(compact('dataType','slug','visitor'));

    }
    public function VisitorCreate(){
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $view = 'visitors.visitor-data';

        return Voyager::view($view)->with(compact('dataType','slug'));

    }
    public function VisitorStore(Request $request){

     $visitorStore =  Visitor::create([
        'name' =>  $request->name ,
        'email' => $request->email  ,
        'phone' => $request->phone  ,
        'visitor_type' => $request->visitor_type
         ]);
         if($visitorStore->save()){
            return redirect('/admin/visitor-data')->with('message','Visitor Added Succesfully... !');
         }
    }
    public function VisitorSendNessage(Request $request){

        // dd($request->all());
        $today = Carbon::now()->format('Y-m-d');
        $users = Visitor::all();
        if (!empty($users)) {
            foreach ($users as $user) {
                SendMessage::dispatch($user,$request->subject,$request->message);
            }
        }
        return redirect('/admin/visitor-data')->with('message','Message Sent Succesfully... !');
       }

    public function VisitorUpdate(Request $request){

        $data= [
            'name' =>  $request->name ,
            'email' => $request->email  ,
            'phone' => $request->phone  ,
            'visitor_type' => $request->visitor_type
        ];
        $visitorStore =  Visitor::where('id',$request->id)->update($data);
            if(!empty($visitorStore)){
               return redirect('/admin/visitor-data')->with('message','Visitor Updated Succesfully... !');
            }
       }
   public function ApplicationForm(){
    if (Auth::user()->hasPermission('read_booking')) {

    if(!Auth::user()) {
        return redirect('admin/login');
    }
    $slug = 'roles';
    $plots = Plot::WHERE('is_booked',0)->get();
    $customers = Leads::where('status','Token Leads')->get();
    // dd($customers);
    $agents = User::where('role_id','5')->get();
    $years = FinancialYear::get();
    $latest = Booking::latest()->first();
     if(isset($latest)){
         $ser_num = $latest->ser_num + 1;
     }else{
        $ser_num = 1;
     }
    $doc = DB::table('form_documents')->where('form_id',13)->get();

    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

    $tunure = InstallmentType::all();
    $bank = Bank::all();


    $this->authorize('browse', app($dataType->model_name));
    $view = 'booking.application-form';
    return Voyager::view($view)->with(compact('ser_num','years','dataType','plots','customers','doc','agents','tunure','bank'));
}else{

    $this->authorize('read_booking');
}

    }

    public function ApplicationFormStore(Request $request){
        // dd($request->all());
        if (Auth::user()->hasPermission('add_booking')) {
            // dd($request->all());

            $plotsize = Plot::where('id',$request->plot)->with('sizeGet')->first();

     $booking =  Booking::create([
          'plot_id' =>  $request->plot ,
          'customer_id' => $request->customer  ,

          'agent_id' => $request->agent  ,
          'agent_commission' => $request->commission  ,
          'agent_amount' => $request->commission_amount  ,

          'ref_num' =>  $request->reference ,
          'ser_num' => $request->serial  ,
          'amount' =>  $request->plot_amount ,
          'tunure' =>  $request->tunure ,
          'status' => 0  ,
          'created_by' => Auth::User()->id,
          'plot_size' => $plotsize->sizeGet->slug
      ]);

      Plot::where('id', $request->plot)->update(['is_booked' => 0 , 'status' =>'Sold Out']);
      foreach($request['addmore'] as $i => $item){
          Nominee::create([
            'booking_id' => $booking->id   ,
            'name' => $request['addmore'][$i]['name']   ,
            'son_of' => $request['addmore'][$i]['so']    ,
            'relation' => $request['addmore'][$i]['relation']   ,
            'phone' => $request['addmore'][$i]['phone']   ,
            'cnic' => $request['addmore'][$i]['cnic']
          ]);
      }


      DownPayment::create([
            'booking_id' => $booking->id   ,
            'amount' => $request->down_payment  ,
            'token_amount' => $request->token_payment  ,
            'p_type' => $request->payment_type  ,


            'FinancialYear' => $request->year,
            'ins_Month' => $request->month,

            'p_method' => $request->payment_method  ,
            'bank_id' => $request->bank  ,
            'receipt' => $request->receipt  ,
            'cheque' => $request->cheque  ,
            'p_order' => $request->pay_order  ,
            'date' => $request->date ,
            'discount'=>$request->discount

      ]);

      $plot = Plot::where('id',$request->plot)->first()->name;
      $customer = Leads::where('id',$request->customer)->first();
    //   dd($customer->name);

       if($request->file){

        foreach($request->file  as $key => $item){
            $path = "Storage/Files/".$plot."/".$customer->name."/Booking";

            $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
            $item->move($path,$doc_name);

            Document::create([
                "customer_id" => $request->customer,
                "event_id" => $request->formID[$key],
                "event_value" => $booking->id,
                "file_id" => $request->file_id[$key],
                "file" => $doc_name,
                "path" => $path
            ]);

        }
       }
       $token = Token::where('id',$request->token_id)->update(['status'=>1]);

        $mobile = $customer->phone;
        $message = "Mr . ".$customer->name." Your Plot (".$plot.") has been booked.";
        $path = '/admin/application-form/record';
        $return_message = 'Booking has been created successfuly';
        return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);


    }else{

        $this->authorize('add_booking');
    }

    }

    public function docs($id){

        if (Auth::user()->hasPermission('read_booking')) {

            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $doc =Document::leftJoin('form_documents','form_documents.id','documents.file_id')
        ->where('event_value',$id)->where('event_id',13)->get();

        return view('booking.docs',compact('doc','id','dataType'));
    }else{

        $this->authorize('read_booking');
    }
    }

    public function TokenExpire(){
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $token = Token::where('expriry_date' , '<' , Carbon::now()->format('Y-m-d'))->with('customers')->get();
    // dd(  $token);
        return view('payments.token',compact('token','dataType'));
    }

    public function record(){
        if (Auth::user()->hasPermission('browse_transfer')) {
        $booking = Booking::with(['down_payments','plots','customers','agents','users'])->get();
            // dd($booking);
        $installmentMaster = InstallmentMaster::get();
        return view('booking.record',compact('booking' , 'installmentMaster'));
    }else{

        $this->authorize('browse_transfer');
    }
    }
    public function customerSearch(Request $request){


        $customer = Leads::where('id',$request->customerID)->first();
        $token = Token::where('customer_id',$request->customerID)->where('plot_id',$request->plotID) ->where('expriry_date' , '>=' , Carbon::now()->format('Y-m-d'))->first();
        // return($token);
        if(isset($token)){
            $amount = $token->amount;
            $tokenId =  $token->id;
        }else{
            $amount = 0;
            $tokenId =  0;
        }

        $client_data = [
            'id' =>  $request->customerID,
            // 'cn' =>  $customer->name ,
            'so' =>  $customer->name ,
            'phone' =>  $customer->phone,
            'email' =>  $customer->email,
            'amount' =>  $amount,
            'tokenId' => $tokenId
        ];

        return $client_data;

   }


    public function agentSearch(Request $request){

        $agent = Agent::where('id',$request->agentID)->first()->commission;
         return $agent;

    }


    public function search(Request $request){

        $id = $request->plot;

        $plot = DB::table('plots')
        ->leftJoin('categories','categories.id','plots.size')
        ->leftJoin('blocks','blocks.id','plots.bl_id')
        ->leftJoin('projects','projects.id','plots.pr_id')
        ->where('plots.id',$id)
        ->select('categories.name','plots.price','plots.status','blocks.name as bl_name','projects.project_name as project','plots.feature')
        ->first();

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
        $tokenData = Token::where('plot_id',$id)->first();
        // return $tokenData;
        $dataT = [
             //token data response
             'downpayment' => $tokenData->downpayment,
             'dealprice' => $tokenData->deal_amount,
             'discount_amount' => $tokenData->discount_amount,
             'token_amount' => $tokenData->amount,
        ];
         $size = [
              'size' => $plot->name,
              'price' => $plot->price,
              'numprice' => number_format($plot->price),
              'block' => $plot->bl_name,
              'project' => $plot->project,
              'status' => $plot->status,
              'feature' => $array,
             
        ];
        $token_Data = json_encode($dataT);
        $sizes = json_encode($size);
        return [
           
            $sizes,
            $token_Data
        ];
    }


    public function search2(Request $request){

        $id = $request->plot;


        $plot = DB::table('plots')
        ->leftJoin('categories','categories.id','plots.size')
        ->leftJoin('blocks','blocks.id','plots.bl_id')
        ->leftJoin('projects','projects.id','plots.pr_id')
        ->where('plots.id',$id)
        ->select('categories.name','plots.price','plots.status','plots.attach_plot','blocks.name as bl_name','projects.project_name as project','plots.feature')
        ->first();

         $feature =  json_decode($plot->feature);
         $merge =  json_decode($plot->attach_plot);
         $array = [];
         $merge_array = [];
         $merge_array_id = [];

         if(isset($feature)){
            foreach($feature as $item){

                $new = DB::table('features')->where('id',$item)->first()->name;
                array_push($array,$new);
             }

        }else{
            $array = ['not avaiable'];
        }

        if(isset($merge)){
            foreach($merge as $item){

                $plot_name = DB::table('plots')->where('id',$item)->first();
                array_push($merge_array,$plot_name->name);
                array_push($merge_array_id,$plot_name->id);
             }

        }else{
            $merge_array = ['not avaiable'];
        }

        $attach_html = '
        <select class="form-control select2 " id="plot_2" name="plot_2"  tabindex="-1" aria-hidden="true">
            foreach($merge_array as $item)
            <option value=".$merge_array_id." >.$merge_array.</option>
            endforeach
        </select>
        ';

         $size = [
              'size' => $plot->name,
              'price' => $plot->price,
              'numprice' => number_format($plot->price),
              'block' => $plot->bl_name,
              'project' => $plot->project,
              'status' => $plot->status,
              'feature' => $array,
              'plot_id' => $merge_array_id,
              'plot_name' => $merge_array,
        ];

        $sizes = json_encode($size);
        return $sizes;
    }


    public function AllotmentForm(){

        if (Auth::user()->hasPermission('read_booking')) {

        if(!Auth::user()) {
            return redirect('admin/login');
        }

        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = 'roles';

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        // Check permission
        $this->authorize('browse', app($dataType->model_name));
        $view = 'forms.allotment-form';
        return Voyager::view($view)->with(compact('dataType'));
    }else{

        $this->authorize('read_booking');
    }

        }


        public function MembershipTransferForm(){

            if(!Auth::user()) {
                return redirect('admin/login');
            }

            // GET THE SLUG, ex. 'posts', 'pages', etc.
            $slug = 'roles';

            // GET THE DataType based on the slug
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            // Check permission
            $this->authorize('browse', app($dataType->model_name));
            $view = 'forms.membership-transfer-form';
            return Voyager::view($view)->with(compact('dataType'));

            }


        public function show($id){
            // dd($id);
                    if (Auth::user()->hasPermission('read_booking')) {
                 $booking = Booking::with(['nominees','down_payments','customers','plots'])->where('bookings.id',$id)->first()->toArray();
                 
                //  dd($booking['plots'][0]['bl_id']);
                 $booking['amount'];
                 $booking['down_payments']['amount'];
                 $booking['down_payments']['discount'];

                 $remaining_balance = $booking['amount']-( $booking['down_payments']['amount'] + $booking['down_payments']['discount']);

                //  dd($remaining_balance);
                 $block = Block::where('id',$booking['plots'][0]['bl_id'])->first()->toArray();
                 $installmentMaster = InstallmentMaster::where('FormNo' , $id)->first();
                 if($installmentMaster)
                 {
                    $insatallmentDetails = InstallmentDetails::where('InstallmentId' , $installmentMaster->InstallmentId)->first();
                    // dd($insatallmentDetails);
                 }else{
                    $insatallmentDetails ='';
                 }
                //  dd($installmentMaster);
                $office = Plot::where('id',$booking['plot_id'])->first()->toArray();
                    //    dd($office);
                 $size = DB::table('categories')->where('id',$booking['plots'][0]['size'])->first();
                 $categories =  DB::table('categories')->get();
                 $bank = DB::table('banks')->where('id',$booking['down_payments']['bank_id'])->first();
                 $feature = Feature::all();
                  $feature_array =      json_decode($booking['plots'][0]['feature']);

                }else{

                    $this->authorize('read_booking');
                }

                return view('pdf_froms.application',compact('insatallmentDetails','installmentMaster','office','booking','size','block','feature' ,'feature_array','categories','bank'));
                }

    public function edit($id){

                    if (Auth::user()->hasPermission('edit_booking')) {
                     if(!Auth::user()) {
                        return redirect('admin/login');
                    }


                    $slug = 'roles';

                    $tunure = InstallmentType::all();
                    // dd($tunure);
                    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

                    $this->authorize('browse', app($dataType->model_name));

                    $booking = Booking::with(['nominees','down_payments','customers','plots','agents'])->where('bookings.id',$id)->first();
                //   dd($booking);
                    $plots = Plot::all();
                       
                    $customers = Leads::all();
                    $agents = User::where('role_id' , '5')->get();
                    $banks = DB::table('banks')->get();

                    $feature =  json_decode($booking->plots[0]->feature);
                    // dd($feature);
                    $array = [];

                    if(isset($feature)){
                       foreach($feature as $item){

                           $new = DB::table('features')->where('id',$item)->first()->name;
                           array_push($array,$new);
                        }

                   }else{
                       $array = ['not avaiable'];
                   }

                   $years = FinancialYear::get();
                //    dd($years);
                    $doc = FormDocument::leftJoin('documents','documents.file_id','form_documents.id')
                    ->where('documents.event_value',$id)
                    ->select('form_documents.*','documents.id as new','documents.path','documents.file')
                    ->get();


                     $update = 1;

                //    DD($booking);
                    return view('booking.application-form',compact('tunure','years','array','booking','agents','plots','update','banks','customers','doc','dataType'));
                }else{

                    $this->authorize('edit_booking');
                }
                }


            public function update(Request $request){
                // dd($request->all());
                if (Auth::user()->hasPermission('edit_booking')) {
                        $id = $request->id;

                         $booking = Booking::where('id',$id)->update([
                              'ref_num' => $request->reference,
                              'ser_num' => $request->serial,
                              'customer_id' => $request->customer,
                              'agent_id' => $request->agent,
                              'agent_commission' => $request->commission,
                              'amount' => $request->plot_amount,
                              'agent_amount' => $request->commission_amount,
                         ]);

                         Nominee::where('booking_id',$id)->delete();
                         foreach($request['addmore'] as $i => $item){
                            Nominee::create([
                              'booking_id' => $id  ,
                              'name' => $request['addmore'][$i]['name']   ,
                              'son_of' => $request['addmore'][$i]['so']    ,
                              'relation' => $request['addmore'][$i]['relation']   ,
                              'phone' => $request['addmore'][$i]['phone']   ,
                              'cnic' => $request['addmore'][$i]['cnic']
                            ]);
                        }


                        DownPayment::where('booking_id',$id)->update([
                              'booking_id' => $id   ,
                              'amount' => $request->down_payment  ,
                              'p_type' => $request->payment_type  ,
                              'p_method' => $request->payment_method  ,
                              'bank_id' => $request->bank  ,
                              'receipt' => $request->receipt  ,
                              'cheque' => $request->cheque  ,
                              'p_order' => $request->pay_order  ,
                              'date' => $request->date

                        ]);
                        //dd($request->file);
                        $plot = Plot::where('id',$request->plot)->first()->name;
                        // dd($request->customer);
                        $customer = Leads::where('id',$request->customer)->first()->name;
                        
                        if(!empty($request->file)){
                            foreach($request->file  as $key => $item){
                                $path = "Storage/Files/".$plot."/".$customer."/Booking";
                                $doc_name =  time().rand(100,999 ).".".$item->getClientOriginalExtension();
                                $item->move($path,$doc_name);
  
                                Document::where('id',$request->file_id[$key])->update([
  
                                    "file" => $doc_name,
                                    "path" => $path
                                ]);
                            }
                        }
                          

                          return redirect('/admin/application-form/record')->with('message','Record has been Updated ... !');

                        }else{

                            $this->authorize('edit_booking');
                        }
                    }





            public function destroy($id){
                if (Auth::user()->hasPermission('delete_booking')) {
                $booking = Booking::where('id',$id)->first();
                Plot::where('id',$booking->plot_id)->update(['is_booked'=> 0]);
                $booking->delete();
                Nominee::where('booking_id',$id)->delete();
                DownPayment::where('booking_id',$id)->delete();

                return back()->with('message','Record has been Deleted ... !');
            }else{

                $this->authorize('delete_booking');
            }
    }

        function approveBooking($id){
            $booking = Booking::find($id);
            $booking->status  = 1;
            if($booking->save()){
                $plot = Plot::find($booking->plot_id);
                $plot->is_booked = 1;
                if($plot->save()){

                    $plot_name = $plot->name;



                $booking = Booking::with(['nominees','down_payments','customers','plots'])->where('bookings.id',$id)->first()->toArray();

                $booking23 = Booking::where('id' , $id)->first();

                $block = Block::where('id',$booking['plots'][0]['bl_id'])->first()->toArray();
                $size = DB::table('categories')->where('id',$booking['plots'][0]['size'])->first();
                $categories =  DB::table('categories')->get();
                $bank = DB::table('banks')->where('id',$booking['down_payments']['bank_id'])->first();
                $feature = Feature::all();
                $feature_array =      json_decode($booking['plots'][0]['feature']);


                $filename = $plot_name.'-booking-'.date('Y-m-d').'-'.date('his').'.pdf';
                $path = "Storage/Files/".$plot_name."/".$booking['customers']['name']."/Booking";
                $DBpath = "Storage/Files/".$plot_name."/".$booking['customers']['name']."/Booking//".$filename;

                $qr = new ApiController();
                $qr->generate_qrcode($booking23->getTable(), $booking['ref_num'], $booking['plot_size'] , $booking['amount']);



                return redirect('/admin/application-form/record')->with('message','Record has been approved ... !');
                }else{
                    return redirect('/admin/application-form/record')->with('message','Something went with ... !');

                }
            }
        }


        function rejectBooking(Request $request){

            $booking = Booking::where('id',$request->id)->first();
            Message::create([
                  'event_id' => 13,
                  'event_value' => $booking->id,
                  'msg_from' => Auth::user()->id,
                  'msg_to' => $booking->created_by,
                  'subject' => $request->subject,
                  'message' => $request->message,
                  'path' => $request->path,
                  'status' => 0
            ]);


            $booking->status  = 2;
            $booking->updated_by  = Auth::user()->id;
            if($booking->save()){
                $plot = Plot::find($booking->plot_id);
                $plot->is_booked = 0;
                return redirect('/admin/application-form/record')->with('message','Record has been rejected ... !');
            }
        }


}
