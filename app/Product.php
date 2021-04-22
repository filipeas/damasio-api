<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    protected $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at'
    ];

    protected $fillable = [
        'cod', 'subcategory', 'group', 'description', 'application', 'cover',
    ];

    // retorna subcategoria do produto
    public function category()
    {
        return $this->belongsTo(Category::class, 'subcategory', 'id');
    }

    // retorna categoria do produto
    public function categoryParent()
    {
        $subcategory = Category::where('id', $this->subcategory)->first();
        return Category::where('id', $subcategory->parent);
    }

    // retorna produtos de uma categoria
    public function listByCategory()
    {
        return $this->categoryParent()->productsOfCategory();
    }

    // retorna produtos de uma sub-categoria
    public function listBySubcategory()
    {
        return $this->category()->products()->get();
    }

    // retorna marcas do produto atual
    public function brands()
    {
        return BrandProduct::join('brands', 'brands.id', 'brand_products.brand')
            ->where('product', $this->id)
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

        self::deleting(function (Product $product) {
            // remove marcas
            $product->brands()->delete();

            // remove cover
            File::delete(storage_path('app/public' . $product->cover));
        });
    }
}
