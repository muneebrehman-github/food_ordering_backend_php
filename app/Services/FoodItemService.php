<?php

namespace App\Services;

use App\Models\FoodItem;
use App\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Facades\DB;

class FoodItemService
{
    public function getAllFoodItems(int $page = 0, int $size = 20)
    {
        return FoodItem::where('active', true)
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], 'page', $page + 1);
    }

    public function getFoodItemById(int $id): FoodItem
    {
        $foodItem = FoodItem::find($id);
        
        if (!$foodItem || !$foodItem->active) {
            throw new ResourceNotFoundException('Food item not found with id: ' . $id);
        }

        return $foodItem;
    }

    public function getFeaturedFoodItems(): array
    {
        return FoodItem::where('featured', true)
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    public function getTopRatedFoodItems(int $page = 0, int $size = 10): array
    {
        return FoodItem::select('food_items.*')
            ->leftJoin('reviews', 'food_items.id', '=', 'reviews.food_item_id')
            ->where('food_items.active', true)
            ->groupBy('food_items.id')
            ->orderByRaw('AVG(reviews.rating) DESC')
            ->skip($page * $size)
            ->take($size)
            ->get()
            ->toArray();
    }
}

