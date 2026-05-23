<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'name' => $this->name,

            'description_short' => $this->description_short,

            'description_long' => $this->description_long,

            'price' => (float) $this->price,

            'stock' => $this->stock,

            'image_url' => $this->image
                ? asset('storage/' . $this->image)
                : null,

            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name
            ],

            'sizes' => $this->sizes->map(function ($size) {

                return [
                    'id' => $size->id,
                    'name' => $size->name_size
                ];
            }),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s')
        ];
    }
}
