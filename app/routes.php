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

Route::get( 'user/create',                 'Pulse\Backend\UserController@create');
Route::post('user',                        'Pulse\Backend\UserController@store');
Route::get( 'user/login',                  'Pulse\Backend\UserController@login');
Route::post('user/login',                  'Pulse\Backend\UserController@do_login');
Route::get( 'user/confirm/{code}',         'Pulse\Backend\UserController@confirm');
Route::get( 'user/forgot_password',        'Pulse\Backend\UserController@forgot_password');
Route::post('user/forgot_password',        'Pulse\Backend\UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'Pulse\Backend\UserController@reset_password');
Route::post('user/reset_password',         'Pulse\Backend\UserController@do_reset_password');
Route::get( 'user/logout',                 'Pulse\Backend\UserController@logout');


Route::get('admin/pages',           'Pulse\Backend\PagesController@index');
Route::get('admin/page/{id}',       'Pulse\Backend\PagesController@show');
Route::get('admin/page/{id}/edit',  'Pulse\Backend\PagesController@edit');
Route::get('admin/pages/create',    'Pulse\Backend\PagesController@create');
Route::delete('admin/page/{id}',    'Pulse\Backend\PagesController@destroy');
Route::put('admin/page/{id}',       'Pulse\Backend\PagesController@update');
Route::post('admin/page',           'Pulse\Backend\PagesController@store');
