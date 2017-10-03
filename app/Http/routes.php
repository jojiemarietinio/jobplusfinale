<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
	return view('login.login');
});

/*
	Paypal routes / added by Ramjith Ap
*/
// Route::get('/paypal/', 'PaypalController@postPaymentWithpaypal'); // this is the url which initiate payment request
// Route::get('/paypal/{user_id}/status', 'PaypalController@getPaymentStatus'); // redirect url/ response url


// Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'AddMoneyController@payWithPaypal',));
// Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal',));
// Route::get('paypal', array('as' => 'payment.status','uses' => 'AddMoneyController@getPaymentStatus',));
// Route::get('/get/employer/wallet','AddMoneyController@payWithPaypal');


// Route::get('payment-status',array('as'=>'payment.status','uses'=>'PaymentController@paymentInfo'));
// Route::get('payment',array('as'=>'payment','uses'=>'PaymentController@payment'));
// Route::get('payment-cancel', function () {
//     return 'Payment has been canceled';
// });

// Route::get('/{order?}', [
//      'name' => 'PayPal Express Checkout',
//      'as' => 'emp.jobwallet',
//      'uses' => 'PayPalController@form',
//  ]);
  
 Route::post('/checkout/payment/{order}/paypal', [
     'name' => 'PayPal Express Checkout',
     'as' => 'checkout.payment.paypal',
     'uses' => 'PayPalController@checkout',
 ]);
  
 Route::get('/paypal/checkout/{order}/completed', [
     'name' => 'PayPal Express Checkout',
     'as' => 'paypal.checkout.completed',
     'uses' => 'PayPalController@completed',
 ]);
  
 //Route::get('/publish', 'EbayController@publish');
 Route::get('/paypal/checkout/{order}/cancelled', [
     'name' => 'PayPal Express Checkout',
     'as' => 'paypal.checkout.cancelled',
     'uses' => 'PayPalController@cancelled',
 ]);
 
 Route::post('/webhook/paypal/{order?}/{env?}', [
     'name' => 'PayPal Express IPN',
     'as' => 'webhook.paypal.ipn',
     'uses' => 'PayPalController@checkout',
 ]);

Route::get('employer/jobwallet', [
	'uses' => 'PaypalController@form',
	'as' => 'emp/jobwallet'
	])->middleware('auth');


/*
	Messaging
*/
// Route::group(['prefix' => 'messages'], function () {
//     Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
//     Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
//     Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
//     Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
//     Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
// });

//Auth::Routes();

Route::get('tests', 'MessageController@tests');

Route::get('/home', 'HomeController@index');


Route::get('message/{id}', 'MessageController@chatHistory')->name('message.read');

