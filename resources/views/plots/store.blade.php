@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> @can('add', app($dataType->model_name))
            <a href="/admin/all-amendment-form" class="btn btn-success btn-add-new">
               <span>Application Form</span>
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
.stepwizard-step p {
    margin-top: 10px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
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
            <h3 class = "panel-title text-center">Application Form</h3>
        </div>
        
        <div class = "panel-body">
        <form action = "{{ route('ApplicationForm') }}" method ="post" enctype = "multipart/form-data">
            <div class="container">
                <div class="col-xs-12" style="margin-top: 20px">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Refrence No <span class="required">*</span> </label>
                                    <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Refrence No"  />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Serial No <span class="required">*</span> </label>
                                    <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Serial No" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <h3><u>PLOT DETAILS</u> </h3>
                            <div class="col-md-2">
                                <label class="control-label">Plot Size: <sub style=" font-size: 9px; ">(RESIDENTAL)</sub> <span class="required">*</span> </label>
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" required="required">
                                    <label class="form-check-label" for="inlineCheckbox1">3 MARLA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option1" required="required">
                                    <label class="form-check-label" for="inlineCheckbox2">5 MARLA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option1" required="required">
                                    <label class="form-check-label" for="inlineCheckbox3">7 MARLA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="option1" required="required">
                                    <label class="form-check-label" for="inlineCheckbox4">8 MARLA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="option1" required="required">
                                    <label class="form-check-label" for="inlineCheckbox5">10 MARLA</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="option1" required="required">
                                    <label class="form-check-label" for="inlineCheckbox6">20 MARLA</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">Plot Size: <sub style=" font-size: 9px; ">(COMMERCIAL)</sub> <span class="required">*</span> </label>
                            </div>
                            <div class="col-md-10">
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox7">3 MARLA</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox8" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox8">4 MARLA</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox9" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox9">5 MARLA</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox10" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox10">5.3 MARLA</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox11" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox11">8 MARLA</label>
                                </div>
                            </div>
                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">Preference of plot: <span class="required">*</span> </label>
                            </div>
                            <div class="col-md-10">
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox12" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox12">Normal</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox13" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox13">Corner <sub>(10% extra charges)</sub></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox14" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox14">Boulevard <sub>(10% extra charges)</sub></label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox15" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox15">Facing Park <sub>(10% extra charges)</sub></label>
                                </div>
                            </div>
                            
                            
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <h3><u>PERSONAL INFORMATION</u></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Name of Applicant:<span class="required">*</span> </label>
                                <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Applicant Name"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Father/Husband Name: <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">CNIC #: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span> </label>
                                <input type="text"  data-inputmask="'mask': '99999-9999999-9'" maxlength = "12" class="form-control"  placeholder="XXXXX-XXXXXXX-X"  name="cnic" required="" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Passport no: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span> </label>
                                <input type="text"  data-inputmask="'mask': '99999-9999999-9'" maxlength = "12" class="form-control"  placeholder="XXXXX-XXXXXXX-X"  name="cnic" required="" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Email: <span class="required">*</span> </label>
                                <input type="text"   class="form-control" required="required"   placeholder="sample@email.com"  name="cnic" required="" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Mailing Address:  <span class="required">*</span> </label> 
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Mailing Address"  required=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Phone: <span class="required">*</span> </label>
                                <input type="text"   class="form-control" required="required"   placeholder="XXXX-XXXXXXX"  name="cnic" required="" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Res:  <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control"  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Mobile:  <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="XXXX-XXXXXXX" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3><u>NOMINEE INFORMATION</u></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Name of Nominee:<span class="required">*</span> </label>
                                <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Nominee No"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Father/Husband Name: <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nominee CNIC #:<span class="required">*</span> </label>
                                <input type="text"  data-inputmask="'mask': '99999-9999999-9'" maxlength = "12" class="form-control"  placeholder="XXXXX-XXXXXXX-X"  name="cnic" required="" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Relationship with Applicant: <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h3><u>PAYMENT DETAILS</u></h3>
                    <div class="row">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-10">
                            <div class="col-md-5">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox16" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox16">Lump Sum Payment (100%)</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox17" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox17">Other</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">DD/Pay Order # <span class="required">*</span> </label>
                                <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Applicant Name"  />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Cash Receipt #: <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Dated: <span class="required">*</span> </label>
                                <input  maxlength="100" type="date" required="required" class="form-control" placeholder=""  />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Bank: <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Bank Name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Branch: <span class="required">*</span> </label>
                                <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Branch Name" />
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="submit" >Submit</button>
                </div>
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