<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () { 
    Route::post('register','App\Http\Controllers\Authentication\AuthController@registerUser');
    Route::post('login','App\Http\Controllers\Authentication\AuthController@login');
});

Route::prefix('v1/user')->middleware(['jwt.verify'])->group(function () { 
    Route::get('index/{page}','App\Http\Controllers\Dashboard\UsersController@index');
    Route::post('create','App\Http\Controllers\Dashboard\UsersController@store');
    Route::put('update','App\Http\Controllers\Dashboard\UsersController@update');
    Route::get('show/{id}','App\Http\Controllers\Dashboard\UsersController@show');
    Route::delete('destroy/{id}','App\Http\Controllers\Dashboard\UsersController@destroy');
});
