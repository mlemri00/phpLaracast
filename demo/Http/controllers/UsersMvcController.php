<?php

namespace Http\controllers;

use core\Validator;
use Http\dao\dao\UsersDaoDb;
use Http\dao\factory\UsersDaoFactory;

class UsersMvcController
{

    private $repository;

    public function __construct()
    {
        $this->repository= UsersDaoFactory::build();
    }

    public function create(){
        view('registration/create.view.php',[]);
    }

    public function store($email,$password){
        $errors = [];
        if (!Validator::email($email)){
            $errors['email']='Please provide a valid email address';

        }

        if (!Validator::string($password,7,255)){
            $errors['password']='Please provide a password of at least seven characters';
        }


        if (! empty($errors)){
            return $errors;
        }
        $this->repository->registerUser($email,$password);

    }


}