<?php

namespace App\Helpers;

use App\LogArtisan;
use DateTime;

class LogArtsanFileReader{
    private String $fileArtsanLocation = "../storage/logs/laravel.log";
    private String $dateExp = "/^\\[[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])(\s)*(([0-9]{2}|0[1-9]|[1-9]):([0-5][0-9]):([0-5][0-9]))\\]/i";
    private String $stackLineExp = "/^(#([0-9])+)/i";
    private $logArtisanObjects = array();
    private $resourceFile ;

    function __construct()
    {
        $this->resourceFile = fopen($this->fileArtsanLocation, "r");
    }

    function readLogFile($qtd, $beginAt, $searchTerm = "")
    {
        $count = 0;
        $stackError = "";
        $date = null;
        $strdate = "";
        while(! feof($this->resourceFile) && $qtd>0)
        {
            $line = fgets($this->resourceFile);
            $init = $this->initReg($line);
            if(trim($init))
            {
                if($count>=1 && $count >= $beginAt)
                {
                    $message = str_replace( $init, "", $line  );
                    if(!$searchTerm || (
                        strstr( $message , $searchTerm) 
                        || strstr($stackError,$searchTerm) 
                        ||  strstr($strdate,$searchTerm) 
                    ))
                    {
                        $this->logArtisanObjects[] = $this->createLogArtisanObject($date, $message, $stackError, $count);
                        $stackError = "";
                        $qtd--;
                    }
                }
                $strdate = substr($init, 1, strlen($init)-2);
                $date = new DateTime( $strdate);
                $count++;
            }
            if($this->checkStackErrorMessage($line))
            $stackError .= str_replace($init, "", $line);
        }
        fclose($this->resourceFile);
    }

    function getById($id)
    {
        $count = 0;
        $stackError = "";
        $date = null;
        $strdate = "";
        while(! feof($this->resourceFile))
        {
            $line = fgets($this->resourceFile);
            $init = $this->initReg($line);
            if(trim($init))
            {
                $message = str_replace( $init, "", $line  );
                if($count>=1 && $count==$id)
                {
                    return $this->createLogArtisanObject($date, $message, $stackError, $count);
                }
                $count++;
            }
            $strdate = substr($init, 1, strlen($init)-2);
            $date = new DateTime( $strdate);
        }
        return null;
    }

    function checkStackErrorMessage($line)
    {
        return preg_match($this->stackLineExp, $line);
    }

    function initReg($line)
    {
        $lineWithoutDate = preg_replace($this->dateExp, "", $line);
        $date = str_replace($lineWithoutDate, "", $line);
        return $date;
    }

    private function createLogArtisanObject($date, $message, $errorStackMessage, $cod)
    {
        $logArtisan = new LogArtisan();
        $logArtisan->setId($cod);
        $logArtisan->setStackError($errorStackMessage);
        $logArtisan->setDateTime($date);
        $logArtisan->setMessage($message);
        return $logArtisan;
    }

    function getLogArtisanObjects()
    {
        return $this->logArtisanObjects;
    }

    function toJson()
    {
        $json = "";
        foreach($this->logArtisanObjects as $log)
        {
            if($json)
            $json .=",";
            $json .= $log->toJson();
        }
        $json = "[".$json."]";
        return $json;
    }

    function total()
    {
        $count = 0;
        $no_of_lines = count(file($this->fileArtsanLocation));
        if(sizeof($this->logArtisanObjects))
        {

        }
        return round($no_of_lines/24);
    }
}