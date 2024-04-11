<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ApplicationController;

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

Route::post('/api/customers/{customer}/edit', [CustomerController::class, 'update']);
Route::get('/api/customers/{customer}/edit', [CustomerController::class, 'edit']);
Route::post('/api/customers/register', [CustomerController::class, 'store']);

Route::get('/api/customers', [CustomerController::class, 'index']);
Route::get('{view}', ApplicationController::class)->where('view', '(.*)');
