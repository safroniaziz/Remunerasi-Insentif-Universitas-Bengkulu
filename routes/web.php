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

    Route::group(['prefix'  => 'manajemen_periode'], function () {
        Route::get('/', 'Admin\PeriodeController@index')->name('admin.periode');
        Route::get('/tambah_periode', 'Admin\PeriodeController@add')->name('admin.periode.add');
        Route::post('/tambah_periode', 'Admin\PeriodeController@post')->name('admin.periode.post');
        Route::get('/ubah_periode/{id}', 'Admin\PeriodeController@edit')->name('admin.periode.edit');
        Route::patch('/update/{id}', 'Admin\PeriodeController@update')->name('admin.periode.update');
        Route::delete('/delete', 'Admin\PeriodeController@delete')->name('admin.periode.delete');
        Route::patch('/aktifkan_status/{id}', 'Admin\PeriodeController@aktifkanStatus')->name('admin.periode.aktifkan_status');
        Route::patch('/non_aktifkan_status/{id}', 'Admin\PeriodeController@nonAktifkanStatus')->name('admin.periode.non_aktifkan_status');
    });

    Route::group(['prefix'  => 'manajemen_rubrik'], function () {
        Route::get('/', 'Admin\RubrikController@index')->name('admin.rubrik');
        Route::get('/tambah_rubrik', 'Admin\RubrikController@add')->name('admin.rubrik.add');
        Route::post('/tambah_rubrik', 'Admin\RubrikController@post')->name('admin.rubrik.post');
        Route::get('/ubah_rubrik/{id}', 'Admin\RubrikController@edit')->name('admin.rubrik.edit');
        Route::patch('/update/{id}', 'Admin\RubrikController@update')->name('admin.rubrik.update');
        Route::delete('/delete', 'Admin\RubrikController@delete')->name('admin.rubrik.delete');
    });
});

Route::group(['prefix'  => 'operator'], function () {
    Route::get('/dashboard', 'Operator\DashboardController@dashboard')->name('operator.dashboard');
    Route::group(['prefix'=>'data_remunisasi'],function(){
        route::get('/','operator\DataRemunController@index')->name('operator.dataremun');
        route::post('/store','operator\DataRemunController@store')->name('operator.dataremun.store');
        route::put('/status/{id}','operator\DataRemunController@status')->name('operator.dataremun.status');
        route::put('/tambah_isian/{id}','operator\DataRemunController@tambah_isian')->name('operator.dataremun.tambah_isian');
        route::delete('/{id}/delete','operator\DataRemunController@destroy')->name('operator.dataremun.destroy');
    });

    Route::group(['prefix'=>'detail_rubrik'],function(){
        route::get('/{id}/','operator\DetailRubrikController@index')->name('operator.detailrubrik');
        route::post('/{id}/store','operator\DetailRubrikController@store')->name('operator.detailrubrik.store');
        route::delete('/{id_rubrik}/destroy','operator\DetailRubrikController@destroy')->name('operator.detailrubrik.destroy');
    });
});

Route::group(['prefix'  => 'verifikator'], function () {
    Route::get('/dashboard', 'Verifikator\DashboardController@dashboard')->name('verifikator.dashboard');
});
