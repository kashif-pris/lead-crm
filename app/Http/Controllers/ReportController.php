<?php

namespace App\Http\Controllers;

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
use App\Models\Message;
use App\Models\Downpayment;
use App\Models\InstallmentMaster;
use App\Models\InstallmentDetails;

use ReflectionClass;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Database\Schema\Table;
use TCG\Voyager\Database\Types\Type;
use TCG\Voyager\Events\BreadAdded;
use TCG\Voyager\Events\BreadDeleted;
use TCG\Voyager\Events\BreadUpdated;




class ReportController extends Controller
{
    
    
    public function index()
    {
        if (Auth::user()->hasPermission('plot_transfer_report')) {
            $slug = 'roles';
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
            $transfer = Transfer::with('customerFrom','customerTo','plots','users','usersUpdate')->get();
            $plots = Plot::where('is_booked',1)->get();
            return view('plot-report.search',compact('dataType','transfer','plots'));
        }else{
      
            $this->authorize('browse_transfer');
        }
     
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
    ->select('categories.name','bookings.id as booking_id','bookings.customer_id','plots.status','plots.price','blocks.name as bl_name','projects.project_name as project','plots.feature')
    ->first();

    $installments = new InstallmentMaster();
    $installmentMaster = $installments->where('FormNo',$plot->booking_id)->with('details')->first();

    $totalInstallments =  $installments->where('InstallmentId',$installmentMaster->InstallmentId)->first()->TotalInstallments;
    $totalPaidInstallments =  $installments->where('InstallmentId',$installmentMaster->InstallmentId)->first()->TotalPaidInstallments;
    $downPayment = Booking::where('id',$plot->booking_id)->first()->DownPayment;
    $remainingAmount = $installments->where('InstallmentId',$installmentMaster->InstallmentId)->first()->RemainingAmount;
    $paidAmount = Booking::where('id',$plot->booking_id)->first()->PaidAmount;
    
    $getInfo = Transfer::where('plot_id',$id)->where('status',1)->first();
    $totalTransfer = $getInfo->TotalTransfers;
    $totaEarnedMoney = $getInfo->EarnedMoney;
    $reservedPerson =  $getInfo->ReservedBy;
    $chartAmount = $getInfo->DrawChart;



    //   return $remainingAmount;

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
          'category'=> $plot->status,
          'reservedPerson'=> $reservedPerson,
          'totaEarnedMoney'=> number_format($totaEarnedMoney),
          'totalTransfer'=> $totalTransfer,
          'chartAmount'=>$chartAmount






    ];

    $sizes = json_encode($size);
    return $sizes;      
}

    function tranferDetails($plotID){
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $plots = Plot::where('is_booked',1)->get();
        $transfer = Transfer::with('customerFrom','customerTo','plots','users','usersUpdate')->where('plot_id',$plotID)->where('status',1)->get();
       // dd($transfer);
        return view('plot-report.transfer-detail',compact('dataType','transfer','plots'));
    }


}
