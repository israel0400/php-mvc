<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

define('BASE_URL','http://localhost:5000/');

use FastRoute\RouteCollector;
$container = require __DIR__ . "/app/bootstrap.php";

$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $router)
{
    $router->addRoute("GET", "/", ['Application\Controllers\DashboardController', 'index']);
    $router->addRoute("GET", "/insert", ['Application\Controllers\HomeController', 'insert']);
    $router->addRoute("GET", "/users", ['Application\Controllers\HomeController', 'users']);
    $router->addRoute("GET", "/user/{id:\d+}", ['Application\Controllers\HomeController', 'user']);
    $router->addRoute("GET", "/update/{id:\d+}", ['Application\Controllers\HomeController', 'update']);
    $router->addRoute("GET", "/delete/{id:\d+}", ['Application\Controllers\HomeController', 'delete']);
    $router->addRoute("GET", "/username/{username}", ['Application\Controllers\HomeController', 'username']);
    $router->addRoute("GET", "/post/user/{id:\d+}", ['Application\Controllers\HomeController', 'newpost']);
    $router->addRoute("GET", "/posts/user/{id:\d+}", ['Application\Controllers\HomeController', 'postsbyuser']);
    $router->addRoute(["GET", "POST"], "/register", ['Application\Controllers\AuthController', 'register']);
    $router->addRoute("POST", "/logout", ['Application\Controllers\DashboardController', 'logout']);
    $router->addRoute(["GET", "POST"], "/login", ['Application\Controllers\AuthController', 'login']);
    
});

$route = $dispatcher->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);

switch($route[0])
{
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "404 NOT FOUND";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo "405 NOT ALLOWED";
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $container->call($controller, $parameters);
        break;
}
