<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\PACController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\MergeController;
use App\Http\Controllers\CancelationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NdcController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ChartOfAccountController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\VoyagerAuthController;
use App\Http\Controllers\VoyagerController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\FullCalenderController;
use Facebook\Facebook;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    // return what you want
    dd('clear');
});
Route::get('/', function () {
     return redirect('/admin/login');
});
//report
Route::get('/admin/uan-configration',[LeadsController::class,'UANConfigrationView'])->name('UANConfigrationView');
Route::post('/admin/api-configration', [LeadsController::class, 'configrationApi'])->name('apiconfig.store');

Route::get('admin/pending-followups',[LeadsController::class,'pendingFollowups'])->name('pendingFollowups');
Route::get('/admin/followup/date-filter',[LeadsController::class,'date_filter'])->name('date-filter');
Route::get('/admin/pending-followup/date-filter',[LeadsController::class,'pending_date_filter'])->name('pending_date_filter');
Route::get('/admin/client-list',[LeadsController::class,'ClientList'])->name('Client-list');
Route::get('/admin/client-list/download',[LeadsController::class,'get_export'])->name('get_export');
Route::get('/admin/follow-up-list',[LeadsController::class,'FollowUplist'])->name('followup-list');
Route::get('/admin/agent-wise-report',[LeadsController::class,'AgentwiseReport'])->name('agent-wise-report');
Route::get('/admin/search-leads-report',[LeadsController::class,'AgentwiseStatusReport'])->name('user-report-status');
Route::get('/admin/u-a-n-leads',[LeadsController::class,'getUANleads'])->name('UANleads');
Route::get('/admin/uan-leads/date-filter',[LeadsController::class,'uandate_filter'])->name('uan-date-filter');

Route::post('/admin/status-update/{id}', [LeadsController::class, 'StatusChangeFollowups']);
// clander
Route::get('full-calender', [FullCalenderController::class, 'index']);

Route::post('full-calender/action', [FullCalenderController::class, 'action']);
Route::get('full-calender/{id}', [FullCalenderController::class, 'get']);
Route::post('full-calender/update-lead', [FullCalenderController::class, 'update']);


Route::get('admin/tokens/expire',[AdminController::class,'TokenExpire']);

