<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function createOrder(CreateOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->validated());
        return response()->json(
            ApiResponse::success(new OrderResource($order), 'Order created successfully'),
            201
        );
    }

    public function getMyOrders(Request $request): JsonResponse
    {
        $page = (int) $request->get('page', 0);
        $size = (int) $request->get('size', 20);
        
        $orders = $this->orderService->getMyOrders($page, $size);
        $resources = OrderResource::collection($orders->items());
        
        return response()->json(
            ApiResponse::success([
                'content' => $resources,
                'totalElements' => $orders->total(),
                'totalPages' => $orders->lastPage(),
                'size' => $orders->perPage(),
                'number' => $orders->currentPage() - 1,
            ])
        );
    }
}

