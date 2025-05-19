<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Cart};


class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'gift_id',
        'quantity',
        'price'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function getItemAttribute()
    {
        return $this->product_id ? $this->product : $this->gift;
    }
}
