@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    {{-- <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/transfer/create" class="btn btn-success btn-add-new">
               <span>Create Transfer</span>
            </a>
        @endcan
        </h1>
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div> --}}
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
            <h3 class = "panel-title">Transfer Details</h3>
        </div>
        
        <div class = "panel-body">
       
            {{-- data from ajax --}}
            <table id="dataTable" class="table table-hover dataTable no-footer" role="grid" aria-describedby="dataTable_info">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Plot</th>
                    <th>To</th>
                    <th>From</th>
                    <th>Fee</th>
                    <th>Date</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
                {{-- @dd($transfer) --}}
                @foreach ($transfer as $item)
                    
               
                <tr>
                    <td>{{$item->id}}</td>
                    <td><a href="/admin/plot/show/{{$item->plots->id}}">{{$item->plots->name}}</a></td>
                    <td><a href="/admin/customer/{{$item->customerTo->sal_customer_id}}">{{$item->customerTo->sal_customer_name}}</a></td>
                    <td><a href="/admin/customer/{{$item->customerFrom->sal_customer_id}}">{{$item->customerFrom->sal_customer_name}}</a></td>
                    <td>{{$item->fee}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{@$item->users->name}}</td>
                    <td>{{@$item->usersUpdate->name}}</td>
                    <td>
                        @if($item->status == 0)
                        <i class="badge badge-warning">pending</i>
                        @elseif($item->status == 1)
                        <i class="badge badge-success">Approved</i>
                        @elseif($item->status == 2)
                        <i class="badge badge-danger">Rejected</i>
                        @endif
                    </td>
                    <td>
                        @if(Auth::user()->hasPermission('read_transfer'))
                        <a class="badge badge-primary" href="/admin/transfer/show/{{$item->id}}">View</a>
                        @endif
                        @if(Auth::user()->hasPermission('edit_transfer'))
                        <a class="badge badge-warning" href="/admin/transfer/edit/{{$item->id}}">Edit</a>
                        @endif
                        @if(Auth::user()->hasPermission('delete_transfer'))
                        <a class="badge badge-danger" href="/admin/transfer/delete/{{$item->id}}">Delete</a>
                        @endif
                        @if(Auth::user()->hasPermission('read_transfer'))
                        <a class="badge badge-info" href="/admin/transfer/docs/{{$item->id}}">Docs</a>
                        @endif
                        @if($item->status == 1)
                        @if(Auth::user()->hasPermission('read_transfer'))
                        <a class="badge badge-success" href="/admin/transfer/certificate/{{$item->id}}">Create Certificate</a>
                        @endif
                        @endif

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
  
   
    
@stop