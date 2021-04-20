<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $dates = [
        'created_at',
        'updated_at',
        // 'deleted_at'
    ];

    protected $fillable = [
        'parent', 'title',
    ];

    // retorna produtos da subcategoria atual
    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory', 'id');
    }

    // retorna produtos da categoria atual
    public function productsOfCategory()
    {
        return Product::join('categories as subcategories', 'products.subcategory', 'subcategories.id')
            ->join('categories as categories', 'categories.id', 'subcategories.parent')
            ->where('subcategories.parent', $this->id)
            ->select(
                'products.id as id',
                'products.cod as cod',
                'products.subcategory as subcategory',
                'products.group as group',
                'products.description as description',
                'products.application as application',
                'products.cover as cover'
            );
    }

    // retorna produtos da subcategoria atual
    public function productsOfSubcategory()
    {
        return Product::join('categories', 'categories.id', 'products.subcategory')
            ->where('categories.id', $this->id)
            ->select(
                'products.id as id',
                'products.cod as cod',
                'products.subcategory as subcategory',
                'products.group as group',
                'products.description as description',
                'products.application as application',
                'products.cover as cover'
            );
    }

    // retorna categoria da subcategoria atual
    public function parent()
    {
        return Category::where('id', $this->parent)->whereNull('parent');
    }

    // retorna subcategorias da categoria atual
    public function subcategories()
    {
        return Category::where('id', $this->id)->whereNotNull('parent');
    }

    // método de callback para exclusão em cascata
    public static function boot()
    {
        parent::boot();

        self::deleting(function (Category $category) {
            // remove produtos
            $category->products()->delete();

            // remove subcategorias
            $category->parent()->delete();
        });
    }
}
