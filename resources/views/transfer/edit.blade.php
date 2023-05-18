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
         
        <form action = "{{url('/admin/transfer/update/')."/".$transfer['id']}}" method ="post" enctype = "multipart/form-data">
    
            @csrf
            <div class="row">
               <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Plot Name <span class="required">*</span> </label>
                        <select name="plot" class="form-control" id="plot">
                            <option>--choose</option>
                            @foreach($plots as $item)
                            <option {{$transfer['plot_id'] == $item->id ? "selected" : ""}} value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Refernece Num <span class="required">*</span> </label>
                       <input value="{{$transfer['ref_num']}}" type="text" class="form-control" placeholder="ref num" name="ref_num">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Serial Num <span class="required">*</span> </label>
                       <input type="text" value="{{$transfer['ser_num']}}" class="form-control" placeholder="Ser num" name="ser_num">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Fee <span class="required">*</span> </label>
                       <input type="text" value="{{$transfer['fee']}}" class="form-control" placeholder="fee" name="fee">
                    </div>
                </div>
        
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Total Balance</label>
                        <input type="text"  id="totalAmount" name="totalAmount" value="{{$transfer['total_amount']}}"  class="form-control">
                     </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-top: 30px">
                        <label class="control-label">Agents</label>
                        <select name="agent" class="form-control select2">
                            <option> -- Choose -- </option>
                            @foreach($agents as $item)
                            <option value="{{$item->id}}" {{$item->id == $transfer['agent_id'] ? 'selected' : ''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                     </div>
                </div>
            </div>



            <div class="row">
                <hr>

                <div class="col-md-2">
                    <label class="control-label pull-right">Plot Project :  </label>
                </div>
                <div class="col-md-2">
                    <label class="badge badge-primery" id="plot_project">{{$transfer->plots->projects->project_name}}</label>
                </div>

                <div class="col-md-2">
                    <label class="control-label pull-right">Plot Block :  </label>
                </div>
                <div class="col-md-2">
                    <label class="badge badge-warning" id="plot_block">{{$transfer->plots->block->name}}</label>
                </div>

                <div class="col-md-2">
                    <label class="control-label pull-right">Plot Size :  </label>
                </div>
                <div class="col-md-2">
                    <label class="badge badge-success" id="plot_size">{{$transfer->plots->sizeGet->name}}</label><hr>
                </div>

                
                <div class="col-md-2">
                  
                    <label class="control-label pull-right">Plot Price :  </label>
                </div>
                <div class="col-md-2">
                    <label class="badge badge-danger" id="plot_price">{{$transfer->plots->price}}</label>
                </div>

                <div class="col-md-2">
                    <label class="control-label pull-right">Plot Features :  </label>
                </div>
                <div class="col-md-4 " id="plot_feature">
                    @foreach($array as $item)
                    <label class="badge badge-info" id="plot_price">{{$item}}</label>
                    @endforeach
                       
                </div>


            </div>
      

            
          
<div class="row">
<hr>
    <div class="col-md-6">
        <label for="customer">Transferer</label>
        
            <select class="form-control  " id="from_customer" name="customer_from"  tabindex="-1" aria-hidden="true">
                @foreach($customers as $item)
                 <option {{$transfer['from_customer'] == $item->sal_customer_id ? "selected" : ""}} value="{{$item->sal_customer_id}}" >{{$item->sal_customer_name}}</option>
                @endforeach
            </select>
         
          
            {{-- data from ajax --}}
            <table class="table table-striped"> 
                <tr>
                    <th>Customer S/O :</th>
                    <td><label class="badge badge-primery" id="c_so">{{$transfer->customerFrom->son_of}}</label></td>
                </tr>
                <tr>
                    <th>Customer Phone : </th>
                    <td><label class="badge badge-primery" id="c_phone">{{$transfer->customerFrom->phone_1}}</label></td>
                </tr>
                <tr>
                    <th>Customer Email :</th>
                    <td><label class="badge badge-primery" id="c_email">{{$transfer->customerFrom->email}}</label></td>
                </tr>
                <tr>
                    <th>Customer Cnic :</th>
                    <td><label class="badge badge-primery" id="c_cnic">{{$transfer->customerFrom->cnic}}</label></td>
                </tr>
            </table>
         </div>
         

            {{-- to --}}


            <div class="col-md-6">
                <label for="customer">Transferee</label>
                    <select class="form-control select2 " id="to_customer" name="customer_to"  tabindex="-1" aria-hidden="true">
                        @foreach($customers as $item)
                        <option {{$transfer['to_customer'] == $item->sal_customer_id ? "selected" : ""}} value="{{$item->sal_customer_id}}" >{{$item->sal_customer_name}}</option>
      
                        @endforeach
                    </select>
                 
                  
                    {{-- data from ajax --}}
                    <table class="table table-striped"> 
                        <tr>
                            <th>Customer S/O :</th>
                            <td><label class="badge badge-primery" id="c_so_to">{{$transfer->customerTo->son_of}}</label></td>
                        </tr>
                        <tr>
                            <th>Customer Phone : </th>
                            <td><label class="badge badge-primery" id="c_phone_to">{{$transfer->customerTo->phone_1}}</label></td>
                        </tr>
                        <tr>
                            <th>Customer Email :</th>
                            <td><label class="badge badge-primery" id="c_email_to">{{$transfer->customerTo->email}}</label></td>
                        </tr>
                        <tr>
                            <th>Customer Cnic :</th>
                            <td><label class="badge badge-primery" id="c_cnic_to">{{$transfer->customerTo->cnic}}</label></td>
                        </tr>
                    </table>
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
                            <th><button type="button" name="add" id="add" class=" btn btn-success">Add More</button></th>
                        </tr>
                        {{-- @dd(dd($transfer->transferNominees)) --}}
                        @foreach($transfer['transferNominees'] as $key => $item)
                        <tr>
                            <td><input type="text" id="freeSpace" value="{{$item['name']}}" name="addmore[{{$key}}][name]" required placeholder="Enter Name..." class="form-control text-field pName" /></td>
                            <td><input type="text" id="freeSpace" value="{{$item['son_of']}}"  name="addmore[{{$key}}][so]" required placeholder="Enter s/o" class="form-control text-field pDesignation" /></td>
                            <td><input type="text" id="freeSpace"   value="{{$item['relation']}}"  name="addmore[{{$key}}][relation]" required placeholder="Enter relation" class="form-control text-field pMobile" /></td>  
                            <td><input type="number" id="freeSpace"  value="{{$item['cnic']}}"  name="addmore[{{$key}}][cnic]" required placeholder="Enter cnic" class="form-control text-field pEmail" /></td>  
                            <td><input type="number" id="freeSpace"  value="{{$item['phone']}}"  name="addmore[{{$key}}][phone]" required placeholder="Enter Phone no 1" class="form-control text-field pPhone" /></td>  
                            <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
                        </tr> 
                        @endforeach 
                      
                    </table>                        
                </div>
               
            </div>

            {{-- documenmts --}}

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="3">Transferer Docs</th>
                              </tr>
                          <tr>
                            <th>Title</th>
                            <th>File</th>
                            <th>View</th>
                          </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($doc as $item)
                                       
                            <tr>
                                <td>{{$item->title}}</td>
                                 <td><input type="file"  class="form-control from_customer" name="file_from[]" ></td>
                                 <td><a href="{{"/".$item->path."/".$item->file}}" class="badge badge-primery" target="-blank">View</a></td>
                                <input type="hidden"  class="form-control" name="file_id_from[]" value="{{$item->new}}" >
                                <input type="hidden"  class="form-control" name="formID_from[]" value="{{$item->form_id}}" >
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
                            <th>View</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($to as $item)
                             <tr>
                                <td>{{$item->title}}</td>
                                 <td><input type="file"   class="form-control to_customer" name="file_to[]" ></td>
                                 <td><a href="{{"/".$item->path."/".$item->file}}" class="badge badge-primery" target="-blank">View</a></td>
                                <input type="hidden"  class="form-control" name="file_id_to[]" value="{{$item->new}}" >
                                <input type="hidden"  class="form-control" name="formID_to[]" value="{{$item->form_id}}" >
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
     
   
      
    

@stop
@section('javascript')

    
    <script type="text/javascript">
            $(document).ready(function() {


                $('#from_customer').change(function(){
                    
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



                $('#to_customer').change(function(){
                    $(".to_customer").attr('required',true);
                   var customer = $('#to_customer').val();
                  
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



                // $('#plot').change(function(){
                // var plot = $('#plot').val();
                // $.ajax({
                //     url: "/admin/application-form/plot/search",
                //     data: {
                //          "plot": plot ,
                //          },
                //     dataType:"json",
                //     type: "get",
                //             success: function(data){
                //             var i;
                //             $('#plot_project').text(data.project);
                //             $('#plot_size').text(data.size);
                //             $('#plot_price').text(data.numprice + " Rs ");
                //             $('#plot_price_input').val(data.price);
                //             $('#plot_block').text(data.block);
                //             $('#plot_feature').html('');
                //             for( i = 0 ; i < data.feature.length ; i++){
                //                 $('#plot_feature').append("<label class='badge badge-info' > "+data.feature[i]+" </label> ");
                //                 }
                //             }
                //        });
                //  });

                $('#plot').change(function(){
                var plot = $('#plot').val();
                $.ajax({
                    url: "/admin/transfer/plot/search",
                    data: {
                         "plot": plot ,
                         },
                    dataType:"json",
                    type: "get",
                            success: function(data){
                            var i;
                            $('#c_so').text(data.son_of);
                            $('#c_phone').text(data.phone);
                            $('#c_email').text(data.email);
                            $('#c_cnic').text(data.cnic);
                            $('#plot_project').text(data.project);
                            $('#plot_size').text(data.size);
                            $('#plot_price').text(data.numprice + " Rs ");
                            $('#plot_price_input').val(data.price);
                            $('#plot_block').text(data.block);
                            $('#from_customer').html();
                            $('#from_customer').html(data.html);
                            $('#plot_feature').html('');
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