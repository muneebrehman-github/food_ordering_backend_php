<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('food_item_id')->constrained('food_items')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
            
            $table->index('cart_id');
            $table->index('food_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

