<?php

use core\Database;

$config = require(base_path('config.php'));
$dba = new Database($config);
$currentUserId = 2;




    $note = $dba->query('select * from notes where id = :id', [
        'id' => $_POST['id']
    ])->findOrFail();

    authorize($note['user_id']===$currentUserId);

    $dba->query('delete from notes where id = :id',[
        'id'=>$_POST['id']
    ]);
    header('location: /notes');
    exit();