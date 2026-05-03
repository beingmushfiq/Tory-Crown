<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldRate extends Model
{
    protected $fillable = ['karat', 'price_per_gram', 'effective_date'];
}
