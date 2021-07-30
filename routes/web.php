<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('chat')->group(function () {
    Route::get('/with/{user}', [ChatController::class, 'with'])->name('chat.with');
    Route::get('/{chat}', [ChatController::class, 'show'])->name('chat.show');
});

Route::post('/message/sent', [MessageController::class, 'sent']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
