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
Route::get('/profile', 'StaticController@getProfile');

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
    Route::get('auth/twitter', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/twitter/callback', 'Auth\AuthController@handleProviderCallback');
    Route::get('auth/twitter/logout', 'Auth\AuthController@logout');
    Route::get('home', array('as' => 'home', 'uses' => function(){
      return view('home');
    }));

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/settings', 'StaticController@getSettings');
        Route::post('/upload', 'StaticController@postUpload');
    });

    Route::group(['prefix' => 'api/v1.0', 'as' => 'api::'], function () {
        Route::get('create/{name}', 'ProfileApiController@postNewUser')->name('postNewUser'); # TODO: POST
        Route::get('profile/{name}', 'ProfileApiController@getProfile')->name('getProfile');

        Route::group(['middleware' => ['auth']], function () {
            Route::get('update', 'ProfileApiController@postProfile')->name('postProfile'); # TODO: POST
            Route::post('upload/opml/', 'ProfileApiController@postPodcastsByOpml')->name('postPodcastsByOpml');
        });
    });
});
