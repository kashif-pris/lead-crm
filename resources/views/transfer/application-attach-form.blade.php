@extends('voyager::master')

@section('page_title', 'Record')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            {{-- <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name)) --}}
            <a href="/admin/transfer/record" class="btn btn-info btn-add-new">
               <span>View Transfer Record</span>
            </a>
            <a href="/admin/transfer/show/{{$id}}" class="btn btn-success btn-add-new">
                <span>View Transfer Form</span>
             </a>
        {{-- @endcan --}}
        </h1>
        @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>

@stop

@section('content')
   
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title text-center">Booking Form Records</h3>
        </div>
        
        <div class = "panel-body" style="margin-top:50px">
<div class="row">
    <div class="col-md-6">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th colspan="3">Transferor</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($from as $item)

                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->title}}</td>
                    <td>
                        <a href="{{"/".$item->path."/".$item->file}}" class="badge badge-primery" target="-blank">View</a>
                       
                    </td>

                </tr>
                    
                @endforeach
                
            </tbody>
         
        </table>
    </div>
    <hr>
    <hr>
    <hr>
    <hr>
    <div class="col-md-6">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th colspan="3">Transferee</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($to as $item)

                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->title}}</td>
                    <td>
                        <a href="{{"/".$item->path."/".$item->file}}" class="badge badge-primery" target="-blank">View</a>
                       
                    </td>

                </tr>
                    
                @endforeach
                
            </tbody>
            
        </table>
    </div>
</div>
           
        
        </div>
    </div>
     
   
      
    

@stop
@section('javascript')
 
<script src="{{ asset('dataTable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dataTable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dataTable/jszip.min.js') }}"></script>
 
 <script>

    $(document).ready(function() {
        $('#example').DataTable( {
            responsive: true
        });
    });
 </script>


    
@stop