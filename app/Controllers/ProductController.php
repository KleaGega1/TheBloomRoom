<?php

namespace App\Controllers;

use App\Core\{Request, View, Session};
use App\Models\{Product, Wishlist, Review};

class ProductController extends Controller
{
    protected int $count;

    function __construct()
    {
        $this->count = Product::all()->count();
    }
    public function index(): View
    {
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
        }

        $products = $query->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();

        $user = get_logged_in_user();

        if ($user) {
            $wishlistItems = Wishlist::query()
                ->where('user_id', $user->id)
                ->pluck('product_id')
                ->toArray();

            foreach ($products as $product) {
                $product->is_in_wishlist = in_array($product->id, $wishlistItems);
            }
        } else {
            foreach ($products as $product) {
                $product->is_in_wishlist = false;
            }
        }

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
            $products = $query->get();
        } else {
            $query = Product::query()->with('reviews');
            $products = $query->get();
            $links = '';
        }

        return View::render()->view('client.products.index', compact('products', 'q', 'sort'));
    }

    public function show($id): View
    {
        $product = Product::query()->where('id', $id)->first();

        if (!$product) {
            abort(404, 'Product not found');
        }

        // Get current user
        $user = Session::get('user');
        
        // Add wishlist status to product
        if ($user) {
            $product->is_in_wishlist = Wishlist::query()
                ->where('user_id', $user['id'])
                ->where('product_id', $product->id)
                ->exists();
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

        // Add wishlist status to similar products
        if ($user) {
            $wishlistItems = Wishlist::query()
                ->where('user_id', $user['id'])
                ->pluck('product_id')
                ->toArray();

            foreach ($similarProducts as $similarProduct) {
                $similarProduct->is_in_wishlist = in_array($similarProduct->id, $wishlistItems);
            }
        }
    
        return View::render()->view('client.products.show', compact(
            'product',
            'similarProducts',
            'averageRating',
            'reviewCount'
        ));
    }
}