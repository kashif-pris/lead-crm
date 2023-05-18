<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

use App\Models\FinancialYear;
use App\Models\FinancialYearDetail;

use App\Models\Booking;
use App\Models\Transfer;
use App\Models\InstallmentMaster;
use App\Models\InstallmentDetails;
use App\Models\InstallmentType;
use App\Models\InstalmentPeriod;
use App\Models\InstalmentType;
use App\Models\ReciptDetails;
use App\Models\ReciptMaster;
use App\Models\Plot;
use App\Models\Token;
use Carbon\Carbon;
use DB;
use PDF;
use Storage;
use File;
use Auth;
use NumberFormatter;
use DNS2D;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $data = InstallmentMaster::select('*')->get();
        

        // dd($data);
        
        return view('payments.record',compact('dataType','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $booking = Booking::with('customers')->where('status' , 0)->get();
        $transfer = Transfer::with('customerTo')->get();
        $years = FinancialYear::get();
        $instalmentPeriod = InstallmentType::all();
        $instalmentType = InstalmentType::all();

        return view('payments.create',compact('transfer','dataType','years','booking','instalmentPeriod','instalmentType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  


    public function show($id)
    {
        
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
      
        $data = InstallmentMaster::where('InstallmentId',$id)->with(['details','customers'])->first();
        // dd($data);
    
        $status = Plot::where('office_no',$data->Location)->with('block')->first();
        // dd($status);
        $data2 = ReciptMaster::where('sal_customer_id' , $data->customerid)->get();
        
        $data3 = InstallmentDetails::where('InstallmentId' , $id)->orderBy('InsatllmentDetailsid', 'desc')->first();

    //    dd($data3->Payment_Type);
       
        return view('payments.view',compact('dataType','data','status' , 'data2' , 'data3'));
    }

    public function storePaidInstallment(Request $request )
    {
        // dd($request['installment_id']);
        // dd($request['Payment_For']);
    //  dd($request->all());

        if($request['Payment_For'] == 'development' || $request['Payment_For'] == 'poession')
        {
            // return 'you are in right condition';
            $value_chargers = InstallmentMaster::where('InstallmentId' , $request['installment_id'])->first();
            if($request['Payment_For'] == 'development' ){
                $value_chargers->development_charges = $request['received_amount'];
                
             }elseif($request['Payment_For'] == 'poession'){
                   $value_chargers->possession_charges = $request['received_amount'];
            }


            $value_chargers->save();
            // return 'value save';

            $userID= Auth::user()->id;
            $dt = Carbon::now();
            $current_date = $dt->toDayDateTimeString();
            $FinancialYear = DB::table('GLFinancialyear')->latest('Financialyear')->select('Financialyear')->where('YearStatus', 'open')->first();
            $invoiceSerial = DB::table('tbl_sal_receipt_master')->latest('sal_receipt_no')->select('sal_receipt_no', 'sal_invoice_no')->first();
        
            if ($invoiceSerial) {
                $sal_receipt_no = ++$invoiceSerial->sal_receipt_no;
                $sal_invoice_no = ++$invoiceSerial->sal_invoice_no;
            } else {
                $sal_receipt_no = 'REC-'.$dt->year.'-'.$dt->month.'-T0001';
                $sal_invoice_no = 'FC-'.$dt->year.'-'.$dt->month.'-T0001';
            }

          
            $payment = new ReciptMaster();
            $payment->GroupId = 1;
            $payment->CompanyId = 8;
            $payment->sal_receipt_no = $sal_receipt_no;
            $payment->sal_receipt_type = $request->Payment_For;
            $payment->installment_id =$request['installment_id'];
            $payment->sal_customer_id =$value_chargers->customerid;
            $payment->sal_receipt_date = $dt->format('Y-m-d');
            $payment->sal_status = "Draft";
            $payment->FinancialYear = $FinancialYear->Financialyear;
            $payment->month = $dt->format('F').','.$dt->year;
            $payment->sal_receipt_mode = $request->Payment_For;
            $payment->sal_entered_by = Auth::user()->id;
            $payment->sal_receivbale_amount = $request['received_amount'];
            $payment->sal_rcv_amount =$request['received_amount'];
            $payment->sal_balance_amount =  '0';
            $payment->sal_gl_status = "False";
            $payment->sal_invoice_no = $sal_invoice_no;
            $payment->sal_cash_bank = "Bank";
            //  $payment->sal_paid_amount = 10000;
                // return $payment;
            //  dd($payment);
            if ($payment->save()) {
                $payment_detail = new ReciptDetails();
                $payment_detail->GroupId=$payment->GroupId;
                $payment_detail->CompanyId=$payment->CompanyId;
                $payment_detail->sal_receipt_no=$payment->sal_receipt_no;
                $payment_detail->sal_invoice_no= $payment->sal_invoice_no;
                $payment_detail->sal_invoice_date=$payment->sal_receipt_date;
                $payment_detail->SubLedgerCode=01;
                $payment_detail->AccountCode= "08010004";
                $payment_detail->sal_invoice_value=$payment->sal_rcv_amount;
                $payment_detail->sal_amount=$payment->amount;
                $payment_detail->sal_recieveable=$payment->sal_rcv_amount;
                $payment_detail->sal_rcvd_amount=$payment->sal_rcv_amount;
                $payment_detail->sal_balance=0;
                $payment_detail->sal_status="Draft";
                $payment_detail->sal_det_complete_status="True";
            }
                $payment_detail->save();
                return back();
        }else{
            
            $value3 = InstallmentDetails::where('InsatllmentDetailsid' , $request->id)->first();
            DB::beginTransaction();
            try {
            foreach($request->id as $i=>$id)
            {
                $value = InstallmentDetails::where('InsatllmentDetailsid' , $id)->first();
                $value2 = InstallmentMaster::where('InstallmentId' , $value3->InstallmentId)->first();
    
                // dd($value , $value2);
    
                $userID= Auth::user()->id;
                $dt = Carbon::now();
                $current_date = $dt->toDayDateTimeString();
                $FinancialYear = DB::table('GLFinancialyear')->latest('Financialyear')->select('Financialyear')->where('YearStatus', 'open')->first();
                $invoiceSerial = DB::table('tbl_sal_receipt_master')->latest('sal_receipt_no')->select('sal_receipt_no', 'sal_invoice_no')->first();
            
                if ($invoiceSerial) {
                    $sal_receipt_no = ++$invoiceSerial->sal_receipt_no;
                    $sal_invoice_no = ++$invoiceSerial->sal_invoice_no;
                } else {
                    $sal_receipt_no = 'REC-'.$dt->year.'-'.$dt->month.'-T0001';
                    $sal_invoice_no = 'FC-'.$dt->year.'-'.$dt->month.'-T0001';
                }

                if($value->AmountReceived != 0){
                            $amountRec = $value->AmountReceived+$request->receivedAmount[$i];
                }else{
                    $amountRec = $request->receivedAmount[$i];

                }
                $paid = ReciptMaster::where('installment_id',$id)->latest()->first();
               if(isset($paid)){
                   $monthyly = $paid->sal_balance_amount;
               }else{
                    $monthyly = $value3->MonthlyInstallment;

               }
  
                $payment = new ReciptMaster();
                $payment->GroupId = 1;
                $payment->CompanyId = 8;
                $payment->sal_receipt_no = $sal_receipt_no;
                $payment->sal_receipt_type = $request->Payment_For;
                $payment->installment_id =$value->InsatllmentDetailsid;
                $payment->sal_customer_id =$value2->customerid;
                $payment->sal_receipt_date = $dt->format('Y-m-d');
                $payment->sal_status = "Draft";
                $payment->FinancialYear = $FinancialYear->Financialyear;
                $payment->month = $dt->format('F').','.$dt->year;
                $payment->sal_receipt_mode = $request->Payment_For;
                $payment->sal_entered_by = Auth::user()->id;
                $payment->sal_receivbale_amount = $value3->MonthlyInstallment;
                $payment->sal_rcv_amount =$request->receivedAmount[$i];
                $payment->sal_balance_amount =  $monthyly- $request->receivedAmount[$i];
                $payment->sal_gl_status = "False";
                $payment->sal_invoice_no = $sal_invoice_no;
                $payment->sal_cash_bank = "Bank";
                //  $payment->sal_paid_amount = 10000;
                    // return $payment;
                //  dd($payment);
                if ($payment->save()) {
                    
                    $payment_detail = new ReciptDetails();
                    $payment_detail->GroupId=$payment->GroupId;
                    $payment_detail->CompanyId=$payment->CompanyId;
                    $payment_detail->sal_receipt_no=$payment->sal_receipt_no;
                    $payment_detail->sal_invoice_no= $payment->sal_invoice_no;
                    $payment_detail->sal_invoice_date=$payment->sal_receipt_date;
                    $payment_detail->SubLedgerCode=01;
                    $payment_detail->AccountCode= "08010004";
                    $payment_detail->sal_invoice_value=$payment->sal_rcv_amount;
                    $payment_detail->sal_amount=$payment->amount;
                    $payment_detail->sal_recieveable=$payment->sal_rcv_amount;
                    $payment_detail->sal_rcvd_amount=$payment->sal_rcv_amount;
                    $payment_detail->sal_balance=0;
                    $payment_detail->sal_status="Draft";
                    $payment_detail->sal_det_complete_status="True";
                }
                    $payment_detail->save();

                    DB::table('InsatllmentDetails')->where('InsatllmentDetailsid',$id)->update(['AmountReceived'=>$amountRec,'Payment_Type'=>$request->Payment_Type , 'Payment_For'=>$request->Payment_For , 'paidDate'=>$dt , 'due_sur_charge_amount' => $request->due_sur_charge_amount]);
                
                    DB::commit();
                    $qr = new ApiController();
                    $qr->generate_qr($payment->getTable(), $payment->sal_receipt_no, $value2);
                    
           }
                return back();
            } catch (\Exception $e) {
                DB::rollback(); 
                // something went wrong
                dd($e);
                
            }
        }
        
    
 }
  
    public function search(Request $request)
    {
        $id = $request->BookingID;
        $booking = Booking::where('id',$id)->with('down_payments')->first();
        $token_date = Token::where('plot_id' , $booking->plot_id)->first();
       
        return response()->json([
            'amount' => $booking->amount,
            'deal_amount' => $token_date->deal_amount,
            'down_payment' => $booking->down_payments->amount,
            'token' => $booking->down_payments->token_amount,
            'token_date' => $token_date->expriry_date,
            'discount' => $booking->down_payments->discount,
            


        ]);
    }

    public function transferSearch(Request $request)
    {
        $id = $request->transferID;
        $transfer = Transfer::where('id',$id)->orderbyDesc('id')->first();
       
        return response()->json([
            'amount' => $transfer->remaining_amount,
            'down_payment' => $transfer->down_payment,
            'token' => 0
            ]);
    }
    

    public function store(Request $request)
    {
        
        // dd($request->all());
        // 
        // dd($request->year);
  
        $installment_plan = $this->getInstallmentPreview($request);

        // dd($installment_plan);
        $booking = Booking::with('customers','nominees')->where('id',$request->booking_id)->first();
       
        // dd($installment_plan,$request->all());
        $serial = InstallmentMaster::orderByDesc('InstallmentId')->limit(1)->first();

        $monthDetail = FinancialYearDetail::where('GLFinancialYear',$request->year)->where('Description',$request->month)->first()->MonthStart;
        // dd($monthDetail);
            if(isset($serial)){
                $sal_customer_inc = ++explode('-',$serial->InstallmentId)[3];
                $inc = "INS-".explode(",",$request->month)[1]."-".explode('-',$monthDetail)[1]."-".$sal_customer_inc;         
                $sal_customer_desig = ++$inc;
            }else{
                $sal_customer_desig =  "INS-".explode(",",$request->month)[1]."-".explode('-',$monthDetail)[1]."-T0001";
            }
            // dd($sal_customer_desig);
       
        // if($serial)
        // {
        //     $sal_customer_desig = ++$serial->InstallmentId;
        // }else{
        //     $sal_customer_desig = 'INS-'.date("Y").'-'.date("m").'-T0001';
        // }
         

        //         dd($sal_customer_desig);
        $dt = Carbon::createFromFormat('Y-m-d', $request->installment_date);

        $insMaster = new InstallmentMaster();

        $insMaster->FinancialYear = $request->year;
        $insMaster->ins_Month = $request->month;
        // $insMaster->transfer_id = $transfer_id;

        $insMaster->InstallmentId = $sal_customer_desig;
        $insMaster->CompanyId = 8;
        $insMaster->Area = null;
        $insMaster->tenureid = count($installment_plan['paymentDate']) - 1;
        $insMaster->paymentplan = 0;
        $insMaster->propertyprice = $request->deal_amount;
        $insMaster->downpayment = $request->down_payment;
        $insMaster->Bulletpayment = 0.00;
        $insMaster->clientName =   $booking->customers->sal_customer_name;
        $insMaster->clientCnic =   $booking->customers->sal_customer_cnic;
        $insMaster->SO = $booking->customers->sal_customer_cont_person;
        $insMaster->SOCnic = $booking->customers->sal_customer_cnic;
        $insMaster->Nominee = $booking->nominees[0]->name;
        $insMaster->NomineeCnic = $booking->nominees[0]->cnic;
        $insMaster->NomineeCell =  $booking->nominees[0]->phone;
        $insMaster->CommAddress =  $booking->nominees[0]->phone;
        $insMaster->ClientEmailAddress =  $booking->customers->sal_customer_email;
        $insMaster->DateOfBooking = $dt->format('Y-m-d H:i:s');
        $insMaster->PlotPriceRegular =  $request->deal_amount;
        $insMaster->PlotPremium = 0.00;
        $insMaster->TotalAgreedPrice =  $request->deal_amount;
        $insMaster->Commission = $booking->agent_amount;
        $insMaster->FormNo = $booking->id;
        $insMaster->AgentStatus = "False";
        $insMaster->PlotSize = explode('-',$booking->plot_size)[0];
        $insMaster->Location = $booking->plots[0]->office_no;
        $insMaster->customerid = $booking->customers->id;
        $insMaster->DueDate =  $request->date_of_installment; 
        $insMaster->balloon_payment = $request->balloon_payment;
        $insMaster->possession_charges = $request->possession_charges;
        $insMaster->development_charges = $request->development_charges;
        // $insMaster->paymentplan = $request->installment_period .'months';
        $insMaster->installment_period = $request->installment_period;
        $insMaster->instalment_type = $request->instalment_type;
        // $insMaster->sal_entry_type = "temp";
        
        if($insMaster->save()){

          
            for($z = 0; $z < (count($installment_plan['paymentDate']) - 1); $z++) {
                $insDetail = new InstallmentDetails();
                $insDetail->InstallmentId =  $insMaster->InstallmentId;
                $insDetail->CompanyId =  $insMaster->CompanyId;
                $insDetail->month =  $request['paymentDate'][$z];
                $insDetail->MonthlyInstallment =  filter_var($installment_plan['ScheduledPayment'][$z+1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $insDetail->Bulletpayment =  0;
                $insDetail->AmountReceived =  0;
                $insDetail->balloon_payment =  $request->balloon_payment;
                $insDetail->outstandingbalance =  filter_var($installment_plan['remainingBalance'][$z+1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $insDetail->save();

            }
        }

        $mobile = $booking->customers->sal_customer_cell;
        $message = "Mr . ".$booking->customers->sal_customer_name." Your instalment plan has been created against Plot (".$booking->plots[0]->name.") .";
        $path = '/admin/payments/record';
        $return_message = 'Installment has been created successfully';
        

        return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);
        



    }

    function getInstallmentPreview(Request $request)
    {
        // dd($request->all());
        // (object)$request->all();
        // return $request->installment_Type;
        $installmentType = (int) $request->installment_Type;

        $balloonPayment = $request->balloon_payment;
        $perMonth = $request->per_month;

         $value = ($perMonth + $balloonPayment);

        $plotAmount = $request->plot_amount;
        $downPayment = $request->down_payment;
        $remainingAmount = $request->remaining_amount;
        $periodType = round($remainingAmount/$value);
        $dateOfInstallment = $request->installment_date;
        //dd($plotAmount,$downPayment,$remainingAmount,$periodType,$dateOfInstallment,$perMonth,$balloonPayment);
        $installmentData = [
                'paymentDate' => [],
                'begningBalance' => [],
                'ScheduledPayment' => [],
                'remainingBalance' => [],
                'systemDate' => []
        ];
        $dt = Carbon::createFromFormat('Y-m-d', $request->installment_date);
        $dtt = Carbon::createFromFormat('Y-m-d', $request->installment_date);
        $installmentData['paymentDate'][] = $dtt->format('M, d Y');
        $installmentData['systemDate'][]=$dt->format('Y-m-d');
        $installmentData['begningBalance'][]=number_format($plotAmount);
        $installmentData['ScheduledPayment'][]=number_format($downPayment);
        $installmentData['remainingBalance'][]=number_format(($plotAmount)-$downPayment);

        for ($i = 0; $i <= $periodType-1; $i++) {
            if (number_format($remainingAmount-$perMonth*$i) != 0) {
               $installmentData['paymentDate'][]=$dtt->addMonths($installmentType)->format('M, d Y');
               $installmentData['systemDate'][]=$dt->addMonths($installmentType)->format('Y-m-d');
                $installmentData['begningBalance'][]=number_format($remainingAmount-$value*$i);
                if ($i == $periodType-1) {
                    $installmentData['ScheduledPayment'][]=number_format($remainingAmount-$value*$i);
                    $installmentData['remainingBalance'][]=number_format((($remainingAmount-$value*$i)-(($remainingAmount-$value*$i))));
                }else{
                    $installmentData['ScheduledPayment'][]=number_format($value);
                    $installmentData['remainingBalance'][]=number_format((($remainingAmount)-(($value)*($i+1))));

                }
              
            } 
        }
        
        return ($installmentData);
    }
    
    public function getInstallmentPeriodAction() {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $data = InstallmentMaster::all();

        // dd($data);

        $installment_data = InstalmentPeriod::get();
        // dd($installment_data);

        return view('payments.instalment.period',compact('dataType','data' , 'installment_data'));
    }

    public function createInstalmentPeriodAction(Request $request) {
        $this->validate($request,['period'=>'required']);
        $instalmentPeriod = new InstalmentPeriod;
        $instalmentPeriod->name = $request->period;
        $instalmentPeriod->save();
        
        return back()->with('success', 'Record Created Successfully....!');
        
    }

    public function getInstallmentPaymentTypeAction() {
        $slug = 'roles';
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
        $data = InstallmentMaster::all();

        $installmentType = InstalmentType::get();
        // dd($installmentType);

        // dd($dataType, $data, $installmentType);

        return view('payments.instalment.type',compact('dataType','data' , 'installmentType'));
    }

    public function createInstalmentTypeAction(Request $request) {
        $this->validate($request,['type'=>'required', 'type_value' => 'required']);
        $instalmentType = new InstalmentType;
        $instalmentType->name = $request->type;
        $instalmentType->value = $request->type_value;
        if(isset($request->balloon)) {
            $instalmentType->balloon_payment = 1;
        }
        $instalmentType->save();
        
        return back()->with('success', 'Record Created Successfully....!');
    }


    public function installmentPeriodEdit($id)
    {
        $value = $id;

        $installment_data = InstalmentPeriod::where('id' , $value)->first();

        // dd($installment_data->name);

        return view('payments.instalment.editInstallment' , compact('installment_data'));
    }

    public function updatePeriodInstallment(Request $request)
    {
    //    return 'khan';
        
        $user = $request->all();
        // dd($user);
        $value = $user['periodInstallment'];
        $valueId = $user['periodId'];
        // dd($value , $valueId);
        $updateValue = InstalmentPeriod::where('id' , $valueId)->first();
        $updateValue->name = $value;
        $updateValue->save();

        return redirect('/admin/payments/instalment/period')->with('message','Installment Period has been Updated ... !');
        // return view('payments.instalment.period');
    }

    public function installmentPeriodDelete($id)
    {
        InstalmentPeriod::where('id',$id)->delete();
        return redirect('/admin/payments/instalment/period')->with('message','Installment Period has been Deleted ... !');
    }

    public function installmentTypeEdit($id)
    {
        $value = $id;
        $installment_data = InstalmentType::where('id' , $value)->first();
        return view('payments.instalment.editTypeInstallment' , compact('installment_data'));
    }

    public function updateInstallmentType(Request $request)
    {
        $this->validate($request,['type'=>'required', 'type_value' => 'required']);
        // dd($request->typeId);
        $instalmentType = InstalmentType::where('id' , $request->typeId)->first();
        // dd($instalmentType);
        $instalmentType->name = $request->type;
        $instalmentType->value = $request->type_value;
        if(isset($request->checkbox_value)) {
            $instalmentType->balloon_payment = 1;
        }

        // dd($instalmentType);
        $instalmentType->save();
        
        return redirect('/admin/payments/instalment/payment-type')->with('success', 'Record Created Successfully....!');

    }
    public function installmentTypeDelete($id)
    {
       InstalmentType::where('id',$id)->delete();
       return redirect('/admin/payments/instalment/payment-type')->with('message','Installment Type has been Deleted ... !');
    }

    public function createPF($id)
    {
        
        $receipt_print = InstallmentMaster::where('InstallmentId' , $id)->first();
       
        $date = date('d-F-Y', strtotime($receipt_print->DateOfBooking));

        $MonthlyInstallment = $receipt_print->propertyprice;
    
        $AmountReceived = $receipt_print->downpayment;

        $programFee = $receipt_print->downpayment;
        $receiveAble = number_format( $programFee);
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $amountInword = ($digit->format(intval($programFee)));
        $balance = number_format($MonthlyInstallment - $AmountReceived);

        $pdf = PDF::loadView('receipts.printModel',  compact('receipt_print' , 'date' , 'amountInword' , 'balance'))->setOptions(['defaultFont' => 'italic']);
        
        Storage::put('public/Files/' . $receipt_print->InstallmentId .'/'.$id.' '.'Down Payment Receipt', $pdf->output());

        return $pdf->download('Down Payment Receipt.pdf');
    }

    public function createPrint($id)
    {
        // dd($id);
        $receipt_print = InstallmentDetails::where('InsatllmentDetailsid' , $id)->first();
      
        $MonthlyInstallment = InstallmentDetails::where('InstallmentId' , $receipt_print->InstallmentId)->sum('MonthlyInstallment');
        $AmountReceived = InstallmentDetails::where('InstallmentId' , $receipt_print->InstallmentId)->sum('AmountReceived');

        $check_value = ReciptMaster::where('installment_id' , $id)->get();
        $date = date('d-F-Y', strtotime($receipt_print->month));

        $master = InstallmentMaster::where('InstallmentId' , $receipt_print->InstallmentId)->first();

                    $programFee = $receipt_print->AmountReceived;
                    $receiveAble = number_format( $programFee);
                    $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                    $amountInword = ($digit->format(intval($programFee)));
                    $balance = number_format($MonthlyInstallment - $AmountReceived);

        // dd($MonthlyInstallment , $AmountReceived , $balance);


        $pdf = PDF::loadView('receipts.printReceipt',  compact('receipt_print' , 'master' , 'date' , 'amountInword' , 'balance' ,'check_value'))->setOptions(['defaultFont' => 'italic']);
        
        Storage::put('public/Files/' . $receipt_print->InstallmentId .'/'.$id.' '.'Print Receipt', $pdf->output());

        return $pdf->download($id.' '.'Receipt.pdf');

    }


    public function recovery(Request $request)
    {
            $customer = Booking::where('status','Approved')->count();
            $date = date('Y-m-d H:i:s');
            $today = ReciptMaster::where('created_at', '>=' ,$date)->get();
            $today_recovery = ReciptMaster::where('created_at', '>=' ,$date)->count();

            $d = strtotime("today");
            $start_week = strtotime("last sunday midnight",$d);
            $end_week = strtotime("next saturday",$d);
            $start = date("Y-m-d",$start_week); 
            $end = date("Y-m-d",$end_week);
            $week_recovery = ReciptMaster::where('created_at', '>=' ,$start)->orWhere('created_at' , '<=' , $end)->get();
            $week_recovery_count = ReciptMaster::where('created_at', '>=' ,$start)->orWhere('created_at' , '<=' , $end)->count();
        return view('dashboardview.partials.recoveryMan' ,compact('customer' , 'today' , 'today_recovery' ,'week_recovery','week_recovery_count') );
    }



  


}
