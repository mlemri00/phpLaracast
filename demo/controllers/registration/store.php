<?php

use core\App;
use core\Database;
use core\Validator;


$email = $_POST['email'];
$password = $_POST['password'];


if (!Validator::email($email)){
    $errors['email']='Please provide a valid email address';

}

if (!Validator::string($password,7,255)){
    $errors['password']='Please provide a password of at least seven characters';
}


if (! empty($errors)){
    return view('registration/create.view.php',[
        'errors'=>$errors
    ]);
}

$db = App::resolve(Database::class);

$user= $db->query('select * from users where email = :email',[
    'email'=>$email
])->find();

if($user){
    header('location: /');
    exit();
}else{
    $db->query('insert into users(email,password) values (:email, :password)',[
        'email'=>$email,
        'password'=>$password
    ]);

    $_SESSION['user']=[
        'email'=> $email
    ];

    header('location: /');
}