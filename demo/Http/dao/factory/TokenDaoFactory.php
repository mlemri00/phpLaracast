<?php

namespace Http\dao\factory;


use Http\dao\dao\TokenDaoDb;

class TokenDaoFactory
{

    public static function build() {
        return new TokenDaoDb();
    }
}