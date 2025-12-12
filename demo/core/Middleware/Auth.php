<?php

namespace core\Middleware;

use Cassandra\Date;
use core\Jwt;
use DateTimeImmutable;
use Http\dao\JwtDao;

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
            $userId = $this->jwt->decode($matches[1])['id']['id'];
            $tokenId =$this->jwt->decode($matches[1])['tokenId'];

            $tokens = JwtDao::getAllTokens($userId);

            if ($tokens==null){
                http_response_code(403);
                echo json_encode(["message" => "Invalid token"]);
                die();
            }

            foreach ($tokens as $token){
                $dbTokenId = $this->jwt->decode($token['token'])['tokenId'];

                if ($tokenId==$dbTokenId){

                    $dateNow = date_create();
                    $tokenCreationDate = new DateTimeImmutable($token['created_at']);

                    $minutes = $tokenCreationDate->diff($dateNow)->i;

                    if ($minutes>=100){
                        http_response_code(403);
                        echo json_encode(["message" => "TokenExpired"]);
                        die();

                    }
                }else{
                    http_response_code(403);
                    echo json_encode(["message" => "Invalid token"]);
                    die();
                }


            }


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
        (new Auth)->authenticateJWTToken();

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
//eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImNyZWF0ZWRBdCI6eyJkYXRlIjoiMjAyNS0xMi0xMiAwODowMzoxMS43Mjg4OTYiLCJ0aW1lem9uZV90eXBlIjozLCJ0aW1lem9uZSI6IlVUQyJ9LCJyYW5kIjoyNTI0M30.eyJpZCI6eyJpZCI6MzF9fQ.R31n8PoiQsFaluYR9L6yKAmkFSxkC6nDMiNzD8oOpJ0
//Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6eyJpZCI6MzF9fQ._bpz0w8reZkau9PX4Mfcj5U0wTwAVPGMgyxfzEBEGaY.eyJpZCI6eyJpZCI6MzF9fQ.R31n8PoiQsFaluYR9L6yKAmkFSxkC6nDMiNzD8oOpJ0
}