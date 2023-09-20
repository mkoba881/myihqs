<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\IhqsController;
use App\Http\Controllers\Admin\AdminController;
use App\Mail\SampleMail;//メール用コントローラー
use App\Http\Controllers\MailSendController;//メール用コントローラー
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
    return view('survey');
});

Route::get('/custom-route', function () {
    return view('survey'); // ビューファイルの名前に変更
});

//管理者権限付与用
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('assign-role', [AdminController::class, 'assignRoleForm'])->name('assign_role_form');
    Route::post('assign-role', [AdminController::class, 'assignRole'])->name('assign_role');
});

Route::controller(IhqsController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('ihqs/selection', 'selection')->name('ihqs.selection');
});

Route::get('/fs/answer/{hash}', [SurveyController::class, 'show'])->middleware('auth')->name('survey.answer');

Route::get('/fs/analysis/data', [AnalysisController::class, 'getData'])->name('data.get');

//選択画面用のルーティング
//Route::get('/api/get_survey_details/{formatId}', 'SurveyController@getSurveyDetails');
Route::get('/api/get_survey_details/{formatId}', [SurveyController::class, 'getSurveyDetails'])->name('get.survey');

Route::controller(IhqsController::class)->prefix('fs')->name('fs.')->middleware('auth')->group(function() {
    Route::get('analysis', 'analysis')->name('analysis');
    Route::get('selectanswer', 'selectanswer')->name('selectanswer');
    Route::get('answer', 'answer')->name('answer');
    Route::get('management', 'management')->name('management');
    Route::post('answerend', 'answerend')->name('answerend');
    Route::post('selectanswerend', 'selectanswerend')->name('selectanswerend');
    Route::get('make', 'make')->name('make');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::post('create', 'create')->name('create');
    Route::get('create', 'getcreate')->name('getcreate');
    
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
