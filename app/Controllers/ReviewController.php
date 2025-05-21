<?php

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\{Product, Gift, Review, Order};

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

        // Handle file upload
        $photoPath = null;
        if (isset($_FILES['review_photo']) && $_FILES['review_photo']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['review_photo']['tmp_name'];
            $fileName = uniqid('review_', true) . '.' . pathinfo($_FILES['review_photo']['name'], PATHINFO_EXTENSION);
            $destinationDir = __DIR__ . '/../../public/uploads/reviews/';
            if (!is_dir($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }
            $destination = $destinationDir . $fileName;
            if (move_uploaded_file($fileTmp, $destination)) {
                $photoPath = 'uploads/reviews/' . $fileName;
            }
        }

        $review = new Review();
        $review->user_id = $user_id;
        $review->rating = $rating;
        $review->comment = $comment;
        $review->photo = $photoPath;

        // Determine ID and assign to correct field
        if ($type === 'gift') {
            $gift_id = $_POST['gift_id'] ?? null;
            $review->gift_id = $gift_id;
            $redirectUrl = "/gifts/$gift_id";
        } else {
            $product_id = $_POST['product_id'] ?? null;
            $review->product_id = $product_id;
            $redirectUrl = "/products/$product_id";
        }

        $review->save();

        $_SESSION['success'] = 'Review sent successfully!';
        header("Location: $redirectUrl");
        exit;
    }
}
