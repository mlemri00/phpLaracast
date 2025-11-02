<?php

$config = require('config.php');
$dba = new Database($config);
$heading = "Note";
$note = $dba->query('select * from notes where id = :id',[
    'id'=>$_GET['id']
])->find() ;

if (! $note){
    abort();
}
$currentUserId = 1;

if ($note['user_id']!=$currentUserId){
    abort(Response::FORBIDDEN);
}


require "views/note.view.php";