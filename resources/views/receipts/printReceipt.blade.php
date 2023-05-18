<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lion Group</title>
</head>
<style>
    p{
        text-align:center;
    }
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
 page {
        background: #fff;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
      
        }
        page[size="A4"] {  
        width: 21cm;
        height: 29.7cm; 
        }
        @media print {
        body, page {
            margin: 0;
            box-shadow: 0;
        }
    }
    .lion-group{
        border: 1px solid #000;
        padding: 10px;
    }
    .receipt-wrap{
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 3px 0px;
    }
    .receipt-w{
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 3px 0px;
    }
    .recipt{
        display: flex;
        justify-content: center;
        align-items: end;
        width: 50%;
    }
    .recipt p:nth-child(2){
        border-bottom: 1px solid #000;
        width: 50%;
    }
    .received{
        width: 100%;
    }
</style>
@php
        $test = $data->price;
        $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );
        $word = $f->format($test);
@endphp
<body>
    <page size="A4">
        <div class="lion-group">        
            <div class="receipt-wrap">
                <div>
                    <img src="http://124.29.208.60:4247/storage/settings/November2022/wW7VXzoZ9z6EAs4mrdTW.png" alt="" style="width:100px;">
                </div>
                <div>
                    <p> <span style="border: 1px solid blue; border-radius: 50px; font-weight: 700; font-size: 12px; padding: 5px 20px;">Customer Copy</span></p>
                </div>
            </div>
            <div class="receipt-wrap">
                <div class="recipt">
                    <p style="font-weight: 700;">Receipt No.</p><p>{{@$data->id}}</p>
                </div>
                <div class="recipt">
                    <p style="font-weight: 700;">Dated:</p><p>{{ date('Y-m-d H:i:s') }}</p>
                </div>
            </div>
            <div class="receipt-wrap">
                <p style="width: 35%;">Received with thanks from Mr./Mrs/Miss:</p>
                <p style="width: 65%; border-bottom: 1px solid #000;"> {{@$data->customers->name}}</p>
            </div>
            <div class="receipt-wrap">
                <div class="receipt-w" style="width: 48%;">
                    <p style="width: 30%;">S/O, D/O, W/O</p>
                    <p style="width: 70%; border-bottom: 1px solid #000;">{{@$data->customer_rel}}</p>
                </div>
                <div class="receipt-w" style="width: 48%;">
                    <p style="width: 25%;">Contact No:</p>
                    <p style="width: 75%; border-bottom: 1px solid #000;">{{@$data->customers->phone}}</p>
                </div>
            </div>
            <div class="receipt-w" >
                <p style="width: 15%;">A Sum of Rupees</p>
                <p style="width: 85%; border-bottom: 1px solid #000;"> {{@$word}}</p>
            </div>
            <div class="receipt-wrap">
                <div class="receipt-w" style="width: 68%;">
                    <p>In Cash/ Cheque/Pay Order/ Bank Draft</p>
                    <p style="width: 50%; border-bottom: 1px solid #000;">{{@$data->payment_type}}</p>
                </div>
                <div class="receipt-w" style="width: 30%;">
                    <p>Dated:</p>
                    <p style="width: 85%; border-bottom: 1px solid #000;">{{ date('Y-m-d H:i:s') }}</p>
                </div>
            </div>
            <div class="receipt-w">
                <div class="receipt-w" style="width: 40%;">
                    <p>File/ Plot No/ Form No</p>
                    <p style="width: 50%; border-bottom: 1px solid #000;">{{@$data->office_no}}</p>
                </div>
                <div class="receipt-w" style="width: 28%;">
                    <p>block</p>
                    <p style="width: 80%; border-bottom: 1px solid #000;">{{@$data->block->name}}</p>
                </div>
                <div class="receipt-w" style="width: 28%;">
                    <p>Size</p>
                    <p style="width: 80%; border-bottom: 1px solid #000;">{{@$data->sizeGet->name}}</p>
                </div>
            </div>
            <div class="receipt-wrap">
                <div class="recipt">
                    <p style="font-weight: 700;">Rs:</p>
                    <p>{{@$data->price}}</p>
                </div>
                <div class="recipt">
                    <p style="font-weight: 700;">For LION HBD</p><p></p>
                </div>
            </div>
            <div style="text-align: center; font-size: 18px; font-weight: 700; padding: 10px 0px;">
                <p>Mehmood Kasori Road Gulberg  3 Lahore.  0311-1222977</p>
            </div>
        </div>
        <div style="border: 1px dashed #000; margin: 10px 0px;"></div>

        <div class="lion-group">        
            <div class="receipt-wrap">
                <div>
                <img src="http://124.29.208.60:4247/storage/settings/November2022/wW7VXzoZ9z6EAs4mrdTW.png" alt="" style="width:100px;">
                </div>
                <div>
                    <p> <span style="border: 1px solid blue; border-radius: 50px; font-weight: 700; font-size: 12px; padding: 5px 20px;">Office Copy</span></p>
                </div>
            </div>
            <div class="receipt-wrap">
                <div class="recipt">
                    <p style="font-weight: 700;">Receipt No.</p><p>{{@$data->id}}</p>
                </div>
                <div class="recipt">
                    <p style="font-weight: 700;">Dated:</p><p>{{ date('Y-m-d H:i:s') }}</p>
                </div>
            </div>
            <div class="receipt-wrap">
                <p style="width: 35%;">Received with thanks from Mr./Mrs/Miss:</p>
                <p style="width: 65%; border-bottom: 1px solid #000;"> {{@$data->customers->name}}</p>
            </div>
            <div class="receipt-wrap">
                <div class="receipt-w" style="width: 48%;">
                    <p style="width: 30%;">S/O, D/O, W/O</p>
                    <p style="width: 70%; border-bottom: 1px solid #000;">{{@$data->customer_rel}}</p>
                </div>
                <div class="receipt-w" style="width: 48%;">
                    <p style="width: 25%;">Contact No:</p>
                    <p style="width: 75%; border-bottom: 1px solid #000;">{{@$data->customers->phone}}</p>
                </div>
            </div>
            <div class="receipt-w" >
                <p style="width: 15%;">A Sum of Rupees</p>
                <p style="width: 85%; border-bottom: 1px solid #000;"> {{@$word}}</p>
            </div>
            <div class="receipt-wrap">
                <div class="receipt-w" style="width: 68%;">
                    <p>In Cash/ Cheque/Pay Order/ Bank Draft</p>
                    <p style="width: 50%; border-bottom: 1px solid #000;">{{@$data->payment_type}}</p>
                </div>
                <div class="receipt-w" style="width: 30%;">
                    <p>Dated:</p>
                    <p style="width: 85%; border-bottom: 1px solid #000;">{{ date('Y-m-d H:i:s') }}</p>
                </div>
            </div>
            <div class="receipt-w">
                <div class="receipt-w" style="width: 40%;">
                    <p>File/ Plot No/ Form No</p>
                    <p style="width: 50%; border-bottom: 1px solid #000;">{{@$data->office_no}}</p>
                </div>
                <div class="receipt-w" style="width: 28%;">
                    <p>block</p>
                    <p style="width: 80%; border-bottom: 1px solid #000;">{{@$data->block->name}}</p>
                </div>
                <div class="receipt-w" style="width: 28%;">
                    <p>Size</p>
                    <p style="width: 80%; border-bottom: 1px solid #000;">{{@$data->sizeGet->name}}</p>
                </div>
            </div>
            <div class="receipt-wrap">
                <div class="recipt">
                    <p style="font-weight: 700;">Rs:</p>
                    <p>{{@$data->price}}</p>
                </div>
                <div class="recipt">
                    <p style="font-weight: 700;">For LION HBD</p><p></p>
                </div>
            </div>
            <div style="text-align: center; font-size: 18px; font-weight: 700; padding: 10px 0px;">
                <p>Mehmood Kasori Road Gulberg  3 Lahore.  0311-1222977</p>
            </div>
        </div>
    </page>
</body>
</html>