<?php

namespace Http\dao\dao;

use App;
use core\Database;
use Http\dao\interfaces\IUsersDao;

class UsersDaoDb implements IUsersDao
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

    public static function getLastId(){
        $db=App::resolve(Database::class);
        $lastId =$db->query("select id from token order by id desc limit 1")->get();
        return $lastId;
    }

    public static function deleteToken($tokenId)
    {

        $db=App::resolve(Database::class);

        $db->query('delete from token where id = :id',[
            'id'=>$tokenId
        ]);

    }
    public static function deleteAllTokens($userId){
        $db=App::resolve(Database::class);

        $db->query('delete from token where user_id = :id',[
            'id'=>$userId
        ]);
    }

    public static function getToken($tokenId){
        $db=App::resolve(Database::class);
        $token = $db->query('select * from token where id = :id', [
            'id' => $tokenId
        ])->findOrFail(true);
        return $token;
    }

    public function findUserByEmail($email){
        $db=App::resolve(Database::class);
        $user= $db->query('select * from users where email = :email',[
            'email'=>$email
        ])->find();
        return $user;
    }

    public function registerUser($email,$password,$phone, $username){
        $db=App::resolve(Database::class);
        $db->query('insert into users(email,password,phone,username) values (:email, :password, :phone,:username)',[
            'email'=>$email,
            'password'=>password_hash($password,PASSWORD_BCRYPT),
            'phone'=>$phone,
            'username'=>$username
        ]);
    }

    public function getUserIdByEmail($email){
        $db=App::resolve(Database::class);
        $id = $db->query('select id from users where email = :email',
            ['email'=>$email])->find();
        return $id;
    }







}