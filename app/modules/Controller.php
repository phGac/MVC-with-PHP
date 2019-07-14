<?php

namespace App\Modules;

use App\Modules\IController;

abstract class Controller implements IController
{
	protected $params;
	protected $content;
    protected $kernel;

    protected $viewFolder = __DIR__.'/../../resources/views/';
    
    protected function View(string $viewName) : void
    {
        require($this->viewFolder.$viewName);
    }

	public function setup(array &$_params, &$_kernel) : void
	{
        //$this->params = $_params;
        self::setParams($_params);
		$this->content = array();
		$this->kernel =& $_kernel;
    }
    
    private function setParams(array &$_params)
    {
        $params = array();
        foreach ($_params as $key => $param) {
            $params[$key] = urldecode($param);
        }
        $this->params = $params;
    }

	public function &getContent() : array
	{
		return $this->content;
	}
}
?>