<?php

use core\Database;

$config = require(base_path('config.php'));
$dba = new Database($config);

$notes = $dba->query('select * from notes ')->get() ;

view("notes/index.view.php",
    ["heading"=>"Notes"
        ,"notes"=>$notes]);