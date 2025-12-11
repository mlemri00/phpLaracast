<?php

namespace core\Middleware;

class Auth
{

    public function handle($apiRequest=false){
    if ($apiRequest) {
        $_SESSION['user']['id']=28;
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

}