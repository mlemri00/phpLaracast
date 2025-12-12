<?php

namespace Http\dao;

use App;
use core\Database;

class JwtDao
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

    public static function getAllToken($userId){
        $db=App::resolve(Database::class);
        $tokens =$db->query("select * from token where user_id = :user_id",[
            'user_id'=>$userId
        ])->get();
        return $tokens;
    }

}