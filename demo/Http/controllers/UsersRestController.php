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
use Http\services\UsersService;

class UsersRestController
{

    private $service;

    public function __construct()
    {
        $this->service = new UsersService();
    }

    public function register()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phone'];
        $username = $_POST['username'];


        $token = $this->service->storeUser($email, $password, $phoneNumber, $username);
        jsonResponse("token", $token);

    }

    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $token = $this->service->authenticateUser($email, $password);

        jsonResponse("token",$token);
    }

    public function deleteToken()
    {
        $userId = Auth::getUserIdFromJwt();


        $tokenId = $_POST['id'] ?? $_GET['id'];

        $token = UsersDaoDb::getToken($tokenId);

        $tokenUserId = $this->jwt->decode($token['token'])['id']['id'];
        if ($userId != $tokenUserId) {
            abort(true, 403);
        }
        UsersDaoDb::deleteToken($tokenId);
        header('Content-Type: application/json');
        echo json_encode(["message" => "Token deleted"]);
        die();
    }

    public function deleteAllTokens()
    {
        $userId = Auth::getUserIdFromJwt();

        UsersDaoDb::deleteAllTokens($userId);

        header('Content-Type: application/json');
        echo json_encode(["message" => "Tokens deleted"]);
        die();
    }




}