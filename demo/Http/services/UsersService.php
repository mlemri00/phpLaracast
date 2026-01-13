<?php

namespace Http\services;

use core\Authenticator;
use core\Database;
use core\Validator;
use Http\dao\dao\UsersDaoDb;
use Http\dao\factory\UsersDaoFactory;
use Http\Forms\LoginForm;

class UsersService
{


    private $repository;

    public function __construct()
    {
        $this->repository = UsersDaoFactory::build();
    }

    public function storeUser($email, $password)
    {
        $errors = [];
        if (!Validator::email($email)) {
            $errors['email'] = 'Please provide a valid email address';

        }

        if (!Validator::string($password, 7, 255)) {
            $errors['password'] = 'Please provide a password of at least seven characters';
        }


        if (!empty($errors)) {
            return $errors;
        }
        $this->repository->registerUser($email, $password);

    }

    public function findUser($email){

    }


    public function authenticateUser($email, $password)
    {
        $db = App::resolve(Database::class);
        $email = $_POST['email'];
        $password = $_POST['password'];

        $form = new LoginForm();


        if ($form->validate($email, $password)) {
            if ((new Authenticator)->attempt($email, $password)) {

                $id = $db->query('select id from users where email = :email',
                    ['email' => $email])->find();

                $lastTokenId = UsersDaoDb::getLastId()[0]['id'];

                $payload = [
                    "id" => $id,
                    "tokenId" => $lastTokenId + 1
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