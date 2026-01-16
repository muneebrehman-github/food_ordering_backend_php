<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    private bool $success;
    private ?string $message;
    private $data;
    private ?string $errorCode;

    public function __construct($data = null, bool $success = true, ?string $message = null, ?string $errorCode = null)
    {
        $this->success = $success;
        $this->message = $message ?? ($success ? 'Success' : 'Error');
        $this->data = $data;
        $this->errorCode = $errorCode;
    }

    public static function success($data = null, ?string $message = null): self
    {
        return new self($data, true, $message);
    }

    public static function error(string $message, ?string $errorCode = null): self
    {
        return new self(null, false, $message, $errorCode);
    }

    public function toArray($request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'timestamp' => now()->toIso8601String(),
            'errorCode' => $this->errorCode,
        ];
    }
}

