<?php

namespace Kernel\Base;

use Kernel\base\IController;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class Controller implements IController
{
    protected $params;
    protected $twig;
    protected const viewsFolder = __DIR__.'/../../../resources/views/';

    public function __construct(array $params = null)
    {
        $this->params = $params;
        $this->setTiwg();
    }

    protected $attrsTiwg = [
        'autoescape' => false,
        'cache' => __DIR__.'/../../var/cache'
    ];

	protected function json(array $data) : void
	{
        header("Content-type:application/json");
        echo json_encode($data, JSON_FORCE_OBJECT);
    }



    protected function render($tiwgFileName, array $parameters = array()) : string
    {
        $tiwgFile = sprintf("%s.html.twig", $tiwgFileName);
        $file = self::viewsFolder.$tiwgFile;

        if (file_exists($file)) {
            return $this->twig->render($tiwgFile, $parameters);
        }else{
            return 'Twig: File Not Fond.';
        }
    }

    protected function js($fileName) : string
    {
        $fileName = sprintf('%s.js.twig', $fileName);
        $file = self::viewsFolder.$fileName;
        if(file_exists($file)){
            return $this->twig->render($fileName);
        }
    }

    private function loader() : FilesystemLoader
    {
        return new FilesystemLoader(self::viewsFolder);
    }

    private function setTiwg() : void
    {
        $this->twig = new Environment($this->loader(), ['debug' => true]);
    }

}
?>