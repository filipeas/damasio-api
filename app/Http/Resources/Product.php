<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'category' => new Category($this->resource->categoryParent()->first()),
            'subcategory' => new Category($this->resource->category()->first()),
            'brands' => Brand::collection($this->resource->brands()->get()),
            'cover' => asset('storage' . $this->resource->cover),
            'description' => $this->resource->description,
            'application' => $this->resource->application,
            // 'created_at' => $this->resource->created_at->format('d/m/Y'),
            // 'updated_at' => $this->resource->updated_at->format('d/m/Y'),
        ];
    }
}
