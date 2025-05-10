<?php

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\Product;
use App\Models\Review;


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
    
        $query = Product::query()->with('reviews');

        if (isset($request->key) && !empty($request->key)) {
            $query = $query->where('name', 'LIKE', '%' . $request->key . '%');
            $q = $request->key;
        }

        if (isset($request->sort) && !empty($request->sort)) {
            $query = $query->orderBy('price', $request->sort);
            $sort = $request->sort;
        }

        if (!empty($q) || !empty($sort)) {
            $products = $query->get(); // ❗ Returns Eloquent models
        } else {
            $query = Product::query()->with('reviews');
            $products = $query->get();
            $links = '';
        }
    
        return View::render()->view('client.products.index', compact('products', 'q', 'sort', 'links'));
    }

    public function show($id): View
    {
        $product = Product::query()->where('id', $id)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        $reviews = Review::where('product_id', $product->id)->get();

        $averageRating = Review::where('product_id', $product->id)->avg('rating') ?? 0;
        $reviewCount = Review::where('product_id', $product->id)->count();


        $similarProducts = Product::query()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        return View::render()->view('client.products.show', compact(
            'product',
            'similarProducts',
            'averageRating',
            'reviewCount'
        ));
    }

}