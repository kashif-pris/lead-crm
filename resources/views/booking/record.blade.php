@extends('voyager::master')

@section('page_title', 'Record')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            @if(Auth::user()->hasPermission('add_booking'))
            <a href="/admin/application-form" class="btn btn-success btn-add-new">
               <span>Booking Form</span>
            </a>
          @endif
        </h1>
        @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>

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
            <h3 class = "panel-title text-center">Booking Form Records</h3>
        </div>
        
        <div class = "panel-body" style="margin-top:50px">

            <table id="dataTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ser #</th>
                        <th>Customer</th>
                        <th>Agent</th>
                        <!-- <th>Comission</th> -->
                        {{-- <th>Plot</th> --}}
                        <!-- <th>Amount</th> -->
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking as $key=>$item)

                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->ser_num}}</td>
                        <td>
                        <!-- <a href="/admin/customer/{{@$item->customers->id}}"> -->
                            {{@$item->customers->name}}
                        <!-- </a> -->
                    </td>
                        <td>
                            
                                @if(@$item->agents->name)
                                <a href="/admin/users/{{@$item->agents->id}}">
                                {{@$item->agents->name}}
                                </a>
                                @else 
                                    N/A
                                @endif
                             
                         </td>
                        <!-- <td>
                            @if(@$item->agent_commission)
                            {{@$item->agent_commission}}
                            @else 
                                N/A
                            @endif
                        </td> -->
                        {{-- <td><a href="/admin/plot/show/{{@$item->plots->id}}">{{@$item->plots->name}}</a></td> --}}
                        <!-- <td>{{$item->amount}}</td> -->
                        @if($item->status  == 0)
                        <td><i class="badge badge-warning">Pending</i></td>
                        @elseif($item->status  == 1)
                        <td><i class="badge badge-success">Approved</i></td>
                        @elseif($item->status  == 2)
                        <td><i class="badge badge-danger">Rejected</i></td>
                        @elseif($item->status  == 3)
                        <td><i class="badge badge-danger">Cancelled</i></td>
                        @endif
                        
                        <td>{{$item->users[0]->name}}</td>
                        <td>
                            @if(Auth::user()->hasPermission('read_booking'))
                                @foreach($installmentMaster as $valueData)
                                    @if($valueData->FormNo == $item->id)
                                        <a href="/admin/application-form/show/{{$item->id}}" class="badge badge-primery">View</a>
                                    @else
                                    @endif
                                @endforeach
                            @endif
                            @if(Auth::user()->hasPermission('read_booking'))
                            <a href="/admin/application-form/docs/{{$item->id}}" class="badge badge-warning">Docs</a>
                            @endif
                            @if(Auth::user()->hasPermission('edit_booking'))
                            <a href="/admin/application-form/edit/{{$item->id}}" class="badge badge-info">Edit</a>
                            @endif
                            @if(Auth::user()->hasPermission('delete_booking'))
                            <a href="/admin/application-form/delete/{{$item->id}}" class="badge badge-danger">Delete</a>
                            @endif
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
