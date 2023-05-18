<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
<style>
    .btn-info {
    color: #fff;
    background-color: #17a2b8;
    border-color: #17a2b8;
}
.btn-danger {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}
.btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
    .m-5 {
    margin: 3rem!important;
}
    
</style>
<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
   
    h2{     
        font-size: 20px;
        margin: 6px 0px;
    }
    h2 span{
        background-color: #000;
        color: #fff;
        padding: 3px;
        border-radius: 5px;
    }
    div{
        width: 100%;
        padding-bottom: 3px;
    }
    .table-wrap{
        width: 100%;
        max-width: 21cm;
        margin: 0 auto;
        padding: 10px 0px;
       
    }
    h4 span{
        border: 3px solid #000;
        padding: 5px;
    }
    h4 {
        margin-bottom: 20px;
        margin-top: 20px;
    }
    .header{
        width: 100%;
        height: 260px;
        
    }
    .header3 {
    width: 100%;
    height: 280px;
}
    .joint-applicant{
        display: flex;
        width: 100%;
    }
    .Nominee{
        display: flex;
        width: 100%;
    }
    .Applicant{
        display: flex;
        width: 100%; 
    }
    .Property{
        display: flex;
        width: 100%;  
    }
    .Company-Firm{
        display: flex;
        width: 100%; 
    }
    .Booking-Detail{
        display: flex;
        width: 100%;  
    }
