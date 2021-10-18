<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithoutSubCategories extends JsonResource
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
            'pdf' => ($this->resource->pdf == null ? null : asset('storage/' . $this->resource->pdf)),
            'propaganda' => ($this->resource->propaganda == null ? null : asset('storage/' . $this->resource->propaganda)),
            'title_color' => ($this->resource->title_color == null ? null : $this->resource->title_color),
            'color' => ($this->resource->color == null ? null : $this->resource->color),
            'model' => $this->resource->model,
            'cover' => (is_null($this->resource->productsOfCategory()->first()) ? null : asset('storage/' . $this->resource->productsOfCategory()->first()->cover)),
            // 'subcategories' => SubcategoryOnly::collection($this->resource->subcategories()->orderBy('title', 'ASC')->get()),
            'created_at' => $this->resource->created_at->format('d/m/Y'),
            'updated_at' => $this->resource->updated_at->format('d/m/Y'),
        ];
    }
}
