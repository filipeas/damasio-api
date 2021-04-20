<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandProduct extends Model
{
    protected $table = 'brand_products';

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at'
    ];

    protected $fillable = [
        'brand', 'product',
    ];
}
