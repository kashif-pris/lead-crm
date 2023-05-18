@extends('voyager::master')



@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/leads/get-filter/New Leads" class="badge badge-success badge-add-new">
               <span>Manage Leads</span>
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
            <h3 class = "panel-title">Pending Follow Up List</h3>
        </div>
        <div class="row">
        <form action="/admin/pending-followup/date-filter" method="GET" enctype="multipart/data">
            <div class="col-md-2 mt-2">
                <label>Date</label>
               <select class="form-control degineDates" onchange="showCustom()" name="timestamp">
                   <option value="0">--All--</option>
                    <!-- <option @if(@$today == \Carbon\Carbon::now()->format('Y-m-d')) selected  @endif value="{{\Carbon\Carbon::now()->format('Y-m-d')}}">Today's</option> -->
                    <option @if(@$today == \Carbon\Carbon::yesterday()->format('Y-m-d')) selected  @endif value="{{\Carbon\Carbon::yesterday()->format('Y-m-d')}}">Yesterday</option>
                    <option @if(@$today == \Carbon\Carbon::tomorrow()->format('Y-m-d')) selected  @endif value="{{\Carbon\Carbon::tomorrow()->format('Y-m-d')}}">Tomorrow</option>
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

                    <input value={{@$dateStart}} readonly="readonly" type="date" id="start_date"  class="form-control customDate" name="datetime_start_from" >
                </div>
            </div>
            <div class="col-md-2 mt-2" >
                <div>
                    <label>Date To</label>
                    <input value={{@$dateTo}} readonly="readonly" type="date" id="end_date" class="form-control customDate" name="datetime_date_to" >
                </div>
            </div>
            <button type="submit" id="btnFiterSubmitSearch" style="margin-top:26px;float: initial;" class="btn btn-success float-right" name="datetime" ><i class="fa fa-search"></i> Search </button>
        </form>
        </div>
        <div class = "panel-body">
       
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Lead Name</th>
                    <th>Agent Name</th>
                    <th>Phone</th>
                    <th>FollowUp Date</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($status))
                    @foreach($status as  $key=>$item)
                    @php
                        $leads=DB::table('leads')->where('id' , @$item->lead_id)->first();
                        $user = DB::table('users')->where('id', @$item->created_by)->select('name')->first();
                    @endphp
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{@$leads->name}}</td>
                        <td>{{@$user->name}}</td>
                        <td><a href="tel:{{@$leads->phone}}">{{@$leads->phone}}</a></td>
                        <td>{{@$item->date}}</td>
                        <td>{{@$item->description}}</td>
                        <td>{{date('d-m-Y', strtotime(@$item->created_at))}}</td>
                        <td><a hre="javascript:void(0)" onclick="showReminderModal({{@$leads->id}})" class="badge badge-warning hidden-sm" data-toggle="tooltip" data-placement="right" title="Update Follow Up">View Details</a></td>
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
