<?php

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\Product;

class ProductController extends Controller
{
    protected int $count;

    function __construct()
    {
        $this->count = Product::all()->count();
    }
    public function index(): View
    {
        list($products, $links) = paginate(8, $this->count, 'products');

        $q = '';
        $sort = '';
        $category = '';
    
        $query = Product::query();
    
        if (Request::has('get')) {
            $request = Request::get('get');
    
            if (isset($request->key) && !empty($request->key)) {
                $query = $query->where('name', 'LIKE', '%' . $request->key . '%');
                $q = $request->key;
            }
    
            if (isset($request->sort) && !empty($request->sort)) {
                $query = $query->orderBy('price', $request->sort);
                $sort = $request->sort;
            }
            
            if (!empty($q) || !empty($sort)) {
                $products = $query->get();
            }
        }
    
        return View::render()->view('client.products.index', compact('products', 'q', 'sort', 'links'));
    }
    public function show($id): View
    {
        $product = Product::query()->where('id', $id)->first();
    
        if (!$product) {
            var_dump(404, 'Product not found');
        }
    
        $similarProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();
    
        return View::render()->view('client.products.show', compact('product', 'similarProducts'));
    }


}