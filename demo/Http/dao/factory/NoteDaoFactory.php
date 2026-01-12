<?php

namespace Http\dao\factory;

use Http\dao\dao\NoteDaoDb;

class NoteDaoFactory
{

    public static function build() {
        return new NoteDaoDb();
    }

}