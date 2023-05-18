<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Allotment;
use App\Models\Customer;
use App\Agent;
use App\Models\Message;
use App\Models\Document;
use Illuminate\Http\Request;
use File;
use PDF;
// use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class PACController extends Controller
{
  
    public function index()
    {
      
        $plots = DB::table('plots')->leftJoin('projects','projects.id','plots.pr_id')
        ->leftJoin('blocks','blocks.id','plots.bl_id')->leftJoin('categories','categories.id','plots.size')
        ->select('plots.*','projects.project_name as project','blocks.name as block','categories.name as size')
        ->get();
      
        return view('plots.record',compact('plots'));
    }

  
    public function create()
    {
        if (Auth::user()->hasPermission('browse_allotments')) {
            $custData = Booking::with(['customers','plots','payments'])->get();
          //
            return view('pac.create', compact('custData'));
        }else{
            $this->authorize('browse_allotments');
        }
        
    }

    function pending(){
        if (Auth::user()->hasPermission('browse_allotments')) {
            $custData = Booking::with(['customers','plots','payments'])->get();
            return view('pac.pending', compact('custData'));
        }else{
            $this->authorize('browse_allotments');
        }
    }

    function approved(){
        if (Auth::user()->hasPermission('browse_allotments')) {
            $custData = Booking::with(['customers','plots','payments'])->get();
            return view('pac.approved', compact('custData'));
        }else{
            $this->authorize('browse_allotments');
        }
    }

    function delivered(){
        if (Auth::user()->hasPermission('browse_allotments')) {
            $custData = Booking::with(['customers','plots','payments'])->get();
            return view('pac.delivered', compact('custData'));
        }else{
            $this->authorize('browse_allotments');
        }
    }

    function printCertificate($bookingID){

       
        // dd($bookingID);
        $bookOrder = Booking::where('id',$bookingID)->with(['customers','plots','allotment_Certificate','agents','payments'])->first();
        $agents = Agent::select('name','id')->get();

        return view('pac.certificatePreview',compact('bookOrder','agents'));   
    }

    function saveCertificate(Request $request){

        
        $id = $request->segment('4');
        $bookOrder = Booking::find($id)->with(['customers','plots','payments'])->first();


        // dd($bookOrder->customers->id); 
   
        $allot = Allotment::create([
            'customer_id'=>$bookOrder->customers->sal_customer_id,
            'booking_id'=>$id,
            'agent_id'=>$request->agent,
            'status'=>'Pending',
            'created_at'=>date('Y-m-d H:i'),
            'updated_at'=>date('Y-m-d H:i'),
            'created_by'=>Auth::user()->id,
            'created_by'=>Auth::user()->id
        ]);
        $plots2 = Booking::find($id)->with('plots','customers')->first();
        $plot = $plots2->plots->name;
        $customer = $plots2->customers->sal_customer_name;
        if (!empty($request->file) > 0) {
            foreach ($request->file  as $key => $item) {
                $path = "Storage/Files/".$plot."/".$customer."/Allotment";
                $doc_name =  time().rand(100, 999).".".$item->getClientOriginalExtension();
                $item->move($path, $doc_name);
                Document::create([
                "event_id" => $request->form_id,
                "event_value" => $allot->id,
                "file_id" => $request->file_id[$key],
                "file" => $doc_name,
                "path" => $path,
                'customer_id'=>$bookOrder->customers->sal_customer_id
            ]);
            }
        }
        $mobile = $plots2->customers->sal_customer_cell;
        $message = "Mr . ".$customer." Your allotment request has been created against Plot (".$plot.") .";
        $path = '/admin/pac/create';
        $return_message = 'Certifcate generated successfully ... !';
        

        return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);
        
    }
    function approveCertificate(Request $request){
     
        // return explode('/',url()->previous())[8];
        $allotment = Allotment::where('id',$request->allotmentID)->first();
        $allotment->status = 'Approved';
        $allotment->updated_by = $request->loggedUserID;
        $allotment->updated_at = date('Y-m-d H:i:s');
        $allotment->save();
 
        $bookOrder = Booking::where('id',$allotment->booking_id)->with(['customers','plots','allotment_Certificate'])->first();
    
        $duplicateOrNot = $allotment->type;
        $plot = $bookOrder->plots->name;
        $customer = $bookOrder->customers->sal_customer_name;
        // return $duplicateOrNot;
        $filename = $plot.'-allotment-'.date('Y-m-d').'-'.date('his').'.pdf';
        $path = "Storage/Files/".$plot."/".$customer."/Allotment";
        $DBpath = "Storage/Files/".$plot."/".$customer."/Allotment//".$filename;
        $allotment = Allotment::orWhere('booking_id',$request->allotmentID)->orWhere('id',$request->allotmentID)->first();
        $pth = env('APP_URL').'/'.$DBpath;
        $qr = new ApiController();
        $qrimg = $qr->allotment_qrcode($allotment->getTable(), $allotment->id,  $pth);
        $allotment->file = $DBpath;
        $allotment->save();
        $dateTime = date("F j, Y, g:i a");
        $pdf = PDF::loadView('pdf.certificatePreview',compact('bookOrder','duplicateOrNot','dateTime','qrimg'));
        if(!File::exists($path)) {
            $check = File::makeDirectory($path, $mode = 0755, true, true);    
        }
        $pdf = PDF::loadView('pdf.certificatePreview',compact('bookOrder','duplicateOrNot','dateTime','qrimg'))->save(''.$path.'/'.$filename);

        return "Approved Successfully.";
    }
    function printDCertificate($bookingID){
       
        $bookOrder = Booking::where('id',$bookingID)->with(['customers','plots','allotment_Certificate'])->first();

        return view('pac.duplicatePreview',compact('bookOrder'));  
    }
    function deliver(Request $request){
      
        $bookOrder = Allotment::where('id',$request->id)->with(['booking'])->first();
      
        $plot = $bookOrder->booking->plots->name;
        $customer = $bookOrder->booking->customers->sal_customer_name;
        $path = "Storage/Files/".$plot."/".$customer."/Allotment";
        $doc_name =  time().rand(100, 999).".".$request->file->getClientOriginalExtension();
        $request->file->move($path, $doc_name);
        $DBpath = "Storage/Files/".$plot."/".$customer."/Allotment//".$doc_name;
        $bookOrder = Allotment::where('id',$request->id)->first();
        $bookOrder->cnic = $DBpath;
        $bookOrder->status = "Delivered";
        $bookOrder->delivered_at = date('Y-m-d H:i:s');
        $bookOrder->save();
        Message::create([
            'event_id' => 14,
            'event_value' => $request->id,
            'msg_from' => Auth::user()->id,
            'msg_to' => Auth::user()->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'path' => url()->previous(),
            'status' => 0
      ]);

      $mobile = $bookOrder->booking->customers->sal_customer_cell;
      $message = "Mr . ".$customer." Your allotment request has been delivered against Plot (".$plot.") .";
      $path = '/admin/pac/create';
      $return_message = 'Certifcate has been delivered successfully ... !';
      

      return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);

    }
    function saveDCertificate(Request $request){

        
        $id = $request->segment('5');
        $bookOrder = Booking::find($id)->with(['customers','plots'])->first();


        // dd($bookOrder->customers->id); 
   
        $allot = Allotment::create([
            'customer_id'=>$bookOrder->customers->sal_customer_id,
            'booking_id'=>$id,
            'agent_id'=>$bookOrder->agent_id,
            'status'=>'Pending',
            'created_at'=>date('Y-m-d H:i'),
            'updated_at'=>date('Y-m-d H:i'),
            'created_by'=>Auth::user()->id,
            'type'=>"duplicate",
        ]);
        $plots2 = Booking::find($id)->with('plots','customers')->first();
        $plot = $plots2->plots->name;
        $customer = $plots2->customers->sal_customer_name;
        if (!empty($request->file) > 0) {
            foreach ($request->file  as $key => $item) {
                $path = "Storage/Files/".$plot."/".$customer."/Allotment";
                $doc_name =  time().rand(100, 999).".".$item->getClientOriginalExtension();
                $item->move($path, $doc_name);
                Document::create([
                    "event_id" => $request->form_id,
                    "event_value" => $allot->id,
                    "file_id" => $request->file_id[$key],
                    "file" => $doc_name,
                    "path" => $path,
                    'customer_id'=>$bookOrder->customers->sal_customer_id
            ]);
        }
        }
        return redirect('/admin/pac/approved')->with('message','Certifcate generated successfully.');
    }

    function pacDetails($allotmentID){
            // dd($allotmentID);
            if (Auth::user()->hasPermission('browse_allotments')) {
                $custData = Allotment::where('booking_id',$allotmentID)->with(['booking'])->where('type','duplicate')->get();
                //    dd($custData);
                return view('pac.allotments', compact('custData'));
            }else{
                $this->authorize('browse_allotments');
            }
    }
    
    public function search(Request $request)
    {
        $project = $request->project;
        $block = $request->block;
        $plot = Plot::latest()->first();
        if(isset($plot)){
            $plot_id = $plot->id + 1;
        }else{
            $plot_id = 1;
        }
      
       $new = $project.'-'.$block.'-'.$plot_id;
        return $new;
    }

    
    public function store(Request $request)
    {

    

        $key = 'AIzaSyC1RGpKCBAwMeclgpo_sqY6Y-XImRhpA30';

        if($request->atack_plot){
            $attach = json_encode($request->atack_plot);
        }else{
            $attach = "[]";
        }

        if($request->feature){
            $feature = json_encode($request->feature);
        }else{
            $feature = "[]";
        }
        
        Plot::create([
           'pr_id' => $request->project   ,
           'bl_id' => $request->block   ,
           'name' => $request->name   ,
           'length' => $request->Length   ,
           'width' => $request->width   ,
           'size' => $request->size  ,
           'status' => $request->status  ,
           'price' => $request->price   ,
           'attach_plot' => $attach ,
           'feature' => $feature ,
           'lattitude' => $request->latitude ,
           'longitude' => $request->longitude ,
           'location_title' => $request->address 
        ]);

        return back()->with('message','plot has been added successfully .....!');
    }


    public function show($id)
    {
        $plot = DB::table('plots')->leftJoin('projects','projects.id','plots.pr_id')
        ->leftJoin('blocks','blocks.id','plots.bl_id')->leftJoin('categories','categories.id','plots.size')
        ->where('plots.id',$id)
        ->select('plots.*','projects.project_name as project','blocks.name as block','categories.name as size')
        ->first();
        

        $plots = DB::table('plots')->leftJoin('projects','projects.id','plots.pr_id')
        ->leftJoin('blocks','blocks.id','plots.bl_id')->leftJoin('categories','categories.id','plots.size')
        ->select('plots.*','projects.project_name as project','blocks.name as block','categories.name as size')
        ->get();

        $attach = json_decode($plot->attach_plot);
        $feature = json_decode($plot->feature);
        return view('plots.record',compact('plot','plots','attach','feature'));
    }

    public function edit($id)
    {
        $plot = DB::table('plots')->where('id',$id)->first();
        $update = 1;
        $projects = DB::table('projects')->get();
        $blocks = DB::table('blocks')->get();
        $features = DB::table('features')->get();
        $size = DB::table('categories')->get();
        $plots = DB::table('plots')->get()->toArray();
        $attach = json_decode($plot->attach_plot);
        $feature = json_decode($plot->feature);
   
        
        return view('plots.create',compact('projects','blocks','size','plots','plot','update','attach','features','feature'));

    }

    
    public function update(Request $request, $id)
    {
        
       if($request->attach_plot){
        $json = json_encode($request->attach_plot);
       }else{
           $json = "[]";
       }

       if($request->feature){
        $feature = json_encode($request->feature);
       }else{
           $feature = "[]";
       }

        Plot::find($id)->update([
            'pr_id' => $request->project   ,
            'bl_id' => $request->block   ,
            'name' => $request->name   ,
            'length' => $request->Length   ,
            'width' => $request->width   ,
            'size' => $request->size  ,
            'status' => $request->status  ,
            'price' => $request->price   ,
            'attach_plot' => $json ,
            'feature' => $feature ,
            'lattitude' => $request->latitude ,
           'longitude' => $request->longitude ,
           'location_title' => $request->address 
           
        ]);
        return back()->with('message','Plot has been upfated successfully ...!');
       
    }

    public function destroy($id)
    {
      
        Plot::find($id)->delete();
        return back()->with('message','Plot has been deleted ...!');
    }


    public function approve($id)
    {
       
      
        Allotment::where('id',$id)->update([
            'status'=> 'Approved' ,
            'updated_by' => Auth::user()->id
        ]);
        return redirect('admin/pac/create')->with('message','Pac Request has been Approved ... !');
   
    }
    public function reject(Request $request)
    {
        if (Auth::user()->hasPermission('read_allotments')) {

            $transfer = Allotment::where('id',$request->id)->first();
            
            Message::create([
                  'event_id' => 14,
                  'event_value' => $transfer->id,
                  'msg_from' => Auth::user()->id,
                  'msg_to' => $transfer->created_by,
                  'subject' => $request->subject,
                  'message' => $request->message,
                  'path' => $request->path,
                  'status' => 0
            ]);
            Allotment::where('id',$request->id)->update(['status'=>"Rejected"]);
        return redirect('/admin/pac/create')->with('message','Allotment Request has been Rejected ... !');
    }else{
      
        $this->authorize('read_allotments');
    }


}
}
