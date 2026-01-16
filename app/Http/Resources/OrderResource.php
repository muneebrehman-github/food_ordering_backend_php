<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'orderNumber' => $this->order_number,
            'userId' => $this->user_id,
            'userName' => $this->user->full_name,
            'items' => OrderItemResource::collection($this->items),
            'totalAmount' => (string) $this->total_amount,
            'status' => $this->status,
            'deliveryAddress' => $this->delivery_address,
            'phone' => $this->phone,
            'notes' => $this->notes,
            'createdAt' => $this->created_at?->toIso8601String(),
            'updatedAt' => $this->updated_at?->toIso8601String(),
        ];
    }
}

