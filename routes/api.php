<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriberController;
//use App\Http\Controllers\AnalysisController;//アンケート分析用


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
//Route::post('/subscribe', [SubscriberController::class, 'subscribe']);

Route::get('/fs/analysis/data', [AnalysisController::class, 'getData'])->name('data.get');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
