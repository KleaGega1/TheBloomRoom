<?php

namespace App\Middlewares;

use App\Core\Session;
use App\Models\User;

class Role
{
    public static function handle(): void
    {
        // If the user is not logged in, redirect them to the login page with a message
        if (!(is_logged_in())) {
            Session::add('message', 'You have to login first');
            redirect('/login');
        }
          // Get the logged-in user
        $user = get_logged_in_user();
        // Check if the user is not an admin
        if ($user->role <> 'admin') {
            Session::add('message', 'You do not have permission to access this page ');
            redirect('/');
        }
    }
}
