<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BouquetFlower extends Model
{
    use SoftDeletes;
    
    protected $table = 'bouquet_flowers';     
    protected $fillable = [
        'bouquet_id',
        'flower_id',
        'quantity',
    ];
    
    public $timestamps = true;

    public function bouquet()
    {
        return $this->belongsTo(Product::class, 'bouquet_id');
    }
    
    public function flower()
    {
        return $this->belongsTo(Product::class, 'flower_id');
    }
}