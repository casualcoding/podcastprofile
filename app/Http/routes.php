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

Route::get('/feed', 'StaticController@testFeed');

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
    Route::get('/', 'StaticController@getIndex')->name('home');

    Route::group(['prefix' => 'auth/twitter', 'as' => 'auth::'], function () {
        Route::get('/', 'Auth\AuthController@redirectToProvider')->name('login');
        Route::get('/callback', 'Auth\AuthController@handleProviderCallbackAsRedirect')->name('callback');
        Route::get('/callback/json', 'Auth\AuthController@handleProviderCallbackAsJson')->name('callback::json');
        Route::get('/logout', 'Auth\AuthController@logout')->name('logout');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/settings', 'StaticController@getSettings')->name('settings');

        Route::group(['prefix' => 'admin', 'as' => 'admin::'], function () {
            Route::group(['middleware' => ['admin']], function () {
                Route::get('/', 'AdminController@getAdmin')->name('admin');
                Route::get('/users', 'AdminController@getUsers')->name('getUsers');
                Route::get('/podcasts', 'AdminController@getPodcasts')->name('getPodcasts');
                Route::get('/podcasts/edit/{id}', 'AdminController@getEditPodcast')->name('getEditPodcast');
                Route::get('/jobs', 'AdminController@getJobs')->name('getJobs');
                Route::get('/failedjobs', 'AdminController@getFailedJobs')->name('getFailedJobs');
            });
        });
    });

    Route::group(['prefix' => 'api/1', 'as' => 'api::'], function () {
        Route::group(['middleware' => ['auth']], function () {
            Route::post('update', 'ProfileApiController@postProfile')->name('profile');
            Route::post('update/image', 'ProfileApiController@postProfileImage')->name('profile::image');
            Route::post('podcasts', 'ProfileApiController@postUpdatePodcasts')->name('podcasts');
            Route::post('upload/rss', 'ProfileApiController@postPodcastByRss')->name('postPodcastByRss');
            Route::post('upload/opml', 'ProfileApiController@postPodcastsByOpml')->name('postPodcastsByOpml');
            Route::post('delete/account', 'ProfileApiController@postDeleteAccount')->name('postDeleteAccount');

            Route::group(['prefix' => 'admin', 'as' => 'admin::'], function () {
                Route::group(['middleware' => ['admin']], function () {
                    Route::post('editpodcast/{id}', 'AdminApiController@postEditPodcast')->name('postEditPodcast');
                    Route::post('deletejob/{id}', 'AdminApiController@postDeleteJob')->name('postDeleteJob');
                });
            });

        });
    });

    Route::get('/top', 'StaticController@getTop')->name('top');

    Route::get('/impressum', 'StaticController@getImpressum')->name('impressum');

    // last
    Route::get('/{handle}', 'StaticController@getProfile')->name('profile');

});
