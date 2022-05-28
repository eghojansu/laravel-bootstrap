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

Route::namespace('App\\Http\\Controllers')->middleware('visit')->group(function() {
    Route::controller('MainController')->group(function() {
        Route::get('', 'home')->name('home');
        Route::get('login', 'login')->name('login');
        Route::post('login', 'loginCheck');
    });

    Route::middleware('auth')->group(function() {
        Route::controller('DashboardController')->prefix('dashboard')->group(function() {
            Route::get('', 'home')->name('dashboard');
            Route::get('account', 'account')->name('account');
            Route::post('account', 'accountSave');
            Route::get('password', 'password')->name('password');
            Route::post('password', 'passwordSave');
            Route::post('logout', 'logout')->name('logout');
        });
    });
});
