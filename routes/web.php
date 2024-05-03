<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CardCodeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StartPointsController;
use App\Http\Middleware\RedirectIfAuthenticated;

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
    return view('dashboard');
});




Route::get('/csrf-token', function () {
    return response()->json(['csrfToken' => csrf_token()]);
});

Route::post('/login', [LoginController::class, 'authentications']);


Route::middleware(['auth'])->group(function () {
    // Logout route
Route::post('/logout', [LoginController::class, 'logout']);

});


Route::post('/api/loyalty-stars/crete', [StartPointsController::class, 'update']);
Route::put('/api/stars/update', [StarController::class, 'update']);
Route::get('/api/stars/{merchant}/edit', [StartPointsController::class, 'edit']);

// Merchant Route
Route::get('/api/merchant/points', [PointController::class,'merchantIndex']);
Route::get('/api/merchant/points/{point}/edit', [PointController::class, 'edit']);
Route::post('/api/merchant/points/{point}/edit', [PointController::class, 'update']);

Route::post('/api/merchant/points/register', [PointController::class,'store']);

// Admin Route

// stars

Route::get('/api/stars', [StarController::class, 'index']);

// User Profile
Route::get('/api/profile', [ProfileController::class, 'index']);
Route::put('/api/profile-information/edit', [ProfileController::class,'updateProfile']);
Route::put('/api/profile-business/edit', [ProfileController::class,'updateBusiness']);
Route::put('/api/profile-password/change', [ProfileController::class,'changePassword']);


// Tripidkard Route
Route::get('/api/tripidkards', [CardCodeController::class, 'index']);
Route::get('/api/merchant/tripidkards', [CardCodeController::class, 'merchantIndex']);

Route::post('/api/tripidkards/create', [CardCodeController::class, 'store']);

// Enterprise Route
Route::get('/api/enterprises', [EnterpriseController::class, 'index']);
Route::post('/api/enterprises/create', [EnterpriseController::class, 'store']);
Route::get('/api/enterprises/{enterprise}/edit', [EnterpriseController::class, 'edit']);
Route::post('/api/enterprises/{enterprise}/edit', [EnterpriseController::class, 'update']);

// Merchant Route
Route::get('/api/merchants', [MerchantController::class, 'index']);
Route::post('/api/merchants/create', [MerchantController::class, 'store']);
Route::get('/api/merchants/{merchant}/edit', [MerchantController::class, 'edit']);
Route::post('/api/merchants/{merchant}/edit', [MerchantController::class, 'update']);

// Customer Route
Route::post('/api/customers/{customer}/edit', [CustomerController::class, 'update']);
Route::get('/api/customers/{customer}/edit', [CustomerController::class, 'edit']);
Route::post('/api/customers/register', [CustomerController::class, 'store']);

Route::get('/api/customers', [CustomerController::class, 'index']);
Route::get('{view}', ApplicationController::class)->where('view', '(.*)');
