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
use TCG\Voyager\Facades\Voyager;
use App\Project;
use App\Agent;
use Config;
use URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Models\Category;

class LeadsController extends Controller
{
    const ALL_LEADS = 'All Leads';
    const REMINDER_TYPE = 'finding';
    const CALL_STATUS_PENDING = 'pending';

    public function index()
    {
        
        $filtersWithCount = $this->getAssociatedLeadStatus();
        $leads = $this->getAllLeads();

        return view('leads.records', compact('leads', 'filtersWithCount'));
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
        if($user->role_id != 5){
            $leads = Leads::where('status', 'new')->get();
        }else{
            $leads = Leads::where('status', 'new')->where('allocated_to',$user->id)->get();

        }
        // $comment = DB::table('php_comments')->where('created_by' ,Auth::user()->id )->get();
        // dd($leads);
        return view('leads.records', compact('leads', 'dataType'));
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
        $agents = User::where('role_id',5)->get();

       
     
        return view('leads.create',compact('projects','agents','updatedleads','offices','dataType'));
    }

    public function importView(Request $request)
    {
        return view('leads.import-leads');
    }

    public function import(Request $request)
    {
        // dd($request->all());
        $import = Excel::import(new ImportLeads, $request->file('file')->store('files'));

        return redirect()->to('/admin/leads/all-leads');
    }

    public function exportLeads(Request $request)
    {
        return Excel::download(new ExportLeads, 'Leads.xlsx');
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
        $agents = User::where('role_id',5)->get();
     
        $categoires =Category::get();

        return view('leads.create', compact('projects', 'agents','categoires', 'leads', 'offices', 'dataType'));
        // $slug = 'roles';
        // $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // $projects = Project::get();
        // $agents = Agent::get();

        // return view('leads.create',compact('projects','agents','dataType','leads'));
    }

 

    function closeLead($id)
    {
        $customer = Leads::where('id', $id)->update([
            'status' => 'Closed Won',
        ]);
        return back()->with('message', 'Lead status has been updated ... !');

    }

    public function store(Request $request)
    {
        //  dd($request->phone_number['full']);
        $customer = Leads::create([

            'name' => $request->name,
            // 'inventory_id' => $request->inventory_id,
            'email' => $request->email,
            'phone' => $request->phone_number['full'],
            'project_name' => $request->project_name,
            'city' => $request->city,
            'status' => $request->status,
            'allocate_to' => $request->allocate_to,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'temperature'=>$request->temperature,
            'source'=>$request->source,
        ]);
        return redirect('/admin/leads/record')->with('message','Lead has been created ... !');

    }
    public function update(Request $request, $id)
    {


        $customer = Leads::where('id',$id)->update([

            'name' => $request->name,
            // 'inventory_id' => $request->inventory_id,
            'email' => $request->email,
            'phone' => $request->phone_number['full'],
            'project_name' => $request->project_name,
            'city' => $request->city,
            'status' => $request->status,
            'allocate_to' => $request->allocate_to,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'temperature'=>$request->temperature,
            'source'=>$request->source,
        ]);

        return redirect('/admin/leads/record')->with('message','Leads has been Updated ... !');
    }
    public function destroy($id)
    {
        Leads::where('id', $id)->delete();
        return redirect('/admin/leads/record')->with('message', 'Leads has been Deleted ... !');
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

    public function GetLeadsWithFilter($filterName)
    {
        $filtersWithCount = $this->getAssociatedLeadStatus();
        $leads = $this->getLeadBystatus($filterName);



        return view('leads.records', compact('leads', 'filtersWithCount'));
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

    public function GetLeadsBaseOnRouteName($routeName)
    {
        $statusName = ucwords(str_replace("-", " ", $routeName));
        $filtersWithCount = [];
        if ($statusName === self::ALL_LEADS) {
            $filtersWithCount = $this->getAssociatedLeadStatus();
            $leads = $this->getAllLeads();
        } else {
            $leads = $this->getLeadBystatus($statusName);
        }

        return view('leads.records', compact('leads', 'filtersWithCount'));
    }

    public function getLeadBystatus($name)
    {
        //   dd($name);
        //   if($name == 'Overdue Leads'){
        //     return Leads::whereDate('created_at','<', Carbon::today())->get();
        //   }
        return Leads::where('status', $name)->get();
    }

    public function getLeadBytoday($name)
    {

        return Leads::whereDate('created_at', Carbon::today())->where('status', $name)->get();
    }

    public function getAllLeads()
    {
        $user = Auth::user();
        if ($user->role_id != '5') {
            return Leads::with('comments')->get();
        } else {
            return Leads::with('comments')->where('allocated_to', $user->id)->get();
        }
    }

    public function createReminderForLead(Request $request)
    {
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
            'lead_id' => $data['lead-id'],
            'type' => $data['reminder_type'],
            'call_status' => self::CALL_STATUS_PENDING,
            'call_type' => config::get('app.reminder_types')[$data['reminder_type']],
            'created_by' =>Auth::user()->id,
        ]);
        Event::create([
            'start' => $newDate,
            'end' => $newDate,
            'lead_id' => $data['lead-id'],
            'title' => $data['description'],
            'created_by' =>Auth::user()->id,
        ]);

        $filtersWithCount = $this->getAssociatedLeadStatus();
        $leads = $this->getAllLeads();
        // updating icon on lead for specific reminder
        $lead = Leads::where('id', $data['lead-id'])->first();
        $lead->status = 'Follow Up Leads';
        if ($lead) {
            $lead->active_reminder = $data['reminder_type'];
            if (@config::get('app.lead_status')[$data['reminder_type']]) {
                $lead->status = @config::get('app.lead_status')[$data['reminder_type']];
            }
            $lead->save();
        }
        return redirect()->to('/admin/leads/all-leads');
    }

