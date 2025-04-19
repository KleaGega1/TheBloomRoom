<?php

namespace App\Middlewares;

use App\Core\Session;

class Auth
{
    // Check if the user is logged in
    public static function check(): void
    {
        if (!(is_logged_in())) {
            Session::add('invalids', ['You need to login first']);
            redirect('/login'); //Redirect to login page
        }
    }
}
