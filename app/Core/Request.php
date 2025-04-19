<?php

namespace App\Core;

class Request
{
    public static function all($is_array = false)
    {
        $request = [];

        if (count($_POST) > 0)
            $request['post'] = $_POST;

        if (count($_GET) > 0)
            $request['get'] = $_GET;

        $request['file'] = $_FILES;

        return json_decode(json_encode($request), $is_array);
    }

    public static function get($key)
    {
        $request = self::all();
        return isset($request->$key) ? $request->$key : null;
    }

    public static function has($key): bool
    {
        return array_key_exists($key, self::all(true));
    }
    
    public static function getInput($section, $key, $default = null)
    {
        $section_data = self::get($section);
        return $section_data && isset($section_data->$key) ? $section_data->$key : $default;
    }

}
