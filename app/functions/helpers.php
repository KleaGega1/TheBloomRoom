<?php

use App\Core\Session;
use App\Core\View;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;
use voku\helper\Paginator;


function paginate($num_of_records, $total_count, $table): array|null
{
    $pages = new Paginator($num_of_records, 'page');
    $pages->set_total($total_count);
    $data = DB::select("SELECT * FROM $table WHERE deleted_at is null ORDER BY created_at DESC" . $pages->get_limit());

    return [
        json_decode(json_encode($data)),
        $pages->page_links()
    ];
}
//Paginate data
function paginateData($model, $perPage = 10)
{
    $page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
    $offset = ($page - 1) * $perPage;

    $query = $model::whereNull('deleted_at')->orderBy('created_at', 'desc');

    $total = $query->count();
    $items = $query->offset($offset)->limit($perPage)->get();

    $totalPages = ceil($total / $perPage);

    return [
        'items' => $items,
        'links' => render_simple_links($page, $totalPages)
    ];
}
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