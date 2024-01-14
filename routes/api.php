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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::controller(AuthController::class)->group(function (): void {
    Route::post('/auth/login', 'login');
    Route::post('/auth/logout', 'logout')->name('logout')->middleware('auth:api');
});


Route::group(['prefix' => 'panics', 'middleware' => [
        'auth:api', 'cors']], function () {

    Route::post('create', [PanicController::class, 'createPanic']);
    Route::post('cancel', [PanicController::class, 'cancelCategory']);
    Route::get('panic-history', [PanicController::class, 'panicHistory']);
});
