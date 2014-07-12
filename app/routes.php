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
