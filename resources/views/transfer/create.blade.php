@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/transfer/record" class="btn btn-success btn-add-new">
               <span>All Transfer History</span>
            </a>
        @endcan
        </h1>
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

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
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
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Create Transfer</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "{{route('transfer.store')}}" method ="post" enctype = "multipart/form-data">
        @csrf
            <div class="row">
               <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Plot Name <span class="required">*</span> </label>
                        <select name="plot" class="form-control" id="plot">
                            <option>--choose</option>
                            @foreach($plots as $item)
                            <option  value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Refernece Num <span class="required">*</span> </label>
                       <input required type="text" onkeypress="if(this.value.length==8){return false;}" class="form-control" placeholder="ref num" name="ref_num">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Serial Num <span class="required">*</span> </label>
                       <input type="text" readonly value="{{$ser_num}}" class="form-control" placeholder="Ser num" name="ser_num">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Transfer Fee <span class="required">*</span> </label>
                        <input type="text" id="transfer_fee_new" value="0" name="fee" class="form-control">
                        <input type="hidden" id="transfer_fee" value="{{$fee}}"  class="form-control">
                        <input type="hidden" id="booking_id"  name="booking_id" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Total Balance</label>
                        <input type="text" value="" id="totalAmount" name="totalAmount"  class="form-control">
                     </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Agents</label>
                        <select name="agent" class="form-control select2">
                            <option> -- Choose -- </option>
                            @foreach($agents as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                     </div>
                </div>

                
                
            
               

              
            </div>



            <div class="row">
                <hr>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Customer Information </legend>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Plot Information --}}
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Plot Details</legend>
                                    <div class="control-group">
                                       
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="control-label pull-right">Plot Project :  </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="badge badge-primery" id="plot_project"></label>
                                            </div>
                                        </div>
                                       <div class="row">
                                            <div class="col-md-3">
                                                <label class="control-label pull-right">Plot Block :  </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="badge badge-warning" id="plot_block"></label>
                                            </div>
                                       </div>
                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="control-label pull-right">Plot Size :  </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="badge badge-success" id="plot_size"></label>
                                            </div>    
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                          
                                                <label class="control-label pull-right">Plot Price :  </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="badge badge-danger" id="plot_price"></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                          
                                                <label class="control-label pull-right">Plot Type :  </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="badge badge-info" id="plot_type"></label>
                                            </div>
                                        </div>
                                      
                                        
                                    </div>
                                </fieldset>

                        </div>
                        <div class="col-md-6">
                            {{-- Customer Account Information --}}

                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Account Status</legend>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label pull-right">Down Payment:  </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="badge badge-primery" id="downpayment"></label>
                                            <input type="hidden" value="" id="downpayment2" name="downpayment">
                                        </div>
                                    </div>
                                   <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label pull-right">No of Instalments :  </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="badge badge-warning" id="totalInstallments"></label>
                                            <input type="hidden" value="" id="totalInstallments2" name="totalInstallments">
                                        </div>
                                   </div>
                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label pull-right">Paid Instalments :  </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="badge badge-success" id="totalPaidInstallments"></label>
                                            <input type="hidden" value="" id="totalPaidInstallments2" name="totalPaidInstallments">
                                        </div>    
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label pull-right">Receivable Balance :  </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="badge badge-danger" id="remainingAmount"></label>
                                            <input type="hidden" value="" id="remainingAmount2" name="remainingAmount">
                                        </div>
                                    </div>

                                    

                                </div>
                               
                            </fieldset>
                        </div>
                    
                </fieldset>

            </div>
      

         
          
