<?php

namespace Http\controllers;

use App;
use core\Authenticator;
use core\Database;
use core\Jwt;
use core\Middleware\Auth;
use core\Validator;
use Http\dao\dao\UsersDaoDb;
use Http\Forms\LoginForm;

class UsersRestController{
    private $jwt;
    public function __construct(){
        $this->jwt=new Jwt();
    }

    public function register(){

        $email = $_POST['email'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phone'];
        $username = $_POST['username'];


        if (! empty($errors)){
            header('Content-Type: application/json');
            echo json_encode(["message"=>$errors]);
            die();
        }



        if($user){
            header('Content-Type: application/json');
            echo json_encode(["message"=>"User exists"]);
            die();
        }else{
            $db->query('insert into users(email,password,phone,username) values (:email, :password, :phone,:username)',[
                'email'=>$email,
                'password'=>password_hash($password,PASSWORD_BCRYPT),
                'phone'=>$phoneNumber,
                'username'=>$username
            ]);
            $id = $db->query('select id from users where email = :email',
                ['email'=>$email])->find();
            $payload = [
                "id" => $id
            ];

            $token =  $this->jwt->encode($payload);

            UsersDaoDb::storeToken($token,$id['id']);

            header('Content-Type: application/json');
            echo json_encode(["token"=>$token]);
            die();
        }

    }
    public function authenticate(){
        $db = App::resolve(Database::class);
        $email = $_POST['email'];
        $password = $_POST['password'];

        $form = new LoginForm();


        if ($form->validate($email,$password)){

            if((new Authenticator)->attempt($email, $password)){

                $id = $db->query('select id from users where email = :email',
                    ['email'=>$email])->find();

                $lastTokenId =UsersDaoDb::getLastId()[0]['id'];

                $payload = [
                    "id" => $id,
                    "tokenId"=>$lastTokenId+1
                ];

                $token =  $this->jwt->encode($payload);
                $payload = $this->jwt->decode($token);

                UsersDaoDb::storeToken($token,$id['id']);

                header('Content-Type: application/json');
                echo json_encode(["token"=>$token,
                    "payload"=>$payload]);
                die();

            }else {
                header('Content-Type: application/json');
                echo json_encode(["message"=>"No account matches that user or password"]);
                die();
            }




        }

    }
    public function deleteToken(){
        $userId = Auth::getUserIdFromJwt();



        $tokenId = $_POST['id'] ?? $_GET['id'];

        $token = UsersDaoDb::getToken($tokenId);

        $tokenUserId = $this->jwt->decode($token['token'])['id']['id'];
        if ($userId!=$tokenUserId) {
            abort(true,403);
        }
        UsersDaoDb::deleteToken($tokenId);
        header('Content-Type: application/json');
        echo json_encode(["message"=>"Token deleted"]);
        die();
    }
    public function deleteAllTokens(){
        $userId = Auth::getUserIdFromJwt();

        UsersDaoDb::deleteAllTokens($userId);

        header('Content-Type: application/json');
        echo json_encode(["message"=>"Tokens deleted"]);
        die();
    }

}