<?php

namespace Http\models;

class User

{
    private $email;
    private $id;
    private $password;

    public function __construct($id, $email, $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }


}