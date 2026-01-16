<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->string('description', 1000)->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image_url', 500)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->integer('stock_quantity')->default(0);
            $table->string('category', 50)->nullable();
            $table->timestamps();
            
            $table->index('featured');
            $table->index('active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};

