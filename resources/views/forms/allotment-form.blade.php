@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/all-amendment-form" class="btn btn-success btn-add-new">
               <span>Allotment Form</span>
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
            <h3 class = "panel-title text-center">Allotment Form</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "{{ route('AllotmentForm') }}" method ="post" enctype = "multipart/form-data">
            <div class="container">
                
                <div class="col-md-12" style="margin-top: 20px">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Registration No <span class="required">*</span> </label>
                                <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Registration No"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date <span class="required">*</span> </label>
                                <input maxlength="100" type="date" required="required" class="form-control"  />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                   
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Name :<span class="required">*</span> </label>
                                <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter  Name"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">House: <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter House" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Address:  <span class="required">*</span> </label> 
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Address"  required=""/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Precinct:  <span class="required">*</span> </label> 
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Precinct"  required=""/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Street:  <span class="required">*</span> </label> 
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Street"  required=""/>
                            </div>
                        </div>
                       
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">CNIC #:<span class="required">*</span> </label>
                                <input type="text"  data-inputmask="'mask': '99999-9999999-9'" maxlength = "12" class="form-control"  placeholder="XXXXX-XXXXXXX-X"  name="cnic" required="" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Size: <span class="required">*</span> </label>
                                <input type="text"   class="form-control" required="required"   placeholder="5 Sq. Yards"  name="cnic" required="" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Contact: <span class="required">*</span> </label>
                                <input type="text"   class="form-control" required="required"   placeholder="XXXX-XXXXXXX"  name="cnic" required="" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Category:  <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control"  />
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" >Submit</button>
            </div> 
        </form>
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

var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

allWells.hide();

navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
            $item = $(this);

    if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-primary').addClass('btn-default');
        $item.addClass('btn-primary');
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
        if (!curInputs[i].validity.valid){
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }

    if (isValid)
        nextStepWizard.removeAttr('disabled').trigger('click');
});

$('div.setup-panel div a.btn-primary').trigger('click');
});
</script>
    <script type="text/javascript">
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 250,   //set editable area's height
                    codemirror: { // codemirror options
                        theme: 'monokai'
                    }
                });
            });
            $(".myselect2").select2();
            $(".myselect").select2({
                multiple: true,
                
            });
            $('#file-upload').bind('change', function() {
            var fileSize = 500000; //500 KB
            var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only formats are allowed : "+fileExtension.join(', '));
                $("#file-upload").css("border-color",'red');
                $("#file-upload").val("");
            }
            if(this.files[0].size > fileSize){
                alert('File size is too large!');
                $("#file-upload").val("");
                $("#file-upload").css("border-color",'red');
            }

            });

            $('.book_title').bind('keyup', function() {
                var Text = $(this).val();
                $('.slug').val(Text.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,''));

            });
         
           
        </script>
   
    
@stop