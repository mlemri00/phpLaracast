<?php

use core\Database;

$config = require(base_path('config.php'));
$db = App::resolve(Database::class);

$notes = $db->query("select * from notes where user_id = :user_id",[
'user_id'=>$_SESSION['user']['id']
])->get() ;

view("notes/index.view.php",
    ["heading"=>"Notes"
        ,"notes"=>$notes]);