</style>
<body>
    <div class="table-wrap">
    <table>
        <div class="header">
           
        </div>
    </table>
        <h4><span> Account Office Copy </span></h4>
        <table style="width: 100%;">
        <h2><span> Booking Detail </span></h2>
        <tr style="width: 100%;">
            <div>
                <span>Unit Price</span>
                <input type="text" value="PKR {{number_format($booking['amount'])}}/-" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Rate/sqft</label>
                <input type="text" name="" value="{{$booking['plot_size']}}" id="" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Down Payment</label>
                <input type="text" value="PKR {{number_format($booking['down_payments']['amount'])}}/-" style="border: none; border-bottom: 1px solid black; width: 23%;">
            </div>

        </tr>
        <tr>
            <div>
                <label for="">Balance Amount</label>
                <input type="text" value="PKR {{number_format($booking['amount']-( $booking['down_payments']['amount'] + $booking['down_payments']['discount']))}}/-" style="border: none; border-bottom: 1px solid black; width: 21%;">

                <label for="">(Installment)</label>
                Monthly
                <input type="checkbox" class="radio" value="1" name="fooby[1][]" />
                Quarterly
                <input type="checkbox" class="radio" value="1" name="fooby[1][]" />

                <label for="">Each Installment Rs.</label>
                @if($insatallmentDetails)
                <input type="text" name="" value="{{$insatallmentDetails->MonthlyInstallment}}" id="" style="border: none; border-bottom: 1px solid black; width: 10%;">
                @else
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 10%;">
                @endif

            </div>
        </tr>
        <tr>
            <div>
                <label for="">No. Of Installments</label>
                @if($installmentMaster)
                    <input type="text" name="" value="{{$installmentMaster->installment_period}}" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @else
                    <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @endif
                <label for="">Installment Tenure</label>
                @if($installmentMaster)
                    <input type="text" name="" value="{{$installmentMaster->instalment_type}}" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @else
                    <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @endif
                <label for="">Amount on possession</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">
            </div>
        </tr>
    </table>

    <table>
        <h2><span> Property Detail </span></h2>
        <tr>
            <div>
                <label for="">Floor No.</label>
                <input type="text" name="" value="{{$block['name']}}" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">

                <label for="">Office No.</label>
                <input type="text" name="" value="{{$office['office_no']}}" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">

                <label for="">Office Area (in sqft)</label>
                <input type="text" name="" id="" value="{{$booking['plot_size']}}" style="border: none; border-bottom: 1px solid black; width: 22%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Office Location</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 80%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Applicant(s) Detail </span></h2>
        <tr>
            <div>
                <label for="">Full Name:</label>
                <input type="text" value="{{$booking['customers']['name']}}" style="border: none; border-bottom: 1px solid black; width: 83%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Nationality:</label>
                <input type="text" name="" id="" Value="Pakistani" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">CNIC/Passport No.</label>
                <input type="text" value="{{$booking['customers']['phone']}}" style="border: none; border-bottom: 1px solid black; width: 41%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Contact No.</label>
                <input type="text" value="{{$booking['customers']['phone']}}" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Address</label>
                <input type="text" value="{{strip_tags($booking['customers']['description'])}}" style="border: none; border-bottom: 1px solid black; width: 55%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Joint Applicant(s) Details(If Applicable and only if the First Applicant is an Individual) </span></h2>
        <tr>
            <div>
                <label for="">Full Name:</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 83%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Nationality:</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">CNIC/Passport No.</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 40.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Contact No.</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Address</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 55%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Nominee(s) Details (In case the First Applicant is an Individual) </span></h2>
        @foreach($booking['nominees']  as $key => $item)
            <tr>
                <div>
                    <label for="">Full Name:</label>
                    <input type="text" value="{{$item['name']}}" style="border: none; border-bottom: 1px solid black; width: 30%;">

                    <label for="">CNIC/Passport No.</label>
                    <input type="text" value="{{$item['cnic']}}" style="border: none; border-bottom: 1px solid black; width: 36%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">S/O, D/O, W/O:</label>
                    <input type="text" value="{{$item['son_of']}}" style="border: none; border-bottom: 1px solid black; width: 29%;">

                    <label for="">Mobile No.</label>
                    <input type="text" value="{{$item['phone']}}" style="border: none; border-bottom: 1px solid black; width: 39.5%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">Relationship with Applicant:</label>
                    <input type="text" value="{{$item['relation']}}" style="border: none; border-bottom: 1px solid black;">

                    <label for="">Email Address:</label>
                    <input type="text" value="N/A" style="border: none; border-bottom: 1px solid black; width: 34%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">Address:</label>
                    <input type="text" value="N/A" style="border: none; border-bottom: 1px solid black; width: 85%;">
                </div>
            </tr>
        @endforeach
    </table>

    <table style="width: 100%;">
        <h2><span> Applicant(s) Details (In Case of a Company/Firm) </span></h2>
        <tr>
            <div>
                <label for="">Commercial Registration No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 36%;">

                <label for="">Date:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 26.5%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Companies Name</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">Place of Registration:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 33.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Mailing Address:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 77.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Mobile No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black;">


                <label for="">Email Address:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 47.7%;">
            </div>
        </tr>
    </table>
    <table>
        <tr>
            <div>
                <label for="">Company's Owner / Authorized Contact person:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 52.7%;">
            </div>
        </tr>
    </table>
    <table>
        <tr>
            <div>
                <label for="">CNIC/Passport No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 35%;">


                <label for="">Mobile No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 30.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">registration Certificate</label>
                <input type="checkbox" name="" id="">
                <label for="">Form A</label>
                <input type="checkbox" name="" id="">
                <label for="">Form 29</label>
                <input type="checkbox" name="" id="">
            </div>
        </tr>

        <tr>
            <div>
                <p>(Note: Please Read Carefully. In Case of any false/wrong information the applicant will br held responsible)</p>
                <p>(Terms and Condition Apply)</p>
            </div>
        </tr>
    </table>
 </div>



