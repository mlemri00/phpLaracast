<?php

use core\Database;

$config = require(base_path('config.php'));
$db = App::resolve(Database::class);

$notes = $db->query('select * from notes')->get() ;

view("notes/index.view.php",
    ["heading"=>"Notes"
        ,"notes"=>$notes]);