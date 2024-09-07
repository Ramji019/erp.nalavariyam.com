<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/get_email_aadhaar_phone/{key}/{username}", [App\Http\Controllers\api\WalletApiController::class, 'get_email_aadhaar_phone'])->name('get_email_aadhaar_phone');
Route::get("/recharge_investment_history/{key}/{username}/{amount}", [App\Http\Controllers\api\WalletApiController::class, 'recharge_investment_history'])->name('recharge_investment_history');
Route::get("/recharge_investment_interest/{key}/{username}/{amount}", [App\Http\Controllers\api\WalletApiController::class, 'recharge_investment_interest'])->name('recharge_investment_interest');
Route::get("/updategovtstatus/{key}/{app_no}/{status}/{reason}", [App\Http\Controllers\api\WalletApiController::class, 'updategovtstatus'])->name('updategovtstatus');
Route::get("/get_applicationmobile/{key}", [App\Http\Controllers\api\WalletApiController::class, 'get_applicationmobile'])->name('get_applicationmobile');
Route::get("/update_old_balance", [App\Http\Controllers\api\WalletApiController::class, 'update_old_balance'])->name('update_old_balance');

Route::get("/update_email_aadhaar_phone/{username}/{email}/{aadhaar_no}/{phone}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'update_email_aadhaar_phone'])->name('update_email_aadhaar_phone');
Route::get("/checkemailverified/{username}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'checkemailverified'])->name('checkemailverified');
Route::get("/verifyemail/{username}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'verifyemail'])->name('verifyemail');
Route::get("/checkusers/{email}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'checkusers'])->name('checkusers');

Route::get("/generate_username/{key}", [App\Http\Controllers\api\WalletApiController::class, 'generate_username'])->name('generate_username');
Route::get("/wallet_balance/{username}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'wallet_balance'])->name('wallet_balance');

Route::get("/wallet_commission/{username}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'wallet_commission'])->name('wallet_commission');

Route::get("/approve_amount/{username}/{amount}/{context}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'approve_amount'])->name('approve_amount');

Route::get("/recharge_approve_amount/{username}/{amount}/{context}/{refusername}/{refcom}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'recharge_approve_amount'])->name('recharge_approve_amount');
Route::get("/totalwallet_history/{username}/{usertype}/{from}/{to}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'totalwallet_history'])->name('totalwallet_history');

Route::get("/balance/{username}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'balance'])->name('balance');
Route::get("/debit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'debit_wallet'])->name('debit_wallet');
Route::get("/voterid_debit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'voterid_debit_wallet'])->name('voterid_debit_wallet');
Route::get("/voterid_credit_wallet/{username}/{adminusername}/{admin_amount}/{superadmin_amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'voterid_credit_wallet'])->name('voterid_credit_wallet');
Route::get("/voterid_activate_center/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'voterid_activate_center'])->name('voterid_activate_center');
Route::get("/lic_activate_center/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'lic_activate_center'])->name('lic_activate_center');
Route::get("/lic_debit_wallet_and_pay_commission/{username}/{adminusername}/{amount}/{commission}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'lic_debit_wallet_and_pay_commission'])->name('lic_debit_wallet_and_pay_commission');


Route::get("/scholarship_activate_student/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'scholarship_activate_student'])->name('scholarship_activate_student');
Route::get("/scholarship_accept_student/{username}/{student_id}/{sup_amount}/{ref_amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'scholarship_accept_student'])->name('scholarship_accept_student');
Route::get("/scholarship_tailoring_debit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'scholarship_tailoring_debit_wallet'])->name('scholarship_tailoring_debit_wallet');

Route::get("/scholarship_tailoring_credit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'scholarship_tailoring_credit_wallet'])->name('scholarship_tailoring_credit_wallet');
Route::post("/recharge_commission", [App\Http\Controllers\api\WalletApiController::class, 'recharge_commission'])->name('recharge_commission');

Route::get("/ramjipay_lic_payment/{username}/{admin_user_name}/{center_user_name}/{superadmin_amount}/{admin_amount}/{superadmin_commission}/{admin_commission}/{center_commission}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'ramjipay_lic_payment'])->name('ramjipay_lic_payment');

Route::get("/recharge_debit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'recharge_debit_wallet'])->name('recharge_debit_wallet');
Route::get("/recharge_refund_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'recharge_refund_wallet'])->name('recharge_refund_wallet');
Route::post("/getaddress", [App\Http\Controllers\api\WalletApiController::class, 'getaddress'])->name('getaddress');
Route::get("/eservice_debit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'eservice_debit_wallet'])->name('eservice_debit_wallet');
Route::get("/eservice_credit_commission/{admin_username}/{referral_username}/{admin_amount}/{referral_amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'eservice_credit_commission'])->name('eservice_credit_commission');


Route::get("/pilgrim_debit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'pilgrim_debit_wallet'])->name('pilgrim_debit_wallet');
Route::get("/pilgrim_credit_wallet/{username}/{adminusername}/{admin_amount}/{superadmin_amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'pilgrim_credit_wallet'])->name('pilgrim_credit_wallet');



Route::get("/pancard_debit_wallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'pancard_debit_wallet'])->name('pancard_debit_wallet');
Route::get("/pancard_credit_wallet/{username}/{adminusername}/{admin_amount}/{superadmin_amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'pancard_credit_wallet'])->name('pancard_credit_wallet');
Route::get("/pancard_activate_center/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'pancard_activate_center'])->name('pancard_activate_center');

Route::get("/matrimony_activate_member/{usertype}/{username}/{adminuser_name}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'matrimony_activate_member'])->name('matrimony_activate_member');


Route::get("/credit_transfer_ramjiwallet/{username}/{amount}/{key}", [App\Http\Controllers\api\WalletApiController::class, 'credit_transfer_ramjiwallet'])->name('credit_transfer_ramjiwallet');