</body>
<br>
<br>
<body>
    <div class="table-wrap">
    <table>
        <div class="header">
           
        </div>
    </table>
        <h4><span> Client Copy </span></h4>
        <table style="width: 100%;">
        <h2><span> Booking Detail </span></h2>
        <tr style="width: 100%;">
            <div>
                <span>Unit Price</span>
                <input type="text" value="PKR {{number_format($booking['amount'])}}/-" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Rate/sqft</label>
                <input type="text" name="" value="{{$booking['plot_size']}}" id="" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Down Payment</label>
                <input type="text" value="PKR {{number_format($booking['down_payments']['amount'])}}/-" style="border: none; border-bottom: 1px solid black; width: 23%;">
            </div>

        </tr>
        <tr>
            <div>
                <label for="">Balance Amount</label>
                <input type="text" value="PKR {{number_format($booking['amount']-( $booking['down_payments']['amount'] + $booking['down_payments']['discount']))}}/-" style="border: none; border-bottom: 1px solid black; width: 21%;">

                <label for="">(Installment)</label>
                Monthly
                <input type="checkbox" class="radio" value="1" name="fooby[1][]" />
                Quarterly
                <input type="checkbox" class="radio" value="1" name="fooby[1][]" />

                <label for="">Each Installment Rs.</label>
                @if($insatallmentDetails)
                <input type="text" name="" value="{{$insatallmentDetails->MonthlyInstallment}}" id="" style="border: none; border-bottom: 1px solid black; width: 10%;">
                @else
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 10%;">
                @endif

            </div>
        </tr>
        <tr>
            <div>
                <label for="">No. Of Installments</label>
                @if($installmentMaster)
                    <input type="text" name="" value="{{$installmentMaster->installment_period}}" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @else
                    <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @endif
                <label for="">Installment Tenure</label>
                @if($installmentMaster)
                    <input type="text" name="" value="{{$installmentMaster->instalment_type}}" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @else
                    <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @endif
                <label for="">Amount on possession</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">
            </div>
        </tr>
    </table>

    <table>
        <h2><span> Property Detail </span></h2>
        <tr>
            <div>
                <label for="">Floor No.</label>
                <input type="text" name="" value="{{$block['name']}}" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">

                <label for="">Office No.</label>
                <input type="text" name="" value="{{$office['office_no']}}" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">

                <label for="">Office Area (in sqft)</label>
                <input type="text" name="" id="" value="{{$booking['plot_size']}}" style="border: none; border-bottom: 1px solid black; width: 22%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Office Location</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 80%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Applicant(s) Detail </span></h2>
        <tr>
            <div>
                <label for="">Full Name:</label>
                <input type="text" value="{{$booking['customers']['name']}}" style="border: none; border-bottom: 1px solid black; width: 83%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Nationality:</label>
                <input type="text" name="" id="" Value="Pakistani" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">CNIC/Passport No.</label>
                <input type="text" value="{{$booking['customers']['phone']}}" style="border: none; border-bottom: 1px solid black; width: 41%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Contact No.</label>
                <input type="text" value="{{$booking['customers']['phone']}}" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Address</label>
                <input type="text" value="{{strip_tags($booking['customers']['description'])}}" style="border: none; border-bottom: 1px solid black; width: 55%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Joint Applicant(s) Details(If Applicable and only if the First Applicant is an Individual) </span></h2>
        <tr>
            <div>
                <label for="">Full Name:</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 83%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Nationality:</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">CNIC/Passport No.</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 40.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Contact No.</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Address</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 55%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Nominee(s) Details (In case the First Applicant is an Individual) </span></h2>
        @foreach($booking['nominees']  as $key => $item)
            <tr>
                <div>
                    <label for="">Full Name:</label>
                    <input type="text" value="{{$item['name']}}" style="border: none; border-bottom: 1px solid black; width: 30%;">

                    <label for="">CNIC/Passport No.</label>
                    <input type="text" value="{{$item['cnic']}}" style="border: none; border-bottom: 1px solid black; width: 36%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">S/O, D/O, W/O:</label>
                    <input type="text" value="{{$item['son_of']}}" style="border: none; border-bottom: 1px solid black; width: 29%;">

                    <label for="">Mobile No.</label>
                    <input type="text" value="{{$item['phone']}}" style="border: none; border-bottom: 1px solid black; width: 39.5%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">Relationship with Applicant:</label>
                    <input type="text" value="{{$item['relation']}}" style="border: none; border-bottom: 1px solid black;">

                    <label for="">Email Address:</label>
                    <input type="text" value="N/A" style="border: none; border-bottom: 1px solid black; width: 34%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">Address:</label>
                    <input type="text" value="N/A" style="border: none; border-bottom: 1px solid black; width: 85%;">
                </div>
            </tr>
        @endforeach
    </table>

    <table style="width: 100%;">
        <h2><span> Applicant(s) Details (In Case of a Company/Firm) </span></h2>
        <tr>
            <div>
                <label for="">Commercial Registration No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 36%;">

                <label for="">Date:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 26.5%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Companies Name</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">Place of Registration:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 33.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Mailing Address:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 77.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Mobile No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black;">


                <label for="">Email Address:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 47.7%;">
            </div>
        </tr>
    </table>
    <table>
        <tr>
            <div>
                <label for="">Company's Owner / Authorized Contact person:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 52.7%;">
            </div>
        </tr>
    </table>
    <table>
        <tr>
            <div>
                <label for="">CNIC/Passport No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 35%;">


                <label for="">Mobile No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 30.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">registration Certificate</label>
                <input type="checkbox" name="" id="">
                <label for="">Form A</label>
                <input type="checkbox" name="" id="">
                <label for="">Form 29</label>
                <input type="checkbox" name="" id="">
            </div>
        </tr>

        <tr>
            <div>
                <p>(Note: Please Read Carefully. In Case of any false/wrong information the applicant will br held responsible)</p>
                <p>(Terms and Condition Apply)</p>
            </div>
        </tr>
    </table>
 </div>
