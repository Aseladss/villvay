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


Route::middleware(['logincheck'])->group(function () {
    Route::resource('/todo', 'TodoController');
});

Route::get('/', 'LoginController@index');
Route::resource('login', 'LoginController');
Route::post('loginuser', 'LoginController@login');
Route::get('register', 'LoginController@register');
Route::post('loginuser', 'LoginController@login');