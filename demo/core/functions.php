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

function authorize($condition,$status=Response::FORBIDDEN,$apiRest = false){
    if (!$condition){

        abort($status,$apiRest);
    }


}
function abort($code = 404,$apiRest=false){// això és per fer un paràmetre de sèrie si no es passa ni un
    http_response_code($code);
    if ($apiRest){
        header('Content-Type: application/json');
        echo json_encode(["message"=>"unauthorized"]);
        die();
    }else {
        require base_path("views/{$code}.php");
    }
    die();
}
function base_path($path){
    return BASE_PATH . $path;
}

function view($path,$attributes = []){
    extract($attributes);//extract ens extreu cada objecte de l'array a una variable
    require base_path('views/' . $path);//Cridam a l'arxiu desde function
}

function redirect($path){
    header("location: {$path}");
    exit();
}