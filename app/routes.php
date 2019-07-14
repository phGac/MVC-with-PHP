<?php

use App\Modules\Router;

$router = new Router();

$router->automaticRoutes('/users', 'UserController');

$router->newRoute('GET', '/', 'HomeController', 'index');
$router->newRoute("GET", "/login", "HomeController", "login");
$router->newRoute("GET", "/register", "HomeController", "register");
$router->newRoute('GET', '/logout', 'UserController', 'logout');
$router->newRoute("POST", '/users/login/[a:user]/[a:password]', "UserController", "login");
$router->newRoute('POST', '/users/register/[a:user]/[a:password]', 'UserController', 'register');

$router->newRoute('GET', '/users/all', 'UserController', 'all');

$router->processRequest();

?>