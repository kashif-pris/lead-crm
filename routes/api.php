<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
// Route::post("/all-leads", [ApiController::class, 'leads']);
// Route::post("login", [ApiController::class, 'login']);
Route::post("/call-logs", [ApiController::class, 'callLogs']);
Route::get('/appHome/Screen', function () {
   return 'test';
});

// Route::middleware('auth:sanctum')->group(function () {

    Route::post("add-leads", [ApiController::class, 'add_leads']);
// dd('htfgh');
    Route::post("login", [ApiController::class, 'login']);
    Route::post("all-leads", [ApiController::class, 'leads']);
    
    Route::get("specific_lead", [ApiController::class, 'specific_lead']);

    Route::post("post-comment", [ApiController::class, 'post_comment']);
    
    Route::post("update-leads", [ApiController::class, 'update_leads']);
    Route::post("followup-leads", [ApiController::class, 'followup_leads']);
    
    Route::get("followup-leads-get", [ApiController::class, 'followup_leads_get']);
    
   
    Route::get("all-target", [ApiController::class, 'targets']);
   
    Route::get("all-agent", [ApiController::class, 'agents']);

    Route::get("add-leads-phone", [ApiController::class, 'leads_phone']);
// });