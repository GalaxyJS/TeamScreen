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

$router->get('/tim', function () use ($router) {
  return view('tim');
});

$router->get('/api.js/teams/', ['uses' => 'TeamsController@getAll']);
$router->post('/api.js/teams/', ['uses' => 'TeamsController@create']);

$router->get('/api.js/boards', ['uses' => 'BoardController@getAll']);
$router->get('/api.js/boards/{board_id}/active-sprint', ['uses' => 'BoardController@getActiveSprint']);
$router->get('/api.js/boards/{board_id}/configuration', ['uses' => 'BoardController@getBoardConfiguration']);
$router->get('/api.js/sprints/{sprint_id}/issues', ['uses' => 'BoardController@getSprintIssues']);
