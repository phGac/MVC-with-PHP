<?php

namespace App\Modules;

use App\Modules\DataBase;
use App\Modules\AppConfig;
use stdClass;

class Query extends DataBase
{
    private $attrs = array(
        \PDO::ATTR_CURSOR => \PDO::CURSOR_SCROLL,
        \PDO::SQLSRV_ATTR_ENCODING => \PDO::SQLSRV_ENCODING_UTF8
    );

    public function setAttributes(array $attrs)
    {
        $this->attrs = $attrs;
    }

    private function getResults($query, $class)
    {
        switch($query->rowCount())
        {
            case 0: 
                return null;
                break;
            default: 
                return $query->fetchObject($class);
                break;
        }
    }

    public function testConnection() : bool
    {
        if( ( $conn = self::newConn()) != null )
            return true;
        else
            return false;
    }

    public function query(stdClass $class, string $tableName, string $sqlQuery, array $paramsValue = null, array $paramsType = array('s'))
    {
        $sql = $sqlQuery;
    }

    public function searchBy_($class, string $tableName, string $columnName, string $value)
    {
        $sql = 'SELECT * FROM '.$tableName.' WHERE '.$columnName.' = :value ;';
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->bindParam(':value', $value);
        $query->execute();
        return $this->getResults($query, $class);
    }

    public function all($class, string $tableName)
    {
        $sql = 'SELECT * FROM '.$tableName.';';
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->execute();
        return self::getResults($query, $class);
    }

    private static function loginConfig()
    {
        return AppConfig::login();
    }

    public function login(string $user, string $password)
    {
        $cfg = self::loginConfig();
        $tableName = $cfg['table'];
        $userColumn = $cfg['user-column'];
        $passColumn = $cfg['password-column'];
        $class = $cfg['class'];

        $sql = 'SELECT * FROM '.$tableName.' WHERE '.$userColumn.' = :user ;';
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->bindParam(':user', $user);
        $query->execute();
        if( ($user = self::getResults($query, $class)) != null ){
            $passDB = $user->$passColumn;
            if(self::validatePassword($password, $passDB))
                return $user;
            else
                return false;
        }else{
            return null;
        }
        
    }

    public function register(string $username, string $password) : bool
    {
        $cfg = self::loginConfig();
        $tableName = $cfg['table'];
        $userColumn = $cfg['user-column'];
        $passColumn = $cfg['password-column'];
        $class = $cfg['class'];

        $user = $this->searchBy_($class, $tableName, $userColumn, $username);
        if( !($user != null) ){
            $encryptedPass = $this->hashPassword($password);
            $sql = 'INSERT INTO '.$tableName.' ('.$userColumn.', '.$passColumn.') VALUES (:user, :pass);';
            $query = $this->conn->prepare($sql, $this->attrs);
            $query->bindParam(':user', $username);
            $query->bindParam(':pass', $encryptedPass);
            $query->execute();
            if( ($this->getResults($query, $class)) != null)
                return true;
            else
                return false;
        }else{
            return false;
        }
    }

    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    private function validatePassword($password, $passDB)
    {
        return password_verify($password, $passDB);
    }
}

?>