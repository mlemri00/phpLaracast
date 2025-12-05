<?php

namespace Http\controllers\classes;

use App;
use core\Authenticator;
use core\Database;

class SessionController
{

    public function index()
    {
        view('sessions/create.view.php');
    }
    public function store(){

        $db = App::resolve(Database::class);
        $email = $_POST['email'];
        $password = $_POST['password'];

        $form = new LoginForm();


        if ($form->validate($email,$password)){

            if((new Authenticator)->attempt($email, $password)){
                redirect('/');
            }else {
                $form->error('email','No matching account found for that email address and password');
            }


        }
        $user = $db->query('select * from users where email = :email',[
            'email'=>$email

        ])->find();

        if ($user){
            if (password_verify($password,$user['password'])){
                login([
                    'email'=>$email
                ]);

                header('location: /');
                exit();
            }
        }






//return redirect('/login');


        return view('sessions/create.view.php', [
            'errors' => $form->errors()
        ]);

    }


    public function delete(){
        (new Authenticator)->logout();
        header('location: /');
        exit();
    }


}