<?php

namespace Http\services;

use core\Authenticator;
use core\Database;
use core\Jwt;
use core\Validator;
use Http\dao\dao\UsersDaoDb;
use Http\dao\factory\TokenDaoFactory;
use Http\dao\factory\UsersDaoFactory;
use Http\Forms\LoginForm;

class UsersService
{


    private $userRepository;
    private $tokenRepository;
    private $jwt;

    public function __construct()
    {
        $this->userRepository = UsersDaoFactory::build();
        $this->tokenRepository = TokenDaoFactory::build();
        $this->jwt=new Jwt();
    }

    public function storeUser($email, $password,$phone,$username)
    {
        $errors = [];
        if (!Validator::email($email)) {
            $errors['email'] = 'Please provide a valid email address';

        }

        if (!Validator::string($password, 7, 255)) {
            $errors['password'] = 'Please provide a password of at least seven characters';
        }
        $user = $this->findUser($email);

        if (!empty($user)){
            $errors['user'] = 'User already exists please login';
        }

        if (!empty($errors)) {
            return $errors;
        }
        $this->userRepository->registerUser($email, $password,$phone,$username);

    }

    public function findUser($email){
        $user = $this->userRepository->findUserByEmail($email);
        return $user;
    }


    public function authenticateUser($email, $password)
    {
        $form = new LoginForm();

        if ($form->validate($email, $password)) {
            if ((new Authenticator)->attempt($email, $password)) {

                $id = $this->userRepository->getUserIdByEmail($email);

                $payload = [
                    "id" => $id,
                ];

                $token = $this->jwt->encode($payload);
                $payload = $this->jwt->decode($token);

                UsersDaoDb::storeToken($token, $id['id']);

                header('Content-Type: application/json');
                echo json_encode(["token" => $token,
                    "payload" => $payload]);
                die();

            } else {
                header('Content-Type: application/json');
                echo json_encode(["message" => "No account matches that user or password"]);
                die();
            }


        }

    }


}