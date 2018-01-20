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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/questions/{part}','HomeController@questions');
Route::get('/parse/{part}', 'HomeController@parse');
Route::get('/answers/{part}', 'HomeController@answers');
Route::get('/search', 'HomeController@searchPage');
Route::post('/search', 'HomeController@search');
Route::get('/get/{title}', 'HomeController@getVariant');
