<?php

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\{Product, Gift, Review};

class ReviewController
{
    public function show($product_id) {
        $product = Product::with('reviews')->findOrFail($product_id);
        $reviews = Review::where('product_id', $product->id)->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        $reviewCount = $reviews->count();

        return View::render()->view('client.products.show', compact('product', 'averageRating', 'reviewCount'));
    }

    public function submitReview() {
        $type = $_POST['type'] ?? 'product'; // 'product' or 'gift'
        $user_id = $_POST['user_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $comment = htmlspecialchars($_POST['comment'] ?? '');

        $review = new Review();
        $review->user_id = $user_id;
        $review->rating = $rating;
        $review->comment = $comment;


        // Determine ID and assign to correct field
        if ($type === 'gift') {
            $gift_id = $_POST['gift_id'] ?? null;
            $review->gift_id = $gift_id;
            $redirectUrl = "/gifts/$gift_id";
        } else {
            $product_id = $_POST['product_id'] ?? null;
            $review->product_id = $product_id;
            $redirectUrl = "/product/$product_id";
        }

        $review->save();

        $_SESSION['success'] = 'Review sent successfully!';
        header("Location: $redirectUrl");
        exit;
    }
}
