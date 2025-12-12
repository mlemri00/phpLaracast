<?php

namespace Http\controllers\classes;

use App;
use core\Authenticator;
use core\Database;
use core\Jwt;
use core\Validator;
use Http\dao\JwtDao;
use Http\Forms\LoginForm;

class JwtController{
    private $jwt;
    public function __construct(){
        $this->jwt=new Jwt();
    }

    public function register(){

        $email = $_POST['email'];
        $password = $_POST['password'];
        $db = App::resolve(Database::class);

        if (!Validator::email($email)){
            $errors['email']='Please provide a valid email address';

        }

        if (!Validator::string($password,7,255)){
            $errors['password']='Please provide a password of at least seven characters';
        }


        if (! empty($errors)){
            header('Content-Type: application/json');
            echo json_encode(["message"=>$errors]);
            die();
        }



        $user= $db->query('select * from users where email = :email',[
            'email'=>$email
        ])->find();

        if($user){
            header('Content-Type: application/json');
            echo json_encode(["message"=>"User exists"]);
            die();
        }else{
            $db->query('insert into users(email,password) values (:email, :password)',[
                'email'=>$email,
                'password'=>password_hash($password,PASSWORD_BCRYPT)
            ]);
            $id = $db->query('select id from users where email = :email',
                ['email'=>$email])->find();

            $lastTokenId =JwtDao::getLastId()[0]['id'];
            $payload = [
                "id" => $id,
                "tokenId"=>$lastTokenId+1
            ];

            $token =  $this->jwt->encode($payload);

            JwtDao::storeToken($token,$id['id']);

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

                $lastTokenId =JwtDao::getLastId()[0]['id'];

                $payload = [
                    "id" => $id,
                    "tokenId"=>$lastTokenId+1
                ];

                $token =  $this->jwt->encode($payload);
                $payload = $this->jwt->decode($token);

                JwtDao::storeToken($token,$id['id']);

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
}