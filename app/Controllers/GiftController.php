<?php

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\Gift;

class GiftController extends Controller
{
    protected int $count;

    function __construct()
    {
        $this->count = Gift::all()->count();
    }
    public function index(): View
    {
        list($gifts, $links) = paginate($query, 8, 'gifts');

        $q = '';
        $sort = '';
        $category = '';
    
        $query = Gift::query();
    
        if (Request::has('get')) {
            $request = Request::get('get');
    
            if (isset($request->key) && !empty($request->key)) {
                $query = $query->where('name', 'LIKE', '%' . $request->key . '%');
                $q = $request->key;
            }
    
            // Sort products by price
            if (isset($request->sort) && !empty($request->sort)) {
                $query = $query->orderBy('price', $request->sort);
                $sort = $request->sort;
            }
            
            if (!empty($q) || !empty($sort)) {
                $products = $query->get();
            }
        }
    
        return View::render()->view('client.gifts.index', compact('gifts', 'q', 'sort', 'links'));
    }
    public function show($id): View
    {
        $gift = Gift::query()->where('id', $id)->first();
        $similarGift = Gift::query()->where('category_id', $gift->category->id)->orderBy('id', 'DESC')->limit(4)->get();

        return View::render()->view('client.gifts.show', compact('gift', 'similarGift'));
    }

    public function category($categoryName): View
{
    $q = '';
    $sort = '';

    $query = Gift::query()->whereHas('category', function ($query) use ($categoryName) {
        $query->where('name', 'LIKE', '%' . str_replace('-', ' ', $categoryName) . '%');
    });

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
    list($gifts, $links) = paginate($query, 8, 'gifts');


    $gifts = $query->get();

    return View::render()->view('client.gifts.index', compact('gifts', 'q', 'sort', 'categoryName', 'links'));
}
}