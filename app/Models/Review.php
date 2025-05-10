<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Table name (optional if it's the plural of the model name)
    protected $table = 'reviews';

    // Timestamps
    public $timestamps = true;

    // Fillable fields (adjust according to your actual database schema)
    protected $fillable = [
        'product_id', 'user_id', 'rating', 'comment',
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with User (assuming you have a User model and a user_id in the reviews table)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // You can add other methods or custom scopes as needed, such as filtering reviews by rating or user.
}
