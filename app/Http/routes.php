<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Home Route
Route::get('/home','HomeController@index');
//user Routes
Route::get('/user','HomeController@user_all');
Route::get('/user/search','HomeController@user_search');
Route::post('/user/search','HomeController@user_search');
Route::get('/user/search/{query}','HomeController@user_search_query');
Route::get('/user/{id}/edit','HomeController@user_edit');
Route::post('/user/{id}','HomeController@user_update');
Route::get('/user/{id}/delete','HomeController@user_delete');

//Auth Routes

Route::get('/', 'Auth\AuthController@getLogin');
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');
Route::get('/auth/register','Auth\AuthController@getRegister');
Route::post('/auth/register','Auth\AuthController@postRegister');

//client Routes
Route::get('/client/ajax_search','ClientsController@ajaxSearch');
Route::get('/client/{id}/delete','ClientsController@destroy');
Route::post('/client/search','ClientsController@search');
Route::get('/client/search','ClientsController@search');
Route::get('/client/search/{query}','ClientsController@search_query');
Route::resource('/client','ClientsController');


//representative Routes
Route::get('/representative/{id}/delete','RepresentativesController@destroy');
Route::post('/representative/search','RepresentativesController@search');
Route::post('/representative/search/{query}','RepresentativesController@search_query');
Route::get('/representative/search','RepresentativesController@index');
Route::resource('/representative','RepresentativesController');

//item Routes
Route::get('/item/{id}/delete','ItemController@destroy');
Route::post('/item/search','ItemController@search');
Route::get('/item/search','ItemController@search');
Route::get('/item/search/{query}','ItemController@search_query');
Route::get('/item/ajax_search','ItemController@ajaxSearch');
Route::get('/item/search_by_id','ItemController@search_by_id');
Route::resource('/item','ItemController');
//invoice Routes
Route::get('/invoice/{id}/delete','InvoiceController@destroy');
Route::post('/invoice/search','InvoiceController@search');
Route::get('/invoice/search','InvoiceController@search');
Route::resource('/invoice','InvoiceController');