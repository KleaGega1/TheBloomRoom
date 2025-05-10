<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Core\Session;
use App\Core\View;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    // Display wishlist page
    public function index()
    {
        // Get current user
        $user = get_logged_in_user();
        
        if (!$user) {
            redirect('/login');
        }

        // Get user's wishlist items
        $wishlistItems = Wishlist::query()
            ->where('user_id', $user->id)
            ->with('product')
            ->get();

        return View::render()->view('user.profile.wishlist', [
            'wishlistItems' => $wishlistItems,
            'user' => $user
        ]);
    }

    // Toggle wishlist (add/remove product)
    public function toggle()
    {
        error_log('Wishlist toggle called');
        // Check if user is logged in
        $user = get_logged_in_user();
        if (!$user) {
            error_log('User not logged in');
            echo json_encode([
                'success' => false,
                'message' => 'Please login to add items to wishlist'
            ]);
            exit;
        }

        // Get product ID from request
        $input = json_decode(file_get_contents('php://input'), true);
        error_log('Input: ' . print_r($input, true));
        $productId = $input['product_id'] ?? null;
        if (!$productId) {
            error_log('Product ID missing');
            echo json_encode([
                'success' => false,
                'message' => 'Product ID is required'
            ]);
            exit;
        }

        // Check if product exists
        $product = Product::find($productId);
        if (!$product) {
            error_log('Product not found: ' . $productId);
            echo json_encode([
                'success' => false,
                'message' => 'Product not found'
            ]);
            exit;
        }

        // Check if product is already in wishlist
        $exists = Wishlist::query()
            ->where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            // Remove from wishlist
            Wishlist::query()
                ->where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();
            error_log('Removed from wishlist');
            echo json_encode([
                'success' => true,
                'in_wishlist' => false,
                'message' => 'Removed from wishlist'
            ]);
            exit;
        }

        // Add to wishlist
        Wishlist::query()->create([
            'user_id' => $user->id,
            'product_id' => $productId
        ]);
        error_log('Added to wishlist');
        echo json_encode([
            'success' => true,
            'in_wishlist' => true,
            'message' => 'Added to wishlist'
        ]);
        exit;
    }
} 