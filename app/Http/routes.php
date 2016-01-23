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

});

Route::group(['prefix' => 'api/v1.0', 'as' => 'api::'], function () {
    Route::get('create/{name}', 'ProfileApiController@postNewUser')->name('postNewUser'); # TODO: POST
    Route::get('profile/{name}', 'ProfileApiController@getProfile')->name('getProfile');

    Route::group(['middleware' => []], function () { # TODO: 'auth' middleware
        Route::get('update', 'ProfileApiController@postProfile')->name('postProfile'); # TODO: POST
        Route::post('upload/opml/', 'ProfileApiController@postPodcastsByOpml')->name('postPodcastsByOpml');
    });
});
