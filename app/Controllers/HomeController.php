<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\{Product, Slider};

class HomeController extends Controller
{
    public function index(): View
    {
        return View::render()->view('client.index');
    }
}
