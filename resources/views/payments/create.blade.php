@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
<?php

use Carbon\CarbonPeriod;
?>
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/merge/record" class="btn btn-success btn-add-new">
               <span>All Payments History</span>
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
    .mt-3{
        margin-top: 30px;
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
            <h3 class = "panel-title">Create Payments</h3>
        </div>
        
        <div class = "panel-body" style="padding: 30px;">
        <form action = "{{route('payment.store')}}" method ="post" enctype = "multipart/form-data">
        @csrf
        <div class="row" style="padding: 20px; background: #212f37; ">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" style="color:white;" >Bookings <span class="required">*</span> </label>
                        <select class="form-control select2 " id="booking_id" name="booking_id"  tabindex="-1" aria-hidden="true">
                            <option>--choose</option>
                            @foreach($booking as $item)
                            <option value="{{$item->id}}">{{$item->customers->sal_customer_name}} ({{$item->ref_num}})</option>
                            @endforeach
                           
                        </select>
                        
                    </div>
                </div>
<!-- 
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" style="color:white;">Transfers <span class="required">*</span> </label>
                        <select class="form-control select2 " id="transfer_id" name="transfer_id"  tabindex="-1" aria-hidden="true">
                            <option>--choose</option>
                            @foreach($transfer as $item)
                            <option value="{{$item->id}}">{{$item->customerTo->sal_customer_name}} ({{$item->ref_num}})</option>
                            @endforeach
                           
                        </select>
                        
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline payment-checkbox">
                        <label class="form-check-label" style="color:white;" for="inlineCheckbox16">LSP (100%)</label>
                    <input class="form-check-input payment-checkbox" name="payment_type" type="radio" id="inlineCheckbox16" value="full" required="required">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-check form-check-inline payment-checkbox">
                        <label class="form-check-label" style="color:white;" for="inlineCheckbox17">Other: </label>
                        <input class="form-check-input" checked type="radio" name="payment_type" id="inlineCheckbox17" value="partial" required="required">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-check form-check-inline payment-checkbox">
                        <label class="form-check-label" style="color:white;" for="inlineCheckbox17">Possession Charges: </label>
                        <input class="form-check-input" type="checkbox" name="possession_charges" id="possession-charges" value="{{setting('admin.possession_charges')}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-check-inline payment-checkbox">
                        <label class="form-check-label" style="color:white;" for="inlineCheckbox17">Development Charges:</label>
                        <input class="form-check-input" type="checkbox" name="development_charges" id="development-charges" value="{{setting('admin.possession_charges')}}">
                    </div>
                </div> -->
        </div>
        <div class="row" style="padding: 20px; background: #e9edeb; border:4px solid #212f37;">

            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label"> Office Amount <span class="required">*</span> </label>
                     <input type="text" class="form-control" id="plot_amount" name="plot_amount" placeholder="Office amount">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label"> Deal Amount <span class="required">*</span> </label>
                     <input type="text" class="form-control" id="deal_amount" name="deal_amount" placeholder="Deal amount">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label"> Discount Amount <span class="required">*</span> </label>
                     <input type="text" class="form-control" id="discount_amount" name="discount_amount" placeholder="Discount amount">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Token <span class="required">*</span> </label>
                    <input   type="number" id="token_payment" name="token_payment" required="required" class="form-control" placeholder="Enter Amount"  />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Token Date <span class="required">*</span> </label>
                    <input   type="text" id="token_payment_date" class="form-control" readonly />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group" data-toggle="tooltip" data-placement="top"  title="Token Amount Is Included In Down Paymnet !">
                    <label class="control-label">DownPayment <span class="required" >*?</span> </label>
                    <input   type="number" id="down_payment" name="down_payment" required="required" class="form-control" placeholder="Enter Amount"  />
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Remaining <span class="required">*</span> </label>
                    <input  id="remaining_amount" readonly type="number" name="remaining_amount" required="required" class="form-control" placeholder="Remaining amount"  />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Installments Period <span class="required">*</span> </label>
                    <select class="form-control periodType" id="installment_period" name="installment_period" >
                        <option>--choose</option>
                        @foreach($instalmentPeriod as $period)
                            <option value="{{$period->months}}">{{$period->name}} ({{$period->months}} Months)</option>
                        @endforeach
                       
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Installments Type <span class="required">*</span> </label>
                    <select class="form-control installmentType" onChange="getPerMonth()" id="instalment_type" name="instalment_type" >
                        <option>--choose</option>
                        @foreach($instalmentType as $type)
                            <option value="{{$type->value}}" balloon="{{$type->balloon_payment}}">{{$type->name}}</option>
                        @endforeach
                       
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Per Month: <span class="required">*</span> </label>
                    <input  type="number" name="per_month" required="required" class="form-control per-anum" placeholder=""  />
                </div>
            </div>

             
            <div class="col-md-2" style="display:none;">
                <div class="form-group">
                    <label class="control-label">Fiancial Month  <span class="required">*</span> </label>
                    <!-- <select name="month" id="month" class="form-control month">
                        @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)
                            <option value="{{ $date->format('F,Y') }}">
                                {{ $date->format('F,Y ') }}
                            </option>
                        @endforeach
                    </select> -->
                    <select name="month" id="month" class="form-control month" >
                        <option value="January,2022">January,2022</option>
                    </select>
                    <!-- <select name="month" id="month" class="form-control month">
                        
                    </select> -->
                </div>
            </div>
            <div class="col-md-2" style="display:none;">
                <div class="form-group">
                    <label class="control-label">Fiancial Year  <span class="required">*</span> </label>
                    <!-- <input type="date" name="year" class="form-control" id="year"> -->
                    <!-- <select name="year" class="form-control" id="dropdownYear" style="width: 120px;" >
                    </select> -->
                    <!-- <select name="year" class="form-control" id="year">
                        <option>--choose</option>
                        @foreach($years as $item)
                        <option value="{{$item->FinancialYear}}">{{$item->FinancialYear}}</option>
                        @endforeach
                    </select> -->
                    <select name="year" class="form-control" id="year">
                        <option value="2021-2022">2021-2022</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Dated: <span class="required">*</span> </label>
                    <input id="date"  type="date" name="installment_date" required="required" class="form-control installment_date" placeholder=""  />
                </div>
            </div>
            <!-- <div class="col-md-2">
                <div class="form-group balloon_payment" style="display:none">
                    <label class="control-label">Balloon Payment: <span class="required">*</span> </label>
                    <input  type="number" name="balloon_payment" class="form-control" id="balloon_payment" placeholder="i.e 5000"/>
                </div>
            </div> -->

         
            <a href="#0" style="margin-top: 25px;background:#072f36;" class="btn btn-success btn-lg pull-right" onclick="getPreview()">
              Get Preview  <span class="icon voyager-eye"></span>
            </a>
           
        </div>
        <div class="row installmentPreview">
            <table class="table table-striped table-bordered table-condensed ">
                <thead>
                    <tr style="background: #ed1b24;color: #ffffff;">
                        <th>Payment No.</th>
                        <th>Payment Date</th>
                        <th>Beginning Balance (PKR)</th>
                        <th>Scheduled Payment (PKR)</th>
                        <th>Remaining Balance (PKR)</th>
                    </tr>
                </thead>
                <tbody class="dataPreview">
                        
                        
                </tbody>
            </table>
        </div>
       

      
            <button class="btn btn-primary nextBtn btn-lg pull-right enableBtn" style="display: none;" type="submit" >Post</button>

      
        </form>
        </div>
    </div>
     
   
      
    

