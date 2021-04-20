<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Subcategory extends JsonResource
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
            'parent' => new Category($this->resource->parent()->first()),
            'title' => $this->resource->title,
            'created_at' => $this->resource->created_at->format('d/m/Y'),
            'updated_at' => $this->resource->updated_at->format('d/m/Y'),
        ];
    }
}
