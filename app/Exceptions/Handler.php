<?php

namespace App\Exceptions;

use App\Exceptions\BadRequestException;
use App\Exceptions\ResourceNotFoundException;
use App\Http\Resources\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception): JsonResponse|\Illuminate\Http\Response
    {
        if ($exception instanceof ResourceNotFoundException) {
            return response()->json(
                ApiResponse::error($exception->getMessage(), 'RESOURCE_NOT_FOUND'),
                404
            );
        }

        if ($exception instanceof BadRequestException) {
            return response()->json(
                ApiResponse::error($exception->getMessage(), 'BAD_REQUEST'),
                400
            );
        }

        if ($exception instanceof ValidationException) {
            $errors = [];
            foreach ($exception->errors() as $field => $messages) {
                $errors[$field] = $messages[0];
            }
            return response()->json(
                ApiResponse::error('Validation failed', 'VALIDATION_ERROR'),
                400
            );
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json(
                ApiResponse::error('Invalid phone number or password', 'UNAUTHORIZED'),
                401
            );
        }

        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json(
                ApiResponse::error('Access denied', 'FORBIDDEN'),
                403
            );
        }

        return parent::render($request, $exception);
    }
}

