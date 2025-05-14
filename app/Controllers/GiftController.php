<?php

namespace App\Controllers;

use App\Core\{Request, View, Session};
use App\Models\{Gift, Wishlist};
use App\Models\Review; 

class GiftController extends Controller
{
    protected int $count;

    function __construct()
    {
        $this->count = Gift::all()->count();
    }

    public function index(): View
    {
        $q = '';
        $sort = '';
        $links = '';

        $query = Gift::query();

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

        $user = get_logged_in_user();

        if ($user) {
            $wishlistItems = Wishlist::query()
                ->where('user_id', $user->id)
                ->pluck('gift_id')
                ->toArray();

            foreach ($gifts as $gift) {
                $gift->is_in_wishlist = in_array($gift->id, $wishlistItems);
            }
        } else {
            foreach ($gifts as $gift) {
                $gift->is_in_wishlist = false;
            }
        }

        return View::render()->view('client.gifts.index', compact('gifts', 'q', 'sort', 'links'));
    }


    public function show($id): View
    {
        $gift = Gift::query()->where('id', $id)->first();

        if (!$gift) {
            abort(404, 'Gift not found');
        }

        $user = get_logged_in_user();

        if ($user) {
            $gift->is_in_wishlist = Wishlist::query()
                ->where('user_id', $user->id)
                ->where('gift_id', $gift->id)
                ->exists();
        } else {
            $gift->is_in_wishlist = false;
        }

        // Load reviews
        $reviews = Review::where('gift_id', $gift->id)->get();

        $averageRating = Review::where('gift_id', $gift->id)->avg('rating') ?? 0;
        $reviewCount = Review::where('gift_id', $gift->id)->count();

        // Load similar gifts
        $similarGift = Gift::query()
            ->where('category_id', $gift->category_id)
            ->where('id', '!=', $gift->id)
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        if ($user) {
            $wishlistItems = Wishlist::query()
                ->where('user_id', $user['id'])
                ->pluck('gift_id')
                ->toArray();

            foreach ($similarGift as $sg) {
                $sg->is_in_wishlist = in_array($sg->id, $wishlistItems);
            }
        }

        return View::render()->view('client.gifts.show', compact(
            'gift',
            'similarGift',
            'averageRating',
            'reviewCount',
        ));
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

        $user = get_logged_in_user();

        if ($user) {
            $wishlistItems = Wishlist::query()
                ->where('user_id', $user->id)
                ->pluck('gift_id')
                ->toArray();

            foreach ($gifts as $gift) {
                $gift->is_in_wishlist = in_array($gift->id, $wishlistItems);
            }
        } else {
            foreach ($gifts as $gift) {
                $gift->is_in_wishlist = false;
            }
        }

        return View::render()->view('client.gifts.index', compact('gifts', 'q', 'sort', 'categoryName', 'links'));
    }
}
