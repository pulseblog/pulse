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

Route::get('admin/pages',           'Pulse\Backend\PagesController@index');
Route::get('admin/page/{id}',       'Pulse\Backend\PagesController@show');
Route::get('admin/page/{id}/edit',  'Pulse\Backend\PagesController@edit');
Route::get('admin/pages/create',    'Pulse\Backend\PagesController@create');
Route::delete('admin/page/{id}',    'Pulse\Backend\PagesController@destroy');
Route::put('admin/page/{id}',       'Pulse\Backend\PagesController@update');
Route::post('admin/page',           'Pulse\Backend\PagesController@store');

Route::get('admin/posts',           'Pulse\Backend\PostsController@index');
Route::get('admin/post/{id}',       'Pulse\Backend\PostsController@show');
Route::get('admin/post/{id}/edit',  'Pulse\Backend\PostsController@edit');
Route::get('admin/posts/create',    'Pulse\Backend\PostsController@create');
Route::delete('admin/post/{id}',    'Pulse\Backend\PostsController@destroy');
Route::put('admin/post/{id}',       'Pulse\Backend\PostsController@update');
Route::post('admin/post',           'Pulse\Backend\PostsController@store');

// Confide routes
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
