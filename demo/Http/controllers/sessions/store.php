<?php


use core\Authenticator;
use Http\Forms\LoginForm;



$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();


if (! $form->validate($email,$password)){
    return view('sessions/create.view.php',[
        'errors'=>$form->errors()
    ]);
}

$auth =new Authenticator();

if($auth->attempt($email, $password)){

   redirect('/');


}else {
    return view('sessions/create.view.php', [
        'errors' => [
            'email' => 'No matching accoutn found for that email adress and password'
        ]
    ]);


}