<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReviewRequest;
use App\Http\Resources\ApiResponse;
use App\Http\Resources\ReviewResource;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $reviewService)
    {
    }

    public function getReviews(int $foodItemId, Request $request): JsonResponse
    {
        $page = (int) $request->get('page', 0);
        $size = (int) $request->get('size', 10);
        
        $reviews = $this->reviewService->getReviewsByFoodItemId($foodItemId, $page, $size);
        $resources = ReviewResource::collection($reviews->items());
        
        return response()->json(
            ApiResponse::success([
                'content' => $resources,
                'totalElements' => $reviews->total(),
                'totalPages' => $reviews->lastPage(),
                'size' => $reviews->perPage(),
                'number' => $reviews->currentPage() - 1,
            ])
        );
    }

    public function createReview(int $foodItemId, CreateReviewRequest $request): JsonResponse
    {
        $review = $this->reviewService->createReview($foodItemId, $request->validated());
        return response()->json(
            ApiResponse::success(new ReviewResource($review), 'Review created successfully'),
            201
        );
    }
}

