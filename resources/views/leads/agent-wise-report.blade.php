@extends('voyager::master')



@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/leads/get-filter/New Leads" class="badge badge-success badge-add-new">
               <span>Report Leads</span>
            </a>
        @endcan
        </h1>
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
@stop

@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Agent Wise Report</h3>
        </div>
        
        <div class = "panel-body">
        <form action="{{route('user-report-status')}}" method="GET" enctype="multipart/data">
           
            @php
            $user = Auth::user();
            @endphp
            <div class="col-md-2">
                <label>Agent</label>
               <select class="form-control statusBased"  name="agents">
                        <option value="0" selected>--Select--</option>
                        @if(Auth::user()->role_id == '5')
                        <option  value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                        @elseif(Auth::user()->role_id == '8')
                            
                            @foreach($myAgents as $a)
                            @php
                                $agentUser = DB::table('users')->where('id', $a)->select('id','name')->get();
                                
                            @endphp
                                <option   value="{{ $agentUser[0]->id }}">{{ @$agentUser[0]->name }}</option>
                            @endforeach
                        @else
                        <option value="0">--All--</option>
                            @foreach($dropagents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        @endif
                        
                </select>
            </div> 
            <!-- <div class="col-md-2 mt-2">
                <div>
                    <label>Status Based</label>
                    @php 
                        $statusArray = config::get('app.lead_status');
                    @endphp
                    <select class="form-control" name="status_search" id="status_search">
                        <option value="0">--All--</option>
                        @foreach($statusArray as $status)
                            <option @if(@$lead_status == $status) selected  @endif  value="{{@$status}}">{{$status}}</option>
                        @endforeach
                    </select>
                </div>
            </div> -->
            <div class="col-md-2 mt-2">
                <label>Date</label>
               <select class="form-control degineDates" onchange="showCustom()" name="timestamp">
                   <option value="0">--All--</option>
                    <option @if(@$today == \Carbon\Carbon::now()->format('Y-m-d')) selected  @endif value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">Today's</option>
                    <option @if(@$today == \Carbon\Carbon::now()->subDays(\Carbon\Carbon::now()->dayOfWeek + 1)->format('Y-m-d')) selected  @endif value="{{\Carbon\Carbon::now()->subDays(\Carbon\Carbon::now()->dayOfWeek + 1)->format('Y-m-d')}}">Last Week</option>
                    <option @if(@$today == \Carbon\Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d')) selected  @endif value="{{\Carbon\Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d')}}">Last Month</option>
                    <option @if(@$today == \Carbon\Carbon::now()->startOfMonth()->subMonth(6)->format('Y-m-d')) selected  @endif value="{{\Carbon\Carbon::now()->startOfMonth()->subMonth(6)->format('Y-m-d')}}">6 Month</option>
                    <option @if(@$today == 'custom') selected  @endif value="custom">Custom Range</option>

                
                </select>
            </div>
            
            <div class="col-md-2 mt-2">
                <div>
                <label>Date From</label>
                <input  type="hidden" id="startD" value="0">

                <input value={{@$dateStart}} readonly="readonly" type="date" id="start_date"  class="form-control customDate" name="datetime_start_from" readonly>
                </div>
            </div>
            <div class="col-md-2 mt-2" >
             <div>
                <label>Date To</label>
                <input value={{@$dateTo}} readonly="readonly" type="date" id="end_date" class="form-control customDate" name="datetime_date_to" readonly>
             </div>
            </div>
            <div class="col-md-2 " >
                <button type="submit" id="btnFiterSubmitSearch" class="btn btn-success float-right" name="datetime" style=" margin-top: 26px; position: absolute; " ><i class="fa fa-search" ></i> Get Report</button>
                <a href="{{ url('/admin/agent-wise-report') }}" class="btn btn-danger" style=" position: absolute; right: 45px; top: 20px; ">Back</a>
            </div>
                      
        </form>
            <table id="example" class="display" style="width:100%">
                <thead>
                <tr>
                    @if(!empty($start_date || $end_date))
                        <th colspan="3">Date: {{$start_date}} to {{$end_date}}</th>
                    @else
                        <th colspan="3">Date: {{$date_filter}}</th>
                    @endif
                    <th colspan="6" style=" text-align: center; ">Call Status</th>
                    <th colspan="6" style=" text-align: center; ">Leads Status</th>
                    
                </tr>
                <tr>
                    <th>Sr#</th>
                    <th>Agent name</th>
                    <th>Assinged leads</th>
                    <th>Answered</th>
                    <th>Not Answered</th>
                    <th>Call Back</th>
                    <th>Busy</th>
                    <th>Powered Off</th>
                    <th>New Leads</th>
                    <th>Follow Up Leads</th>
                    <th>Overdue Leads</th>
                    <th>Closed Won</th>
                    <th>Closed Lost</th>
                    <th>Token Leads</th>
                </tr>
                </thead>
                <tbody>

                    @if(!empty($date_filter || $start_date || $end_date ))
                    
                        @foreach($agents as $key=>$a)
                            @if($date_filter != NULL && $date_filter != 'custom')
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$a->name}}</td>
                                    <td>
                                        @php
                                            $allocated_to =DB::table('leads')->where('allocated_to' , $a->id)->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($allocated_to)
                                                {{$allocated_to}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $Answered =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Answered' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($Answered)
                                                {{$Answered}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $NotAnswered =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Not Answered' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($NotAnswered)
                                                {{$NotAnswered}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $callBack =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Call Back' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($callBack)
                                                {{$callBack}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $busy =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Busy' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($busy)
                                                {{$busy}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $poweredOff =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Powered Off' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($poweredOff)
                                                {{$poweredOff}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $newLeads =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'New Leads' )->count();
                                        @endphp
                                        @if($newLeads)
                                                {{$newLeads}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $followup =DB::table('calls')->where('created_by' , $a->id)->where('date','>=' , $date_filter)->where('date', '<=' ,date('Y-m-d'))->count();
                                        @endphp
                                        @if($followup)
                                                {{@$followup}}
                                        @else
                                            0
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @php
                                            $overdue =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Overdue Leads' )->count();
                                        @endphp
                                        @if($overdue)
                                                {{$overdue}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $closed =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Closed Won' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($closed)
                                                {{$closed}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $closedlost =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Closed Lost' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($closedlost)
                                                {{$closedlost}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $token =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Token Leads' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($token)
                                                {{$token}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <!-- <td>
                                        @php
                                            $meetingplan =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Meeting Plan' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($meetingplan)
                                                {{$meetingplan}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $meetingDone =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Meeting Done' )->where('created_at','>=' , $date_filter)->count();
                                        @endphp
                                        @if($meetingDone)
                                                {{$meetingDone}}
                                        @else
                                            0
                                        @endif
                                    </td> -->
                                    
                                </tr>
                                
                            @else
                            
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$a->name}}</td>
                                    <td>
                                        @php
                                            $allocated_to =DB::table('leads')->where('allocated_to' , $a->id)->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($allocated_to)
                                                {{$allocated_to}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $Answered =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Answered' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($Answered)
                                                {{$Answered}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $NotAnswered =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Not Answered' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($NotAnswered)
                                                {{$NotAnswered}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $callBack =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Call Back' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($callBack)
                                                {{$callBack}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $busy =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Busy' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($busy)
                                                {{$busy}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $poweredOff =DB::table('leads')->where('allocated_to' , $a->id)->where('response' , 'Powered Off' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($poweredOff)
                                                {{$poweredOff}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $newLeads =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'New Leads' )->count();
                                        @endphp
                                        @if($newLeads)
                                                {{$newLeads}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                        
                                            $followup =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Follow Up Leads' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($followup)
                                                {{$followup}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $overdue =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Overdue Leads' )->count();
                                        @endphp
                                        @if($overdue)
                                                {{$overdue}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $closed =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Closed Won' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($closed)
                                                {{$closed}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $closedlost =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Closed Lost' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($closedlost)
                                                {{$closedlost}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $token =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Token Leads' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($token)
                                                {{$token}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <!-- <td>
                                        @php
                                            $meetingplan =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Meeting Plan' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($meetingplan)
                                                {{$meetingplan}}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $meetingDone =DB::table('leads')->where('allocated_to' , $a->id)->where('status' , 'Meeting Done' )->where('created_at','>=' , $start_date)->where('created_at','<=' , $end_date)->count();
                                        @endphp
                                        @if($meetingDone)
                                                {{$meetingDone}}
                                        @else
                                            0
                                        @endif
                                    </td> -->
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
                
            </table>
      
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script>
	function showCustom(){
	  var dateFilter = $('.degineDates :selected').val();
	  datefrom = dateFilter;
	  if(dateFilter == "custom"){
		  $('.customDate').attr('readonly',false);
	  }else{
	  
		  $('#startD').val(dateFilter);
		  $('.customDate').attr('readonly',true);


	  } 
  }

</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ]
        } );
    } );
</script>
@stop
