<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\override;


Route::post('mobile-verification', [AuthController::class,'mobile_verification']);
Route::post('otp-verification', [AuthController::class,'otp_verification']);


Route::post('staff-mobile-verification', [AuthController::class,'staff_mobile_verification']);
Route::post('staff-otp-verification', [AuthController::class,'staff_otp_verification']);

Route::post('admin_login', [AuthController::class,'admin_login']);

Route::get('unauthorizeds', [AuthController::class,'unauthorized']);

//condition  for protect the user route
Route::middleware('auth:api')->group(function () {


});



//condition  for protect the vendor route
Route::middleware(['auth:vendor-api'])->group(function () {

    Route::post('add_customer', [AdminController::class,'add_customer']);
    Route::post('update_customer', [AdminController::class,'update_customer']);
    Route::post('delete_customer', [AdminController::class,'delete_customer']);
    Route::post('customer_list', [AdminController::class,'customer_list']);
    Route::post('customer_details', [AdminController::class,'customer_details']);

    Route::post('add_scheme', [AdminController::class,'add_scheme']);
    Route::post('update_scheme', [AdminController::class,'update_scheme']);
    Route::post('delete_scheme', [AdminController::class,'delete_scheme']);
    Route::post('scheme_list', [AdminController::class,'scheme_list']);

    Route::post('get_dashboard_data', [AdminController::class,'get_dashboard_data']);

    Route::post('pending_verification', [AdminController::class,'pending_verification']);
    Route::post('get_verification', [AdminController::class,'get_verification']);


    Route::post('get_collection', [AdminController::class,'get_collection']);
    Route::post('pending_collection', [AdminController::class,'pending_collection']);

    Route::post('add_scheme_customer', [AdminController::class,'add_scheme_customer']);
    Route::post('get_pending_payment',[AdminController::class,'get_pending_payment']);

});
