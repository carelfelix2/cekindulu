<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Laptop', 'Smartphone', 'Tablet', 'Monitor', 'Keyboard',
                'Mouse', 'Headphone', 'Earbuds', 'Smartwatch', 'Gaming',
                'Camera', 'Printer', 'Networking', 'SSD', 'RAM',
                'Processor', 'GPU', 'Office', 'Home Appliance', 'Accessories',
            ]),
            'slug' => fn(array $a) => str($a['name'])->slug(),
            'icon' => fn(array $a) => match ($a['name']) {
                'Laptop' => 'laptop', 'Smartphone' => 'smartphone', 'Tablet' => 'tablet',
                'Monitor' => 'monitor', 'Keyboard' => 'keyboard', 'Mouse' => 'mouse',
                'Headphone' => 'headphones', 'Earbuds' => 'earbuds', 'Smartwatch' => 'watch',
                'Gaming' => 'gamepad-2', 'Camera' => 'camera', 'Printer' => 'printer',
                'Networking' => 'wifi', 'SSD' => 'hard-drive', 'RAM' => 'memory-stick',
                'Processor' => 'cpu', 'GPU' => 'gpu', 'Office' => 'briefcase',
                'Home Appliance' => 'refrigerator', 'Accessories' => 'cable',
                default => 'package',
            }),
            'description' => fn(array $a) => "Kategori {$a['name']} - Temukan rekomendasi {$a['name']} terbaik dan termurah di CekDulu.",
            'is_active' => true,
        ];
    }
}
