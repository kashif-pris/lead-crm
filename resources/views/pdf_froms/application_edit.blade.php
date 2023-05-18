<style>
  @page  {
    margin: 0;
    size: Legal; /*or width x height 150mm 50mm*/
  }
  table, td, th {
  border: 1px solid black;
}

table {
    width: 64%;
    border-collapse: collapse;
}
  </style>
  <form action="/admin/application-form/update/{{$booking['id']}}" method="post">
    @csrf
 
      <div class="row">

<div class="col-md-4">
    <p>Sr. No : <input type="text" class="form-control" name="ser" value="{{$booking['ser_num']}}"></p>
</div>
          <div class="col-md-4">
            <p>Sr. No : <input type="text" class="form-control" name="ref" value="{{$booking['ref_num']}}"></p>
          </div>
      </div>

<h3>PLOT DETAILS:</h3>
<div class="col-md-12">
    @if($booking['plots']['status'] == "residential")
    <div class="row" style="display:flex;margin-bottom:15px; ">
       <div class="col-md-2">
           <label class="control-label">Plot Size: <sub style=" font-size: 9px; ">(RESIDENTAL)</sub> <span class="required">*</span> </label>
        </div> 
        <div class="col-md-4" style="display: inline-flex; position: relative; left: 38px;">
            <select name="size"  class="form-control">
            @foreach ($categories as $item)

                <option {{$item->id == $booking['plots']['size'] ? "selected" : ""}} value="{{$item->id}}">{{$item->name}} </option>
                @endforeach
            </select>
           
        </div>
    </div>
    @else
    <div class="row" style=" display: flex; margin-bottom:15px;">
        <div class="col-md-2">
            <label class="control-label">Plot Size: <sub style=" font-size: 9px; ">(COMMERCIAL)</sub> <span class="required">*</span> </label>
        </div>
        <div class="col-md-4" style="display: inline-flex; position: relative; left: 31px;">
            <select name="size"  class="form-control">
                @foreach ($categories as $item)
    
                    <option {{$item->id == $booking['plots']['size'] ? "selected" : ""}} value="{{$item->id}}">{{$item->name}} </option>
                    @endforeach
                </select>
        </div>
    </div>
    @endif 
   
    
</div>
<h3>PERSONAL INFORMATION:</h3>
<div class="col-md-12">

  <div class="row">
      <div class="col-md-4"style=" margin-bottom: 20px; ">
          <div class="form-group">
              <label class="control-label">Name of Applicant:<span class="required">*</span> </label>
               <select name="customer"  class="form-control">
                @foreach ($customer as $item)
                    <option {{$item->id == $booking['customers']['id'] ? "selected" : ""}} value="{{$item->id}}">{{$item->name}} </option>
                @endforeach
                </select>
          </div>
      </div>
     
  </div>
</div>


<div class="col-md-12">

    <div class="col-md-12">
        <hr>
        <div class="row">
            <div class="col-md-12">
               
                <table style="display: inline-table !important;" class="table table-striped" id="dynamicTable" style="2px solid black">  
                    <tr style="color:black">
                        <th>Name of Nominee</th>
                        <th>Father/Husband Name</th>
                        <th>Relationship </th>
                        <th>CNIC #</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                
                    @foreach($booking['nominees']  as $key => $item)
                    <tr>
                        <td><input type="text" id="freeSpace" value="{{$item['name']}}" name="addmore[{{$key}}][name]" required placeholder="Enter Name..." class="form-control text-field pName" /></td>
                        <td><input type="text" id="freeSpace" value="{{$item['son_of']}}" name="addmore[{{$key}}][so]" required placeholder="Enter s/o" class="form-control text-field pDesignation" /></td>
                        <td><input type="text" id="freeSpace" value="{{$item['relation']}}" name="addmore[{{$key}}][relation]" required placeholder="Enter relation" class="form-control text-field pMobile" /></td>  
                        <td><input type="number" id="freeSpace" value="{{$item['cnic']}}" name="addmore[{{$key}}][cnic]" required placeholder="Enter cnic" class="form-control text-field pEmail" /></td>  
                        <td><input type="number" id="freeSpace" value="{{$item['phone']}}" name="addmore[{{$key}}][phone]" required placeholder="Enter Phone no 1" class="form-control text-field pPhone" /></td>  
                        <td><button type="button" name="add"  class="btn btn-success add">Add More</button></td>  
                    </tr>  
                    @endforeach
                </table>                        
            </div>
           
        </div>
    </div>

