<?php

#http://www.geoplugin.net/php.gp?ip=

#echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));

namespace Kernel\Client;

use Kernel\plugin\geoPlugin;

class ClientInfo {

    private $geoplugin;

    public function __construct($ip = null)
    {
        $this->geoplugin = new geoPlugin($ip);
    }

    public function __get($propertyName)
    {
        switch($propertyName){
            case 'ip': return $this->geoplugin->ip; break;
            case 'country': return array( 'name' => $this->geoplugin->countryName, 'code' => $this->countryCode ); break;
            case 'timezone': return $this->geoplugin->timezone; break;
            case 'location': return array( 'country' => $this->geoplugin->countryName, 'region' => $this->geoplugin->regionName, 'latitude' => $this->geoplugin->latitude, 'longitude' => $this->geoplugin->longitude ); break;
        }
        if( property_exists(__CLASS__, $propertyName) )
            return $this->$propertyName;
        else
            return 'NO EXISTE LA PROPIEDAD >> '.$propertyName.' << ';
    }

}




?>