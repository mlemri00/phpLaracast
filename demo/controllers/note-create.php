<?php
$heading='Create note';

$config = require('config.php');
$dba = new Database($config);


if ($_SERVER['REQUEST_METHOD']=='POST') {

 
    $dba->query(
        'INSERT INTO notes (body, user_id)
                VALUES (:body,:user_id)',
        [
            'body' => $_POST['body'],
            'user_id' => 1
        ]);

}

require "views/note-create.view.php";