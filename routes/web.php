<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// 以下を追加
Route::resource('articles', 'ArticlesController');

Route::get('/day', 'ArticlesController@day');
Route::get('/week', 'ArticlesController@week');
Route::get('/month', 'ArticlesController@month');
Route::get('/year', 'ArticlesController@year');
Route::get('/', 'ArticlesController@year');
