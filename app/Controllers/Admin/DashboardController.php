<?php
namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\View;
use App\Middlewares\Role;
use App\Models\Product;
use App\Models\Order;

// Display the admin dashboard with recent products, total order count, and orders grouped by city.
class DashboardController extends Controller
{
    public function __construct()
    {
        Role::handle();
    }

    public function index(): View
    {
      
        return View::render()->view('admin.dashboard');
    }
}