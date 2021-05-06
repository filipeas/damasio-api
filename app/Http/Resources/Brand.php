<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Brand extends JsonResource
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
            'code' => $this->resource->code,
            'title' => $this->resource->title,
            'image' => asset('storage/' . $this->resource->image),
            // 'created_at' => $this->resource->created_at->format('d/m/Y'),
            // 'updated_at' => $this->resource->updated_at->format('d/m/Y'),
        ];
    }
}
