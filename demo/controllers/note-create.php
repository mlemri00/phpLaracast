<?php
$heading='Create note';

$config = require('config.php');
$dba = new Database($config);


if ($_SERVER['REQUEST_METHOD']=='POST') {

    $errors =[];

    if (strlen($_POST['body']) === 0){
        $errors['body']='A body is required';
    }
    if (strlen($_POST['body'])> 1000){
        $errors['body']='The body cannot be more than 1000 characters';
    }

    if (empty($errors)){
        $dba->query(
            'INSERT INTO notes (body, user_id)
                    VALUES (:body,:user_id)',
            [
                'body' => $_POST['body'],
                'user_id' => 1
            ]);
}
}

require "views/note-create.view.php";