@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/tokens/record" class="btn btn-success btn-add-new">
               <span>All Tokens History</span>
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
            <h3 class = "panel-title">Create Token</h3>
        </div>
        
        <div class = "panel-body">
            @if(isset($token))
            <form action = "{{route('token.update',$token->id)}}" method ="post" enctype = "multipart/form-data">
            @else
        <form action = "{{route('token.store')}}" method ="post" enctype = "multipart/form-data">
            @endif
        @csrf
            <div class="row">

                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">File Name<span class="required">*</span> </label>
                        <select name="plot_id" class="form-control plot_id" id="plot">
                            <option>--choose</option>
                            @foreach($plots as $item)
                            <option {{@$token->plot_id == $item->id ? "selected" : ""}} value="{{$item->id}}">{{$item->office_no}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
              
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Customer Name<span class="required">*</span> </label>
                        <select name="customer_id" class="form-control" id="customer">
                            <option>--choose</option>
                            @foreach($customers as $item)
                            <option {{@$token->customer_id == $item->id ? "selected" : ""}}  value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Total Amount<span class="required">*</span> </label>
                       <input type="number" value="{{@$token->office_amount}}"    class="form-control office_amount" placeholder="Amount" name="office_amount" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Deal Amount<span class="required">*</span> </label>
                       <input type="number"   value="{{@$token->deal_amount}}"  class="form-control deal_amount" placeholder=" Deal Amount" name="deal_amount">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Discount Amount<span class="required">*</span> </label>
                       <input type="number"   value="{{@$token->discount_amount}}"  class="form-control discount_amount" placeholder="Discount_amount" name="discount_amount" readonly>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Downpayment Amount<span class="required">*</span> </label>
                       <input type="number"   value="{{@$token->downpayment}}"  class="form-control" placeholder="Downpayment" name="downpayment">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Token Amount<span class="required">*</span> </label>
                       <input type="number"   value="{{@$token->amount}}"  class="form-control" placeholder="Amount" name="amount">
                    </div>
                </div>

                <!-- <div class="col-md-3">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Deduction<span class="required">*</span> </label>
                       <input type="number"  value="{{@$token->deduction}}" class="form-control" placeholder="Deduction" name="deduction">
                    </div>
                </div> -->

                <!-- <div class="col-md-6">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Description<span class="required">*</span> </label>
                       <input type="text" value="{{@$token->notes}}"  class="form-control" placeholder="Description" name="notes">
                    </div>
                </div> -->

                <!-- <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Fiancial Year  <span class="required">*</span> </label>
                        <select name="FinancialYear" class="form-control" id="year">
                            <option>--choose</option>
                            @foreach($years as $item)
                            <option  {{@$token->FinancialYear == $item->FinancialYear ? "selected" : ""}}  value="{{$item->FinancialYear}}">{{$item->FinancialYear}}</option>
                            @endforeach
                        </select>
                    </div>
                </div> -->
                <!-- <div class="col-md-2" style="margin-top: 30px">
                    <div class="form-group">
                        <label  class="control-label">Fiancial Month  <span class="required">*</span> </label>
                        <select id="month" name="ins_Month" class="form-control month">
                            <option value="{{@$token->ins_Month}}">{{@$token->ins_Month}}</option>
                        </select>
                    </div>
                </div> -->
                <div class="col-md-2" style="margin-top: 30px">
                    <div class="form-group">
                        <label class="control-label">Date: <span class="required">*</span> </label>
                        <input id="date" value="{{@$token->expriry_date}}"  type="date" name="expriry_date" required="required" class="form-control installment_date" placeholder=""  />
                    </div>
                </div>

               <input type="hidden" name="status" value="token">
                
               
               
            </div>

            <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" >Submit</button>
       
      
        </form>
        </div>
    </div>
     
   
      
    

@stop
@section('javascript')

    
    <script type="text/javascript">
            $(document).ready(function() {

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
          
            });
         
           
        </script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script type='text/javascript'>
    $('.deal_amount').on('focusout', function() {
       var dealprice = $(".deal_amount").val();
       var office_amount = $('.office_amount').val();
       var discount =office_amount - dealprice;
       $('.discount_amount').val(discount);
    });
   $(document).ready(function(){

      // Department Change
      $('.plot_id').change(function(){

         // Department id
         var id = $(this).val();
        // alert(id);

         // AJAX request 
         $.ajax({
           url: 'getofficeprice/'+id,
           type: 'get',
           dataType: 'json',
           success: function(response){
            // console.log(response);
            $('.office_amount').val(response.price);

           }
         });
      });
   });
   </script>
    
@stop