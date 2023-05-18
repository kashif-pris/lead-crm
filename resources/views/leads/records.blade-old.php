@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '."Customer")

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<style>

/* @import url(https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css); */
.form-control {
    display: block;
    width: 100% !important;
    height: 40px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #ebebeb;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
button.close {
    -webkit-appearance: none;
    padding: 0;
    cursor: pointer;
    background: 0 0;
    border: 0;
}
.close {
    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    color: #000;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: .2;
}
@media (min-width: 768px){
    .form-inline .form-control {
        display: inline-block;
        width: auto;
        vertical-align: middle;
    }
    .form-inline .form-group {
        display: inline-block;
        margin-bottom: 0;
        vertical-align: middle;
    }

}
button.close {
    float: right;
}
.detailBox {
    display: block;
    position: absolute;
    left: -274px;
    background-color: #ffffff;
    top: -13px;
    z-index: 1;
    opacity: 0;
    visibility: hidden;
    border: 1px solid #ccc;
    background-color: aliceblue;
}
.showBox {
    opacity: 1;
    visibility: visible;
}
.closeBox {
    opacity: 0;
    visibility: none;
}
#dataTable a {
    position: relative !important;
}
.titleBox {
    background-color: #0e4851;
    padding: 10px;
}
.titleBox label{
    color:rgb(255, 255, 255);
    margin:0;
    display:inline-block;
    font-weight: 800;
}

.commentBox {
    padding:10px;
    border-top:1px dotted #bbb;
   
}
.commentBox .form-group:first-child, .actionBox .form-group:first-child {
    width:80%;
}
/* .commentBox .form-group:nth-child(2), .actionBox .form-group:nth-child(2) {
    width:18%;
} */
.actionBox .form-group * {
    width:100%;
}
.taskDescription {
    margin-top:10px 0;
}
.commentList {
    padding:0;
    list-style:none;
    max-height:200px;
    overflow:auto;
}
.commentList li {
    margin:0;
    margin-top:10px;
}
.commentList li > div {
    display:table-cell;
}
.commenterImage {
    width:30px;
    margin-right:5px;
    height:100%;
    float:left;
}
.commenterImage img {
    width:100%;
    border-radius:50%;
}
.commentText {
    display: inline-grid !important;
    color: black;
}
.commentText p {
    margin: 0;
    font-size: small;
}
.sub-text {
    color:#aaa;
    font-family:verdana;
    font-size:11px;
}
.actionBox {
    border-top:1px dotted #bbb;
    padding:10px;
}
form.form-inline {
    display: inline-flex;
}
.voyager .btn.btn-default {
    background-color: #f0f0f0;
    border-color: #eaeaea;
    padding: 7px !important;
    font-weight: bold;
}
form {
    background: #ffffff00 !important;
}
.btn {
    margin-top: 0px;

}
textarea{
    color: black;
    font-size: 11px;
    border: 1px solid transparent;
    border-radius: 4px;
    margin-right: 3px;
}
.commentBox .form-group:nth-child(2), .actionBox .form-group:nth-child(2) {
    width: 100% !important;
}
div#dataTable_filter {
    margin-right: 57px;
}
#dataTable tr:hover:nth-child(odd)
{
    background: #c9e1ee;
}
.newLead {
    background: #55b4fb;
    padding: 7px;
}
</style>
@section('page_header')
<div class="container-fluid bg-bg">
  
        
        

 
    @include('voyager::multilingual.language-selector')
</div>

@stop


