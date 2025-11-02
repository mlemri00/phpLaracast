<?php

$config = require(base_path('config.php'));
$dba = new Database($config);

$note = $dba->query('select * from notes where id = :id',[
    'id'=>$_GET['id']
])->findOrFail() ;

$currentUserId = 1;
authorize($note['user_id']==$currentUserId);



view("notes/show.view.php",
    ["heading"=>"Note"
    ,"note"=>$note]);