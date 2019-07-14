<?php

/** 
 * 
 * Autor: Philippe Gac
 * 
 *  .
 *  ├─── app/
 *  │     ├ controllers/     : directorio de controladores 
 *  │     ├ helpers/         : directorio de archivos helpers (métodos, clases, etc. que pueden ser llamados en toda la aplicacion) 
 *  │     ├ models/          : directorio de modelos
 *  │     ├ modules/         : directorio de modulos internos
 *  │     └ routes           : configuracion de rutas
 *  ├─── config/
 *  │     ├ app.json         : archivo de configuracion de la base de datos, entre otros.
 *  │     ├ application.php  : archivo de inicio de la aplicacion.
 *  │     ├ helpers.php      : llama a los archivos helpers
 *  │     ├ router.php       : configuracion de las friendly routes (rutas amigables)
 *  │     └ session.php      : configuracion de sesiones
 *  ├─── logs/
 *  │     ├ log.log          : indica donde se genero un nuevo log
 *  │     └ query.log        : guarda los log relacionados con la base de datos
 *  ├─── resources/
 *  │     ├ assets/          : archivos png, jpeg, icon, etc.
 *  │     ├ css/             : archivos css
 *  │     ├ js/              : archivos js
 *  │     └ views/           : vistas
 *  ├─── tests/              : configuracion de pruebas (tests)
 *  └─── vendor/             : directorio de Composer
 * 
 * 
 *                              __routes__
 * 
 *    $router = new Router();
 *
 *    $router->automaticRoutes('/actividades', 'ClienteController');
 *            
 *    ┌────────┬──────────────────────────────────┬───────────────┬──────────┐
 *    │  HTTP  │            ruta                  │   Controller  │  Método  │
 *    ├────────┼──────────────────────────────────┼───────────────┼──────────┤
 *    │   GET  │ /actividades/[i:pag]/[*:search]? │    Cliente    │   index  │
 *    ├────────┼──────────────────────────────────┼───────────────┼──────────┤
 *    │   GET  │ /actividades/new                 │    Cliente    │   new    │
 *    ├────────┼──────────────────────────────────┼───────────────┼──────────┤
 *    │   GET  │ /actividades/[i:id]              │    Cliente    │   show   │
 *    ├────────┼──────────────────────────────────┼───────────────┼──────────┤
 *    │   GET  │ /actividades/[i:id]/edit         │    Cliente    │   edit   │
 *    ├────────┼──────────────────────────────────┼───────────────┼──────────┤
 *    │   POST │ /actividades/new                 │    Cliente    │  create  │
 *    ├────────┼──────────────────────────────────┼───────────────┼──────────┤
 *    │   PUT  │ /actividades/[i:id]              │    Cliente    │  update  │
 *    ├────────┼──────────────────────────────────┼───────────────┼──────────┤
 *    │ DELETE │ /actividades/[i:id]              │    Cliente    │  destroy │
 *    └────────┴──────────────────────────────────┴───────────────┴──────────┘
 * 
 * 
 */

require_once 'config/application.php';

?>