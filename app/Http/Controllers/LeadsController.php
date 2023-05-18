<?php

namespace App\Http\Controllers;

use App\Models\CallRecoveryMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportLeads;
use App\Exports\ExportLeads;
use App\Models\Leads;
use App\Models\Plot;
use App\Models\Event;
use App\Models\User;
use App\Models\LeadComments;
use App\Models\ApiIntegrationSetting;
use App\Models\ApiIntegrationAgents;
use TCG\Voyager\Facades\Voyager;
use App\Project;
use App\Agent;
use Config;
use URL;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Category;
use DataTables;
use Facebook\Facebook;

class LeadsController extends Controller
{
    const ALL_LEADS = 'All Leads';
    const BUTTON_FILTER = 'Button Filter';
    const DATE_FILTER = 'Date Filter';
    const REMINDER_TYPE = 'finding';
    const CALL_STATUS_PENDING = 'pending';
    const AGENT_ID = 5;
    const MANAGER_ID = 8;
    public $managerAgents = [];
    public function __construct()
    { 
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
        $this->id = Auth::user()->id;
        if(Auth::user()->role_id == '1' || Auth::user()->role_id == '5' ){
            $myAgents = [];
        }else{
           
            $manager = User::where('id',$this->id)->first();
            $myAgents = $manager::getManagerAgents();
        }
     
        $this->managerAgents = $myAgents;
            return $next($request);
        });

    }
   
    function leadsIndex(Request $request)
    {
        dd($request->all());
        
        // dd('oka');
        // return $request->agent;
        // return($this->managerAgents);
        if(Auth::user()->role_id != '5'){
            if(Auth::user()->role_id == 8){
                    if($request->agent == 0){
                  
                    $leadsData = Leads::with('comments','project','reminders','agent')
                                    ->select('Leads.*')->whereIn('allocated_to', array_values($this->managerAgents))->orWhere('allocated_to', $this->id);
                    }else{
                        $leadsData = Leads::with('comments','project','reminders','agent')
                        ->select('Leads.*')->whereIn('allocated_to',[$request->agent]);
         
                    }
            }else{
            $leadsData = Leads::with('comments','project','reminders','agent')
                                // ->orderBy('id','desc')
                                ->select('Leads.*');
            }

        }
        else{
          
        $leadsData = Leads::with('comments','project','reminders','agent')
                            // ->orderBy('id','desc')
                            ->select('Leads.*')->where('allocated_to',Auth::user()->id);
        }
        $routeName = explode('/',url()->previous());
        $status = 'All';
        if(array_key_exists(6,$routeName)){
         
            $routeName = explode('/',url()->previous());
            $status = str_replace('%20',' ', $routeName[6]);
            $Leadsdata = $leadsData->where('status',$status);
        }
       
         $user = Auth::User();
       if(!empty($request->start_date) && !empty($request->end_date) || !empty($request->agent) )
        {
            $data = $request->only('start_date','end_date','agent');
           
            if ($data['start_date'] && $data['start_date'] != '0' ) {
                $leadsData->where("created_at", ">=" ,$data['start_date']);
            }
            if ($data['end_date']) {
                $leadsData->where("created_at", "<=" ,$data['end_date']);                
            }
          
             if ($data['agent']) {
              
                   $leadsData->where('allocated_to', $data['agent']);
            }
          
            $Leadsdata = $leadsData->select('Leads.*')->get();
           
         } else{
            $Leadsdata =  $leadsData->limit(50)->get();
        } 
        
        // leads datatable
        return Datatables::of($Leadsdata)
                    ->addIndexColumn()
                    ->addColumn('selected_leads', function ($data) {
                        return '<input type="checkbox" class="data_leads" data-id-leads-delete="'.$data->id.'" name="leads[]" value="'.$data->id.'"/>';
                    })
                    ->addColumn('action', function($data){
                            $btn = '<a target="_blank" href="/admin/leads/edit/'.$data->id.'" class="btn btn-primary btn-xs">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                
                                <a  target="_blank" href="/admin/leads/show/'.$data->id.'"class="btn btn-info btn-xs deleteRecord">
                                    <i class="fa fa-eye"></i>
                                </a>
                            
                                
                                ';
                        
                        return $btn;
                    })
                    ->addColumn('id', function ($data) {
                        return @$data->id;
                    })
                    ->addColumn('name', function ($data) {
                        return 
                        '<a target="_blank" href="/admin/leads/show/'.$data->id.'">
                                    '.
                                    @$data->name
                                    .'
                                </a>';
                    })
                    ->addColumn('response', function ($data) {
                        
                        if($data->response){
                            return  $data->response;
                        }
                        return "N/A";
                        
                    })
                    ->addColumn('phone', function ($data) {
                        return '<a  href="tel:'.$data->phone.'" >'.$data->phone.'</a>';
                    })
                    ->addColumn('agent', function ($data) {
                        return '<a href="#0">
                                    '.@$data->agent->name.'
                                </a>';
                    })
                    ->addColumn('project', function ($data) {
                        return '<a href="#0">
                                   '.@$data->project->project_name.'
                                </a>';
                    })
                    ->addColumn('city', function ($data) {
                        return  $data->city;
                    })
                    ->addColumn('date', function ($data) {
                        return  $data->created_at->format('d-m-Y');
                    })
                    ->addColumn('comments', function ($data) {
                     $commentsList = '';
                      foreach($data->comments as $key=>$comment){
                        $old_date = date($comment->created_at);
                        $old_date_timestamp = strtotime($old_date);
                        $new_date = date('d-m-Y', $old_date_timestamp);
                        $commentsList.='
                                        <li>
                                            <div class="commenterImage">
                                                <img src="https://www.pngitem.com/pimgs/m/150-1503945_transparent-user-png-default-user-image-png-png.png" />
                                            </div>
                                            <div class="commentText">
                                                <textarea readonly name="" id="" cols="30" rows="4">'.@$comment->comments.'</textarea>
                                                <span class="date sub-text">'.$new_date.' by '.@$comment->user->name.'</span>

                                            </div>
                                        </li>
                        ';
                      }

                     

                      $commentBox = '
                                    <a style="background:green;" href="#0" title="Comments" class="customClass_'.$data->id.' badge-sm badge-primary pull-right delete" data-id="2" id="delete-2">
                                   
                                    <i class="voyager-chat"></i> <span class="hidden-xs hidden-sm" onClick="openBox('.$data->id.',`open`)" >Comments</span>
                                        <div class="detailBox showBox_'.$data->id.'">
                                            <div class="titleBox">
                                                <label>Comment Box</label>
                                                <span style=" float: right; " onClick="openBox('.$data->id.',`open`)"><i class="fa fa-times" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="actionBox showBox_">
                                                <ul class="commentList append_'.$data->id.'">
                                                '.$commentsList.'

                                                </ul>
                                            
                                                <div class="form-group">
                                                    <input class="form-control comment_'.$data->id.'" id ="comment" name = "comment" type="text" placeholder="Your comments" />
                                                    <input type="text" class="lead_id" data-id="'.$data->id.'" id="lead_id" name="lead_id" value ="'.$data->id.'" hidden>
                                                </div>
                                                <div class="form-group">
                                                    <button  class="btn btn-default cBTN" onclick="commentSubmit('.$data->id.',``)">ADD</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                  
                                        </a>
                                ';
                      return $commentBox;

                    })
                    ->addColumn('reminder', function ($data) {
                        
                        return '<a hre="javascript:void(0)" onclick="showReminderModal('.$data->id.')" class="badge badge-success hidden-sm" data-toggle="tooltip" data-placement="right" title="Follow Up">Follow Up</a>';
                    })
                    ->addColumn('status', function ($data) {
                        $statusArray = config::get('app.lead_status');
                        $options = '';
                       
                        foreach($statusArray as $status){
                            if($data->status == $status){
                                        $selected = 'selected';
                            }else{
                                $selected='';
                            }
                           $options.=' <option '.$selected.' value="'.$status.'">'.$status.'</option>';
                        }
                     
                        return '
                            <select onchange="changeStatus('.$data->id.')" class="lead_'.$data->id.'" style=" border: 1px solid #737479; color: white; background: #48887a; ">
                                '.$options.'
                            </select>
                        ';
                    })
                    
                    
                    ->setRowClass(function ($data) {
                        return 'deleteClass_lead_row_'.$data->id;
                    })
                    ->rawColumns(['name','phone','agent','comments','project','action','reminder','status','selected_leads'])
                    ->make(true);
     

    }
    public function index()
    {
        
        $filtersWithCount = $this->getAssociatedLeadStatus();
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;
        $leads = $this->getAllLeads();

        
        return view('leads.records', compact('leads', 'filtersWithCount', 'agents','myAgents'));
    }
    public function AgentwiseReport(Request $request)
    {
        $date_filter = null;
        $start_date = null;
        $end_date = null;
        $slug = 'roles';
        $dropagents = $this->getAgents();
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $agents = $this->getAgents();
        return view('leads.agent-wise-report',compact( 'dataType','agents','dropagents','date_filter','start_date','end_date'));
    }
    public function AgentwiseStatusReport(Request $request)
    {
        // dd($request->all());
        $date_filter = null;
        $start_date = null;
        $end_date = null;
        $user = Auth::user();
        $leadsData = Leads::with('comments','project','reminders','agent')
                    ->select('Leads.*');
        $slug = 'roles';
        $dropagents = $this->getAgents();
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        if(!empty($request['agents']) && $request['agents'] != '0'){
           
            $agents = User::where('id',$request['agents'])->get();
            // dd($agents);
        }else{
            $agents = $this->getAgents();
        }
        
        //    dd($agents);
            if($request['statusBased'] && $request['statusBased'] != '0' )
            {
                $leadsData->where('allocated_to', @$request['statusBased']);
            }
            if(isset($request['timestamp']) && $request['timestamp'] != '0' && $request['timestamp'] != 'custom')
            {
                $date_filter = $request['timestamp'];
                $leadsData->where('created_at','>=', $request['timestamp']);          
                
            }elseif($request['timestamp'] == 'custom'){
                 $start_date=$request['datetime_start_from'];
                 $end_date=$request['datetime_date_to'];
                $leadsData->where('created_at','>=', $request['datetime_start_from']); 
                $leadsData->where('created_at','<=', $request['datetime_date_to']);          
            }
        return view('leads.agent-wise-report',compact( 'leadsData','dataType','dropagents','agents','date_filter','start_date','end_date'));
    }
    public function show($id)
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $lead = Leads::where('id', $id)->with('comments', 'project','partnerData')->first();
        // dd($lead->partnerData);
        return view('leads.show', compact('lead', 'dataType'));
    }


    public function New(Request $request)
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $user = Auth::user();
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;
        if($user->role_id != 5){
            $leads = Leads::where('status', 'new')->get();
        }else {
            $leads = Leads::where('status', 'new')->where('allocated_to', $user->id)->get();

        }

        return view('leads.records', compact('leads', 'dataType', 'agents','myAgents'));
    }

    public function create(Request $request)
    {
        // dd($request);
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $user = Auth::user();
        if($user->role_id != 5){
            $updatedleads = Leads::get();
        }else{
            $updatedleads = Leads::where('allocated_to',$user->id)->get();

        }
        $offices = Plot::get();
        $projects = Project::get();
        if(Auth::user()->role_id == 1){
            $agents = $this->getManagerAgents();
            // dd($agents);
        }elseif(Auth::user()->role_id == 8){
            
            $agents = $this->managerAgents;
          
        }else{
            $agents = User::where('role_id',5)->where('id',Auth::user()->id)->get();
        }


        



        return view('leads.create',compact('projects','agents','updatedleads','offices','dataType'));
    }

    public function importView(Request $request)
    {
        $agents = User::whereIn('role_id',['5','8'])->where('status','1')->get();
        // dd($agents);
        return view('leads.import-leads',compact('agents'));
    }
    public function UANConfigrationView(Request $request)
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $agents = User::whereIn('role_id',['5','8'])->where('status','1')->get();
        // dd($agents);
        return view('leads.uan-configration',compact('agents','dataType'));
    }
    public function configrationApi(Request $request)
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        if($request->facebook == 'fb'){
            $fb = 'fb';
        }else{
            $fb =  'uan';
        }
        // dd($request->agent_id);
        $apiconfig = ApiIntegrationSetting::create([
            'agent_id' => json_encode($request->agent_id),
            'facebook' => $fb,
            'api_duration' => $request->api_duration,
            'account_id' => $request->account_id,
            'app_id' => $request->app_id,
            'compaign_id' => $request->compaign_id,
            'fb_token' => $request->fb_token,
            'base_path' => $request->base_path,
            'uan_token' => $request->uan_token,
        ]);
        foreach($request->agent_id as $key=>$a){
            $agentdata = User::where('id',$a)->where('status','1')->first();
            // dd($agentdata);
            $SelectedAgents = ApiIntegrationAgents::create([
                'integration_id' => $apiconfig->id,
                'agent_id' => $agentdata->id,
                'date' => date('Y-m-d'),
                'lead_count' => '0',
            ]);
        }
        $agents = User::whereIn('role_id',['5','8'])->get();
        return view('leads.uan-configration',compact('apiconfig','agents','dataType'));
    }

    public function import(Request $request)
    {
        Session::put('agents', $request->agent_id);
        $import = Excel::import(new ImportLeads ,$request->file('file')->store('files'));

        return redirect()->to('/admin/leads/get-filter/New%20Leads');
    }

    public function exportLeads(Request $request)
    {
        return Excel::download(new ExportLeads, 'Leads-export.xlsx');
    }

    public function edit($id)
    {
        // dd($id);
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $leads = Leads::where('id', $id)->first();
        $offices = Plot::get();
        $projects = Project::get();
        // dd($projects);
        if(Auth::user()->role_id == 1){
            $agents = $this->getManagerAgents();
        }elseif(Auth::user()->role_id == 8){
            $agents = $this->managerAgents;
        }else{
            $agents = User::where('role_id',5)->where('id',Auth::user()->id)->get();
        }

        $categoires =Category::get();

        return view('leads.create', compact('projects', 'agents','categoires', 'leads', 'offices', 'dataType'));
        // $slug = 'roles';
        // $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // $projects = Project::get();
        // $agents = Agent::get();

        // return view('leads.create',compact('projects','agents','dataType','leads'));
    }

    public function store(Request $request)
    {
        //  dd($request->all());
        if($request->status == ''){
            $status = 'New Leads';
        }else{
            $status = $request->status;
        }
         $str = $request->phone_number['full'];
        $full_number = substr($str, 1);
        $customer = Leads::create([

            'name' => $request->name,
            // 'inventory_id' => $request->inventory_id,
            'email' => $request->email,
            'phone' => $full_number,
            'project_name' => $request->project_name,
            'city' => $request->city,
            'status' => $status,
            'description' => $request->description,
            'allocated_to' => $request->allocate_to,
            'source' => $request->source,
            'response' => $request->response,
            'created_by' => Auth::user()->id,
            'partner' => $request->partner,
        ]);
        return redirect('/admin/leads/record')->with('message', 'Lead has been created ... !');

    }

    function closeLead($id)
    {
        $customer = Leads::where('id', $id)->update([
            'status' => 'Closed Won',
        ]);
        return back()->with('message', 'Lead status has been updated ... !');

    }

    public function update(Request $request, $id)
    {

        // dd($request->all());
        $str = $request->phone_number['full'];
        $full_number = substr($str, 1);
// dd($str);

        $customer = Leads::where('id', $id)->update([

            'name' => $request->name,
            // 'inventory_id' => $request->inventory_id,
            'email' => $request->email,
            'phone' => $str,
            'project_name' => $request->project_name,
            'allocated_to' => $request->allocate_to,
            'city' => $request->city,
            'status' => $request->status,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'source' => $request->source,
            'response' => $request->response,
            'Category_id' => $request->Category_id,
            'qty' => $request->qty,
            'partner' => $request->partner,
        ]);

        return redirect('/admin/leads/record')->with('message', 'Leads has been Updated ... !');
    }

    public function destroy(Request $request)
    {
        if(!empty($request)){
            $leads_id = $request->leads_ids;
            // return  $leads_id;
            // DB::table("leads")->whereIn('id',explode(",",$leads_id))->delete();
            foreach($leads_id as $l){
                    Leads::where('id', $l)->delete();
            }
            return response()->json(['success'=>"Leads Deleted successfully."]);
        }
        else{
            return redirect('/admin/leads/record')->with('message', 'Please select leads to Delete...!');
        }
    }
    public function AssingedLeads(Request $request)
    {
        if(!empty($request)){
            $leads_id = $request->leads_ids;
            $agent_id = $request->agentID;
            // return  $agent_id;
            foreach($leads_id as $l){
                    Leads::where('id', $l)->update([
                        'allocated_to' => $agent_id
                    ]);
            }
            return response()->json(['success'=>"Leads Deleted successfully."]);
        }
        else{
            return redirect('/admin/leads/record')->with('message', 'Please select leads to Delete...!');
        }
    }
    public function UanAssingedLeads(Request $request)
    {
        if(!empty($request)){
            $leads_id = $request->leads_ids;
            $agent_id = $request->agentID;
            return  $agent_id;
            // foreach($leads_id as $l){
            //         Leads::where('id', $l)->update([
            //             'allocated_to' => $agent_id
            //         ]);
            // }
            return response()->json(['success'=>"Leads Assigned successfully."]);
        }
        else{
            return redirect('/admin/leads/record')->with('message', 'Please select leads to Delete...!');
        }
    }
    public function post_comments(Request $request)
    {
        $new_comments = LeadComments::
        create([
            'lead_id' => $request->lead_id,
            'comments' => $request->comment,
            'created_by' => Auth::user()->id,
        ]);
        if ($request->from_form) {
            return back()->with('message', 'Comment has been added ... !');
        }
        return 'success';
    }

    public function GetLeadsWithFilter($filterName,Request $request)
    {
        // dd($filterName);
        $filtersWithCount = $this->getAssociatedLeadStatus();
        // dd($filtersWithCount);
        $leads = $this->getLeadBystatus($filterName,$request);
        // dd($lead);
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;

        return view('leads.records', compact('leads', 'filtersWithCount', 'agents','myAgents'));
    }

    function getLeadsWithDateRange(Request $request)
    {
      
        $data = $request->request->all();
        $agents = $this->getAgents();
        $filtersWithCount = $this->getAssociatedLeadStatus();
        $leads = $this->getLeadByWithDateRangeStatus($data);
        $myAgents = $this->managerAgents;
    //    dd($leads);
        return view('leads.records', compact('leads', 'filtersWithCount', 'agents','myAgents'));
    }


    public function GetLeadsbydate($start,$end)
    {


    $user = Auth::user();
    if($user->role_id != '5'){
        $leadsFollowUp = DB::table('events')
                                ->leftjoin('Leads','Leads.id','events.lead_id')
                                ->where('events.start','>=',$start)
                                ->where('events.start','<',$end)
                                // ->whereNotNull('events.lead_id')
                                ->select('events.title','events.lead_id','events.id','events.start')
                                ->get();
    }else{

        $leadsFollowUp = DB::table('events')
                            ->leftjoin('Leads','Leads.id','events.lead_id')
                            ->where('events.start','>=',$start)
                            ->where('events.start','<',$end)
                            ->where('leads.allocated_to',$user->id)
                            ->select('events.title','events.lead_id','events.id','events.start')
                            ->get();
    }
        // dd($leadsFollowUp);
         return view('leads.recordtoday', compact('leadsFollowUp'));
    }

    public function GetLeadsBaseOnRouteName($routeName , Request $request)
    {
        // dd($routeName);
        // dd($request->all());
        $agent_id = null;
        $lead_source = null;
        $lead_status = null;
        $response_search = null;
        $today = null;
        $dateStart = null;
        $dateTo = null;
        $statusName = ucwords(str_replace("-", " ", $routeName));
        $filtersWithCount = [];
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;
        // dd($statusName);
        if ($statusName === self::ALL_LEADS) {
         
            $filtersWithCount = $this->getAssociatedLeadStatus();
            $leads = $this->getAllLeads();
        //    dd($leads[0]->comments);
        }if ($statusName === self::BUTTON_FILTER) {
            $filtersWithCount = $this->getAssociatedLeadStatus();
            $leads = $this->getLeadBystatus($statusName , $request);
            $agent_id = $request['statusBased'];
            $lead_status =$request['status_search'];
            $lead_source =$request['source_search'];
            $response_search =$request['response_search'];
            if($request['timestamp'] == 'custom')
            {
                $today = 'custom';
            }else{
                $today = $request['timestamp'];
            }
            $dateStart=$request['datetime_start_from'];
            $dateTo = $request['datetime_date_to'];
            
        } else {
            // dd('ok');
            $leads = $this->getLeadBystatus($statusName , $request);
        }

        return view('leads.records', compact('leads', 'filtersWithCount','lead_source', 'response_search','agents','myAgents' , 'agent_id' , 'lead_status' , 'today','dateStart','dateTo'));
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $search_value = $request->search;
        $filtersWithCount = [];
        // dd($filtersWithCount);
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;
        $data = Leads::where('name', 'like', '%'.$search_value.'%')->orWhere('phone', 'like', '%'.$search_value.'%')->pluck('id')->toArray();
        $leads = Leads::whereIn('id' , $data)->orderBy('id','desc')->paginate(50); 
        // dd($leads);
        return view('leads.records', compact('leads', 'filtersWithCount', 'agents','myAgents','search_value'));
    }

    public function button_filter(Request $request)
    {
        // dd($request->all());
        $filtersWithCount = [];
        $statusBased_value = $request->statusBased;
        $timeStamp_Value = $request->timestamp;
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;
        if($request->statusBased )
        {
            $leads = Leads::where('allocated_to' ,$request->statusBased)->orderBy('id','desc')->paginate(50); 
            return view('leads.records', compact('leads', 'filtersWithCount', 'agents','myAgents' , 'statusBased_value'));
        }
        if($request->timestamp != 'custom')
        {
            
            $leads = Leads::where('created_at' , '>=' , $request->timestamp)->orderBy('id','desc')->paginate(50); 
            return view('leads.records', compact('leads', 'filtersWithCount', 'agents','myAgents', 'timeStamp_Value'));
        }
        if($request->statusBased && $request->timestamp != 'custom')
        {
            $leads = Leads::where('allocated_to' ,$request->statusBased)->orWhere('created_at' , '>=' , $request->timestamp)->orderBy('id','desc')->paginate(50); 
            return view('leads.records', compact('leads', 'filtersWithCount', 'agents','myAgents' , 'timeStamp_Value' , 'statusBased_value'));
        }
    }
    public function date_filter(Request $request)
    {
        // dd($request->all());
        $slug = 'roles';
        $today= null;
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        if($request->timestamp == 'custom')
            {
                $today = 'custom';
            }else{
                $today = $request->timestamp;
            }
        $filtersWithCount = [];
        $timeStamp_Value = $request->timestamp;
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;
       
        if($request->timestamp != 'custom')
        {
            $status = CallRecoveryMan::where('date' ,$request->timestamp)->where('created_by', Auth::user()->id)->orderBy('id','desc')->paginate(50); 
            return view('leads.followup-list', compact('status','dataType' ,'filtersWithCount', 'agents','myAgents' , 'timeStamp_Value'));
        }
        if($request->timestamp == 'custom'){
            $status= CallRecoveryMan::where('date','>=', $request->datetime_start_from)->where('date','<=', $request->datetime_date_to)->where('created_by', Auth::user()->id)->orderBy('id','desc')->paginate(50);  
            return view('leads.followup-list', compact('status','dataType' ,'filtersWithCount', 'agents','myAgents' , 'timeStamp_Value'));      
        }
        // if($request->timestamp == 'overdue_followups'){
        //     $status= CallRecoveryMan::where('followup_status' ,'pending')->where('date','>=', $request->datetime_start_from)->where('date','<=', $request->datetime_date_to)->where('created_by', Auth::user()->id)->orderBy('id','desc')->paginate(50);  
        //     return view('leads.followup-list', compact('status','dataType' ,'filtersWithCount', 'agents','myAgents' , 'timeStamp_Value'));      
        // }
    }
    public function pending_date_filter(Request $request)
    {
        // dd($request->all());
        $slug = 'roles';
        $today= null;
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        if($request->timestamp == 'custom')
            {
                $today = 'custom';
            }else{
                $today = $request->timestamp;
            }
        $filtersWithCount = [];
        $timeStamp_Value = $request->timestamp;
        $agents = $this->getAgents();
        $myAgents = $this->managerAgents;
       
        if($request->timestamp != 'custom')
        {
            $status = Event::where('end' ,$request->timestamp)->where('created_by', Auth::user()->id)->orderBy('id','desc')->paginate(50); 
            return view('leads.pending-followup-list', compact('status','dataType' ,'filtersWithCount', 'agents','myAgents' , 'timeStamp_Value'));
        }
        if($request->timestamp == 'custom'){
            $status= Event::where('end','>=', $request->datetime_start_from)->where('end','<=', $request->datetime_date_to)->where('created_by', Auth::user()->id)->orderBy('id','desc')->paginate(50);  
            return view('leads.pending-followup-list', compact('status','dataType' ,'filtersWithCount', 'agents','myAgents' , 'timeStamp_Value'));      
        }
        // if($request->timestamp == 'overdue_followups'){
        //     $status= CallRecoveryMan::where('followup_status' ,'pending')->where('date','>=', $request->datetime_start_from)->where('date','<=', $request->datetime_date_to)->where('created_by', Auth::user()->id)->orderBy('id','desc')->paginate(50);  
        //     return view('leads.followup-list', compact('status','dataType' ,'filtersWithCount', 'agents','myAgents' , 'timeStamp_Value'));      
        // }
    }
    public function getLeadBystatus($name , Request $request)
    {
        if(Auth::user()->role_id != '5'){

            if(Auth::user()->role_id == 8){
                    if($request['statusBased'] == 0){                  
                        $leadsData = Leads::with('comments','project','reminders','agent')
                                    ->select('Leads.*')
                                    ->whereIn('allocated_to', array_values($this->managerAgents))
                                    ->orWhere('allocated_to', $this->id);
                    }else{
                        $leadsData = Leads::with('comments','project','reminders','agent')
                                    ->select('Leads.*')
                                    ->whereIn('allocated_to',[$request['statusBased']]);         
                    }
            }else{
                    $leadsData = Leads::with('comments','project','reminders','agent')
                                    ->select('Leads.*');
                    if($name != 'Button Filter' && $name != 'Search Lead'){
                        // dd($name);
                        $leadsData = Leads::with('comments','project','reminders','agent')
                                        ->where('status',$name)
                                        ->select('Leads.*');
                    }
            }

        }
        else{    
            // dd('agent111');      
        $leadsData = Leads::with('comments','project','reminders','agent')
                            // ->orderBy('id','desc')
                            ->select('Leads.*')->where('allocated_to',Auth::user()->id);
                            // dd('test' ,$leadsData);
        }
        if($name == 'Search Lead')
        {            
            // dd($leadsData->get());
          $leadsData->where('phone', 'like', '%'.$request['search'].'%');
            
        //   dd($leadsData->get());
        }
        if($name == 'Button Filter')
        {
            $statusName = ucwords(str_replace("+", " ", $request['status_search']));
            if($request['statusBased'] && $request['statusBased'] != '0' )
            {
                $leadsData->where('allocated_to', @$request['statusBased']);
            }
            if($request['source_search'] && $request['source_search'] != '0' )
            {
                $leadsData->where('source', @$request['source_search']);
            }
            if($request['response_search'] && $request['response_search'] != '0' )
            {
                $leadsData->where('response', @$request['response_search']);
            }
            if($statusName && $statusName != '0' )
            {
                $leadsData->where('status', @$request['status_search']);
            }
            if(isset($request['timestamp']) && $request['timestamp'] != '0' && $request['timestamp'] != 'custom')
            {
                $leadsData->where('created_at','>=', $request['timestamp']);          
                
            }elseif($request['timestamp'] == 'custom'){
                $leadsData->where('created_at','>=', $request['datetime_start_from']); 
                $leadsData->where('created_at','<=', $request['datetime_date_to']);          
            }
          
        }
        return $leadsData->orderBy('id','desc')->paginate(50)->setPath(\Request::fullUrl());
    }

    public function getLeadBytoday($name)
    {

        return Leads::whereDate('created_at', Carbon::today())->where('status', $name)->get();
    }
    // public function getNewLeads()
    // {
    //     $user = Auth::user();
    //     if ($user->role_id != '5') {
    //         return Leads::with('comments')->where('status','New Leads')->get();
    //     } else {
    //         return Leads::with('comments')->where('allocated_to', $user->id)->where('status','New Leads')->get();
    //     }
    // }
    public function getAllLeads()
    {
        $user = Auth::user();
        if ($user->role_id != '5') {
            return Leads::with('comments')->orderBy('id','desc')->paginate(50);
        } else {
            return Leads::with('comments')->where('allocated_to', $user->id)->orderBy('id','desc')->paginate(50);
        }
    }

    public function createReminderForLead(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'date' => 'required',
            'description' => 'required',
            'reminder_type' => 'required',
        ]);
        $data = $request->request->all();
        // dd($data['date']);
        $originalDate = $data['date'];
        $newDate = date("Y-m-d H:m:s:s", strtotime($originalDate));
        //    dd($newDate);
       
        CallRecoveryMan::create([
            'date' => $newDate,
            'description' => $data['description'],
            'lead_id' => $data['lead_id'],
            'type' => $data['reminder_type'],
            'call_status' => self::CALL_STATUS_PENDING,
            'call_type' => config::get('app.reminder_types')[$data['reminder_type']],
            'created_by' => Auth::user()->id,

        ]);
        $updateFollowUp = CallRecoveryMan::where('lead_id',$request->lead_id)->where('date',date('Y-m-d'))->update([
            'status' => '1'
        ]);
        // return $updateFollowUp;
        Event::create([
            'start' => $newDate,
            'end' => $newDate,
            'lead_id' => $data['lead_id'],
            'title' => $data['description'],
            'created_by' => Auth::user()->id,

        ]);
        // return CallRecoveryMan::where('lead_id', $data['lead_id'])->get();
        $filtersWithCount = $this->getAssociatedLeadStatus();
        $leads = $this->getAllLeads();
        // updating icon on lead for specific reminder
        $lead = Leads::where('id', $data['lead_id'])->first();
        if ($lead) {
            $lead->active_reminder = $data['reminder_type'];
            if (@config::get('app.lead_status')[$data['reminder_type']]) {
                $lead->status = @config::get('app.lead_status')[$data['reminder_type']];
            }
            $lead->save();
        }
        return CallRecoveryMan::where('lead_id', (int)$data['lead_id'])->get();
        // return 0;
    }

    public function GetReminderWithLeadId($id)
    {
        return CallRecoveryMan::where('lead_id', (int)$id)->get();
        // return 0;
    }

    public function deleteLeadReminderById(Request $r)
    {
        $id = $r->id;
        $leadReminder = CallRecoveryMan::find((int)$id);
        $leadReminder->delete();
        return 1;
    }

    public function deleteCommentChat(Request $request)
    {
        $id = $request->id;
        $comment = LeadComments::where('id',$id)->first();
 

        if ($comment) {
            $comment->delete();
            return 1;
        } else {
           return 0;
        }
    }

    public function getAssociatedLeadStatus()
    {
        $user = Auth::user();
        if($user->role_id != '5'){
            if($user->role_id == 8){
                return DB::table('leads')
                        ->select(DB::raw('count(1) as statusCount'), 'status')
                        ->whereIn('allocated_to',$this->managerAgents)
                        ->groupBy('status')
                        ->get();
            }
            return DB::table('leads')
                ->select(DB::raw('count(1) as statusCount'), 'status')
                ->groupBy('status')
                ->get();
        }else{
            return DB::table('leads')
                    ->select(DB::raw('count(1) as statusCount'), 'status')
                    ->where('allocated_to',$user->id)
                    ->groupBy('status')
                    ->get();
        }
    }

    public function FollowUplist()
    {
       
        $slug = 'roles';
        // dd(Auth::user()->role_id);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        if(Auth::user()->role_id == '1'){
            $status = CallRecoveryMan::where('date',date('Y-m-d'))
                                    ->where('status', NULL)
                                    ->orderBy('id','desc')
                                    ->get();
        }if(Auth::user()->role_id == '5'){
            $status = CallRecoveryMan::where('date',date('Y-m-d'))
                                    ->orderBy('id','desc')
                                    ->where('status', NULL)
                                    ->where('created_by',Auth::user()->id)
                                    ->get();
        }
        if(Auth::user()->role_id == '8'){
            $status = CallRecoveryMan::where('date',date('Y-m-d'))
                                    ->orderBy('id','desc')
                                    ->where('status', NULL)
                                    ->where('created_by',Auth::user()->id)
                                    ->get();
        }
        
        // $lead = Leads::where('id' , $status[0]->lead_id)->first();
        // dd($lead);
        // dd($status);
        return view('leads.followup-list',compact('status','dataType'));
    }
    public function pendingFollowups()
    {
       
        $slug = 'roles';
        // dd(Auth::user()->role_id);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        if(Auth::user()->role_id == '1'){
            $status = CallRecoveryMan::where('date','<',date('Y-m-d'))
                            ->where('call_status','pending')
                            ->orderBy('id','desc')
                            ->get();
        }if(Auth::user()->role_id == '5'){
            $status = CallRecoveryMan::where('date','<',date('Y-m-d'))
                            ->where('call_status','pending')
                            ->orderBy('id','desc')
                            ->where('created_by',Auth::user()->id)
                            ->get();
        }
        if(Auth::user()->role_id == '8'){
            $status = CallRecoveryMan::where('date','<',date('Y-m-d'))
                            ->where('call_status','pending')
                            ->orderBy('id','desc')
                            ->where('created_by',Auth::user()->id)
                            ->get();
        }
        
        // $lead = Leads::where('id' , $status[0]->lead_id)->first();
        // dd($lead);
        // dd($status);
        return view('leads.pending-followup-list',compact('status','dataType'));
    }
    public function getUANleads()
    {
       
        $slug = 'roles';
        // dd(Auth::user()->role_id);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $agents = $this->getAgents();
        $manager = User::where('id',$this->id)->first();
        $myAgents = $manager::getManagerAgents();
        return view('leads.uan-leads',compact('dataType','agents','myAgents'));
    }
    public function UanLeads(Request $request)
    {
        // dd($request->all());
        $slug = 'roles';
        // dd(Auth::user()->role_id);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://zong-cap.com.pk:93/api/customer/incoming-calls?date_from='.$request->date_from.'&date_to='.$request->date_to.'&api_token=UUf4VXNSYvHmMjNSRRCadzoxKj1eJkFryrIixlGUiWHZgY6bwC08APB3l8Nd',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $uanCalls = json_decode($response);
                $agents = $this->getAgents();
                $manager = User::where('id',$this->id)->first();
                $myAgents = $manager::getManagerAgents();
                // dd($uanCalls);
                return view('leads.uan-leads',compact('uanCalls' , 'dataType','agents','myAgents'));

    }
    // public function won_commission($id)

    // {


    //     $projects = Project::get();
    //     $agents  = Agent::get();
    //     $leads  = Leads::get();

    //     return view('leads.won-commission',compact('projects','agents','leads'));
    // }


    public function won_commission($id)
    {
        // dd($id);
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $leads = Leads::where('id', $id)->first();
        $offices = Plot::get();
        $projects = Project::get();
        // dd($projects);
        $agents = User::where('role_id',5)->get();

        return view('leads.won-commission', compact('projects', 'agents', 'leads', 'offices', 'dataType'));
        // $slug = 'roles';
        // $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // $projects = Project::get();
        // $agents = Agent::get();

        // return view('leads.create',compact('projects','agents','dataType','leads'));
    }

    public function Next30Minutes()
    {
        $user = Auth::user();
        // if($user->role_id != '5'){
        //     $followUpsCount30 =  DB::table('events')
        //                     ->where('start','=', Carbon::now()->addMinutes(30)->format('Y-m-d H:i:00:000'))
        //                     ->count();
        //     $followUpsCount5 =  DB::table('events')
        //                     ->where('start','=', Carbon::now()->addMinutes(5)->format('Y-m-d H:i:00:000'))
        //                     ->count();
        //     $found = $followUpsCount30 + $followUpsCount5 ;
        // }else{
            $leads =  Leads::with('comments')->where('allocated_to',$user->id)->pluck('id');

            $followUpsCount30 =  DB::table('events')
                                ->whereIn('lead_id',$leads)
                                ->where('start','=', Carbon::now()->addMinutes(30)->format('Y-m-d H:i:00:000'))
                                ->count();
            $followUpsCount5 =  DB::table('events')
                                ->whereIn('lead_id',$leads)
                                ->where('start','=', Carbon::now()->addMinutes(5)->format('Y-m-d H:i:00:000'))
                                ->count();
            $found = $followUpsCount30 + $followUpsCount5 ;
        // }
        return $found;
    }
    public function checkfollowup()
    {
        // date_default_timezone_set("Asia/Karachi");
        // $date =date('Y-m-d H:i:s')
        $user = Auth::user();
        $events = CallRecoveryMan::where('date' , '<=', Carbon::today())->where('created_by',$user->id)->where('call_status','!=','done')->get();
        $leads = Leads::where('id',@$events->lead_id)->update([
            'status' => 'Overdue Leads'
        ]);
        return $leads;
    }
    public function StatusChangeFollowups(Request $request)
    {
        // return $request->all();
        $user = Auth::user();
        $events = CallRecoveryMan::where('id' ,$request->id )->update([
            'call_status'=> 'done'
        ]);
        return $events;
    }

    public function activity_log()

    {

        $filtersWithCount = $this->getAssociatedLeadStatus();
        $leads = $this->getAllLeads();

        $events = Event::where('created_at' , '>=', Carbon::today())->get();

        // dd($events);
        return view('leads.activity-log', compact('filtersWithCount' , 'events'));

    }

    public function activity_show($id)

    {
        $filtersWithCount = $this->getAssociatedLeadStatus();
        $leads = $this->getAllLeads();
        // $events_data = Event::where('id' , $id)->fis
        $events = Event::where('created_at' , '>=', Carbon::today())->get();
        $events = Event::where('id' , $id)->first();
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();


        return view('leads.activity-show', compact('dataType', 'events','leads' ));

    }
  function deleteFollow($id){
        DB::table('events')->where('id',$id)->delete();
        return back();
    }
   

    function change_lead_status(Request $request){
         Leads::where('id',$request->id)->update(['status'=>$request->status]);  
         return 'success';
    }
    function change_lead_response(Request $request){
        Leads::where('id',$request->id)->update(['response'=>$request->status]);  
        return 'success';
   }
    private function getLeadByWithDateRangeStatus(array $data)
    {
        $recordsData = Leads::select('leads.*');

        if ($data['status']  != '0' ) {
            $recordsData->where('status', $data['status']);          
        }
        if ($data['agent-id']  != '0' ) {
            $recordsData->where('allocated_to', $data['agent-id']);            
        }
        if ($data['start-date'] != null) {
            $recordsData->where("created_at", ">=" ,$data['start-date']);
        } 
       
        if ($data['end-date'] != null) {
            $recordsData->where("created_at", '<=' ,$data['end-date']);
        } 

        return $recordsData->get();
       

        // dd($recordsData->get(),$data['status'],$data['agent-id'],$data['start-date'],$data['end-date']);

    }

    private function getAgents()
    {
        
        return User::orWhere('role_id', self::AGENT_ID)->orWhere('role_id', self::MANAGER_ID)->orWhere('status', 1)->get();
    }
    private function getManagerAgents()
    {
        
        return User::orWhere('role_id', self::AGENT_ID)->orWhere('role_id', self::MANAGER_ID)->orWhere('status', 1)->get();
    }
    
   
   public function mobile(Request $request)
   {   
       // return $request->mobile;
       $str = $request->mobile;
       $full_number = substr($str, 1);
       $check_Number = Leads::where('phone' , $full_number)->first();
       if($check_Number){
           return $check_Number;
       }else{
           return 0;
       }
   }

   public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null){
    
   }
   public function ClientList(){
    //  dd('ok');
     $slug = 'roles';
     $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
     $clients = Leads::with('agent')->orderBy('id','desc')->paginate(200000);
    //  dd($clients);
     return view('leads.client-list', compact('dataType','clients'));
   }
  
   public function get_export(Request $request){
    return Excel::download(new ExportLeads, 'contacts.xlsx');
    return redirect()->back();
}
public function fb_leads(Request $request){
    
    $slug = 'roles';
    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    $fbint_data = ApiIntegrationSetting::where('uan_token',Null)->get();
    foreach($fbint_data as $fbint_data){
        $fb = new Facebook([
            'app_id' => $fbint_data->app_id,
            'app_secret' => $fbint_data->account_id,
            'default_graph_version' => 'v16.0',
        ]);
        $access_token = $fbint_data->fb_token;
        try {
            $adId = $fbint_data->compaign_id;
            $response = $fb->get('/' . $adId . '/leads', $access_token);
            $leads = $response->getGraphEdge();
            $data = $leads->getIterator();
            $agent_ids = json_decode($fbint_data->agent_id);
           $this->assigToAgents($data,$agent_ids);
            return view('leads.fb-leads', compact('dataType','data'));
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            dd($e);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            dd($e, 2);
        }
    }

}    

        function assigToAgents($data,$agents){
            
            $rows = $data;
            // dd($agents);
            $perAgent = round(count($rows) / count($agents));
            $checking = $perAgent*count($agents);
            if($perAgent > 0){
                $difference = count($rows) - $checking;
            }else{
                $difference = 0;
            }
            // dd(count($rows), count($agents),$perAgent);
            // dd($difference,$agents);
                        $agentIndex = 0;
                        $index = 1;
                        $result = [];
                        if($perAgent >= 1){
                            foreach($rows as $rowKey => $row) {
                                // dd(json_decode($row)->field_data);
                            
                               
                                if($index <= $perAgent){
                                    
                                        try {
                                            if(array_key_exists($agentIndex, $agents)){
                                                // $result[$agents[$agentIndex]->id][] = $row[2];
                                                // dd($agents[$agentIndex]->id);
                                                $fbLead = $this->formatFieldData(json_decode($row)->field_data);
                                                if($fbLead != ''){
                                                    $checkphone = Leads::where('phone',(string)$fbLead['phone'])->first();
                                                    if(empty($checkphone)){
                                                            $fbLead['created_at'] = date('Y-m-d');
                                                            $fbLead['project_name'] = 1;
                                                            $fbLead['source'] = 'Facebook';
                                                            $fbLead['created_by'] = Auth::user()->id;
                                                            $fbLead['allocated_to'] = $agents[$agentIndex];
                                                            $fbLead['status'] = 'New Leads';
                                                            $fbLead['temperature'] = 'Moderate';
                                                            Leads::create($fbLead);
                                                        }else{
                                                            $fbLead['created_at'] = date('Y-m-d');
                                                            $fbLead['project_name'] = 1;
                                                            $fbLead['source'] = 'Facebook';
                                                            $fbLead['created_by'] = Auth::user()->id;
                                                            $fbLead['allocated_to'] ='1';
                                                            $fbLead['status'] = 'Duplicate Lead';
                                                            $fbLead['temperature'] = 'Moderate';
                                                            Leads::create($fbLead);
                                                        }
                                                    }
                                                    $index++;
                                                }
                                        
                                            

                                        } catch (\Exception $exception) {
                                            dd($exception);
                                            Log::error($exception);
                                        }
                                    }else{
                                        
                                        $agentIndex++;
                                        $index = 1;
                                        
                                        
                                    
                                        if(array_key_exists($agentIndex, $agents)){
                                            $agent =$agents[$agentIndex]; 
                                            // $result[$agent][] = $row[2];
                                            // dd($agent);
                                            $fbLead = $this->formatFieldData(json_decode($row)->field_data);
                                            $checkphone = Leads::where('phone',(string)$fbLead['phone'])->first();
                                            if(empty($checkphone)){
                                                $fbLead['created_at'] = date('Y-m-d');
                                                $fbLead['project_name'] = 1;
                                                $fbLead['source'] = 'Facebook';
                                                $fbLead['created_by'] = Auth::user()->id;
                                                $fbLead['allocated_to'] = $agents[$agentIndex];
                                                $fbLead['status'] = 'New Leads';
                                                $fbLead['temperature'] = 'Moderate';
                                                Leads::create($fbLead);
                                                }else{
                                                    $fbLead['created_at'] = date('Y-m-d');
                                                    $fbLead['project_name'] = 1;
                                                    $fbLead['source'] = 'Facebook';
                                                    $fbLead['created_by'] = Auth::user()->id;
                                                    $fbLead['allocated_to'] ='1';
                                                    $fbLead['status'] = 'Duplicate Lead';
                                                    $fbLead['temperature'] = 'Moderate';
                                                    Leads::create($fbLead);
                                                }
                                        }
                                        $index++;
                                    }

                            }
                        }else{
                            foreach($rows as $key=>$last){
                                if(array_key_exists($agentIndex, $agents)){
                                    $agent =$agents[$agentIndex]; 
                                    $fbLead = $this->formatFieldData(json_decode($last)->field_data);
                                    if($fbLead != ''){
                                        $checkphone = Leads::where('phone',(string)$fbLead['phone'])->first();
                                        if(empty($checkphone)){
                                                    $fbLead['created_at'] = date('Y-m-d');
                                                    $fbLead['project_name'] = 1;
                                                    $fbLead['source'] = 'Facebook';
                                                    $fbLead['created_by'] = Auth::user()->id;
                                                    $fbLead['allocated_to'] = $agents[$agentIndex];
                                                    $fbLead['status'] = 'New Leads';
                                                    $fbLead['temperature'] = 'Moderate';
                                                    Leads::create($fbLead);
                                            }else{
                                                    $fbLead['created_at'] = date('Y-m-d');
                                                    $fbLead['project_name'] = 1;
                                                    $fbLead['source'] = 'Facebook';
                                                    $fbLead['created_by'] = Auth::user()->id;
                                                    $fbLead['allocated_to'] ='1';
                                                    $fbLead['status'] = 'Duplicate Lead';
                                                    $fbLead['temperature'] = 'Moderate';
                                                    Leads::create($fbLead);
                                            }
                                    }
                                    $agentIndex++;
                                }
                               
                            }
                        }
                        if($difference > 0){
                            // dd(iterator_to_array($rows), json_decode($row)->field_data);
                            $RemainingItems = array_slice(iterator_to_array($rows), -$difference);
                            // dd($RemainingItems);
                            foreach($RemainingItems as $key=>$last){
                                if(array_key_exists($key, $agents)){
                                    $agent =$agents[$key]; 
                                    // $result[$agent][] = $last[2];
                                    $fbLead = $this->formatFieldData(json_decode($last)->field_data);
                                    if($fbLead != ''){
                                        $checkphone = Leads::where('phone',(string)$fbLead['phone'])->first();
                                        if(empty($checkphone)){
                                                    $fbLead['created_at'] = date('Y-m-d');
                                                    $fbLead['project_name'] = 1;
                                                    $fbLead['source'] = 'Facebook';
                                                    $fbLead['created_by'] = Auth::user()->id;
                                                    $fbLead['allocated_to'] = $agent;
                                                    $fbLead['status'] = 'New Leads';
                                                    $fbLead['temperature'] = 'Moderate';
                                                    Leads::create($fbLead);
                                            }else{
                                                    $fbLead['created_at'] = date('Y-m-d');
                                                    $fbLead['project_name'] = 1;
                                                    $fbLead['source'] = 'Facebook';
                                                    $fbLead['created_by'] = Auth::user()->id;
                                                    $fbLead['allocated_to'] ='1';
                                                    $fbLead['status'] = 'Duplicate Lead';
                                                    $fbLead['temperature'] = 'Moderate';
                                                    Leads::create($fbLead);
                                            }
                                    }
                                }
                               
                            }
                            
                        }
            // dd($result);

           
        }
        function formatFieldData($fields){
                    $leadFormat = [];
                    $index = 0;
                    foreach($fields as $field){
                        // name
                        if($index == 0){
                            $leadFormat['name']= $field->values[0];
                        }
                         // phone
                         if($index == 2){
                            $leadFormat['phone']= $field->values[0];
                        }
                         // email
                         if($index == 3){
                            $leadFormat['email']= $field->values[0];
                        }
                         // description
                         if($index == 1){
                            $leadFormat['description']= $field->values[0];
                        }
                        
                    $index++;
                    }
                    return $leadFormat;
        }
}
