<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        Role::create(['name' => Role::ROLE_ADMIN]);
        Role::create(['name' => Role::ROLE_CUSTOMER]);

        // Create admin user
        $admin = User::create([
            'full_name' => 'Admin User',
            'phone' => '+1234567890',
            'email' => 'admin@foodordering.com',
            'password' => Hash::make('admin123'),
            'active' => true,
        ]);

        $adminRole = Role::where('name', Role::ROLE_ADMIN)->first();
        $admin->roles()->attach($adminRole->id);

        // Seed food items
        $this->call(FoodItemSeeder::class);
    }
}

