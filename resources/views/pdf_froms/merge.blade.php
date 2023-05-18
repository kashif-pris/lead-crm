<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>
.col-md-1 {width:8%;  float:left;}
.col-md-2 {width:16%; float:left;}
.col-md-3 {width:25%; float:left;}
.col-md-4 {width:33%; float:left;}
.col-md-5 {width:42%; float:left;}
.col-md-6 {width:50%; float:left;}
.col-md-7 {width:58%; float:left;}
.col-md-8 {width:66%; float:left;}
.col-md-9 {width:75%; float:left;}
.col-md-10{width:83%; float:left;}
.col-md-11{width:92%; float:left;}
.col-md-12{width:100%; float:left;} 
 
  table, td, th {
  border: 1px solid black;
}

table {
    width: 64%;
    border-collapse: collapse;
}
.row{
    text-align: left;
}
span.bb {
    border-bottom: 2px solid black;
}
.container {
  position: relative;
  text-align: center;
 
}

.bottom-left {
    position: absolute;
    bottom: 2px;
    left: 6%;
    color: black;
    background: #ffe499;
    font-size: 28px;
}
.top-right {
    position: absolute;
    top: 13px;
    right: 6%;
    color: black;
    FONT-SIZE: 28PX;
    background: #ffe499;
}
input[type=checkbox] {
    transform: scale(2);
    margin-right: 20px !important;
}
  </style>
  <div class="container">
      <div class="row">
          <div class="col-md-2">
            <img src="{{asset('storage/images/logo.png')}}" alt="Snow" id="img" height="150px">
          </div>
          <div class="col-md-3"></div>
            <div class="col-md-4  ">
              <h1>DEFENCE CITY</h1>
              <H1>merge Form</H1>
          </div>
      </div>
      <div class="row mt-5">
          <div class="col-md-12">
            <h5>REF NO : <span class="bb" > {{$merge['ref_num']}}</span></h5>
          </div>
          <div class="col-md-12">
            <h5>Sr. No :  <span class="bb">{{$merge['ser_num']}}</span></h5>
          </div>
          <div class="col-md-12 mt-5">
            <h5>PLOT DETAILS:</h5>
   
                <div class="row" style="display:flex;margin-bottom:15px; ">
                    <div class="col-md-3">
                    <h5 class="control-label">Plot Size: <sub style=" font-size: 9px; ">(RESIDENTAL)</sub> <span class="required">*</span> </h5>
                    </div> 
                    
                    @foreach ($categories as $item)
                    <div class="col-md-2">
                        <div class="form-check form-check-inline">
                            @if($merge['plots']['status'] == "residential")
                        <input class="form-check-input" {{$item->id == $merge['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
                        @else
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">

                        @endif
                        <label class="form-check-label" for="inlineCheckbox7">{{$item->name}}</label>
                        </div>
                    </div>
                    @endforeach
                
                </div>
              </div>
            </div>

                <div class="row" style=" display: flex; margin-bottom:15px;">
                    <div class="col-md-3">
                        <h5 class="control-label">Plot Size: <sub style=" font-size: 9px; ">(COMMERCIAL)</sub> <span class="required">*</span> </h5>
                    </div>
            
                        @foreach ($categories as $item)
                        <div class="col-md-2">
                            <div class="form-check form-check-inline">
                                @if($merge['plots']['status'] == "commercial")
                            <input class="form-check-input" {{$item->id == $merge['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
                            @else
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
                            @endif 
                            <label class="form-check-label" for="inlineCheckbox7">{{$item->name}}</label>
                            </div>
                        </div>
                        @endforeach
            
                   </div>
            
                   <div class="row" style=" display: flex;margin-bottom:15px; ">
                    <div class="col-md-3">
                        <h5 class="control-label">Preference of plot: <span class="required">*</span> </h5>
                    </div>
                    <div class="col-md-9" style="display: inline-flex; position: relative; left: 45px;">
                        @foreach($feature as $item)
                          <div class="col-md-2">
                          <div class="form-check form-check-inline">
                              @if(isset($feature_array))
                          <input class="form-check-input" {{in_array($item->id,$feature_array) ? "checked" : ""}}   type="checkbox" id="inlineCheckbox12" value="{{$item->id}}" required="required">
                          <label class="form-check-label" for="inlineCheckbox12">{{$item->name}}</label>
                          @else
                          <input class="form-check-input"   type="checkbox" id="inlineCheckbox12" value="{{$item->id}}" required="required">
                          <label class="form-check-label" for="inlineCheckbox12">{{$item->name}}</label>
                          @endif
                          </div>
                      </div>
                      @endforeach
                     
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                       <h3>PERSONAL INFORMATION of mergeor:</h3><hr>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Name of Applicant:<span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <input  maxlength="100" type="text" value="{{$merge['customer_from']['name']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">Father/Husband Name: <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9  mb-3">
                        <input  maxlength="100" type="text"  value="{{$merge['customer_from']['son_of']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">CNIC #: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                    </div>
                    <div class="col-md-3  mb-3">
                        <input  maxlength="100" type="text"   value="{{$merge['customer_from']['cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3 pl-5">
                        <label class="control-label">Passport no: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                    </div>
                    <div class="col-md-3  mb-3">
                        <input  maxlength="100" type="text"    value="{{$merge['customer_from']['passport_num']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">Email: <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <input  maxlength="100" type="text" value="{{$merge['customer_from']['son_of']}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">Mailing Address:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <input  maxlength="100" type="text" value="{{$merge['customer_from']['mail_address']}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3"></div>
                        <div class="col-md-1">
                        <label class="control-label">Phone:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input  maxlength="100" type="text" value="{{$merge['customer_from']['phone_1']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-1">
                        <label class="control-label">Res:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input  maxlength="100" type="text" value="{{$merge['customer_from']['permanent_address']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-1">
                        <label class="control-label">Mobile:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input  maxlength="100" type="text" value="{{$merge['customer_from']['phone_2']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>
              </div>


              <div class="row">
                <div class="col-md-12">
                   <h3>PERSONAL INFORMATION of mergeee:</h3><hr>
                </div>
                <div class="col-md-3">
                    <label class="control-label">Name of Applicant:<span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-3">
                    <input  maxlength="100" type="text" value="{{$merge['customer_to']['name']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Father/Husband Name: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9  mb-3">
                    <input  maxlength="100" type="text"  value="{{$merge['customer_to']['son_of']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">CNIC #: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                </div>
                <div class="col-md-3  mb-3">
                    <input  maxlength="100" type="text"   value="{{$merge['customer_to']['cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3 pl-5">
                    <label class="control-label">Passport no: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                </div>
                <div class="col-md-3  mb-3">
                    <input  maxlength="100" type="text"    value="{{$merge['customer_to']['passport_num']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Email: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-3">
                    <input  maxlength="100" type="text" value="{{$merge['customer_to']['son_of']}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Mailing Address:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-3">
                    <input  maxlength="100" type="text" value="{{$merge['customer_to']['mail_address']}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3"></div>
                    <div class="col-md-1">
                    <label class="control-label">Phone:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-2 mb-3">
                    <input  maxlength="100" type="text" value="{{$merge['customer_to']['phone_1']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-1">
                    <label class="control-label">Res:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-2 mb-3">
                    <input  maxlength="100" type="text" value="{{$merge['customer_to']['permanent_address']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-1">
                    <label class="control-label">Mobile:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-2 mb-3">
                    <input  maxlength="100" type="text" value="{{$merge['customer_to']['phone_2']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>
          </div>
             {{-- Nominee --}}
             @foreach($merge['merge_nominees']  as $key => $item)
             
             <div class="row">
                <div class="col-md-12" >
                    <h3>NOMINEE {{$key + 1}} INFORMATION:</h3>
                </div>
                   <div class="col-md-3" >
                        <label class="control-label">Name of Nominee:<span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9 mb-4" >
                         <input  maxlength="100" type="text" required="required" class="form-control" value="{{$item['name']}}" placeholder="Enter Nominee Name" style=" width: 680px; height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>
        
                <div class="col-md-3">
                    <label class="control-label">Father /Husband Name: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-4">
                     <input  maxlength="100" type="text" required="required" class="form-control"  value="{{$item['son_of']}}"  placeholder="Enter Nominee Name" style=" width: 680px; height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Nominee CNIC #: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-4">
                     <input  maxlength="100" type="text" required="required" class="form-control"  value="{{$item['cnic']}}"  placeholder="Enter Nominee Name" style=" width: 680px; height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Nominee Phone: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-4">
                     <input  maxlength="100" type="text" required="required" class="form-control"   value="{{$item['phone']}}"  placeholder="Enter Nominee Name" style=" width: 680px; height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Relationship with Applicant: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-4">
                     <input  maxlength="100" type="text" required="required" class="form-control" value="{{$item['relation']}}"   placeholder="Enter Nominee Name" style=" width: 680px; height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>
                
            </div>
            @endforeach
  
                <div class="row" style="display: flex;margin-bottom: 20px">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Total Price PKR <sub style="font-size: 9px">(cost of land)</sub><span class="required">*</span> </label>
                            <input  maxlength="100" value="{{$booking[0]['amount']}}" type="text" required="required" class="form-control" placeholder="Enter Amount" style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; " />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label"> Paid Amount PKR <span class="required">*</span> </label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Amount"style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; "/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">To be Paid Amount PKR <span class="required">*</span> </label>
                            <input  maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Amount"  style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; "/>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;margin-bottom: 20px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">merge through <span class="required">*</span> </label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Name" style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; "/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Code: <span class="required">*</span> </label>
                            <input maxlength="100" type="text" required="required" class="form-control" placeholder="Enter Code Name" style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; "/>
                        </div>
                    </div>
                    <div class="col-md-12" style="display: flex;">
                        <div class="col-md-4">
                            <label class="control-label"> Payment plan option: <span class="required">*</span> </label>
                        </div>
                        <div class="col-md-8" style="display: flex;">
                            <div class="col-md-1">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox16" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox16">1</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox17" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox17">2</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox17" value="option1" required="required">
                                <label class="form-check-label" for="inlineCheckbox17">2</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;">
                    <b style="margin-bottom: 12px;">Possession of the plots shall be given after the complete payment(s) has been received
                         including the development charges 
                        and <br>any other charges levied by DEFENCE CITY from time to time.
                        </b>
            
        <div  style="border: 1px solid black;">
          <h3 style="text-align: center;">Declaration</h3>
          <p>I do hereby acknowledge, agree and abide by all the present and future terms and conditions / rules and regulations 
            made by DEFENCE CITY .</p>
          <div class="row" style="display: flex;">
            <div class="col-md-6">
              <p>Signature of mergeee and Thumb Impression:_____________________</p>
            </div>
            <div class="col-md-6">
              <p >Date:_____________________</p>
            </div>
          </div>
        </div>
       


</div>
<div style="margin: 100px">
<button id="print" class="btn btn-info" onclick="Pr()">print</button>
        @if($merge['status'] == 0)
        <a id="approve" href="/admin/merge/approve/{{$id}}" class="btn btn-success">Approve</a>
        @else
        <a id="approve" href="/admin/merge/unapprove/{{$id}}" class="btn btn-warning">Un Approve</a>
        @endif
</div>
<script>
    function Pr(){
      $("#print,#approve").hide();
            print();
         location.reload();
    }
</script>