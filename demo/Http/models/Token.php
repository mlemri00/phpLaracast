<?php

namespace Http\models;

class Token
{
    private $key;
    private $userId;

    public function __construct($key, $userId)
    {
        $this->key=$key;
        $this->userId=$userId;
    }


    public function getKey(){
        return $this->key;
}

    public function getUserId(){
        return $this->userId;
    }

    public function __toString(): string
    {

        return "Token : ".$this->getKey();

    }

}