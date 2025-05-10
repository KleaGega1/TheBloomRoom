<?php

use App\Core\Session;
use App\Core\View;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;
use voku\helper\Paginator;
use App\Core\Request;


function paginate($query, $perPage, $route)
{
    $currentPage = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
    $offset = ($currentPage - 1) * $perPage;

    $countQuery = clone $query;
    $total = $countQuery->count();
    $items = $query->offset($offset)->limit($perPage)->get();

    $links = generatePaginationLinks($currentPage, $perPage, $total, $route);

    return [$items, $links];
}

function generatePaginationLinks($currentPage, $perPage, $total, $route)
{
    $totalPages = ceil($total / $perPage);
    
    if ($totalPages <= 1) {
        return '';
    }
    
    $links = '<nav aria-label="Page navigation"><ul class="pagination">';

    $queryParams = $_GET; 
    unset($queryParams['page']); 
    $queryString = !empty($queryParams) ? '&' . http_build_query($queryParams) : ''; 
    
    $prevDisabled = $currentPage <= 1 ? 'disabled' : '';
    $prevPage = $currentPage - 1;
    $links .= "<li class='page-item $prevDisabled'><a class='page-link' href='/$route?page=$prevPage$queryString' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
    
    $pageRange = 5;
    $startPage = max(1, $currentPage - floor($pageRange / 2));
    $endPage = min($totalPages, $startPage + $pageRange - 1);
    
    if ($endPage - $startPage + 1 < $pageRange && $startPage > 1) {
        $startPage = max(1, $endPage - $pageRange + 1);
    }
    
    if ($startPage > 1) {
        $links .= "<li class='page-item'><a class='page-link' href='/$route?page=1$queryString'>1</a></li>";
        if ($startPage > 2) {
            $links .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        }
    }
    
    for ($i = $startPage; $i <= $endPage; $i++) {
        $active = $i == $currentPage ? 'active' : '';
        $links .= "<li class='page-item $active'><a class='page-link' href='/$route?page=$i$queryString'>$i</a></li>";
    }
    
    if ($endPage < $totalPages) {
        if ($endPage < $totalPages - 1) {
            $links .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        }
        $links .= "<li class='page-item'><a class='page-link' href='/$route?page=$totalPages$queryString'>$totalPages</a></li>";
    }
    
    $nextDisabled = $currentPage >= $totalPages ? 'disabled' : '';
    $nextPage = $currentPage + 1;
    $links .= "<li class='page-item $nextDisabled'><a class='page-link' href='/$route?page=$nextPage$queryString' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
    
    $links .= '</ul></nav>';

    return $links;
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