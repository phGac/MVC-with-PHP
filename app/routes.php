<?php

$router->addRoute('GET', '/', 'App\Controllers\HomeController::index');
$router->addRoute('GET', '/login', 'App\Controllers\HomeController::login');
$router->addRoute('GET', '/register', 'App\Controllers\HomeController::register');
$router->addRoute('GET', '/logout', 'App\Controllers\UserController::logout');

$router->addGroup('/users', function (RouteCollector $r) {
    $r->addRoute('GET', '/all', 'App\Controllers\UserController::all');
    $r->addRoute('POST', '/login/[a:user]/[a:password]', 'App\Controllers\UserController::login');
    $r->addRoute('POST', '/register/[a:user]/[a:password]', 'App\Controllers\UserController::register');
});