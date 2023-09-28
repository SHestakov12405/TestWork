<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Todo\TodoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SessionSaveController;
use App\Http\Controllers\Todo\TodoUsersController;
use App\Http\Controllers\Todo\EditsUsersController;
use App\Http\Controllers\Account\IndexController as AccountController;

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

Route::get('/', function()
{
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('account.logout');

    Route::resource('users', TodoUsersController::class);

    Route::get('/account', AccountController::class)->name('account');
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('todo', TodoController::class);


    Route::middleware(['isEntitlements'])->group(function () {

        Route::get('/edits/save', SessionSaveController::class)->name('session.save');
        Route::resource('edits', EditsUsersController::class);

    });
});

Auth::routes();

