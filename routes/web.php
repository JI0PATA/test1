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


Route::get('/myEvents/{id}', 'EventController@myEvents');

Route::get('/', 'HomeController@index')->name('home');

Route::get('/user/{id}', 'HomeController@showUser');

Route::get('/events', 'EventController@getAvailableEvents');

Route::get('/checkUser', 'Auth\RegisterController@checkUser');

Auth::routes();

/**
 * Переопределение роута для логина
 */
Route::post('/login', 'Auth\LoginController@login')->middleware('identifyUser');

/**
 * Роуты для панели администратора
 */
Route::prefix('admin')->middleware('admin')->group(function() {

    Route::get('/', 'AdminController@getIndex')->name('admin');

    Route::get('/addEvent', function() {
        return view('admin.add');
    })->name('addEvent');

    Route::get('/addEventXML', function() {
        return view('admin.addXML');
    })->name('addXML');

    Route::post('/addEvent', 'AdminController@create')->name('addEvent');
    Route::post('/addEventXML', 'AdminController@createXML')->name('addEventXML');
    Route::get('/deleteEvent/{id}', 'AdminController@delete')->name('deleteEvent');

    Route::get('/logout', 'AdminController@logout');

});

Route::prefix('profile')->middleware('auth')->group(function() {

    Route::get('/joinEvent/{id}', 'EventController@joinEvent')->name('joinEvent');
    Route::get('/events', 'EventController@myEvents')->name('myEvents');

    Route::get('/cancelEvent/{id}', 'EventController@cancelEvent')->name('cancelEvent');

});

Route::get('autocomplit', 'SearchController@autocomplit')->name('autocomplit');