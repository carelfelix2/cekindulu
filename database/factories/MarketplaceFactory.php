<?php

namespace Database\Factories;

use App\Models\Marketplace;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketplaceFactory extends Factory
{
    protected $model = Marketplace::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Shopee', 'Tokopedia', 'Lazada', 'Blibli', 'Bukalapak',
            ]),
            'slug' => fn(array $a) => str($a['name'])->slug(),
            'logo' => fn(array $a) => 'https://placehold.co/120x40/1a1a2e/ffffff?text=' . urlencode($a['name']),
            'base_url' => fn(array $a) => 'https://www.' . strtolower($a['name']) . '.co.id/',
            'is_active' => true,
        ];
    }
}
