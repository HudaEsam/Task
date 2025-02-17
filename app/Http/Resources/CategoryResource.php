<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        {
            return [
                'id' => $this->id,
                'Category_name' => $this->name,
                'Description' => $this->description,
                'created at' => $this->created_at->format('Y-m-d H:i:s'),

            ];
    }
    }
}
