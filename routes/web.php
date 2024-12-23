<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

use App\Http\Controllers\StarController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CardCodeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\StartPointsController;


Route::get('/api/order/lists', [OrderController::class, 'Adminindex']);
Route::get('/api/loyalty-stars/order/{order}/edit', [OrderController::class, 'edit']);
Route::put('/api/loyalty-stars/order/create', [OrderController::class, 'orderAccept']);

Route::get('/api/activity-logs', [ActivityLogController::class, 'index']);
Route::get('/api/user/activity-logs', [ActivityLogController::class, 'indexUser']);
Route::post('/api/voucher/create', [CartController::class, 'store']);
Route::get('/api/voucher', [CartController::class, 'index']);
Route::put('/api/voucher/edit/{id}', [CartController::class, 'update']);
Route::delete('/api/voucher/{id}', [CartController::class, 'destroy']);

// Merchant Account
Route::get('/api/card/lists', [OrderController::class, 'index']);

Route::get('/api/home/customer/{card_number}/points', [CustomerController::class, 'customerResult']);

Route::get('/api/stars', [StarController::class, 'index']);


Route::post('/api/loyalty-stars/crete', [StartPointsController::class, 'store']);
Route::post('/api/loyalty-stars/crete', [StartPointsController::class, 'update']);
Route::get('/api/loyalty-stars/{merchant}/edit', [StartPointsController::class, 'edit']);
Route::put('/api/loyalty-stars/edit', [StartPointsController::class, 'update']);

// Merchant Route
Route::get('/api/merchant/discounts', [DiscountController::class,'merchantIndex']);

Route::get('/api/merchant/points', [PointController::class,'merchantIndex']);
Route::get('/api/merchant/points/{point}/edit', [PointController::class, 'edit']);
Route::post('/api/merchant/points/{point}/edit', [PointController::class, 'update']);

Route::post('/api/merchant/points/register', [PointController::class,'store']);

// Admin Route


// User Profile
Route::get('/api/profile', [ProfileController::class, 'index']);
Route::post('/api/upload-profile-image', [ProfileController::class, 'uploadImage']);
Route::post('/api/profile/upload-background-image', [ProfileController::class, 'uploadBackground']);
Route::put('/api/profile-information/edit', [ProfileController::class,'updateProfile']);
Route::put('/api/profile-business/edit', [ProfileController::class,'updateBusiness']);
Route::put('/api/profile-password/change', [ProfileController::class,'changePassword']);


// Tripidkard Route
Route::get('/api/tripidkards', [CardCodeController::class, 'index']);
Route::get('/api/merchant/tripidkards', [CardCodeController::class, 'merchantIndex']);

Route::post('/api/tripidkards/create', [CardCodeController::class, 'store']);
Route::get('/api/tripidkards/count', [CardCodeController::class, 'count']);


// Merchant Route
Route::get('/api/merchants', [MerchantController::class, 'index']);
Route::get('/api/merchants-pending', [MerchantController::class, 'indexPending']);
Route::get('/api/merchants-archive', [MerchantController::class, 'indexArchive']);
Route::post('/api/merchants/create', [MerchantController::class, 'store']);
Route::put('/api/merchants/{id}', [MerchantController::class, 'archive']);
Route::get('/api/merchants/{merchant}/edit', [MerchantController::class, 'edit']);
Route::put('/api/merchants/{merchant}/update', [MerchantController::class, 'update']);
Route::patch('/api/merchant/{id}/status/approve', [MerchantController::class, 'approve']);
Route::patch('/api/merchant/{id}/status/archive', [MerchantController::class, 'archive']);

Route::get('/api/merchants/count', [MerchantController::class, 'count']);


// Influencer Route
Route::get('/api/influencers', [InfluencerController::class, 'index']);
Route::get('/api/influencers-pending', [InfluencerController::class, 'indexPending']);
Route::get('/api/influencers-archive', [InfluencerController::class, 'indexArchive']);
Route::post('/api/influencers/create', [InfluencerController::class, 'store']);
Route::get('/api/influencers/{influencer}/edit', [InfluencerController::class, 'edit']);
Route::post('/api/influencers/{influencer}/edit', [InfluencerController::class, 'update']);
// In your routes/web.php or routes/api.php
Route::patch('/api/influencer/{id}/status/approve', [InfluencerController::class, 'approve']);
Route::patch('/api/influencer/{id}/status/archive', [InfluencerController::class, 'archive']);

Route::get('/api/influencers/count', [InfluencerController::class, 'count']);

// Customer Route
Route::post('/api/customers/{customer}/edit', [CustomerController::class, 'update']);
Route::get('/api/customers/{customer}/edit', [CustomerController::class, 'edit']);
Route::post('/api/customers/register', [CustomerController::class, 'store']);
Route::get('/api/customers/count', [CustomerController::class, 'count']);

Route::get('/api/customers', [CustomerController::class, 'index']);
Route::get('/api/user/customers', [CustomerController::class, 'indexUser']);
Route::get('/api/customer/{id}/points', [CustomerController::class, 'points']);
Route::get('{view}', ApplicationController::class)->where('view', '(.*)');


Route::post('/contact/send-email', [EmailController::class, 'sendContactUs']);
Route::post('/api/merchant/stars', [EmailController::class, 'sendStarPoint']);
Route::post('/api/card/orders', [EmailController::class, 'sendCard']);

Route::post('/api/merchant/qrcode', [QrcodeController::class, 'merchantQrCode']);
Route::post('/api/influencer/qrcode', [QrcodeController::class, 'influencerQrCode']);
Route::post('/api/home/qrcode', [QrcodeController::class, 'homeQrCode']);






require __DIR__.'/auth.php';
