<?php

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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'  => 'admin'], function () {
    Route::get('/dashboard', 'Admin\DashboardController@dashboard')->name('admin.dashboard');
});

Route::group(['prefix'  => 'operator'], function () {
    Route::get('/dashboard', 'Operator\DashboardController@dashboard')->name('operator.dashboard');
});

Route::group(['prefix'  => 'verifikator'], function () {
    Route::get('/dashboard', 'Verifikator\DashboardController@dashboard')->name('verifikator.dashboard');
});