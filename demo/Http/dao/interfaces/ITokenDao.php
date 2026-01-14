<?php

namespace Http\dao\interfaces;

interface ITokenDao
{
    public  function storeToken($token, $userId);

    public  function getAllTokens();

    public  function getLastId();

    public  function deleteToken($tokenId);

    public  function deleteAllTokens($userId);

    public  function getToken($tokenId);




}