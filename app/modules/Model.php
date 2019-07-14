<?php

namespace App\Modules;

use App\Modules\Query;

abstract class Model
{
    protected $tableName;
    protected $pk;
    protected $maxPerPag;
    protected $log;

    function __construct()
    {
        $this->pk = 'id';
        $this->maxPerPag = 10;
    }

    public function getLog() { return $this->log; }

    /**
     * retorna el id maximo de la tabla/modelo
     *
     * @return integer
     */
    public function maxId() : int
    {
        $sql = "SELECT max()";
        return 0;
    }

    /**
     * crea una conexión a una base de datos con un objeto DataBase
     *
     * @return bool
     */
    private function setConn() : bool
    {
        $query = new Query();
        if( ( $conn = $query->newConn()) != null ){
            $this->conn = $conn;
            return true;
        }
        return false;
    }

    public function clearConn()
    {
        $this->conn = null;
    }

    /**
     * obtiene una lista de objetos y los retorna en un array
     *
     * @param int $pag
     * @param int $search
     * @return array
     */
    protected function index( int $pag, string $search) {  }

    /**
     * retorna un objeto del tipo de la clase heredada de Model
     *
     * @param int $id
     * @return object|null
     */
    protected function show(int $id) { }

    /**
     * Crea un objeto con atributos por defecto
     *
     * @return object
     */
    protected function new() { }

    /**
     * crea un objeto con los atributos pasados
     *
     * @return object|null
     */
    protected function create( array $parameters ) { }

}

?>