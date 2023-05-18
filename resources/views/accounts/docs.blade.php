@extends('voyager::master')

@section('page_title', 'Record')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            {{-- <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name)) --}}
            <a href="/admin/application-form/record" class="btn btn-info btn-add-new">
               <span>View Booking Record</span>
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
            <h3 class = "panel-title text-center">Merge Form Records</h3>
        </div>
        
        <div class = "panel-body" style="margin-top:50px">

            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                     
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doc as $item)

                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->title}}</td>
                        <td>
                            <a href="{{"/".$item->path."/".$item->file}}" class="badge badge-primery" target="-blank">View</a>
                           
                        </td>

                    </tr>
                        
                    @endforeach
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>Customer</th>
                        <th>Plot</th>
                        <th>Ref #</th>
                        <th>Ser #</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        
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