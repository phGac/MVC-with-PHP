<?php

$router->addRoute('GET', '/', 'App\Controllers\HomeController::index');
$router->addRoute('GET', '/login', 'App\Controllers\HomeController::login');
$router->addRoute('GET', '/register', 'App\Controllers\HomeController::register');
$router->addRoute('GET', '/logout', 'App\Controllers\UserController::logout');

$router->addGroup('/users', function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/all', 'App\Controllers\UserController::all');
    $r->addRoute('POST', '/login/{user:[a-z0-9]}/{password:[a-z0-9]}', 'App\Controllers\UserController::login');
    $r->addRoute('POST', '/register/{user:[a-z0-9]}/{password:[a-z0-9]}', 'App\Controllers\UserController::register');
});