<div class="row">
<hr>
    <div class="col-md-6">
        <label for="customer">Transferer </label>
            <select class="form-control  " id="customer" name="customer_from"  tabindex="-1" aria-hidden="true">
                @foreach($customers as $item)
                <option value="{{$item->sal_customer_id}}" >{{$item->sal_customer_name}}</option>
                @endforeach
            </select>
         
          
            {{-- data from ajax --}}
            <table class="table table-striped"> 
                <tr>
                    <th>Customer S/O :</th>
                    <td><label class="badge badge-primery" id="c_so"></label></td>
                </tr>
                <tr>
                    <th>Customer Phone : </th>
                    <td><label class="badge badge-primery" id="c_phone"></label></td>
                </tr>
                <tr>
                    <th>Customer Email :</th>
                    <td><label class="badge badge-primery" id="c_email"></label></td>
                </tr>
                <tr>
                    <th>Customer Cnic :</th>
                    <td><label class="badge badge-primery" id="c_cnic"></label></td>
                </tr>
            </table>
         </div>
         

            {{-- to --}}


            <div class="col-md-6">
                <label for="customer">Transferee</label>
                    <select class="form-control select2 " id="customer_to" name="customer_to"  tabindex="-1" aria-hidden="true">
                        @foreach($customers as $item)
                        <option value="{{$item->sal_customer_id}}" >{{$item->sal_customer_name}}</option>
                        @endforeach
                    </select>
                 
                  
                    {{-- data from ajax --}}
                    <table class="table table-striped"> 
                        <tr>
                            <th>Customer S/O :</th>
                            <td><label class="badge badge-primery" id="c_so_to"></label></td>
                        </tr>
                        <tr>
                            <th>Customer Phone : </th>
                            <td><label class="badge badge-primery" id="c_phone_to"></label></td>
                        </tr>
                        <tr>
                            <th>Customer Email :</th>
                            <td><label class="badge badge-primery" id="c_email_to"></label></td>
                        </tr>
                        <tr>
                            <th>Customer Cnic :</th>
                            <td><label class="badge badge-primery" id="c_cnic_to"></label></td>
                        </tr>
                    </table>
                 </div>
            </div>
            <div class="row">
                    {{-- down payment --}}

                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-2">
    
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-5">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="payment_type" type="radio" id="inlineCheckbox16" value="full" required="required">
                                    <label class="form-check-label" for="inlineCheckbox16">Lump Sum Payment (100%)</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_type" id="inlineCheckbox17" value="partial" required="required">
                                    <label class="form-check-label" for="inlineCheckbox17">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
    
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fiancial Year  <span class="required">*</span> </label>
                                    <select name="year" class="form-control" id="year">
                                        <option>--choose</option>
                                        @foreach($years as $item)
                                        <option value="{{$item->FinancialYear}}">{{$item->FinancialYear}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fiancial Month  <span class="required">*</span> </label>
                                    <select name="month" id="month" class="form-control month">
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Dated: <span class="required">*</span> </label>
                                    <input id="date" type="date"  name="date" required="required" class="form-control" placeholder=""  />
                                </div>
                            </div>

                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Payment Type <span class="required">*</span> </label>
                                    <select name="payment_method" class="form-control">
                                        <option>--choose</option>
                                        <option value="1">Online</option>
                                        <option value="2">Cash</option>
                                        <option  value="3">Cherque</option>
                                        <option value="4">Pay order</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Down Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" type="number" name="down_payment" required="required" class="form-control" placeholder="Enter Amount"  />
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">DD/Pay Order # <span class="required"></span> </label>
                                    <input  maxlength="100" type="text" name="pay_order" class="form-control" placeholder="Enter Applicant Name"  />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Cheque # <span class="required"></span> </label>
                                    <input  maxlength="100" type="text" name="cheque"  class="form-control" placeholder="Enter Applicant Name"  />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Cash Receipt #: <span class="required">*</span> </label>
                                    <input maxlength="100" type="text" name="receipt" required="required" class="form-control" placeholder="Enter Name" />
                                </div>
                            </div>
                
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Bank : <span class="required">*</span> </label>
                                    <select name="bank" class="form-control">
                                        <option>--choose</option>
                                        @foreach($bank as $item)
                                        <option value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
    
    
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Tunure : <span class="required">*</span> </label>
                                    <select name="tunure" class="form-control">
                                        <option>--choose</option>
                                        @foreach($tunure as $item)
                                        <option value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                    </div>
            </div>



            {{-- nominees --}}

            <div class="row">
                <div class="col-md-12">
                   
                    <table style="display: inline-table !important;" class="table table-striped" id="dynamicTable" style="2px solid black">  
                        <tr style="background-color:black;color:white">
                            <th>Name of Nominee</th>
                            <th>Father/Husband Name</th>
                            <th>Relationship </th>
                            <th>CNIC #</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td><input type="text" id="freeSpace" name="addmore[0][name]" required placeholder="Enter Name..." class="form-control text-field pName" /></td>
                            <td><input type="text" id="freeSpace" name="addmore[0][so]" required placeholder="Enter s/o" class="form-control text-field pDesignation" /></td>
                            <td><input type="text" id="freeSpace" name="addmore[0][relation]" required placeholder="Enter relation" class="form-control text-field pMobile" /></td>  
                            <td><input type="number" id="freeSpace" name="addmore[0][cnic]" required placeholder="Enter cnic" class="form-control text-field pEmail" /></td>  
                            <td><input type="number" id="freeSpace" name="addmore[0][phone]" required placeholder="Enter Phone no 1" class="form-control text-field pPhone" /></td>  
                           
                            <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                        </tr>  
                    </table>                        
                </div>
               
            </div>

            {{-- documenmts --}}

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Transferer Docs</th>
                              </tr>
                          <tr>
                            <th>Title</th>
                            <th>File</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($doc as $item)
                            <tr>
                                <td>{{$item->title}}</td>
                                 <td><input type="file"  class="form-control" name="file[]"  {{$item->is_required}}></td>
                                <input type="hidden"  class="form-control" name="file_id[]" value="{{$item->id}}" >
                                <input type="hidden"  class="form-control" name="formID[]" value="{{$item->form_id}}" >
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Transferee Docs</th>
                              </tr>
                          <tr>
                            <th>Title</th>
                            <th>File</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($doc as $item)
                            
                            @if(in_array($item->id,[47,48,52,53,54,55,56]))
                            @continue
                            @else
                            <tr>
                                <td>{{$item->title}}</td>
                                 <td><input type="file"  class="form-control" name="file_to[]"  {{$item->is_required}}></td>
                                <input type="hidden"  class="form-control" name="file_id_to[]" value="{{$item->id}}" >
                                <input type="hidden"  class="form-control" name="formID_to[]" value="{{$item->form_id}}" >
                              </tr>
                            @endif

                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>

            <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" >Submit</button>
       
      
        </form>
        </div>
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

                $('#year').change(function(){
                   var year = $(this).val();
           
                    $.ajax({
                        url: "/admin/transfer/plot/searchyear",
                        data: {
                            "yearID": year ,
                            },
                        dataType:"json",
                        type: "get",
                        success: function(data){
                        console.log(data[0].GLFinancialYearDetailId);
                        $('.month').html("");
                        var i;
                            $('.month').append("<option value=''> -- Choose</option>");
                           for( i = 0 ; i < data.length ; i++){
                                $('.month').append("<option value="+data[i].Description+">"+data[i].Description+"</option>");
                                }
                        }
                    });
                });


                $('#month').change(function(){
                    var selected_date = $(this).val();
                    var month  = $('.month').val().split(',')[0];
                    var year  = $('.month').val().split(',')[1];
                    var newMonth = new Date(Date.parse(month +" 1")).getMonth()+1 ; 
                    
                    if(newMonth == 10 || newMonth == 12){
                        $('#date').attr('min', year+'-'+newMonth+'-01');
                        $('#date').attr('max', year+'-'+newMonth+'-31');
                    }else if(newMonth == 11){
                        $('#date').attr('min', year+'-'+newMonth+'-01');
                        $('#date').attr('max', year+'-'+newMonth+'-30');
                    }else if(newMonth == 2){
                        $('#date').attr('min', year+'-0'+newMonth+'-01');
                        $('#date').attr('max', year+'-0'+newMonth+'-28');
                    }else if(newMonth == 4 || newMonth == 6 || newMonth == 9){
                        $('#date').attr('min', year+'-0'+newMonth+'-01');
                        $('#date').attr('max', year+'-0'+newMonth+'-30');
                    }else{
                        $('#date').attr('min', year+'-0'+newMonth+'-01');
                        $('#date').attr('max', year+'-0'+newMonth+'-31');
                    }
                   
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
                var fee = $('#transfer_fee').val();
                
                $.ajax({
                    url: "/admin/transfer/plot/search",
                    data: {
                         "plot": plot ,
                         "fee": fee ,
                         },
                    dataType:"json",
                    type: "get",
                            success: function(data){
                                // console.log(data);
                              if(data.length <= 0){
                                  alert('Installment plan not found against this booking!');
                                  location.reload();
                              }
                            
                            
                            $('#booking_id').val(data.booking_id);
                            $('#transfer_fee_new').val(data.fees);

                            $('#downpayment').text(data.downpayment + " Rs");
                            $('#totalInstallments').text(data.totalInstallments);
                            $('#totalPaidInstallments').text(data.totalPaidInstallments);
                            $('#remainingAmount').text(data.remainingAmount);
                            $('#totalAmount').val(data.remainingAmount + data.fees);
                            

                            $('#downpayment2').val(data.downpayment);
                            $('#totalInstallments2').val(data.totalInstallments);
                            $('#totalPaidInstallments2').val(data.totalPaidInstallments);
                            $('#remainingAmount2').val(data.remainingAmount);

                            

                            $('#plot_type').text(data.plot_status);
                            $('#c_so').text(data.son_of);
                            $('#c_phone').text(data.phone);
                            $('#c_email').text(data.email);
                            $('#c_cnic').text(data.cnic);
                            $('#plot_project').text(data.project);
                            $('#plot_size').text(data.size);
                            $('#plot_price').text(data.numprice + " Rs ");
                            $('#plot_price_input').val(data.price);
                            $('#plot_block').text(data.block);
                            $('#customer').html();
                            $('#customer').html(data.html);
                            $('#plot_feature').html('');

                            var i;

                            for( i = 0 ; i < data.feature.length ; i++){
                                $('#plot_feature').append("<label class='badge badge-info' > "+data.feature[i]+" </label> ");
                                }
                            }
                       });
                 });




                            // for contact person
                var t = $('#dynamicTable tr').length - 1 ;
                var i = $('#dynamicTable tr').length - 2;
             
                
                $("#add").click(function(){
                    ++i;
                    ++t;
                    $("#dynamicTable").append('<tr><td><input type="text" id="freeSpace" name="addmore['+i+'][name]" placeholder="Enter Name..." class="form-control text-field pName" /></td><td><input type="text" id="freeSpace" name="addmore['+i+'][so]" placeholder="Enter S/O" class="form-control text-field pDesignation" /></td><td><input type="text" id="relation" name="addmore['+i+'][relation]" placeholder="Enter relation" class="form-control text-field pMobile"/></td><td><input type="number" id="freeSpace" name="addmore['+i+'][cnic]" required placeholder="Enter cnic '+t+'" class="form-control text-field pPhone" /></td><td><input type="number" id="freeSpace" name="addmore['+i+'][phone]" placeholder="Enter Phone" class="form-control text-field pEmail" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
                });
                $(document).on('click', '.remove-tr', function(){  
                    $(this).parents('tr').remove();
                });

            });
         
           
        </script>
   
    
@stop