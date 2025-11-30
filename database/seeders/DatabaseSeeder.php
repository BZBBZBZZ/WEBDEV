<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'BZBBZBZZ',
            'email' => 'nicholasleroy83@gmail.com',
            'password' => Hash::make('qwerty123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::factory(30)->create();

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            EmployeeSeeder::class,
            PromoSeeder::class,
            LocationSeeder::class,
            CustomOrderSeeder::class,
        ]);
    }
}