<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'foodItemId' => $this->food_item_id,
            'userId' => $this->user_id,
            'userName' => $this->user->full_name,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'createdAt' => $this->created_at?->toIso8601String(),
            'updatedAt' => $this->updated_at?->toIso8601String(),
        ];
    }
}

