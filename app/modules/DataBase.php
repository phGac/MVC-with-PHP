<?php

namespace App\Modules;

use \PDO;
use \PDOException;
use App\Modules\Log;
use App\Modules\AppConfig;

class DataBase
{
    private $user;
    private $pass;
    private $host;
    private $dbname;
    private $options;
    private $type;
    private $dns;
    protected $conn;

    function __construct()
    {
        $dbConfig = AppConfig::db();
        $this->user    = $dbConfig['user'];
        $this->pass    = $dbConfig['pass'];
        $this->host    = $dbConfig['host'];
        $this->dbname  = $dbConfig['dbname'];
        $this->type    = $dbConfig['type'];
        self::setOptions($dbConfig);
        self::setConfigConn();
        $this->conn = self::newConn();
    }

    private function setOptions(array $cfg)
    {
        $this->options = array(
            "CharacterSet" => $cfg['charset']
        );
    }

    private function setConfigConn()
    {
        switch($this->type)
        {
            case 'mysql' : 
                $this->dns = 'mysql:host='.$this->host.'; dbname='.$this->dbname;
                break;
            case 'sqlsrv': 
                $this->dns = 'sqlsrv:server='.$this->host.';Database='.$this->dbname;
                break;
            case 'sqlite3':
                $this->dns = 'sqlite:'.$this->dbname.'.sqlite3';
                break;
            default:
                break;
        }
    }

    /**
     * retorna una conexión a la base de datos
     *
     * @return PDO|null
     */
    public function newConn() : ?PDO
    {
        try
        {
            $conn = null;
            if($this->type == 'sqlite3')
            {
                $conn = new PDO($this->dns);
            }
            else
            {
                $conn = new PDO( $this->dns, $this->user, $this->pass, $this->options);
                $conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8); //sql server
                //$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            }
            return $conn;
        }
        catch(PDOException $ex)
        {
            $log = new Log();
            $log->setErrorQuery(__FILE__, 1, __LINE__, 10, $query = null, $ex);
            return null;
        }
    }
}

?>