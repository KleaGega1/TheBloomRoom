<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\{Category, Product, Gift};

class CategoryController extends Controller
{
    public function show($id): View
    {
        $category = Category::query()->where('id', $id)->first();
        $products = Product::query()->where('category_id', $category->id)->get();

        $user = get_logged_in_user();
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::query()
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

        return View::render()->view('client.categories.show', compact('category', 'products'));
    }

    public function index()
    {
        $mainCategories = Category::where('parent_id', 0)->get();

        $subcategories = Category::where('parent_id', '!=', 0)->get()->groupBy('parent_id');

        return View::render()->view('client.index', compact('mainCategories', 'subcategories'));
    }

    public function showByCategorySlug($slug)
    {
        // Find the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // Fetch all products and gifts belonging to this category
        $products = Product::where('category_id', $category->id)->get();
        $gifts = Gift::where('category_id', $category->id)->get();

        $user = get_logged_in_user();
        if ($user) {
            $wishlistItems = \App\Models\Wishlist::query()
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

        return View::render()->view('client.categories.show', compact('category', 'products', 'gifts'));
    }
}
