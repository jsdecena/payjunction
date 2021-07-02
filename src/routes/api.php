<?php

use Illuminate\Support\Facades\Route;
use Jsdecena\Payjunction\Http\Controllers\CustomerController;

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

// No need to do the controllers, only for testing
$apiOnly = [
    'index'
];

Route::prefix('api')->group(function () use ($apiOnly) {
    Route::resource('customers', CustomerController::class)->only($apiOnly);
});
