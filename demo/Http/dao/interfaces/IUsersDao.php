<?php

namespace Http\dao\interfaces;

interface IUsersDao
{

    public function findUserByEmail($email);

    public function registerUser($email, $password, $phone, $username);

    public function getUserIdByEmail($email);

}