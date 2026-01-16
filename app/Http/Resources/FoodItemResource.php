<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (string) $this->price,
            'imageUrl' => $this->image_url,
            'active' => $this->active,
            'featured' => $this->featured,
            'stockQuantity' => $this->stock_quantity,
            'category' => $this->category,
            'averageRating' => $this->average_rating,
            'reviewCount' => $this->review_count,
            'createdAt' => $this->created_at?->toIso8601String(),
            'updatedAt' => $this->updated_at?->toIso8601String(),
        ];
    }
}

