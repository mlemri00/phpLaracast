<?php

namespace Http\services;

use core\Jwt;
use Http\dao\factory\TokenDaoFactory;
use Http\models\Token;

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
            'id'=>$userId
        ];
        $token = $this->jwt->encode($payload);

        $this->repository->storeToken($token,$userId);

        return $this->toToken($token);
    }

    public function getAllTokens($userId){
    $tokens =  $this->repository->getAllTokens($userId);

    return array_map([$this,'toToken'],$tokens);
    }
    public function toToken($daoToken){
        $token = Jwt::decode($daoToken);
        return new Token(
            $token['id'],
            $daoToken);
    }


    public function deleteToken($token){
        $this->repository->deleteToken();
    }

    public function deleteAllTokens($userId){

    }

}