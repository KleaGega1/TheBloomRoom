<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist'; // Explicitly set the table name
    protected $fillable = ['user_id', 'product_id'];

    // Relationship with product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 