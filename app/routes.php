<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', 'Pulse\Frontend\CmsController@indexPosts');
Route::get('page_{slug}', 'Pulse\Frontend\CmsController@showPage');
Route::get('{slug}', 'Pulse\Frontend\CmsController@showPost');
