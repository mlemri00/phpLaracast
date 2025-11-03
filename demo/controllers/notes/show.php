<?php

use core\Database;

$config = require(base_path('config.php'));
$dba = new Database($config);
$currentUserId = 2;


if ($_SERVER['REQUEST_METHOD']==='POST'){

    $note = $dba->query('select * from notes where id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();

    authorize($note['user_id']===$currentUserId);

    $dba->query('delete from notes where id = :id',[
        'id'=>$_GET['id']
    ]);
    header('location: /notes');
    exit();

}else {

    $note = $dba->query('select * from notes where id = :id', [
        'id' => $_GET['id']
    ])->findOrFail();


    authorize($note['user_id'] == $currentUserId);




}
view("notes/show.view.php",
    ["heading"=>"Note"
        ,"note"=>$note]);
