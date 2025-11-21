<?php

use core\Database;
use core\Validator;


$db = App::resolve(Database::class);


$currentUserId = 2;

$note = $db -> query('select * from notes where id = :id',[
    'id'=>$_POST['id']
])->findOrFail();


authorize($note['user_id']===$currentUserId);

$errors = [];

if (!Validator::string($_POST['body'],1,1000)){
    $errors['body']='A body of no more than 1000 characters,  is required';
}


if (count($errors)){
    return view('notes/edit.view.php',[
        'heading'=>'Edit Note',
        'errors'=>$errors,
        'note'=>$note
    ]);
}

$db -> query('update notes set body = :body where id = :id',[

    'body' => $_POST['body']
    , 'id'=>$_POST['id']
]);

header('location: /notes');
die();