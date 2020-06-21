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
Route::get('/','DirectoryController@index')->name('index');
Route::get('/create', "DirectoryController@create")->name('create');;
Route::post('store','DirectoryController@store')->name('store_file');
Route::get('{file}/edit', "DirectoryController@edit")->name('edit');;
Route::put('{file}/update','DirectoryController@update')->name('update');
Route::delete('{file}/destroy', 'DirectoryController@destroy')->name('destroy');
Route::get('{file}/show', 'DirectoryController@show')->name('show');
Route::get('filehistory', 'DirectoryController@filehistory')->name('filehistory');