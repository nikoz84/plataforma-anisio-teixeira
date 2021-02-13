<?php

namespace App;

use DateTime;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Date;
use phpDocumentor\Reflection\Types\Integer;

class LogArtisan implements Jsonable{
    protected DateTime $dateTime;
    protected String   $message;
    protected String   $stackError;
    protected int  $id;

    function toJson($options = 0)
    {
        $json = '{"dateTime":"'.$this->dateTime->format('Y-m-d H:i:s').'","id":"'.$this->id.'","message":"'.str_replace('"', '\"',str_replace("\n", "",$this->message)).'","stackError":"'.str_replace('"', '\"',str_replace("\n", "",$this->stackError)).'"}';
        return $json;
    }

    function __toString()
    {
        return $this->toJson();
    }

    function getDateTime()
    {
        return $this->dateTime;
    }

    function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    function getMessage()
    {
        return $this->message;
    }

    function setMessage($message)
    {
        $this->message = $message;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function getStackError()
    {
        return $this->stackError;
    }

    function setStackError($stackError)
    {
        $this->stackError = $stackError;
    }

    function getName()
    {
        return $this->getDateTime()->format("yyyy-mm-dd H:i:s");
    }
}