<h3>PAYMENT DETAILS:</h3>
<div class="col-md-12">

  <div class="row">
    

      <div class="col-md-10" style="display: flex;    margin-left: 156px;">
          <div class="col-md-5">
              <div class="form-check form-check-inline">
              <input class="form-check-input" {{$booking['down_payments']['p_type'] == "full" ? "checked" : ""}} type="checkbox" id="inlineCheckbox16" value="option1">
              <label class="form-check-label"  for="inlineCheckbox16">Lump Sum Payment (100%)</label>
              </div>
          </div>
          <div class="col-md-5" style=" margin-left: 135px; ">
              <div class="form-check form-check-inline">
              <input class="form-check-input"  {{$booking['down_payments']['p_type'] == "partial" ? "checked" : ""}}  type="checkbox" id="inlineCheckbox17" value="option1" >
              <label class="form-check-label" for="inlineCheckbox17">Other</label>
              </div>
          </div>
      </div>
  </div>
  <div class="row" style=" display: flex; ">
      <div class="col-md-12"  style=" margin-bottom: 20px; margin-top: 12px; ">
          <div class="form-group">
              <label class="control-label">DD/Pay Order # <span class="required">*</span> </label>
              <input  maxlength="100" type="text" name="p_order" required="required" value="{{$booking['down_payments']['p_order']}}" class="form-control" placeholder="Enter Payorder"  style=" width: 180px; height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; " />
          </div>
      </div>
      <div class="col-md-12"  style=" margin-bottom: 20px;margin-left: 40px;margin-top: 10px; ">
          <div class="form-group">
              <label class="control-label">Cash Receipt #: <span class="required">*</span> </label>
              <input maxlength="100" type="text"  name="receipt" value="{{$booking['down_payments']['cheque']}}" required="required" class="form-control" placeholder="Enter Name" style=" width: 180px; height: 33px; position: relative; left: 28px;   border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black;" />
          </div>
      </div>
  </div>
  <div class="row" style=" display: flex; ">
      <div class="col-md-4"  style=" margin-bottom: 20px; ">
          <div class="form-group">
              <label class="control-label">Dated: <span class="required">*</span> </label>
              <input  maxlength="100" type="date"  name="date" value="{{$booking['down_payments']['date']}}" required="required" class="form-control" placeholder="" style=" width: 180px; height: 33px; position: relative; left: 28px;    border-left: 0px; border-top: 0px; border-right: 0px; border-bottom: 2px solid black; "  />
          </div>
      </div>
      <div class="col-md-4"  style=" margin-bottom: 20px;margin-left: 50px; ">
          <div class="form-group">
              <label class="control-label">Bank: <span class="required">*</span> </label>
               <select class="form-control" name="bank">
                   <option>-choose</option>
                   @foreach($banks as $item)
                   <option {{$booking['down_payments']['bank_id'] == $item->id ? "selected" : ""}} value="{{$item->id}}">{{$item->name}}</option>
                   @endforeach
               </select>
          </div>
      </div>
    
  </div>
  <input class="btn btn-info mb-5" value="Update" type="submit">
    
  
</div>
</form>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
   $(document).ready(function () {
         
          // for contact person
        var i = 0;
        var t = 1;

        $(".add").click(function(){
            ++i;
            ++t;
            $("#dynamicTable").append('<tr><td><input type="text" id="freeSpace" name="addmore['+i+'][name]" placeholder="Enter Name..." class="form-control text-field pName" /></td><td><input type="text" id="freeSpace" name="addmore['+i+'][so]" placeholder="Enter S/O" class="form-control text-field pDesignation" /></td><td><input type="text" id="relation" name="addmore['+i+'][relation]" placeholder="Enter relation '+t+' " class="form-control text-field pMobile"/></td><td><input type="number" id="freeSpace" name="addmore['+i+'][cnic]" required placeholder="Enter cnic '+t+'" class="form-control text-field pPhone" /></td><td><input type="number" id="freeSpace" name="addmore['+i+'][phone]" placeholder="Enter Phone" class="form-control text-field pEmail" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });
        $(document).on('click', '.remove-tr', function(){  
            $(this).parents('tr').remove();
        });

    });    
</script>

 