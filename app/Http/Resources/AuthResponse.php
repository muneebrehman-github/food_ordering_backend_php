<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResponse extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'token' => $this->resource['token'],
            'type' => $this->resource['type'] ?? 'Bearer',
            'id' => $this->resource['id'],
            'fullName' => $this->resource['fullName'],
            'phone' => $this->resource['phone'],
            'email' => $this->resource['email'],
            'roles' => $this->resource['roles'],
        ];
    }
}

