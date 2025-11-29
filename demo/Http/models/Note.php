<?php

namespace Http\models;

class Note
{
private $id;
private $body;
private $user_id;


public function __construct($id,$body,$user_id)
{
    $this->user_id=$user_id;
    $this->body=$body;
    $this->id=$id;

}
    public function getBody() :string
    {
        return $this->body;
    }


    public function getId() : int
    {
        return $this->id;
    }


    public function getUserId() : int
    {
        return $this->user_id;
    }

}