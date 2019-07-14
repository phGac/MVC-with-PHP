<?php

namespace App\Modules;

use App\Modules\Log;
use stdClass;

interface IModel
{
    /**
     * Retorna los log obtenidos en la ejecucion
     *
     * @return Log
     */
    public function getLog() : Log;

    /**
     * retorna el id maximo de la tabla/modelo
     *
     * @return integer
     */
    public function maxId() : int;

    /**
     * obtiene una lista de objetos y los retorna en un array
     *
     * @param int $pag
     * @param int $search
     * @return array
     */
    public function index( int $pag, string $search);

    /**
     * retorna un objeto del tipo de la clase heredada de Model
     *
     * @param int $id
     * @return object|null
     */
    public function show(int $id) : ?stdClass;

    /**
     * Crea un objeto con atributos por defecto
     *
     * @return object
     */
    public function new() : ?stdClass;

    /**
     * crea un objeto con los atributos pasados
     *
     * @return object|null
     */
    public function create( array $parameters ) : ?stdClass;
    
}

?>