    public function GetReminderWithLeadId($id)
    {
        return CallRecoveryMan::where('lead_id', (int)$id)->get();
    }

    public function deleteLeadReminderById($id)
    {
        $leadReminder = CallRecoveryMan::find((int)$id);
        if ($leadReminder) {
            $leadReminder->delete();
            $filtersWithCount = $this->getAssociatedLeadStatus();
            $leads = $this->getAllLeads();

            return view('leads.records', compact('leads', 'filtersWithCount'))
                ->with('message', 'Reminder deleted against lead... !');
        } else {
            $filtersWithCount = $this->getAssociatedLeadStatus();
            $leads = $this->getAllLeads();

            return view('leads.records', compact('leads', 'filtersWithCount'))
                ->with('message', 'Record not found!');
        }
    }

    public function getAssociatedLeadStatus()
    {
        $user = Auth::user();
        if($user->role_id != '5'){
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
        
        $over_due_leads = Leads::where('status' , 'Follow Up Leads')->where('created_at' ,'<', Carbon::today())->get();
        $count_over = count($over_due_leads);
                                //    ->update(['status' => 'Overdue Leads']);
                                // return $over_due_leads;
                        for($i=0; $i<$count_over;$i++)
                        {
                            $data = Leads::where('id' , $over_due_leads[$i]->id)->first();
                            $data->status = "Overdue Leads";
                            $data->save();
                        }
                   
        // return $over_due_leads;
        $user = Auth::user();
        if($user->role_id != '5'){
            $followUpsCount30 =  DB::table('events')
                            ->where('start','=', Carbon::now()->addMinutes(30)->format('Y-m-d H:i:00:000'))
                            ->count();
            $followUpsCount5 =  DB::table('events')
                            ->where('start','=', Carbon::now()->addMinutes(5)->format('Y-m-d H:i:00:000'))
                            ->count();
            
           
            $found = $followUpsCount30 + $followUpsCount5;
        }else{
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
        }

       
        return $found;
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
    public function mobile(Request $request)
    {   
        // return $request->mobile;

        $check_Number = Leads::where('phone' , $request->mobile)->first();
        if($check_Number){
            return $check_Number;
        }else{
            return 0;
        }
    }

    
    
}
