@extends('voyager::master')



@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/leads/get-filter/New Leads" class="badge badge-success badge-add-new">
               <span>UAN Leads</span>
            </a>
        @endcan
        </h1>
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<style>
    input[type="text"] {
        color: black;
    }
</style>
@stop

@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">UAN Leads List</h3>
        </div>
        <div class="row">
        <form action="/admin/uan-leads" method="post" enctype="multipart/data">
            @csrf
            <input type="hidden" name="api_token" value="UUf4VXNSYvHmMjNSRRCadzoxKj1eJkFryrIixlGUiWHZgY6bwC08APB3l8Nd">
            <div class="col-md-2 mt-2">
                <label>Date</label>
               <select class="form-control degineDates" onchange="showCustom()" name="timestamp"> 
                    <option @if(@$today == 'custom') selected  @endif value="custom">Custom Range</option>
                </select>
            </div>
            
            <div class="col-md-2 mt-2">
                <div>
                    <label>Date From</label>
                    <input  type="hidden" id="startD" value="0">

                    <input value={{@$dateStart}} readonly="readonly" type="date" id="start_date"  class="form-control customDate" name="date_from" >
                </div>
            </div>
            <div class="col-md-2 mt-2" >
                <div>
                    <label>Date To</label>
                    <input value={{@$dateTo}} readonly="readonly" type="date" id="end_date" class="form-control customDate" name="date_to" >
                </div>
            </div>
            <button type="submit" id="btnFiterSubmitSearch" style="margin-top:26px;float: initial;" class="btn btn-success float-right" name="datetime" ><i class="fa fa-search"></i> Search </button>
        </form>
        </div>
        <div class = "panel-body">
        <div class="row ">
                <div class="newq">
                            @php
                    $user = Auth::user();
                    @endphp
                    @if($user->role_id == '1' || $user->role_id == '8')
                    
                    <div class="col-md-9" style="width: 78%;">
                        <button type="button" class="check btn btn-success">Check All</button>
                        <button type="button" class="uncheck btn btn-warning">Un-Check All</button>   
                        <button type="button" id="assignedToAgent" class="btn btn-primary float-right" >Assigned To Agent</button>  
                        <div class="col-md-3 mt-7 float-right" style="margin-top: 7px;">
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
                                            <option {{ Request::query('statusBased') == $agent->id ? 'selected' : '' }} value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endforeach
                                    @endif
                            </select>
                        </div>
                        
                    </div>
                    @endif
                </div>
            </div>
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                <th><input  type="checkbox" class="check uan_leads" name="uan_leads[]" ></th>
                    <th>Sr#</th>
                    <th>UAN Phone</th>
                    <th>Extension</th>
                    <th>Date Time</th>
                    <th>Duration</th>
                    <th>Recording</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($uanCalls))
                @foreach($uanCalls->calls as  $key=>$item)
                 <tr>
                 <td><input type="checkbox" class="uan_leads" data-id-leads-delete="{{$key+1}}" name="uan_calls[]" value="{{$key+1}}"/></td>
                    <td>{{$key+1}}</td>
                    <td><a  href="tel:{{@$item->phone}}" >{{@$item->phone}}</a></td>
                    <input type="hidden" class="uan_leads_contacts" data-id-contacts-uan-leads-delete="{{$key+1}}" name="uan_contacts[]" value="{{$key+1}}"/>
                    <td>{{@$item->ext}}</td>
                    <td>{{@$item->datetime}}</td>
                    <td>{{@$item->duration}} Min</td>
                    <td>{{@$item->recording}}</td>
                    <td>{{@$item->status}}</td>
                    <td><a hre="javascript:void(0)" class="badge badge-warning hidden-sm" data-toggle="tooltip" data-placement="right" title="Update Follow Up">Add Leads</a></td>
                </tr>
                
                @endforeach
                @endif
            
               
            </tbody>
        
        </table>
      
    </div>
</div>
<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reminderModalLabel">update Follow Up</h5>
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
                                <option @if(@$item->call_type == $icon) selected  @endif  value="{{$icon}}"> {{$type}}</option>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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

$(document).ready(function(){
    $(".check").click(function(){
        $(".uan_leads").attr("checked", true);
    });
    $(".uncheck").click(function(){
        $(".uan_leads").attr("checked", false);
    });
});
</script>
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
                $(".uan_leads:checkbox:checked").each( function(i, ob) {
                    myArray.push( {
                        id: $(ob).data('id-leads-delete')
                    });
                });
                var contacts = [];
                $(".uan_leads:checkbox:checked").each( function(i, ob) {
                    myArray.push( {
                        contacts: $(ob).data( 'id-contacts-uan-leads-delete' )
                    });
                });
                
                var id = myArray;
                var agent_id = $('.assigned_agent_id').val();
                var url = '{{ route("uan_leads.assigned") }}';
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
                            alert('Assigned...!');
                    }
                })
            }
        })
    });
</script>
<script>
    function getMessage(id){
        $.ajax({
            type:'POST',
            url:'/admin/status-update/'+id,
            dataType:'json',
            success:function(data){
               console.log(data);
            }
        });
     }
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
<script>
    $(document).ready(function() {
        $('#example1').DataTable( {
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
<script>
    $(document).ready(function () {
        // Setup - add a text input to each footer cell
        $('#example thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#example thead');
    
        var table = $('#example').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            initComplete: function () {
                var api = this.api();
    
                // For each column
                api
                    .columns()
                    .eq(0)
                    .each(function (colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');
    
                        // On every keypress in this input
                        $(
                            'input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                            .off('keyup change')
                            .on('change', function (e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();
    
                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != ''
                                            ? regexr.replace('{search}', '(((' + this.value + ')))')
                                            : '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function (e) {
                                e.stopPropagation();
    
                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
        });
    }); 
</script>
@stop
