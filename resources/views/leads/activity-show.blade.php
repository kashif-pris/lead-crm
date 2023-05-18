@extends('voyager::master')


 <style>
    .field{
       display: none;
    }
    .app-container.expanded .app-footer {
    left: 0px;
}
    input[type="file"] {
        /* display: none; */
    }
    .note-btn{
        background: #62a8ea !important;
    }
    #tagator_activate_tagator2{
        width:auto !important;
    }
   .Partnership , .Company{
      display: none;
   }

    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }

    label {
    font-weight: bold !important;
    color: black;
  }
   input.form-control {
      border: 1px solid black;
      color: black;
   }
    
 </style>

 @if(isset($editAgent))
 @if($editAgent->person_type == 0)
 <style>
  .individual{
    display : block;
 }
.Partnership , .Company{
   display : none;
}
</style>
 @elseif($editAgent->person_type == 1)
 <style>
   .Partnership , .Company{
     display : block;
  }
  .individual {
    display : none;
 }
 </style>
 @elseif($editAgent->person_type == 2)
 <style>
   .Company{
     display : block;
  }
 .Partnership , .individual{
    display : none;
 }
 </style>
 @endif
 @endif




  
{{-- @stop --}}

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
            <h3 class = "panel-title">View activity Log </h3>
        </div>
 
        <div class = "panel-body">
 
               <div class="panel-body" id="new_row" >
                  
                  <div class="form-group  col-md-3 ">
                     <label class="control-label" for="name"> Lead Name</label>
                     {{-- <input readonly required="" type="text" class="form-control" name="name" placeholder="" value=""> --}}
                     <select disabled  class="form-control  " name="lead">
                        <option>select option</option>
                        @foreach($leads as $itme )
                     <option   @if(@$itme->id == $events->lead_id) {{'selected'}} @endif value="{{$itme->id}}">{{$itme->name}}</option>
                       
                        @endforeach
                    </select> 
                  </div>
         
                  <div class="form-group  col-md-3 ">
                     <label class="control-label" for="name">Event</label>
                     <input readonly required="" type="text" class="form-control" name="email" placeholder="" value="{{$events->title}}">
                  </div>
            
                  <div class="form-group  col-md-3 ">
                     <label class="control-label" for="name">Start Date</label>
                     <input readonly required="" type="text" class="form-control" name="mobile" placeholder="" value="{{$events->start}}">
                  </div>
               
                  <div class="form-group  col-md-3 ">
                     <label class="control-label" for="name">End Date </label>
                     <input readonly type="text" class="form-control" name="address" required="" step="any" placeholder=""  value="{{$events->end}}">
                  </div>
             
            
      
               </div>
            
            <!-- panel-body -->
        

           {{-- <div class = "row">
            @foreach($investorDetail as $d)
               
            
            <div class="panel-body" id="new_row" >
                  
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Property Name</label>
                  <input readonly required="" type="text" class="form-control" name="name" placeholder="" value="{{$d->property_name}}">
               </div>
               
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Quantity</label>
                  <input readonly required="" type="text" class="form-control" name="email" placeholder="" value="{{$d->quantity}}">
               </div>
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Sale Price</label>
                  <input readonly required="" type="text" class="form-control" name="email" placeholder="" value="{{$d->sale_price}}">
               </div>
               
             
            
               
   
            </div>
            @endforeach
           </div> --}}

            <div class="row">
               <div class="panel-footer">
                  <a href="/admin/investors" class="btn btn-primary save">Back</a>
               </div>
            </div>
     
       
         
    </div>
     
   
      
    

@stop
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

   <script>
      $(document).ready(function(){
            $("#person_type").change(function(){
              var type = this.value;
              if(type == 1){
               $(".Partnership").show();
               $(".Company").show();
               $(".individual").hide();
              } else if (type == 2) {
               $(".Partnership").hide();
               $(".Company").show();
               $(".individual").hide();
              }else if (type == 0) {
               $(".Partnership").hide();
               $(".Company").hide();
               $(".individual").show();
              }else{
               $(".Partnership").hide();
               $(".Company").hide();
               $(".individual").hide();
              }
            });
      });

      
   </script>
   
   <script>
      
      var html = ' <div class="row">\n' +
                                    '<div class="col-lg-12">'+
          '                        <div class="form-group  col-md-3 ">\n' +
          '                            <label class="control-label" for="name">Property Name</label>\n' +
          '                            <input required="" type="text" class="form-control" name="property_name[]" placeholder="Project Name" value="">\n' +
          '                        </div>\n' +
          '                        <!-- GET THE DISPLAY OPTIONS -->\n' +
          '                        <div class="form-group  col-md-3 ">\n' +
          '                            <label class="control-label" for="name">Quantity</label>\n' +
          '                            <input required="" type="text" class="form-control" name="quantity[]" placeholder="Quantity"\n' +
          '                                   value="">\n' +
          '                        </div>\n' +
          '                        <!-- GET THE DISPLAY OPTIONS -->\n' +
          '                        <div class="form-group  col-md-3 ">\n' +
          '                            <label class="control-label" for="name">Sale Price</label>\n' +
          '                            <input required="" type="text" class="form-control" name="sale_price[]" placeholder="Sale Price" value="">\n' +
          '                        </div>\n' +
          '\n' +
          '\n' +
          '                    </div>'+
          '                   </div>';

      $("#addmore").click(function () {


          $('#new_row').append(html);


      });


  </script>


   @stop