<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Panics\PanicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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


//Route::get('/clear-cache', function () {
//    Artisan::call('cache:clear');
//});
//
//Route::get('/route-cache', function () {
//    Artisan::call('route:cache');
//});
//
//Route::get('/run-worker', function () {
//    Artisan::call('queue:work');
//});



Route::controller(AuthController::class)->group(function (): void {
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout')->middleware('auth:api');
});


Route::group(['prefix' => 'panics', 'middleware' => [
    'auth:api', 'cors' , 'json.response']], function () {
    Route::post('create', [PanicController::class, 'createPanic'])->middleware('api.logger');
    Route::post('cancel', [PanicController::class, 'cancelPanicAlert'])->middleware('api.logger');
    Route::get('panic-history', [PanicController::class, 'getUserNotificationHistory'])->middleware('api.logger');
});



