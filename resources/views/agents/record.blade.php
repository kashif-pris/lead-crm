@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))


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
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 5px 45px;
        cursor: pointer;
        margin-top: 26px;
    }
 </style>

@section('page_header')
<div class="container-fluid">
    <h1 class="page-title">
        <i class="icon voyager-pie-chart"></i>
             
    </h1>
        <a href="/admin/agent/create" class="btn btn-success ">
           <span>Add New Agent</span>
        </a>
        <a href="/admin/agent/record" class="btn btn-warning ">
            <span>View All Agent</span>
         </a>
       
        

  
  
   
 
    @include('voyager::multilingual.language-selector')
</div>

@stop


@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Agents Records</h3>
        </div>
        
        <div class = "panel-body">
       
            {{-- data from ajax --}}
            <table id="" class="table table-hover dataTable no-footer" role="grid" aria-describedby="dataTable_info">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    {{-- <th>Father Name</th> --}}
                    <th>CNIC</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    {{-- <th>City</th> --}}
                    {{-- <th>Address</th> --}}
                    {{-- <th>Date Of Birth</th> --}}
                    <th>Commission (%)</th>
                    {{-- <th>Registration No.</th> --}}
                    {{-- <th>Representative</th> --}}
                    {{-- <th>Momorandom</th> --}}
                    <th>Project</th>
                    {{-- <th>Description</th> --}}
                    <th>Action</th>
                </tr>
            </thead>

                @foreach ($agentsRecord as $a)
                <tr>
                    <td>{{$a->id}}</td>
                    <td>{{$a->name}}</td>
                    {{-- <td>{{$a->father}}</td> --}}
                    <td>{{$a->cnic}}</td>
                    <td>{{$a->email}}</td>
                    <td>{{$a->mobile}}</td>
                    {{-- <td>{{$a->city}}</td> --}}
                    {{-- <td>{{$a->address}}</td> --}}
                    {{-- <td>{{$a->date_of_birth}}</td> --}}
                    <td>{{$a->commission}}</td>
                    {{-- <td>{{$a->reg_no}}</td> --}}
                    {{-- <td>{{$a->representative}}</td> --}}
                    {{-- <td>{{$a->momorandom}}</td> --}}
                    <td>{{@$a->projects->project_name}}</td>
                    {{-- <td>{{$a->description}}</td> --}}
                    <td>
                        <a class="badge badge-primary" href="/admin/agent/show/{{$a->id}}">View</a>
                        <a class="badge badge-warning" href="/admin/agent/edit/{{$a->id}}">Edit</a>
                        <a class="badge badge-danger" href="/admin/agent/delete/{{$a->id}}">Delete</a>
                    </td>
                </tr>
                @endforeach
               
            </table>
    </div>
</div>
@if(isset($agentShow))
  <!-- Modal -->

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Agent Name : {{$agentShow->name}} <span class="text text-danger"> ( {{$type[$agentShow->person_type]}} )</span></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-striped table-bordered">
             <tr>
                 <th>Name</th>
                 <td>{{$agentShow->name}}</td>
                 <th>Father Name</th>
                 <td>{{$agentShow->father}}</td>
             </tr>
             <tr>
                <th>Email</th>
                <td>{{$agentShow->email}}</td>
                <th>Mobile</th>
                <td>{{$agentShow->mobile}}</td>
            </tr>
            <tr>
                <th>CNIC</th>
                <td>{{$agentShow->cnic}}</td>
                <th>D-O-B</th>
                <td>{{$agentShow->date_of_birth}}</td>
            </tr>
            <tr>
                <th>Commission</th>
                <td>{{$agentShow->commission}}</td>
                <th>Project</th>
                <td></td>
            </tr>
            <tr>
                <th>City</th>
                <td>{{$agentShow->city}}</td>
                <th>Address</th>
                <td>{{$agentShow->address}}</td>
            </tr>
            <tr>
                <th>Reg No</th>
                <td>{{$agentShow->reg_no}}</td>
                <th>Representative</th>
                <td>{{$agentShow->representative}}</td>
            </tr>
            <tr>
                <th>Memorandom</th>
                <td>{{$agentShow->memorandom}}</td>
                <th>Description</th>
                <td>{{$agentShow->description}}</td>
            </tr>
            <tr>
                <th>Avatar</th>
                <td>
                    <a href="{{asset('storage/Files/agents/'.$agentShow->avatar)}}" target="_blank" download="{{asset('storage/Files/agents/'.$agentShow->avatar)}}">{{$agentShow->avatar}}</a>
                </td>
                <th>Reg Certificate</th>
                <td>
                    <a href="{{asset('storage/Files/agents/'.$agentShow->reg_certificate)}}" target="_blank" download="{{asset('storage/Files/agents/'.$agentShow->reg_certificate)}}">{{$agentShow->reg_certificate}}</a>
                  </td>
            </tr>
            <tr>
                <th>NTN</th>
                <td>
                    <a href="{{asset('storage/Files/agents/'.$agentShow->ntn)}}" target="_blank" download="{{asset('storage/Files/agents/'.$agentShow->ntn)}}">{{$agentShow->ntn}}</a> 
                </td>
                <th>Form 29</th>
                <td>
                    <a href="{{asset('storage/Files/agents/'.$agentShow->form29)}}" target="_blank" download="{{asset('storage/Files/agents/'.$agentShow->form29)}}">{{$agentShow->form29}}</a>
                </td>
            </tr>
            
          </table>
          <div class="container">
            <div class="row">
                @if (!empty($TotalPlotSales))
                    <legend>No of Plot Booked:: {{$TotalPlotSales}}</legend>
                    <legend>Total Commission:: {{$TotalAgentSales}} Rs/-</legend>
                @else
                    <p style="color: black"> <span style="color: red">NOtE::</span> Booking plot record against this agent not exist..</p>
                @endif
              
            </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
       $(document).ready(function() {
            $("#exampleModal").modal("show");
       });
    
 </script>
     
   @endif
      
    

@stop
@section('javascript')

@stop