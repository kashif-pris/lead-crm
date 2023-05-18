<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Models\Leads;
use Illuminate\Http\Request;
use DNS2D;
use DB;
use Auth;
use App\Project;
use App\Models\User;
use App\Models\CallLogs;
use App\Models\Event;
use App\Models\CallRecoveryMan;
use App\Models\LeadComments;
use Response;
use Config;
use Illuminate\Support\Facades\Hash;
use carbon\carbon;

use function PHPUnit\Framework\returnSelf;

class ApiController extends VoyagerController
{
    const CALL_STATUS_PENDING = 'pending';
    // public function leads()
    // {

    //     if (auth()->user()) {

    //         if (auth()->user()->user_id == 1) {
    //             $leads = Leads::with('reminders', 'comments', 'agent')->get();
    //          dd($leads);
    //         } else {
    //             $leads = Leads::with('reminders', 'comments', 'agent')->where('allocated_to', auth()->id())->get();
             
    //         }
    //         $response = [
    //             'leads' => $leads,

    //         ];
    //         return response($response, 201);
    //     } 
    //     else {
    //         $response = [
    //             'leads' => [],

    //         ];
    //         return response($response, 404);
    //     }
    // }

    public function post_comment(Request $request)
    {
        if($request->comments != '')
        {
            $post_comment = new LeadComments();
            $post_comment->lead_id = $request->lead_id;
            $post_comment->comments = $request->comments;
            $post_comment->created_by = auth()->user()->id;
            $post_comment->save();
            return Response('Comment Saved Successfully');
        }else{
            return Response('Please Enter Comment');
        }



    }
    public function specific_lead(Request $request)
    {
        
        $customer = Leads::with('comments','reminders','agent','project')->where('id',$request->id)->first();
        $lead_status = Config::get('app.lead_status');
        $reminder_types =Config::get('app.reminder_types');
        $response = Config::get('app.response');
        $source = Config::get('app.source');
        $projects= Project::get(['id','project_name']);
        $agents = User::where('role_id',['5','8'])->get(['id','name']);

        return Response::json(['customer_update'=>$customer , 'lead_status'=>$lead_status, 'reminder_types'=>$reminder_types ,'response' =>$response , 'source'=>$source,'projects'=>$projects, 'agents'=>$agents]);
        
    }

    public function followup_leads_get(Request $request)
    {
        // if($request->lead_id)
        // {
            $leads = Leads::with('data')->get();
            // return $leads;
            return Response::json(['followUpLeads'=>$leads]);
        // } 
        // return Response::json('Please Enter Lead Id');
    }

    public function followup_leads(Request $request)
    {
    //    return $request->all();
     if($request)
        {
            $remainder =  new CallRecoveryMan();
            $remainder->date = $request->date;
            $remainder->description = $request->description;
            $remainder->lead_id = $request->id;
            $remainder->type = $request->type;
            $remainder->call_status = "pending";
            $remainder->call_type = $request->call_type;
            $remainder->created_by =auth()->user()->id;
         
            $remainder->save();

            $event = new Event();
            $event->start = $remainder->date;
            $event->end = $remainder->date;
            $event->lead_id = $remainder->lead_id;
            $event->title =  $remainder->description;
            $event->created_by = Auth::user()->id;

            $lead_update = Leads::where('id', $request->lead_id)->first();
            if ($lead_update) {
                $lead_update->active_reminder = $request->type;
                if (@config::get('app.lead_status')[$request->type]) {
                    $lead_update->status = @config::get('app.lead_status')[$request->type];
                }
                $lead_update->save();
            }
            return Response::json('Follow Up Leads Successfully');
            // return Response::json($lead_update_status);
        }
    }
    

