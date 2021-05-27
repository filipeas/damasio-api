<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryOnly extends JsonResource
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
            'title' => $this->resource->title,
            'cover' => (is_null($this->resource->productsOfSubcategory()->skip(1)->first()) ? (is_null($this->resource->productsOfSubcategory()->first()->cover) ? null : asset('storage/' . $this->resource->productsOfSubcategory()->first()->cover)) : asset('storage/' . $this->resource->productsOfSubcategory()->skip(1)->first()->cover)),
            'created_at' => $this->resource->created_at->format('d/m/Y'),
            'updated_at' => $this->resource->updated_at->format('d/m/Y'),
        ];
    }
}
