<?php

namespace Http\services;

use core\Authenticator;
use core\Database;
use Core\HttpResponse;
use core\Jwt;
use core\Validator;
use Http\dao\dao\UsersDaoDb;
use Http\dao\factory\TokenDaoFactory;
use Http\dao\factory\UsersDaoFactory;
use Http\Forms\LoginForm;
use Http\models\Token;
use Http\models\User;

class UsersService
{


    private $userRepository;
    private $tokenService;

    public function __construct()
    {
        $this->userRepository = UsersDaoFactory::build();
        $this->tokenService = new TokenService();
    }

    public function storeUser($email, $password, $phone, $username)
    {
        $user = $this->findUserByEmail($email);

        if ($user->getId()) {
            jsonResponse("info", "User already exists");
        }

        $this->userRepository->registerUser($email, $password, $phone, $username);

        $userId = $this->findUserByEmail($email)->getId();

        $token = $this->tokenService->generateToken($userId);

        return $token;


    }
    public function findUserByEmail($email)
    {
        $user = $this->userRepository->findUserByEmail($email);
        return new User($user['id'],$user['email'],$user['password']);
    }

    public function findUserById($userId){
        $user = $this->userRepository->findUserById($userId);
        return new User($user['id'],$user['email'],$user['password']);
    }


    public function authenticateUser($email, $password)
    {

        if (!(new Authenticator)->attempt($email, $password, false)) {
            jsonResponse("error", "No account matches that user");
        }
        $id = $this->userRepository->getUserIdByEmail($email);
        $token = $this->tokenService->generateToken($id);

        return $token;


    }

    public function toToken($daoToken)
    {
        $token = Jwt::decode($daoToken);
        return new Token(
            $token['id'],
            $daoToken);
    }


    public function authorizeUser()
    {
        if (!array_key_exists('Authorization', getallheaders())) {
            jsonResponse("error", "unauthorized");
        }

        $providedToken = str_replace('Bearer ', '', getallheaders()['Authorization']);
        $tokens = $this->tokenService->getAllTokens();

        foreach ($tokens as $token ) {
            if ($token->getKey() == $providedToken) {
                return $this->findUserById($token->getUserId());
            }
        }

        abort(false, 404);
    }

}