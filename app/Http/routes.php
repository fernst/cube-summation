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

Route::get('/db', ['uses' => 'CubeSummationDBController@index', 'as' => 'cube-summation-db.index']);

Route::post('/db/create', ['uses' => 'CubeSummationDBController@create',
    'as' => 'cube-summation-db.create']);

Route::post('/db/update', ['uses' => 'CubeSummationDBController@update',
    'as' => 'cube-summation-db.update']);

Route::post('/db/query', ['uses' => 'CubeSummationDBController@query',
    'as' => 'cube-summation-db.query']);
