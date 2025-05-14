<?php

namespace App\Core;

use Exception;

class CSRFToken
{
    public static function _token()
    {
        if (!Session::has('token')) {
            $key = base64_encode(openssl_random_pseudo_bytes(32));
            Session::add('token', $key);
        }

        return Session::get('token');
    }

    public static function verify($request_token, $regenerate = false): bool
    {
        if (!Session::has('token') || Session::get('token') !== $request_token) {
            return false;
        }

        return true;
    }
}
