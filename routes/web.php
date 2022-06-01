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

    Route::prefix('dashboard')->group(function() {
        Route::middleware('auth')->group(function() {
            Route::controller('DashboardController')->group(function() {
                Route::get('', 'home')->name('dashboard');
                Route::get('profile', 'profile')->name('profile');
                Route::post('profile', 'profileSave');
                Route::get('password', 'password')->name('password');
                Route::post('password', 'passwordSave');
                Route::post('logout', 'logout')->name('logout');
            });
        });

        Route::middleware('access:adm.user')->resource('user', 'UserController');

        Route::controller('AdmController')->prefix('adm')->group(function() {
            Route::middleware('access:adm.pref')->prefix('preference')->group(function() {
                Route::get('', 'preference')->name('preference');
                Route::post('', 'preferenceSave');
            });
        });
    });
});
