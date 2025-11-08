<?php


use core\App;
use core\Database;
use core\Validator;
use Http\Forms\LoginForm;

$db = App::resolve(Database::class);


$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();


if (! $form->validate($email,$password)){
    return view('sessions/create.view.php',[
        'errors'=>$form->errors()
    ]);
}

$user=$db->query('select * from users where email = :email',[
    'email'=>$email
])->find();

if($user){
    if (password_verify($password,$user['password'])) {

        login(
            [
                'email' => $email
            ]
        );
        header('location: /');

        exit();
    }
}

return view('sessions/create.view.php',[
    'errors'=>[
        'email'=>'No matching accoutn found for that email adress and password'
    ]
]);