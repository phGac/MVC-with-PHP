<?php

$resources = 'resources/';

/** ruta a la estructura del sitio */
define('_LAYOUTS',__DIR__.'/../../resources/views/layouts/_', true);
define('_VIEWS', __DIR__.'/../../resources/views/', true); //controllers
define('_JS', $resources.'js/', true);
define('_CSS', $resources.'css/', true);
define('_ASSESTS', $resources.'assets/', true);

/** index */
define('PAGE_TITLE', "Terraservice S.A.", true);

?>