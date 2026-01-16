<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Http\Resources\OrderResource;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(private AdminService $adminService)
    {
    }

    public function getDashboard(): JsonResponse
    {
        $dashboard = $this->adminService->getDashboard();
        return response()->json(
            ApiResponse::success($dashboard)
        );
    }

    public function getAllOrders(Request $request): JsonResponse
    {
        $page = (int) $request->get('page', 0);
        $size = (int) $request->get('size', 20);
        
        $orders = $this->adminService->getAllOrders($page, $size);
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

    public function getDailyReport(): JsonResponse
    {
        $reports = $this->adminService->getDailyReport();
        return response()->json(
            ApiResponse::success($reports)
        );
    }

    public function getWeeklyReport(): JsonResponse
    {
        $reports = $this->adminService->getWeeklyReport();
        return response()->json(
            ApiResponse::success($reports)
        );
    }

    public function getMonthlyReport(): JsonResponse
    {
        $reports = $this->adminService->getMonthlyReport();
        return response()->json(
            ApiResponse::success($reports)
        );
    }

    public function getProfitLossReport(): JsonResponse
    {
        $report = $this->adminService->getProfitLossReport();
        return response()->json(
            ApiResponse::success($report)
        );
    }
}

