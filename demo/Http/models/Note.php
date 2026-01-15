<?php

namespace Http\models;

class Note
{
public $id;
public $body;
public $user_id;


public function __construct($id,$body,$user_id)
{
    $this->user_id=$user_id;
    $this->body=$body;
    $this->id=$id;

}
    public function getBody()
    {
        return $this->body;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getUserId()
    {
        return $this->user_id;
    }

}