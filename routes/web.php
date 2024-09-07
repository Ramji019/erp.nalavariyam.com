<?php
use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\MainController::class, 'welcome'])->name('welcome');

Auth::routes();
Route::get('register/{username}', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('userregister');
Route::get('registerusers', [App\Http\Controllers\DashboardController::class, 'registerusers'])->name('registerusers');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');

Route::get('/memberdashboard', [App\Http\Controllers\Member\MemberDashboardController::class, 'memberdashboard'])->name('memberdashboard');
Route::get('/bgdark/{customer_id}', [App\Http\Controllers\Member\MemberDashboardController::class, 'bgdark'])->name('bgdark');
Route::get('/bgbright/{customer_id}', [App\Http\Controllers\Member\MemberDashboardController::class, 'removefavorites'])->name('bgbright');

Route::get('/memberlogin', [App\Http\Controllers\Member\MemberLoginController::class, 'memberlogin'])->name('memberlogin');
Route::post('/checklogin', [App\Http\Controllers\Member\MemberLoginController::class, 'checklogin'])->name('checklogin');
ROUTE::get('/memberlogout', [App\Http\Controllers\Member\MemberLoginController::class, 'memberlogout'])->name('memberlogout');

Route::get('/memberservices', [App\Http\Controllers\Member\MemberServicesController::class, 'memberservices'])->name('memberservices');
Route::POST('/memservicepayment', [App\Http\Controllers\Member\MemberServicesController::class, 'memservicepayment'])->name('memservicepayment');
Route::POST('/memcreateapplication', [App\Http\Controllers\Member\MemberServicesController::class, 'memcreateapplication'])->name('memcreateapplication');
Route::get('memberpending', [App\Http\Controllers\Member\MemberServicesController::class, 'memberpending'])->name('memberpending');
Route::get('/memberstatuscompleted/{from}/{to}', [App\Http\Controllers\Member\MemberServicesController::class, 'memberstatuscompleted'])->name('memberstatuscompleted');
Route::get('/memberrejected', [App\Http\Controllers\Member\MemberServicesController::class, 'memberrejected'])->name('memberrejected');
Route::post('/memberserviceupdatestatus', [App\Http\Controllers\Member\MemberServicesController::class, 'memberserviceupdatestatus'])->name('memberserviceupdatestatus');
Route::post('/membercompletedbill', [App\Http\Controllers\Member\MemberServicesController::class, 'membercompletedbill'])->name('membercompletedbill');
Route::get('/memberprofile', [App\Http\Controllers\Member\MemberServicesController::class, 'memberprofile'])->name('memberprofile');
Route::post('/updatememberprofile', [App\Http\Controllers\Member\MemberServicesController::class, 'updatememberprofile'])->name('updatememberprofile');
Route::get('/memberchangepassword', [App\Http\Controllers\Member\MemberServicesController::class, 'memberchangepassword'])->name('memberchangepassword');
Route::POST('/memberupdatepassword', [App\Http\Controllers\Member\MemberServicesController::class, 'memberupdatepassword'])->name('memberupdatepassword');
 Route::get('/memberlogout', [App\Http\Controllers\Member\MemberServicesController::class, 'memberlogout'])->name('memberlogout');
Route::get('/membernotification', [App\Http\Controllers\Member\MemberServicesController::class, 'membernotification'])->name('membernotification');


Route::get('/memberwallet/{from}/{to}', [App\Http\Controllers\Member\MemberWalletController::class, 'index'])->name('memberwallet');
Route::get('/memberallwallet/{from}/{to}', [App\Http\Controllers\Member\MemberWalletController::class, 'memberallwallet'])->name('memberallwallet');
Route::post('/memberamount', [App\Http\Controllers\Member\MemberWalletController::class, 'memberamount'])->name('memberamount');
Route::get('/memberrequestamount', [App\Http\Controllers\Member\MemberWalletController::class, 'memberrequestamount'])->name('memberrequestamount');
Route::post('/memberrequestamount_approve', [App\Http\Controllers\Member\MemberWalletController::class, 'memberrequestamount_approve'])->name('memberrequestamount_approve');
Route::post('/memberpaymentrequest', [App\Http\Controllers\Member\MemberWalletController::class, 'memberpaymentrequest'])->name('memberpaymentrequest');


Route::get('/usertypes', [App\Http\Controllers\UsersController::class, 'usertypes'])->name('usertypes');
Route::get('/renewal', [App\Http\Controllers\UsersController::class, 'renewal'])->name('renewal');
Route::POST('/updaterenewamount', [App\Http\Controllers\UsersController::class, 'updaterenewamount'])->name('updaterenewamount');
Route::get('/primaryusers', [App\Http\Controllers\UsersController::class, 'primaryusers'])->name('primaryusers');
Route::get('/specialusers', [App\Http\Controllers\UsersController::class, 'specialusers'])->name('specialusers');
Route::get('/districtusers', [App\Http\Controllers\UsersController::class, 'districtusers'])->name('districtusers');
Route::get('/talukusers', [App\Http\Controllers\UsersController::class, 'talukusers'])->name('talukusers');
Route::get('/blockusers', [App\Http\Controllers\UsersController::class, 'blockusers'])->name('blockusers');
Route::get('/panchayathusers', [App\Http\Controllers\UsersController::class, 'panchayathusers'])->name('panchayathusers');
Route::get('/centerusers', [App\Http\Controllers\UsersController::class, 'centerusers'])->name('centerusers');
Route::get('/profile', [App\Http\Controllers\UsersController::class, 'profile'])->name('profile');
Route::POST('/updateprofile', [App\Http\Controllers\UsersController::class, 'updateprofile'])->name('updateprofile');
Route::get('/changepassword', [App\Http\Controllers\UsersController::class, 'changepassword'])->name('changepassword');
Route::POST('/updatepassword', [App\Http\Controllers\UsersController::class, 'updatepassword'])->name('updatepassword');
Route::get('/gettaluklimit', [App\Http\Controllers\UsersController::class, 'gettaluklimit'])->name('gettaluklimit');
Route::get('/assigned/{user_type_id}/{id}', [App\Http\Controllers\UsersController::class, 'assigned'])->name('assigned');

Route::post('/addassigneduser', [App\Http\Controllers\UsersController::class, 'addassigneduser'])->name('addassigneduser');


Route::get('/avilableposting', [App\Http\Controllers\UsersController::class, 'avilableposting'])->name('avilableposting');
Route::POST('/updateavilableposting', [App\Http\Controllers\UsersController::class, 'updateavilableposting'])->name('updateavilableposting');
Route::get('/edituser/{id}', [App\Http\Controllers\UsersController::class, 'edituser'])->name('edituser');
Route::POST('/updateuser', [App\Http\Controllers\UsersController::class, 'updateuser'])->name('updateuser');
Route::POST('/adduser', [App\Http\Controllers\UsersController::class, 'adduser'])->name('adduser');
Route::POST('/checkemail', [App\Http\Controllers\UsersController::class, 'checkemail'])->name('checkemail');
Route::POST('/gettaluk', [App\Http\Controllers\UsersController::class, 'gettaluk'])->name('gettaluk');
Route::POST('/getpanchayath', [App\Http\Controllers\UsersController::class, 'getpanchayath'])->name('getpanchayath');
Route::post('/getblock', [App\Http\Controllers\UsersController::class, 'getblock'])->name('getblock');

Route::POST('/gettalukfront', [App\Http\Controllers\Auth\RegisterController::class, 'gettalukfront'])->name('gettalukfront');
Route::POST('/getpanchayathfront', [App\Http\Controllers\Auth\RegisterController::class, 'getpanchayathfront'])->name('getpanchayathfront');
Route::POST('/getcenterfront', [App\Http\Controllers\Auth\RegisterController::class, 'getcenterfront'])->name('getcenterfront');
Route::POST('/updatephone', [App\Http\Controllers\UsersController::class, 'updatephone'])->name('updatephone');

Route::post('/editusertype', [App\Http\Controllers\UsersController::class, 'editusertype'])->name('editusertype');

Route::POST('/checkaadhar', [App\Http\Controllers\UsersController::class, 'checkaadhar'])->name('checkaadhar');
Route::POST('/checkphone', [App\Http\Controllers\UsersController::class, 'checkphone'])->name('checkphone');

Route::get('/districts', [App\Http\Controllers\DistrictsController::class, 'districts'])->name('districts');
Route::post('/adddistricts', [App\Http\Controllers\DistrictsController::class, 'adddistricts'])->name('adddistricts');
Route::post('/editdistricts', [App\Http\Controllers\DistrictsController::class, 'editdistricts'])->name('editdistricts');
Route::get('/deletedistricts/{id}', [App\Http\Controllers\DistrictsController::class, 'deletedistricts'])->name('deletedistricts');


Route::get('/signature', [App\Http\Controllers\DistrictsController::class, 'signature'])->name('signature');

Route::get('/taluk/{id}', [App\Http\Controllers\DistrictsController::class, 'taluk'])->name('taluk');
Route::post('/addtaluk', [App\Http\Controllers\DistrictsController::class, 'addtaluk'])->name('addtaluk');
Route::post('/edittaluk', [App\Http\Controllers\DistrictsController::class, 'edittaluk'])->name('edittaluk');
Route::get('/deletetaluk/{id}', [App\Http\Controllers\DistrictsController::class, 'deletetaluk'])->name('deletetaluk');
Route::get('/panchayath/{id}', [App\Http\Controllers\DistrictsController::class, 'panchayath'])->name('panchayath');
Route::post('/addpanchayath', [App\Http\Controllers\DistrictsController::class, 'addpanchayath'])->name('addpanchayath');
Route::post('/editpanchayath', [App\Http\Controllers\DistrictsController::class, 'editpanchayath'])->name('editpanchayath');
Route::get('/deletepanchayath/{id}', [App\Http\Controllers\DistrictsController::class, 'deletepanchayath'])->name('deletepanchayath');

Route::post('/editdistrictsignature', [App\Http\Controllers\DistrictsController::class, 'editdistrictsignature'])->name('editdistrictsignature');


Route::get('/editcustomer', [App\Http\Controllers\CustomersController::class, 'editcustomer'])->name('editcustomer');
Route::POST('/addcustomer', [App\Http\Controllers\CustomersController::class, 'addcustomer'])->name('addcustomer');
Route::POST('/addowncustomer', [App\Http\Controllers\CustomersController::class, 'addowncustomer'])->name('addowncustomer');

Route::post('/upload_offline_form', [App\Http\Controllers\ServicesController::class, 'upload_offline_form'])->name('upload_offline_form');

Route::get('/customers', [App\Http\Controllers\CustomersController::class, 'customers'])->name('customers');
Route::get('/editcustomers/{id}', [App\Http\Controllers\CustomersController::class, 'editcustomers'])->name('editcustomers');
Route::POST('/updatecustomers', [App\Http\Controllers\CustomersController::class, 'updatecustomers'])->name('updatecustomers');
Route::get('/members', [App\Http\Controllers\CustomersController::class, 'members'])->name('members');
Route::get('/addfamily/{id}', [App\Http\Controllers\CustomersController::class, 'addfamily'])->name('addfamily');
Route::POST('/addmember', [App\Http\Controllers\CustomersController::class, 'addmember'])->name('addmember');
Route::POST('/addmemberdocument', [App\Http\Controllers\CustomersController::class, 'addmemberdocument'])->name('addmemberdocument');
Route::POST('/addfamilymember', [App\Http\Controllers\CustomersController::class, 'addfamilymember'])->name('addfamilymember');
Route::POST('/updatefamilymember', [App\Http\Controllers\CustomersController::class, 'updatefamilymember'])->name('updatefamilymember');
Route::POST('/updatemembers', [App\Http\Controllers\CustomersController::class, 'updatemembers'])->name('updatemembers');
Route::get('/specialmembers', [App\Http\Controllers\CustomersController::class, 'specialmembers'])->name('specialmembers');
Route::POST('/addspecialmember', [App\Http\Controllers\CustomersController::class, 'addspecialmember'])->name('addspecialmember');
Route::POST('/updatespecial', [App\Http\Controllers\CustomersController::class, 'updatespecial'])->name('updatespecial');
Route::get('/editspecial/{id}', [App\Http\Controllers\CustomersController::class, 'editspecial'])->name('editspecial');
Route::get('/goto/{id}', [App\Http\Controllers\CustomersController::class, 'goto'])->name('goto');
Route::post('/gotomembers', [App\Http\Controllers\CustomersController::class, 'gotomembers'])->name('gotomembers');
Route::post('/gotospmember', [App\Http\Controllers\CustomersController::class, 'gotospmember'])->name('gotospmember');
Route::post('/get_sub_work_there', [App\Http\Controllers\CustomersController::class, 'get_sub_work_there'])->name('get_sub_work_there');
Route::post('/get_sub_work_there', [App\Http\Controllers\CustomersController::class, 'get_sub_work_there'])->name('get_sub_work_there');
Route::POST('/customeremail', [App\Http\Controllers\CustomersController::class, 'customeremail'])->name('customeremail');
Route::POST('/customeraadhar', [App\Http\Controllers\CustomersController::class, 'customeraadhar'])->name('customeraadhar');
Route::post('/customerphone', [App\Http\Controllers\CustomersController::class, 'customerphone'])->name('customerphone');
Route::post('/customerregister', [App\Http\Controllers\CustomersController::class, 'customerregister'])->name('customerregister');
ROUTE::get('/showmember/{customer_id}', [App\Http\Controllers\CustomersController::class, 'showmember'])->name('showmember');
Route::post('/memberstatus', [App\Http\Controllers\CustomersController::class, 'memberstatus'])->name('memberstatus');
Route::post('/specialmemberstatus', [App\Http\Controllers\CustomersController::class, 'specialmemberstatus'])->name('specialmemberstatus');
ROUTE::get('/idcard/{customer_id}', [App\Http\Controllers\CustomersController::class, 'idcard'])->name('idcard');
ROUTE::get('/kannan/{customer_id}', [App\Http\Controllers\CustomersController::class, 'kannan'])->name('kannan');
Route::get('/performers/{from}/{to}', [App\Http\Controllers\CustomersController::class, 'performers'])->name('performers');
Route::get('/topperformers', [App\Http\Controllers\CustomersController::class, 'topperformers'])->name('topperformers');
Route::get("/updatepassword/{customer_id}", [App\Http\Controllers\CustomersController::class, 'updatepassword'])->name('updatepassword');
Route::get('/customerpagination/fetch_data', [App\Http\Controllers\CustomersController::class, 'fetch_data'])->name('customerpagination');


Route::get('/services', [App\Http\Controllers\ServicesController::class, 'services'])->name('services');
Route::POST('/addservice', [App\Http\Controllers\ServicesController::class, 'addservice'])->name('addservice');
Route::get('/editservice/{id}', [App\Http\Controllers\ServicesController::class, 'editservice'])->name('editservice');
Route::POST('/updateservice', [App\Http\Controllers\ServicesController::class, 'updateservice'])->name('updateservice');

ROUTE::get('/viewservices/{id}', [App\Http\Controllers\ServicesController::class, 'viewservices'])->name('viewservices');
Route::POST('/servicepayment', [App\Http\Controllers\ServicesController::class, 'servicepayment'])->name('servicepayment');
Route::POST('/renewpayment', [App\Http\Controllers\UsersController::class, 'renewpayment'])->name('renewpayment');
Route::POST('/createapplication', [App\Http\Controllers\ServicesController::class, 'createapplication'])->name('createapplication');
Route::get('/pending', [App\Http\Controllers\ServicesController::class, 'pending'])->name('pending');
Route::get('/completed/{from}/{to}', [App\Http\Controllers\ServicesController::class, 'completed'])->name('completed');
Route::get('/onlinestatus/{status}/{from}/{to}', [App\Http\Controllers\ServicesController::class, 'onlineStatus'])->name('onlineStatus');
Route::get('/rejected', [App\Http\Controllers\ServicesController::class, 'rejected'])->name('rejected');
Route::post('/updatecompleteddetails', [App\Http\Controllers\ServicesController::class, 'updatecompleteddetails'])->name('updatecompleteddetails');
Route::post('/serviceupdatestatus', [App\Http\Controllers\ServicesController::class, 'serviceupdatestatus'])->name('serviceupdatestatus');
Route::post('/completedbill', [App\Http\Controllers\ServicesController::class, 'completedbill'])->name('completedbill');
Route::get('/receipt/{cust_id}/{id}', [App\Http\Controllers\ServicesController::class, 'receipt'])->name('receipt');


Route::get('/wallet/{from}/{to}', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
Route::get('/allwallet/{from}/{to}', [App\Http\Controllers\WalletController::class, 'allwallet'])->name('allwallet');
Route::get('/withdrawal', [App\Http\Controllers\WalletController::class, 'withdrawal'])->name('withdrawal');
Route::post('/withdrawalrequest', [App\Http\Controllers\WalletController::class, 'withdrawalrequest'])->name('withdrawalrequest');
Route::get('/rejectwithdrawal/{id}', [App\Http\Controllers\WalletController::class, 'rejectwithdrawal'])->name('rejectwithdrawal');
Route::post('/acceptwithdrawal', [App\Http\Controllers\WalletController::class, 'acceptwithdrawal'])->name('acceptwithdrawal');
Route::get('/walletamount', [App\Http\Controllers\WalletController::class, 'walletamount'])->name('walletamount');

Route::post('/addwallet', [App\Http\Controllers\WalletController::class, 'addwallet'])->name('addwallet');
Route::post('/superadminaddwallet', [App\Http\Controllers\WalletController::class, 'superadminaddwallet'])->name('superadminaddwallet');
Route::get('/servicepaymentdelete/{id}', [App\Http\Controllers\WalletController::class, 'servicepaymentdelete'])->name('servicepaymentdelete');
Route::get('/transferpaymentdelete/{id}', [App\Http\Controllers\WalletController::class, 'transferpaymentdelete'])->name('transferpaymentdelete');
Route::post('/requestamount', [App\Http\Controllers\WalletController::class, 'requestamount'])->name('requestamount');
Route::get('/viewrequestamount', [App\Http\Controllers\WalletController::class, 'viewrequestamount'])->name('viewrequestamount');

Route::get('/declinerequest_payment/{id}', [App\Http\Controllers\WalletController::class, 'declinerequest_payment'])->name('declinerequest_payment');

Route::post('/requestamount_approve', [App\Http\Controllers\WalletController::class, 'requestamount_approve'])->name('requestamount_approve');


Route::get('/notification', [App\Http\Controllers\NotificationController::class, 'notification'])->name('notification');
Route::post('/addnotification', [App\Http\Controllers\NotificationController::class, 'addnotification'])->name('addnotification');
Route::post('/editnotification', [App\Http\Controllers\NotificationController::class, 'editnotification'])->name('editnotification');
Route::get('/deletenotification/{id}', [App\Http\Controllers\NotificationController::class, 'deletenotification'])->name('deletenotification');
Route::post('/savebulkbuy', [App\Http\Controllers\BulkServicesController::class, 'savebulkbuy'])->name('savebulkbuy');
Route::post('/bulkrequestamount', [App\Http\Controllers\BulkServicesController::class, 'bulkrequestamount'])->name('bulkrequestamount');
Route::get('/bulkorders', [App\Http\Controllers\BulkServicesController::class, 'bulkorders'])->name('bulkorders');
Route::get("/viewbulkorders/{user_id}", [App\Http\Controllers\BulkServicesController::class, 'viewbulkorders'])->name('viewbulkorders');
Route::post('/updatebulkstatus', [App\Http\Controllers\BulkServicesController::class, 'updatebulkstatus'])->name('updatebulkstatus');
Route::get('/pendingbulkservice', [App\Http\Controllers\BulkServicesController::class, 'pendingbulkservice'])->name('pendingbulkservice');
Route::get('/deliveredbulkservice', [App\Http\Controllers\BulkServicesController::class, 'deliveredbulkservice'])->name('deliveredbulkservice');
Route::get("/gettaluklimit/{district_id}", [App\Http\Controllers\UsersController::class, 'gettaluklimit'])->name('gettaluklimit');
Route::get("/getpanchayathlimit/{taluk_id}", [App\Http\Controllers\UsersController::class, 'getpanchayathlimit'])->name('getpanchayathlimit');
Route::get("/getcenterpanchayathlimit/{taluk_id}", [App\Http\Controllers\UsersController::class, 'getcenterpanchayathlimit'])->name('getcenterpanchayathlimit');

Route::get('/advertisement', [App\Http\Controllers\AdvertisementController::class, 'advertisement'])->name('advertisement');
Route::post('/addadvertisement', [App\Http\Controllers\AdvertisementController::class, 'addadvertisement'])->name('addadvertisement');
Route::post('/editadvertisement', [App\Http\Controllers\AdvertisementController::class, 'editadvertisement'])->name('editadvertisement');
Route::get('/deleteadvertisement/{id}', [App\Http\Controllers\AdvertisementController::class, 'deleteadvertisement'])->name('deleteadvertisement');

Route::get('/tailoring', [App\Http\Controllers\TailoringController::class, 'tailoring'])->name('tailoring');
Route::post('/addtailoring', [App\Http\Controllers\TailoringController::class, 'addtailoring'])->name('addtailoring');
Route::post('/updatetailoring', [App\Http\Controllers\TailoringController::class, 'updatetailoring'])->name('updatetailoring');
Route::get('/deletetailoring/{id}', [App\Http\Controllers\TailoringController::class, 'deletetailoring'])->name('deletetailoring');
Route::get('/paytailoring/{id}', [App\Http\Controllers\TailoringController::class, 'paytailoring'])->name('paytailoring');
Route::post('/tailoringpayment_update', [App\Http\Controllers\TailoringController::class, 'tailoringpayment_update'])->name('tailoringpayment_update');
Route::post('/approve_certificate', [App\Http\Controllers\TailoringController::class, 'approve_certificate'])->name('approve_certificate');
Route::post('/resubmit_certificate', [App\Http\Controllers\TailoringController::class, 'resubmit_certificate'])->name('resubmit_certificate');

ROUTE::get('/backup', [App\Http\Controllers\BackupController::class, 'index'])->name('backup');
ROUTE::get('/backup/create', [App\Http\Controllers\BackupController::class, 'create'])->name('create');
ROUTE::get('/backup/download/{file_name}', [App\Http\Controllers\BackupController::class, 'download'])->name('download');
ROUTE::get('/backup/delete/{file_name}', [App\Http\Controllers\BackupController::class, 'delete'])->name('delete');
ROUTE::get('/chatusers', [App\Http\Controllers\ChatController::class, 'chatusers'])->name('chatusers');
Route::get('/chat/{id}', [App\Http\Controllers\ChatController::class, 'chat'])->name('chat');
Route::post('/userchat', [App\Http\Controllers\ChatController::class, 'userchat'])->name('userchat');
Route::get('/getchat/{id}', [App\Http\Controllers\ChatController::class, 'getchat'])->name('getchat');


Route::get("/resetpass/{offset}", [App\Http\Controllers\UsersController::class, 'resetpass'])->name('resetpass');
Route::get("/resetpassword/{userid}", [App\Http\Controllers\UsersController::class, 'resetpassword'])->name('resetpassword');

Route::get('/bgdark/{user_id}', [App\Http\Controllers\DashboardController::class, 'bgdark'])->name('bgdark');
Route::get('/bgbright/{user_id}', [App\Http\Controllers\DashboardController::class, 'removefavorites'])->name('bgbright');

Route::post('/userstatus', [App\Http\Controllers\UsersController::class, 'userstatus'])->name('userstatus');
Route::get('/allusers', [App\Http\Controllers\UsersController::class, 'allusers'])->name('allusers');
Route::get('/allcustomers', [App\Http\Controllers\CustomersController::class, 'allcustomers'])->name('allcustomers');
Route::get('/userstatusupdate/{id}/{usertype}', [App\Http\Controllers\UsersController::class, 'userstatusupdate'])->name('userstatusupdate');
Route::get('/specialmemberstatusupdate/{id}/{usertype}', [App\Http\Controllers\CustomersController::class, 'specialmemberstatusupdate'])->name('specialmemberstatusupdate');
Route::post('/specialmemberactivate', [App\Http\Controllers\CustomersController::class, 'specialmemberactivate'])->name('specialmemberactivate');
Route::post('/userstatuspayment_update', [App\Http\Controllers\UsersController::class, 'userstatuspayment_update'])->name('userstatuspayment_update');


Route::get('/logout', [App\Http\Controllers\UsersController::class, 'logout'])->name('logout');
Route::post('/forgotpassword', [App\Http\Controllers\ForgotController::class, 'forgotpassword'])->name('forgotpassword');
Route::get("/sendotpemail/{email}/{aadhaar_no}/{phone}", [App\Http\Controllers\UsersController::class, 'sendotpemail'])->name('sendotpemail');
Route::get("/resendotpemail", [App\Http\Controllers\UsersController::class, 'resendotpemail'])->name('resendotpemail');
Route::get("/confirmotpemail/{username}/{otp}", [App\Http\Controllers\UsersController::class, 'confirmotpemail'])->name('confirmotpemail');
Route::post('/paymentrequest', [App\Http\Controllers\WalletController::class, 'paymentrequest'])->name('paymentrequest');


Route::get('/test', [App\Http\Controllers\usersController::class, 'test'])->name('test');

Route::get('/meetings', [App\Http\Controllers\MeetingsController::class, 'meetings'])->name('meetings');
Route::post('/addmeeting', [App\Http\Controllers\MeetingsController::class, 'addmeeting'])->name('addmeeting');
Route::post('/updatemeeting', [App\Http\Controllers\MeetingsController::class, 'updatemeeting'])->name('updatemeeting');
Route::get('/deletemeeting/{id}', [App\Http\Controllers\MeetingsController::class, 'deletemeeting'])->name('deletemeeting');
Route::get('/meetingparticipated/{id}', [App\Http\Controllers\MeetingsController::class, 'meetingparticipated'])->name('meetingparticipated');
Route::post('/addparticipated', [App\Http\Controllers\MeetingsController::class, 'addparticipated'])->name('addparticipated');
Route::post('/meetingpayment', [App\Http\Controllers\MeetingsController::class, 'meetingpayment'])->name('meetingpayment');
Route::post('/updatestatus', [App\Http\Controllers\MeetingsController::class, 'updatestatus'])->name('updatestatus');


Route::get('/setdistrict', [App\Http\Controllers\DashboardController::class, 'setdistrict'])->name('setdistrict');
