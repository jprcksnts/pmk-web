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

Route::get('/', function () {
    return view('landing_page');
});

Route::get('/login', 'Web\Auth\WebAuthPageController@displayLoginPage');
Route::get('/signup', 'Web\Auth\WebAuthPageController@displaySignupPage');

Route::post('/login', 'Web\Auth\WebAuthController@login');
Route::post('/signup', 'Web\Auth\WebAuthController@signup');
