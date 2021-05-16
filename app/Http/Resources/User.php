<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            // 'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'pdf_completo' => ($this->resource->pdf_completo == null ? null : asset('storage/' . $this->resource->pdf_completo)),
            'pdf_fixo' => asset('storage/' . $this->resource->pdf_fixo),
            // 'created_at' => $this->resource->created_at->format('d/m/Y'),
            // 'updated_at' => $this->resource->updated_at->format('d/m/Y'),
        ];
    }
}
