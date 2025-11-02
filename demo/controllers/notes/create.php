<?php

require 'Validator.php';
$heading='Create note';
$config = require('config.php');
$dba = new Database($config);


if ($_SERVER['REQUEST_METHOD']=='POST') {

    $errors =[];



    if (!Validator::string($_POST['body'],1,1000)){
        $errors['body']='A body of no more than 1000 characters,  is required';
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

require "views/notes/create.view.php";