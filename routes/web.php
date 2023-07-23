<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\IhqsController;
//use App\Mail\TestMail;//メール用コントローラー
use App\Mail\SampleMail;//メール用コントローラー
use App\Http\Controllers\MailSendController;//メール用コントローラー
//use App\Http\Controllers\Api\ContactController;//メール用コントローラー
use App\Http\Controllers\SurveyController;//アンケートリンク複合用
use App\Http\Controllers\AnalysisController;//アンケート分析用


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(IhqsController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('ihqs/selection', 'add')->name('ihqs.selection');
});

Route::get('/fs/answer/{hash}', [SurveyController::class, 'show'])->middleware('auth')->name('survey.answer');

Route::get('/fs/analysis/data', [AnalysisController::class, 'getData'])->name('data.get');


Route::controller(IhqsController::class)->prefix('fs')->name('fs.')->middleware('auth')->group(function() {
    Route::get('analysis', 'analysis')->name('analysis');
    Route::get('answer', 'answer')->name('answer');
    Route::get('management', 'management')->name('management');
    Route::post('answerend', 'answerend')->name('answerend');
    Route::get('make', 'make')->name('make');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::post('create', 'create')->name('create');
    Route::get('makepreview', 'makepreview')->name('makepreview');
    Route::post('deleteankate', 'deleteankate')->name('deleteankate');
    Route::get('conductankate', 'conductankate')->name('conductankate');
    Route::post('conductankatepreview', 'conductankatepreview')->name('conductankatepreview');
    Route::post('saveconductankate', 'saveconductankate')->name('saveconductankate');
});


//メール送信用のルーティング

Route::controller(MailSendController::class)->prefix('mail')->name('mail.')->middleware('auth')->group(function() {
    //Route::post('send', 'sendMail')->name('send');
    Route::get('testmail', 'send')->name('testmail');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
