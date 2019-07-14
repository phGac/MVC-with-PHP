<?php

namespace App\Modules;

abstract class AppConfig
{
    private const folder = __DIR__.'/../../config/app.json';
    public $db;
    public $session;
    public $login;

    private static function setShemaConfig()
    {
        $file = file_get_contents( self::folder, true);
        $json = json_decode($file, true);
        $shemaConfig = $json[0];
        return $shemaConfig;
    }

    public static function __callStatic($propertyName, $arguments)
    {
        if( property_exists(__CLASS__, $propertyName) ){
            $shemaConfig = self::setShemaConfig();
            return $shemaConfig[$propertyName];
        }
        else
            return 'NO EXISTE LA PROPIEDAD >> '.$propertyName.' << ';
    }
}

?>