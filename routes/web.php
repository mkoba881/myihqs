<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\Admin\IhqsController;
Route::controller(IhqsController::class)->prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('ihqs/selection', 'add');
});
Route::controller(IhqsController::class)->middleware('auth')->group(function() {
    Route::get('fs/analysis', 'analysis');
});

Route::get('fs/analysis', [IhqsController::class, 'analysis'])->name('fs.analysis');
Route::get('fs/answer', [IhqsController::class, 'answer'])->name('fs.answer');
Route::get('fs/management', [IhqsController::class, 'management'])->name('fs.management');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