@stop
@section('javascript')
<script>
        $(document).ready(function () {
        $('#dropdownYear').each(function() {

                var year = (new Date()).getFullYear();
                var current = year;
                year -= 3;
                for (var i = 0; i < 6; i++) {
                if ((year+i) == current)
                    $(this).append('<option selected value="' + (year + i) + '">' + (year + i) + '</option>');
                else
                    $(this).append('<option value="' + (year + i) + '">' + (year + i) + '</option>');
                }

                });
            });
    </script>
    
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
            $(document).ready(function() {

                $('#booking_id').change(function(){
                   var booking_id = $(this).val();
                 
                    $.ajax({
                        url: "/admin/payments/search",
                        data: {
                            "BookingID": booking_id ,
                            },
                        dataType:"json",
                        type: "get",
                        success: function(data){
                            console.log(data);
                        $("#plot_amount").val(data.amount);
                        $("#down_payment").val(parseInt(data.down_payment)+parseInt(data.token));
                        $("#token_payment").val(data.token);
                        $("#token_payment_date").val(data.token_date);
                        var remaining_amount =  (data.amount - data.down_payment - data.token - data.discount);
                        $('#remaining_amount').val(remaining_amount);
                        $('#discount_amount').val(data.discount);
                        $('#deal_amount').val(data.deal_amount);
                        $("#down_payment").attr('max',data.amount);
                        $("#token_payment").attr('max',data.token);


                        }
                    });
                });

                $('#month').change(function() {
                    debugger
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

                $('#transfer_id').change(function(){
                   var transfer_id = $(this).val();
                 
                    $.ajax({
                        url: "/admin/payments/transferSearch",
                        data: {
                            "transferID": transfer_id ,
                            },
                        dataType:"json",
                        type: "get",
                        success: function(data){
                            console.log(data);
                        $("#plot_amount").val(data.amount);
                        $("#down_payment").val(parseInt(data.down_payment)+parseInt(data.token));
                        $("#token_payment").val(data.token);
                        var remaining_amount =  (data.amount - data.down_payment - data.token);
                        $('#remaining_amount').val(remaining_amount);

                        $("#down_payment").attr('max',data.amount);
                        $("#token_payment").attr('max',data.token);


                        }
                    });
                });

               



                $('#down_payment').keyup(function(){
                    var down_payment = $(this).val();
                    var plot_amount = $("#plot_amount").val();
                    var remaining = plot_amount - down_payment ;

                    $("#remaining_amount").val(remaining);

                });

                $('#num_of_installments').keyup(function(){
                    var num_of_installments = $(this).val();
                    var remaining_amount = $("#remaining_amount").val();
                    var installment_amount = remaining_amount / num_of_installments ;

                    $("#installment_amount").val(installment_amount);

                });

      
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
  
            // getting preview of installments
            function getPreview(){
                //Enable loading preview
               $('#voyager-loader').css('display', 'block');
               $('#voyager-loader').css('background', '#a1cdf0');
               $('#voyager-loader').css('opacity', '0.4');
               let balloonPayment = $('#balloon_payment').val();
               var plot_amount =  $('#deal_amount').val();
               var down_payment =  $('#down_payment').val();
               var remaining_amount =  $('#remaining_amount').val();
               var periodType =  $('.periodType').val();
               var installment_date =  $('.installment_date').val();
               var per_month = $('.per-anum').val();
               var instalment_type = $('.installmentType').val();
               
               
                $.ajax({
                    url: "/admin/payments/getInstallmentPreview",
                    data: {
                        "plot_amount": plot_amount ,
                        "down_payment": down_payment ,
                        "remaining_amount": remaining_amount ,
                        "periodType": periodType ,
                        "installment_Type": instalment_type ,
                        "installment_date": installment_date ,
                        "per_month":per_month,
                        "balloon_payment":balloonPayment

                    },
                    type: "get",
                    success: function(data){
                      console.log(data);
                    //   Disable Loading
                        $('#voyager-loader').css('display', 'none');

                        $('.dataPreview').html('');
                        $('.enableBtn').css('display', 'block');

                        // console.log(data.ScheduledPayment);
                        for(var i = 0; i < data.ScheduledPayment.length;i++){
                            
                            if(i ==0){
                                 $('.dataPreview').append('<tr><td>'+(i+1)+' <span class="badge badge-pill badge-info">Down Payment</span></td><td><input type="text" value="'+data.paymentDate[i]+'" id="date" name="paymentDate[]" readonly style=" border: 1px solid white; "></td><td>'+data.begningBalance[i]+'</td><td>'+data.ScheduledPayment[i]+'</td><td>'+data.remainingBalance[i]+'</td></tr>');
                            }else{
                                $('.dataPreview').append('<tr><td>'+(i+1)+' </td><td><input type="text" value="'+data.paymentDate[i]+'" id="date" name="paymentDate[]" readonly style=" border: 1px solid white; "></td><td>'+data.begningBalance[i]+'</td><td>'+data.ScheduledPayment[i]+'</td><td>'+data.remainingBalance[i]+'</td></tr>');

                            }
                        }
                           
                        

                    }
                });

               
            }

            function getPerMonth(){
                let remaining_amount =  $('#remaining_amount').val();
                let installentPeriod =  $('.periodType').val();
                let perAnum = parseFloat(remaining_amount/installentPeriod).toFixed(2);
                let instalmentType =  $('#instalment_type').val();
                let updatedPerAnum = perAnum*instalmentType.charAt(0);
                var balloon = $('#instalment_type option:selected').attr("balloon");
                $('.per-anum').val(updatedPerAnum);
                if(balloon == 1) {
                    $('.balloon_payment').show();
                } else {
                    $('.balloon_payment').hide();
                }
                
            }

            function upadateAmount(remainingAmount , isPlus) {
                let curentRemaining = $('#remaining_amount').val();
                if (isPlus) {
                    $('#remaining_amount').val(parseFloat(curentRemaining) + parseFloat(remainingAmount));
                } else {
                    $('#remaining_amount').val(parseFloat(curentRemaining) - parseFloat(remainingAmount));
                }
            }
            
            $('#possession-charges').click(function() {
                if($('#booking_id').val() == '--choose') {
                    alert('First choose the booking option');
                    $(this).prop("checked", false);
                } else {
                    if ($(this).prop("checked") == true) {
                        upadateAmount(this.value, true);
                    } else if ($(this).prop("checked") == false) {
                        upadateAmount(this.value, false);
                    }
                }
            });

            $('#development-charges').click(function() {
                if($('#booking_id').val() == '--choose') {
                    alert('First choose the booking option');
                    $(this).prop("checked", false);
                } else {
                    if ($(this).prop("checked") == true) {
                        upadateAmount(this.value, true);
                    } else if ($(this).prop("checked") == false) {
                        upadateAmount(this.value, false);
                    }
                }
            });
        </script>
   
    
@stop