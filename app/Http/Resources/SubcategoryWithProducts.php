<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryWithProducts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $products = $this->resource->productsOfSubcategory()->paginate(15);
        return [
            'id' => $this->resource->id,
            'category' => new CategoryWithSubCategories($this->resource->parent()->first()),
            'title' => $this->resource->title,
            'products' => Product::collection($products),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'last_page_url' => $products->previousPageUrl(),
                'next_page_url' => $products->nextPageUrl(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ];
    }
}
