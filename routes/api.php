<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Panics\PanicController;
use Illuminate\Http\Request;
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

//Route::post('panics/create', [PanicController::class, 'createPanic']);
//Route::get('test', [PanicAlertController::class, 'test']);


Route::controller(AuthController::class)->group(function (): void {
    Route::post('/auth/login', 'login');
    Route::post('/auth/logout', 'logout')->name('logout')->middleware('auth:api');
});


Route::group(['prefix' => 'panics', 'middleware' => [
        'auth:api', 'cors']], function () {

    Route::post('create', [PanicController::class, 'createPanic'])->middleware('api.logger');
    Route::post('cancel', [PanicController::class, 'cancelPanicAlert'])->middleware('api.logger');
    Route::get('panic-history', [PanicController::class, 'getUserNotificationHistory']);
});



