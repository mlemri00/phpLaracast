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
        $this->repository =  TokenDaoFactory::build();
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

    public function getAllTokens(){
    $tokens =  $this->repository->getAllTokens();

    return array_map([$this,'toTokenFromDao'],$tokens);
    }
    public function toToken($daoToken){
        $token = Jwt::decode($daoToken);
        return new Token(
            $daoToken,$token['id']);
    }
    public function toTokenFromDao($daoToken){
        $token = Jwt::decode($daoToken['token']);
        return new Token(
            $daoToken['token'],$token['id']);
    }


    public function deleteToken($token){
        $this->repository->deleteToken();
    }

    public function deleteAllTokens($userId){

    }

}