@extends('voyager::master')
@section('page_title', __('voyager::generic.viewing'))
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
            <h3 class = "panel-title">Edit Instalment period</h3>
        </div>
        <div class = "panel-body" style="padding: 30px;">
            <form action = "{{url('/admin/payments/update-installment')}}" method ="get" enctype = "multipart/form-data">
                @csrf
                <div class="row">
                    <div class=" col-md-6 ">
                        <input type="text" class="form-control" name="periodInstallment" placeholder="{{$installment_data->name}}" > 
                        <input type="hidden" class="form-control" name="periodId" value="{{$installment_data->id}}" > 
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop