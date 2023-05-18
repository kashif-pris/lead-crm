@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

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
                                        <label class="control-label">Plot Name <span class="required">*</span> </label>
                                        <select required name="plot" class="form-control" id="plot">
                                            <option>--choose</option>
                                            @foreach($plots as $item)
                                            @if($item->is_booked == 0)
                                                <option {{$item->id == $booking->plot_id ? "selected" : ""}} value="{{$item->id}}">{{$item->name}}</option>
                                           
                                             @endif
                                             @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Refrence No <span class="required">*</span> </label>
                                        <input  pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==9) return false;" type="text" value="{{$booking->ref_num}}" name="reference" required="required" class="form-control" placeholder="Enter Refrence No"  />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Serial No <span class="required">*</span> </label>
                                        <input maxlength="100" type="text" value="{{$booking->ser_num}}"  name="serial" required="required" class="form-control" placeholder="Enter Serial No" />
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        
                        <div class="col-md-12">
                            <div class="row">
                                <hr>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Plot Project :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-primery" id="plot_project"> {{$booking->plots->projects->project_name}}</label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Plot Block :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-warning" id="plot_block">{{$booking->plots->block->name}}</label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Plot Size :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-success" id="plot_size">{{$booking->plots->sizeGet->name}}</label><hr>
                                </div>
    
                                
                              <div class="col-md-2">
                                  
                                    <label class="control-label pull-right">Plot Price :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-danger" id="plot_price">{{$booking->plots->price}}</label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Plot Features :  </label>
                                </div>
                                <div class="col-md-4 " id="plot_feature">
                                    @foreach($array as $item)
                                    <label class="badge badge-danger" id="plot_price">{{$item}}</label>
                                    @endforeach
                                </div>
    
    
                            </div>
                        </div>
    
    
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label for="customer">Customer</label>
                                    <select class="form-control select2 " id="customer" name="customer"  tabindex="-1" aria-hidden="true">
                                        <option>--choose</option>
                                        @foreach($customers as $item)
                                        <option {{$item->id == $booking->customer_id ? "selected" : ""}} value="{{$item->sal_customer_id}}" >{{$item->sal_customer_name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
                            {{-- {{dd($booking)}} --}}
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer S/O :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_so">{{$booking->customers->son_of}}</label>
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Phone :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_phone">{{$booking->customers->phone_1}}</label>
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Email :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_email">{{$booking->customers->email}}</label><hr>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Cnic :  </label>
                            </div>
                            <div class="col-md-2">
                                <label class="badge badge-primery" id="c_cnic">{{$booking->customers->cnic}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label for="customer">Agent</label>
                                    <select class="form-control select2 " id="agent" name="agent"  tabindex="-1" aria-hidden="true">
                                        <option value="" >--Choose</option>
                                       @foreach($agents as $item)
                                        <option {{$item->id == $booking->agent_id ? "selected" : ""}} value="{{$item->id}}" >{{$item->name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Commission:  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text"name="commission"  value="{{$booking->agent_commission}}" id="commission" class="form-control" >
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Plot Price :  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="plot_price_input"  value="{{$booking->amount}}"  name="plot_amount">
                            </div>
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Commission amount :  </label>
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="commission_amount"  value="{{$booking->agent_amount}}"  name="commission_amount">
                            </div>
    
                             
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
                                        <th><button type="button" name="add" id="add" class=" btn btn-success">Add More</button></th>
                                    </tr>
                                    
                                    @foreach($booking->nominees as $key =>$item)
                                    <tr>
                                        <td><input type="text" id="freeSpace" value="{{$item->name}}" name="addmore[{{$key}}][name]" required placeholder="Enter Name..." class="form-control text-field pName" /></td>
                                        <td><input type="text" id="freeSpace" value="{{$item->son_of}}"  name="addmore[{{$key}}][so]" required placeholder="Enter s/o" class="form-control text-field pDesignation" /></td>
                                        <td><input type="text" id="freeSpace"   value="{{$item->relation}}"  name="addmore[{{$key}}][relation]" required placeholder="Enter relation" class="form-control text-field pMobile" /></td>  
                                        <td><input type="number" id="freeSpace"  value="{{$item->cnic}}"  name="addmore[{{$key}}][cnic]" required placeholder="Enter cnic" class="form-control text-field pEmail" /></td>  
                                        <td><input type="number" id="freeSpace"  value="{{$item->phone}}"  name="addmore[{{$key}}][phone]" required placeholder="Enter Phone no 1" class="form-control text-field pPhone" /></td>  
                                        <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
                                    </tr> 
                                    @endforeach 
                                    
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
                                    <input class="form-check-input" {{$booking->down_payments->p_type == "full" ? "checked" : ""}} name="payment_type" type="radio" id="inlineCheckbox16" value="full" required="required">
                                    <label class="form-check-label" for="inlineCheckbox16">Lump Sum Payment (100%)</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" {{$booking->down_payments->p_type == "partial" ? "checked" : ""}} type="radio" name="payment_type" id="inlineCheckbox17" value="partial" required="required">
                                    <label class="form-check-label" for="inlineCheckbox17">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
    
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Payment Type <span class="required">*</span> </label>
                                    <select name="payment_method" class="form-control" required>
                                        <option>--choose</option>
                                        <option value="1">Online</option>
                                        <option selected value="2">Cash</option>
                                        <option  value="3">Cherque</option>
                                        <option value="4">Pay order</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Down Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" type="number" value="{{$booking->down_payments->amount}}" name="down_payment" required="required" class="form-control" placeholder="Enter Applicant Name"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">DD/Pay Order # <span class="required"></span> </label>
                                    <input  maxlength="100" type="text" value="{{$booking->down_payments->p_order}}" name="pay_order"  class="form-control" placeholder="Enter Applicant Name"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cheque # <span class="required"></span> </label>
                                    <input  maxlength="100" type="text" name="cheque" value="{{$booking->down_payments->cheque}}" class="form-control" placeholder="Enter Applicant Name"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cash Receipt #: <span class="required">*</span> </label>
                                    <input maxlength="100" type="text" name="receipt"  value="{{$booking->down_payments->receipt}}" required="required" class="form-control" placeholder="Enter Name" />
                                </div>
                            </div>
                
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Dated: <span class="required">*</span> </label>
                                    <input  maxlength="100" type="date" name="date" required="required"  value="{{$booking->down_payments->date}}" class="form-control" placeholder=""  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Bank : <span class="required">*</span> </label>
                                    <select name="bank" class="form-control">
                                        <option>--choose</option>
                                        @foreach($banks as $item)
                                        <option {{$item->id == $booking->down_payments->bank_id ? "selected" : "" }} value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Tenure : <span class="required">*</span> </label>
                                    {{-- <select name="bank" class="form-control">
                                        <option>--choose</option>
                                        @foreach($tenure as $item)
                                        <option {{$item->id == $booking->down_payments->bank_id ? "selected" : "" }} value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-ms-12">
                                <table class="table table-striped">
                                    <thead>
                                    
                                        <th>Title</th>
                                        <th>File</th>
                                        <th>View</th>
                                  
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($doc as $item)
                                       
                                        <tr>
                                            <td>{{$item->title}}</td>
                                             <td><input type="file"  class="form-control" name="file[]" ></td>
                                             <td><a href="{{"/".$item->path."/".$item->file}}" class="badge badge-primery" target="-blank">View</a></td>
                                            <input type="hidden"  class="form-control" name="file_id[]" value="{{$item->new}}" >
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
                                        <label class="control-label">Plot Name <span class="required">*</span> </label>
                                        <select name="plot" class="form-control" id="plot">
                                            <option>--choose</option>
                                            @foreach($plots as $item)
                                                @if($item->is_booked == 0)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
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
                                    <label class="control-label pull-right">Plot Project :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-primery" id="plot_project"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Plot Block :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-warning" id="plot_block"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Plot Size :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-success" id="plot_size"></label><hr>
                                </div>
    
                                
                              <div class="col-md-2">
                                  
                                    <label class="control-label pull-right">Plot Price :  </label>
                                </div>
                                <div class="col-md-2">
                                    <label class="badge badge-danger" id="plot_price"></label>
                                </div>
    
                                <div class="col-md-2">
                                    <label class="control-label pull-right">Plot Features :  </label>
                                </div>
                                <div class="col-md-4 " id="plot_feature">
                                       
                                </div>
    
    
                            </div>
                        </div>
    
    
                    <div class="col-md-12">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                
                                    <label for="customer">Customer</label>
                                    <select class="form-control select2 " id="customer" name="customer"  tabindex="-1" aria-hidden="true">
                                        <option>--choose</option>
                                        @foreach($customers as $item)
                                        <option value="{{$item->sal_customer_id}}" >{{$item->sal_customer_name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
    
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer S/O :  </label>
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
                            
                            <div class="col-md-2">
                                <label class="control-label pull-right">Customer Cnic :  </label>
                            </div>
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
                                        <option value="" >--Choose</option>
                                       @foreach($agents as $item)
                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                       @endforeach
                                    </select>
                                 
                            </div>
                            {{-- data from ajax --}}
    
                            <div class="col-md-2">
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
                            </div>
    
    
    
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
                                    <input class="form-check-input" type="radio" name="payment_type" id="inlineCheckbox17" value="partial" required="required">
                                    <label class="form-check-label" for="inlineCheckbox17">Other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
    
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Down Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" type="number" name="down_payment" required="required" class="form-control" placeholder="Enter Amount"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Token Payment <span class="required">*</span> </label>
                                    <input  maxlength="100" readonly id="token_payment" type="text" name="token_payment" required="required" class="form-control" placeholder="Enter Amount"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">DD/Pay Order # <span class="required"></span> </label>
                                    <input  maxlength="100" type="text" name="pay_order" class="form-control" placeholder="Enter Applicant Name"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cheque # <span class="required"></span> </label>
                                    <input  maxlength="100" type="text" name="cheque"  class="form-control" placeholder="Enter Applicant Name"  />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Cash Receipt #: <span class="required">*</span> </label>
                                    <input maxlength="100" type="text" name="receipt" required="required" class="form-control" placeholder="Enter Name" />
                                </div>
                            </div>
                
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Dated: <span class="required">*</span> </label>
                                    <input  maxlength="100" type="date" name="date" required="required" class="form-control" placeholder=""  />
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

         $('#commission').keyup(function(){
            var commission = $(this).val();
            var price = $('#plot_price_input').val();

            commission_amount =  price/100 * commission;
           $('#commission_amount').val(commission_amount);
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
                       $('#c_cnic').text(data.cn );
                       $('#token_payment').val(data.amount);
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
   
    
@stop