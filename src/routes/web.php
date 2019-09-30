<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('spa');
});

/**
 * In a full app, this group would serve to apply middleware to the routes
 * inside and this would be in another file to separate the api from web routes
 */
$router->group(['prefix' => 'api', 'middleware' => []], function () use ($router) {
    $router->group(['prefix' => 'wmata'], function () use ($router) {
        $router->get('stations', 'WMATAApiController@getStationList');
        $router->get('trains', 'WMATAApiController@getNextTrains');
    });
});