    public function update_leads(Request $request)
    {
        
        
        // if($request->status == ''){
        //     $status = 'New Leads';
        // }else{
        //     $status = $request->status;
        // }
        if(!empty($request))
        {
            $leads_update = Leads::find($request->id);
            $leads_update->name = $request->name;
            $leads_update->email = $request->email;
            $leads_update->phone =  $request->phone;
            $leads_update->project_name = $request->project_name;
            $leads_update->city = $request->city;
            $leads_update->status = $request->status;
            $leads_update->description = $request->description;
            $leads_update->allocated_to = $request->allocated_to;
            $leads_update->source = $request->source;
            $leads_update->response = $request->response;
            $leads_update->created_by = auth()->user()->id;
            $leads_update->created_at = date('Y-m-d h:i:s');
            $leads_update->save();
            // return $leads;
            return Response:: json($leads_update);
        }else{
            return Response('Please Fill the Form..!');
        }
            
        $lead_status = Config::get('app.lead_status');
        $reminder_types =Config::get('app.reminder_types');
        $response = Config::get('app.response');
        $source = Config::get('app.source');
        return Response::json(['customer_update'=>$leads_update , 'lead_status'=>$lead_status, 'reminder_types'=>$reminder_types ,'response' =>$response , 'source'=>$source]);
    }



public function add_leads(Request $request)
{
    // return $request->all();

 
    // $full_number = $request->phone_number;
    if($request->status == ''){
        $status = 'New Leads';
    }else{
        $status = $request->status;
    }
    if(!empty($request))
        {
            $leads = new Leads();
            $leads->name = $request->name;
            $leads->phone =  $request->phone;
            $leads->project_name = $request->project_name;
            $leads->city = $request->city;
            $leads->status = $status;
            $leads->description = $request->lead_description;
            $leads->allocated_to =  $request->allocated_to;
            $leads->source = $request->source;
            $leads->response = $request->response;
            $leads->created_by = auth()->user()->id;
            $leads->created_at = date('Y-m-d h:i:s');
            $leads->save();
            //follow up addded
            $remainder =  new CallRecoveryMan();
            $remainder->date = $request->date;
            $remainder->description = $request->followup_description;
            $remainder->lead_id = $leads->id;
            $remainder->type = $request->type;
            $remainder->call_status = "pending";
            $remainder->call_type = $request->call_type;
            $remainder->created_by =auth()->user()->id;
         
            $remainder->save();

            $event = new Event();
            $event->start = $remainder->date;
            $event->end = $remainder->date;
            $event->lead_id = $leads->id;
            $event->title =  $remainder->description;
            $event->created_by = auth()->user()->id;
            $event->save();
            $lead_update = Leads::where('id', $leads->id)->first();
            if ($lead_update) {
                $lead_update->active_reminder = $request->type;
                if (@config::get('app.lead_status')[$request->type]) {
                    $lead_update->status = @config::get('app.lead_status')[$request->type];
                }
                $lead_update->save();
            }
            $post_comment = new LeadComments();
            $post_comment->lead_id = $leads->id;
            $post_comment->comments = $request->comments;
            $post_comment->created_by = auth()->user()->id;
            $post_comment->save();
            // return $leads;
            return Response('Lead Added Successfully');
        }else{
            return Response('Please Fill the Form..!');
        }

}

    public function leads(Request $request)
    {
        $user = auth()->user();
        return $request;
        // return Carbon::now();
        // date_default_timezone_set('Asia/Karachi');
        // return 'test';
        $leads = Leads::with('reminders', 'comments', 'agent','project')->limit(50)->get();
        $response = [
            'leads' => $leads,

        ];
        // if (auth()->user()) {

        //     if (auth()->user()->id == 1) {
        //         $leads = Leads::with('reminders', 'comments', 'agent','project')->get();
           
        //     } 
            
        //     else {
        //         $leads = Leads::with('reminders', 'comments', 'agent','project')->where('allocated_to', auth()->user()->id)->get(); 
        //     }
        //     $response = [
        //         'leads' => $leads,

        //     ];
        //     return $leads;
        //     // return response($response, 200);
        // }
        // else {
        //     $response = [
        //         'leads' => [],

        //     ];
          
        //     // return response($response, 404);
           
        // }


        return Response::json($response);
    }

