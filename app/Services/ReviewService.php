<?php

namespace App\Services;

use App\Models\Review;
use App\Models\FoodItem;
use App\Exceptions\BadRequestException;
use App\Exceptions\ResourceNotFoundException;

class ReviewService
{
    public function getReviewsByFoodItemId(int $foodItemId, int $page = 0, int $size = 10)
    {
        return Review::with('user')
            ->where('food_item_id', $foodItemId)
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], 'page', $page + 1);
    }

    public function createReview(int $foodItemId, array $data): Review
    {
        $user = auth()->user();
        $foodItem = FoodItem::find($foodItemId);

        if (!$foodItem || !$foodItem->active) {
            throw new ResourceNotFoundException('Food item not found with id: ' . $foodItemId);
        }

        if (Review::where('food_item_id', $foodItemId)
            ->where('user_id', $user->id)
            ->exists()) {
            throw new BadRequestException('You have already reviewed this food item');
        }

        return Review::create([
            'food_item_id' => $foodItemId,
            'user_id' => $user->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ])->load('user');
    }
}

