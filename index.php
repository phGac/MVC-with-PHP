<?php

/** 
 * 
 * Autor: Philippe Gac
 * 
 *  .
 *  ├─── app            : directorio de de la applicación
 *  │     ├ build       : directorio de archivos para el uso de templates
 *  │     ├ controllers : directorio de controladores 
 *  │     ├ helpers     : directorio de archivos helpers (métodos, clases, etc. que pueden ser llamados en todo la aplicacion) 
 *  │     ├ models      : directorio de modelos
 *  │     ├ resources   : directorio de recursos (js, css, icon, etc)
 *  │     └ views       : directorio de vistas
 *  ├─── config         : directorio de configuacion
 *  │     ├ application : llamada a los archivos de configuración
 *  │     ├ controllers : llamada de los controladores
 *  │     ├ database    : configuracion de la base de datos
 *  │     ├ helpers     : llama a los archivos helpers
 *  │     ├ modules     : llama a los modulos
 *  │     ├ router      : configuracion de las friendly routes (rutas amigables)
 *  │     └ session     : configuracion de sesiones
 *  ├─── modules        : directorio de los módulos
 *  └─── public         : directorio público
 * 
 *  En el caso de usar Composer, puede incluir la siguiente línea para cargar sus Clases:
 *      require_once('../vendor/autoload.php');
 */

/** Display Errors */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** No Caché */
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once __DIR__.'/config/application.php';

?>