@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
<link rel="shortcut icon" href="https://hospital.prismatic-technologies.com/assets_web/images/icons/55200e5d48bb4a147cf33a7bb8dd2ff7.png">

<!-- jquery ui css -->
<link href="https://hospital.prismatic-technologies.com/assets/css/jquery-ui.min.css" rel="stylesheet" type="text/css"/>

<!-- Bootstrap --> 
<link href="https://hospital.prismatic-technologies.com/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- Font Awesome 4.7.0 -->
<link href="https://hospital.prismatic-technologies.com/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<!-- semantic css -->
<link href="https://hospital.prismatic-technologies.com/assets/css/semantic.min.css" rel="stylesheet" type="text/css"/> 
<!-- sliderAccess css -->
<link href="https://hospital.prismatic-technologies.com/assets/css/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css"/> 
<!-- slider  -->
<link href="https://hospital.prismatic-technologies.com/assets/css/select2.min.css" rel="stylesheet" type="text/css"/> 
<!-- DataTables CSS -->
<link href="https://hospital.prismatic-technologies.com/assets/datatables/css/dataTables.min.css" rel="stylesheet" type="text/css"/> 
<!-- pe-icon-7-stroke -->
<link href="https://hospital.prismatic-technologies.com/assets/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/> 
<!-- themify icon css -->
<link href="https://hospital.prismatic-technologies.com/assets/css/themify-icons.css" rel="stylesheet" type="text/css"/> 
<!-- Pace css -->
<link href="https://hospital.prismatic-technologies.com/assets/css/flash.css" rel="stylesheet" type="text/css"/>
<!-- Theme style -->
<link href="https://hospital.prismatic-technologies.com/assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- jstree view -->
<link rel="stylesheet" href="https://hospital.prismatic-technologies.com/assets/vakata-jstree/dist/themes/default/style.min.css" />
        <!-- jQuery  -->
<script src="https://hospital.prismatic-technologies.com/assets/js/jquery.min.js" type="text/javascript"></script>
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
    <div class="content"> 

        <!-- alert message -->
                            
                            
                            

        <!-- content -->
         <style type="text/css">
