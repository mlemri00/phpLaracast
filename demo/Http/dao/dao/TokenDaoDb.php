<?php

namespace Http\dao\dao;

use core\Database;

class TokenDaoDb
{
    public static function storeToken($token, $userId){
        $db=App::resolve(Database::class);

        $db->query(
            'INSERT INTO token (token, user_id)
                VALUES (:token,:user_id)',
            [
                'token' => $token,
                'user_id' => $userId
            ]);
    }

    public static function getAllTokens($userId){
        $db=App::resolve(Database::class);
        $tokens =$db->query("select * from token where user_id = :user_id",[
            'user_id'=>$userId
        ])->get();
        return $tokens;
    }





}