<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => '/api', 'middleware' => 'auth'], function() use ($router){

    $router->group(["prefix" => "/users"], function() use($router){
        $router->post('', 'UserController@store');
        $router->get('', 'UserController@index');
        $router->get('{id}', 'UserController@show');
        $router->put('{id}', 'UserController@update');
        $router->delete('{id}', 'UserController@destroy');
    });

    $router->group(["prefix" => "/transactions"], function() use($router){
        $router->post('', 'TransactionsController@store');
    });

});


$router->post('api/login', 'TokenController@login');
