@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
<?php

use Carbon\CarbonPeriod;
?>
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            @if(Auth::user()->hasPermission('browse_booking'))
            <a href="/admin/application-form/record" class="btn btn-success btn-add-new">
               <span>Booking Record</span>
            </a>
            @endif
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
 
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title text-center">Booking Form</h3>
        </div>
        
        <div class = "panel-body">
              @if(isset($update))
            <form action = "{{ route('ApplicationForm.update') }}" method ="post" enctype = "multipart/form-data">
               
                @csrf
                <input type="hidden" value="{{$booking->id}}" name="id">
                {{-- {{dd($booking->plot_id)}} --}}
                
                <div class="container">
                    <div class="col-xs-12" style="margin-top: 20px">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Office Name <span class="required">*</span> </label>
                                        <select name="plot" class="form-control" id="plot">
                                            <option>--choose</option>
                                            @foreach($plots as $item)
                                                @if($item->is_booked == 0)
                                                    <option value="{{$item->id}}">{{$item->office_no}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Refrence No <span class="required">*</span> </label>
                                        <input  maxlength="100" type="text" name="reference"  onKeyPress="if(this.value.length==9) return false;" required="required" class="form-control" placeholder="Enter Refrence No"  />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label">Serial No <span class="required">*</span> </label>
                                        <input maxlength="100" type="text" name="serial" value="{{@$ser_num}}"  onKeyPress="if(this.value.length==6) return false;" required="required" class="form-control" placeholder="Enter Serial No" />
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="row">
                                <hr>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Project :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-primery" id="plot_project"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Floor :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-warning" id="plot_block"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Size :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-success" id="plot_size"></label><hr>
                                </div>
    
                                
                              <div class="col-md-2">
                                  
                                    <label class="control-label pull-right">Office Price :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-danger" id="plot_price"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Features :  </label>
                                </div>
                                <div class="col-md-2 " id="plot_feature">
                                       
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Status :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-danger" id="plot_status"></label>
                                </div>
    
    
                            </div>
                        </div>
    
    
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label for="customer">Customer</label>
                                    <select class="form-control select2 " id="customer" name="customer"  tabindex="-1" aria-hidden="true">
                                        <option value="">--choose--</option>
                                        @foreach($customers as $item)
                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Name :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_so"></label>
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Phone :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_phone"></label>
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Email :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_email"></label><hr>
                            </div>
                            
                            {{-- <div class="col-md-2">
                                <label class="control-label pull-right">Customer Cnic :  </label>
                            </div> --}}
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_cnic"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label for="customer">Agent</label>
                                    <select class="form-control select2 " id="agent" name="agent"  tabindex="-1" aria-hidden="true">
                                        <option value="" >--Choose--</option>
                                       @foreach($agents as $item)
                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
                            <input hidden type="number" onKeyPress="if(this.value.length==9) return false;" id="plot_price_input" name="plot_amount">
                            <!-- <div class="col-md-2">
                                <label class="control-label pull-right">Commission:  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="commission" onKeyPress="if(this.value.length==3) return false;"  id="commission" class="form-control" >
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Plot Price :  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" onKeyPress="if(this.value.length==9) return false;" id="plot_price_input" name="plot_amount">
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Commission amount :  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" onKeyPress="if(this.value.length==9) return false;" id="commission_amount" name="commission_amount">
                            </div> -->
    
    
    
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                               
                                <table style="display: inline-table !important;" class="table table-striped" id="dynamicTable" style="2px solid black">  
                                    <tr style="color:black">
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
                    </div>
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
                                    <input class="form-check-input" type="radio"  name="payment_type" id="inlineCheckbox17" value="partial" required="required">
                                    <label class="form-check-label" for="inlineCheckbox17">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fiancial Month  <span class="required">*</span> </label>
                                    <select name="month" id="month" class="form-control month">
                                        @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)
                                            <option value="{{ $date->format('F Y') }}">
                                                {{ $date->format('F ') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- <select name="month" id="month" class="form-control month">
                                        
                                    </select> -->
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fiancial Year  <span class="required">*</span> </label>
                                    <select name="year" class="form-control" id="dropdownYear" style="width: 120px;" >
                                    </select>
                                    <!-- <select name="year" class="form-control" id="year">
                                        <option>--choose</option>
                                        @foreach($years as $item)
                                        <option value="{{$item->FinancialYear}}">{{$item->FinancialYear}}</option>
                                        @endforeach
                                    </select> -->
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Dated: <span class="required">*</span> </label>
                                    <input  maxlength="100" type="date" id="date" name="date" required="required" class="form-control" placeholder=""  />
                                </div>
                            </div>
    
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Payment Type <span class="required">*</span> </label>
                                    <select name="payment_method" class="form-control">
                                        <option>--choose</option>
                                        <option value="1">Online</option>
                                        <option value="2">Cash</option>
                                        <option  value="3">Cheque</option>
                                        <option value="4">Pay order</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Down Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" id="downpayment" type="number" name="down_payment" required="required" class="form-control downpayment" placeholder="Enter Amount"  />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Token Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" readonly id="token_payment" type="text" name="token_payment" required="required" class="form-control token_amount" placeholder="Enter Amount"  />
                                    <input  maxlength="100" readonly id="token_id" type="hidden" name="token_id" required="required" class="form-control token_amount" placeholder="Enter Amount"  />
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
                                    <label class="control-label">Tenure : <span class="required">*</span> </label>
                                    <select name="tunure" class="form-control">
                                        <option>--choose</option>
                                        @foreach($tunure as $item)
                                        <option value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div id="ifYes"  class="form-group">
                                    <label class="control-label">Discount : <span class="required">*</span> </label>
                                    <input  type="text" id="discount_amount" name="discount"  class="form-control discount_amount" placeholder="Discount Amount"  />
                                    

                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    
                                        <th>Title</th>
                                        <th>File</th>
                                    
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
                    </div>
                </div> 
            </form>
            @else
            <form action = "{{ route('ApplicationForm') }}" method ="post" enctype = "multipart/form-data">
                @csrf
                <div class="container">
                    <div class="col-xs-12" style="margin-top: 20px">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Office Name <span class="required">*</span> </label>
                                        <select name="plot" class="form-control" id="plot">
                                            <option>--choose</option>
                                            @foreach($plots as $item)
                                                @if($item->is_booked == 0)
                                                    <option value="{{$item->id}}">{{$item->office_no}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Refrence No <span class="required">*</span> </label>
                                        <input  maxlength="100" type="text" name="reference"  onKeyPress="if(this.value.length==9) return false;" required="required" class="form-control" placeholder="Enter Refrence No"  />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <label class="control-label">Serial No <span class="required">*</span> </label>
                                        <input maxlength="100" type="text" name="serial" value="{{@$ser_num}}"  onKeyPress="if(this.value.length==6) return false;" required="required" class="form-control" placeholder="Enter Serial No" />
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-md-12">
                            <div class="row">
                                <hr>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Project :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-primery" id="plot_project"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Floor :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-warning" id="plot_block"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Size :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-success" id="plot_size"></label><hr>
                                </div>
    
                                
                              <div class="col-md-2">
                                  
                                    <label class="control-label pull-right">Office Price :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-danger" id="plot_price"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Features :  </label>
                                </div>
                                <div class="col-md-2 " id="plot_feature">
                                       
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Office Status :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-danger" id="plot_status"></label>
                                </div>
    
    
                            </div>
                        </div>
    
    
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label for="customer">Customer</label>
                                    <select class="form-control select2 " id="customer" name="customer"  tabindex="-1" aria-hidden="true">
                                        <option value="">--choose--</option>
                                        @foreach($customers as $item)
                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Name :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_so"></label>
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Phone :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_phone"></label>
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Email :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_email"></label><hr>
                            </div>
                            
                            {{-- <div class="col-md-2">
                                <label class="control-label pull-right">Customer Cnic :  </label>
                            </div> --}}
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_cnic"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label for="customer">Agent</label>
                                    <select class="form-control select2 " id="agent" name="agent"  tabindex="-1" aria-hidden="true">
                                        <option value="" >--Choose--</option>
                                       @foreach($agents as $item)
                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
                            <input hidden type="number" onKeyPress="if(this.value.length==9) return false;" id="plot_price_input" name="plot_amount">
                            <!-- <div class="col-md-2">
                                <label class="control-label pull-right">Commission:  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="commission" onKeyPress="if(this.value.length==3) return false;"  id="commission" class="form-control" >
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Plot Price :  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" onKeyPress="if(this.value.length==9) return false;" id="plot_price_input" name="plot_amount">
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Commission amount :  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" onKeyPress="if(this.value.length==9) return false;" id="commission_amount" name="commission_amount">
                            </div> -->
    
    
    
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                               
                                <table style="display: inline-table !important;" class="table table-striped" id="dynamicTable" style="2px solid black">  
                                    <tr style="color:black">
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
                    </div>
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
                                    <input class="form-check-input" type="radio"  name="payment_type" id="inlineCheckbox17" value="partial" required="required">
                                    <label class="form-check-label" for="inlineCheckbox17">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fiancial Month  <span class="required">*</span> </label>
                                    <select name="month" id="month" class="form-control month">
                                        @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month', now()->addMonths(11)->startOfMonth()) as $date)
                                            <option value="{{ $date->format('F Y') }}">
                                                {{ $date->format('F ') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- <select name="month" id="month" class="form-control month">
                                        
                                    </select> -->
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fiancial Year  <span class="required">*</span> </label>
                                    <select name="year" class="form-control" id="dropdownYear" style="width: 120px;" >
                                    </select>
                                    <!-- <select name="year" class="form-control" id="year">
                                        <option>--choose</option>
                                        @foreach($years as $item)
                                        <option value="{{$item->FinancialYear}}">{{$item->FinancialYear}}</option>
                                        @endforeach
                                    </select> -->
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Dated: <span class="required">*</span> </label>
                                    <input  maxlength="100" type="date" id="date" name="date" required="required" class="form-control" placeholder=""  />
                                </div>
                            </div>
    
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Payment Type <span class="required">*</span> </label>
                                    <select name="payment_method" class="form-control">
                                        <option>--choose</option>
                                        <option value="1">Online</option>
                                        <option value="2">Cash</option>
                                        <option  value="3">Cheque</option>
                                        <option value="4">Pay order</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Down Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" id="downpayment" type="number" name="down_payment" required="required" class="form-control downpayment" placeholder="Enter Amount"  />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Token Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" readonly id="token_payment" type="text" name="token_payment" required="required" class="form-control token_amount" placeholder="Enter Amount"  />
                                    <!-- <input  maxlength="100" readonly id="token_id" type="hidden" name="token_id" required="required" class="form-control token_amount" placeholder="Enter Amount"  /> -->
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
                                    <label class="control-label">Tenure : <span class="required">*</span> </label>
                                    <select name="tunure" class="form-control">
                                        <option>--choose</option>
                                        @foreach($tunure as $item)
                                        <option value="{{$item->id}}"> {{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div id="ifYes"  class="form-group">
                                    <label class="control-label">Discount : <span class="required">*</span> </label>
                                    <input  type="text" id="discount_amount" name="discount"  class="form-control discount_amount" placeholder="Discount Amount"  />
                                    

                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                    
                                        <th>Title</th>
                                        <th>File</th>
                                    
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
                    </div>
                </div> 
            </form>
            @endif
        </div>
    </div>
     
   
      
    

@stop
@section('javascript')
<script>
    $(":input").inputmask();
</script>
    <script src="{{ asset('tagsManager/fm.tagator.jquery.js') }}"></script>
    <script src="{{ asset('dataTable/summernote.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
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
<script>
    
    $(document).ready(function () {

         $('#commission').keyup(function(){
            var commission = $(this).val();
            var price = $('#plot_price_input').val();

            commission_amount =  price/100 * commission;
           $('#commission_amount').val(commission_amount);
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
                        // console.log(data);
                        var parseData = JSON.parse(data[0]);
                        var parsetoken = JSON.parse(data[1]);
                       var i;
                      $('#plot_project').text(parseData.project);
                      $('#plot_size').text(parseData.size);
                      $('#plot_price').text(parseData.numprice + " Rs ");
                      $('#plot_price_input').val(parseData.price);
                      $('#plot_block').text(parseData.block);
                      $('#plot_status').text(parseData.status);
                      $('#plot_feature').html('');
                      $('#downpayment').val(parsetoken.downpayment);
                      $('#dealprice').val(parsetoken.dealprice);
                      $('#discount_amount').val(parsetoken.discount_amount);
                      $('#token_payment').val(parsetoken.token_amount);
                      for( i = 0 ; i < parseData.feature.length ; i++){
                           $('#plot_feature').append("<label class='badge badge-info' > "+parseData.feature[i]+" </label> ");
                          }
                       
                    }
                });
          });

          $('#customer').change(function(){
            var customer = $('#customer').val();
         
            var plot = $('#plot').val();
           
                $.ajax({
                    url: "/admin/application-form/customer/search",
                    data: {
                         "customerID": customer ,
                         "plotID": plot ,
                         },
                    dataType:"json",
                    type: "get",
                    success: function(data){
                      console.log(data);
                       $('#c_so').text(data.so);
                       $('#c_phone').text(data.phone);
                       $('#c_email').text(data.email);
                    //    $('#c_cnic').text(data.cn );
                    //    $('#token_payment').val(data.amount);
                       $('#token_id').val(data.tokenId);
                    }
                });
          });

        //   agent
          $('#agent').change(function(){
            var agent = $('#agent').val();
           
                $.ajax({
                    url: "/admin/application-form/agent/search",
                    data: {
                         "agentID": agent ,
                         },
                    dataType:"json",
                    type: "get",
                    success: function(data){
                        var price = $('#plot_price_input').val();
                        var commission = price/100 * data;
                        $('#commission').val(data);
                        $('#commission_amount').val(commission);
                    }
                });
          });

          // for contact person
          var t = $('#dynamicTable tr').length - 1;
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

<script type="text/javascript">
    function Check() {
        // alert('data');
        if (document.getElementById('inlineCheckbox16').checked) {
            document.getElementById('ifYes').style.display = 'block';
            // alert('data');
        } 
        else {
            document.getElementById('ifYes').style.display = 'none';
            document.getElementById('ifYes').value = '0';
    
       }
    }
    
    </script>
   
    
@stop