<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'email' => 'admin@example.com',
            'username' => 'Admin',
            'password' => Hash::make('password'),
            'roles' => 'Admin'
        ]);
        User::factory()->create([
            'email' => 'kasir@example.com',
            'username' => 'Kasir',
            'password' => Hash::make('password'),
            'roles' => 'Cashier'
        ]);
        User::factory()->create([
            'email' => 'pelanggan@example.com',
            'username' => 'Pelanggan',
            'password' => Hash::make('password'),
            'roles' => 'Guest'
        ]);

        Category::factory()->create([
            'name' => 'Makanan',
            'slug' => 'minuman',
            'description' => 'Makanan Berat & Ringan'
        ]);
        Category::factory()->create([
            'name' => 'Minuman',
            'slug' => 'minuman',
            'description' => 'Minuman Berat & Ringan'
        ]);

        \App\Models\Supplier::factory(3)->create();
        \App\Models\Product::factory(10)->create();
    }
}
