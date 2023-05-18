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
            <form action = "{{url('/admin/payments/update-installmentType')}}" method ="get" enctype = "multipart/form-data">
                @csrf
                <div class="row">
                    <div class=" col-md-3 ">
                        <input type="text" class="form-control" name="type" placeholder="{{$installment_data->name}}"> 
                    </div>
                    <div class=" col-md-3 ">
                        <input type="number" class="form-control" name="type_value" placeholder="{{$installment_data->value}}"> 
                        <input type="hidden" class="form-control" name="typeId" value="{{$installment_data->id}}"> 
                    </div>
                    <div class=" col-md-3 ">
                        <label>Balloon Payment: </label>
                        <input type="checkbox" name="checkbox_value" id="checkbox_value" value="yes" @if(old('balloon_payment',$installment_data->balloon_payment)=="1") checked @endif>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop