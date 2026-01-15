<?php

namespace Http\dao\dao;

use App;
use core\Database;
use Http\dao\interfaces\ITokenDao;

class TokenDaoDb implements ITokenDao
{
    public  function storeToken($token, $userId){
        $db=App::resolve(Database::class);

        $db->query(
            'INSERT INTO token (token, user_id)
                VALUES (:token,:user_id)',
            [
                'token' => $token,
                'user_id' => $userId
            ]);
    }

    public function getAllTokens(){
        $db=App::resolve(Database::class);
        $tokens =$db->query("select * from token")->get();
        return $tokens;
    }
    public function getAllTokensByUserId($userId){
        $db=App::resolve(Database::class);

        $tokens =$db->query("select * from token where user_id = :user_id",[
            'user_id'=>$userId
        ])->get();
        return $tokens;
    }
    public  function getLastId(){
        $db=App::resolve(Database::class);
        $lastId =$db->query("select id from token order by id desc limit 1")->get();
        return $lastId;
    }


    public  function deleteToken($token)
    {

        $db=App::resolve(Database::class);

        $db->query('delete from token where token = :token',[
            'token'=>$token
        ]);

    }
    public  function deleteAllTokens($userId){
        $db=App::resolve(Database::class);

        $db->query('delete from token where user_id = :id',[
            'id'=>$userId
        ]);
    }

    public  function getToken($tokenId){
        $db=App::resolve(Database::class);
        $token = $db->query('select * from token where id = :id', [
            'id' => $tokenId
        ])->findOrFail(true);
        return $token;
    }





}