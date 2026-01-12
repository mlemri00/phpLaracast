<?php

namespace core;

class Session
{

    public static function has($key){
        return (bool) self::get($key);
    }

    public static function put($key, $value){
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null){
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }






}