<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\FoodItem;
use App\Exceptions\BadRequestException;
use App\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder(array $data): Order
    {
        $user = auth()->user();
        $cart = Cart::with('items.foodItem')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new BadRequestException('Cart is empty');
        }

        $order = Order::create([
            'order_number' => $this->generateOrderNumber(),
            'user_id' => $user->id,
            'status' => Order::STATUS_PENDING,
            'delivery_address' => $data['deliveryAddress'] ?? null,
            'phone' => $data['phone'] ?? $user->phone,
            'notes' => $data['notes'] ?? null,
            'total_amount' => 0,
        ]);

        $totalAmount = 0;

        foreach ($cart->items as $cartItem) {
            $foodItem = $cartItem->foodItem;

            if (!$foodItem->active) {
                throw new BadRequestException('Food item ' . $foodItem->name . ' is no longer available');
            }

            if ($foodItem->stock_quantity < $cartItem->quantity) {
                throw new BadRequestException('Insufficient stock for ' . $foodItem->name . '. Available: ' . $foodItem->stock_quantity);
            }

            $subtotal = $foodItem->price * $cartItem->quantity;
            $totalAmount += $subtotal;

            OrderItem::create([
                'order_id' => $order->id,
                'food_item_id' => $foodItem->id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $foodItem->price,
                'subtotal' => $subtotal,
            ]);

            $foodItem->decrement('stock_quantity', $cartItem->quantity);
        }

        $order->update(['total_amount' => $totalAmount]);
        CartItem::where('cart_id', $cart->id)->delete();

        return $order->load(['items.foodItem', 'user']);
    }

    public function getMyOrders(int $page = 0, int $size = 20)
    {
        $user = auth()->user();
        return Order::with(['items.foodItem', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], 'page', $page + 1);
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(Str::random(8)) . '-' . (time() % 100000);
    }
}

