@extends('voyager::master') @section('page_header')

<style>
@page {
	margin: 0;
	size: Legal;
	/*or width x height 150mm 50mm*/
}
@media only screen and (max-width: 480px){
    tbody.result-call tr td {
        width: 100%;
        display: block;
    }
}

@media only screen and (max-width: 480px){
    tbody.result-cal tr td {
        display: block;
        width: 100%;
    }
}

.result-cal tr td {
    border: #eee 1px solid;
    margin-bottom: 20px;
    border-bottom: 5px solid #009639;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 1px 1px 17px #ccc;
    text-align: center;
}

.result-call tr td {
    border: #eee 1px solid;
    margin-bottom: 20px;
    border-bottom: 5px solid #e54e4e;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 1px 1px 17px #ccc;
    text-align: center;
}
.close:hover{
    background:red !important;
}




</style>
 @stop @section('content')
<div class="page-content  browse container-fluid"> 
    <div class="container" style="margin-top:20px">
        <div class="row" style="margin-top:20px; margin-bottom:30px; display:block;">
            <!-- <div class="span5" style=" margin-top: 40px;">
               
                <table width="100%">
                    <tbody class="result-cal">
                        <tr>
                            
                            <td width="20%">
                                <h3>{{$data->Location}}</h3> Office
                                <br>
                                <br> 
                            </td>
                                <td width="20%">
                                <h3>{{$data->customers->name}}</h3> Booking Form No
                                <br>
                                <br> </td>
                            <td width="20%">
                                <h3>{{$data->PlotSize}} </h3> Office Size
                                <br>
                                <br> </td>
                            <td width="20%">
                                <h3 style="text-transform: capitalize;">{{@$status->status}}</h3> Type
                                
                                <br>
                                <br> </td>
                           
                        </tr>
                        <tr>
                            <td width="20%">
                                <h3>{{$data->propertyprice}}</h3> Booking Amount
                                <br>
                                <br> </td>
                            
                            <td width="20%">
                                <h3>{{$data->downpayment}}</h3> Down Payment
                                <br>
                                <br> </td>
                            <td width="20%">
                                <h3>12</h3> Payments/Years
                                <br>
                                <br> </td>
                            <td width="20%">
                                <h3>{{explode(" ",$data->details[0]->month)[0]}}</h3> Start Date
                                <br>
                                <br> </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
            <div class="span5" style=" margin-top: 40px;">
                <h2 style="margin: 0px 0px 10px 0px;">
                        Installment Summary
                    </h2>
                <table width="100%">
                    <tbody class="result-call">
                        <tr>
                            <td width="25%">
                                <h3 class="perMonth">{{$data->details[0]->MonthlyInstallment}}</h3> Scheduled Payment
                                <br>
                                <br> </td>
                            <td width="25%">
                                <h3>{{count($data->details)}}</h3> Payments (Scheduled)
                                <br>
                                <br> </td>
                            <td width="25%">
                                <h3>0</h3> Payments (Actual)
                                <br>
                                <br> </td>
                                <td width="25%">
                                    <h3>0</h3> Remaining Amount)
                                    <br>
                                    <br> </td>

                            <td width="25%" style=" padding: 15px; ">
                                    <h3 style="font-size: 15px;">Add Payment</h3> 
                                    <a href="javascript:void(0);" class="mb-2" data-toggle="modal" data-target="#myModal"><span class="badge badge-pill badge-primary" style=" width: 181px; padding: 10px; ">+ Receive Amount</span></a>
                                    <br>
                                    <br> </td> 
                        
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- <div>
               
                @if($data->development_charges != '' && $data->possession_charges != '')
                <marquee behavior="scroll" direction="left" scrollamount="5">
                <p style="color:#009639; font-size: larger; font-weight: bold;"> Poession Charges already paid </p> <p style="color:#009639; font-size: larger; font-weight: bold;"> Development Charges already paid </p>
            </marquee>
                @elseif($data->development_charges == '' && $data->possession_charges == '')
                <p style="color:#ed1b24; font-size: larger; font-weight: bold;">Poession Charges did not paid</p>
                <p style="color:#ed1b24; font-size: larger; font-weight: bold;">Development Charges did not paid</p>
                @elseif($data->development_charges == '' || $data->possession_charges != '')
                <p style="color:#009639; font-size: larger; font-weight: bold;">Poession Charges already paid</p>
                <p style="color:#ed1b24; font-size: larger; font-weight: bold;">Development Charges did not be paid</p>
                @elseif($data->development_charges != '' || $data->possession_charges == '')
                <p style="color:#ed1b24; font-size: larger; font-weight: bold;">Poession Charges not be  paid</p>
                <p style="color:#009639; font-size: larger; font-weight: bold;">Development Charges be paid</p>
                
                @endif


            </div>

            <div class="span5">
                <script type="text/javascript" src="/charts/fusioncharts.combined.js"></script>
            </div> -->
        </div>
        <button  class="btn btn-primary" onClick="printReport()"> Print </button>
        <div class="row" style="margin-top:30px" id="reportPrinting">
            <div class="row">
                <div class="col-md-6">
                <h2 style="margin: 0px 0px 10px 0px;">Property Details</h2>
                    <table class="table table-responsive" style="width:50%">
                        <tr>
                            <th>Office No</th>
                            <th>{{$data->Location}}</th>
                        </tr>
                        <tr>
                            <th>Booking Form No</th>
                            <th>{{$data->FormNo}}</th>
                        </tr>
                        <tr>
                        <th>Floor</th>
                        <th>{{$status->block->name}}</th>
                        </tr>
                        <tr>
                        <th>Area sqft</th>
                        <th>{{$data->PlotSize}} sqft</th>
                        </tr>
                        <tr>
                        <th>Rate / sqft</th>
                        <th>
                            @php 
                                $rate = $data->TotalAgreedPrice / $data->PlotSize;
                                $office_rate = round($rate);
                            @endphp
                            {{$office_rate}} PKR per sqft
                        </th>
                        </tr>
                        <tr>
                            <th>Total Amount</th>
                            <th>{{$data->TotalAgreedPrice}}</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                <h2 style="margin: 0px 0px 10px 0px;">Member Details</h2>
                    <table class="table table-responsive" style="width:50%">
                        <tr>
                            <th>Owner Name</th>
                            <th>{{$data->customers->name}}</th>
                        </tr>
                        <tr>
                            <th>S/O W/O</th>
                            <th>N/A</th>
                        </tr>
                        <tr>
                        <th>CNIC No</th>
                        <th>N/A</th>
                        </tr>
                        
                        <tr>
                        <th>Contact No</th>
                        <th>
                            
                            {{$data->customers->phone}}
                        </th>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="tabPlaceholder table-responsive" id="scheduleTab">
                <table class="table table-striped table-bordered table-condensed ">
                    <thead>
                        <tr style="background: #ed1b24;color: #ffffff;">
                            <th>Reference No</th>
                            <th>Installments</th>
                            <th>Due Date</th>
                            <th>Paid Date</th>
                            <th>Due Amount</th>
                            <th>Payment Mode</th>
                            <!-- <th>Balloon Payment (PKR)</th> -->
                            <th>Beginning Balance (PKR)</th>
                            <th>Scheduled Payment (PKR)</th>
                            <th>Paid Amount (PKR)</th>

                            <th>Remaining Balance (PKR)</th>
                            <th>Status</th>
                        </tr>
                    </thead>


                    <tbody class="dataPreview">
                        <tr class="downPaymentRow">
                            <td>1 <span class="badge badge-pill badge-info">Down Payment</span></td>
                            @php
                                    $old_date = date($data->DateOfBooking);
                                    $old_date_timestamp = strtotime($old_date);
                                    $new_date = date('F-Y ', $old_date_timestamp);
                            @endphp
                            <td>{{ $new_date}}</td>
                            <td>{{explode(' ',$data->DateOfBooking)[0]}}</td>

                           <td>
                                @if($data3->paidDate)
                                    {{$data3->paidDate}}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>N/A</td>
                            <td>
                                Down Payment
                              </td>

                            <td>{{$data->PlotPriceRegular}}</td>
                            <td>{{$data->downpayment}}</td>
                            <td>{{$data->downpayment}}</td>
                            <td>
                                {{$data->PlotPriceRegular - $data->downpayment +$data->possession_charges + $data->development_charges}} 
                            </td>
                            <td><a  href="{{ URL::to('/admin/payments/createPF') }}/{{$data->InstallmentId}}"><span class="badge badge-pill badge-success">Paid</span></a></td>
                        </tr>
                        @foreach ($data->details as $key => $item)
                        @if($data->details[$key]->AmountReceived != $data->details[$key]->MonthlyInstallment)
                        @if($data->details[$key]->AmountReceived != 0)
                        <tr class="installmentRow partialRow">
                        @else  
                        <tr class="installmentRow">
                        @endif
                            <td><input type="hidden" name="id[]" value="{{$data->details[$key]->InsatllmentDetailsid}}">{{$data->details[$key]->InsatllmentDetailsid}}</td>
                            @php
                                    $old_date = date($data->details[$key]->month);
                                    $old_date_timestamp = strtotime($old_date);
                                    $new_date = date('F Y ', $old_date_timestamp);
                            @endphp
                            <td>{{$new_date}}</td>
                            <td>{{explode(" " , $data->details[$key]->month)[0]}}</td>
                            <td>
                                @if($data->details[$key]->paidDate!='')
                                    {{@$data->details[$key]->paidDate}}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                               
                                    {{$data->details[$key]->MonthlyInstallment - $data->details[$key]->balloon_payment}}
                               
                            </td>
                            <td>
                                @if($data->details[$key]->Payment_Type)
                                    {{$data->details[$key]->Payment_Type}}
                                @else
                                    N/A
                                @endif
                              </td>
                            <!-- <td>{{$data->details[$key]->balloon_payment}}</td> -->

                            <td>{{($data->details[$key]->outstandingbalance +  $data->details[$key]->MonthlyInstallment)}}</td>
                            <td>{{$data->details[$key]->MonthlyInstallment}}</td>
                            @php 
                                $blc = $data->details[$key]->MonthlyInstallment - $data->details[$key]->AmountReceived;
                            @endphp
                            <td style="width:15%;">{{$data->details[$key]->MonthlyInstallment}} - {{$data->details[$key]->AmountReceived}} = <span class="badge badge-pill badge-primary">{{$blc}}</span></td>
                            <td>
                                
                             
                                {{ $data->details[$key]->outstandingbalance }}
                       
 
                              
                            </td>
                            <td>
                                @if($data->details[$key]->AmountReceived > 0)
                                <span class="badge badge-pill badge-success">Partial Paid</span></td>
                                @else
                                    <span class="badge badge-pill badge-success">UnPaid</span>
                                @endif
                                
                            
                            </td>
                           
                        </tr>

                    {{-- RECEIPT OF REMAINING AMOUNT SLIP TESTING --}}


            





                        
                        @else 
                        <tr class="paidRow">
                            <td><input type="hidden" name="id[]" value="{{$data->details[$key]->InsatllmentDetailsid}}">{{$data->details[$key]->InsatllmentDetailsid}}</td>
                            @php
                                    $old_date = date($data->details[$key]->month);
                                    $old_date_timestamp = strtotime($old_date);
                                    $new_date = date('F Y ', $old_date_timestamp);
                            @endphp
                            <td>{{$new_date}}</td>
                            <td>{{explode(" " , $data->details[$key]->month)[0]}}</td>
                            <td>
                                @if($data->details[$key]->paidDate)
                                {{$data->details[$key]->paidDate}}
                                @else
                                N/A 
                                @endif
                            <!-- <td></td> -->
                            <td>N/A</td>
                            <td>
                                @if($data->details[$key]->Payment_Type)
                                    {{$data->details[$key]->Payment_Type}}
                                @else
                                    N/A
                                @endif
                              </td>
                            <td>{{($data->details[$key]->outstandingbalance +  $data->details[$key]->MonthlyInstallment)}}</td>
                            
                            <td>{{$data->details[$key]->MonthlyInstallment}}</td>
                            <td><span class="badge badge-pill badge-success">{{$data->details[$key]->AmountReceived}}</span></td>
                            
                            <td>
                             

                               {{$data->details[$key]->outstandingbalance  }} 

                            </td>
                            <td>

                                @if($data->details[$key]->AmountReceived > 0)
                                <span class="badge badge-pill badge-success">Paid</span>
                                @endif
                                
                            
                            </td>
                        </tr>

                        @endif
                            
                        @endforeach
                 
                       
                    </tbody>
                    
                </table>
               
            </div>
           
        </div>
       
    </div>

