@extends('voyager::master')

@section('page_title', 'Record')

@section('page_header')
    <div class="container-fluid">
        <h1 class="">
            <a href="/admin/leads/create" class="btn btn-success btn-add-new">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                <span>Create</span>
            </a>
        </h1>
        @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
    
@stop

@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
    <div class = "panel panel-primary" style="padding: 3px;">
    
        <div class = "panel-body" style="margin-top:10px">
            <div style="overflow-x:auto;">
            <table id="dataTable" class="display">
                <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Agent Name</th>
                    <th>Lead Name</th>
                    <th>Event Name</th>
                    <th>Created at</th>
                    <th>End Date</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($events as $key=>$a)
                    <tr>
                            @php
                                $lead_name = DB::table('leads')->where('id' , $a->lead_id)->first();
                                $user_name = DB::table('users')->where('id' , $a->created_by)->first();
                            @endphp
                        <td>{{$key+1}}</td>
                        <td>{{@$user_name->name}}</td>
                        <td>{{@$lead_name->name}}</td>
                        <td>{{$a->title}}</td>
                        <td>{{$a->created_at}}</td>
                        <td>{{$a->end}}</td>


                        <td>
                            
                            {{-- <a class="badge badge-warning" href="#">Edit</a>
                            <a class="badge badge-danger" href="#">Delete</a> --}}
                        </td>
                    @endforeach
                </tbody>
               
            </table>
            </div>
        </div>
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
                <form method="POST" action="{{ route('leads.createReminder') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Follow Up Type:</label>
                            <select class="form-control" name="reminder_type">
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
                        <input type="hidden" id="leadId" name="lead-id">
                    </div>
                    <div class="modal-footer">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Type</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="reminder-table"></tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                $('#reminder-table').empty();
                $(resp).each(function(key,value){
                    $('#reminder-table').append(`
                   <tr>
                    <th scope="row">
                    `+value.date+`
                    </th>
                    <td>`+value.description+`</td>
                    <td>`+value.call_status+`</td>
                    <td>`+value.call_type+`</td>
                    <td><a  onclick="return confirm('Are you sure to delete?')"   href='/admin/leads/delete-reminder/`+value.id+`' class="badge badge-danger">Delete</a>
                    </td>
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
        // alert(id);
        $.ajax({
            url:'{{route("postComment")}}',
            method:'post',
            data:{'comment':comment,'lead_id':id,'_token':'{{csrf_token()}}'},
            success: function(resp){
                // console.log(resp);
                if(resp === 'success'){
                    location.reload(true);
                }else{
                    'no data'
                }

            },})
    }

    const openBox = (id,action)=>{
       
        if ($('.showBox_'+id).hasClass('showBox') == false) {
            $('.showBox_'+id).addClass('showBox');
            $('.showBox_'+id).removeClass('closeBox');

        }else{
            $('.showBox_'+id).removeClass('showBox');
            // $('.showBox_'+id).addClass('closeBox');
        }

    }

</script>
