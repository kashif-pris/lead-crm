<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Agent;
use DB;
use Illuminate\Support\Facades\Redirect;
use TCG\Voyager\Facades\Voyager;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slug = 'Agents';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $agentsRecord = Agent::with('projects')->get();
        // dd($getagent);
        return view('agents.record',compact('agentsRecord','dataType'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $slug = 'Agents';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $project = Project::all();
        return view('agents.create',compact('project','dataType'));
    }

    
    public function store(Request $request)
    {
        $project = Project::all();
        if(isset($request->avatar)){
            $avatar = $request->avatar;
            $path = "Storage/Files/agents";
            $doc_name =  time().rand(100,999 ).".".$avatar->getClientOriginalExtension();
            $avatar->move($path,$doc_name);
        }else{
            $doc_name = 'none';
        }

        if(isset($request->reg_certificate)){
            $reg_certificate = $request->reg_certificate;
            $path = "Storage/Files/agents";
            $doc_name1 =  time().rand(100,999 ).".".$reg_certificate->getClientOriginalExtension();
            $reg_certificate->move($path,$doc_name1);
        }else{
            $doc_name1 = 'none';
        }

        if(isset($request->ntn)){
            $ntn = $request->ntn;
            $path = "Storage/Files/agents";
            $doc_name2 =  time().rand(100,999 ).".".$ntn->getClientOriginalExtension();
            $ntn->move($path,$doc_name2);
        }else{
            $doc_name2 = 'none';
        }

        if(isset($request->form29)){
            $form29 = $request->form29;
            $path = "Storage/Files/agents";
            $doc_name3 =  time().rand(100,999 ).".".$form29->getClientOriginalExtension();
            $form29->move($path,$doc_name3);
        }else{
            $doc_name3 = 'none';
        }
       
        $agents = Agent::create([
            'name' => $request->name,
            'father' => $request->father,
            'cnic' => $request->cnic,
            'project_id' => $request->project_id,
            'date_of_birth' => $request->date_of_birth,
            'city' => $request->city,
            'reg_no' => $request->reg_no,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'person_type' => $request->person_type,
            'avatar' => $doc_name,
            'representative' => $request->representative,
            'ntn' => $doc_name2,
            'reg_certificate' => $doc_name1,
            'form29' => $doc_name3,
            'momorandom' => $request->momorandom,
            'commission' => $request->commission,
            'description' => $request->description,
        ]);
        // dd($agents);
        return view('agents.create', compact('agents','project'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slug = 'Agents';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $type = [
            0 => 'Individual',
            1 => 'Partnership',
            2 => 'Company',
        ];

        $agentShow = Agent::with('projects')->where('id',$id)->first();
        $TotalAgentSales = DB::table('bookings')
                            ->select('agent_amount')
                            ->where('agent_id',$id)
                            ->where('status',1)
                            ->sum('agent_amount');
                            // dd($TotalAgentSales);
        $TotalPlotSales = DB::table('bookings')
                            ->join('agents','agents.id','=','bookings.agent_id')
                            ->where('agents.id',$id)
                            ->where('bookings.status',1)
                            ->count();
                           //dd($TotalPlotSales);
        $agentsRecord = Agent::with('projects')->get();
       
        return view('agents.record',compact('agentsRecord','dataType','agentShow','type','TotalAgentSales','TotalPlotSales'));
    }


    public function edit($id)
    {
        // dd(0);
        $editAgent = Agent::with('projects')->where('id',$id)->first();
        $project = Project::all();

        $type = [
            0 => 'Individual',
            1 => 'Partnership',
            2 => 'Company',
        ];
        return view('agents.create', compact('editAgent','project','type'));
    }



    public function update(Request $request)
    {
        $agentsUPDATE = Agent::where('id',(int)$request->id)->first();


        if(isset($request->avatar)){
            $avatar = $request->avatar;
            $path = "Storage/Files/agents";
            $doc_name =  time().rand(100,999 ).".".$avatar->getClientOriginalExtension();
            $avatar->move($path,$doc_name);
            $agentsUPDATE->avatar = $doc_name;
        }else{
            $doc_name = 'none';
        }

        if(isset($request->reg_certificate)){
            $reg_certificate = $request->reg_certificate;
            $path = "Storage/Files/agents";
            $doc_name1 =  time().rand(100,999 ).".".$reg_certificate->getClientOriginalExtension();
            $reg_certificate->move($path,$doc_name1);
            $agentsUPDATE->reg_certificate = $doc_name1;
        }else{
            $doc_name1 = 'none';
        }

        if(isset($request->ntn)){
            $ntn = $request->ntn;
            $path = "Storage/Files/agents";
            $doc_name2 =  time().rand(100,999 ).".".$ntn->getClientOriginalExtension();
            $ntn->move($path,$doc_name2);
            $agentsUPDATE->ntn = $doc_name2;
        }else{
            $doc_name2 = 'none';
        }

        if(isset($request->form29)){
            $form29 = $request->form29;
            $path = "Storage/Files/agents";
            $doc_name3 =  time().rand(100,999 ).".".$form29->getClientOriginalExtension();
            $form29->move($path,$doc_name3);
            $agentsUPDATE->form29 = $doc_name3;
        }else{
            $doc_name3 = 'none';
        }
       
        
        $agentsUPDATE->name = $request->name;
        $agentsUPDATE->father = $request->father;
        $agentsUPDATE->cnic = $request->cnic;
        $agentsUPDATE->project_id = $request->project_id;
        $agentsUPDATE->date_of_birth = $request->date_of_birth;
        $agentsUPDATE->city = $request->city;
        $agentsUPDATE->email = $request->email;
        $agentsUPDATE->reg_no = $request->reg_no;
        $agentsUPDATE->mobile = $request->mobile;
        $agentsUPDATE->address = $request->address;
        $agentsUPDATE->person_type = $request->person_type;
        $agentsUPDATE->representative = $request->representative;
        $agentsUPDATE->momorandom = $request->momorandom;
        $agentsUPDATE->commission = $request->commission;
        $agentsUPDATE->description = $request->description;
        $agentsUPDATE->save();


        return redirect('/admin/agent/record');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agent $agent , $id)
    {
        Agent::find($id)->delete();
        return redirect()->back();

    }
}
