<?php

namespace App\Modules;

use \AltoRouter;
use App\Modules\Controller;
use \Closure;

class Router extends AltoRouter {

    public $controllerPath;
    public $controllerNamespace;
    
    function __construct()
    {
        $this->controllerPath = __DIR__ . "/../controllers";
        $this->controllerNamespace = "App\Controllers";
    }

    public function newRoute(string $requestMethod, string $requestURI, string $controllerName, 
    string $functionName) : void
    {
        array_push($this->routes, array(
            $requestMethod,
            $requestURI,
            $controllerName,
            $functionName
        ));
    }

    public function automaticRoutes(string $baseRequestURI, string $controllerName) : void
    {
        self::newRoute('GET', $baseRequestURI.'/[i:pag]/[*:search]?', $controllerName, 'index');
        self::newRoute('GET', $baseRequestURI.'/new', $controllerName, 'new');
        self::newRoute('GET', $baseRequestURI.'/[i:id]', $controllerName, 'show');
        self::newRoute('GET', $baseRequestURI.'/[i:id]/edit', $controllerName, 'edit');
        self::newRoute('POST', $baseRequestURI.'/new', $controllerName, 'create');
        self::newRoute('PUT|PATCH', $baseRequestURI.'/[i:id]', $controllerName, 'update');
        self::newRoute('DELETE', $baseRequestURI.'/[i:id]', $controllerName, 'destroy');
    }

    /**
	 * Calls a resolved controller's function with parameters provided.
	 * 
	 * @param Controller& $_controller the resolved controller
	 * @param string $_function the function to call
	 * @param array& $_params the parameters
	 * 
	 * @return array& the result from this controller and function
	 */
	private function &callController(Controller &$_controller, string $_function, 
    array &$_params) : array
    {
        $result = [];

        $_controller->setup($_params, $this);

        if(!method_exists($_controller, $_function))
        {
            $errorArray = [];
            $errorArray["controller"] = get_class($_controller);
            $errorArray["function"] = $_function;

            $this->error($errorArray, "functionNotFound");
        }

        $result["httpResponseCode"] = $_controller->$_function();
        if($result["httpResponseCode"] == NULL)
            $result["httpResponseCode"] = 'GET';
        $result["content"] = $_controller->getContent();

        return $result;
    }

    public function processRequest() : void
	{
		$requestURI = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : "/";
		$requestMethod = $_SERVER['REQUEST_METHOD'];

		$match = $this->match();

        $controller = null;
		// check if we found a matching route
		if(!$match)
			$this->error(["message" => "Route not found"], "routeNotFound");
        else if( ($match["target"] instanceof Closure) ){
            self::routeWithClosure($match);
        }else{
            $controller = $this->requireController($match["target"]);
            if($controller == NULL)
                $this->error([], "controllerNotFound");
            $result = $this->callController($controller, $match["name"], $match["params"]);
            //print_r($result);
        }
		
    }

    private function routeWithClosure($match)
    {
        if( is_array($match) && is_callable( $match['target'] ) ) {
            call_user_func_array( $match['target'], $match['params'] ); 
        } else {
            // no route was matched
            header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        }
    }

    /**
	 * Resolves a controller by it's name. It includes the controller's file and also 
	 * creates an instance of it.
	 * 
	 * @param string $_controllerName The name of the controller to include
	 * @return BaseController 
	 */
	private function requireController(string $_controllerName) 
	{
		$file = $this->controllerPath . "/" . $_controllerName . ".php";

		// check if controller at $_path exists
		if(file_exists($file))
		{
			if(substr(exec("php -l " . $file), 0, 5) == "Error")
				return NULL;

			require_once $file;

			$identifier = $this->controllerNamespace . "\\" . $_controllerName;
			if(!class_exists($identifier))
				return NULL;

			$controller = new $identifier();
            if( $controller instanceof Controller )
                return $controller;
		}

		return NULL;
	}

}

?>