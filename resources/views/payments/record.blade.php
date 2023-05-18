@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> 
        <!-- @can('add', app($dataType->model_name))
            <a href="/admin/merge/create" class="btn btn-success btn-add-new">
               <span>Installments</span>
            </a>
        @endcan -->
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
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Installments </h3>
        </div>
        
        <div class = "panel-body">
       
            {{-- data from ajax --}}
            <table id="dataTable" class="table table-hover " role="grid" aria-describedby="dataTable_info">
                <thead>
                <tr>
                    <th>SR#</th>
                    <th>Installment Reference</th>
                    <th>Customer</th>
                    <th>Office Size</th>
                    <th>Fee</th>
                    <th>Date</th>
                    <!-- <th>Created By</th>
                    <th>Status</th> -->
                    <th>Action</th>
                </tr>
            </thead>
                {{-- @dd($merge) --}}
                @foreach ($data as $key=>$item)
               
                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        
                        <a href="/admin/payments/installment/{{@$item->InstallmentId}}">
                            {{@$item->InstallmentId}}
                        </a>
                    </td>
                    <td>
                        <!-- <a href="/admin/customers/{{@$item->customers->id}}"> -->
                        {{@$item->customers->name}}
                        <!-- </a> -->
                    </td>
                    <td>
                        <!-- <a href="/admin/plot/show/{{$item->installmentId}}"> -->
                        {{$item->PlotSize}}
                        <!-- </a> -->
                    </td>
                    <td>
                        <!-- <a href="/admin/plot/show/{{$item->installmentId}}"> -->
                        {{$item->TotalAgreedPrice}}
                        <!-- </a> -->
                    </td>
                    <td>{{$item->ins_Month}}</td>
                    <!-- <td>{{$item->installmentId}}</td>
                    <td>{{@$item->installmentId}}</td> -->
                   
                    <td>
                        @if(Auth::user()->hasPermission('read_merge'))
                        <a class="badge badge-info" href="/admin/payments/installment/{{$item->InstallmentId}}">View</a>
                        @endif
                        
                        {{-- @if(Auth::user()->hasPermission('edit_merge'))
                        <a class="badge badge-warning" href="/admin/merge/edit/{{$item->installmentId}}">Edit</a>
                        @endif
                        @if(Auth::user()->hasPermission('delete_merge'))
                        <a class="badge badge-danger" href="/admin/merge/delete/{{$item->installmentId}}">Delete</a>
                        @endif
                        @if(Auth::user()->hasPermission('read_merge'))
                        <a class="badge badge-info" href="/admin/merge/docs/{{$item->installmentId}}">Docs</a>
                        @endif
                        @if($item->status == 1)
                        @if(Auth::user()->hasPermission('read_merge'))
                        <a class="badge badge-success" href="/admin/merge/certificate/{{$item->installmentId}}">Create Certificate</a>
                        @endif
                        @endif --}}

                    </td>
                </tr>
                @endforeach
               
            </table>
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
                    url: "/admin/application-form/plot/search",
                    data: {
                         "plot": plot ,
                         },
                    dataType:"json",
                    type: "get",
                    success: function(data){
                       var i;
                      $('#plot_project').text(data.project);
                      $('#plot_size').text(data.size);
                      $('#plot_price').text(data.numprice + " Rs ");
                      $('#plot_price_input').val(data.price);
                      $('#plot_block').text(data.block);
                      $('#plot_feature').html('');
                      for( i = 0 ; i < data.feature.length ; i++){
                           $('#plot_feature').append("<label class='badge badge-info' > "+data.feature[i]+" </label> ");
                          }
                       
                    }
                });
          });

            });
         
           
        </script>
   
    
@stop