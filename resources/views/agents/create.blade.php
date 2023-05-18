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
            <h3 class = "panel-title">Add Agents </h3>
        </div>
 
        <div class = "panel-body">
          @if (isset($editAgent))
          <form role="form" class="form-edit-add" action="{{route('agent.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$editAgent->id}}" name="id">
            <div class="panel-body">
               <!-- Adding / Editing -->
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Name</label>
                  <input required="" type="text" class="form-control" name="name" placeholder="Name" value="{{$editAgent->name}}">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Email</label>
                  <input required="" type="text" class="form-control" name="email" placeholder="Email" value="{{$editAgent->email}}">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">City</label>
                  <input required="" type="text" class="form-control" name="city" placeholder="City" value="{{$editAgent->city}}">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Commission (%)</label>
                  <input type="number" class="form-control" name="commission" required="" step="any" placeholder="Commission (%)" value="{{$editAgent->commission}}">
               </div>
               <div class="form-group  col-md-6 ">
                  <label class="control-label" for="name">Address</label>
                  <input required="" type="text" class="form-control" name="address" placeholder="address" value="{{$editAgent->address}}">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Date Of Birth</label>
                  <input type="date" class="form-control" name="date_of_birth" placeholder="Date Of Birth" value="{{$editAgent->date_of_birth}}">
               </div>
           
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Profile Image</label>
                  <input  type="file" name="avatar" accept="image/*">
                  <img src="{{asset('storage/Files/agents/'.$editAgent->avatar)}}" width="50px">

               </div>

        
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="person_type" >Person Type</label>
                  <select class="form-control" name="person_type" id="person_type">
                     @foreach ($type as $key =>$item)
                      <option value="{{$key}}"  {{$editAgent->person_type == $key ? "selected" : ""}} >{{$item}}</option>
                     @endforeach
                </select>
               </div>
               <div class="form-group " >
                  <div class="form-group  col-md-3 Partnership" >
                     <label class="control-label " for="name">Registration No.</label>
                     <input type="number" class="form-control" name="reg_no"   placeholder="Registration No." value="{{$editAgent->reg_no}}">
                  </div>
                  <div class="form-group  col-md-3 Partnership" >
                     <label class="control-label" for="name">Representative</label>
                     <input type="text" class="form-control" name="representative"   placeholder="Representative" value="{{$editAgent->representative}}">
                  </div>
                  <div class="form-group  col-md-3 Partnership">
                     <label class="control-label" for="name">Momorandom</label>
                     <input type="text" class="form-control" name="momorandom"   placeholder="Memorendom" value="{{$editAgent->momorandom}}">
                     
                  </div>
                  <div class="form-group  col-md-3 Company">
                     <label class="control-label" for="name">Reg Certificate</label>
                     <input type="file" name="reg_certificate" accept="image/*">
                     <img src="{{asset('storage/Files/agents/'.$editAgent->reg_certificate)}}" width="50px">
                  </div>
                  <div class="form-group  col-md-3 individual">
                     <label class="control-label" for="name">Father Name</label>
                     <input  type="text" class="form-control" name="father" placeholder="Father Name" value="{{$editAgent->father}}">
                  </div>
                  <!-- GET THE DISPLAY OPTIONS -->
                  <div class="form-group  col-md-3 individual">
                     <label class="control-label" for="name">CNIC</label>
                     <input  type="text" class="form-control" name="cnic" placeholder="CNIC" value="{{$editAgent->cnic}}">
                  </div>
                  <div class="form-group  col-md-3 individual">
                     <label class="control-label" for="name">Mobile</label>
                     <input type="number" class="form-control" name="mobile"  step="any" placeholder="Mobile" value="{{$editAgent->mobile}}">
                  </div>
                  <!-- GET THE DISPLAY OPTIONS -->
                  <div class="form-group  col-md-3 Company">
                     <label class="control-label " for="name">NTN</label>
                     <input type="file" name="ntn" accept="image/*">
                     <img src="{{asset('storage/Files/agents/'.$editAgent->ntn)}}" width="50px">
                  </div>
                  <!-- GET THE DISPLAY OPTIONS -->
                  <div class="form-group  col-md-3 Partnership">
                     <label class="control-label" for="name">Form 29</label>
                     <input type="file" name="form29" accept="image/*">
                     <img src="{{asset('storage/Files/agents/'.$editAgent->form29)}}" width="50px">
                  </div>
               </div>
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Project</label>
                  <select class="form-control " name="project_id" >
                     @foreach($project as $p)
                     <option value="{{$p->id}}" {{$p->id == $editAgent->id ? "selected" : ""}}>{{$p->project_name}}</option>
                     @endforeach
                  </select>
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-9 ">
                  <label class="control-label" for="name">Description</label>
                  <input type="text" class="form-control" name="description" required=""  placeholder="Description" value="{{$editAgent->description}}">

               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               
               <!-- GET THE DISPLAY OPTIONS -->
            </div>
            <!-- panel-body -->
            <div class="panel-footer">
               <button type="submit" class="btn btn-primary save">Save</button>
            </div>
         </form>
          @else
          <form role="form" class="form-edit-add" action="{{route('agent.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="panel-body">
               <!-- Adding / Editing -->
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Name</label>
                  <input required="" type="text" class="form-control" name="name" placeholder="Name" value="">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Email</label>
                  <input required="" type="text" class="form-control" name="email" placeholder="Email" value="">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">City</label>
                  <input required="" type="text" class="form-control" name="city" placeholder="City" value="">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Commission (%)</label>
                  <input type="number" class="form-control" name="commission" required="" step="any" placeholder="Commission (%)" value="">
               </div>
               <div class="form-group  col-md-6 ">
                  <label class="control-label" for="name">Address</label>
                  <input required="" type="text" class="form-control" name="address" placeholder="address" value="">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Date Of Birth</label>
                  <input type="date" class="form-control" name="date_of_birth" placeholder="Date Of Birth" value="">
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Profile Image</label>
                  <input  type="file" name="avatar" accept="image/*">
               </div>
               
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="person_type" >Person Type</label>
                  <select class="form-control" name="person_type" id="person_type">
                     <option value="0" selected="selected"   data-select2-id="3">Individual</option>
                     <option value="1" >Partnership</option>
                     <option value="2" >Company</option>
                  </select>
               </div>
               <div class="form-group " >
                  <div class="form-group  col-md-3 Partnership" >
                     <label class="control-label " for="name">Registration No.</label>
                     <input type="number" class="form-control" name="reg_no"   placeholder="Registration No." value="">
                  </div>
                  <div class="form-group  col-md-3 Partnership" >
                     <label class="control-label" for="name">Representative</label>
                     <input type="text" class="form-control" name="representative"   placeholder="Representative" value="">
                  </div>
                  <div class="form-group  col-md-3 Partnership">
                     <label class="control-label" for="name">Momorandom</label>
                     <input type="text" class="form-control" name="momorandom"   placeholder="Memorendom" value="">
                  </div>
                  <div class="form-group  col-md-3 Company">
                     <label class="control-label" for="name">Reg Certificate</label>
                     <input type="file" name="reg_certificate" accept="image/*">
                  </div>
                  <div class="form-group  col-md-3 individual">
                     <label class="control-label" for="name">Father Name</label>
                     <input  type="text" class="form-control" name="father" placeholder="Father Name" value="n/a">
                  </div>
                  <!-- GET THE DISPLAY OPTIONS -->
                  <div class="form-group  col-md-3 individual">
                     <label class="control-label" for="name">CNIC</label>
                     <input  type="text" class="form-control" name="cnic" placeholder="CNIC" value="0">
                  </div>
                  <div class="form-group  col-md-3 individual">
                     <label class="control-label" for="name">Mobile</label>
                     <input type="number" class="form-control" name="mobile"  step="any" placeholder="Mobile" value="0">
                  </div>
                  <!-- GET THE DISPLAY OPTIONS -->
                  <div class="form-group  col-md-3 Company">
                     <label class="control-label " for="name">NTN</label>
                     <input type="file" name="ntn" accept="image/*">
                  </div>
                  <!-- GET THE DISPLAY OPTIONS -->
                  <div class="form-group  col-md-3 Partnership">
                     <label class="control-label" for="name">Form 29</label>
                     <input type="file" name="form29" accept="image/*">
                  </div>
               </div>
               <div class="form-group  col-md-3 ">
                  <label class="control-label" for="name">Project</label>
                  <select class="form-control " name="project_id" >
                     @foreach($project as $p)
                     <option value="{{$p->id}}" >{{$p->project_name}}</option>
                     @endforeach
                  </select>
               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               <div class="form-group  col-md-9 ">
                  <label class="control-label" for="name">Description</label>
                  <input type="text" class="form-control" name="description" required=""  placeholder="Description" value="">

               </div>
               <!-- GET THE DISPLAY OPTIONS -->
               
               <!-- GET THE DISPLAY OPTIONS -->
            </div>
            <!-- panel-body -->
            <div class="panel-footer">
               <button type="submit" class="btn btn-primary save">Save</button>
            </div>
         </form>
          @endif
         
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
   
    
@stop