@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/tokens/create" class="btn btn-sm btn-success">
               <span>Create Token</span>
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
            <h3 class = "panel-title">Token Records</h3>
        </div>
        
        <div class = "panel-body">
       
            {{-- data from ajax --}}
            <table id="dataTable" class="table table-hover " role="grid" aria-describedby="dataTable_info">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Office No</th>
                    <th>Customer</th>
                    <th>Office Amount</th>
                    <th>Deal Amount</th>
                    <th>Discount Amount</th>
                    <th>Downpayment Amount</th>
                    <th>Token Amount</th>
                    <th>Token Date</th>
                    <th>Created By</th>
                    <th>Verified By</th> 
                    <th>Action</th>
                </tr>
            </thead>
                {{-- @dd($transfer) --}}
                @foreach ($tokens as $item)
                    
               
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{@$item->plots->office_no}}</td>
                    <td>{{@$item->customers->name}}</td>
                    <td>{{$item->office_amount}}</td>
                    <td>{{$item->deal_amount}}</td>
                    <td>{{$item->discount_amount}}</td>
                    <td>{{$item->downpayment}}</td>
                    <td>{{$item->amount}}</td>
                    <td>{{$item->expriry_date}}</td>
                    <td>{{$item->created_by}}</td>
                    <td>
                        
                            <a  href="/admin/tokens/{{$item->id}}/delete" title="Delete" class="badge badge-sm badge-danger pull-right delete" data-id="2" id="delete-2">
                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                            </a>
                            <a href="/admin/tokens/{{$item->id}}/edit" title="Edit" class="badge badge-sm badge-primary pull-right edit">
                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Edit</span>
                            </a>
                            {{-- <a href="/admin/tokens/{{$item->id}}" title="View" class="badge badge-sm badge-warning pull-right view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">View</span>
                            </a> --}}
                         
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
                        <td scope="col">{{@$customer->id}}</td>
                        <th scope="col">Name</th>
                        <td scope="col">{{@$customer->name}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Country</th>
                        <td scope="col">{{@$customer->country}}</td>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <td scope="col">{{@$customer->city}}</td>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <td scope="col">{{@$customer->phone}}</td>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <td scope="col">{{@$customer->email}}</td>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <td scope="col">{{@$customer->sal_AccountCode}}</td>
                        <th scope="col">#</th>
                        <td scope="col">{{@$customer->sal_sub_ledger_code}}</td>
                    </tr>
                    <tr>
                        <th scope="col">Address 1</th>
                        <td scope="col" colspan="3">{{@$customer->address}}</td>
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