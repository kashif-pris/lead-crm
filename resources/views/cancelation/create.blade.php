@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/cancelation/record" class="btn btn-success btn-add-new">
               <span>All Cancelation History</span>
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
    @php 
    $booking = \App\Models\Cancelation::orderBy('id', 'desc')->first();
    if(!empty($booking)){
        $serialNo = ($booking->id+1);
    }else{
        $serialNo = 1;
    }
  
    @endphp
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title">Create Cancelation Request</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "{{route('cancelation.store')}}" method ="post" enctype = "multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <div class="form-group" style="margin-top: 30px">
                    <label class="control-label">Serial Num <span class="required">*</span> </label>
                   <input type="text" class="form-control" readonly value="{{$serialNo}}" placeholder="Ser num" name="ser_num">
                </div>
            </div>
            <div class="col-md-3">
                 <div class="form-group" style="margin-top: 30px">
                     <label class="control-label">Customer Name <span class="required">*</span> </label>
                     <select onchange="getBooking()" name="customer" class="form-control getBooking select2" id="customer">
                         <option>--choose--</option>
                         @foreach($customers as $item)
                            <option  value="{{$item->sal_customer_id}}">{{$item->sal_customer_name}}</option>
                         @endforeach
                     </select>
                 </div>
             </div>
             <div class="col-md-3">
                 <div class="form-group" style="margin-top: 30px">
                     <label class="control-label">Booking Reference <span class="required">*</span> </label>
                     <select  name="booking_id"  class="getTransferFee form-control bookings select2" id="booking">
                        <option>--choose--</option>
                        
                    </select>
                 </div>
             </div>
           
             <div class="col-md-3">
                <div class="form-group" style="margin-top: 30px">
                    <label class="control-label">Reason <span class="required">*</span> </label>
                    <select  name="reason"  class="form-control select2">
                       <option>--choose--</option>
                       <option value="Development Status">Development Status</option>
                       <option value="Delay in Balloting">Delay in Balloting</option>
                       <option value="Financial Issues">Financial Issues</option>
                       <option value="Unsatisfactory Customer services">Unsatisfactory Customer services</option>
                       <option value="Development Charges">Development Charges</option>
                       <option value="Misrepresentation by sales person or Dealer">Misrepresentation by sales person or Dealer</option>
                   </select>
                </div>
            </div>
           
         </div>

         <div class="row">
            <hr>
          
            <table class="table table-bordered">
                <tbody>
                    
                    <tr>
                      <th>Son Of</th>
                        <td><label class="badge badge-primery" id="c_so"></label></td>
                    </tr>
                    <tr>
                      <th>Phone</th>
                        <td> <label class="badge badge-warning" id="c_phone"></label></td>
                    </tr>
                  <tr>
                      <th>Email</th>
                          <td><label class="badge badge-success" id="c_email"></label></td>
                    </tr>
                    <tr>
                        <th>CNIC</th>
                            <td><label class="badge badge-danger" id="c_cnic"></label></td>
                      </tr>
                      <tr>
                        <th>Plot Type</th>
                            <td><label class="badge badge-danger" id="p_type"></label></td>
                      </tr>
                      <tr>
                        <th>Plot Size</th>
                            <td><label class="badge badge-danger" id="p_size"></label></td>
                      </tr>
                      <tr>
                        <th>Plot Value</th>
                            <td><label class="badge badge-danger" id="p_value"></label></td>
                      </tr>
                </tbody>
            </table>

            <p class="text-danger" style="padding:16px;"> 
               {{setting('site.cancelation_fee_note')}}
             </p>
            
            <div class="col-md-3">
                <div class="form-group" style="margin-top: 30px">
                    <label class="control-label">Cancelation Fee </label>
                    <input type="number"  name="fee" class="form-control transferFee">
                </div>
            </div>

        </div>

          
<div class="row">
<hr>
   




            {{-- documenmts --}}

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">Required Docs</th>
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


            </div>

            <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" >Submit</button>
       
      
        </form>
        </div>
    </div>
</div>
     
   
      
    

@stop
@section('javascript')

    
    <script type="text/javascript">
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
         
           function getBooking(){
               var customerID = $('.getBooking').val();
               $('.bookings').html('');
               $.ajax({
                   'url':'/admin/cancelation/getBookings/'+customerID,
                   'method':'GET',
                   success: function(data){
                        console.log(data);
                        var i;
                        for(var i = 0; i < data.length; i++){
                            
                            var transferFee = data[i].plot_size.split("-")[0];
                            $('.bookings').append('<option fee="'+transferFee+'" value="'+data[i].id+'">'+data[i].ref_num +' ('+data[i].plot_size+')</option>');
                            if(data[i].plots.status == "residential"){
                                $('.transferFee').val(data[i].plots.price*10/100);
                            }else{
                                $('.transferFee').val(data[i].plots.price*10/100);
                            }
                           
                            $('#p_size').text(data[i].plot_size);
                            $('#p_type').text(data[i].plots.status);
                            $('#p_value').text((data[i].plots.price));

                        }
                    },
                   error:function(data){

                   }
               })
           }
           $('.getTransferFee').change(function(){
            // alert('lsdn');
            // console.log(this.attr('fee'));
           })
         
        </script>
   
    
@stop