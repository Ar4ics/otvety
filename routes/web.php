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

Route::get('/part1', function () {
    return view('part1/questions');
});

Route::get('/part1/get', 'HomeController@part1');
Route::get('/part1/answers', 'HomeController@part1answers');
