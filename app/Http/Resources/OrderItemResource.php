<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'foodItemId' => $this->food_item_id,
            'foodItemName' => $this->foodItem->name,
            'foodItemImageUrl' => $this->foodItem->image_url,
            'quantity' => $this->quantity,
            'unitPrice' => (string) $this->unit_price,
            'subtotal' => (string) $this->subtotal,
        ];
    }
}

