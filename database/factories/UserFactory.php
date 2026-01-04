<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class UserFactory extends Factory
{
    protected $model = User::class;
    protected static ?string $password;

    public function definition(): array
    {
        $firstNames = ['Ahmad', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fajar', 'Gita', 'Hendra', 'Indah', 'Joko'];
        $lastNames = ['Pratama', 'Santoso', 'Wijaya', 'Kusuma', 'Permana', 'Saputra', 'Lestari', 'Hidayat', 'Rahayu', 'Setiawan'];
        
        $firstName = Arr::random($firstNames);
        $lastName = Arr::random($lastNames);
        $name = $firstName . ' ' . $lastName;
        $email = strtolower($firstName . '.' . $lastName . rand(1, 999) . '@example.com');

        return [
            'name' => $name,
            'email' => $email,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'user',
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