Route::group(['prefix'=>'ajax', 'as'=>'ajax::'], function() {
Route::post('message/send', 'MessageController@ajaxSendMessage')->name('message.new');
Route::delete('message/delete/{id}', 'MessageController@ajaxDeleteMessage')->name('message.delete');
});
/*
	Jobify Bot Routes
*/
Route::get('/jobbot/receive', 'MainController@receive')->middleware("verify");
Route::post('/jobbot/receive', 'MainController@receive');
Route::get('register', ['as' => 'login.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);
Route::auth();
Route::group(['middleware' => ['web']], function(){
Route::get('/get/checker/job','UserController@checkJob');
Route::get('/get/checker','UserController@checkPage');
Route::get('/get/checker/dummy','UserController@getJob');
Route::get('/get/rank','ApplicantController@getrank');
/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::get('/get/profile/skill','ProfileController@getSkill');
Route::get('/update/profile/skill','ProfileController@updateSkill');
Route::get('/set/user/profile/name','ProfileController@setName');
Route::get('/set/user/profile/overview','ProfileController@setOverview');
Route::get('/get/history','ProfileController@getHistory');
/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
//Resend Verification Code
Route::get('/get/user/resend','UserController@resendCode');
Route::get('/user/home', [
	'uses' => 'UserController@getHome',
	'as' => 'user/home'
	])->middleware('auth');
Route::post('/user/upload', [
	'uses' => 'UserController@UploadImage',
	'as' => 'user/upload'
	])->middleware('auth');
Route::get('/user/setup', [
	'uses' => 'UserController@getSetup',
	'as' => 'user/setup'
	])->middleware('auth');
Route::get('/app/setup', [
	'uses' => 'UserController@getSetup',
	'as' => 'app/setup'
	])->middleware('auth');
Route::post('/setup/save', [
	'uses' => 'UserController@saveProfile',
	'as' => 'user/save'
	])->middleware('auth');
Route::get('/get/user/profile','UserController@getProfile');
Route::get('user/profile', [
	'uses' => 'UserController@getProfile',
	'as' => 'app/profile'
	])->middleware('auth');
Route::get('/get/user/setupdata', 'UserController@getSetupData');
Route::get('/get/user/degree', 'UserController@getDegree');
Route::get('/set/user/education','UserController@setEducation');
Route::get('/get/user/education','UserController@getEducation');
Route::get('/remove/user/education','UserController@removeEducation');
Route::get('/find/user/education','UserController@findEducation');
Route::get('/update/user/education','UserController@updateEducation');
Route::get('/set/user/step1','UserController@setStep1');
Route::get('/set/user/work','UserController@setWork');
Route::get('/get/user/work','UserController@getWork');
Route::get('/remove/user/work','UserController@removeWork');
Route::get('/find/user/work','UserController@findWork');
Route::get('/update/user/work','UserController@updateWork');
Route::get('/set/user/verify','UserController@setVerification');
Route::get('/get/user/verify','UserController@getVerification');
Route::get('/get/profiledata', 'UserController@getProfileData');
Route::get('/get/update/name', 'UserController@updateName');
Route::get('/admin','UserController@getAdmin');
Route::get('/sms','UserController@getSMSPage');
Route::get('/sms/send/{recipientNumber}/{message}','ChikkaSmsController@send');
Route::post('/sms/receive','ChikkaSmsController@receive');
Route::post('/sms/notify','ChikkaSmsController@notify');
Route::post('/sms/extract','ChikkaSmsController@testExtract');
Route::get('/get/dash/resched','ApplicantController@setReschedule');
// Route::get('/get/user/wallet','UserController@getWallet');
/*
|--------------------------------------------------------------------------
| Employer Routes
|--------------------------------------------------------------------------
*/
Route::get('/employer',[
	'uses' => 'EmployerController@index',
	'as' => 'employer'
	])->middleware('auth');
Route::get('/employer/test/{$id}', [
	'uses' => 'EmployerController@test',
	'as' => 'test'
	])->middleware('auth');

Route::get('/employer/dashboard', [
	'uses' => 'EmployerController@getDashboard',
	'as' => 'emp/dashboard'
	])->middleware('auth');

Route::get('/employer/jobpost', [
	'uses' => 'EmployerController@getJobPost',
	'as' => 'emp/job/post'
	])->middleware('auth');
Route::get('/set/postjob','EmployerController@postJob');
Route::get('/employer/jobpost/data', [
	'uses' => 'EmployerController@getJobPostData',
	'as' => 'emp/job/post/data'
	])->middleware('auth');
Route::get('employer/applications', [
	'uses' => 'EmployerController@getApplications',
	'as' => 'emp/applications'
	])->middleware('auth');

Route::get('employer/jobwallet', [
	'uses' => 'EmployerController@getJobwallet',
	'as' => 'emp/jobwallet'
	])->middleware('auth');

Route::get('/get/emloyer/viewJob', 'EmployerController@getViewJob');
//Route::get('/get/employer/wallet','EmployerController@getJobwallet');
Route::get('/get/employer/profile','EmployerController@getProfile');
// Applications
Route::get('/employer/applications/data', 'EmployerController@getApplicationData');
Route::get('/employer/application/response','EmployerController@ApplicationResponse');
Route::get('/employer/application/decline','EmployerController@declineApplication');
//Dashboard
Route::get('/employer/dashboard/data','EmployerController@getDashboardData');
Route::get('/employer/startjob','EmployerController@startJob');
Route::get('/employer/endjob','EmployerController@endJob');
Route::get('/employer/endjob/summary','EmployerController@endJobSummary');
/*
|--------------------------------------------------------------------------
| PAYPAL Routes
|--------------------------------------------------------------------------
*/
//Route::get('create_paypal_plan', 'PaypalController@create_plan');

// route for view/blade file
// Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
// // route for post request
// Route::post('paypal', array('as' => 'paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
// // route for check status responce
// Route::get('paypal', array('as' => 'status','uses' => 'PaypalController@getPaymentStatus',));


/*
|--------------------------------------------------------------------------
| Applicant Routes
|--------------------------------------------------------------------------
*/
Route::get('/applicant/dashboard/', [
	'uses' => 'ApplicantController@getDashboard',
	'as' => 'app/dashboard'
	])->middleware('auth');
Route::get('/applicant/job', [
	'uses' => 'ApplicantController@getJobPage',
	'as' => 'app/job/result'
	])->middleware('auth');
Route::get('/app/job/filter','ApplicantController@getFilter');
Route::get('/app/job/getskill','ApplicantController@getSkills');
Route::get('/app/jobsearch', 'ApplicantController@getJobSearch');
Route::get('/get/jobpagedata','ApplicantController@getJobPageData');
Route::get('/get/job/recommended','ApplicantController@getJobRecommended');
Route::get('/get/job/nearby','ApplicantController@getJobNearby');
Route::get('/get/job','ApplicantController@getResult');
Route::get('/app/apply','ApplicantController@Apply');
Route::get('/app/upcomingJob','ApplicantController@getUpcoming');
Route::get('/app/ongoingJob','ApplicantController@getOngoing');
Route::get('/app/activeJob','ApplicantController@getActive');
Route::get('/admin/applicant','ApplicantController@getAdmin');
Route::get('/app/dashboard/seemore','ApplicantController@getSeemore');
Route::get('/app/applications','ApplicantController@getApplications');
Route::get('/set/application/decline','ApplicantController@setApplication');
Route::get('/applicant/job/start',[
	'uses' => 'ApplicantController@StartJob',
	'as' => 'app/job/start'
	])->middleware('auth');
Route::get('/applicant/endjob','ApplicantController@EndJob');
Route::get('/applicant/endjob/summary','ApplicantController@endJobSummary');
Route::get('/applicant/pending/confirmation','ApplicantController@getPendingConfirmation');
Route::get('/applicant/receive/confirm','ApplicantController@receivePayment');
/*
|--------------------------------------------------------------------------
| Job Routes
|--------------------------------------------------------------------------
*/
Route::get("/job/create", "jobController@create");
Route::post("job/store", "jobController@store");
Route::get("index", "jobController@index");
Route::get("show/{id}", "jobController@show");
Route::get("edit/{id}", "jobController@edit");
Route::patch("update/{id}", "jobController@update");
Route::get("delete/{id}", "jobController@destroy");
});
