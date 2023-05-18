@extends('voyager::master')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="icon voyager-pie-chart"></i>
            <a href="/admin/plot/record" class="btn btn-success btn-add-new">
               <span>Files List</span>
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
    <div class = "panel panel-primary">
        <div class = "panel-heading">
            <h3 class = "panel-title text-center">Create File</h3>
        </div>
        
        <div class = "panel-body">
            @if(isset($update))
            <form action = "{{ url('admin/plot/update/'.$plot->id) }}" method ="post">
                @csrf
                <div class="container">
                    <div class="col-xs-12" style="margin-top: 20px">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Projects <span class="required">*</span> </label>
                                        <select name="project" class="form-control select2-search__field" id="project" required>
                                            
                                            @foreach ($projects as $item)
                                            <option {{$plot->pr_id == $item->id ? "selected" : ""}} value="{{$item->id}}"> {{$item->project_name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Block <span class="required">*</span> </label>
                                        <select name="block" class="form-control select2-search__field" id="block" required>
                                            
                                            @foreach ($blocks as $item)
                                            <option {{$plot->bl_id == $item->id ? "selected" : ""}}  value="{{$item->id}}"> {{$item->name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">File No <span class="required">*</span> </label>
                                        <input type ="text" name ="office_no" class ="form-control" value ="{{$plot->office_no}}" required>
                                        <input type="hidden" name="name"  value="{{$plot->name}}" class="form-control" id="plot" onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57))">
                                    </div>
                                </div>
    
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Length <span class="required">*</span> </label>
                                        <input type="number" name="Length"  value="{{$plot->length}}" class="form-control" id="length">
                                    </div>
                                </div>
    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Width <span class="required">*</span> </label>
                                        <input type="number" name="width"  value="{{$plot->width}}" class="form-control" id="width">
                                    </div>
                                </div> -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Price <span class="required">*</span> </label>
                                        <input type="number" name="price"  value="{{$plot->price}}" class="form-control" id="price" required>
                                    </div>
                                </div>
    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Size <span class="required">*</span> </label>
                                        <select name="size" class="form-control select2-search__field" id="size" required>
                                            
                                            @foreach ($size as $item)
                                            <option {{$plot->size == $item->id ? "selected" : ""}} value="{{$item->id}}"> {{$item->name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Type <span class="required">*</span> </label>
                                        <select name="status" class="form-control select2-search__field" id="size" required>
                                            
                                            @if($plot->status == "Open")
                                            <option selected value="Open"> Open </option>
                                            <option value="Sold Out"> Sold Out  </option> 
                                            <option value="Token "> Token  </option> 
                                            @elseif($plot->status == "Sold Out")
                                            <option  value="Open"> Open </option>
                                            <option selected value="Sold Out"> Sold Out  </option> 
                                            <option value="Token "> Token  </option> 
                                            @elseif($plot->status == "Token")
                                            <option  value="Open"> Open </option>
                                            <option  value="Sold Out"> Sold Out  </option> 
                                            <option selected value="Token "> Token  </option> 
                                            @endif
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Customer Type <span class="required">*</span> </label>
                                        <select name="customer_type" class="form-control select2-search__field" id="size" required>
                                            
                                            @if($plot->customer_type == "Seller")
                                            <option selected value="Seller"> Seller </option>
                                            <option value="Buyer"> Buyer </option> 
                                            @elseif($plot->customer_type == "Buyer")
                                            <option  value="Seller"> Seller </option>
                                            <option selected value="Buyer"> Buyer </option> 
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Customer Name <span class="required">*</span> </label>
                                        <input type="text" name="customer_name"  value="{{$plot->customer_name}}" class="form-control" id="customer_name" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Customer Phone <span class="required">*</span> </label>
                                        <input type="text" name="customer_phone"  value="{{$plot->customer_phone}}" class="form-control" id="customer_phone" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">File Type <span class="required">*</span> </label>
                                        <select name="file_type" class="form-control select2-search__field" id="size" required>
                                            
                                            @if($plot->file_type == "Fresh")
                                            <option selected value="Fresh"> Fresh </option>
                                            <option value="Resale"> Resale </option> 
                                            @elseif($plot->file_type == "Resale")
                                            <option  value="Fresh"> Fresh </option>
                                            <option selected value="Resale"> Resale </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                               
                                <!-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Attach Office <span class="required">*</span> </label>
                                       <select class="multiple form-control" name="attach_plot[]"  multiple="multiple"> 
                                            @foreach ($plots as $item)
                                            @if(in_array($item->id,$attach)){
                                                <option selected value="{{$item->id}}"> {{$item->name}}</option>
                                            @else
                                                <option   value="{{$item->id}}"> {{$item->name}}</option>
                                            @endif
                                                
                                            @endforeach
                                          </select>
                                    </div>
                                </div> -->

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">File Features <span class="required">*</span> </label>
                                       <select class="multiple form-control" name="feature[]"  multiple="multiple" > 
                                        @if(isset($feature))
                                            @foreach ($features as $item)
                                                @if(in_array($item->id,$feature)){
                                                    <option selected value="{{$item->id}}"> {{$item->name}}</option>
                                                @else
                                                    <option   value="{{$item->id}}"> {{$item->name}}</option>
                                                @endif
                                                
                                            @endforeach
                                        @else
                                            @foreach ($features as $item)
                                               <option   value="{{$item->id}}"> {{$item->name}}</option>
                                            @endforeach
                                        @endif
                                          </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Description <span class="required">*</span> </label>
                                        <textarea type="text" name="description" class="form-control" required >{{$plot->description}}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                    <fieldset>
                                        <legend>Customer information</legend>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Customer</label>
                                                <select name="customer_id" class="form-control select2-search__field" id="customer_id" required>
                                                    @foreach ($leads as $item)
                                                    <option {{$plot->customer_id == $item->id ? "selected" : ""}} value="{{$item->id}}"> {{$item->name}}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">S/O, D/O, W/O </label>
                                                <input type="text"  value="{{$plot->customer_rel}}" name="customer_rel" class="form-control" id="customer_rel" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Phone No </label>
                                                <input type="number"  value="{{$plot->phone}}" name="phone" class="form-control" id="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">CNIC </label>
                                                <input type="text" value="{{$plot->cnic}}"name="cnic" class="form-control" id="cnic" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Payment Type <span class="required">*</span> </label>
                                                <select name="payment_type" class="form-control select2-search__field" id="payment_type" required>
                                                    <option selected value="Cash"> Cash </option>
                                                    <option value="Cheque"> Cheque </option> 
                                                    <option value="Pay Order"> Pay Order </option> 
                                                    <option value="Bank Draft"> Bank Draft </option> 
                                                </select>
                                            </div>
                                        </div>
                                    <fieldset>
                                </div>
                        </div>
                       
                    
                        <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" >Submit</button>
                    </div>
                </div> 
            </form>
            @else
            <form action = "{{ route('plot_store') }}" method ="post"  autocomplete="off">
                @csrf
                <div class="container">
                    <div class="col-xs-12" style="margin-top: 20px">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Projects <span class="required">*</span> </label>
                                        <select name="project" class="form-control select2-search__field" id="project" required>
                                            
                                            @foreach ($projects as $item)
                                            <option value="{{$item->id}}"> {{$item->project_name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Block <span class="required">*</span> </label>
                                        <select name="block" class="form-control select2-search__field" id="block" required>
                                            
                                            @foreach ($blocks as $item)
                                            <option value="{{$item->id}}"> {{$item->name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="plot">File No <span class="required">*</span> </label>
                                        <input type ="text" name ="office_no" class ="form-control" required>
                                        <input  type="hidden" name="name" class="form-control"  autocomplete="off" id="plot" onkeypress="return (event.charCode !=8 &amp;&amp; event.charCode ==0 || (event.charCode >= 48 &amp;&amp; event.charCode <= 57))">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Price <span class="required">*</span> </label>
                                        <input type="number" name="price" class="form-control" id="price" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Size <span class="required">*</span> </label>
                                        <select name="size" class="form-control select2-search__field" id="size" required>
                                            
                                            @foreach ($size as $item)
                                            <option value="{{$item->id}}"> {{$item->name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Status <span class="required">*</span> </label>
                                        <select name="status" class="form-control select2-search__field" id="size" required>
                                            
                                            <option selected value="Open"> Open </option>
                                            <option value="Sold Out"> Sold Out  </option> 
                                            <option value="Token "> Token  </option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Customer Type <span class="required">*</span> </label>
                                        <select name="customer_type" class="form-control select2-search__field" id="size" required>
                                            
                                            <option selected value="Seller"> Seller </option>
                                            <option value="Buyer"> Buyer </option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Customer Name <span class="required">*</span> </label>
                                        <input type="text" name="customer_name" class="form-control" id="customer_name" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Customer Phone <span class="required">*</span> </label>
                                        <input type="text" name="customer_phone" class="form-control" id="customer_phone" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">File Type <span class="required">*</span> </label>
                                        <select name="file_type" class="form-control select2-search__field" id="size" required>
                                            <option selected value="Fresh"> Fresh </option>
                                            <option value="Resale"> Resale </option> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">File Feature  <span class="required">*</span> </label>
                                        <select class="multiple form-control " name="feature[]" multiple="multiple">
                                            @foreach ($features as $item)
                                            <option value="{{$item->id}}"> {{$item->name}}</option> 
                                            @endforeach
                                          </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Description <span class="required">*</span> </label>
                                        <textarea type="text" name="description" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <fieldset>
                                    <legend>Customer information</legend>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Customer</label>
                                            <select name="customer_id" class="form-control select2-search__field" id="customer_id">
                                                <option value=" "> -- Choose--</option>
                                                @foreach ($leads as $item)
                                                <option value="{{$item->id}}"> {{$item->name}}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">CNIC </label>
                                            <input type="text" name="cnic" class="form-control" id="cnic">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Phone No </label>
                                            <input type="number" name="phone" class="form-control" id="phone">
                                        </div>
                                    </div>
                                <fieldset>
                            </div> -->
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
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFxypOx1dqnZaFxa7ZxK2-uPMbSzsJQk&libraries=places&callback=initialize" async></script>
<script src="/mapInput.js"></script>

<script>
$(document).ready(function() {
    $('.multiple').select2();
});
    
    $(document).ready(function () {
         
         $('#block').change(function(){
            var project = $('#project').val();
            var block = $(this).val();
                $.ajax({
                    url: "/admin/plot/search",
                    data: {
                         "project": project ,
                         "block": block 
                         },
                    dataType:"html",
                    type: "get",
                    success: function(data){
                      $('#plot').val(data);
                    }
                });
          });
    });   
</script>
   
    
@stop