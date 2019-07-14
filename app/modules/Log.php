<?php

namespace App\Modules;

use \PDOStatement;
use \PDOException;

class Log {

    private $typeLog;
    private $message;
    private $assessment;
    private $position;
    private $line;
    private $fileName;
    private $exception;

    function __construct()
    {
        $this->message = '';
        $this->assessment = 0;
        $this->position = 0;
        $this->line = 0;
        $this->fileName = '';
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function getAssessment() : int
    {
        return $this->assessment;
    }

    public function getPosition() : int
    {
        return $this->position;
    }

    public function getLine() : int
    {
        return $this->line;
    }

    public function getFileName() : string
    {
        return $this->fileName;
    }

    public function getErrorInfo() : array
    {
        return array(
            'FileName' => $this->fileName,
            'Line' => $this->line,
            'Position' => $this->position,
            'Assessment' => $this->assessment,
            'Message' => $this->message
        );
    }

    private function writeFileLog()
    {
        $date = date("( Y/m/d H:i:s )");
        switch ($this->typeLog) {
            case 'query':
                $msg = "Log $date:";
                $msg .= "\n\t File: ".$this->fileName;
                $msg .= "\n\t Line: ".$this->line;
                $msg .= "\n\t Position: ".$this->position;
                $msg .= "\n\t Assessment: ".$this->assessment;
                $msg .= "\n\t Message: ".$this->message;
                $msg .= "\n\t Exception: ".$this->exception;
                $msg .= "\n";

                try {
                    $file = fopen(__DIR__."/../../logs/query.log", "a") or die("Unable to open file!");
                    fwrite($file, $msg);
                    fclose($file);
                }catch(Exception $e){}
                break;
            
            default:
                # code...
                break;
        }
        self::newLog($date);
    }

    private function newLog($date) : void
    {
        $msg = "$date Log on ".$this->typeLog."\n";

        try {
            $file = fopen(__DIR__."/../../logs/log.log", "a") or die("Unable to open file!");
            fwrite($file, $msg);
            fclose($file);
        }catch(Exception $e){}
    }

    public function setErrorQuery( string $fileName, int $position, int $line, $assessment = 0, PDOStatement $query = null, PDOException $ex = null)
    {
        $this->typeLog = 'query';
        $this->fileName = $fileName;
        $this->position = $position;
        $this->line = $line;
        $this->assessment = $assessment;
        if($query != null){
            $errorInfo = $query->errorInfo(); //implode("|", $query->errorInfo());
            $this->message = $errorInfo[2];
        }
        if($ex != null)
            $this->exception = $ex->getMessage();
        self::writeFileLog();
    }

}

?>