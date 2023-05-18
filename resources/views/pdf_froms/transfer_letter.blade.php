<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<style>
.col-md-1 {width:8%;  float:left;}
.col-md-2 {width:16%; float:left;}
.col-md-2 {width:25%; float:left;}
.col-md-4 {width:22%; float:left;}
.col-md-5 {width:42%; float:left;}
.col-md-6 {width:50%; float:left;}
.col-md-7 {width:58%; float:left;}
.col-md-8 {width:66%; float:left;}
.col-md-10 {width:75%; float:left;}
.col-md-10{width:82%; float:left;}
.col-md-11{width:102%; float:left;}
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
    background: #ffe41010;
    font-size: 28px;
}
.top-right {
    position: absolute;
    top: 12px;
    right: 6%;
    color: black;
    FONT-SIZE: 28PX;
    background: #ffe41010;
}
input[type=checkbox] {
    transform: scale(2);
    margin-right: 20px !important;
}
h5 {
    line-height: 40px;
}
  </style>
  <div class="container">
      <div class="row">
          <div class="col-md-2">
            <img src="{{asset('storage/images/logo.png')}}" alt="Snow" id="img" height="150px">
          </div>
          <div class="col-md-2"></div>
            <div class="col-md-4 ">
              <h1>DEFENCE CITY</h1>
              <H1>Transfer Letter</H1>
            </div>
        </div>



      <div class="row mt-5">
          <div class="col-md-2"><h2>Dated :</h2></div>
          <div class="col-md-10">{{date('Y-m-d', strtotime($transfer['created_at']))}}</div>

          <div class="col-md-2"><h2>Reg No :</h2></div>
          <div class="col-md-10">{{$transfer['ref_num']}}</div>

          <div class="col-md-2"><h2>Name :</h2></div>
          <div class="col-md-10">{{$transfer['customer_to']['sal_customer_name']}}</div>

          <div class="col-md-2"><h2>Address :</h2></div>
          <div class="col-md-10">{{strip_tags($transfer['customer_to']['sal_customer_address_1']), "<strong><em>"}}</div>

          <div class="col-md-2"><h2>Subject :</h2></div>
          <div class="col-md-10">Transfer of Registration No . ({{$transfer['ref_num']}}) () ' Town , City</div>


          <div class="col-md-12">
              <h5>The undersigned is pleased to inform you that the subject registration measuring ___Square Yards /
                {{$transfer['plots']['status']}} Plot in DEFENCE CITY has been transferred in your name with all rights, deposits and liabilities,
                on existing terms and condition and those which may be enforced in future by DEFENCE CITY or any
                authority competent to do so. </h5>

                <h5>
                    <b>Note : </b>
                    Any discrepancy in paper or payments of dues, installments and additional charges etc. subsequently
                    notices by the DEFENCE CITY administration shall be made good by the transferee or his / her heir (s).
                </h5>
          </div>

          <div class="col-md-4"><h2>Created On :</h2></div>
          <div class="col-md-8">{{date('Y-m-d', strtotime($transfer['created_at']))}}</div>

          <div class="col-md-4"><h2>Approved No :</h2></div>
          <div class="col-md-8">{{date('Y-m-d', strtotime($transfer['updated_at']))}}</div>

          <div class="col-md-4"><h2>CC :</h2></div>
          <div class="col-md-8"></div>

          <div class="col-md-4"><h2>Seller Name :</h2></div>
          <div class="col-md-8">{{$transfer['customer_from']['sal_customer_name']}}</div>

          <div class="col-md-4"><h2>Seller Address :</h2></div>
          <div class="col-md-8">{{strip_tags($transfer['customer_from']['sal_customer_address_1']), "<strong>"}}</div>

          <div class="col-md-12">
            <h5>The undersigned is pleased to inform you that the subject registration measuring ___Square Yards /
                {{$transfer['plots']['status']}} Plot in DEFENCE CITY has been transferred in your name with all rights, deposits and liabilities,
                on existing terms and condition and those which may be enforced in future by DEFENCE CITY or any
                authority competent to do so. </h5>

                <h5>

              <h5>
                  <b>Note : </b>
                  <h5>Subject property has been transferred from {{$transfer['customer_from']['sal_customer_name']}} to the name of {{$transfer['customer_to']['sal_customer_name']}} holding
                    CNIC{{$transfer['customer_to']['sal_customer_cnic']}} S/o, D/o, W/o {{$transfer['transfer_nominees'][0]['son_of']}} with all rights deposits and liabilities.</h5>
              </h5>
        </div>
      </div>
         
      
        <div style="margin: 100px">
        <button id="print" class="btn btn-info" onclick="Pr()">print</button>
            
        </div>
   
</div>
<script>
    function Pr(){
      $("#print").hide();
            print();
         location.reload();
    }
</script>