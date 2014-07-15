<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/',             'Pulse\Frontend\CmsController@indexPosts');
Route::get('page-{slug}',   'Pulse\Frontend\CmsController@showPage');
Route::get('{slug}',        'Pulse\Frontend\CmsController@showPost');

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'before' => 'auth',
    'prefix' => 'admin',
    'namespace' => 'Pulse\Backend'
    ],
    function() {
        Route::get(   'pages',          'PagesController@index');
        Route::get(   'page/{id}',      'PagesController@show');
        Route::get(   'page/{id}/edit', 'PagesController@edit');
        Route::get(   'pages/create',   'PagesController@create');
        Route::delete('page/{id}',      'PagesController@destroy');
        Route::put(   'page/{id}',      'PagesController@update');
        Route::post(  'page',           'PagesController@store');

        Route::get(   'posts',          'PostsController@index');
        Route::get(   'post/{id}',      'PostsController@show');
        Route::get(   'post/{id}/edit', 'PostsController@edit');
        Route::get(   'posts/create',   'PostsController@create');
        Route::delete('post/{id}',      'PostsController@destroy');
        Route::put(   'post/{id}',      'PostsController@update');
        Route::post(  'post',           'PostsController@store');
    }
);

/*
|--------------------------------------------------------------------------
| Confide routes
|--------------------------------------------------------------------------
|
*/

Route::get( 'users/create',                 'Pulse\Backend\UsersController@create');
Route::post('users',                        'Pulse\Backend\UsersController@store');
Route::get( 'users/login',                  'Pulse\Backend\UsersController@login');
Route::post('users/login',                  'Pulse\Backend\UsersController@do_login');
Route::get( 'users/confirm/{code}',         'Pulse\Backend\UsersController@confirm');
Route::get( 'users/forgot_password',        'Pulse\Backend\UsersController@forgot_password');
Route::post('users/forgot_password',        'Pulse\Backend\UsersController@do_forgot_password');
Route::get( 'users/reset_password/{token}', 'Pulse\Backend\UsersController@reset_password');
Route::post('users/reset_password',         'Pulse\Backend\UsersController@do_reset_password');
Route::get( 'users/logout',                 'Pulse\Backend\UsersController@logout');
