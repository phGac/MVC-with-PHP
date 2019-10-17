<?php

use Kernel\Application;

$app = new Application();

$app->showErrors();
$app->env();
$app->dbTestConnection();
$app->loadRoutes();