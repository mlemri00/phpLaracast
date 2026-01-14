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

class UsersService
{


    private $userRepository;
    use Core\HttpResponse;

    private $tokenService;

    public function __construct()
    {
        $this->userRepository = UsersDaoFactory::build();
        $this->tokenService = new TokenService();
    }

    public function storeUser($email, $password, $phone, $username)
    {
        $form = new LoginForm();
        if ($form->validate($email, $password)) {
            $user = $this->findUser($email);

            if (!empty($user)) {
                jsonResponse("info", "User already exists");
            }

            $this->userRepository->registerUser($email, $password, $phone, $username);

            $userId = $this->userRepository->findUserByEmail($email);

            $token = $this->tokenService->generateToken($userId);

            return $token;
        } else {
            jsonResponse("error", $form->validate($email, $password));

        }


    }

    public function findUser($email)
    {
        $user = $this->userRepository->findUserByEmail($email);
        return $user;
    }


    public function authenticateUser($email, $password)
    {

        if (!(new Authenticator)->attempt($email, $password, false)) {
            jsonResponse("error","No account matches that user");
        }
            $id = $this->userRepository->getUserIdByEmail($email);
            $token = $this->tokenService->generateToken($id);

            return $token;




    }

    public function authorizeUser($userId)
    {
        if (!array_key_exists('Authorization', getallheaders())) {
            jsonResponse("error","unauthorized");
        }

        $token = str_replace('Bearer ', '', getallheaders()['Authorization']);
        $tokens = $this->tokenService->getAllTokens($userId);

        foreach ($tokens as $t) {
            if ($t->getValue() == $token) {
                return $this->userService->get($t->getSub())->getId();
            }
        }

        abort(false, 404);
    }

}