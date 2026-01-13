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
    private $tokenService;

    public function __construct()
    {
        $this->userRepository = UsersDaoFactory::build();
        $this->tokenService = new TokenService();
    }

    public function storeUser($email, $password,$phone,$username)
    {
        $errors = [];
        $form = new LoginForm();
        if (!$form->validate($email,$password)) {
            $user = $this->findUser($email);

            if (!empty($user)) {
                $errors['user'] = 'User already exists please login';
            }

            if (!empty($errors)) {
                return $errors;
            }
            $this->userRepository->registerUser($email, $password, $phone, $username);
        }
    }

    public function findUser($email){
        $user = $this->userRepository->findUserByEmail($email);
        return $user;
    }


    public function authenticateUser($email, $password)
    {
        $errors = [];

        $form = new LoginForm();
        if ($form->validate($email, $password)) {
            if ((new Authenticator)->attempt($email, $password,false)) {

                $id = $this->userRepository->getUserIdByEmail($email);
                $token = $this->tokenService->generateToken($id);

                return $token;

            } else{
                $errors['error'] = "No account matches that user or password";
                return $errors;
            }


        }

    }


}