<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'Product Name' => $this->name,
            'Description' => $this->description,
            'Price' => $this->price,
            'Category' => new CategoryResource($this->category),
            'created at' => $this->created_at->format('Y-m-d H:i:s'),
            
        ];
    }
}
