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

$router->get('/api/agendas', ['uses' => 'AgendasController@getAll']);
$router->get('/api/agendas/{id}', ['uses' => 'AgendasController@get']);

$router->post('/api/agendas', ['uses' => 'AgendasController@create']);
$router->put('/api/agendas/{id}', ['uses' => 'AgendasController@update']);
$router->delete('/api/agendas/{id}', ['uses' => 'AgendasController@delete']);

$router->get('/api/team', ['uses' => 'TeamsController@getAll']);
$router->get('/api/team/{id}', ['uses' => 'TeamsController@get']);
$router->get('/api/team/{id}/agendas', ['uses' => 'TeamsController@getAgendas']);

$router->get('/api/team/{id}/members', ['uses' => 'MembersController@getAllForTeam']);
$router->post('/api/team/', ['uses' => 'TeamsController@create']);
$router->put('/api/team/{id}', ['uses' => 'TeamsController@update']);
$router->delete('/api/team/{id}', ['uses' => 'TeamsController@delete']);

$router->get('/api/member', ['uses' => 'MembersController@getAll']);
$router->get('/api/member/{id}', ['uses' => 'MembersController@get']);
$router->put('/api/member/{id}', ['uses' => 'MembersController@update']);
$router->post('/api/member', ['uses' => 'MembersController@create']);
$router->delete('/api/member/{id}', ['uses' => 'MembersController@delete']);

$router->get('/api/board', ['uses' => 'BoardController@getAll']);
$router->get('/api/board/{board_id}/active-sprint', ['uses' => 'BoardController@getActiveSprint']);
$router->get('/api/board/{board_id}/configuration', ['uses' => 'BoardController@getBoardConfiguration']);
$router->get('/api/sprint/{sprint_id}/issues', ['uses' => 'BoardController@getSprintIssues']);
$router->get('/api/avatars/{username}/{size}', ['uses' => 'BoardController@getAvatar']);

