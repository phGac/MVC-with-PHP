<?php

namespace Kernel\Base;

use \PDO;
use \PDOException;
use Kernel\base\Log;

class DataBase
{
    private static function setConfigConn(string $type, string $host = null, string $dbname = null)
    {
        switch($type)
        {
            case 'mysql' : 
                return 'mysql:host='.$host.'; dbname='.$dbname;
                break;
            case 'sqlsrv': 
                return 'sqlsrv:server='.$host.';Database='.$dbname;
                break;
            case 'sqlite3':
                return 'sqlite:'.$dbname.'.sqlite3';
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * retorna una conexión a la base de datos
     *
     * @return PDO|null
     */
    public static function newConn() : ?PDO
    {
        try
        {
            $user    = $_ENV['db']['user']      ?? 'sa';
            $pass    = $_ENV['db']['pass']      ?? 'bimmer';
            $host    = $_ENV['db']['host']      ?? '127.0.0.1';
            $dbname  = $_ENV['db']['dbname']    ?? 'PANKI_TS_OPERTERRA';
            $type    = $_ENV['db']['type']      ?? 'sqlsrv';
            $charset = $_ENV['db']['charset']   ?? 'UTF-8';
            $options = array(
                "CharacterSet" => $charset
            );
            $dns = self::setConfigConn($type, $host, $dbname);

            $conn = null;
            if($type == 'sqlite3')
            {
                $conn = new PDO($dns);
            }
            else
            {
                $conn = new PDO( $dns, $user, $pass, $options);
                $conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8); //sql server
                //$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
            }
            return $conn;
        }
        catch(PDOException $ex)
        {
            Log::errorQuery([ 'line' => __LINE__, 'file' => __FILE__, 'class' => __CLASS__, 'ex' => $ex, 'query' => '', 'message' => '' ]);
            return null;
        }
    }
}

?>