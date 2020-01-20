<?php

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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/getPasien', 'HomeController@dataPasien')->name('getPasien');
Route::get('/surat', 'HomeController@showSurat')->name('showSurat');
Route::post('/surat', 'HomeController@showSuratV')->name('showSurat');
Route::get('/getSurat', 'HomeController@dataSurat')->name('getSurat');
Route::get('/detail/{id}', 'Homecontroller@detail')->name('detail.pasien');
Route::get('/add', 'Homecontroller@add')->name('add');
Route::post('/add', 'Homecontroller@addStore')->name('store');
Route::get('/autofill', 'Homecontroller@autofill')->name('autofill');
Route::get('/delete/surat/{id}', 'Homecontroller@deleteSurat')->name('delete.surat');
Route::get('/edit/surat/{id}', 'Homecontroller@v_edit_surat')->name('edit.surat');
Route::post('/edit/surat/{id}', 'Homecontroller@p_edit_surat')->name('edit.surat.proses');