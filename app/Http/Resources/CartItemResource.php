<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'foodItemId' => $this->food_item_id,
            'foodItemName' => $this->foodItem->name,
            'foodItemImageUrl' => $this->foodItem->image_url,
            'foodItemPrice' => (string) $this->foodItem->price,
            'quantity' => $this->quantity,
            'subtotal' => (string) ($this->foodItem->price * $this->quantity),
            'createdAt' => $this->created_at?->toIso8601String(),
        ];
    }
}

