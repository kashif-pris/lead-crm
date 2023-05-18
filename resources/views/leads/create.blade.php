@extends('voyager::master')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i>
             @can('add', app($dataType->model_name))
            <a href="/admin/leads/record" class="btn btn-success btn-add-new">
               <span>All Leads History</span>
            </a>
        @endcan
        </h1>
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
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
    .iti {
    position: relative;
    display: block !important;
}
    /* .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 5px 45px;
        cursor: pointer;
        margin-top: 26px;
    } */
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
            <h3 class = "panel-title">Create Leads</h3>
        </div>

        <div class = "panel-body">
            @if(isset($leads))
                <form action = "{{route('leads.update',$leads->id)}}" method ="post" enctype = "multipart/form-data">
            @else
                <form action = "{{route('leads.store')}}" method ="post" enctype = "multipart/form-data">
            @endif
        @csrf

            <div class="row">
                
                <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">Project name<span class="required text-danger">*</span> </label>
                        <select class="form-control" name="project_name" id="project_name" required>
                          <option value="New Leads" selected disabled>--Select--</option>
                            @foreach($projects as $p)
                            <option  @if(@$leads->project_name == $p->id) {{'selected'}} @endif value="{{$p->id}}">{{$p->project_name}}</option>
                            @endforeach
                        </select>
                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">Name<span class="required text-danger">*</span> </label>
                       
                       
                            <input  type="text" class="form-control" required value="{{@$leads->name}}" placeholder="Name" name="name">
                        
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">Email </label>
                        @if(@$leads->email != '')
                            <input readonly type="email"  class="form-control"   value="{{@$leads->email}}"  placeholder="Email" name="email">
                        @else
                            <input  type="email"  class="form-control"   value="{{@$leads->email}}"  placeholder="Email" name="email">
                        @endif
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">Phone<span class="required text-danger">*</span> </label>
                        @if(@$leads->phone != '')
                           @if(Auth::user()->role_id == '1')
                           <input  type="tel" class ="form-control" name="phone_number[main]" id="phone_number" value ="{{$leads->phone}}" />
                           @else
                           <input readonly type="tel" class ="form-control" name="phone_number[main]" id="phone_number" value ="{{$leads->phone}}" />
                           @endif
                        @else
                         <input required type="tel" class ="form-control" name="phone_number[main]" id="phone_number" onfocusout="myFunctionMobile()"  />
                                <a href="#0"  target="_blank" class='lead_id'  value=''>   
                                                 <small style="
                                                        display: none;color: rgb(255 255 255);background: red;position: absolute;top: 95px;padding: 4px;text-align: center;
                                                 " id="error_mobile">Lead already exists <i class="fa fa-eye"></i></small>
                                </a>
                            
                        @endif
                    </div>
                </div>

                <!-- <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">City</label>
                       <input type="text"  value="{{@$leads->city}}"  class="form-control" placeholder="City" name="city">
                    </div>
                </div> -->
         
                <!-- <div class="col-md-4">
                    <div class="form-group "  >
                        <label class="control-label" for="status">Status</label>
                        <select class="form-control" name="status" id="status" required>
                          <option value="New Leads" selected disabled>--Select--</option>
                            @foreach(config::get('app.lead_status') as $status)
                            <option @if(@$leads->status == $status) {{'selected'}} @endif value="{{$status}}">{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">Allocated To </label>
                        <select class="form-control" name="allocate_to" id="allocate_to" >
                          
                        @if(Auth::user()->role_id == '5')
                          
                          <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                        @elseif(Auth::user()->role_id == '8')
                            @foreach($agents as $a)
                                @php
                                    $agentUser = DB::table('users')->where('id', $a)->select('id','name')->get();
                                    
                                @endphp
                                <option  value="{{ $agentUser[0]->id }}">{{ $agentUser[0]->name }}</option>
                            @endforeach
                        @else
                         <option value="" selected disabled>--Select--</option>
                             @foreach($agents as $a)
                            <option @if(@$leads->allocated_to == $a->id) {{'selected'}} @endif value="{{$a->id}}">{{$a->name}}</option>
                            @endforeach
                        @endif
                        </select>
                      
                    </div>
                </div>
                
                <!-- <div class="col-md-6">
                    <div class="form-group" >
                        <label class="control-label">Description</label>
                        <textarea type="text" rows="3" col="12" class="form-control" placeholder="Description" name="description">  {{@$leads->description}}  </textarea>
                    </div>
                </div> -->
                
                <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">Temperature</label>
                        <select class ="form-control" name = "temperature">
                            <option value ="">---Select---</option>
                            @if(@$leads->temperature == 'Hot')
                                <option value ="Hot" selected>Hot</option>
                                <option value ="Cold" >Cold</option>
                                <option value ="Moderate" >Moderate</option>
                            @elseif(@$leads->temperature == 'Cold')
                                <option value ="Hot" >Hot</option>
                                <option value ="Cold" selected>Cold</option>
                                <option value ="Moderate" >Moderate</option>
                            @else
                                <option value ="Hot" >Hot</option>
                                <option value ="Cold" >Cold</option>
                                <option value ="Moderate" selected>Moderate</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group" >
                        <label class="control-label">Source</label>
                        <select class ="form-control" name = "source">
                            <option value ="">---Select---</option>
                            @foreach(config::get('app.source') as $status)
                                <option
                                    @if(@$leads->source == $status) {{'selected'}} @endif value="{{$status}}">{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if(Request::segment(3)=='edit')
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Response<span
                                    class="required text-danger"></span> </label>
                            <select class="form-control" name="response" id="response" >
                                <option value="N/A" selected disabled>--Select--</option>
                                @foreach(config::get('app.response') as $status)
                                    <option
                                        @if(@$leads->response == $status) {{'selected'}} @endif value="{{$status}}">{{$status}}</option>
                                @endforeach

                            </select>

                        </div>
                    </div>
                @else
                    <input class="form-control" type="hidden" name="response" value="NA">
                @endif



            </div>

            <button class="btn btn-primary submit_btn nextBtn btn-lg pull-right" type="submit" > Submit  </button>


        </form>
        </div>
    </div>


    


@stop
@section('javascript')

<script>

    var phone_number = window.intlTelInput(document.querySelector("#phone_number"), {
        separateDialCode: true,
        preferredCountries:["pk"],
        hiddenInput: "full",
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
      });
      
      $("form").submit(function() {
        var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
        $("input[name='phone_number[full]'").val(full_number);
      });
    
    
</script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      
      <script>
         function myFunctionMobile() {
            var mobile_no = document.getElementById("phone_number").value;
           var country_code =$('.iti__selected-dial-code').text();
        // alert(country_code);
            var mobile = country_code+mobile_no;
            // alert(mobile);
            $.ajax({
               type:'POST',
               url:'/admin/leads/checkmobilenumber',
               data:{'mobile':mobile, '_token':'{{csrf_token()}}'},
               success:function(data) {
                if(data != 0){
                    $('#error_mobile').css('display','block');
                    $('.lead_id').attr('href','{{url("/admin/leads/show")}}/'+data.id); 
                    $('.submit_btn').attr('disabled', true);  
                }else{
                    $('.submit_btn').attr('disabled', false);
                    $('#error_mobile').css('display','none');
                }
               }
            });
         }
      </script>


@stop
