<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Cart};


class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'item_id',
        'item_type',
        'quantity',
        'price'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


    public function item()
    {
        return $this->morphTo();
    }
}