@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
        <div class="row" style="padding:12px;">
           
        @php
            $user = Auth::user();
            @endphp
            
            <div class="col-md-2">
                <label>Agent</label>
               <select class="form-control statusBased"  name="statusBased">
                        <option value="0" selected>--Select--</option>
                        @if(Auth::user()->role_id == '5')
                        <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                        @elseif(Auth::user()->role_id == '8')
                            
                            @foreach($myAgents as $a)
                            @php
                                $agentUser = DB::table('users')->where('id', $a)->select('id','name')->get();
                                
                            @endphp
                                <option  value="{{ $agentUser[0]->id }}">{{ $agentUser[0]->name }}</option>
                            @endforeach
                        @else
                        <option value="0">--All--</option>
                            @foreach($agents as $agent)
                                <option {{ Request::input('agent-id') == $agent->id ? 'selected' : '' }} value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        @endif
                        
                </select>
            </div>
            <div class="col-md-2 mt-2">
                <label>Date</label>
               <select class="form-control degineDates" onchange="showCustom()" name="timestamp">
                   <option value="0">--All--</option>
                    <option value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">Today's</option>
                    <option value="{{\Carbon\Carbon::now()->subDays(\Carbon\Carbon::now()->dayOfWeek + 1)->format('Y-m-d')}}">Last Week</option>
                    <option value="{{\Carbon\Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d')}}">Last Month</option>
                    <option value="{{\Carbon\Carbon::now()->startOfMonth()->subMonth(6)->format('Y-m-d')}}">6 Month</option>
                    <option value="custom">Custom Range</option>

                
                </select>
            </div>
          
            <div class="col-md-3 mt-2">
                <div>
                <label>Date From</label>
                <input  type="hidden" id="startD" value="0">

                <input readonly="readonly" type="date" id="start_date"  class="form-control customDate" name="datetime" >
                </div>
            </div>
            <div class="col-md-3 mt-2" >
             <div>
                <label>Date To</label>
                <input readonly="readonly" type="date" id="end_date" class="form-control customDate" name="datetime" >
             </div>
            </div>
            <div class="col-md-2 " style="float:right">
                <input type="hidden" class="checkStatus" name="checkAll" value="0">
                <butto type="button" id="btnFiterSubmitSearch" style="margin-top:26px;" class="btn btn-success float-right" name="datetime" ><i class="fa fa-search"></i> Search Leads</butto>
            </div>
                      
           

            <hr style="    width: 100%;">
                <a style="margin-left: 10px;margin-top: 5px;"
                    href="{{url('/admin/leads/all-leads')}}"
                    class="btn btn-success btn-add-new">
                        <i class="fa fa-tasks" aria-hidden="true"></i>
                        <span>All Leads</span>
                    </a>
                    @foreach($filtersWithCount as $filterWithCount)
                        @if ($filterWithCount->status == 'Closed Lost')
                            <a style="margin-left: 10px;margin-top: 5px;" href="{{ route('leads.withFilter', [ 'name'=> $filterWithCount->status ]) }}"  class="btn btn-danger btn-add-new"  >
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span>{{ $filterWithCount->status }} ({{ $filterWithCount->statusCount }})</span>
                            </a>
                            @elseif ($filterWithCount->status == 'Follow Up Leads')
                            <a style="margin-left: 10px;margin-top: 5px;" href="{{ route('leads.withFilter', [ 'name'=> $filterWithCount->status ]) }}"  class="btn btn-warning btn-add-new"  >
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span>{{ $filterWithCount->status }} ({{ $filterWithCount->statusCount }})</span>
                            </a>
                            @elseif ($filterWithCount->status == 'Meeting Plan')
                            <a style="margin-left: 10px;margin-top: 5px;" href="{{ route('leads.withFilter', [ 'name'=> $filterWithCount->status ]) }}"  class="btn btn-primary btn-add-new"  >
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span>{{ $filterWithCount->status }} ({{ $filterWithCount->statusCount }})</span>
                            </a>
                            @elseif ($filterWithCount->status == 'New Leads')
                            <a style="margin-left: 10px;margin-top: 5px;" href="{{ route('leads.withFilter', [ 'name'=> $filterWithCount->status ]) }}"  class="btn btn-default btn-add-new"  >
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span>{{ $filterWithCount->status }} ({{ $filterWithCount->statusCount }})</span>
                            </a>
                            @else
                            <a style="margin-left: 10px;margin-top: 5px;" href="{{ route('leads.withFilter', [ 'name'=> $filterWithCount->status ]) }}"  class="btn btn-success btn-add-new"  >
                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span>{{ $filterWithCount->status }} ({{ $filterWithCount->statusCount }})</span>
                            </a>
                        @endif
                    @endforeach
            <hr style="    width: 100%;">
            <a target="_blank" href="/admin/leads/create" class="float-right newLead" style="margin-right: 20px; color: white; margin-top: -10px;" >
                <span> <i class="fa fa-plus" aria-hidden="true"></i> Create Lead</span>
            </a>
            @php
            $user = Auth::user();
            @endphp
            @if($user->role_id != '5')
            <a target="_blank" href="/admin/leads/file-import" class="float-right newLead" style="margin-right: 20px; color: white; margin-top: -10px;" >
                <span> <i class="fa fa-file" aria-hidden="true"></i> Import Lead</span>
            </a>
            @endif
        </div>
        
        
        <button class="toast-btn" style="display:none;"></button>
        </div>
        <br>
      
       
        <div class = "panel-body">
        <div class=" container row">
            <div class="col-md-3" style=" margin-left: 25px; ">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" style=" position: relative; top: 28px; right: 40px; ">Page</span>
                    </div>
                    <select name="pagelist" id="pagelist" class="form-control pagelist"></select>
                    <div class="input-group-append">
                        <span class="input-group-text" style="position: absolute;top: 28px;right: -40px;">of&nbsp;<span id="totalpages"></span></span>
                    </div>
                </div>
            </div>
        </div>
        @php
        $user = Auth::user();
        @endphp
        @if($user->role_id == '1' || $user->role_id == '8')
        
        <div class="container row">
            <button type="button" class="check btn btn-success">Check All</button>
            <button type="button" class="uncheck btn btn-warning">Un-Check All</button>   
            @if($user->role_id == '1')
            <button type="button" id="deleteAll" class="btn btn-danger">Delete All</button>  
            @endif
            <button type="button" id="assignedToAgent" class="btn btn-primary float-right" >Asssigned To Agent</button>  
            <div class="col-md-2 mt-7 float-right" style="margin-top: 7px;">
               <select class="form-control assigned_agent_id"  name="assigned_agent_id" float-right> 
                        <!-- <option value="0">--All--</option> -->
                        @if(Auth::user()->role_id == '8')
                        
                            @foreach($myAgents as $a)
                            @php
                                $agentUser = DB::table('users')->where('id', $a)->select('id','name')->get();
                                
                            @endphp
                                <option  value="{{ $agentUser[0]->id }}">{{ $agentUser[0]->name }}</option>
                            @endforeach
                        @else
                            @foreach($agents as $agent)
                                <option {{ Request::input('agent-id') == $agent->id ? 'selected' : '' }} value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        @endif
                </select>
            </div>
            
        </div>
        @endif
        <table id="dataTable" class="table table-hover table-responsive" >
                <thead>
                    <tr>
                        <th><input  type="checkbox" class="check selected_leads" name="leads[]" ></th>
                        <th>Action</th>
                        <th>Sr</th>
                        <th>Name</th>
                        <th>Response</th>
                        <th>Phone</th>
                        <th>Agent</th>
                        <th>Project</th>
                        <th>City</th>
                        <th>Date</th>
                        <th>Comments</th>
                        <th>Reminders</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                
            </table>
    </div> 
           
       
    <div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reminderModalLabel">Add Follow Up</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="modalstore" method="POST" action="{{ route('leads.createReminder') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Follow Up Type:</label>
                            <select class="form-control title_val" name="reminder_type" id="exampleInputEmail1">
                                <option value="New Leads" selected disabled>--Select--</option>
                                @foreach(config::get('app.reminder_types') as $icon=>$type)
                                    <option  value="{{$icon}}"> {{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Date:</label>
                            <input type="datetime-local" class="form-control" name="date" required>
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" required></textarea>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <input type="hidden" id="leadId" name="lead_id">
                    </div>
                    <div class="modal-footer">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Type</th>
                                @if(Auth::user()->id == '1')
                                    <th scope="col">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="reminder-table1"></tbody>
                        </table>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
        
</div>
    

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).on('click','#assignedToAgent',function() 
    {

        console.log('hi before');   

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, i Confirm it!'
            }).then((result) => {
            if (result.value) 
            {
                console.log('hi after');   
                var myArray = [];
                $(".data_leads:checkbox:checked").each( function(i, ob) {
                    myArray.push( {
                        id: $(ob).data( 'id-leads-delete' )
                    });
                });
                
                var id = myArray;
                var agent_id = $('.assigned_agent_id').val();
                var url = '{{ route("leads.assigned") }}';
                console.log( agent_id );
                $.ajax
                ({
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    url:url,
                    type:'GET',
                    datatype:'json',
                    data: {
                        leads_ids : id,
                        agentID : agent_id,
                        },
                    success:function(data)
                    {
                        // console.log(data);
                            location.reload();
                    }
                })
            }
        })
    });
</script>
<script>
    $(document).on('click','#deleteAll',function() 
    {

        // console.log('hi before');   

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) 
            {
                // console.log('hi after');   
                var myArray = [];
                $(".data_leads:checkbox:checked").each( function(i, ob) {
                    myArray.push( {
                        id: $(ob).data( 'id-leads-delete' )
                    });
                });
                
                var id = myArray;
              
                var url = '{{ route("leads.destroy") }}';
                // console.log( url );
                $.ajax
                ({
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    url:url,
                    type:'GET',
                    datatype:'json',
                    data: {
                        leads_ids : id,
                        },
                    success:function(data)
                    {
                            location.reload();
                    }
                })
            }
        })
    });
