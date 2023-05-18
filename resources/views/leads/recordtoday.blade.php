@extends('voyager::master')

@section('page_title', 'Record')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            {{-- @if(Auth::user()->hasPermission('add_booking')) --}}
            <a href="/admin/leads/file-import" class="btn btn-success btn-add-new">
               <span>Leads Import</span>
            </a>
            <a href="/admin/leads/create" class="btn btn-success btn-add-new">
                <span>Create</span>
             </a>
          {{-- @endif --}}
        </h1>
        @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
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
    width: 70% !important;
}
div#dataTable_filter {
    margin-right: 57px;
}
        </style>
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
        <div class = "panel-heading">
      
            @if(\Request::route()->getName() != "leads.baseOnRouteName")

                <a  style="margin: 12px;padding:20px" class="btn btn-success btn-add-new"  href="/admin/leads/follow-up-list/{{date('Y-m-d 00:00:00:000')}}/{{date('Y-m-d 23:59:00:000')}}">  Current Day</a>
                <a style="margin: 12px;padding:20px" href="/admin/leads/follow-up-list/{{\Carbon\Carbon::now()->subDay(1)->format('Y-m-d 00:00:00:000')}}/{{\Carbon\Carbon::now()->subDay(1)->format('Y-m-d 23:59:00:000')}}" class="btn btn-success btn-add-new">
                        <span>Yesterday / Overdue</span>
                </a>
                <a style="margin: 12px;padding:20px" href="/admin/leads/follow-up-list/{{\Carbon\Carbon::now()->addDay(1)->format('Y-m-d 00:00:00:000')}}/{{\Carbon\Carbon::now()->addDay(1)->format('Y-m-d 23:59:00:000')}}" class="btn btn-success btn-add-new">
                        <span>Tomorrow</span>
                </a>
                <a style="margin: 12px;padding:20px" href="/admin/leads/follow-up-list/{{\Carbon\Carbon::now()->addDay(1)->format('Y-m-d 00:00:00:000')}}/{{\Carbon\Carbon::now()->addDay(7)->format('Y-m-d 23:59:00:000')}}" class="btn btn-success btn-add-new">
                        <span>Next Week</span>
                </a>
                <a style="margin: 12px;padding:20px" href="/admin/leads/follow-up-list/{{\Carbon\Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00:000')}}/{{\Carbon\Carbon::now()->endOfMonth()->format('Y-m-d 23:59:00:000')}}" class="btn btn-success btn-add-new">
                        <span>This Month</span>
                </a>
                
            @endif
           
        </div>




        <div class = "panel-body" style="margin-top:10px">

            <table id="dataTable" class="display">
                <thead>
                    <tr>
                        <th>Sr#</th>
                        <th>Follow Up</th>
                        <th>Datetime</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($leadsFollowUp))

                @php
                    $index=1;
                    
                @endphp
                    @foreach ($leadsFollowUp as $key=>$item)

                    <tr>
                        <td>{{$index}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->start}}</td>
                        
                        <td>
                            @if($item->lead_id)
                            <a href="/admin/leads/show/{{@$item->lead_id}}" target="_blank" class="badge badge-primery">View Lead Info</a>
                            @else  
                                N/A
                            @endif
                            <a onclick="return confirm('Are you sure to delete?')" href="/admin/leads/delete/follow-up/{{@$item->id}}" class="badge badge-danger">Delete</a>
                        </td>

                    </tr>
                    @php
                        $index++;
                    @endphp
                    @endforeach
                    @else
                    <p>No records</p>

                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th>Customer</th>
                        <th>Plot</th>
                        <th>Ref #</th>
                        <th>Ser #</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
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
                    <td><a href='/admin/leads/delete-reminder/`+value.id+`' class="badge badge-danger">Delete</a>
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
            $('.showBox_'+id).addClass('closeBox');
        }
     
    }

</script>
