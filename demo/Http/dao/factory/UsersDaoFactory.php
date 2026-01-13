<?php

namespace Http\dao\factory;

use Http\dao\dao\UsersDaoDb;

class UsersDaoFactory
{
    public static function build() {
        return new UsersDaoDb();
    }

}