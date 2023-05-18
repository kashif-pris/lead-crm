@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/all-amendment-form" class="btn btn-success btn-add-new">
               <span>Document Requirements</span>
            </a>
        @endcan
        </h1>
        @include('voyager::multilingual.language-selector')
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.css') }}"/>
        <link rel="stylesheet" href="{{ asset('tagsManager/fm.tagator.jquery.min.css') }}"/>
    </div>
 

  
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
            <h3 class = "panel-title text-center">Document Requirements</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "{{ route('documnet.store') }}" method ="post" enctype = "multipart/form-data">
            @csrf
            <div class="container">
                <div class="col-xs-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Select Form <span class="required">*</span> </label>
                                    <select onchange="getDocuments()" class="form-control select2" name="form_id">
                                        <option value="-1">--select--</option>
                                        @forelse($forms as $form)
                                        <option value="{{$form->id}}">{{$form->name}}</option>
                                        @empty    

                                        @endforelse
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-xs-12" style="margin-top: 20px">
                        <div class="col-md-12">
                            <div class="row">
                                <table id="" class="table table-striped table">
                                        <tr>
                                            <th>Display Name Of Document</th>
                                            <th>System Value</th>
                                            <th>Is Required</th>
                                          
                                            <th><a class="btn btn-success" id="add"> + Add More</a></th>

                                        </tr>
                                        <tbody id="dynamicTable">
                                            <tr id="row_0">
                                                <td><input  maxlength="100" name="title[]" type="text" required="required" class="form-control" placeholder="Enter Document Title"  /></td>
                                                <td><input  maxlength="100" name="system[]" type="text" required="required" class="form-control" placeholder="Enter Document System Value"  /></td>
                                                <td>
                                                    
                                                    <input checked type="hidden" value="required" name="required[]" id="check_0"/>
                                                    <input checked type="checkbox" onclick="check(0)"/>
                                                    </td>
                                                <td>
                                                    
                                                </td>

                                            </tr>
                                        </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
             
            </div> 
            <button type="submit" class="btn btn-success float-right">Submit</button>
        </form>
        </div>
    </div>
     
   
      
    

@stop
@section('javascript')

    <script type="text/javascript">
        
            $(".myselect2").select2();
            $(".myselect").select2({
                multiple: true,
                
            });
            var i = 235345344;
            $("#add").click(function(){
                ++i;
                $("#dynamicTable").append(`
                <tr id="row_`+i+`">
                    <td><input  maxlength="100" name="title[]" type="text" required="required" class="form-control" placeholder="Enter Document Title"  /></td>
                    <td><input  maxlength="100" name="system[]" type="text" required="required" class="form-control" placeholder="Enter Document System Value"  /></td>
                    <td>
                        <input checked type="hidden" value="required" name="required[]" id="check_`+i+`"/>
                        <input checked type="checkbox" onclick="check(`+i+`)"  />

                    </td>
                    <td>
                        <a class="btn btn-danger" onclick="deleteRow(`+i+`)"> -Delete</a>
                    </td>

                </tr>
                `);
            });
      
           
        </script>

        <script>
               function deleteRow(rowID){
                let proceed = confirm("Are you sure you want to remove?");
                    if (proceed) {
                        $('#row_'+rowID).remove();
                    } else {
                        return false;
                    }
                    
                }
                function check(id){
                   
                    var c = document.getElementById("check_"+id);
                    console.log(c);
                    if( c.value == 'required'){
                        c.value = 'no';
                    }else{
                        c.value = 'required';

                    }
                        
                }

        function getDocuments(){
            var formID = $('.select2').val();
            $.ajax({
                'url':'/admin/Getdocument/'+formID,
                'method':'GET',
                success:function(data){
                    console.log(data);
                    $("#dynamicTable").html('');
                    var j = 0;
                    for(var j = 0; j < data.length; j++){
                        var t = data[j].is_required;
                        console.log(t);
                        if(t == "required"){
                            var m = "checked";
                        }else{
                            var m = "";
                        }

                        $("#dynamicTable").append(`
                        <tr id="row_`+j+`">
                            <td><input  maxlength="100" name="title[]" value="`+data[j].title+`" type="text" required="required" class="form-control" placeholder="Enter Document Title"  /></td>
                            <td><input  maxlength="100" name="system[]" value="`+data[j].system_value+`" type="text" required="required" class="form-control" placeholder="Enter Document System Value"  /></td>
                            <td>
                                <input checked type="hidden" value="required" name="required[]" id="check_`+j+`"/>
                                
                                <input `+m+` type="checkbox" onclick="check(`+j+`)"  />

                            </td>
                            <td>
                                <a class="btn btn-danger" onclick="deleteRow(`+j+`)"> -Delete</a>
                            </td>

                        </tr>
                        `);
                    }
                 
                }

            })
        }
        </script>
   
    
@stop