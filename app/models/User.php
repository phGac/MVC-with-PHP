<?php

namespace App\Models;

use \PDO;
use App\Modules\Model;
use App\Modules\Log;
use App\Modules\Query;

class User extends Model
{
    private $idUser;
    private $userName;
    private $userPassword;
    private $firstName;
    private $lastName;
    private $userStatus;
    private $privileges;

    protected $tableName = 'users';
    protected $pk = 'idUser';

    public function __get($propertyName)
    {
        if( property_exists(__CLASS__, $propertyName) )
            return $this->$propertyName;
        else
            return 'NO EXISTE LA PROPIEDAD >> '.$propertyName.' << ';
    }

    function login($user, $password) : ?User
    {
        $query = new Query();
        $user = $query->login($user, $password);
        return $user;
    }

    public function register($user, $password) : bool
    {
        $query = new Query();
        if( $query->register($user, $password) )
            return true;
        else
            return false;
    }

    function logout() : bool
    {
        try{
            $session = unserialize(SESSION);
            $session->killSession();
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    function index($pag, $search) : array
    {
        $users = array();
        $limit = $this->maxPerPag; // maximo por pagina
        $offset = ( $limit * $pag + 1 );
        $limite = ( $limit * ( $pag + 1) );

        $where_search = '';
        $buscar = '';
        if ( $search != null ){
            $buscar = strtoupper(trim($search));
            $where_search = self::whereSearch($buscar);
        }

        $sql = "SELECT * FROM user ;";
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->execute();
        switch($query->rowCount()){
            case 0: 
                    if ( $query->errorCode() != 0 ){ 
                        $this->log = new Log();
                        $this->log->setErrorQuery(__FILE__, 1, __LINE__, 0, $query);
                    }
                    break;
            default: 
                    while( ( $user = ($query->fetchObject(__CLASS__)) ) != null ){
                        $users[] = $user;
                    }
                    break;
        }
        $query->closeCursor();
        $query = null;

        return $users;
    }

    public function new() : User
    {
        $user = new User();
        $user->idUser = 0;
        $user->userName = '';
        $user->userPassword = '';
        $user->firstName = '';
        $user->lastName = '';
        $user->userStatus = 0;
        $user->privileges = 0;
        return $user;
    }

    public function create( array $parameters ) : User
    {
        $user = new User();
        $user->idUser = 0;
        $user->userName = $parameters['username'];
        $user->userPassword = $parameters['password'];
        $user->userName = $parameters['firstname'];
        $user->lastName = $parameters['lastname'];
        $user->userStatus = 0;
        $user->privileges = 0;

        $tableName = $this->tableName;
        if($user->id == null || $user->id == ''){
            $maxId = self::getMaxId();
            $user->id = ($maxId+1);
        }
        $sql = 'INSERT INTO $tableName (id_user, user_name, user_password, first_name, last_name, user_status, privileges)'.
                            ' VALUES (:idUser, :userName, :userPassword, :firstName, :lastName, :userStatus, :privileges);';
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->bindParam(':idUser', $user->idUser);
        $query->bindParam(':userName', $user->userName);
        $query->bindParam(':userPassword', $user->userPassword);
        $query->bindParam(':firstName', $user->firstName);
        $query->bindParam(':lastName', $user->lastName);
        $query->bindParam(':userStatus', $user->userStatus);
        $query->bindParam(':privileges', $user->privileges);
        $query->execute();
        //validar errores
        return $user;
    }

    private function getMaxId()
    {
        $id = 0;
        $sql = "SELECT MAX(id_user) AS maxId FROM ".$this->tableName." ;";
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->execute();
        switch($query->rowCount()){
            case 0: 
                    if ( $query->errorCode() != 0 ){ 
                        $this->log = new Log();
                        $this->log->setErrorQuery(__FILE__, 1, __LINE__, 0, $query);
                    }
                    break;
            default: 
                    $row = ($query->fetch());
                    $id = (int) ($row['maxId']);
                    break;
        }
        $query->closeCursor();
        $query = null;
        return $id;
    }

    function show($id) : ?Grupo
    {
        $grupo = null;
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE id_user = :id ;';
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        switch($query->rowCount()){
            case 0: break;
            case 1: 
                    $grupo = ($query->fetchObject(__CLASS__));
                    break;
        }
        return $grupo;
    }

    function searchByUserName(string $userName) : ?User
    {
        $user = null;
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE userName = :userName ;';
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->bindParam(':userName', $userName);
        $query->execute();
        switch($query->rowCount()){
            case 0: break;
            case 1: 
                    $user = ($query->fetchObject(__CLASS__));
                    break;
        }
        return $user;
    }

    function searchByName(string $name) : ?Grupo
    {
        $grupo = null;
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE firstName = :name OR lastName = :name2 ;';
        $query = $this->conn->prepare($sql, $this->attrs);
        $query->bindParam(':name', $name);
        $query->bindPAram(':name2', $name);
        $query->execute();
        switch($query->rowCount()){
            case 0: break;
            case 1: 
                    $grupo = ($query->fetchObject(__CLASS__));
                    break;
        }
        return $grupo;
    }

    public function all()
    {
        $query = new Query();
        $results = $query->all(__CLASS__, $this->tableName);
        if($results != null)
            print_r($results);
        else
            echo 'no pe';
    }

}

?>