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
  return view('home');
});

$router->get('/api/teams/', ['uses' => 'TeamsController@getAll']);
$router->post('/api/teams/', ['uses' => 'TeamsController@create']);

$router->get('/api/board/{board_id}/active-sprint', ['uses' => 'BoardController@getActiveSprint']);
