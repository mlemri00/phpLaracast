<?php

namespace Http\controllers;


use Http\services\TokenService;
use Http\services\UsersService;

class UsersRestController
{

    private $service;
    private $tokenService;

    public function __construct()
    {
        $this->service = new UsersService();
        $this->tokenService = new TokenService();
    }

    public function register()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phone'];
        $username = $_POST['username'];


        $token = $this->service->storeUser($email, $password, $phoneNumber, $username);
        jsonResponse("token", $token->getKey());

    }

    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $token = $this->service->authenticateUser($email, $password);

        jsonResponse("token", $token->getKey());
    }

    public function deleteToken()
    {
        $this->tokenService->deleteToken($this->requestToken());

        redirect("/api/token");
    }

    public function getAllTokens()
    {

        $userId = $this->service->authorizeUser();
        $tokens = $this->tokenService->getAllTokensByUserId($userId);

        jsonResponse("tokens", $tokens);

    }


    public function deleteAllTokens()
    {
        $userId = $this->service->authorizeUser();
        $this->tokenService->deleteAllTokens($userId);
        jsonResponse("message", "All tokens we're deleted");
    }

    public function requestToken()
    {
        return str_replace('Bearer ', '', getallheaders()['Authorization']);
    }


}