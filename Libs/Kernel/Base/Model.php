<?php

namespace Kernel\Base;

use Kernel\base\Query;

abstract class Model
{
    protected $tableName;
    protected $pk;
    protected $maxPerPag;
    protected $log;

    protected $conn;
    protected $attrs = array(
        \PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL,
        \PDO::SQLSRV_ATTR_ENCODING => \PDO::SQLSRV_ENCODING_UTF8
    );

    function __construct()
    {
        $this->maxPerPag = 10;
    }

    public function __isset($name)
    {
        switch($name){
            case 'conn': 
                if( empty($this->conn) ){
                    $this->conn = Query::newConn();
                }
                break;
        }
        return true;
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

    public function getNewId(string $tableName, string $columnName = 'id') : ?int
    {
        $sql = "SELECT (MAX($columnName)+1) AS new_id FROM $tableName";
        $stm = $this->conn->prepare($sql, $this->attrs);
        $stm->execute();
        switch($stm->rowCount()){
            case 0: 
                if ( $stm->errorCode() != 0 ){ 
                    Log::errorQuery(__FILE__, 1, __LINE__, 0, $stm);
                    return null;
                }else{
                    return 0;
                }
                break;
            case 1: 
                $row = $stm->fetch();
                return (int) $row['new_id'];
                break;
            default: 
                return null; 
                break;
        }
    }

    /**
     * crea una conexión a una base de datos con un objeto DataBase
     *
     * @return bool
     */
    protected function setConn() : bool
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
    protected function index( int $pag = null, string $search = null) {  }

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