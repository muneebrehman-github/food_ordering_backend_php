<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_item_id')->constrained('food_items')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating');
            $table->string('comment', 1000)->nullable();
            $table->timestamps();
            
            $table->index('food_item_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

