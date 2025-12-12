<?php

namespace Http\dao;

use core\Database;

class JwtDao
{

    public function storeToken($token, $userId){
        $db=App::resolve(Database::class);
        $db->query(
            'INSERT INTO token (token, user_id)
                VALUES (:token,:user_id)',
            [
                'token' => $token,
                'user_id' => $userId
            ]);
    }


}