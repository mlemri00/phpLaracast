<?php

namespace core\Middleware;

use core\Jwt;
use DateTimeImmutable;
use Http\dao\dao\UsersDaoDb;

class Auth
{
    public function handle()
    {

            if (!$_SESSION['user'] ?? false) {
                header('location: /');
                exit();

        }
    }


    public static function getUserIdFromJwt()
    {

    }
//eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCIsImNyZWF0ZWRBdCI6eyJkYXRlIjoiMjAyNS0xMi0xMiAwODowMzoxMS43Mjg4OTYiLCJ0aW1lem9uZV90eXBlIjozLCJ0aW1lem9uZSI6IlVUQyJ9LCJyYW5kIjoyNTI0M30.eyJpZCI6eyJpZCI6MzF9fQ.R31n8PoiQsFaluYR9L6yKAmkFSxkC6nDMiNzD8oOpJ0
//Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6eyJpZCI6MzF9fQ._bpz0w8reZkau9PX4Mfcj5U0wTwAVPGMgyxfzEBEGaY.eyJpZCI6eyJpZCI6MzF9fQ.R31n8PoiQsFaluYR9L6yKAmkFSxkC6nDMiNzD8oOpJ0
}