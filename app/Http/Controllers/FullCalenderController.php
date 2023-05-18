<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\CallRecoveryMan;
use App\Models\Leads;
use Auth;
class FullCalenderController extends Controller
{
    public function index(Request $request)
    {
    	if($request->ajax())
    	{
            $user = Auth::user();
            if($user->role_id != '5'){
                $data = Event::whereDate('start', '>=', $request->start)
                        ->whereDate('end',   '<=', $request->end)
                        ->get(['id', 'title', 'start', 'end']);
            }else{
                $leads =  Leads::with('comments')->where('allocated_to',$user->id)->pluck('id');
                $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->whereIn('lead_id',$leads)
                       ->get(['id', 'title', 'start', 'end']);
  
            }
    		
            return response()->json($data);
    	}
    	return view('calender.full-calender');
    }

    public function action(Request $request)
    {
        // return $request;
    	if($request->ajax())
    	{
    		if($request->type == 'add')
    		{

                $originalDate =$request->start;
                $newDate = date("Y-m-d H:i:s", strtotime($originalDate));
              
                CallRecoveryMan::create([
                    'date' => $newDate,
                    'description' => $request->title,
                    'lead_id' => $request->lead,
                    'type' => 'Follow Up Leads',
                    'call_status' => 'Pending',
                    'call_type' => 'Follow Up Leads',
                     'created_by' =>Auth::user()->id,
                ]);
    			$event = Event::create([
    				'title'		=>	$request->title,
    				'start'		=>	$newDate,
    				'end'		=>	$newDate,
                    'lead_id'		=>	$request->lead,
                    'created_by' =>Auth::user()->id,
    			]);

    			return response()->json($event);
    		}

    		if($request->type == 'update')
    		{
                $originalDate =$request->start;
                $newDate = date("Y-m-d H:i:s", strtotime($originalDate));
                // return $newDate;
    			$event = Event::find($request->id)->update([
    				'title'		=>	$request->title,
    				'start'		=>	$newDate,
    				'end'		=>	$newDate,
                    'lead_id'		=>	$request->lead,
                    'created_by' =>Auth::user()->id,
    			]);
                CallRecoveryMan::where('id',$request->lead)->update([
                    'date' => $newDate,
                    'description' => $request->title,
                    'lead_id' => $request->lead,
                    'type' => 'Follow Up Leads',
                    'call_status' => 'Pending',
                    'call_type' => 'Follow Up Leads',
                    'created_by' =>Auth::user()->id,
                ]);

    			return response()->json($event);
    		}

    		if($request->type == 'delete')
    		{
                $eventData = Event::where('id',$request->id)->with('lead')->first();
                CallRecoveryMan::where('id',$eventData->lead_id)->delete();
    			$event = Event::find($request->id)->delete();

    			return response()->json($event);
    		}
    	}
    }

    function get($id){
  
        $event = Event::where('id',$id)->with('lead')->first();
        if($event){
            return $event;
        }
    }

   
}
?>