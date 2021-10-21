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

    public function brandProduct()
    {
        return BrandProduct::join('products', 'products.id', 'brand_products.product')
            ->where('brands', $this->id)
            ->select(
                'brands.id as id',
                'brands.code as code',
                'brands.title as title',
                'brands.image as image',
                // 'brand.created_at as created_at',
                // 'brand.updated_at as updated_at',
            );
        // return DB::table('brands')
        //     ->join('brand_product', 'brand_product.brand', 'brands.code')
        //     ->where('brand_product.product', $this->id)
        //     ->select('brands.id as id', 'brands.code as code', 'brands.title as title', 'brands.image as image')
        //     ->get();
    }

    // método de callback para exclusão em cascata
    public static function boot()
    {
        parent::boot();

        self::deleting(function (Brand $brand) {
            // remove vinculo com produtos
            $brand->brandProduct()->delete();

            // remove imagem
            File::delete(storage_path('app/public' . $brand->image));
        });
    }
}