.fa-folder{
color:#D4AC0D;
}
.fa-folder-open-o{
color:#D4AC0D;
}
.dsply{
display: block;;
}
</style> 

 <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                    Chart Of Account                      
                  </div>
                </div>

                <div class="panel-body">
                    <div class="row">
            <div class="col-md-6">
                
                <div id="jstree1" class="jstree jstree-1 jstree-default" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j1_146" aria-busy="false"><ul class="jstree-container-ul jstree-children" role="group"><li role="treeitem" aria-selected="false" aria-level="1" aria-labelledby="j1_1_anchor" aria-expanded="true" id="j1_1" class="jstree-node  jstree-last jstree-open"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="#" tabindex="-1" id="j1_1_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Chart Of Accounts</a><ul role="group" class="jstree-children" style=""><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j1_2_anchor" aria-expanded="false" id="j1_2" class="jstree-node jstree-closed"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('1')" id="j1_2_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Assets</a></li><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j1_63_anchor" aria-expanded="true" id="j1_63" class="jstree-node  jstree-open"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('2')" id="j1_63_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Equity</a><ul role="group" class="jstree-children"><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_64_anchor" aria-expanded="false" id="j1_64" class="jstree-node  jstree-closed"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('202')" id="j1_64_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Reserve &amp; Surplus</a></li><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_66_anchor" aria-expanded="false" id="j1_66" class="jstree-node  jstree-closed jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('201')" id="j1_66_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Share Holders Equity</a></li></ul></li><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j1_69_anchor" aria-expanded="true" id="j1_69" class="jstree-node  jstree-open"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('4')" id="j1_69_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Expence</a><ul role="group" class="jstree-children"><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_70_anchor" id="j1_70" class="jstree-node  jstree-leaf"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('403')" id="j1_70_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Cost of Sale</a></li><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_71_anchor" aria-expanded="false" id="j1_71" class="jstree-node  jstree-closed"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('402')" id="j1_71_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Other Expenses</a></li><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_142_anchor" id="j1_142" class="jstree-node  jstree-leaf"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('404')" id="j1_142_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Sale Discount</a></li><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_143_anchor" aria-expanded="false" id="j1_143" class="jstree-node  jstree-closed jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('401')" id="j1_143_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Store Expenses</a></li></ul></li><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j1_145_anchor" aria-expanded="true" id="j1_145" class="jstree-node  jstree-open"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('3')" id="j1_145_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Income</a><ul role="group" class="jstree-children"><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_146_anchor" aria-expanded="false" id="j1_146" class="jstree-node  jstree-closed"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('302')" id="j1_146_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Other Income</a></li><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_157_anchor" aria-expanded="false" id="j1_157" class="jstree-node  jstree-closed jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('301')" id="j1_157_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Store Income</a></li></ul></li><li role="treeitem" aria-selected="false" aria-level="2" aria-labelledby="j1_161_anchor" aria-expanded="true" id="j1_161" class="jstree-node  jstree-open jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('5')" id="j1_161_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Liabilities</a><ul role="group" class="jstree-children"><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_162_anchor" aria-expanded="false" id="j1_162" class="jstree-node  jstree-closed"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('502')" id="j1_162_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Current Liabilities</a></li><li role="treeitem" aria-selected="false" aria-level="3" aria-labelledby="j1_182_anchor" aria-expanded="false" id="j1_182" class="jstree-node  jstree-closed jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i><a class="jstree-anchor" href="javascript:" tabindex="-1" onclick="loadData('501')" id="j1_182_anchor"><i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom" role="presentation"></i>Non Current Liabilities</a></li></ul></li></ul></li></ul></div>
            </div> 
                            <div class="col-md-6" id="newform">
        <form name="form" id="form" action="https://hospital.prismatic-technologies.com//accounts/accounts/insert_coa" method="post" enctype="multipart/form-data">
            <div id="newData">
        <table width="100%" border="0" cellspacing="0" cellpadding="5">

        <tbody><tr>
        <td>Head Code</td>
        <td><input type="text" name="txtHeadCode" id="txtHeadCode" class="form_input" value="102020102" readonly="readonly"></td>
        </tr>
        <tr>
        <td>Head Name</td>
        <td><input type="text" name="txtHeadName" id="txtHeadName" class="form_input" value="CEO Current A/C">
        <input type="hidden" name="HeadName" id="HeadName" class="form_input" value="CEO Current A/C">
        </td>
        </tr>
        <tr>
        <td>Parent Head</td>
        <td><input type="text" name="txtPHead" id="txtPHead" class="form_input" readonly="readonly" value="Advance"></td>
        </tr>
        <tr>

        <td>Head Level</td>
        <td><input type="text" name="txtHeadLevel" id="txtHeadLevel" class="form_input" readonly="readonly" value="4"></td>
        </tr>
        <tr>
        <td>Head Type</td>
        <td><input type="text" name="txtHeadType" id="txtHeadType" class="form_input" readonly="readonly" value="A"></td>
        </tr>

        <tr>
        <td>&nbsp;</td>
        <td><input type="checkbox" name="IsTransaction" value="1" id="IsTransaction" size="28" onchange="IsTransaction_change();" checked=""><label for="IsTransaction"> IsTransaction</label>
        <input type="checkbox" value="1" name="IsActive" id="IsActive" checked="" size="28"><label for="IsActive"> IsActive</label>
        <input type="checkbox" value="1" name="IsGL" id="IsGL" size="28" onchange="IsGL_change();"><label for="IsGL"> IsGL</label>

        </td>
        </tr>
        <tr>
                <td>&nbsp;</td>
                <td><input type="button" name="btnNew" id="btnNew" value="New" onclick="newdata(102020102)">
                <input type="submit" name="btnSave" id="btnSave" value="Save" disabled="disabled" style="display: none;"> <input type="submit" name="btnUpdate" id="btnUpdate" value="Update"> </td>
            </tr>

        </tbody></table>

        </div></form></div>
                        </div>
        </div> 
        </div>
        </div> 
        </div>

        <script type="text/javascript">
        $(document).ready(function () {
        $('#jstree1').jstree({
        'core' : {
            'check_callback' : true
        },
        'plugins' : [ 'types', 'dnd' ],
        'types' : {
            'default' : {
                'icon' : 'fa fa-folder'
            },
            'html' : {
                'icon' : 'fa fa-file-code-o'
            },
            'svg' : {
                'icon' : 'fa fa-file-picture-o'
            },
            'css' : {
                'icon' : 'fa fa-file-code-o'
            },
            'img' : {
                'icon' : 'fa fa-file-image-o'
            },
            'js' : {
                'icon' : 'fa fa-file-text-o'
            }

        }
        });
        });
        </script>
        <script type="text/javascript">
        function loadData(id){
        // alert(id);
        $.ajax({
        url : "https://hospital.prismatic-technologies.com/accounts/accounts/selectedform/" + id,
        type: "GET",
        dataType: "json",
        success: function(data)
        {
        $('#newform').html(data);
        $('#btnSave').hide();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        alert('Error get data from ajax');
        }
        });
        }


        </script>
        <script type="text/javascript">
        function newdata(id){
        $.ajax({
        url : "https://hospital.prismatic-technologies.com/accounts/accounts/newform/" + id,
        type: "GET",
        dataType: "json",
        success: function(data)
        {
        // console.log(data.headcode);
        console.log(data.rowdata);
        var headlabel = data.headlabel;
        $('#txtHeadCode').val(data.headcode);
        document.getElementById("txtHeadName").value = '';
        $('#txtPHead').val(data.rowdata.HeadName);
        $('#txtHeadLevel').val(headlabel);
        $('#btnSave').prop("disabled", false);
        $('#btnSave').show();
        $('#btnUpdate').hide();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        alert('Error get data from ajax');
        }
        });
        }

        </script>

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
   
 
@stop
<script type="text/javascript">
    function loadData(id){
       // alert(id);
        $.ajax({
            url : "https://hospital.prismatic-technologies.com/accounts/accounts/selectedform/" + id,
            type: "GET",
            dataType: "json",
            success: function(data)
            {
                $('#newform').html(data);
                 $('#btnSave').hide();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    
    </script>
    <script type="text/javascript">
        function newdata(id){
         $.ajax({
            url : "https://hospital.prismatic-technologies.com/accounts/accounts/newform/" + id,
            type: "GET",
            dataType: "json",
            success: function(data)
            {
              // console.log(data.headcode);
               console.log(data.rowdata);
               var headlabel = data.headlabel;
               $('#txtHeadCode').val(data.headcode);
                document.getElementById("txtHeadName").value = '';
                $('#txtPHead').val(data.rowdata.HeadName);
                $('#txtHeadLevel').val(headlabel);
                $('#btnSave').prop("disabled", false);
                 $('#btnSave').show();
                $('#btnUpdate').hide();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    
    </script>
    
                    </div> <!-- /.content -->
                </div> <!-- /.content-wrapper -->
    
                <footer class="main-footer">
                    2021©Copyright            </footer>
            </div> <!-- ./wrapper -->
     
            <!-- jquery-ui js -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/jquery-ui.min.js" type="text/javascript"></script> 
            <!-- bootstrap js -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/bootstrap.min.js" type="text/javascript"></script>  
            <!-- pace js -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/pace.min.js" type="text/javascript"></script>  
            <!-- SlimScroll -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/jquery.slimscroll.min.js" type="text/javascript"></script>  
    
            <!-- bootstrap timepicker -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/jquery-ui-sliderAccess.js" type="text/javascript"></script> 
            <script src="https://hospital.prismatic-technologies.com/assets/js/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script> 
            <!-- select2 js -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/select2.min.js" type="text/javascript"></script>
    
            <script src="https://hospital.prismatic-technologies.com/assets/js/sparkline.min.js" type="text/javascript"></script> 
            <!-- Counter js -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/waypoints.js" type="text/javascript"></script>
            <script src="https://hospital.prismatic-technologies.com/assets/js/jquery.counterup.min.js" type="text/javascript"></script>
    
            <!-- ChartJs JavaScript -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/Chart.min.js" type="text/javascript"></script>
            
            <!-- semantic js -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/semantic.min.js" type="text/javascript"></script>
            <!-- DataTables JavaScript -->
            <script src="https://hospital.prismatic-technologies.com/assets/datatables/js/dataTables.min.js"></script>
            <!-- tinymce texteditor -->
            <script src="https://hospital.prismatic-technologies.com/assets/tinymce/tinymce.min.js" type="text/javascript"></script> 
            <!-- Table Head Fixer -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/tableHeadFixer.js" type="text/javascript"></script> 
    
            <!-- Admin Script -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/frame.js" type="text/javascript"></script> 
    
            <!-- Custom Theme JavaScript -->
            <script src="https://hospital.prismatic-technologies.com/assets/js/custom.js" type="text/javascript"></script>
            <!-- jstree view -->
            <script src="https://hospital.prismatic-technologies.com/assets/vakata-jstree/dist/jstree.min.js"></script>