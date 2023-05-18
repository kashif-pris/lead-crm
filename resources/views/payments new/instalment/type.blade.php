@extends('voyager::master')
@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
@section('page_header')
  
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
            <h3 class = "panel-title">Add Instalment Type</h3>
        </div>
        <div class = "panel-body" style="padding: 30px;">
            <form action = "{{route('type.create')}}" method ="post" enctype = "multipart/form-data">
                @csrf
                <div class="row">
                    <div class=" col-md-3 ">
                        <input type="text" class="form-control" name="type" placeholder="i.e One Month" required> 
                    </div>
                    <div class=" col-md-3 ">
                        <input type="number" class="form-control" name="type_value" placeholder="i.e 1" required> 
                    </div>
                    <div class=" col-md-3 ">
                        <label>Balloon Payment: </label>
                        <input type="checkbox" name="balloon" >
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>

        <div class = "panel-body">
       
            {{-- data from ajax --}}
            <table id="dataTable" class="table table-hover " role="grid" aria-describedby="dataTable_info">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Time Duration</th>
                    <th>Value</th>
                    <th>Balloon Payment</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            @foreach ($installmentType as $item)
                    
               
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->value}}</td>
                <td><input type="checkbox" onclick="return false;" name="tag_1" id="tag_1" value="yes" @if(old('balloon_payment',$item->balloon_payment)=="1") checked @endif></td>
                <td>{{$item->created_at}}</td>
                <td>
                    
                        <a  href="/admin/payments/typeInstallment/{{$item->id}}/delete" title="Delete" class="badge badge-sm badge-danger pull-right delete" data-id="2" id="delete-2">
                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                        </a>
                        <a href="/admin/payments/typeInstallment/{{$item->id}}/edit" title="Edit" class="badge badge-sm badge-primary pull-right edit">
                        <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Edit</span>
                        </a>
                        {{-- <a href="/admin/tokens/{{$item->id}}" title="View" class="badge badge-sm badge-warning pull-right view">
                        <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">View</span>
                        </a> --}}
                     
                </td>
                
            </tr>
            @endforeach

           
                {{-- @dd($transfer) --}}
               
            </table>
      
    </div>


    </div>
@stop