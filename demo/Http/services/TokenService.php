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

    public function generateToken($userId){
        $payload = [
            'id'=>$$userId
        ];
        $token = $this->jwt->encode($payload);

        $this->repository->storeToken($token,$userId);

        return $token;
    }

    public function storeToken(){

    }
    public function getAllTokens(){

    }
    public function deleteToken(){

    }

    public function deleteAllTokens(){

    }

}