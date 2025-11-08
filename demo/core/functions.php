<?php

use core\Response;

function dd($value){
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value){
    return $_SERVER['REQUEST_URI'] === $value;
}

function authorize($condition,$status=Response::FORBIDDEN){
    if (!$condition){
        abort($status);
    }


}
function abort($code = 404 ){// això és per fer un paràmetre de sèrie si no es passa ni un
    http_response_code($code);
    require base_path("views/{$code}.php");

    die();
}
function base_path($path){
    return BASE_PATH . $path;
}

function view($path,$attributes = []){
    extract($attributes);//extract ens extreu cada objecte de l'array a una variable
    require base_path('views/' . $path);//Cridam a l'arxiu desde function
}

function login($user){
    $_SESSION['user']=[
        'email'=>$user['email']
    ];

    session_regenerate_id(true);
}
function logout()
{
    $_SESSION = [];
    session_destroy();


    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}