</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content" style="border-style: groove;border-width: 4px;width: fit-content;">
        <div class="modal-header" style="background: linear-gradient( 272deg , #093b43 0%, #2c8e9b 154%) !important; color: white;">
          <button type="button" class="close" style="background: red;padding-left:12px; padding-right: 12px; padding-top: 5px; color: white; padding-bottom: 5px;" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Enter Receiving Information</h4>
        </div>
        <div class="modal-body">
            <form method="post" action="/admin/payments/store/receiveAmount">
                        @csrf
                        <input type="hidden" class="R_amount" name="received_amount"> 
                        <input type="hidden" name="installment_id" value="{{Request::segment(4)}}"> 
                <div class="row">
                    <div class="col-md-3">
                    <label><input type="checkbox" class="my_features" data-name="surcharge">  Due Surcharge Amount</label>
                    </div>
                    <div class="col-md-4" id ="surcharge" style ="display:none;">
                        <input type="number" placeholder="Enter Due Surcharge Amount" class="form-control" name="due_sur_charge_amount" id="">
                    </div>
                </div>
                <div class="row" style="padding:8px;">
                    <!-- <div class="col-md-2" style="margin-right: -100px;" ></div> -->
                    
                    
                    
                    
                    
                        <div class="col-md-3 " >

                        <label>Select Payment</label> 
                            <select onchange ="getValue()" class="form-control"  id="Payment_For" name="Payment_For">
                                <option value="" amount = ''>choose</option>
                                
                                <option value="installment" amount = ''>Installment</option>
                                

                                @if($data->possession_charges != '')
                                @else 
                                <option value="poession" amount = "{{setting('admin.possession_charges')}}">Poession Charges </option>
                                @endif

                                @if($data->development_charges != '')
                                @else
                                <option value= "development" amount = "{{setting('admin.possession_charges')}}">Development Charges</option>
                                @endif
                            
                            </select>
    
    
                        </div>

                        <div class="col-md-3" >

                        <label>Payment Type</label> 
                            <select class="AmountTypeReceipt form-control"  name="Payment_Type">
                            <option >Amount Type</option>
                            <option value="cash">Cash</option>
                            <option value= "cheque">Cheque</option>
                            <option value="payOrder">Pay Order</option>
                            <option value="bankDraft">Bank Draft No</option>
                            </select>
    
    
                        </div>
                        <div class="col-md-4">
                            <label>Enter Amount</label> 
                        <input type="number" class="form-control received_amount"  placeholder="Received Amount e.g 200000" name="received_amount"> 
                    </div>
                    
                    <div class="col-md-2" style="margin-right: -17px;"><br>
                        
                        <button type="button" style="cursor: pointer !important;" class="btn btn-primary" onclick="getRows()" data-toggle="tooltip" data-placement="right"  title="System will check the amount & applies FIFO method on unpaid installments!">Apply ?</button>
                    </div>
                            <table class="receivedAmountRows table table-striped table-bordered table-condensed ">
                                <thead  class="headData">
                                    <tr style="background: #ed1b24;color: #ffffff;">
                                    <th>Reference No</th>
                                    <th>Installments</th>
                                    <th>Due Date</th>
                                    <th>Paid Date</th>
                                    <th>Due Amount</th>
                                    <th>Payment Mode</th>
                                    <!-- <th>Balloon Payment (PKR)</th> -->
                                    <th>Beginning Balance (PKR)</th>
                                    <th>Scheduled Payment (PKR)</th>
                                    <th>Paid Amount (PKR)</th>

                                    <th>Remaining Balance (PKR)</th>
                                    <th>Status</th>
                                    </tr>
                                </thead>
            
                                <tbody class="childRows">
                                    
                                </tbody>
                            
                            </table>
                            </div>
                            <div class="modal-footer">
                                <button  type="submit" class="btn btn-primary saveData float-right" style="display:none;">Save Details</button>

                            </div>
                    </form>
                    
      </div>
  
    </div>
