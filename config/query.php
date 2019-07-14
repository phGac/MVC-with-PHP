<?php
use App\Modules\Query;

$query = new Query();

if(!$query->testConnection())
{
    echo 'Error en la conexión a la base de datos';
    exit();
}

?>