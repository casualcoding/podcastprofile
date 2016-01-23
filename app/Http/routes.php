<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'StaticController@getIndex');
Route::get('/settings', 'StaticController@getSettings');
Route::get('/profile', 'StaticController@getProfile');
Route::post('/upload', 'StaticController@postUpload');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::group(['prefix' => 'api', 'as' => 'api::'], function () {
        Route::get('create/{name}', 'ProfileApiController@createUser')->name('create'); # TODO: POST
        Route::get('profile/{name}', 'ProfileApiController@getProfile')->name('profile');
    });

});


Route::get('auth/twitter', 'Auth\AuthController@redirectToProvider');
Route::get('auth/twitter/callback', 'Auth\AuthController@handleProviderCallback');

Route::get('home', array('as' => 'home', 'uses' => function(){
  return view('home');
}));
