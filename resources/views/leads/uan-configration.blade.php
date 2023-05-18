@extends('voyager::master')

        <link rel="stylesheet" href="{{env('APP_URL')}}/dist/css/bootstrap-multiselect.css" type="text/css">
       
 <style>
    .field{
       display: none;
    }
    .app-container.expanded .app-footer {
    left: 0px;
}
    input[type="file"] {
        /* display: none; */
    }
    .note-btn{
        background: #62a8ea !important;
    }
    #tagator_activate_tagator2{
        width:auto !important;
    }
   .Partnership , .Company{
      display: none;
   }

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }

    label {
    font-weight: bold !important;
    color: black;
  }
   input.form-control {
      border: 1px solid black;
      color: black;
   }
    
 </style>

 @if(isset($editAgent))
 @if($editAgent->person_type == 0)
 <style>
  .individual{
    display : block;
 }
.Partnership , .Company{
   display : none;
}
</style>
 @elseif($editAgent->person_type == 1)
 <style>
   .Partnership , .Company{
     display : block;
  }
  .individual {
    display : none;
 }
 </style>
 @elseif($editAgent->person_type == 2)
 <style>
   .Company{
     display : block;
  }
 .Partnership , .individual{
    display : none;
 }
 </style>
 @endif
 @endif




  
{{-- @stop --}}

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
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Api Configration Setting</h3>
        </div>
 
        <div class = "panel-body">
          <form role="form" class="form-edit-add" action="{{route('apiconfig.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class=" panel-body">
                <div class="row">
                    @php
                        $user = Auth::user();
                    @endphp
                    @if($user->role_id != '5')
                    <div class="form-group  col-md-3">
                        <label for="Agent"> Select Agent</label>
                        <select  class="form-control onchange" id="multiple" multiple="multiple"  name="agent_id[]">
                                @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" >
                                            @if($agent->role_id == 8)
                                                <span style="color:green !important; ">{{ $agent->name }}</span>
                                                @else
                                                {{$agent->name}}
                                            @endif
                                        </option>
                                @endforeach
                        </select>
                    </div>
                    @endif
                </div>
               <!-- Adding / Editing -->
               <fieldset class="setting">
                    <label for="integration">Integration Setting</label>
                    <input class="facebook_chk" type="checkbox" name="facebook" value="fb" />
                    <span class="item-text">Facebok</span>
                </fieldset>
               <!-- GET THE DISPLAY OPTIONS -->
               <fieldset class="facebook">
                    <div class="row">
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for=" API Duration">API Duration</label>
                            <input  type="text" class="form-control" name="api_duration" placeholder="FB API Duration" value="">
                        </div>
                        <!-- GET THE DISPLAY OPTIONS -->
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for="name">Account ID</label>
                            <input  type="text" class="form-control" name="account_id"  value="">
                        </div>
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for="name">APP ID</label>
                            <input  type="text" class="form-control" name="app_id"  value="">
                        </div>
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for="name">Campaign ID</label>
                            <input  type="text" class="form-control" name="compaign_id" value="">
                        </div>
                        <!-- GET THE DISPLAY OPTIONS -->
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for="name">FB Token</label>
                            <input  type="text" class="form-control" name="fb_token"  value="">
                        </div>
                    </div>
               </fieldset>
               <fieldset class="uan">
                    <div class="row">
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for=" API Duration">API Duration</label>
                            <input type="text" class="form-control" name="api_duration" placeholder="API Duration" value="">
                        </div>
                        <!-- GET THE DISPLAY OPTIONS -->
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for="name">base path</label>
                            <input type="text" class="form-control" name="base_path" value="">
                        </div>
                        <!-- GET THE DISPLAY OPTIONS -->
                        <div class="form-group  col-md-3 ">
                            <label class="control-label" for="name">Token</label>
                            <input  type="text" class="form-control" name="uan_token"  value="">
                        </div>
                    </div>
               </fieldset>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="Status" >Status</label>
                  <select class="form-control" name="status" id="status">
                     <option value="1" >Active</option>
                     <option value="0" >In Active</option>
                  </select>
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
            </div>
            <!-- panel-body -->
            <div class="panel-footer">
               <button type="submit" class="btn btn-primary save">Save</button>
            </div>
         </form>
         
    </div>
     
   
      
    

@stop
@section('javascript')
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="{{env('APP_URL')}}/dist/js/bootstrap-multiselect.js"></script>
<!-- Initialize the plugin: -->
<script type="text/javascript">
        $(document).ready(function() {
            $('#multiple').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                maxHeight: 400,
                dropDown: true
            });
        });
    </script>
<script>
    $(".facebook").hide();
    $(".uan").show();
    $(".facebook_chk").click(function() {
        if($(this).is(":checked")) {
            $(".facebook").show();
            $(".uan").hide();
        } else {
            $(".facebook").hide();
            $(".uan").show();
        }
    });
</script>
   
    
@stop