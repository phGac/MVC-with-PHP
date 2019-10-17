<?php

namespace Kernel\Base;

use Kernel\base\Log;
use stdClass;

interface IModel
{
    public function __get($propertyName);

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
     * inserta en la base de datos. De ser exitoso retorna el id, por el contrario retornará null.
     *
     * @return int|null
     */
    public function create( array $parameters ) : ?int; 
    
}

?>