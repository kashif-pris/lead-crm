@extends('voyager::master')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class=" voyager-pie-chart"></i>
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
                          <th>Name</th> 
                          <th>CNIC</th>
                          <th>Mobile</th>
                          <th>Total</th>
                          <th>Paid</th>
                          <th>Balance</th>
                          <th>No.Of Certificates</th>
                          <th>Status</th>
                          <th>Created By</th>
                          <th>Action</th>



                        </tr>
                      </thead>
                      <tbody>
                        
                        @foreach ($custData as $key=>$item)
                        @php 
                        $certificate = DB::table('allotments')->where('booking_id',$item->id)->first(); 
                        $countCertificate = DB::table('allotments')->where(['booking_id'=>$item->id])->where('type','duplicate')->count(); 
                        // $paidAmount = DB::table('InsatllmentDetails')
                        // ->where('InstallmentId',$item->payments->InstallmentId)
                        // ->where('AmountReceived','')
                        // ->get();
                       // dd($paidAmount);
                        if(!empty($certificate)){
                             $user = DB::table('users')->where('id',$certificate->created_by)->first(); 
                        }else{
                            $user = null;
                        }
                        @endphp
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                <a href="/admin/plot/show/{{$item->plots->id}}">
                                    {{$item->plots->name}}
                                </a>
                            </td>
                            <td>
                                <a href="/admin/customer/{{$item->customers->sal_customer_id}}">
                                    {{$item->customers->sal_customer_name}}
                                </a>
                            </td>
                            <td>{{$item->customers->sal_customer_id}}</td>
                            <td>{{$item->customers->sal_customer_cell}}</td>
                            <td>{{$item->payments->propertyprice}}</td>
                            <td>{{$item->payments->downpayment + $item->payments->PaidAmount}}</td>
                            <td>{{$item->payments->RemainingAmount}}</td>
                            <td>
                                @if($countCertificate == 0 && !empty($certificate))
                                    <a href="/admin/pac/details/{{$item->id}}">{{$countCertificate}}</a>
                                @elseif($countCertificate == 0 && empty($certificate))    
                                    N/A
                                @else   
                                <a href="/admin/pac/details/{{$item->id}}"> {{$countCertificate}}</a>
                                @endif
                            </td>
                            <td>
                                @if(!empty($certificate))
                                {{$certificate->status}}
                                @else   
                                N/A
                                @endif
                            </td>
                            <td>
                                @if(!empty($user))
                                <a href="/admin/users/{{$user->id}}"> {{$user->name}}</a>
                                @else   
                                N/A
                                @endif
                            </td>
                            <td>
                                @if(!empty($certificate))
                                <a href="/admin/pac/generate/{{$item->id}}">
                                    <span class="badge badge-pill badge-success">View Certificate</span>
                                  </a>
                                
                                  @if(Auth::user()->hasPermission('duplicate_allotments'))
                                    @if(!empty($certificate))
                                        @if($certificate->status == "Approved" || $certificate->status == "Delivered")
                                        <a href="/admin/pac/generate/duplicate/{{$item->id}}">
                                            <span class="badge badge-pill badge-warning">Make Duplicate</span>
                                        </a>
                                        @endif
                                    @endif
                                   
                                @endif
                                @else
                                <a href="/admin/pac/generate/{{$item->id}}">
                                  <span class="badge badge-pill badge-success">Generate Certificate</span>
                                </a>
                                @endif
  
                               
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

