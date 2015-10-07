<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);

// Authentication routes...
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::get('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);

Route::get('/forgetpassword', ['as' => 'forget-password', 'uses' => 'Auth\AuthController@getForget']);
Route::post('/forgetpassword', ['as' => 'forget-password', 'uses' => 'Auth\AuthController@postForget']);

Route::get('/activate/{code}', ['as' => 'activate','uses' => 'Auth\AuthController@activate']);
Route::get('/recover/{code}', ['as' => 'recover','uses' => 'Auth\AuthController@recover']); 
Route::get('/resend/{mail}', ['as' => 'resend-activation-mail','uses' => 'Auth\AuthController@resend']);	



Route::group(['middleware' => 'auth'], function(){
    
    Route::get('/changepassword', ['as' => 'change-password', 'uses' => 'Auth\AuthController@getChangePassword']);
    Route::post('/changepassword', ['as' => 'change-password', 'uses' => 'Auth\AuthController@postChangePassword']);
    
    //Normal User
    Route::group(['middleware' => 'normal_user'], function(){
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'HomeController@dashboard']);
    });
    //Admin
    Route::group(['middleware' => 'admin'], function(){
        Route::get('admin', ['as' => 'admin', 'uses' => 'AdminController@index']);
    });   
    
});

