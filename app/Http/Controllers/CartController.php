<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function addToCart(AddToCartRequest $request): JsonResponse
    {
        $cart = $this->cartService->addToCart($request->validated());
        return response()->json(
            ApiResponse::success(new CartResource($cart), 'Item added to cart'),
            201
        );
    }

    public function getCart(): JsonResponse
    {
        $cart = $this->cartService->getCart();
        return response()->json(
            ApiResponse::success(new CartResource($cart))
        );
    }

    public function removeCartItem(int $itemId): JsonResponse
    {
        $this->cartService->removeCartItem($itemId);
        return response()->json(
            ApiResponse::success(null, 'Item removed from cart')
        );
    }
}

