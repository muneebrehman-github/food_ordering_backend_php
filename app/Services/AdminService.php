<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\FoodItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminService
{
    public function getDashboard(): array
    {
        $now = Carbon::now();
        $startOfDay = $now->copy()->startOfDay();

        return [
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', Order::STATUS_PENDING)
                ->whereBetween('created_at', [$startOfDay, $now])
                ->count(),
            'completedOrders' => Order::where('status', Order::STATUS_DELIVERED)
                ->whereBetween('created_at', [$startOfDay, $now])
                ->count(),
            'totalRevenue' => (string) Order::where('status', Order::STATUS_DELIVERED)
                ->whereBetween('created_at', [$startOfDay, $now])
                ->sum('total_amount') ?? '0.00',
            'totalCustomers' => User::count(),
            'totalFoodItems' => FoodItem::count(),
            'activeFoodItems' => FoodItem::where('active', true)->count(),
        ];
    }

    public function getAllOrders(int $page = 0, int $size = 20)
    {
        return Order::with(['items.foodItem', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], 'page', $page + 1);
    }

    public function getDailyReport(): array
    {
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(30);
        $reports = [];

        for ($date = $startDate->copy(); $date->lte($today); $date->addDay()) {
            $start = $date->copy()->startOfDay();
            $end = $date->copy()->endOfDay();

            $reports[] = $this->generateReport($start, $end, $date->toDateString());
        }

        return $reports;
    }

    public function getWeeklyReport(): array
    {
        $today = Carbon::today();
        $startDate = $today->copy()->subWeeks(12);
        $reports = [];

        for ($date = $startDate->copy(); $date->lte($today); $date->addWeek()) {
            $weekEnd = $date->copy()->addDays(6);
            if ($weekEnd->gt($today)) {
                $weekEnd = $today->copy();
            }

            $start = $date->copy()->startOfDay();
            $end = $weekEnd->copy()->endOfDay();

            $reports[] = $this->generateReport($start, $end, $date->toDateString());
        }

        return $reports;
    }

    public function getMonthlyReport(): array
    {
        $today = Carbon::today();
        $startDate = $today->copy()->subMonths(12);
        $reports = [];

        for ($date = $startDate->copy(); $date->lte($today); $date->addMonth()) {
            $monthEnd = $date->copy()->endOfMonth();
            if ($monthEnd->gt($today)) {
                $monthEnd = $today->copy();
            }

            $start = $date->copy()->startOfDay();
            $end = $monthEnd->copy()->endOfDay();

            $reports[] = $this->generateReport($start, $end, $date->toDateString());
        }

        return $reports;
    }

    public function getProfitLossReport(): array
    {
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(30);
        $start = $startDate->copy()->startOfDay();
        $end = $today->copy()->endOfDay();

        $totalRevenue = (float) Order::where('status', Order::STATUS_DELIVERED)
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_amount') ?? 0.0;

        $totalCost = $this->calculateTotalCost($start, $end);
        $grossProfit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0;

        return [
            'totalRevenue' => (string) $totalRevenue,
            'totalCost' => (string) $totalCost,
            'grossProfit' => (string) $grossProfit,
            'profitMargin' => (string) round($profitMargin, 2),
            'dailyBreakdown' => $this->getDailyReport(),
        ];
    }

    private function generateReport(Carbon $start, Carbon $end, string $date): array
    {
        $totalOrders = Order::whereBetween('created_at', [$start, $end])->count();
        $totalRevenue = (float) Order::where('status', Order::STATUS_DELIVERED)
            ->whereBetween('created_at', [$start, $end])
            ->sum('total_amount') ?? 0.0;
        $totalCost = $this->calculateTotalCost($start, $end);

        return [
            'date' => $date,
            'totalOrders' => $totalOrders,
            'totalRevenue' => (string) $totalRevenue,
            'totalCost' => (string) $totalCost,
            'profit' => (string) ($totalRevenue - $totalCost),
            'totalItemsSold' => 0,
        ];
    }

    private function calculateTotalCost(Carbon $start, Carbon $end): float
    {
        return 0.0;
    }
}