</script>

<script>
     $(document).on("submit", "#modalstore", function (event) {


event.preventDefault();
var formData = new FormData(this);

$.ajax({
    url: " {{ route('leads.createReminder') }}",
    type: 'POST',
    data: formData,
    success: function (resp) {
        console.log(resp);
        // location.reload();
        $(' #reminder-table').html('');
        $('#modalstore').trigger("reset");
        $('#reminder-table1').empty();
        $(resp).each(function (key, value) {
            // return value;
            $(' #reminder-table1').append(`
          
            <tr class="deleteClass_row_${value.id}">
            <th scope="row">
            ` + value.date + `
      
            </th>
            <td>` + value.description + `</td>
            <td>` + value.call_status + `</td>
            <td>` + value.call_type + `</td>
            <td>
                <a href="javascript:void(0);"  onclick="deleteClass(${value.id})" class="badge badge-danger" >Delete</a>
            </td>
           </tr>`);
        });

        // tableData.ajax.reload();
          
    },
    cache: false,
    contentType: false,
    processData: false
});

});
</script>

<script>

$(document).ready(function(){
    $(".check").click(function(){
        $(".data_leads").attr("checked", true);
    });
    $(".uncheck").click(function(){
        $(".data_leads").attr("checked", false);
    });
});
</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    // set reminder modal
    function showReminderModal(leadId) {
        $('#reminderModal').modal('show');
        $('#leadId').val(leadId);
        $.ajax({
            url:'{{route('leads.reminders', '')}}'+'/'+leadId,
            method:'GET',
            success: function(resp){
                
                $('#reminder-table1').empty();
                $(resp).each(function (key, value) {
          
                    $('#reminder-table1').append(`
                   <tr class="deleteClass_row_${value.id}">
                    <th scope="row">
                    ` + value.date + `
                    </th>
                    <td>` + value.description + `</td>
                    <td>` + value.call_status + `</td>
                    <td>` + value.call_type + `</td>
                    
                    <td><a href="javascript:void(0);" onclick="deleteClass(${value.id})" class="badge badge-danger" >Delete</a></td>

                   </tr>`);
                });

            },
            error: function(xhr){
                alert('something went wrong');
            },
        });
    }

    function commentSubmit(id) {
   
        const comment = $('.comment_' + id).val();
        if(comment){
            $('.cBTN').text('Wait');
            $.ajax({
                url:'{{route("postComment")}}',
                method:'post',
                data:{'comment':comment,'lead_id':id,'_token':'{{csrf_token()}}'},
                success: function(resp){
                    // console.log(resp);
                    if(resp === 'success'){
                        $('.cBTN').text('Add');
                        $('.append_'+ id).append(
                            `
                            <li>
                                <div class="commenterImage">
                                    <img src="https://www.pngitem.com/pimgs/m/150-1503945_transparent-user-png-default-user-image-png-png.png">
                                </div>
                                <div class="commentText">
                                    <textarea readonly="" name="" id="" cols="30" rows="4">${comment}</textarea>
                                    <span class="date sub-text">{{date('d-m-y h:i:s')}} by {{Auth::user()->name}}</span>

                                </div>
                            </li>
                            `
                        );
                        $('.comment_' + id).val('');
                    }else{
                        'no data'
                    }

                },})
        }else{
            alert('Enter comment!');
        }
    }

    const openBox = (id,action)=>{
    //    alert(action);
        if ($('.showBox_'+id).hasClass('showBox') == false) {
            $('.showBox_'+id).addClass('showBox');
            $('.showBox_'+id).removeClass('closeBox');

        }else{
            $('.showBox_'+id).removeClass('showBox');
            // $('.showBox_'+id).addClass('closeBox');
        }

    }
    function changeStatus(id) {
    //    alert(id);
       const status = $('.lead_' + id).val();
       if(status){
           $('.cBTN').text('Wait');
           $.ajax({
               url:'{{route("change_lead_status")}}',
               method:'post',
               data:{'id':id,'status':status,'_token':'{{csrf_token()}}'},
               success: function(resp){
                   // console.log(resp);
                   if(resp === 'success'){
                      alert('Status changed successfully.');
                   }else{
                     alert('something went wrong.');
                   }

               },})
       }else{
           alert('Select status!');
       }
   }
   function delete_Data(route,id) {
        // alert(route);
        if (confirm('Are you sure ?')) {
            $.ajax({ 
                url: route+id,
                data: {"_token": "{{ csrf_token() }}"},
                type: 'get',
                success: function(result){                
                    $('.deleteClass_lead_row_'+id).remove();
                }
            });
        }
     
       
       
    }
</script>

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
        const deleteClass = (id)=>{

           $.ajax({ 
              url: "{{ route('leads.delete-reminder-event') }}",
              data: {"id": id,"_token": "{{ csrf_token() }}"},
              type: 'post',
              success: function(result){                
                $('.deleteClass_row_'+id).remove();
              }
            });
        }
     
    </script>
    

@stop
