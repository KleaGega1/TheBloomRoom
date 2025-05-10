<?php

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\Product;
use App\Models\Review;

class ReviewController {

    public function show($product_id) {
        // Retrieve the product along with its reviews
        $product = Product::with('reviews')->findOrFail($product_id);
        $reviews = Review::where('product_id', $product->id)->get();
        $averageRating = $reviews->avg('rating') ?? 0;
        $reviewCount = $reviews->count();
        
        // Return the view with the product and its reviews
        return View::render()->view('client.products.show', compact('product', 'averageRating', 'reviewCount'));
    }
    
    
    public function submitReview() {
        // Use $_POST to access form data directly
        $product_id = $_POST['product_id'] ?? null;
        $user_id = $_POST['user_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $comment = htmlspecialchars($_POST['comment'] ?? '');

        // Save the review using Eloquent
        $review = new Review();
        $review->product_id = $product_id;
        $review->user_id = $user_id;
        $review->rating = $rating;
        $review->comment = $comment;

        // Save the review in the database
        $review->save();

        // Redirect to the product page with a success message stored in the session
        $_SESSION['success'] = 'Review submitted successfully!';

        // Redirect to the product page where the review will be displayed
        header("Location: /product/$product_id");
        exit; // Ensure that the script stops executing after the redirect
    }
}
