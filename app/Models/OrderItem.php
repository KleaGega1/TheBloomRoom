<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    public $timestamps = true;
    protected $fillable = [
        'order_id',
        'product_id',
        'gift_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function gift()
    {
        return $this->belongsTo(\App\Models\Gift::class);
    }
} 