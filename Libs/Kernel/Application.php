<?php

namespace Kernel;

use Kernel\base\Query;
use Kernel\base\Resources;
use FastRoute;

class Application
{
    private const appFolder = __DIR__.'/../../app';

    public function showErrors() : void
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    public function env() : void
    {
        $env = require(__DIR__.'/../../.env.php');
        foreach ($env as $key => $value) {
           $_ENV[$key] = $value;
        }
    }

    public function noCachePHPFiles() : void
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    public function dbTestConnection() : void
    {
        if(!Query::testConnection())
        {
            echo 'Error en la conexión a la base de datos';
            exit();
        }
    }

    public function loadRoutes() : void
    {
        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {

            require(self::appFolder.'/routes.php');

        });
        
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        
        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                echo 'Not Found!!';
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                echo 'Metodo No Encontrado: '.$allowedMethods;
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                // ... call $handler with $vars
                
                if($handler instanceof \Closure){
                    $handler();
                }else{

                    $h = explode('::', $handler);
                    $className = $h[0];
                    $methodName = $h[1];
                    $class = new $className( $vars );
                    $class->$methodName();
                }

                break;
        }
    }

}

?>
