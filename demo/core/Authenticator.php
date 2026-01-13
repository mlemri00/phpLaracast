<?php

namespace core;

use App;

class Authenticator
{

    public function attempt($email, $password, $session = true)
    {

        $user = App::resolve(Database::class)
            ->query('select * from users where email = :email', [
                'email' => $email
            ])->find();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($session) {
                    $this->login(
                        [
                            'email' => $email,
                            'id' => $user['id']
                        ]
                    );
                }
                return true;
            }
        }

        return false;
    }

    public function login($user)
    {
        Session::put('user', [
            'email' => $user['email'],
            'id' => $user['id']
        ]);

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }

}