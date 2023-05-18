@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/visitor-data" class="btn btn-success btn-add-new">
               <span>All Visitor History</span>
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
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Create Visitor</h3>
        </div>
        
        <div class = "panel-body">
            @if(isset($visitor))
            <form action = "{{route('visitor.update',$visitor->id)}}" method ="post" enctype = "multipart/form-data">
            @else
        <form action = "{{route('visitor.store')}}" method ="post" enctype = "multipart/form-data">
            @endif
        @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Name<span class="required text-danger">*</span> </label>
                       <input type="text"  class="form-control" required value="{{@$visitor->name}}" placeholder="Name" name="name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Email<span class="required text-danger">*</span> </label>
                       <input type="email" required value="{{@$visitor->email}}"  class="form-control" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Phone<span class="required text-danger">*</span> </label>
                       <input type="number" required value="{{@$visitor->phone}}"  class="form-control" placeholder="Phone" name="phone">
                    </div>
                </div>
                @if (!empty($visitor))
                <div class="col-md-6">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Visitor Type <span class="required">*</span> </label>
                        <select name="visitor_type" class="form-control" id="visitor_type" required>
                            <option>--choose</option>
                            <option  value="information">Information</option>
                            <option  value="visiting">Visiting</option>
                        </select>
                    </div>
                </div>
                @else
                    <div class="col-md-6">
                        <div class="form-group" style="margin-top: 30px">
                            <label class="control-label">Visitor Type <span class="required">*</span> </label>
                            <select name="visitor_type" class="form-control" id="visitor_type" required>
                                <option>--choose</option>
                                <option  value="information">Information</option>
                                <option  value="visiting">Visiting</option>
                            </select>
                        </div>
                    </div>
                @endif
                
            </div>

            <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" >Submit</button>
       
      
        </form>
        </div>
    </div>
     
   
      
    

@stop
@section('javascript')

    
    <script type="text/javascript">
            $(document).ready(function() {

                $('#customer').change(function(){
                   var customer = $('#customer').val();
           
                    $.ajax({
                        url: "/admin/application-form/customer/search",
                        data: {
                            "customerID": customer ,
                            },
                        dataType:"json",
                        type: "get",
                        success: function(data){
                        console.log(data);
                        $('#c_so').text(data.so);
                        $('#c_phone').text(data.phone);
                        $('#c_email').text(data.email);
                        $('#c_cnic').text(data.cn );
                        }
                    });
                });



                $('#customer_to').change(function(){
                   var customer = $('#customer_to').val();
           
                    $.ajax({
                        url: "/admin/application-form/customer/search",
                        data: {
                            "customerID": customer ,
                            },
                        dataType:"json",
                        type: "get",
                        success: function(data){
                        console.log(data);
                        $('#c_so_to').text(data.so);
                        $('#c_phone_to').text(data.phone);
                        $('#c_email_to').text(data.email);
                        $('#c_cnic_to').text(data.cn );
                        }
                    });
                });



                $('#plot').change(function(){
                var plot = $('#plot').val();
                $.ajax({
                    url: "/admin/transfer/plot/search",
                    data: {
                         "plot": plot ,
                         },
                    dataType:"json",
                    type: "get",
                            success: function(data){
                            var i;
                            $('#c_so').text(data.son_of);
                            $('#c_phone').text(data.phone);
                            $('#c_email').text(data.email);
                            $('#c_cnic').text(data.cnic);
                            $('#plot_project').text(data.project);
                            $('#plot_size').text(data.size);
                            $('#plot_price').text(data.numprice + " Rs ");
                            $('#plot_price_input').val(data.price);
                            $('#plot_block').text(data.block);
                            $('#customer').html();
                            $('#customer').html(data.html);
                            $('#plot_feature').html('');
                            for( i = 0 ; i < data.feature.length ; i++){
                                $('#plot_feature').append("<label class='badge badge-info' > "+data.feature[i]+" </label> ");
                                }
                            }
                       });
                 });




                            // for contact person
                var t = $('#dynamicTable tr').length - 1 ;
                var i = $('#dynamicTable tr').length - 2;
             
                
                $("#add").click(function(){
                    ++i;
                    ++t;
                    $("#dynamicTable").append('<tr><td><input type="text" id="freeSpace" name="addmore['+i+'][name]" placeholder="Enter Name..." class="form-control text-field pName" /></td><td><input type="text" id="freeSpace" name="addmore['+i+'][so]" placeholder="Enter S/O" class="form-control text-field pDesignation" /></td><td><input type="text" id="relation" name="addmore['+i+'][relation]" placeholder="Enter relation" class="form-control text-field pMobile"/></td><td><input type="number" id="freeSpace" name="addmore['+i+'][cnic]" required placeholder="Enter cnic '+t+'" class="form-control text-field pPhone" /></td><td><input type="number" id="freeSpace" name="addmore['+i+'][phone]" placeholder="Enter Phone" class="form-control text-field pEmail" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
                });
                $(document).on('click', '.remove-tr', function(){  
                    $(this).parents('tr').remove();
                });

            });
         
           
        </script>
   
    
@stop