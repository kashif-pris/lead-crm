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
    .childTab {
        height: 325px;
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
            <h3 class = "panel-title">Plot Report</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "{{route('transfer.store')}}" method ="post" enctype = "multipart/form-data">
        @csrf
            <div class="row">
               <div class="col-md-6">
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
                
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 50px">
                        <button type="button"  class="btn btn-info" onclick="transferHistory()"><i class="fa fa-list"></i>  Check Plot Transfer History</button>
                      
                    </div>
                </div>
               
            </div>



            <div class="row">
                <hr>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Plot Report Information </legend>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Plot Information --}}
                                <fieldset class="childTab scheduler-border">
                                    <legend class="scheduler-border">Plot Details <i class="voyager-scissors"></i></legend>
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
                                          
                                                <label class="control-label pull-right">Plot Category :  </label>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="badge badge-danger" id="plot_category"></label>
                                            </div>
                                        </div>
                                      
                                        
                                    </div>
                                </fieldset>

                        </div>
                        <div class="col-md-6">
                            {{-- Customer Account Information --}}

                            <fieldset class="childTab scheduler-border">
                                <legend class="scheduler-border">Transfer Stats <i class="voyager-scissors"></i></legend>
                                <div class="control-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label pull-right">Total Transfer(s):  </label>
                                        </div>
                                        <div class="col-md-3" >
                                           <a href="/admin/plot-report/tranfer-details"> <label class="badge badge-primery" id="totalTransfer"></label></a>
                                        </div>
                                    </div>
                                   <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label pull-right">Reserved :  </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="badge badge-warning" id="reservedPerson"></label>
                                        </div>
                                   </div>
                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label pull-right">Earned Money :  </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="badge badge-success" id="earnedMoney"></label>
                                        </div>    
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                      
                                            <label class="control-label pull-right">Possesion Date:  </label>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="badge badge-danger" id="date_of_posession"></label>
                                            <input type="hidden" value="" id="remainingAmount2" name="remainingAmount">
                                        </div>
                                    </div>
                                  
                                </div>
                                <br>
                                <br>

                            </fieldset>
                        </div>
                    
                </fieldset>

            </div>
      
            <div class=" col-sm-12 placeholder">
                <div class="panel panel-cyan">
                    <div class="panel-body"><div id="chartContainer" style="height: 370px; width: 100%;"></div></div>
                    <div class="panel-footer"></div>
                </div>
            </div>

 
     
   
      
    

@stop
@section('javascript')

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
                    url: "/admin/plot-report/transfers",
                    data: {
                         "plot": plot ,
                         },
                    dataType:"json",
                    type: "get",
                            success: function(data){
                             
                                var i;
                                
                                $('#booking_id').val(data.booking_id);

                                $('#downpayment').text(" PKR " +  data.downpayment);
                                $('#totalInstallments').text(data.totalInstallments);
                                $('#totalPaidInstallments').text(data.totalPaidInstallments);
                                $('#remainingAmount').text(data.remainingAmount);

                                $('#downpayment2').val(data.downpayment);
                                $('#totalInstallments2').val(data.totalInstallments);
                                $('#totalPaidInstallments2').val(data.totalPaidInstallments);
                                $('#remainingAmount2').val(data.remainingAmount);

                                $('#c_so').text(data.son_of);
                                $('#c_phone').text(data.phone);
                                $('#c_email').text(data.email);
                                $('#c_cnic').text(data.cnic);
                                $('#plot_project').text(data.project);
                                $('#plot_size').text(data.size);
                                $('#plot_price').text(" PKR " + data.numprice);
                                $('#plot_price_input').val(data.price);
                                $('#plot_block').text(data.block);
                                $('#customer').html();
                                $('#customer').html(data.html);
                                $('#plot_category').text(data.category);

                                $('#totalTransfer').text(data.totalTransfer);
                                $('#reservedPerson').text(data.reservedPerson);
                                $('#earnedMoney').text(" PKR " + data.totaEarnedMoney);

                                $('#plot_feature').html('');
                                
                                var dataStats = [];
                                for (var k = 0; k < data.chartAmount.length; k++) { 
                                    console.log(data.chartAmount[k].to_customer);
                                    var words = numberToWords(k+1);
                                    var item= { label: ""+words+" Transfer",  y: parseInt(data.chartAmount[k].fee)  };
                                    dataStats.push(item);
                                }
                                console.log(dataStats);
                                var chart = new CanvasJS.Chart("chartContainer", {
                                    title:{
                                        text: "Transfer History Chart"              
                                    },
                                    data: [              
                                    {
                                        // Change type to "doughnut", "line", "splineArea", etc.
                                        type: "column",
                                        dataPoints: dataStats
                                    }
                                    ]
                                });
                                chart.render();


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
         
            function numberToWords(number) {
                var digit = ['zero', 'First', 'Second', 'Third', 'Four', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth'];
                var elevenSeries = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
                var countingByTens = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
                var shortScale = ['', 'thousand', 'million', 'billion', 'trillion'];
                number = number.toString();
                number = number.replace(/[\, ]/g, '');
                if (number != parseFloat(number)) return 'not a number';
                var x = number.indexOf('.');
                if (x == -1) x = number.length;
                if (x > 15) return 'too big';
                var n = number.split('');
                var str = '';
                var sk = 0;
                for (var i = 0; i < x; i++) {
                    if ((x - i) % 3 == 2) {
                        if (n[i] == '1') {
                            str += elevenSeries[Number(n[i + 1])] + ' ';
                            i++;
                            sk = 1;
                        } else if (n[i] != 0) {
                            str += countingByTens[n[i] - 2] + ' ';
                            sk = 1;
                        }
                    } else if (n[i] != 0) {
                        str += digit[n[i]] + ' ';
                        if ((x - i) % 3 == 0) str += 'hundred ';
                        sk = 1;
                    }
                    if ((x - i) % 3 == 1) {
                        if (sk) str += shortScale[(x - i - 1) / 3] + ' ';
                        sk = 0;
                    }
                }
                if (x != number.length) {
                    var y = number.length;
                    str += 'point ';
                    for (var i = x + 1; i < y; i++) str += digit[n[i]] + ' ';
                }
                str = str.replace(/\number+/g, ' ');
                str = str.replace(/\s+/g, '-').toLowerCase();
                return "" + str.trim() + ".";
            }
        </script>
   
    
@stop