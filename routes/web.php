<?php

use App\Http\Request;
use App\Http\Response;
use App\Http\Router;

$router = new Router(new Request(), new Response());

$router->get('/', 'home');
$router->get('/projects', "ProjectsController@list");
$router->get('/projects/{page}', "ProjectsController@list");
$router->get('/new', "ProjectsController@create");
$router->get('/project/{id}', "ProjectsController@read");
$router->get('/project/{id}/edit', "ProjectsController@edit");
$router->get('/project/{id}/delete', "ProjectsController@delete");

$router->post('/new', "ProjectsController@create");
$router->post('/project/{id}/edit', "ProjectsController@edit");

$router->resolve();