    public function targets()
    {

        if (auth()->user()) {

            if (auth()->user()->user_id = 1) {
                $agent = Agent::get();
            } else {
                $agent = Agent::where('project_id', auth()->id())->get();
            }
            $response = [
                'agent' => $agent,

            ];
            return response($response, 201);
        }
        else {
            $response = [
                'agent' => [],

            ];
            return response($response, 404);
        }
    }
    public function agents()
    {
        // return $agent = Agent::get();
        if (auth()->user()) {

            if (auth()->user()->user_id = 1) {
                $agent = Agent::with('projects')->get();
            } else {
                $agent = Agent::where('project_id', auth()->id())->get();
            }
            $response = [
                'agent' => $agent,

            ];
            return response($response, 201);
        }
        else {
            $response = [
                'agent' => [],

            ];
            return response($response, 404);
        }
    }
    public function callLogs( Request $request)
    {
        // return $request->all();
            $user_log = callLogs::where('user_id',$request->id)->first();
           if($user_log){
            $user_log->delete();
            $call_logs = new CallLogs();
            $call_logs->user_id = $request->id;
            $call_logs->call_logs =  $request->call_logs;
            $call_logs->status =  '0';
            $call_logs->save();
           }else{
            $call_logs = new CallLogs();
            $call_logs->user_id = $request->id;
            $call_logs->call_logs =  $request->call_logs;
            $call_logs->status =  '0';
            $call_logs->save();
           }
           
            
            
            return 'ok';
        // }
    }
    public function leads_phone(){
        $phone = Leads::select('phone','id')->get();
        $response = [
            'phone' => $phone,

        ];
        return response($response, 201);
    }


  public  function login(Request $request)
    {
        // return $request->all();
        $user= User::where('email', $request->email)->first();
        // print_r($user);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
             $token = $user->createToken('my-app-token')->plainTextToken;
      
            $response = [
                'user' => $user,
                'token' => $token
            ];
         
        
             return response($response, 201);
            //  return Response::json($user);
             
    }

    
        // APp Home Screen
    public function appHome(Request $request){  
        return $this->dashboard($request);
    }
    public function sms($mobile,$message,$path,$return_message){
        $api_key = "923078881628-0b3712be-eff9-443c-9da1-530a8bd0444f";
        $sender = "SenderID";

        ////sending sms

        $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&message=".urlencode($message)."";
        $url = "https://sendpk.com/api/sms.php?api_key=$api_key";
        $ch = curl_init();
        $timeout = 30; // set to zero for no timeout
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = curl_exec($ch);
        
        return redirect($path)->with('message',$return_message);
    }


    public function generate_qr($entity,$id,$MasterData){
     
            
            $qrData = [
                'Total AMount'=>$MasterData->TotalAgreedPrice,
                'Paid Amount'=>$MasterData->PaidAmount,
                'Balance'=>$MasterData->RemainingAmount
            ];
            $qr = json_encode($qrData);
            $srcImage ="data:image/png;base64,".DNS2D::getBarcodePNG(($qr), "QRCODE")."";
            DB::table($entity)->where('sal_receipt_no',$id)->update(['qr_code'=>$srcImage]);
            // $srcImage ="data:image/png;base64,".DNS2D::getBarcodePNG(('https://prismatic-technologies.com'), "QRCODE" , 3,3)."";
            
            $qr_code = $srcImage;
        $resp = ['data'=>$qrData,'image'=>$srcImage,'message'=>"Record Saved Successfully"];
        return $resp;
    }

    public function generate_qrcode($entity,$id,$MasterData,$balance){
     
            
        $qrData = [
            'Reference Number'=>$id,
            'Size'=>$MasterData,
            'Balance'=>$balance
        ];
        $qr = json_encode($qrData);
        $srcImage ="data:image/png;base64,".DNS2D::getBarcodePNG(($qr), "QRCODE")."";
        DB::table($entity)->where('ref_num',$id)->update(['qr_code'=>$srcImage]);
        // $srcImage ="data:image/png;base64,".DNS2D::getBarcodePNG(('https://prismatic-technologies.com'), "QRCODE" , 3,3)."";
        
                $qr_code = $srcImage;
            $resp = ['data'=>$qrData,'image'=>$srcImage,'message'=>"Record Saved Successfully"];
            return $resp;
    }
    public function allotment_qrcode($entity,$id,$path){
        $srcImage ="data:image/png;base64,".DNS2D::getBarcodePNG(($path), "QRCODE" , 3,3)."";
        DB::table($entity)->where('id',$id)->update(['qr_code'=>$srcImage]);
        return $srcImage;
    }
}
