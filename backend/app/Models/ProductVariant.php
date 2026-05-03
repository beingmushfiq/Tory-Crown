<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'sku', 'karat', 'weight_in_grams', 'size', 'making_charge', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
