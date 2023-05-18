<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documenttt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <img class="card-img-top" src="1.jpg" alt="Card image cap">
            </div>
        </div>
        <div class="col-md-10 text-center">
            <h2>Defance City</h2>
            <h2>Cash / Cheque Recipit</h2>
        </div>
    </div>
    <div class="row mt-5">
        <table class="col-12">
            <tr>
                <td style="width: 10%;">
                    <label for="exampleInputEmail1">Sr NO: </label>
                </td>
                <td width="80%" colspan="8"></td>

            </tr>
            <tr>
                <td colspan="8">
                    <label for="exampleInputEmail1">Refrance NO: {{$receipt_print->InstallmentId}}</label>
                </td>

                <td width="40%"> Date {{$date}}</td>

            </tr>
            <tr>
                <td style="width: 100%;" colspan="9">
                    <label for="exampleInputEmail1">Recived with thanks form
                        ________________{{$receipt_print->clientName}}_________________</label>
                </td>
            </tr>
            <tr>
                <td style="width: 100%;" colspan="9">
                    <label for="exampleInputEmail1">The sum of Rupees
                        ________________{{$amountInword}}________________</label>
                </td>
            </tr>
            <tr>
                <td style="width: 10%;">
                    @if($receipt_print->Payment_Type == 'cash')
                    <input type="checkbox" id="cash" name="payment" value="cash" checked>
                    <label for="cash"> By Cash</label>
                    @else
                    <input type="checkbox" id="cash" name="payment" value="cash">
                    <label for="cash"> By Cash</label>
                    @endif
                </td>
                <td style="width: 15%;">
                    @if($receipt_print->Payment_Type == 'cheque')
                    <input type="checkbox" id="cheque" name="payment" value="cheque" checked>
                    <label for="cheque">*Cheque</label>

                    @else
                    <input type="checkbox" id="cheque" name="payment" value="cheque">
                    <label for="cheque">*Cheque</label>
                    @endif
                </td>
                <td style="width: 15%;">
                    @if($receipt_print->Payment_Type == 'payOrder')
                    <input type="checkbox" id="payOrder" name="payment" value="payOrder" checked>
                    <label for="cheque"> Pay Order</label>

                    @else
                    <input type="checkbox" id="payOrder" name="payment" value="payOrder">
                    <label for="cheque"> Pay Order</label>
                    @endif
                </td>
                <td style="width: 20%;">
                    @if($receipt_print->Payment_Type == 'bankDraft')
                    <input type="checkbox" id="draft" name="payment" value="draft" checked>
                    <label for="draft">Bank Draft No</label>

                    @else
                    <input type="checkbox" id="draft" name="payment" value="draft">
                    <label for="draft">Bank Draft No</label>
                    @endif
                </td>
                <td style="width: 40%;" colspan="5"> (* subject to realization of Cheque)
              
                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <label for="exampleInputEmail1">As part payment of the price in respect of house No.
                        {{$receipt_print->Location}} </label>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <label for="exampleInputEmail1">Approximatly measuring  {{$receipt_print->PlotSize}} Marla. </label>
                </td>
            </tr>
            <tr>
                <td style="width: 30%;">
                    @if($receipt_print->downpayment != '')
                    <input type="checkbox" id="cash" name="payment" value="cash" checked>
                    <label for="cash"> Down Payment</label>
                    @endif
                </td>
                <td style="width: 30%;">
                    
                    <input type="checkbox" id="cheque" name="payment" value="cheque">
                    <label for="cheque">Installment</label>
                    
                </td>
                <td style="width: 30%;">
                    <input type="checkbox" id="cheque" name="payment" value="cheque">
                    <label for="cheque"> Other(specify)</label>
                    <br>
                    <br>
                </td>
                <td colspan="7">

                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <br>
                    <br>
                    <label for="exampleInputEmail1">Received Amount. {{$receipt_print->downpayment}}</label>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <label for="exampleInputEmail1">Remaining Balance. {{$balance}}</label>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <br>
                    <br>
                    <label for="exampleInputEmail1">______________________ </label>
                </td>
                <td colspan="6">
                    <label for="exampleInputEmail1"> </label>
                </td>
                <td colspan="2">
                    <br>
                    <br>
                    <br>
                    <label for="exampleInputEmail1">______________________ </label>
                </td>
            </tr>
            <tr>
                <td colspan="2">

                    <label for="exampleInputEmail1">Prepared By. </label>
                </td>
                <td colspan="4">
                    <label for="exampleInputEmail1"> </label>
                </td>
                <td colspan="3">
                    <label for="exampleInputEmail1">Approved By </label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="exampleInputEmail1">Accounts Exective. </label>
                </td>
                <td colspan="4">
                    <label for="exampleInputEmail1"> </label>
                </td>
                <td colspan="3">
                    <br>
                    <label for="exampleInputEmail1">Manager Finace </label>
                </td>
            </tr>
        </table>

    </div>
</div>
<br/>
<br/>
<br/> 
</body>
</html>