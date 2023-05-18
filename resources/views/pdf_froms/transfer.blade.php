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
              <H1>Transfer Form</H1>
          </div>
          <div class="col-md-2">
            <div class="card">
                @if($transfer['qr_code'] == '')
                @else
                <img class="card-img-top" style="margin-top:20px" src="{{$transfer['qr_code']}}" alt="Card image cap">
                @endif
            </div>
        </div>
      </div>
      <div class="row mt-5">
          <div class="col-md-12">
            <h5>REF NO : <span class="bb" > {{$transfer['ref_num']}}</span></h5>
          </div>
          <div class="col-md-12">
            <h5>Sr. No :  <span class="bb">{{$transfer['ser_num']}}</span></h5>
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
                            @if($transfer['plots']['status'] == "residential")
                        <input class="form-check-input" {{$item->id == $transfer['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
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
                                @if($transfer['plots']['status'] == "commercial")
                            <input class="form-check-input" {{$item->id == $transfer['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
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
                       <h3>PERSONAL INFORMATION of Transferor:</h3><hr>
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Name of Applicant:<span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <input  maxlength="100" type="text" value="{{$transfer['customer_from']['sal_customer_name']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">Father/Husband Name: <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9  mb-3">
                        <input  maxlength="100" type="text"  value="{{$transfer['customer_from']['sal_customer_cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">CNIC #: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                    </div>
                    <div class="col-md-3  mb-3">
                        <input  maxlength="100" type="text"   value="{{$transfer['customer_from']['sal_customer_cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3 pl-5">
                        <label class="control-label">Passport no: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                    </div>
                    <div class="col-md-3  mb-3">
                        <input  maxlength="100" type="text"    value="{{$transfer['customer_from']['sal_customer_cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">Email: <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <input  maxlength="100" type="text" value="{{$transfer['customer_from']['sal_customer_cnic']}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3">
                        <label class="control-label">Mailing Address:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <input  maxlength="100" type="text" value="{{strip_tags($transfer['customer_from']['sal_customer_email'])}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-3"></div>
                        <div class="col-md-1">
                        <label class="control-label">Phone:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input  maxlength="100" type="text" value="{{$transfer['customer_from']['sal_customer_cell']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-1">
                        <label class="control-label">Res:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input  maxlength="100" type="text" value="{{$transfer['customer_from']['sal_customer_address_1']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>

                    <div class="col-md-1">
                        <label class="control-label">Mobile:  <span class="required">*</span> </label>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input  maxlength="100" type="text" value="{{$transfer['customer_from']['sal_customer_cell']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                    </div>
              </div>


              <div class="row">
                <div class="col-md-12">
                   <h3>PERSONAL INFORMATION of Transferee:</h3><hr>
                </div>
                <div class="col-md-3">
                    <label class="control-label">Name of Applicant:<span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-3">
                    <input  maxlength="100" type="text" value="{{$transfer['customer_to']['sal_customer_name']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Father/Husband Name: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9  mb-3">
                    <input  maxlength="100" type="text"  value="{{$transfer['customer_to']['sal_customer_cont_person']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">CNIC #: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                </div>
                <div class="col-md-3  mb-3">
                    <input  maxlength="100" type="text"   value="{{$transfer['customer_to']['sal_customer_cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3 pl-5">
                    <label class="control-label">Passport no: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                </div>
                <div class="col-md-3  mb-3">
                    <input  maxlength="100" type="text"    value="{{$transfer['customer_to']['sal_customer_cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Email: <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-3">
                    <input  maxlength="100" type="text" value="{{$transfer['customer_to']['sal_customer_cont_person']}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3">
                    <label class="control-label">Mailing Address:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-9 mb-3">
                    <input  maxlength="100" type="text" value="{{strip_tags($transfer['customer_to']['sal_customer_address_1'])}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-3"></div>
                    <div class="col-md-1">
                    <label class="control-label">Phone:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-2 mb-3">
                    <input  maxlength="100" type="text" value="{{$transfer['customer_to']['sal_customer_cell']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-1">
                    <label class="control-label">Res:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-2 mb-3">
                    <input  maxlength="100" type="text" value="{{strip_tags($transfer['customer_to']['sal_customer_address_1'])}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>

                <div class="col-md-1">
                    <label class="control-label">Mobile:  <span class="required">*</span> </label>
                </div>
                <div class="col-md-2 mb-3">
                    <input  maxlength="100" type="text" value="{{$transfer['customer_to']['sal_customer_cell']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                </div>
          </div>
             {{-- Nominee --}}
             @foreach($transfer['transfer_nominees']  as $key => $item)
             
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Total Price PKR <sub style="font-size: 9px">(cost of land)</sub><span class="required">*</span> </label>
                            <input  maxlength="100" value="{{@$booking[0]['amount']}}" type="text" required="required" class="form-control" placeholder="Enter Amount" style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; " />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label"> Paid Amount PKR <span class="required">*</span> </label>
                            <input maxlength="100" value="{{@$booking[0]['amount'] - $transfer['remaining_amount']}}" type="text" required="required" class="form-control" placeholder="Enter Amount"style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; "/>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">To be Paid Amount PKR <span class="required">*</span> </label>
                            <input  maxlength="100" value="{{$transfer['remaining_amount']}}" type="text" required="required" class="form-control" placeholder="Enter Amount"  style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; "/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">down Payment <span class="required">*</span> </label>
                            <input  maxlength="100" value="{{$downPayment}}" type="text" required="required" class="form-control" placeholder="Enter Amount"  style=" width: 130px; height: 33px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;margin-left: 0px; "/>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;margin-bottom: 20px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Transfer through <span class="required">*</span> </label>
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
                                <label class="form-check-label" for="inlineCheckbox17">3</label>
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
              <p>Signature of Transferee and Thumb Impression:_____________________</p>
            </div>
            <div class="col-md-6">
              <p >Date:_____________________</p>
            </div>
          </div>
        </div>
       


</div>
<div style="margin: 100px">
<button id="print" class="btn btn-info" onclick="Pr()">print</button>
<a id="approve" href="/admin/transfer/approve/{{$id}}" class="btn btn-success">Approve</a>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Reject</button>
</div>


        {{-- model --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Reject Form</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{route('transfer.reject')}}">
                    @csrf
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label right" style="float: left">Subject:</label>
                      <input type="text" class="form-control" id="recipient-name" name="subject">
                      <input type="hidden" class="form-control" name="id" value="{{$transfer['id']}}">
                      <input type="hidden" class="form-control" id="path" name="path" value="">
                    </div>
                    <div class="form-group">
                      <label for="message-text" class="col-form-label" style="float: left">Message:</label>
                      <textarea class="form-control" id="message-text" name="message"></textarea>
                    </div>
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Send message</button>
                </div>
              </form>
              </div>
            </div>
          </div>
        {{-- model-end --}}

</div>

<script>
    $("#path").val(window.location.pathname);  
    function Pr(){
      $("#print,#approve").hide();
            print();
         location.reload();
    }
</script>