</div>

@stop @section('css')
<style>
@media screen and (min-width: 480px) {
	.dt-buttons {
		position: relative Im !important;
		left: 10px !important;
	}
}
</style> @stop @section('javascript')
<!-- DataTables -->
<script src="{{ asset('dataTable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('dataTable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('dataTable/jszip.min.js') }}"></script>
<script type="text/javascript">
    function printReport()
    {
        var prtContent = document.getElementById("reportPrinting");
        var WinPrint = window.open();
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
</script>
<script>

$(function() {
  $('.my_features').on("change",function() { 
    $('#'+$(this).attr('data-name')).toggle(this.checked); // toggle instead
  }).change(); // trigger the change
});

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
$("#path").val(window.location.pathname);

function Pr() {
	$(".btn").hide();
	print();
	location.reload();
}
</script>
<script>
$(document).ready(function() {
	$('#example').DataTable({
		"scrollX": true,
		dom: 'Bfrtip',
		lengthMenu: [
			[10, 25, 50, -1],
			['10 Filas', '25 Filas', '50 Filas', 'All']
		],
		buttons: [{
			extend: 'excel',
			text: '<i class="fas fa-file-excel" aria-hidden="true"> Exportar a EXCEL</i>'
		}, 'pageLength'],
	});
});

function apporveCertificate(allotmentID, loggedUserID) {
	$.ajax({
		'url': '/admin/pac/approve/certificate',
		'method': 'POST',
		'data': {
			allotmentID: allotmentID,
			loggedUserID: loggedUserID,
			'_token': '{{csrf_token()}}'
		},
		success: function(data) {
			// console.log(data);
			toastr.success("Approved Successfully! SMS sent to CCRA");
			setTimeout(function() {
				location.reload();
			}, 3000);
		},
		error: function(data) {}
	})
}

function getValue()
{
    var amount = $('#Payment_For option:selected').attr("amount");
    // console.log(amount);
    $('.received_amount').val(amount);
   

}

    function getRows(){

        // getting data from the user
        var receivedAmount = $('.received_amount').val();
        var amountType = $('.AmountTypeReceipt').val();
        var amountFor = $('#Payment_For').val();
        if(amountFor == 'installment')
        {

        var value12 = '{{$data->InstallmentId}}';
        // console.log($('.installmentRow'));
        if(receivedAmount <= 0 ){
            // alert(value12);
            $('.received_amount').css('border-color',"red !important;");
            return false;
        }
        
        else{
           
            $('.received_amount').css('border-color',"grey !important;");
        }
        var tr =  $('.dataPreview tr.partialRow')[0];
        if(tr){
         var receivedAmount = (parseInt(receivedAmount) + parseInt($(tr).find('td')[8].innerHTML.split('=')[0].split('-')[1]));
        }else{
            var receivedAmount = (receivedAmount);
        }

        var perMonth = $('.perMonth').text();
        // alert(perMonth);
        var numberOfInstallment = Math.floor(receivedAmount / perMonth); // full payment of each record
        var variation = receivedAmount / perMonth; // applicable for partial record 
        var systemReservation = (perMonth*numberOfInstallment);//round figure;
        var installmentRows = 0;
        var isntallmentArray = [];
    

        // if received amount is divisible and output is round figure e.g 60000 is for 3 installments if per month is 20000
        if(variation == numberOfInstallment){
            var i = 0;
            for(i; i < numberOfInstallment; i++) {
          
                    if(installmentRows <= receivedAmount){
                        isntallmentArray.push($('.installmentRow')[i]);
                        installmentRows += parseInt(perMonth);
                    }
                
            }
        }else{
            var i = 0;
            for(i; i <= numberOfInstallment; i++) {
                    
                    if(installmentRows <= receivedAmount){
                        // console.log($('.installmentRow')[i]);
                        isntallmentArray.push($('.installmentRow')[i]);
                        installmentRows += parseInt(perMonth);
                    }
                
            }
        }

        
        // removing the child table rows
        $('.childRows').html('');
        
        for(let j = 0; j <= (isntallmentArray.length); j++) {
            
            $('.childRows').append(isntallmentArray[j]);

        }

        // getting child table rows length
        var rows= $('.receivedAmountRows tbody tr.installmentRow').length;
        var difference = receivedAmount - systemReservation;
        

        if(difference ==  0){
            var difference = perMonth;
            var html = ' <span class="badge badge-pill badge-success">Full</span>';
        }else{
            var html = ' <span class="badge badge-pill badge-danger">Partial</span>';
        }
        for(let j = 0; j < rows; j++) {
          
           var tr =  $('.receivedAmountRows tbody tr.installmentRow')[j];
        //    console.log($(tr).find('td')[6].innerHTML.split('=')[1]);
           var amountPayable = parseInt($(tr).find('td')[8].innerHTML.split('=')[1]);
           
            $(tr).find('td')[4].innerHTML= '<input readonly value="'+amountPayable+'" type="number" name="receivedAmount[]"> <span class="badge badge-pill badge-success">Full</span>';
           

        }
        // getting the difference if received amount is round figure or check existence of partial payment
     
        // preparing userInterface to display the rwos that the received amount is for how many installments 
        
        // if there is any partial payment then rendering partial tag at last row 
        if(difference < amountPayable ){
            console.log($('.received_amount').val() , difference , amountPayable);

            $('.receivedAmountRows tr:last').addClass('lastRow');
            var tr = $('.receivedAmountRows tr:last'); 
            if($('.received_amount').val() <= amountPayable){
                 $(tr).find('td')[4].innerHTML= '<input  value="'+$('.received_amount').val()+'" type="number" name="receivedAmount[]">' + html;
            }else{
                $(tr).find('td')[4].innerHTML= '<input  value="'+difference+'" type="number" name="receivedAmount[]">' + html;

            }
        }else{
            $('.receivedAmountRows tr:last').addClass('lastRow');
            var tr = $('.receivedAmountRows tr:last'); 
            if($('.received_amount').val() < amountPayable){
                $(tr).find('td')[4].innerHTML= '<input  value="'+$('.received_amount').val()+'" type="number" name="receivedAmount[]">' + html;
        
            }else{
             $(tr).find('td')[4].innerHTML= '<input  value="'+amountPayable+'" type="number" name="receivedAmount[]">' + html;
            }
        }
        
        $('.saveData').css('display', 'block');

    }else{
        $('.R_amount').val($('.received_amount').val());
        $('.headData').css('display' , 'none');
        $('.saveData').css('display', 'block');

    }
    
}
</script> 

@stop