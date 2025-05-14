<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Core\Session;
use App\Core\View;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Gift;

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
            ->with(['product', 'gift'])
            ->get();

        return View::render()->view('user.profile.wishlist', [
            'wishlistItems' => $wishlistItems,
            'user' => $user
        ]);
    }

    // Toggle wishlist (add/remove product or gift)
    public function toggle()
    {
        error_log('Wishlist toggle called');
        
        // Verify CSRF token
        $headers = getallheaders();
        error_log('Request headers: ' . print_r($headers, true));
        
        $csrfToken = $headers['X-CSRF-TOKEN'] ?? null;
        error_log('Received CSRF token: ' . ($csrfToken ?? 'null'));
        error_log('Session token: ' . (\App\Core\Session::get('token') ?? 'null'));
        
        try {
            if (!$csrfToken || !\App\Core\CSRFToken::verify($csrfToken)) {
                error_log('CSRF verification failed');
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid CSRF token'
                ]);
                exit;
            }
        } catch (\Exception $e) {
            error_log('CSRF Error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Invalid CSRF token'
            ]);
            exit;
        }

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

        // Get product/gift ID and type from request
        $input = json_decode(file_get_contents('php://input'), true);
        error_log('Input: ' . print_r($input, true));
        
        $itemId = $input['item_id'] ?? null;
        $itemType = $input['item_type'] ?? null;
        
        if (!$itemId || !$itemType) {
            error_log('Item ID or type missing');
            echo json_encode([
                'success' => false,
                'message' => 'Item ID and type are required'
            ]);
            exit;
        }

        // Check if item exists
        if ($itemType === 'product') {
            $item = Product::find($itemId);
            $idField = 'product_id';
        } else if ($itemType === 'gift') {
            $item = Gift::find($itemId);
            $idField = 'gift_id';
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid item type'
            ]);
            exit;
        }

        if (!$item) {
            error_log('Item not found: ' . $itemId);
            echo json_encode([
                'success' => false,
                'message' => 'Item not found'
            ]);
            exit;
        }

        // Check if item is already in wishlist
        $exists = Wishlist::query()
            ->where('user_id', $user->id)
            ->where($idField, $itemId)
            ->first();

        if ($exists) {
            // Remove from wishlist
            Wishlist::query()
                ->where('user_id', $user->id)
                ->where($idField, $itemId)
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
        $data = [
            'user_id' => $user->id,
            'product_id' => $itemType === 'product' ? $itemId : null,
            'gift_id' => $itemType === 'gift' ? $itemId : null
        ];
        Wishlist::query()->create($data);
        error_log('Added to wishlist');
        echo json_encode([
            'success' => true,
            'in_wishlist' => true,
            'message' => 'Added to wishlist'
        ]);
        exit;
    }
} 