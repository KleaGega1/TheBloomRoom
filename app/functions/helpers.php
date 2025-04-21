<?php

use App\Core\Session;
use App\Core\View;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;
use voku\helper\Paginator;

function render_simple_links($current, $total)
{
    $links = '';

    for ($i = 1; $i <= $total; $i++) {
        if ($i === $current) {
            $links .= "<span style='margin:0 5px;font-weight:bold;'>$i</span>";
        } else {
            $links .= "<a style='margin:0 5px;' href='?page=$i'>$i</a>";
        }
    }

    return $links;
}
function dump($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die;
}
function is_logged_in(): bool
{
    return Session::has('user_id');
}
//Get logged user
function get_logged_in_user()
{
    if (is_logged_in()) {
        return User::query()->where('id', Session::get('user_id'))->first();
    }
    return false;
}
//Verify is admin
function is_admin(): bool
{
    if (is_logged_in()) {
        $user =get_logged_in_user();
        return $user->role == 'admin';
    }
    return false;
}
function redirect(string $page): void
{
    header("location: $page");
}
function url($path = '')
{
    $path = ltrim($path, '/');
    
    $base = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $base .= $_SERVER['HTTP_HOST'];
    
    return $base . '/' . $path;
}