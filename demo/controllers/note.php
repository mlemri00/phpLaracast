<?php

$config = require('config.php');
$dba = new Database($config);
$heading = "Note";
$note = $dba->query('select * from notes where id = :id',[
    'id'=>$_GET['id']
])->findOrFail() ;

$currentUserId = 1;
authorize($note['user_id']==$currentUserId);



require "views/note.view.php";