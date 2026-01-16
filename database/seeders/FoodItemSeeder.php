<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use Illuminate\Database\Seeder;

class FoodItemSeeder extends Seeder
{
    public function run(): void
    {
        $foodItems = [
            ['name' => 'Margherita Pizza', 'description' => 'Classic pizza with tomato sauce, mozzarella, and fresh basil', 'price' => 12.99, 'image_url' => 'https://example.com/pizza-margherita.jpg', 'active' => true, 'featured' => true, 'stock_quantity' => 50, 'category' => 'Pizza'],
            ['name' => 'Pepperoni Pizza', 'description' => 'Traditional pizza with pepperoni and mozzarella cheese', 'price' => 14.99, 'image_url' => 'https://example.com/pizza-pepperoni.jpg', 'active' => true, 'featured' => true, 'stock_quantity' => 45, 'category' => 'Pizza'],
            ['name' => 'Chicken Burger', 'description' => 'Juicy grilled chicken breast with lettuce, tomato, and special sauce', 'price' => 9.99, 'image_url' => 'https://example.com/burger-chicken.jpg', 'active' => true, 'featured' => true, 'stock_quantity' => 60, 'category' => 'Burgers'],
            ['name' => 'Beef Burger', 'description' => 'Classic beef patty with cheese, pickles, and onions', 'price' => 10.99, 'image_url' => 'https://example.com/burger-beef.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 55, 'category' => 'Burgers'],
            ['name' => 'Caesar Salad', 'description' => 'Fresh romaine lettuce with caesar dressing, croutons, and parmesan', 'price' => 8.99, 'image_url' => 'https://example.com/salad-caesar.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 40, 'category' => 'Salads'],
            ['name' => 'Greek Salad', 'description' => 'Mixed greens with feta cheese, olives, and olive oil dressing', 'price' => 9.49, 'image_url' => 'https://example.com/salad-greek.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 35, 'category' => 'Salads'],
            ['name' => 'Chicken Wings', 'description' => 'Crispy fried chicken wings with your choice of sauce', 'price' => 11.99, 'image_url' => 'https://example.com/wings.jpg', 'active' => true, 'featured' => true, 'stock_quantity' => 70, 'category' => 'Appetizers'],
            ['name' => 'French Fries', 'description' => 'Golden crispy french fries served with ketchup', 'price' => 4.99, 'image_url' => 'https://example.com/fries.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 100, 'category' => 'Sides'],
            ['name' => 'Onion Rings', 'description' => 'Battered and fried onion rings', 'price' => 5.99, 'image_url' => 'https://example.com/onion-rings.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 80, 'category' => 'Sides'],
            ['name' => 'Chocolate Cake', 'description' => 'Rich chocolate layer cake with frosting', 'price' => 6.99, 'image_url' => 'https://example.com/cake-chocolate.jpg', 'active' => true, 'featured' => true, 'stock_quantity' => 30, 'category' => 'Desserts'],
            ['name' => 'Cheesecake', 'description' => 'New York style cheesecake with berry topping', 'price' => 7.99, 'image_url' => 'https://example.com/cheesecake.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 25, 'category' => 'Desserts'],
            ['name' => 'Ice Cream Sundae', 'description' => 'Vanilla ice cream with hot fudge and whipped cream', 'price' => 5.99, 'image_url' => 'https://example.com/sundae.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 50, 'category' => 'Desserts'],
            ['name' => 'Coca Cola', 'description' => 'Refreshing cola drink', 'price' => 2.99, 'image_url' => 'https://example.com/coke.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 200, 'category' => 'Beverages'],
            ['name' => 'Orange Juice', 'description' => 'Fresh squeezed orange juice', 'price' => 3.49, 'image_url' => 'https://example.com/oj.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 150, 'category' => 'Beverages'],
            ['name' => 'Coffee', 'description' => 'Hot brewed coffee', 'price' => 2.49, 'image_url' => 'https://example.com/coffee.jpg', 'active' => true, 'featured' => false, 'stock_quantity' => 180, 'category' => 'Beverages'],
        ];

        foreach ($foodItems as $item) {
            FoodItem::create($item);
        }
    }
}