Route::post('/postComment',[LeadsController::class,'post_comments'])->name('postComment');
Route::get('admin/coa',[ChartOfAccountController::class,'create']);
Route::get('admin/record',[ChartOfAccountController::class,'record']);
Route::post('/change_status-lead',[LeadsController::class,'change_lead_status'])->name('change_lead_status');
Route::post('/change_response_lead',[LeadsController::class,'change_lead_response'])->name('change_lead_response');
Route::group(['prefix' => 'admin'], function () {

    Voyager::routes();

    Route::group(['prefix' => '/messages'], function () {
        // Route::get('/create',[TransferController::class,'create']);
        Route::get('/received',[MessageController::class,'index']);
        Route::get('/view/{id}',[MessageController::class,'show']);
        Route::get('/sent',[MessageController::class,'sent']);
 });
  //leads
  Route::group(['prefix' => '/leads'], function () {
    Route::get('/file-import',[LeadsController::class,'importView'])->name('import-view');
    Route::post('/import',[LeadsController::class,'import'])->name('import');
    Route::get('/export-leads',[LeadsController::class,'exportLeads'])->name('export-leads');
    Route::get('/create',[LeadsController::class,'create']);
    Route::get('/show/{id}',[LeadsController::class,'show'])->name('leads.show');
    Route::get('/record',[LeadsController::class,'index'])->name('leads.record');
    Route::post('/store',[LeadsController::class,'store'])->name('leads.store');
    Route::get('/delete',[LeadsController::class,'destroy'])->name('leads.destroy');
    Route::get('/assigned-leads',[LeadsController::class,'AssingedLeads'])->name('leads.assigned');
    Route::get('/assigned-uan-leads',[LeadsController::class,'UanAssingedLeads'])->name('uan_leads.assigned');
    Route::get('/edit/{id}',[LeadsController::class,'edit']);
    Route::post('/update/{id}',[LeadsController::class,'update'])->name('leads.update');
    Route::get('/action-close/{id}',[LeadsController::class,'closeLead']);
    Route::post('/get-lead-date',[LeadsController::class,'getLeadsWithDateRange'])->name('leads.withDate');
    // leads filters
    Route::get('/new-leads',[LeadsController::class,'new']);
    Route::get('/{routeName}',[LeadsController::class,'GetLeadsBaseOnRouteName'])->name('leads.baseOnRouteName');

    Route::get('/search-lead',[LeadsController::class,'search'])->name('search-name');
    Route::get('/button-filter',[LeadsController::class,'button_filter'])->name('button-filter');
   
    // Leads filter
     Route::get('/get-filter/{name}',[LeadsController::class,'GetLeadsWithFilter'])->name('leads.withFilter');
    Route::get('/follow-up-list/{start_date}/{end_date}',[LeadsController::class,'GetLeadsbydate'])->name('leads.followup');
  
    Route::get('/delete/follow-up/{id}',[LeadsController::class,'deleteFollow'])->name('leads.followup');
    // get next 30 minutes followups
    Route::get('/get-next-30-minutes/follow-ups/get',[LeadsController::class,'Next30Minutes'])->name('Next30Minutes');
    //check interval followups
    Route::get('/get-overdue-followups/follow-ups/get',[LeadsController::class,'checkfollowup'])->name('checkfollowup');

//follow up records
        Route::get('/follow-up',[LeadsController::class,'followup'])->name('leads.followup');

     Route::post('/create-reminder',[LeadsController::class,'createReminderForLead'])->name('leads.createReminder');
     // reminder
     Route::get('/get-reminder/{id}',[LeadsController::class,'GetReminderWithLeadId'])->name('leads.reminders');
    //  Route::get('/delete-reminder/{id}', [LeadsController::class, 'deleteLeadReminderById'])->name('leads.delete-reminder');
         Route::post('/delete-reminder-event', [LeadsController::class, 'deleteLeadReminderById'])->name('leads.delete-reminder-event');
         Route::post('/delete-comment-chat', [LeadsController::class, 'deleteCommentChat'])->name('leads.comment-chat-');
         //  Route::get('/won-commission',[LeadsController::class,'won_commission']);
    Route::get('won-commission/{id}',[LeadsController::class,'won_commission'])->name('won-commission');
    // //activity log
    // Route::get('activity-log',[LeadsController::class,'activity_log'])->name('activity-log');
      // datables implementions
      Route::get('get-leads/server/side-loading',[LeadsController::class,'leadsIndex'])->name('leads-server-side-data');
      Route::post('/checkmobilenumber',[LeadsController::class,'mobile'])->name('checkmobilenumber');
     
});


 //  customers
 Route::group(['prefix' => '/tokens'], function () {
    Route::get('/create',[TokenController::class,'create']);
    Route::get('/record',[TokenController::class,'index']);
    Route::post('/store',[TokenController::class,'store'])->name('token.store');
    Route::get('/{id}',[TokenController::class,'show']);
    Route::get('/{id}/delete',[TokenController::class,'destroy']);
    Route::get('/{id}/edit',[TokenController::class,'edit']);
    Route::post('/update/{id}',[TokenController::class,'update'])->name('token.update');
    
    Route::get('/getofficeprice/{id}',[TokenController::class,'OfficPrice']);
});

//  agent
Route::group(['prefix' => '/agent'], function () {
    Route::get('/create',[AgentController::class,'create']);
    Route::get('/record',[AgentController::class,'index']);
    Route::post('/store',[AgentController::class,'store'])->name('agent.store');
    Route::get('/show/{id}',[AgentController::class,'show']);
    Route::get('/delete/{id}',[AgentController::class,'destroy']);
    Route::get('/edit/{id}',[AgentController::class,'edit']);
    Route::post('/update',[AgentController::class,'update'])->name('agent.update');
});

//  Token
Route::group(['prefix' => '/customer'], function () {
    Route::get('/create',[CustomerController::class,'create']);
    Route::get('/record',[CustomerController::class,'index']);
    Route::post('/store',[CustomerController::class,'store'])->name('customer.store');
    Route::get('/{id}',[CustomerController::class,'show']);
    Route::get('/delete/{id}',[CustomerController::class,'destroy']);
    Route::get('/{id}/edit',[CustomerController::class,'edit']);
    Route::post('/update/{id}',[CustomerController::class,'update'])->name('customer.update');
    Route::get('/get-record/{id}',[CustomerController::class,'getVisitor']);

});

//  transfer
    Route::group(['prefix' => '/transfer'], function () {
            Route::get('/create',[TransferController::class,'create']);
            Route::get('/record',[TransferController::class,'index']);
            Route::post('/store',[TransferController::class,'store'])->name('transfer.store');
            Route::get('/show/{id}',[TransferController::class,'show']);
            Route::get('/docs/{id}',[TransferController::class,'doc']);
            Route::get('/certificate/{id}',[TransferController::class,'certificate']);
            Route::get('/delete/{id}',[TransferController::class,'destroy']);
            Route::get('/edit/{id}',[TransferController::class,'edit']);
            Route::post('/update/{id}',[TransferController::class,'update']);
            Route::get('/approve/{id}',[TransferController::class,'approve']);
            Route::post('/reject',[TransferController::class,'unapprove'])->name('transfer.reject');
            Route::get('/plot/search',[TransferController::class,'search']);
            Route::get('/plot/searchyear',[TransferController::class,'searchyear']);
     });

     //  installments
    Route::group(['prefix' => '/payments'], function () {
        Route::get('/create',[PaymentController::class,'create']);
        Route::get('/record',[PaymentController::class,'index']);
        Route::post('/store',[PaymentController::class,'store'])->name('payment.store');
        Route::post('/store/receiveAmount',[PaymentController::class,'storePaidInstallment'])->name('payment.store.installment');
        Route::get('/installment/{id}',[PaymentController::class,'show']);
        Route::get('/search',[PaymentController::class,'search']);
        Route::get('/transferSearch',[PaymentController::class,'transferSearch']);
        Route::get('/getInstallmentPreview',[PaymentController::class,'getInstallmentPreview']);
        Route::get('/instalment/period',[PaymentController::class,'getInstallmentPeriodAction']);
        Route::post('/instalment/create-period',[PaymentController::class,'createInstalmentPeriodAction'])->name('period.create');
        Route::get('/instalment/payment-type',[PaymentController::class,'getInstallmentPaymentTypeAction']);
        Route::post('/instalment/create-type',[PaymentController::class,'createInstalmentTypeAction'])->name('type.create');


        Route::get('/{id}/edit',[PaymentController::class,'installmentPeriodEdit'])->name('period.edit');
        Route::get('/update-installment',[PaymentController::class,'updatePeriodInstallment']);
        Route::get('/{id}/delete',[PaymentController::class,'installmentPeriodDelete']);

        Route::get('/typeInstallment/{id}/edit',[PaymentController::class,'installmentTypeEdit']);
        Route::get('/update-installmentType',[PaymentController::class,'updateInstallmentType']);
        Route::get('/typeInstallment/{id}/delete',[PaymentController::class,'installmentTypeDelete']);

        Route::get('/createPF/{id}' , [PaymentController::class,'createPF']);
        Route::get('/createPrint/{id}' , [PaymentController::class,'createPrint']);

        Route::get('/chargesDetails' , [PaymentController::class,'chargesDetails']);




    });


    // Visitor Data
    Route::get('/visitor-create',[AdminController::class,'VisitorCreate']);
    Route::get('/visitor-data',[AdminController::class,'VisitorIndex']);
    Route::post('/visitor-data-store',[AdminController::class,'VisitorStore'])->name('visitor.store');
    Route::post('/visitor-update-data/{id}',[AdminController::class,'VisitorUpdate'])->name('visitor.update');
    Route::get('/visitor-data-show/{id}',[AdminController::class,'VisitorShow']);
    Route::get('/visitor-data-delete/{id}',[AdminController::class,'VisitorDelete']);
    Route::post('/visitor-send-message',[AdminController::class,'VisitorSendNessage'])->name('visitor.sendMessage');

   //  NDC

   Route::group(['prefix' => '/ndc'], function () {
    Route::get('/create',[NdcController::class,'index']);
    Route::get('/record',[NdcController::class,'record']);
    Route::post('/store',[NdcController::class,'store'])->name('ndc.store');
    Route::get('/show/{id}',[NdcController::class,'show']);
    Route::get('/docs/{id}',[NdcController::class,'doc']);
    Route::post('/save/{id}',[NdcController::class,'saveCertificate'])->name('saveNDC');
    Route::get('/certificate/{id}',[NdcController::class,'printCertificate']);
    Route::get('/delete/{id}',[NdcController::class,'destroy']);
    Route::get('/edit/{id}',[NdcController::class,'edit']);
    Route::post('/update/{id}',[NdcController::class,'update']);
    Route::post('/approve',[NdcController::class,'approveCertificate']);
    Route::post('/reject',[NdcController::class,'unapprove'])->name('transfer.reject');
    Route::get('/generate/{bookingID}',[NdcController::class,'printCertificate']); //print Request
    Route::post('/approve/certificate',[NdcController::class,'approveCertificate'])->name('approveNDC'); //print Request
});


// Merger started
     Route::group(['prefix' => '/merge'], function () {

        Route::get('/create',[MergeController::class,'create']);
        Route::get('/record',[MergeController::class,'index']);
        Route::post('/store',[MergeController::class,'store'])->name('merge.store');
        Route::get('/show/{id}',[MergeController::class,'show']);
        Route::get('/docs/{id}',[MergeController::class,'docs']);
        Route::get('/certificate/{id}',[MergeController::class,'certificate']);
        Route::get('/delete/{id}',[MergeController::class,'destroy']);
        Route::get('/edit/{id}',[MergeController::class,'edit']);
        Route::post('/update/{id}',[MergeController::class,'update'])->name('merge.update');
        Route::get('/approve/{id}',[MergeController::class,'approve']);
        Route::post('/reject',[MergeController::class,'reject'])->name('merge.reject');

        Route::get('/customer/search',[MergeController::class,'customerSearch']);
    });
    // Cancelation started
    Route::group(['prefix' => '/cancelation'], function () {
        Route::get('/create',[CancelationController::class,'create']);
        Route::get('/getBookings/{cID}',[CancelationController::class,'getBookings']);
        Route::get('/record',[CancelationController::class,'index']);
        Route::post('/store',[CancelationController::class,'store'])->name('cancelation.store');
        Route::get('/show/{id}',[CancelationController::class,'show']);
        Route::get('/docs/{id}',[CancelationController::class,'docs']);
        Route::get('/certificate/{id}',[CancelationController::class,'certificate']);
        Route::get('/delete/{id}',[CancelationController::class,'destroy']);
        Route::get('/edit/{id}',[CancelationController::class,'edit']);
        Route::post('/update/{id}',[CancelationController::class,'update'])->name('merge.update');
        Route::get('/approve/{id}',[CancelationController::class,'approve']);
        Route::post('/reject',[CancelationController::class,'unapprove'])->name('cancelation.reject');
    });


    Route::get('/application-form',[AdminController::class,'ApplicationForm'])->name('ApplicationForm');
    Route::get('/application-form/record',[AdminController::class,'record']);

    Route::get('/application-form/delete/{id}',[AdminController::class,'destroy']);
    Route::get('/application-form/show/{id}',[AdminController::class,'show']);
    Route::get('/application-form/docs/{id}',[AdminController::class,'docs']);

    Route::get('/application-form/edit/{id}',[AdminController::class,'edit']);
    Route::post('/application-form/update/{id}',[AdminController::class,'update']);
    Route::get('/booking/approve/{id}',[AdminController::class,'approveBooking']);
    Route::post('/booking/reject',[AdminController::class,'rejectBooking'])->name('booking.reject');

    Route::post('/application-form',[AdminController::class,'ApplicationFormStore'])->name('ApplicationForm');
    Route::post('/application-form/update',[AdminController::class,'update'])->name('ApplicationForm.update');
    Route::get('/application-form/plot/search',[AdminController::class,'search']);
    Route::get('/application-form/plot/search2',[AdminController::class,'search2']);
    Route::get('/application-form/customer/search',[AdminController::class,'customerSearch']);
    Route::get('/application-form/agent/search',[AdminController::class,'agentSearch']);
    Route::get('/allotment-form',[AdminController::class,'AllotmentForm'])->name('AllotmentForm');
    Route::get('/membership-transfer-form',[AdminController::class,'MembershipTransferForm'])->name('MembershipTransferForm');
    Route::get('/document',[DocumentController::class,'create'])->name('documnet.create');
    Route::post('/document',[DocumentController::class,'store'])->name('documnet.store');
    Route::get('/Getdocument/{fID}',[DocumentController::class,'getDocument'])->name('documnet.get');

    Route::get('/generate-receipt/{id}',[PlotController::class,'PlotReceipt'])->name('generate-plot-receipt');
    Route::get('plot/create',[PlotController::class,'create'])->name('plot.create');
    Route::post('plot/store',[PlotController::class,'store'])->name('plot_store');
    Route::post('plot/update/{id}',[PlotController::class,'update'])->name('plot_update');
    Route::get('plot/search',[PlotController::class,'search']);
    Route::get('plot/record',[PlotController::class,'index']);
    Route::get('plot/delete/{id}',[PlotController::class,'destroy']);
    Route::get('plot/show/{id}',[PlotController::class,'show']);
    Route::get('plot/edit/{id}',[PlotController::class,'edit']);
    Route::get('plot/import',[PlotController::class,'importExportView']);
    Route::get('plot/export', [PlotController::class, 'export'])->name('plot.export');
    Route::post('plot/import', [PlotController::class, 'import'])->name('plot.import');
// Provissioanal Allotment Certificates Starts
    Route::group(['prefix' => 'pac'], function () {
        // Voyager::routes();
        Route::get('/create',[PACController::class,'create']); //create
        Route::get('/generate/{bookingID}',[PACController::class,'printCertificate']); //print Request
        Route::get('/generate/duplicate/{bookingID}',[PACController::class,'printDCertificate']); //print Request
        Route::get('/generate/duplicate/{bookingID}/{index}',[PACController::class,'printDCertificate']); //print Request
        Route::post('/save/duplicate/{id}',[PACController::class,'saveDCertificate'])->name('saveDPAC'); //print Request
        Route::post('/save/{id}',[PACController::class,'saveCertificate'])->name('savePAC'); //print Request
        Route::post('/approve/certificate',[PACController::class,'approveCertificate'])->name('approvePAC'); //print Request
        Route::get('/details/{id}',[PACController::class,'pacDetails'])->name('pacDetails');
        Route::get('/pending',[PACController::class,'pending']); //pending
        Route::get('/approved',[PACController::class,'approved']); //approved
        Route::get('/certificates',[PACController::class,'index']); //certificates generated
        Route::get('/delivered',[PACController::class,'delivered']); //delivered
        Route::post('/reject',[PACController::class,'reject'])->name('pac.reject');
        Route::post('/deliver',[PACController::class,'deliver'])->name('pac.deliver');


    });
// Provissioanal Allotment Certificates Closed


     //  Reports
     Route::group(['prefix' => '/plot-report'], function () {
        Route::get('/transfer-details/{plotID}',[ReportController::class,'tranferDetails']);
        Route::get('/transfer',[ReportController::class,'index']);
        Route::get('/transfers',[ReportController::class,'search']);



    });
      //  Notifications
      Route::group(['prefix' => '/notifcations'], function () {
            Route::get('/today',[NotificationController::class,'index']);
            Route::get('/transfers',[ReportController::class,'search']);


        });

    Route::get('/recoveryMan' , [PaymentController::class , 'recovery']);

    Route::group(['prefix' => '/recovery-data'], function () {
        Route::get('/customer',[VoyagerController::class,'index_data'])->name('customersRecovery');
        Route::get('/transfers',[VoyagerController::class,'search']);
        Route::post('/save-model',[VoyagerController::class,'saveModel']);
    });

    Route::group(['prefix' => '/investors'], function () {
        Route::get('',[InvestorController::class,'index_data'])->name('investor-list');
        Route::get('/create-investor',[InvestorController::class,'create'])->name('create-investor');
        Route::post('/store-investor-record',[InvestorController::class,'storeInvestor'])->name('store-investor-record');
        Route::get('/edit-investor-info/{id}',[InvestorController::class,'edit'])->name('edit-investor');
        Route::post('/update-investor-info',[InvestorController::class,'updateInvestor'])->name('update-investor');
        Route::get('/show-investor-profile/{id}',[InvestorController::class,'show'])->name('show-Investor-Profile');
        Route::get('/delete-investor/{id}',[InvestorController::class,'destroy'])->name('delete-investor');
    });


    Route::group(['prefix' => '/targets'], function () {
        Route::get('',[InvestorController::class,'target_index'])->name('target-index');
        Route::get('/create-target',[InvestorController::class,'create_target'])->name('create-target');
        Route::post('/store-target-record',[InvestorController::class,'storeTarget'])->name('store-target-record');
        Route::get('/edit-target-info/{id}',[InvestorController::class,'edit_target'])->name('edit-target');
        Route::post('/update-target-info',[InvestorController::class,'updateTarget'])->name('update-target-info');
        Route::get('/show-target-profile/{id}',[InvestorController::class,'show_target'])->name('show-target-Profile');
        Route::get('/delete-target/{id}',[InvestorController::class,'destroy_target'])->name('delete-target');
    });

 
    //activity log
    Route::get('activity-log',[LeadsController::class,'activity_log'])->name('activity-log');
    Route::get('activity-show/{id}',[LeadsController::class,'activity_show'])->name('activity-show');


    Route::post('/uan-leads',[LeadsController::class,'UanLeads']);

});
Route::get('/admin/facebook',[LeadsController::class,'fb_leads'])->name('fb-leads');
Route::get('/admiaan/facebook', function () {
    $fb = new Facebook([
        'app_id' => '6245396468813835',
        'app_secret' => 'f3fc3710913439f5c94449a5f0352479',
        'default_graph_version' => 'v16.0',
    ]);
    $access_token = 'EABYwJ64BUAsBAHfEilPM4c5pgSOuuZALLixvLFYmOfmZAWA1YDVgcUv5nVJ0eXaWLiPqNCAzuzJdEc9Jg5ZBGlFokhU55PIEPPI0E7M9tfgkBOrdSe6aqoKMCGugJLsi0gduQtfqwZBOuBi1Vg7NqhBr4t2v5iZAY8ELUMW3xtc2D6sDklCGlWU655RaLkRcZD';

    try {
        $adId = '23846503107470317';
        $response = $fb->get('/' . $adId . '/leads', $access_token);
        $leads = $response->getGraphEdge();
        $data = $leads->getIterator();
        $html = "<table><tr><th>Id</th><th>field data</th></tr>";
        foreach ($data as $item) {
            $html = $html . "<tr>";
            $html = $html . '<td style="border:black 2px solid; ">' . $item['id'] . '</td>';
            $html = $html . '<td style="border:black 2px solid;">';
            $html = $html . '<table><tr><th> Name</th ><th> values</th> </tr>';
            foreach ($item['field_data'] as $item1) {
                $html = $html . ' <tr><td style = "border:black 2px solid; " > ' . $item1["name"] . '</td> ';
                $html = $html . '  <td style = "border:black 2px solid; ">';
                foreach ($item1["values"] as $subitem) {
                    $html = $html . $subitem;
                }
                $html = $html . '  </td ></tr >';
            }
            echo $html;    
            $html = $html . '</td ></tr ><table/></td >';
            $html = $html . "</tr>";
            $html = $html . "</table>";

        }

        $html = $html . "</table>";
        echo $html;

    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        dd($e);
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        dd($e, 2);
    }


});