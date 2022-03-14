<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@welcome');

Route::get('/signin', 'AuthController@signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout');
Route::get('/sendamrit', 'CalendarController@reply');
Route::get('/calendar', 'CalendarController@calendar');
Route::get('/messageA', 'CalendarController@amritmail');
Route::post('/sendamrit', 'CalendarController@pleasereply');
Route::get('/calendar/new', 'CalendarController@getNewEventForm');
Route::post('/calendar/new', 'CalendarController@createNewEvent');


Route::post('/messageSend',[
    'uses'=>'CalendarController@pleasereply',
    'as'=>'messageSend'    
]);

/*
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@welcome');

Route::get('/signin', 'AuthController@signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout');
Route::get('/viewMessage', 'CalendarController@viewMessage');
Route::get('/calendar/new', 'CalendarController@getNewEventForm');
Route::post('/calendar/new', 'CalendarController@createNewEvent');
*/