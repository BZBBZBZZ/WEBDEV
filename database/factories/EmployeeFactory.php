<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $firstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fajar', 'Gita', 'Hendra',
            'Indah', 'Joko', 'Kartika', 'Lina', 'Made', 'Nina', 'Oscar', 'Putri',
            'Rina', 'Sari', 'Tono', 'Udin', 'Vina', 'Wati', 'Yanto', 'Zaki'
        ];

        $lastNames = [
            'Pratama', 'Santoso', 'Wijaya', 'Kusuma', 'Permana', 'Saputra',
            'Lestari', 'Hidayat', 'Rahayu', 'Setiawan', 'Suryanto', 'Purnama'
        ];

        $positions = [
            'Head Baker',
            'Pastry Chef',
            'Sales Assistant',
            'Manager',
            'Assistant Baker',
            'Cashier',
            'Kitchen Helper',
            'Store Supervisor',
            'Bread Specialist',
            'Cake Decorator',
        ];

        $firstName = Arr::random($firstNames);
        $lastName = Arr::random($lastNames);
        $name = $firstName . ' ' . $lastName;

        return [
            'name' => $name,
            'position' => Arr::random($positions),
            'image' => "https://picsum.photos/seed/" . uniqid() . "/400/400",
        ];
    }
}
