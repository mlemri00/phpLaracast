<?php

namespace Http\dao\interfaces;

interface ITokenDao
{
    public static function storeToken($token, $userId);

    public static function getAllTokens($userId);

    public static function getLastId();

    public static function deleteToken($tokenId);

    public static function deleteAllTokens($userId);

    public static function getToken($tokenId);




}