</body>
<br>
<br>
<br>
<body>
    <div class="table-wrap">
    <table>
        <div class="header3">
           
        </div>
    </table>
        <h4><span> Sales Office Copy </span></h4>
        <table style="width: 100%;">
        <h2><span> Booking Detail </span></h2>
        <tr style="width: 100%;">
            <div>
                <span>Unit Price</span>
                <input type="text" value="PKR {{number_format($booking['amount'])}}/-" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Rate/sqft</label>
                <input type="text" name="" value="{{$booking['plot_size']}}" id="" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Down Payment</label>
                <input type="text" value="PKR {{number_format($booking['down_payments']['amount'])}}/-" style="border: none; border-bottom: 1px solid black; width: 23%;">
            </div>

        </tr>
        <tr>
            <div>
                <label for="">Balance Amount</label>
                <input type="text" value="PKR {{number_format($booking['amount']-( $booking['down_payments']['amount'] + $booking['down_payments']['discount']))}}/-" style="border: none; border-bottom: 1px solid black; width: 21%;">

                <label for="">(Installment)</label>
                Monthly
                <input type="checkbox" class="radio" value="1" name="fooby[1][]" />
                Quarterly
                <input type="checkbox" class="radio" value="1" name="fooby[1][]" />

                <label for="">Each Installment Rs.</label>
                @if($insatallmentDetails)
                <input type="text" name="" value="{{$insatallmentDetails->MonthlyInstallment}}" id="" style="border: none; border-bottom: 1px solid black; width: 10%;">
                @else
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 10%;">
                @endif

            </div>
        </tr>
        <tr>
            <div>
                <label for="">No. Of Installments</label>
                @if($installmentMaster)
                    <input type="text" name="" value="{{$installmentMaster->installment_period}}" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @else
                    <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @endif
                <label for="">Installment Tenure</label>
                @if($installmentMaster)
                    <input type="text" name="" value="{{$installmentMaster->instalment_type}}" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @else
                    <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 12%;">
                @endif
                <label for="">Amount on possession</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">
            </div>
        </tr>
    </table>

    <table>
        <h2><span> Property Detail </span></h2>
        <tr>
            <div>
                <label for="">Floor No.</label>
                <input type="text" name="" value="{{$block['name']}}" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">

                <label for="">Office No.</label>
                <input type="text" name="" value="{{$office['office_no']}}" id="" style="border: none; border-bottom: 1px solid black; width: 18%;">

                <label for="">Office Area (in sqft)</label>
                <input type="text" name="" id="" value="{{$booking['plot_size']}}" style="border: none; border-bottom: 1px solid black; width: 22%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Office Location</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 80%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Applicant(s) Detail </span></h2>
        <tr>
            <div>
                <label for="">Full Name:</label>
                <input type="text" value="{{$booking['customers']['name']}}" style="border: none; border-bottom: 1px solid black; width: 83%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Nationality:</label>
                <input type="text" name="" id="" Value="Pakistani" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">CNIC/Passport No.</label>
                <input type="text" value="{{$booking['customers']['phone']}}" style="border: none; border-bottom: 1px solid black; width: 41%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Contact No.</label>
                <input type="text" value="{{$booking['customers']['phone']}}" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Address</label>
                <input type="text" value="{{strip_tags($booking['customers']['description'])}}" style="border: none; border-bottom: 1px solid black; width: 55%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Joint Applicant(s) Details(If Applicable and only if the First Applicant is an Individual) </span></h2>
        <tr>
            <div>
                <label for="">Full Name:</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 83%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Nationality:</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">CNIC/Passport No.</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 40.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Contact No.</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 20%;">

                <label for="">Address</label>
                <input type="text" name="" value="N/A" id="" style="border: none; border-bottom: 1px solid black; width: 55%;">
            </div>
        </tr>
    </table>

    <table style="width: 100%;">
        <h2><span> Nominee(s) Details (In case the First Applicant is an Individual) </span></h2>
        @foreach($booking['nominees']  as $key => $item)
            <tr>
                <div>
                    <label for="">Full Name:</label>
                    <input type="text" value="{{$item['name']}}" style="border: none; border-bottom: 1px solid black; width: 30%;">

                    <label for="">CNIC/Passport No.</label>
                    <input type="text" value="{{$item['cnic']}}" style="border: none; border-bottom: 1px solid black; width: 36%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">S/O, D/O, W/O:</label>
                    <input type="text" value="{{$item['son_of']}}" style="border: none; border-bottom: 1px solid black; width: 29%;">

                    <label for="">Mobile No.</label>
                    <input type="text" value="{{$item['phone']}}" style="border: none; border-bottom: 1px solid black; width: 39.5%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">Relationship with Applicant:</label>
                    <input type="text" value="{{$item['relation']}}" style="border: none; border-bottom: 1px solid black;">

                    <label for="">Email Address:</label>
                    <input type="text" value="N/A" style="border: none; border-bottom: 1px solid black; width: 34%;">
                </div>
            </tr>
            <tr>
                <div>
                    <label for="">Address:</label>
                    <input type="text" value="N/A" style="border: none; border-bottom: 1px solid black; width: 85%;">
                </div>
            </tr>
        @endforeach
    </table>

    <table style="width: 100%;">
        <h2><span> Applicant(s) Details (In Case of a Company/Firm) </span></h2>
        <tr>
            <div>
                <label for="">Commercial Registration No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 36%;">

                <label for="">Date:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 26.5%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Companies Name</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 25%;">

                <label for="">Place of Registration:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 33.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Mailing Address:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 77.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">Mobile No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black;">


                <label for="">Email Address:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 47.7%;">
            </div>
        </tr>
    </table>
    <table>
        <tr>
            <div>
                <label for="">Company's Owner / Authorized Contact person:</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 52.7%;">
            </div>
        </tr>
    </table>
    <table>
        <tr>
            <div>
                <label for="">CNIC/Passport No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 35%;">


                <label for="">Mobile No.</label>
                <input type="text" name="" id="" style="border: none; border-bottom: 1px solid black; width: 30.7%;">
            </div>
        </tr>
        <tr>
            <div>
                <label for="">registration Certificate</label>
                <input type="checkbox" name="" id="">
                <label for="">Form A</label>
                <input type="checkbox" name="" id="">
                <label for="">Form 29</label>
                <input type="checkbox" name="" id="">
            </div>
        </tr>

        <tr>
            <div>
                <p>(Note: Please Read Carefully. In Case of any false/wrong information the applicant will br held responsible)</p>
                <p>(Terms and Condition Apply)</p>
            </div>
        </tr>
    </table>
 </div>

    <div class="m-5">
    <!-- <button id="print" class="btn btn-info" onclick="Pr()">print</button> -->
    @if($booking['status'] == '1')
    
    @else
    <a id="approve" href="/admin/booking/approve/{{$booking['id']}}" class="btn btn-success">Approve</a>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Reject</button>
    @endif
    
    </div>

</body>


</html>
<script>
$("#path").val(window.location.pathname);  
  
    function Pr(){
      $(".btn").hide();
            print();
         location.reload();
    }
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
    $("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on
  var $box = $(this);
  if ($box.is(":checked")) {
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
</script>