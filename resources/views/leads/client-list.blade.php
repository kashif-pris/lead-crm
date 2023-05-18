@extends('voyager::master')



@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/client-list/download" class="badge badge-success badge-add-new">
               <span>Download</span>
            </a>
        @endcan
        </h1>
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<style>
    input[type="text"] {
        color: black;
    }
</style>
@stop

@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Client List</h3>
        </div>
        
        <div class = "panel-body">
       
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th> Name</th>
                    <th>Agent Name</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($clients))
                @foreach($clients as  $key=>$item)
         
                @php
                    $user = DB::table('users')->where('id', @$item->created_by)->select('name')->first();
                @endphp
                 <tr>
                    <td>{{$key+1}}</td>
                    <td>{{@$item->name}}</td>
                    <td>{{@$user->name}}</td>
                    <td>{{@$item->phone}}</td>
                </tr>
                
                @endforeach
                @endif
            
               
            </tbody>
        
        </table>
      
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable( {
            
            lengthChange: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ]
        } );
    } );
</script>

@stop
