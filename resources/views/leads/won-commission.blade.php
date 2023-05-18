@extends('voyager::master')

{{-- @section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural')) --}}

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            {{-- <i class="{{ $dataType->icon }}"></i> --}}
             {{-- @can('add', app($dataType->model_name)) --}}
            <a href="/admin/leads/record" class="btn btn-success btn-add-new">
               <span>All Leads History</span>
            </a>
        {{-- @endcan --}}
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
            <h3 class = "panel-title">Commissions</h3>
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
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Project name<span class="required text-danger">*</span> </label>
                        <select class="form-control" name="project_name" id="project_name" required>
                          <option  value="New Leads" selected disabled>--Select--</option>
                            @foreach($projects as $p)
                            <option  @if(@$leads->project_name == $p->id) {{'selected'}} @endif value="{{$p->id}}">{{$p->project_name}}</option>
                            @endforeach
                        </select>
                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Name<span class="required text-danger">*</span> </label>
                       <input readonly type="text" class="form-control" required value="{{@$leads->name}}" placeholder="Name" name="name">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Email<span class="required text-danger">*</span> </label>
                       <input readonly type="email"  class="form-control" required  value="{{@$leads->email}}"  placeholder="Email" name="email">
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Phone<span class="required text-danger">*</span> </label>
                       <input readonly type="number"  required  value="{{@$leads->phone}}"  class="form-control" placeholder="phone" name="phone">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 30px">
                        <label  class="control-label">City<span class="required text-danger">*</span> </label>
                       <input readonly type="text" required value="{{@$leads->city}}"  class="form-control" placeholder="City" name="city">
                    </div>
                </div>
         
                <div class="col-md-4">
                    <div class="form-group "  style="margin-top: 30px">
                        <label class="control-label" for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                          <option value="New Leads" selected disabled>--Select--</option>
                            @foreach(config::get('app.lead_status') as $status)
                            <option @if(@$leads->status == $status) {{'selected'}} @endif value="{{$status}}">{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Allocated To<span class="required text-danger">*</span> </label>
                        <select class="form-control" name="allocate_to" id="allocate_to" required>
                          <option value="" selected disabled>--Select--</option>
                            @foreach($agents as $a)
                            <option disabled selected @if(@$leads->allocate_to == $a->id) {{'selected'}} @endif value="{{$a->id}}">{{$a->name}}</option>
                            @endforeach
                        </select>
                      
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Description</label>
                        <textarea disabled type="text" rows="3" col="12" class="form-control" placeholder="Description" name="description">  {{@$leads->description}}  </textarea>
                    </div>
                </div>




            </div>

            <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" > Submit  </button>


<div class='row' id="new_row">

    <div class="col-md-4">
        <div class="form-group" style="margin-top: 30px">
            <label class="control-label">Name<span class="required text-danger">*</span> </label>
           <input type="text" class="form-control" required value="" placeholder="" name="name">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group" style="margin-top: 30px">
            <label class="control-label">Commission<span class="required text-danger">*</span> </label>
           <input type="email"  class="form-control" required  value=""  placeholder="" name="email">
        </div>
    </div>

    <div class="col-md-4">
     <button class="btn btn-primary" id="addmore">Add more</button>
    </div>
</div>
        







        </form>
        </div>
    </div>





@stop
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
      
    var html = ' <div class="row">\n' +
        '<div class="col-md-6">\n'+
   '<div class="form-group" style="margin-top: 30px">\n'+
      ' <label class="control-label">Name<span class="required text-danger">*</span> </label>\n'+
      '<input type="text" class="form-control" required value="" placeholder="" name="name">\n'+
      '  </div>\n'+
  '  </div>\n'+
  ' <div class="col-md-6">\n'+
    '    <div class="form-group" style="margin-top: 30px">\n'+
       '     <label class="control-label">Commission<span class="required text-danger">*</span> </label>\n'+
       '    <input type="email"  class="form-control" required  value=""  placeholder="" name="email">\n'+
       ' </div>\n'+
   ' </div>\n'+
       

        '   </div>';

    $("#addmore").click(function () {
       


        $('#new_row').append(html);


    });


</script>

@stop



