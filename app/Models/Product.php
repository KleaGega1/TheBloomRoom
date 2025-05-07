<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = [
        'name', 'sku', 'price', 'description', 'quantity', 
        'category_id', 'is_bouquet', 'color', 'length', 
        'occasion', 'image_path'
    ];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'price' => 'decimal:2',
        'is_bouquet' => 'boolean',
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // For bouquets, relationship with flowers through bouquet_flowers
    public function flowers()
    {
        return $this->belongsToMany(Product::class, 'bouquet_flowers', 'bouquet_id', 'flower_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // For flowers, relationship with bouquets they belong to
    public function bouquets()
    {
        return $this->belongsToMany(Product::class, 'bouquet_flowers', 'flower_id', 'bouquet_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    // Relationship with order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship with reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relationship with wishlists
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Scope for bouquets only
    public function scopeBouquets($query)
    {
        return $query->where('is_bouquet', true);
    }

    // Scope for individual flowers only
    public function scopeFlowers($query)
    {
        return $query->where('is_bouquet', false);
    }
}