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

$router->get('/api/teams/', ['uses' => 'TeamsController@getAll']);
$router->post('/api/teams/', ['uses' => 'TeamsController@create']);

$router->get('/api/boards', ['uses' => 'BoardController@getAll']);
$router->get('/api/boards/{board_id}/active-sprint', ['uses' => 'BoardController@getActiveSprint']);
$router->get('/api/boards/{board_id}/configuration', ['uses' => 'BoardController@getBoardConfiguration']);
$router->get('/api/sprints/{sprint_id}/issues', ['uses' => 'BoardController@getSprintIssues']);

$router->post('/api/members/', ['uses' => 'MembersController@create']);