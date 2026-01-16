<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Http\Resources\FoodItemResource;
use App\Services\FoodItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function __construct(private FoodItemService $foodItemService)
    {
    }

    public function getAllFoodItems(Request $request): JsonResponse
    {
        $page = (int) $request->get('page', 0);
        $size = (int) $request->get('size', 20);
        
        $foodItems = $this->foodItemService->getAllFoodItems($page, $size);
        $resources = FoodItemResource::collection($foodItems->items());
        
        return response()->json(
            ApiResponse::success([
                'content' => $resources,
                'totalElements' => $foodItems->total(),
                'totalPages' => $foodItems->lastPage(),
                'size' => $foodItems->perPage(),
                'number' => $foodItems->currentPage() - 1,
            ])
        );
    }

    public function getFoodItemById(int $id): JsonResponse
    {
        $foodItem = $this->foodItemService->getFoodItemById($id);
        return response()->json(
            ApiResponse::success(new FoodItemResource($foodItem))
        );
    }

    public function getFeaturedFoodItems(): JsonResponse
    {
        $foodItems = $this->foodItemService->getFeaturedFoodItems();
        return response()->json(
            ApiResponse::success(FoodItemResource::collection($foodItems))
        );
    }

    public function getTopRatedFoodItems(Request $request): JsonResponse
    {
        $page = (int) $request->get('page', 0);
        $size = (int) $request->get('size', 10);
        
        $foodItems = $this->foodItemService->getTopRatedFoodItems($page, $size);
        return response()->json(
            ApiResponse::success(FoodItemResource::collection($foodItems))
        );
    }
}

