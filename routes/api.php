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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('welcome', [ApiController::class,'Welcome']);
Route::get('all-users-data', [ApiController::class,'AllUsersList']);
Route::post('signup', [ApiController::class,'Signup']);

//otp apis
Route::post('send-otp', [ApiController::class,'SendOtp']);
Route::post('verify-otp', [ApiController::class,'VerifyOtp']);

//import colours
Route::post('import-colors', [ApiController::class,'ImportColors']);

//user
Route::post('user-detail', [ApiController::class,'GetUserDetailsByName']);
