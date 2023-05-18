@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <!-- <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/transfer/create" class="btn btn-success btn-add-new">
               <span>Create Transfer</span>
            </a>
        @endcan
        </h1> -->
      @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
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
 </style>

  
@stop

@section('content')
    <div class="page-content  browse container-fluid">
        @include('voyager::alerts')
            
    </div>
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Todays Notifications</h3>
        </div>
        @php
            $tokens = DB::table('tokens')->where('expriry_date',date("Y/m/d"))->get();
            $receiving = DB::table('InsatllmentDetails')->where('month',date("Y/m/d"))->get();
            $bookings = DB::table('bookings')->get();
            
            $transfer = DB::table('transfers')->where('status',1)->get();
           // dd($transfer);
        @endphp
        {{-- for Receivings --}}
        @if(isset($receiving))
        
       <div class="row">
           <div class="col-md-1"></div>
           <div class="col-md-10">
            <div class = "panel-body">
                <div class = "panel-heading" style="background-color: #2a3b44; border-bottom: 0;">
                    <h5 class = "panel-title">Receiving Notifications</h3>
                </div>
                {{-- data from ajax --}}
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Sr#</th>
                        <th scope="col">Installment Id</th>
                        <th scope="col">company Id</th>
                        <th scope="col">Installment Month</th>
                        <th scope="col">Installment Amount</th>
                        <th scope="col">Bullet payment</th>
                        <th scope="col">Amount Received</th>
                        <th scope="col">Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                   @foreach ($receiving as $t )
                   <tr>
                        <td>{{$t->InsatllmentDetailsid}}</td>
                        <td>{{$t->InstallmentId}}</td>
                        <td>{{$t->CompanyId}}</td>
                        <td>{{$t->month}}</td>
                        <td>{{$t->MonthlyInstallment}}</td>
                        <td>{{$t->Bulletpayment}}</td>
                        <td>{{$t->AmountReceived}}</td>
                        <td>{{$t->outstandingbalance}}</td>
                    </tr>
                   @endforeach
                    </tbody>
                </table>
                
            </div>
           </div>
           <div class="col-md-1"></div>
       </div>
   @else
       
   @endif
       {{-- for Tokens --}}
   @if(isset($tokens))
         
            
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
            <div class = "panel-body">
                <div class = "panel-heading" style="background-color: #2a3b44; border-bottom: 0;">
                    <h5 class = "panel-title">Tokens Notifications</h3>
                </div>
                {{-- data from ajax --}}
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Sr#</th>
                        <th scope="col">Customer Id</th>
                        <th scope="col">Plot Id</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Deduction</th>
                        <th scope="col">Expriry Date</th>
                        <th scope="col">Financial Year</th>
                        <th scope="col">Installment Month</th>
                        <th scope="col">Notes</th>
                        <th scope="col">Created By</th>
                    </tr>
                    </thead>
                    <tbody>
                   @foreach ($tokens as $t )
                   <tr>
                        <td>{{$t->id}}</td>
                        <td>{{$t->customer_id}}</td>
                        <td>{{$t->plot_id}}</td>
                        <td>{{$t->amount}}</td>
                        <td>{{$t->deduction}}</td>
                        <td>{{$t->expriry_date}}</td>
                        <td>{{$t->FinancialYear}}</td>
                        <td>{{$t->ins_Month}}</td>
                        <td>{{$t->notes}}</td>
                        <td>{{$t->created_by}}</td>
                    </tr>
                   @endforeach
                    </tbody>
                </table>
                
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
       @else
           
       @endif
       {{-- for Bookings --}}
       @if(isset($bookings))
         
            
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
            <div class = "panel-body">
                <div class = "panel-heading" style="background-color: #2a3b44; border-bottom: 0;">
                    <h5 class = "panel-title">Bookings Notifications</h3>
                </div>
                {{-- data from ajax --}}
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Sr#</th>
                        <th scope="col">Plot Id</th>
                        <th scope="col">Customer Id</th>
                        <th scope="col">Agent Id</th>
                        <th scope="col">Agent commision</th>
                        <th scope="col">Agent amount </th>
                        <th scope="col">Reference No</th>
                        <th scope="col">Serial No Month</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Plot Size</th>
                        <th scope="col">Tanure</th>
                        <th scope="col">status</th>
                        <th scope="col">Created By</th>
                    </tr>
                    </thead>
                    <tbody>
                   @foreach ($bookings as $t )
                   <tr>
                        <td>{{$t->id}}</td>
                        <td>{{$t->plot_id}}</td>
                        <td>{{$t->customer_id}}</td>
                        <td>{{$t->agent_id}}</td>
                        <td>{{$t->agent_commission}}</td>
                        <td>{{$t->agent_amount}}</td>
                        <td>{{$t->ref_num}}</td>
                        <td>{{$t->ser_num}}</td>
                        <td>{{$t->amount}}</td>
                        <td>{{$t->plot_size}}</td>
                        <td>{{$t->tunure}}</td>
                        <td>{{$t->status}}</td>
                        <td>{{$t->created_by}}</td>
                    </tr>
                   @endforeach
                    </tbody>
                </table>
                
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
       @else
           
       @endif


       
</div>
     
   
      
    

@stop
@section('javascript')

    
    <script type="text/javascript">
            $(document).ready(function() {

                $('#customer').change(function(){
                   var customer = $('#customer').val();
           
                    $.ajax({
                        url: "/admin/application-form/customer/search",
                        data: {
                            "customerID": customer ,
                            },
                        dataType:"json",
                        type: "get",
                        success: function(data){
                        console.log(data);
                        $('#c_so').text(data.so);
                        $('#c_phone').text(data.phone);
                        $('#c_email').text(data.email);
                        $('#c_cnic').text(data.cn );
                        }
                    });
                });



                $('#customer_to').change(function(){
                   var customer = $('#customer_to').val();
           
                    $.ajax({
                        url: "/admin/application-form/customer/search",
                        data: {
                            "customerID": customer ,
                            },
                        dataType:"json",
                        type: "get",
                        success: function(data){
                        console.log(data);
                        $('#c_so_to').text(data.so);
                        $('#c_phone_to').text(data.phone);
                        $('#c_email_to').text(data.email);
                        $('#c_cnic_to').text(data.cn );
                        }
                    });
                });



                $('#plot').change(function(){
                var plot = $('#plot').val();
                $.ajax({
                    url: "/admin/application-form/plot/search",
                    data: {
                         "plot": plot ,
                         },
                    dataType:"json",
                    type: "get",
                    success: function(data){
                       var i;
                      $('#plot_project').text(data.project);
                      $('#plot_size').text(data.size);
                      $('#plot_price').text(data.numprice + " Rs ");
                      $('#plot_price_input').val(data.price);
                      $('#plot_block').text(data.block);
                      $('#plot_feature').html('');
                      for( i = 0 ; i < data.feature.length ; i++){
                           $('#plot_feature').append("<label class='badge badge-info' > "+data.feature[i]+" </label> ");
                          }
                       
                    }
                });
          });

            });
  
   
    
@stop