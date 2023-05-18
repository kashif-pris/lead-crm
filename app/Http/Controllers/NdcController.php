<?php

namespace App\Http\Controllers;

use App\Models\Ndc;
use App\Models\Plot;
use App\Models\Booking;
use App\Models\Allotment;
use App\Agent;
use Illuminate\Http\Request;
use DB;
use Auth;
use File;
use PDF;
class NdcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = 1;
        // $custData = DB::table('allotments')->where('status', '=', $status)->get();
       $custData = Booking::with(['customers','plots','payments'])->where('status', '=', $status)->get();
       //dd($custData);
            return view('ndc.create', compact('custData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasPermission('browse_ndc')) {
            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            $custData = Booking::with(['customers','plots'])->get();
            return view('ndc.record', compact('custData'));
        }else{
      
            $this->authorize('browse_ndc');
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
        //
    }
    function printCertificate($bookingID){

       
       
        $bookOrder = Booking::where('id',$bookingID)->with(['customers','plots','allotment_Certificate','agents','payments'])->first();
        $ndc = Ndc::where('booking_id',$bookingID)->with(['allotment_Certificate'])->first();
        //dd($bookOrder);
        $agents = Agent::select('name','id')->get();

        return view('ndc.certificatePreview',compact('bookOrder','agents','ndc'));   
    }
    function approveCertificate(Request $request){
        
    //   return $request->all();
        $allotment = new Ndc;
        $allotment->booking_id = $request->bookingID;
        $allotment->status = 1;
        $allotment->updated_by = $request->loggedUserID;
        $allotment->updated_at = date('Y-m-d H:i:s');
        $allotment->created_by = Auth::user()->id;
        $allotment->updated_by = Auth::user()->id;
     //   return $allotment->booking_id;
        $bookOrder = Booking::where('id',$allotment->booking_id)->with(['customers','plots','allotment_Certificate'])->first();
        // $bookedPlots = DB::table('plots')->select('name')->where('size',$allotment->booking_id)->get();
        $duplicateOrNot = $allotment->type;
        $plot = $bookOrder->plots->name;
        $customer = $bookOrder->customers->sal_customer_name;
        // return $duplicateOrNot;
        $filename = $plot.'-Ndc-'.date('Y-m-d').'-'.date('his').'.pdf';
        $path = "Storage/Files/".$plot."/".$customer."/Ndc";
        $DBpath = "Storage/Files/".$plot."/".$customer."/Ndc/".$filename;
        $allotment->file = $DBpath;
        $allotment->save();
        $dateTime = date("F j, Y, g:i a");
        $pdf = PDF::loadView('pdf.certificatePreviewNdc',compact('bookOrder','duplicateOrNot','dateTime'));
        if(!File::exists($path)) {
            $check = File::makeDirectory($path, $mode = 0755, true, true);    
        }
        $pdf = PDF::loadView('pdf.certificatePreviewNdc',compact('bookOrder','duplicateOrNot','dateTime'))->save(''.$path.'/'.$filename);

       if($allotment->save()){
        // $qr = new ApiController();
        // dd($qr->generate_qrcode($allotment->getTable(), $bookOrder['ref_num'], $bookOrder['plot_size'] , $bookOrder['amount']));
        return "Approved Successfully.";
       }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ndc  $ndc
     * @return \Illuminate\Http\Response
     */
    public function show(Ndc $ndc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ndc  $ndc
     * @return \Illuminate\Http\Response
     */
    public function edit(Ndc $ndc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ndc  $ndc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ndc $ndc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ndc  $ndc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ndc $ndc)
    {
        //
    }
}
