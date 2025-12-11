<?php

namespace core\Middleware;

class Middleware
{
    const MAP=[
        'guest'=> Guest::class,
        'auth'=>Auth::class
    ];


    public static function resolve($key,$apiRequest = false){

        if(!$key){
            return;
        }
        $middleware = static::MAP[$key] ?? false;

        if(!$middleware){
            throw new \Exception('No matching middlware for key '. $key);
        }

        (new $middleware)->handle($apiRequest);

    }

}