@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-pie-chart"></i>
            <a href="/admin/plot/record" class="btn btn-success btn-add-new">
               <span>Allotment Certificates</span>
            </a>
      
        </h1>
        @include('voyager::multilingual.language-selector')
    </div>
    
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
    /* .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 5px 45px;
        cursor: pointer;
        margin-top: 26px;
    } */
    .form-control {
    color: #3c4248;
    background-color: #fff;
    background-image: none;
    border: 1px solid #2830378f;
}
    body{ 
        color: #3e3e3e !important;
    margin-top:40px; 
}
.required{
    color:red;
}
.btn-link, .checkbox-inline, .checkbox label, .radio-inline, .radio label, label {
    font-weight: 600;
}
 </style>

  
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
  
        
	<div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Available List</h3>
                <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span>
            </div>
            <div class="panel"  style="padding:12px;">
                
                <table id="dataTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sr#</th> 

                            <th>Plot</th> 
                          <th>Customer Name</th> 
                          <th>CNIC / Passport</th>
                          <th>Mobile</th>
                          <th>Status</th>

                          <th>Action</th>



                        </tr>
                      </thead>
                      <tbody>
                  
                        @foreach ($custData as $key=>$item)
                        @php 
                       
                        $certificate = DB::table('allotments')->where('booking_id',$item->id)->first(); 
                        $countCertificate = DB::table('allotments')->where(['booking_id'=>$item->id])->count(); 
                      
                        @endphp
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                <a href="/admin/plot/show/{{@$item->plots->id}}">
                                    {{$item->booking->plots->name}}
                                </a>
                            </td>
                            <td>
                                <a href="/admin/customers/{{@$item->customers->id}}">
                                    {{$item->booking->customers->sal_customer_name}}
                                </a>
                            </td>
                            <td>{{$item->booking->customers->sal_customer_id}}</td>
                            <td>{{$item->booking->customers->sal_customer_cell}}</td>
                            <td>
                               
                                    {{$item->status}}
                               
                            </td>
                       
                            <td>
                              
                                <a href="/admin/pac/generate/duplicate/{{$item->booking->id}}/{{$key}}">
                                    <span class="badge badge-pill badge-success">View Certificate</span>
                                </a>
                                  
                               
  
                               
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
@section('css')
    <style>
   
    @media screen and (min-width: 480px) {
        .dt-buttons{
            position: relative Im !important;
            left: 10px  !important;
        }
    }
    </style>
    
    
@stop
