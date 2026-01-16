<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\FoodItem;
use App\Exceptions\BadRequestException;
use App\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function addToCart(array $data): Cart
    {
        $user = auth()->user();
        $foodItem = FoodItem::findOrFail($data['foodItemId']);

        if (!$foodItem->active) {
            throw new BadRequestException('Food item is not available');
        }

        if ($foodItem->stock_quantity < $data['quantity']) {
            throw new BadRequestException('Insufficient stock. Available: ' . $foodItem->stock_quantity);
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('food_item_id', $foodItem->id)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $data['quantity'];
            if ($foodItem->stock_quantity < $newQuantity) {
                throw new BadRequestException('Insufficient stock. Available: ' . $foodItem->stock_quantity);
            }
            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'food_item_id' => $foodItem->id,
                'quantity' => $data['quantity'],
            ]);
        }

        return $this->getCart();
    }

    public function getCart(): Cart
    {
        $user = auth()->user();
        $cart = Cart::with(['items.foodItem'])->firstOrCreate(['user_id' => $user->id]);

        $totalAmount = 0;
        $totalItems = 0;

        foreach ($cart->items as $item) {
            $totalAmount += $item->foodItem->price * $item->quantity;
            $totalItems += $item->quantity;
        }

        $cart->total_amount = $totalAmount;
        $cart->total_items = $totalItems;

        return $cart;
    }

    public function removeCartItem(int $itemId): void
    {
        $user = auth()->user();
        $cartItem = CartItem::with('cart')->findOrFail($itemId);

        if ($cartItem->cart->user_id !== $user->id) {
            throw new BadRequestException("You don't have permission to remove this item");
        }

        $cartItem->delete();
    }
}

