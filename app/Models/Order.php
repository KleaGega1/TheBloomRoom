<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'ref_code',
        'recipient_name',
        'recipient_phone',
        'delivery_address',
        'delivery_date',
        'payment_method',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
} 