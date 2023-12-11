<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\GoogleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

//signup
Route::get('signup-index', [SignupController::class,'Index']);
Route::post('signup-save-data', [SignupController::class,'Signup']);

//login
Route::post('login-user', [LoginController::class,'LoginProcced']);

//dashboard
Route::get('dashboard', [DashboardController::class,'Dashboard']);
Route::get('delete_user/{id}', [DashboardController::class,'DeleteUser']);
Route::get('edit_user/{id}', [DashboardController::class,'EditUser']);
Route::post('update_user', [DashboardController::class,'Update']);
Route::get('logout', [DashboardController::class,'Logout']);
Route::get('send_offer_dashboard', [DashboardController::class,'SendEmailDashbard']);
Route::post('send_offer', [DashboardController::class,'SendOffer']);


//blogs
Route::get('blogs', [BlogsController::class,'index']);
Route::post('create-blog', [BlogsController::class,'CreateBlog']);
Route::get('edit-blog/{id}', [BlogsController::class,'EditBlog']);
Route::post('update-blog', [BlogsController::class,'UpdateBlog']);

//google login
Route::controller(GoogleController::class)->group(function(){
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});