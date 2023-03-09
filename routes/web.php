<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ReferandEarn;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOrderController;

use App\Http\Controllers\VendorInventoryController;
use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use App\Events\checkTable;
use App\Events\DashboardOrderChannel;
use App\Events\Kotstatus;
use App\Events\Orderstatus;
use App\Events\Notification;



use App\Models\Vendor;
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

Route::get('/', function () {
    return Redirect::to('https://weazydine.com');
});

Route::get('/checkon', function () {

   DashboardOrderChannel::dispatch(1);
});

Route::get('/send_email', [VendorController::class,'send_mail']);


Route::get('/checkTable',function (Request $request){

	// $vendor=Vendor::find(1);
	// event(new checkTable());

	//checkTable::dispatch($table);
	event(new checkTable(1));

});

Route::get('/notification',function (Request $request){

	// $vendor=Vendor::find(1);
	// event(new checkTable());

	//checkTable::dispatch($table);
	event(new NotificationChannel(1));

});

Route::get('/qr-img/{table_uu_id}',[GlobalController::class,'show_qr_image']);
Route::get('/qr-img/{table_uu_id}/{type}',[GlobalController::class,'show_qr_image']);

Route::get('/qr-shop/{vendor_id}',[GlobalController::class,'show_qr_shop']);
Route::get('/qr-shop/{vendor_id}/{type}',[GlobalController::class,'show_qr_shop']);

Route::get('/check_inventory',[VendorInventoryController::class,'check_inventory']);
Route::get('/VerifyOrderTransaction',[UserOrderController::class,'VerifyOrderTransaction']);

Route::post('/VerifyOrderTransaction',[UserOrderController::class,'VerifyOrderTransaction']);

Route::get('/payment-update-paytm',[UserOrderController::class,'payment-update-paytm']);


Route::get('/send_push', [UserController::class,'send_push']);

Route::get('/genrate_qr', [UserController::class,'genrate_or']);

Route::get('/send_mail', [UserController::class,'send_mail']);
Route::get('/uploadCvs',function (){
	return view('upload_csv');
});


Route::post('/update_data', [GlobalController::class,'update_data_csv']);


Route::get('/{refer_id}',[ReferandEarn::class,'genrateRequest']);




// Route::get('login', [AuthController::class,'unauthorized']);
