@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/transfer/record" class="btn btn-success btn-add-new">
               <span>All Transfer History</span>
            </a>
        @endcan
        </h1>
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
 <style>
    input[type="file"] {
        /* display: none; */
    }
    .note-btn{
        background: #62a8ea !important;
    }
    #tagator_activate_tagator2{
        width:auto !important;
    }
    /* .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 5px 45px;
        cursor: pointer;
        margin-top: 26px;
    } */

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
                
    }
    .childTab {
        height: 325px;
    }
    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }

    

/******************************************************************************************

						 		[ 2. Comment Box ]
							
*******************************************************************************************/

.detailBox {
    width: 100%;
    border: 1px solid #bbb;
    margin-top: -10px;
    margin-bottom: 0px;
    border-radius: 10px;
}

button.btn.btn-success {
    margin-left: 7px;
}

.titleBox {
    padding: 10px;
}

.titleBox label {
    color: #444;
    margin: 0;
    display: inline-block;
}

.detailBox {
    position: relative;
}

.commentBox {
    padding: 10px;
    border-top: 1px dotted #bbb;
}

button.btn.btn-primary.custom-chat-btn {
    position: absolute;
    right: 118px;
    bottom: 20px;
}

.commentBox .form-group:first-child,
.actionBox .form-group:first-child {
    width: 80%;
}

.commentBox .form-group:nth-child(2),
.actionBox .form-group:nth-child(2) {
    width: 80%;
}

.actionBox .form-group * {
    width: auto;
}

.taskDescription {
    margin-top: 10px 0;
}

.commentList {
    padding: 0;
    list-style: none;
    max-height: 250px;
    min-height: 250px;
    overflow: auto;
}

.commentList li {
    margin: 0;
    margin-top: 10px;
}
.childTab {
    height: 460px;
}

.commentList li>div {
    display: flow-root;
    padding-right: 15px;
}

.commenterImage {
    width: 30px;
    margin-right: 5px;
    height: 100%;
    float: left;
}

.commenterImage img {
    width: 100%;
    border-radius: 50%;
}

.commentText p {
    margin: 0;
}

.sub-text {
    color: #aaa;
    font-family: verdana;
    font-size: 11px;
}

.actionBox {
    border-top: 1px dotted #bbb;
    padding: 10px;
}

@media (max-width: 481px) {
    .custom-chat-btn.btn {
        padding: 10px 5px 8px 5px;
    }
}

