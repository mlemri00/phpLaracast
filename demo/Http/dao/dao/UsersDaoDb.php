<?php

namespace Http\dao\dao;

use App;
use core\Database;
use Http\dao\interfaces\IUsersDao;

class UsersDaoDb implements IUsersDao
{


    public function findUserByEmail($email){
        $db=App::resolve(Database::class);
        $user= $db->query('select * from users where email = :email',[
            'email'=>$email
        ])->find();
        return $user;
    }
    public function findUserById($userId){
        $db=App::resolve(Database::class);
        $user= $db->query('select * from users where id = :id',[
            'id'=>$userId
        ])->find();
        return $user;
    }

    public function registerUser($email,$password,$phone = null, $username = null){
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
        return $id['id'];
    }







}