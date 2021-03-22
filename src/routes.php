<?php

$app->get('/', 'App\Controllers\HomeController:index');

$app->group('/auth', function($app) {
    $app->post('/login', 'App\Controllers\AuthController:login');
    $app->post('/register', 'App\Controllers\UserController:create');
    // Todo create api refetch token
});

$app->group('/users', function($app) {
    $app->get('', 'App\Controllers\UserController:find');
    $app->post('', 'App\Controllers\UserController:create');
    $app->get('/me', 'App\Controllers\UserController:me');
    $app->get('/{id}', 'App\Controllers\UserController:get');
    $app->put('/{id}', 'App\Controllers\UserController:update');
    $app->delete('/{id}', 'App\Controllers\UserController:delete');
})->add('auth');