<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gift extends Model
{
    use SoftDeletes;

    protected $table = 'gifts';

    protected $fillable = [
        'name',
        'sku',
        'price',
        'description',
        'quantity',
        'category_id',
        'color',
        'size',
        'occasion',
        'image_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    
}
