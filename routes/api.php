<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['cors'])->group(function () {
    Route::options('{any?}', function () {
        return '';
    })->where('any', '.*');
    Route::post('/user/register', 'AuthController@register');
    Route::post('/user/login', 'AuthController@login');

    Route::middleware('checkUser')->get('/user/checkToken', 'UserController@checkToken');
    Route::middleware('checkUser')->get('/user/profile', 'UserController@getProfile');
    Route::middleware('checkUser')->post('/user/profile', 'UserController@setProfile');
    Route::middleware('checkUser')->post('/user/avatar', 'UserController@setAvatar');
    Route::middleware('checkUser')->get('/courses', 'CoursesController@get');
    Route::middleware('checkUser')->get('/courses/search', 'CoursesController@search');
    Route::middleware('checkUser')->put('/words', 'WordsController@learn');
});

