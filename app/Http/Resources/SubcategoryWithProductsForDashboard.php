<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryWithProductsForDashboard extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($request->has('search')) {
            $products = $this->resource->productsOfSubcategory()
                ->where('products.description', 'like', '%' . $request->search . '%')
                ->orWhere('products.application', 'LIKE', '%' . $request->search . '%')
                ->paginate(15);
            $products->setPath(env('APP_URL') . "/usuario/subcategoria/{$this->resource->id}/visualizar?search={$request->search}");
        } else {
            $products = $this->resource->productsOfSubcategory()->paginate(15);
            $products->setPath(env('APP_URL') . "/usuario/subcategoria/{$this->resource->id}/visualizar");
        }

        return [
            'id' => $this->resource->id,
            'category' => new CategoryWithoutSubCategories($this->resource->parent()->first()),
            'title' => $this->resource->title,
            'products' => Product::collection($products),
            'pagination' => [
                'links' => (string) $products->links(),
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
