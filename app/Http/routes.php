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

Route::get('/', ['uses' => 'CubeSummationController@index', 'as' => 'cube-summation.index']);

Route::post('/', ['uses' => 'CubeSummationController@process', 'as' => 'cube-summation.process']);
