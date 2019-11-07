<?php

namespace Kernel\Base;

class Log {

    protected const varFolder = __DIR__.'/../../../var';
    protected const logFolder = self::varFolder.'/logs';

    public static function __callStatic($name, $arguments) 
    {
        $type = null;
        $info =& $arguments[0];
        switch($name)
        {
            case 'errorQuery': 
                $type = 'query';
                if( isset($info['stm']) ){
                    $message = $info['stm']->errorInfo();
                    $info['message'] =& $message[2];
                    $info['query'] =& $info['stm']->{'queryString'};
                }
                $info['exception'] = ( isset($info['ex']) ) ? $arguments[0]['ex']->getMessage() : '';
                break;
            case 'errorRouter': 
                $type = 'router';
                $info['message'] = ( isset($info['msg']) ) ? str_replace('?', $info['class'], $info['msg']) : str_replace('?', $errorInfo['class'], 'Controller/Model No encontrado >> ? <<');
                $info['query'] = '';
                $info['exception'] = ( isset($info['ex']) ) ? $arguments[0]['ex']->getMessage() : '';
                break;
            case 'auth':
                $type = 'auth';
                $info['messafe'] = '';
                break;
            case 'errorClientJS': 
                return self::writeFileLogClient('js', $info);
                break;
            default: 
                echo("Error NO CAPTURADO: ($name, array)");
                print_r($arguments);
                break;
        }
        if( $type != null ){
            return self::writeFileLog($type, $info);
        }
    }

    private static function writeFileLog(string $typeLog, array $info)
    {
        $date = date("( Y/m/d H:i:s )");
        $msg = "Log $date:";
        $msg .= "\n\t File: ".$info['file'];
        $msg .= "\n\t Class: ".$info['class'];
        $msg .= "\n\t Line: ".$info['line'];
        $msg .= "\n\t Query: ".$info['query'];
        $msg .= "\n\t Message: ".$info['message'];
        $msg .= "\n\t Exception: ".$info['exception'];
        $msg .= "\n";
        switch ($typeLog) {
            case 'query':
                try {
                    $file = fopen(self::logFolder."/query.log", "a");
                    fwrite($file, $msg);
                    fclose($file);
                }catch(Exception $e){
                    self::createfolder( self::varFolder );
                    self::createfolder( self::logFolder );
                    self::writeFileLog( $typeLog, $info );
                }
                break;
            case 'router':
                try {
                    $file = fopen(self::logFolder."/router.log", "a");
                    fwrite($file, $msg);
                    fclose($file);
                }catch(Exception $e){
                    self::createfolder( self::varFolder );
                    self::createfolder( self::logFolder );
                    self::writeFileLog( $typeLog, $info );
                }
                break;
            default:
                # code...
                break;
        }
        self::newLog($date, $typeLog);
    }

    private static function writeFileLogClient(string $typeLog, array $info)
    {
        $date = date("( Y/m/d H:i:s )");
        $msg = "Log $date:";
        $msg .= "\n\t File: ".$info['file'];
        $msg .= "\n\t Line: ".$info['line'];
        $msg .= "\n\t Column: ".$info['column'];
        $msg .= "\n\t Message: ".$info['message'];
        $msg .= "\n\t Stack: ".$info['stack'];
        $msg .= "\n\t Client Date: ".$info['date'];
        $msg .= "\n\t Client Hour: ".$info['hour'];
        $msg .= "\n\t Client IP: ".$info['ip'];
        $msg .= "\n\t Client Country: ".$info['country'];
        $msg .= "\n\t Client Region: ".$info['region'];
        $msg .= "\n\t Client Latitude-Longitude: ".$info['latitude-longitude'];
        $msg .= "\n";
        switch ($typeLog) {
            case 'js':
                try {
                    $file = fopen(self::logFolder."/client_js.log", "a");
                    fwrite($file, $msg);
                    fclose($file);
                }catch(Exception $e){
                    self::createfolder( self::varFolder );
                    self::createfolder( self::logFolder );
                    self::writeFileLog( $typeLog, $info );
                }
                break;
            default:
                # code...
                break;
        }
        self::newLog($date, $typeLog);
    }

    private static function newLog($date, string $typeLog) : void
    {
        $msg = "$date Log on ".$typeLog."\n";

        try {
            $file = fopen(self::logFolder."/logs.log", "a") or die("Unable to open file!");
            fwrite($file, $msg);
            fclose($file);
        }catch(Exception $e){
            self::createfolder( self::varFolder );
            self::createfolder( self::logFolder );
            self::newLog( $date, $typeLog );
        }
    }

    private static function createfolder( string $folder ) : void
    {
        if( !is_dir( folder ) ){
            mkdir( $folder, 777 );
        }
    }

}

?>