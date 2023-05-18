@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/merge/record" class="btn btn-success btn-add-new">
               <span>All Mergining History</span>
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
            <h3 class = "panel-title">Create Merge</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "{{url('/admin/merge/update/')."/".$merge['id']}}" method ="post" enctype = "multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-3">
                 <div class="form-group" style="margin-top: 30px">
                     <label class="control-label">Customer Name <span class="required">*</span> </label>
                     <select name="customer" class="form-control" id="customer">
                         <option>--choose</option>
                         @foreach($customers as $item)
                         <option  {{$merge->customers->sal_customer_id == $item->sal_customer_id ? "selected" : ""}}  value="{{$item->sal_customer_id}}">{{$item->sal_customer_name}}</option>
                         @endforeach
                     </select>
                 </div>
             </div>
             <div class="col-md-3">
                <div class="form-group" style="margin-top: 30px">
                    <label class="control-label">Status <span class="required">*</span> </label>
                    <select name="status" class="form-control">
                        @if($merge->status == 1)
                        <option value="1" selected>Approved</option>
                        <option value="0">Un Approved</option>
                        @else
                        <option value="1">Approved</option>
                        <option value="0" selected>Un Approved</option>
                        @endif
                    </select>
                </div>
            </div>
             {{-- <div class="col-md-3">
                 <div class="form-group" style="margin-top: 30px">
                     <label class="control-label">Refernece Num <span class="required">*</span> </label>
                    <input type="text" value="{{$merge->}}" class="form-control" placeholder="ref num" name="ref_num">
                 </div>
             </div>
             <div class="col-md-3">
                 <div class="form-group" style="margin-top: 30px">
                     <label class="control-label">Serial Num <span class="required">*</span> </label>
                    <input type="text" class="form-control" placeholder="Ser num" name="ser_num">
                 </div>
             </div> --}}
             <div class="col-md-3">
                 <div class="form-group" style="margin-top: 30px">
                     <label class="control-label">Transfer Fee </label>
                     <input type="text" value="{{$merge->fee}}" name="fee" class="form-control">
                 </div>
             </div>
             <div class="col-md-3">
                <div class="form-group" style="margin-top: 30px">
                    <label class="control-label">Agents</label>
                    <select name="agent" class="form-control select2">
                        <option> -- Choose -- </option>
                        @foreach($agents as $item)
                        <option value="{{$item->id}}" {{$item->id == $merge->agent_id ? 'selected' : ''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                 </div>
            </div>
           
         </div>

         <div class="row">
            <hr>

            <div class="col-md-3">
                <label class="control-label pull-right">Son Of :  </label>
            </div>
            <div class="col-md-3">
                <label class="badge badge-primery" id="c_so"></label>
            </div>

            <div class="col-md-3">
                <label class="control-label pull-right">Phone :  </label>
            </div>
            <div class="col-md-3">
                <label class="badge badge-warning" id="c_phone"></label><hr>
            </div>

            <div class="col-md-3">
                <label class="control-label pull-right">Email :  </label>
            </div>
            <div class="col-md-3">
                <label class="badge badge-success" id="c_email"></label>
            </div>

            
            <div class="col-md-3">
              
                <label class="control-label pull-right">CNIC :  </label>
            </div>
            <div class="col-md-3">
                <label class="badge badge-danger" id="c_cnic"></label>
            </div>

            


        </div>

          
<div class="row">
<hr>
    <div class="col-md-6">
        <label for="customer">Plot 1</label>
            <select class="form-control select2 " id="plot_1" name="plot_1"  tabindex="-1" aria-hidden="true">
                @foreach($plots as $item)
                <option {{$merge->plotFirst->id == $item->id ? "selected" : ""}} value="{{$item->id}}" >{{$item->name}}</option>
                @endforeach
            </select>
         
          
            {{-- data from ajax --}}
                        <table class="table table-striped"> 
                <tr>
                    <th>Project :</th>
                    <td><label id="project_1"></label></td>
                </tr>
                <tr>
                    <th>Block : </th>
                    <td><label id="block_1"></label></td>
                </tr>
                <tr>
                    <th>Size :</th>
                    <td><label id="size_1"></label></td>
                </tr>
                <tr>
                    <th>Price :<th>
                    <td><label id="price_1"></label></td>
                </tr>
                <tr>
                    <th>Feature :<th>
                    <td><label id="feature_1"></label></td>
                </tr>
            </table>
         </div>
         

            {{-- Plot 2 --}}


            <div class="col-md-6">
                <label for="Plot 2" id="">Plot 2</label>
                    <select class="form-control select2 plot_2" id="plot_2" name="plot_2"  tabindex="-1" aria-hidden="true">
                        @foreach($plots as $item)
                        <option {{$merge->plotSecond->id == $item->id ? "selected" : ""}} value="{{$item->id}}" >{{$item->name}}</option>
                        @endforeach
                    </select>
                 
                  
                    {{-- data from ajax --}}
                    <table class="table table-striped"> 
                        <tr>
                            <th>Project :</th>
                            <td><label id="project_2"></label></td>
                        </tr>
                        <tr>
                            <th>Block : </th>
                            <td><label id="block_2"></label></td>
                        </tr>
                        <tr>
                            <th>Size :</th>
                            <td><label id="size_2"></label></td>
                        </tr>
                        <tr>
                            <th>Price :<th>
                            <td><label id="price_2"></label></td>
                        </tr>
                        <tr>
                            <th>Feature :<th>
                            <td><label id="feature_2"></label></td>
                        </tr>
                    </table>
                 </div>
            </div>




            {{-- documenmts --}}

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="3">From Customer Docs</th>
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
                                 <td><input type="file"  class="form-control from_customer" name="file[]" ></td>
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

         $('#plot_1').change(function(){
                var plot = $('#plot_1').val();
                $.ajax({
                    url: "/admin/application-form/plot/search2",
                    data: {
                         "plot": plot ,
                         },
                    dataType:"json",
                    type: "get",
                            success: function(data){
                                console.log(data)
                            var i;
                            var k;
                            $('#project_1').text(data.project);
                            $('#size_1').text(data.size);
                            $('#price_1').text(data.numprice + " Rs ");
                            $('#block_1').text(data.block);
                            $('#feature_1').html('');
                            for( i = 0 ; i < data.feature.length ; i++){
                                $('#feature_1').append("<label class='badge badge-info' > "+data.feature[i]+" </label> ");
                            }
                            $('.plot_2').html('');
                            for( k = 0 ; k < data.plot_id.length ; k++){
                                $('.plot_2').append('<option value="'+data.plot_id[k]+'" >'+data.plot_name[k]+'</option>');
                            }
                           
                            }
                       });
                 });

                 $('#plot_2').change(function(){
                var plot2 = $('#plot_2').val();
                $.ajax({
                    url: "/admin/application-form/plot/search",
                    data: {
                         "plot": plot2 ,
                         },
                    dataType:"json",
                    type: "get",
                            success: function(data){
                                console.log(data)
                            var i;
                            var k;
                            $('#project_2').text(data.project);
                            $('#size_2').text(data.size);
                            $('#price_2').text(data.numprice + " Rs ");
                            $('#block_2').text(data.block);
                            $('#feature_2').html('');
                            for( i = 0 ; i < data.feature.length ; i++){
                                $('#feature_2').append("<label class='badge badge-info' > "+data.feature[i]+" </label> ");
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