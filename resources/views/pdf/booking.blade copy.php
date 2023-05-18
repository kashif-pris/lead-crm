

<style>
  .col-md-1 {width:8%;  }
  .col-md-2 {width:16%; }
  .col-md-3 {width:25%; }
  .col-md-4 {width:33%; }
  .col-md-5 {width:42%; }
  .col-md-6 {width:50%; }
  .col-md-7 {width:58%; }
  .col-md-8 {width:66%; }
  .col-md-9 {width:75%; }
  .col-md-10{width:83%; }
  .col-md-11{width:92%; }
  .col-md-12{width:100%;} 
   
 .fl{
    float: left;
    display: flex;
    flex-direction: column;
 }
  
  table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
  }
  
  span.bb {
      border-bottom: 2px solid black;
  }
  .container {
    position: relative;
    text-align: center;
    margin: 0% 12%
   
  }

  
  .bottom-left {
      position: absolute;
      bottom: 2px;
      left: 8%;
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
  .mt-2{
      margin-top: 20px;
  }
  .mt-5{
      margin-top: 50px;
  }
  .mb-5{
      margin-top: 50px;
  }
    </style>
    <div class="container">
        <table class="table">
            <tr>
                <td style="margin-left: 100px"><img src="{{public_path('storage\images\logo.png')}}" alt="Snow" id="img" height="150px"></td>
                <td>
                    <h1>DEFENCE CITY</h1>
                    <H1>APPLICATION</H1>
                </td>
            </tr>
       
        </table>
        <div class="col-md-3">
            <h5>REF NO : <span class="bb" > {{$booking['ref_num']}}</span></h5>
            <h5>Sr. No :  <span class="bb">{{$booking['ser_num']}}</span></h5>
        </div>
        <br>
        <div class="col-md-3">
            <h3>PLOT DETAILS:</h3>
        </div>

        

        <div class="row" style=" display: flex;margin-bottom:15px; ">
            <div class="col-md-3">
                <h4 class="control-label">Plot Size: <sub style=" font-size: 9px; ">(RESIDENTAL)</sub> </h4>
            </div>
            <div class="col-md-9" style="display: inline-flex; position: relative; left: 45px;">
                    @foreach ($categories as $item)
                    <div class="col-md-10 fl"> 
                        <div class="form-check form-check-inline">
                            @if($booking['plots']['status'] == "residential")
                        <input class="form-check-input" {{$item->id == $booking['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
                        @else
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
        
                        @endif
                        <label class="form-check-label" for="inlineCheckbox7">{{$item->name}}</label>
                        </div>
                    </div>
                  @endforeach
          </div>
        </div>

        <div class="row" style=" display: flex;margin-bottom:15px; ">
            <div class="col-md-3">
                <h4 class="control-label">Plot Size:  <sub style=" font-size: 9px; ">(COMMERCIAL)</sub> </h4>
            </div>
            <div class="col-md-9" style="display: inline-flex; position: relative; left: 45px;">
                @foreach ($categories as $item)
                <div class="col-md-10 fl">
                    <div class="form-check form-check-inline">
                        @if($booking['plots']['status'] == "commercial")
                    <input class="form-check-input" {{$item->id == $booking['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
                    @else
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
                    @endif 
                    <label class="form-check-label" for="inlineCheckbox7">{{$item->name}}</label>
                    </div>
                </div>
                @endforeach
          </div>
        </div>

        <div class="row" style=" display: flex;margin-bottom:15px; ">
            <div class="col-md-3">
                <h4 class="control-label">Preference of plot: <span class="required">*</span> </h4>
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
                         <h3>PERSONAL INFORMATION:</h3><hr>
                      </div>
                      <div class="col-md-3 fl">
                          <label class="control-label">Name of Applicant:<span class="required">*</span> </label>
                      </div>
                      <div class="col-md-9 fl">
                          <input  maxlength="100" type="text" value="{{$booking['customers']['name']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
  
                      <div class="col-md-3 fl mt-2">
                          <label class="control-label">Father/Husband Name: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-9  fl mt-2">
                          <input  maxlength="100" type="text"  value="{{$booking['customers']['son_of']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
  
                      <div class="col-md-3  fl mt-2">
                          <label class="control-label">CNIC #: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                      </div>
                      <div class="col-md-3   fl mt-2">
                          <input  maxlength="100" type="text"   value="{{$booking['customers']['cnic']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
  
                      <div class="col-md-3  fl mt-2">
                          <label class="control-label">Passport no: <sub style="font-size: 9px">(copy attached)</sub> <span class="required">*</span></label>
                      </div>
                      <div class="col-md-3  fl mt-2">
                          <input  maxlength="100" type="text"    value="{{$booking['customers']['passport_num']}}" required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
  
                      <div class="col-md-3  fl mt-2">
                          <label class="control-label">Email: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-9  fl mt-2">
                          <input  maxlength="100" type="text" value="{{$booking['customers']['son_of']}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
  
                      <div class="col-md-3  fl mt-2">
                          <label class="control-label">Mailing Address:  <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-9  fl mt-2">
                          <input  maxlength="100" type="text" value="{{strip_tags($booking['customers']['mail_address'])}}"   required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
                      <div class="col-md-2  fl mt-2">
                          <label class="control-label">Phone:  <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  fl mt-2">
                          <input  maxlength="100" type="text" value="{{$booking['customers']['phone_1']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
  
                      <div class="col-md-2  fl mt-2">
                          <label class="control-label">Res:  <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  fl mt-2">
                          <input  maxlength="100" type="text" value="{{strip_tags($booking['customers']['permanent_address'])}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
  
                      <div class="col-md-2  fl mt-2">
                          <label class="control-label">Mobile:  <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  fl mt-2">
                          <input  maxlength="100" type="text" value="{{$booking['customers']['phone_2']}}"  required="required" class="form-control" placeholder="Enter Applicant Name" style=" height: 33px; position: relative; left: 28px;    border: 2px solid black; "  />
                      </div>
                </div>
               {{-- Nominee --}}
               @foreach($booking['nominees']  as $key => $item)
               
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
              {{-- end nominee --}}


              <div class="row fl mt-5 ">
                <div class="col-md-3 " >
                    <h3>PAYMENT DETAILS:</h3>
                </div>
                <div class="col-md-9"></div>
                <div class="col-md-12">
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" {{$booking['down_payments']['p_type'] == "full" ? "checked" : ""}} type="checkbox" id="inlineCheckbox16" value="option1" required="required">
                    <label class="form-check-label"  for="inlineCheckbox16">Lump Sum Payment (100%)</label>
                    </div>
                </div>
                        <div class="col-md-5" >
                            <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{$booking['down_payments']['p_type'] == "partial" ? "checked" : ""}}  type="checkbox" id="inlineCheckbox17" value="option1" required="required">
                            <label class="form-check-label" for="inlineCheckbox17">Other</label>
                            </div>
                        </div>
                    </div>
                
  
                <div class="row mt-5" >
                  <div class="col-md-2" >
                      <label class="control-label">DD/Pay Order # <span class="required">*</span> </label>
                  </div>
                      <div class="col-md-4">
                          <input  maxlength="100" type="text" required="required" value="{{$booking['down_payments']['p_order']}}" class="form-control" placeholder="Enter Payorder"  style=" height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; " />
                      </div>
                
                      <div class="col-md-2" >
                          <label class="control-label pl-4">Cash Receipt #: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-4">
                          <input maxlength="100" type="text" value="{{$booking['down_payments']['cheque']}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
  
                      <div class="col-md-2  mt-5" >
                          <label class="control-label pl-4">Date: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  mt-5">
                          <input maxlength="100" type="text" value="{{$booking['down_payments']['date']}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
  
                      <div class="col-md-2 pl-5 mt-5" >
                          <label class="control-label">Bank: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  mt-5">
                          <input maxlength="100" type="text" value="{{$bank->name}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
  
                      <div class="col-md-2 pl-5 mt-5" >
                          <label class="control-label">Branch: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  mt-5">
                          <input maxlength="100" type="text" value="{{$bank->branch_code}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
              </div>
  
              <div class="row" style="margin-top: 30px; ">
                  <div class="col-md-3"    >
                      <div class="form-group">
                        <input maxlength="100" type="text" required="required" class="form-control" style="  height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                      </div>
                  </div>
                  <div class="col-md-3"  style=" margin-bottom: 20px;margin-left: 50px; ">
                      <div class="form-group">
                        <input maxlength="100" type="text" required="required" class="form-control" style=" height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                      </div>
                  </div>
                  <div class="col-md-3"  style=" margin-bottom: 20px;margin-left: 45px; ">
                      <div class="form-group">
                          <input maxlength="100" type="text" required="required" class="form-control" style="  height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                      </div>
                  </div>
                  <div class="col-md-3"  style=" margin-bottom: 20px;margin-left: 45px; ">
                    <div class="form-group">
                        <input maxlength="100" type="text" required="required" class="form-control" style="  height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                    </div>
                  </div>
                </div>
  
                <div class="row">
                  <div class="col-md-4"  style=" margin-bottom: 20px; ">
                      <div class="form-group">
                        <label class="control-label">Applicant Signature</label>
                       </div>
                  </div>
                  <div class="col-md-4"  style=" margin-bottom: 20px;">
                      <label class="control-label">Sales Officer/Rec Agent</label>
                  </div>
                   <div class="col-md-4"  style=" margin-bottom: 20px;">
                      <div class="form-group">
                          <label class="control-label">Manager sales</label>
                      </div>
                  </div>
                 
                </div>
          </div>
  
  <hr style="border-top: .75em dotted; width: 100%; height: 0px; border-bottom: 0; border-left: 0; border-right: 0; position: relative; ">
  
  
  <div class="container">
      
      <div class="row mt-5">
          <div class="col-md-12">
            <h5>REF NO : <span class="bb" > {{$booking['ref_num']}}</span></h5>
          </div>
          <div class="col-md-12">
            <h5>Sr. No :  <span class="bb">{{$booking['ser_num']}}</span></h5>
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
                            @if($booking['plots']['status'] == "residential")
                        <input class="form-check-input" {{$item->id == $booking['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
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
                                @if($booking['plots']['status'] == "commercial")
                            <input class="form-check-input" {{$item->id == $booking['plots']['size'] ? "checked" : ""}} type="checkbox" id="inlineCheckbox7" value="{{$item->id}}" required="required">
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
  
                <div class="row mt-5">
                  <div class="col-md-12"><h3>PAYMENT DETAILS:</h3></div>
                   
                        <div class="col-md-2"></div>
                          <div class="col-md-5">
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" {{$booking['down_payments']['p_type'] == "full" ? "checked" : ""}} type="checkbox" id="inlineCheckbox16" value="option1" required="required">
                            <label class="form-check-label"  for="inlineCheckbox16">Lump Sum Payment (100%)</label>
                            </div>
                        </div>
                        <div class="col-md-5" >
                            <div class="form-check form-check-inline">
                            <input class="form-check-input"  {{$booking['down_payments']['p_type'] == "partial" ? "checked" : ""}}  type="checkbox" id="inlineCheckbox17" value="option1" required="required">
                            <label class="form-check-label" for="inlineCheckbox17">Other</label>
                            </div>
                        </div>
                    </div>
                
  
                <div class="row mt-5" >
                  <div class="col-md-2" >
                      <label class="control-label">DD/Pay Order # <span class="required">*</span> </label>
                  </div>
                      <div class="col-md-4">
                          <input  maxlength="100" type="text" required="required" value="{{$booking['down_payments']['p_order']}}" class="form-control" placeholder="Enter Payorder"  style=" height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; " />
                      </div>
                
                      <div class="col-md-2" >
                          <label class="control-label pl-4">Cash Receipt #: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-4">
                          <input maxlength="100" type="text" value="{{$booking['down_payments']['cheque']}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
  
                      <div class="col-md-2  mt-5" >
                          <label class="control-label pl-4">Date: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  mt-5">
                          <input maxlength="100" type="text" value="{{$booking['down_payments']['date']}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
  
                      <div class="col-md-2 pl-5 mt-5" >
                          <label class="control-label">Bank: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  mt-5">
                          <input maxlength="100" type="text" value="{{$bank->name}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
  
                      <div class="col-md-2 pl-5 mt-5" >
                          <label class="control-label">Branch: <span class="required">*</span> </label>
                      </div>
                      <div class="col-md-2  mt-5">
                          <input maxlength="100" type="text" value="{{$bank->branch_code}}" required="required" class="form-control" placeholder="Enter Name" style="  height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
                      </div>
              </div>
  
              <div class="row" style="margin-top: 30px; ">
                  <div class="col-md-3"    >
                      <div class="form-group">
                        <input maxlength="100" type="text" required="required" class="form-control" style="  height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                      </div>
                  </div>
                  <div class="col-md-3"  style=" margin-bottom: 20px;margin-left: 50px; ">
                      <div class="form-group">
                        <input maxlength="100" type="text" required="required" class="form-control" style=" height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                      </div>
                  </div>
                  <div class="col-md-3"  style=" margin-bottom: 20px;margin-left: 45px; ">
                      <div class="form-group">
                          <input maxlength="100" type="text" required="required" class="form-control" style="  height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                      </div>
                  </div>
                  <div class="col-md-3"  style=" margin-bottom: 20px;margin-left: 45px; ">
                    <div class="form-group">
                        <input maxlength="100" type="text" required="required" class="form-control" style="  height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "/>
                    </div>
                  </div>
                </div>
  
                <div class="row">
                  <div class="col-md-4"  style=" margin-bottom: 20px; ">
                      <div class="form-group">
                        <label class="control-label">Applicant Signature</label>
                       </div>
                  </div>
                  <div class="col-md-4"  style=" margin-bottom: 20px;">
                      <label class="control-label">Sales Officer/Rec Agent</label>
                  </div>
                   <div class="col-md-4"  style=" margin-bottom: 20px;">
                      <div class="form-group">
                          <label class="control-label">Manager sales</label>
                      </div>
                  </div>
                 
                </div>
  
                <div class="row">
                  <table class="table">
                    <tr>
                      <th colspan="6" style=" height: 35px; "><u>Payment Plan (PKR)
                      </u></th>
                    </tr>
                    <tr>
                      <th>Plot Size
                        (Marla)</th>
                      <th>Total Price
                        (PKR)</th>
                      <th style=" width: 14%; ">Booking</th>
                      <th>36-Monthly
                        Installments</th>
                      <th>At Announcement of
                        Balloting</th>
                      <th>At Announcement of
                        Possession</th>
                    </tr>
                    <tr style="height: 50px !important;">
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </table>
                </div>
  
     
    <div class="row">
      <h3 style="text-align: center;">Terms & Conditions</h3>
      <ol>
          <li>Application form along with pay order, bank draft shall be submitted in favor of DEFENCE CITY at City/Site office. All subsequent payments 
          shall be made as per schedule of payment and same be treated as part of these terms and conditions.</li>
          <li>A plot cannot be surrendered once it is allotted or transferred.</li>
          <li>The exact size and location of the plot will remain tentative and subject to adjustment till demarcation/measurement of the said plot at the time of 
          possession.</li>
          <li>If the allottee fails to pay three successive installments, his provisional allotment will be cancelled. The paid amount shall be refunded after the 
            deduction of 20% of the plot price within 3 months of cancellation, without any interest/markup against paid amount.</li>
          <li>Lump sum or installments payment will be as per the above mentioned payment plan.</li>
          <li>Installments received after due date will only be accepted subject to payment of surcharge @0.05% per day of the due installment.</li>
          <li>Development charges are inclusive in the plot price; however in case of any compulsive conditions customers will be informed.</li>
          <li>Development charges include the cost of main access road, sewerage, water supply and drainage whereas utilities and any other charges shall be obtained later.</li>
          <li> Unexpected increment in development charges may increase the price.</li>
          <li>10% premium will be charged for each preferential location. For example 30% premium will be charged for corner, boulevard location and facing 
            park.</li>
          <li>In addition to the total amount, additional land charges will be applicable in case of extra land area in plot.</li>
          <li>One booking form can be used for seeking allotment of one plot only. For booking of more than one plot, separate forms to be used by the 
            applicant</li>
          <li>All registration, sale agreement/mutation charges etc. or any other government taxes applicable on plot/development shall be borne by the 
            provisional allottee.
            </li>
          <li>For any type of construction prior approval from DEFENCE CITY Design Wing will be mandatory</li>
          <li>In case of any dispute between the provisional allottee and DEFENCE CITY the dispute will be referred to the Administration Committee of 
            DEFENCE CITY, whose decision shall be final and binding on both the parties. The parties do hereby bind to arbitration and exclude the 
            intimation of any civil proceeding before the court of law.</li>
          <li>Every applicant shall abide by the bye-laws, rules and regulations, terms and conditions of DEFENCE CITY for possession, allotment, 
            construction and transfer of plots etc.</li>
          <li>Possession and final allotment of the plot shall be given after all the complete payment(s) has been received including charges levied by 
            DEFENCE CITY from time to time.</li>
          <li>Address given by the applicant in the application form shall be deemed to be proper address for any future correspondence and communication 
            unless updated in DEFENCE CITY.</li>
          <li>Application form will be charged at PKR 500.00 each (non-refundable)
          </li>
          <li>Processing fee (non-refundable) for each 10 Marla residential plot is PKR 5,000.00.</li>
          <li>10% discount will be given on full lump sum payment (100% payment of the cost) as mentioned in this application form. However, the rest of the 
            charges to be levied as mentioned above have to be paid by the applicant as and when applicable.
            </li>
      </ol>
    </div>
   
    <div class="row mt-4">
        <div class="col-md-6">
          <form action="/action_page.php">
              <fieldset>
               <legend>NOTE:</legend>
               <p style="margin: 10px;text-align : justify">
                  Every Customer copy of the booking foirm has a Pak Rs. 20 Currency Note affixed .
                  This Currency Note validates the serial number on the booking form .Incase the serial number on the Rs. 20 note differ from the form number on the booking fo0rm or the orignal form is not attached withy the boking form. The booking shall be canceled.
                  It is mendatory for Rs. 20 note to be attached to form at time of bookinhg filr opening and transfer.
               </p>
               </fieldset>
             </form>
        </div>
        <div class="col-md-6">
          
              {{-- <img src="{{asset('storage/images/20_note.jfif')}}" alt="Snow" style="width:100%;" id="image"> --}}
                    <div id="top" class="top-right">{{$booking['ref_num']}}</div>
                    <div  id="bottom" class="bottom-left">{{$booking['ref_num']}}</div>
            </div>
       
    </div>
  
  
    <div class="row">
        <div class="col-md-12">
          <h3 style="text-align: center;">Declaration</h3>
        </div>
        
          <div class="col-md-12" >
              <div style="border: 1px solid black;">
                 <p>I do hereby acknowledge, agree and abide by all the present and future terms and conditions/ rules and regulations made by DEFENCE CITY .</p>
             
              <div class="row mt-3">
                  <div class="col-md-6">
                      <p>Signature of the Applicant:_____________________</p>
                    </div>
                    <div class="col-md-6">
                      <p >Date:_____________________</p>
                    </div>
             
              <hr>
              <div class="col-md-4" >
                  <div class="form-group">
                    <label class="control-label">Sales Officer/Rec Agent</label>
                  
                  </div>
              </div>
              <div class="col-md-4" >
                  <div class="form-group">
                      <label class="control-label">Manager sales</label>
                  </div>
              </div>
              <div class="col-md-4" >
                <div class="form-group">
                    <label class="control-label">Date</label>
                    
                </div>
              </div>
         </div>
             
       </div>
    </div>
         
  
  
  </div>
  
  
  
  
  