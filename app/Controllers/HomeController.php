<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\{Product, Slider, Category};

class HomeController extends Controller
{
    public function index()
    {
        // Fetch main categories (parent_id = 0)
        $mainCategories = Category::where('parent_id', 0)->get();

        // Fetch subcategories grouped by parent_id
        $subcategories = Category::where('parent_id', '!=', 0)->get()->groupBy('parent_id');

        return View::render()->view('client.index', compact('mainCategories', 'subcategories'));
    }
}
