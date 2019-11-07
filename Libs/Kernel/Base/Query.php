<?php

namespace Kernel\Base;

use Kernel\base\DataBase;

class Query extends DataBase
{
    public function __get($propertyName)
    {
        if( property_exists(__CLASS__, $propertyName) )
            return $this->$propertyName;
        else
            return 'NO EXISTE LA PROPIEDAD >> '.$propertyName.' << ';
    }

    public static function testConnection() : bool
    {
        $database = new DataBase();
        if( ( $conn = $database::newConn()) != null )
            return true;
        else
            return false;
    }
    
}

?>