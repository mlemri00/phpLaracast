<?php

namespace core\Middleware;

use core\Jwt;

class Auth
{
    private $jwt;
    public function __construct()
    {
        $this->jwt=new Jwt();
    }

    public function handle($apiRequest=false){
    if ($apiRequest) {

        $this->authenticateJWTToken();
        /*
        header('Content-Type: application/json');
        echo json_encode(["message"=>"Not authenticated"]);
        die();
        */
    }else{
        if (!$_SESSION['user'] ?? false) {
            header('location: /');
            exit();
        }
    }
    }
    public function authenticateJWTToken()
    {

        if (!preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header"]);
            return false;
        }

        try {
            $data = $this->jwt->decode($matches[1])['id']['id'];

        } catch (InvalidSignatureException) {

            http_response_code(401);
            echo json_encode(["message" => "invalid signature"]);
            return false;
        } catch (Exception $e) {

            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }



        return true;
    }

    public static function getUserIdFromJwt(){
        $jwt = new Jwt();
        if (!preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header"]);
            return false;
        }

        try {
            $data = $jwt->decode($matches[1])['id']['id'];
            return $data;
        } catch (InvalidSignatureException) {

            http_response_code(401);
            echo json_encode(["message" => "invalid signature"]);
            return false;
        }
    }

}