@media (max-width: 768px) {
    .custom-chat-btn.btn {
        padding: 10px 5px 8px 5px;
    }
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
    {{-- <div > --}}
    <a href="/admin/leads/all-leads"><button class="btn btn-info btn-sm">Back</button></a>
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"> + Follow Up</button>
    <a  class="btn btn-info btn-sm" href="/admin/leads/edit/{{@$lead->id}}" target="_blank">
        <span class="icon voyager-pen"></span> Edit This Lead
    </a>

    <a  class="btn btn-info btn-sm" href="/admin/leads/action-close/{{@$lead->id}}" target="_blank">
        Close Lead
    </a>

    {{-- </div> --}}

    <div class = "panel panel-primary">
      
        
        <div class = "panel-body">
      

            <div class="row">
                <hr>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Lead </legend>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Plot Information --}}
                                <fieldset class="childTab scheduler-border">
                                    <legend class="scheduler-border">General Information <i class="voyager-scissors"></i></legend>
                                    <div class="control-group">
                                       
                                       
                                            <div class="col-lg-12">
                                                <div class="card shadow-sm">
                                                <div class="card-header bg-transparent border-0">
                                                    
                                                </div>
                                                <div class="card-body pt-0" style="padding: 0;">
                                                    <table class="table table-bordered table-responsive">
                                                    <tbody><tr>
                                                        <th width="30%">Name</th>
                                                        <td width="2%">:</td>
                                                        <td>{{ucfirst(@$lead->name)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="30%">Mobile</th>
                                                        <td width="2%">:</td>
                                                        <td>{{(@$lead->phone)}}</td>
                                                    </tr>
                                                 
                                                    <tr>
                                                        <th width="30%">Status</th>
                                                        <td width="2%">:</td>
                                                        <td>{{ucfirst(@$lead->status)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="30%">Email</th>
                                                        <td width="2%">:</td>
                                                        <td>{{(@$lead->email)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="30%">Project</th>
                                                        <td width="2%">:</td>
                                                        <td>{{ucfirst(@$lead->project->project_name)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="30%">Source</th>
                                                        <td width="2%">:</td>
                                                        <td>{{ucfirst(@$lead->source)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="30%">Customer Response</th>
                                                        <td width="2%">:</td>
                                                        <td>
                                                            @if($lead->partnerData)
                                                                {{ucfirst(@$lead->response)}}
                                                            @else 
                                                                N/A
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="30%">Description</th>
                                                        <td width="2%">:</td>
                                                        <td>
                                                            <p>{{ucfirst(@$lead->description)}}</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="30%">Affiliate Partner</th>
                                                        <td width="2%">:</td>
                                                        <td>
                                                            <p>
                                                                @if($lead->partnerData)
                                                                {{ucfirst(@$lead->partnerData->name)}}
                                                                @else 
                                                                N/A 
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                                </div>
                                                </div>
                                            </div>
                                       
                                       
                                      
                                        
                                    </div>
                                </fieldset>

                        </div>
                        <div class="col-md-6">
                            {{-- Customer Account Information --}}

                            <fieldset class="childTab scheduler-border">
                                <legend class="scheduler-border">Comments History <i class="voyager-scissors"></i></legend>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                               
                                        <div class="detailBox">
                                            <div class="titleBox">
                                                <label>Chat History</label>
                                                <button type="button" class="close" aria-hidden="true">×</button>
                                            </div>
                                            
                                            <div class="actionBox">
                                                <ul class="commentList">
                                                    @if(count($lead->comments) > 0)
                                                    @foreach($lead->comments as $comment)
                                                    <li>
                                                        <div class="commenterImage"> <i class="fa fa-user" aria-hidden="true"></i> </div>
                                                        <div class="commentText">
                                                            <p class=""> {{$comment->comments}} </p>  <small><span style="color:green">by {{@$comment->user->name}} at</span>  <span style="color:#ec2221"> {{@$comment->created_at}}</span></small> </div>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                </ul>
                                                <hr>
                                                <form action="{{route("postComment")}}" method="POST" enctype="" class="" role="form">
                                                    @csrf                                                                                   <div class="form-group">
                                                        <input type="text" value="{{@$lead->id}}" name="lead_id" hidden=""> 
                                                        <input type="text" value="1" name="from_form" hidden=""> 
                                                        <input name="comment" class="form-control " type="text" placeholder="Your comments" style="width: 80%;"> </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-primary custom-chat-btn"><i class="fa fa-paper-plane" aria-hidden="true"></i>Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                   
                                  
                                </div>
                                <br>
                                <br>

                            </fieldset>
                        </div>
                    
                </fieldset>
                <div id="myModal" class="modal fade" role="dialog" style="display: none;">
                    <div class="modal-dialog">
                  
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">New Follow Up</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" class="form-control event_id_val"  >  
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Title</label>
                                    <input type="text" class="form-control title_val" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Follow Up">
                            
                                </div>
                             
                            <div class="form-group">
                                <label for="exampleInputEmail1">Datetime</label>
                                <input type="datetime-local" class="form-control dateof_event" name="date" required>                    
                            </div>
                              <div class="form-group">
                                <label for="exampleInputPassword1">Lead</label>
                                @php 
                                $leads = DB::table('Leads')->get();
                                @endphp
                            
                                <select id="leads" class="form-control lead_id">
                                    <option value="" selected disabled>--Select--</option>
                                    @foreach($leads as $ld)
                                        <option value="{{$ld->id}}"  @if($lead->id == $ld->id) selected @endif>  {{ucfirst($ld->name)}} </option>
                                    @endforeach
                                  </select>
                              </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="updateBTN btn btn-success " onClick="fullCalendar_f()">Save changes</button>
                        </div>
                      </div>
                  
                    </div>
                  </div>
            </div>
      
 

            
   
      
    

@stop
@section('javascript')
    <script type="text/javascript">
            $(document).ready(function() {

                            // Get the modal
                var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 

            modal.style.display = "block";


            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
            modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            });
         
            var fullCalendar_f =()=>{
                    $.ajaxSetup({
                        headers:{
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var title = $('.title_val').val();
                
                    var lead = $('.lead_id').val();
                    var start = $('.dateof_event').val();
                $.ajax({
                            url:"/full-calender/action",
                            type:"POST",
                            data:{
                                title: title,
                                start: start,
                                end: start,
                                lead:lead,
                                type: 'add'
                            },
                            success:function(data)
                            {
                                
                                alert("Event Created Successfully");
                                location.reload();
                            }
                        })
            }
        </script>
   
    
@stop