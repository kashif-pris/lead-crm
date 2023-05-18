@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/customer/create" class="badge badge-success badge-add-new">
               <span>Create Customer</span>
            </a>
        @endcan
        </h1>
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>

  
@stop

@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Customer Records</h3>
        </div>
        
        <div class = "panel-body">
       
            {{-- data from ajax --}}
            <table id="dataTable" class="table table-hover " role="grid" aria-describedby="dataTable_info">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>S/O</th>
                    <th>CNIC</th>
                    <th>Phone</th>
                    <th>Email</th>
                    {{-- <th>Ledger</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
                {{-- @dd($transfer) --}}
                @foreach ($customers as $item)
                    
               
                <tr>
                    <td>{{$item->sal_customer_id}}</td>
                    <td>{{$item->sal_customer_name}}</td>
                    <td>{{$item->sal_customer_cont_person}}</td>
                    <td>{{$item->sal_customer_cnic}}</td>
                    {{-- <td>{{$item->sal_customer_country}}</td>
                    <td>{{$item->sal_customer_city}}</td>
                    <td>{{$item->sal_customer_stateprov}}</td> --}}
                    <td>{{$item->sal_customer_cell}}</td>
                    <td>{{$item->sal_customer_email}}</td>
                    {{-- <td>{{$item->sal_sub_ledger_code}}</td> --}}
                    <td>
                        
                            <a  href="/admin/customer/{{$item->sal_customer_id}}/delete" title="Delete" class="badge badge-sm badge-danger pull-right delete" data-id="2" id="delete-2">
                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                            </a>
                            <a href="/admin/customer/{{$item->sal_customer_id}}/edit" title="Edit" class="badge badge-sm badge-primary pull-right edit">
                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Edit</span>
                            </a>
                            <a href="/admin/customer/{{$item->sal_customer_id}}" title="View" class="badge badge-sm badge-warning pull-right view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">View</span>
                            </a>
                         
                    </td>
                    
                </tr>
                @endforeach
               
            </table>
      
    </div>
</div>

@if(isset($customer))

{{-- model --}}

  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Customer Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <td scope="col">{{@$customer->sal_customer_id}}</td>
                        <th scope="col">Name</th>
                        <td scope="col">{{@$customer->sal_customer_name}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Father Name</th>
                        <td scope="col">{{@$customer->sal_customer_cont_person}}</td>
                        <th scope="col">Country</th>
                        <td scope="col">{{@$customer->sal_customer_country}}</td>
                    </tr>
                    <tr>
                        <th scope="col">City</th>
                        <td scope="col">{{@$customer->sal_customer_city}}</td>
                        <th scope="col">Province</th>
                        <td scope="col">{{@$customer->sal_customer_stateprov}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Postal Code</th>
                        <td scope="col">{{@$customer->sal_customer_postalcode}}</td>
                        <th scope="col">Phone Number</th>
                        <td scope="col">{{@$customer->sal_customer_cell}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Fax</th>
                        <td scope="col">{{@$customer->sal_customer_fax}}</td>
                        <th scope="col">Email</th>
                        <td scope="col">{{@$customer->sal_customer_email}}</td>
                    </tr>
                    <tr>
                        <th scope="col">GST</th>
                        <td scope="col">{{@$customer->sal_customer_gst}}</td>
                        <th scope="col">Tax</th>
                        <td scope="col">{{@$customer->sal_customer_tax}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Account Code</th>
                        <td scope="col">{{@$customer->sal_AccountCode}}</td>
                        <th scope="col">Ladger Code</th>
                        <td scope="col">{{@$customer->sal_sub_ledger_code}}</td>
                    </tr>
                    <tr>
                        <th scope="col">CNIC</th>
                        <td scope="col" colspan="3">{{@$customer->sal_customer_cnic}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Address 1</th>
                        <td scope="col" colspan="3">{{@$customer->sal_customer_address_1}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Address 2</th>
                        <td scope="col" colspan="3">{{@$customer->sal_customer_address_2}}</td>
                    </tr>
                </thead>
                
                </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="badge badge-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  {{-- end model --}}

  @endif
     
   
      
    

@stop
@if(isset($customer))

@section('javascript')

    
    <script type="text/javascript">
         $(document).ready(function() {
            $(window).on('load', function() {
                $('#staticBackdrop').modal('show');
            });
         });
     </script>

@stop
@endif