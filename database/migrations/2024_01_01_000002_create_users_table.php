<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('phone', 20)->unique();
            $table->string('email', 100)->nullable()->unique();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->timestamps();
            
            $table->index('phone');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

