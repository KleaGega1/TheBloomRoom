<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Category, OrderItem, Review, Wishlist, CartItem};

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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function flowers()
    {
        return $this->belongsToMany(Product::class, 'bouquet_flowers', 'bouquet_id', 'flower_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function bouquets()
    {
        return $this->belongsToMany(Product::class, 'bouquet_flowers', 'flower_id', 'bouquet_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function scopeBouquets($query)
    {
        return $query->where('is_bouquet', true);
    }

    public function scopeFlowers($query)
    {
        return $query->where('is_bouquet', false);
    }

       public function cartItems()
    {
        return $this->morphMany(CartItem::class, 'item');
    }
}