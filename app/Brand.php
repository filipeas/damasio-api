<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Brand extends Model
{
    protected $table = 'brands';

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at'
    ];

    protected $fillable = [
        'code', 'title', 'image',
    ];

    // retorna produtos da marca
    public function products()
    {
        return $this->belongsToMany(Product::class, 'brand_product', 'brand', 'product');
    }

    // método de callback para exclusão em cascata
    public static function boot()
    {
        parent::boot();

        self::deleting(function (Brand $brand) {
            // remove vinculo com produtos
            // $brand->products()->delete();

            // remove imagem
            File::delete(storage_path('app/public' . $brand->image));
        });
    }
}
