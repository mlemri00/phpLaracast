<?php

namespace Http\dao\factory;

use Http\dao\dao\NoteDaoDbImpl;

class NoteDaoFactory
{

    public function build() {
        return new NoteDaoDbImpl();
    }

}