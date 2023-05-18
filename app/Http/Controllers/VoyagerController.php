<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use League\Flysystem\Util;
use TCG\Voyager\Facades\Voyager;
// use App\User;
use DB;
use Carbon\Carbon;
use App\Book;
use App\Author;

use App\Agent;


use App\Models\Booking;
use App\Models\Cancelation;
use App\Models\Customer;
use App\Models\Merge;
use App\Models\Transfer;
use App\Models\Plot;
use App\Models\Leads;
use App\Models\Allotment;
use App\Models\User;
use App\Models\ReciptDetails;
use App\Models\InstallmentMaster;
use App\Models\InstallmentDetails;
use App\Models\CallRecoveryMan;

use App\Models\ReciptMaster;
use DataTables;
class VoyagerController extends \TCG\Voyager\Http\Controllers\VoyagerController
{
    public function index()
    {   
   
        
       
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('voyager.login');
    }

    public function upload(Request $request)
    {
        $fullFilename = null;
        $resizeWidth = 1800;
        $resizeHeight = null;
        $slug = $request->input('type_slug');
        $file = $request->file('image');

        $path = $slug.'/'.date('F').date('Y').'/';

        $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
        $filename_counter = 1;

        // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
        while (Storage::disk(config('voyager.storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
        }

        $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

        $ext = $file->guessClientExtension();

        if (in_array($ext, ['jpeg', 'jpg', 'png', 'gif'])) {
            $image = Image::make($file)
                ->resize($resizeWidth, $resizeHeight, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            if ($ext !== 'gif') {
                $image->orientate();
            }
            $image->encode($file->getClientOriginalExtension(), 75);

            // move uploaded file from temp to uploads directory
            if (Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $image, 'public')) {
                $status = __('voyager::media.success_uploading');
                $fullFilename = $fullPath;
            } else {
                $status = __('voyager::media.error_uploading');
            }
        } else {
            $status = __('voyager::media.uploading_wrong_type');
        }

        // echo out script that TinyMCE can handle and update the image in the editor
        return "<script> parent.helpers.setImageValue('".Voyager::image($fullFilename)."'); </script>";
    }

    public function dashboard(){

   
        $latest_books = [];
        
        // Latest orders
        $latest_authors = [];
            $booking = Booking::all()->count();
            $allotment = Allotment::all()->count();
            $cancelation = Cancelation::all()->count();
            if(Auth::user()->role_id == '1')
            {
                $customer = Leads::all()->count();
            }else{
                $customer = Leads::where('allocated_to' , Auth::user()->id)->get()->count();
            }
            $merge = Merge::all()->count();
            $transfer = Transfer::all()->count();
            $user = User::all()->count();
            $agent = Agent::all()->count();
            $plot = Plot::all()->count();
      
            $plot_booked = Plot::selectRaw('is_booked , count(id) as count')->groupBy('is_booked')->get()->toArray();
            $plot_customers = Booking::with(['customers','plots'])->get()->toArray();
            // $agent_name = Leads::with('agent' ,'reminders_call','events')->withCount('reminders_call' , 'events')->get();
            $agent_count = User::where('role_id' , '5')->withCount('agent_lead_count' ,'agent_event_count' , 'agent_call_count')->get()->toArray();
            // dd($agent_count);
            // dd($agent_name);
            // dd($customer);
  
        
            return view('dashboardview.show',compact('agent_count','plot_customers','booking','allotment','cancelation','customer','merge','transfer','user','agent','plot','plot_booked'));
    
       

     }

     public function saveModel(Request $request)
     {
         $value = new CallRecoveryMan;
         $value->date = $request->date;
         $value->description = $request->note;
         $value->call_type = $request->type;
         $value->call_status = 'Pending';

         $value->save();
         return back();
     }

     public function index_data(Request $request)
     {
         if ($request->ajax()) {
            $customers = InstallmentMaster::join('tbl_sal_customer_master', 'tbl_sal_customer_master.sal_customer_id', '=', 'InstallmentMaster.customerid')
                ->join('bookings','bookings.id' , '=', 'InstallmentMaster.FormNo')
                ->where('bookings.status',1)
                ->select(
                    'tbl_sal_customer_master.sal_customer_id',
                    'tbl_sal_customer_master.sal_customer_name',
                    'tbl_sal_customer_master.sal_customer_cell',
                    'bookings.ref_num',
                    'InstallmentMaster.installmentId',
                );
        
    
             $data = Booking::select('id','customer_id');
             return Datatables::of($customers)
                     ->addIndexColumn()
                     ->addColumn('balance', function($row){
                                $master = InstallmentMaster::where('installmentId',$row->installmentId)->first();
                                $balance = $master->RemainingAmount;
                                return 'PKR '.number_format($balance).' /-';
                        })
                        ->addColumn('today_payable', function($row){

                            $today = InstallmentDetails::where(['installmentId'=>$row->installmentId,'month'=>date('Y-m-d 00:00:00.000')])->first();
                            if($today){
                                return 'PKR '.number_format($today->MonthlyInstallment).' /-';
                            }else{
                                return 'PKR '.number_format(0).' /-';
                            }
                    })
                     ->addColumn('action', function($row){
                            
                            $btn = '<a target="_blank" href="/admin/payments/installment/'.$row->installmentId.'" class="edit btn btn-primary btn-sm">&nbsp;&nbsp; View Details &nbsp;&nbsp; </a>
                                    <a type="button" class="edit btn btn-success btn-sm" onclick="addReminder('.$row->sal_customer_id.')" data-toggle="modal" data-target="#myModal" >Add Reminder</a>';
     
                             return $btn;
                     })
                     ->rawColumns(['action'])
                     ->make(true);
         }
     }

}



