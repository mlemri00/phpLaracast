<?php

namespace Http\services;

use core\Jwt;
use Http\dao\factory\TokenDaoFactory;

class TokenService
{
    private $repository;
    private $jwt;

    public function __construct()
    {
        $this->repository =  new TokenDaoFactory()::build();
        $this->jwt = new Jwt();
    }

    public function generateToken($id){
        $payload = [
            'id'=>$id
        ];
        $token = $this->jwt->encode($id);




    }


}