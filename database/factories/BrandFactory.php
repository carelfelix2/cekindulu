<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Apple', 'Samsung', 'Xiaomi', 'ASUS', 'Acer', 'Lenovo', 'MSI', 'HP', 'Dell', 'LG',
                'Sony', 'Logitech', 'Corsair', 'SteelSeries', 'Razer', 'Anker', 'Ugreen', 'Kingston', 'SanDisk', 'TP-Link',
                'D-Link', 'Canon', 'Nikon', 'Epson', 'Brother', 'WD', 'Seagate', 'Intel', 'AMD', 'NVIDIA',
                'Gigabyte', 'ASRock', 'ZOTAC', 'Cooler Master', 'Noctua', 'be quiet!', 'Fractal Design', 'NZXT', 'Lian Li', 'Thermaltake',
                'ViewSonic', 'BenQ', 'Philips', 'Polytron', 'Sharp', 'Panasonic', 'Miyako', 'Maspion', 'Oxone', 'Cosmos',
            ]),
            'slug' => fn(array $a) => str($a['name'])->slug(),
            'logo' => fn(array $a) => 'https://placehold.co/200x80/1a1a2e/ffffff?text=' . urlencode($a['name']),
            'description' => fn(array $a) => "{$a['name']} adalah brand ternama yang menyediakan produk berkualitas tinggi. Temukan rekomendasi dan harga terbaik produk {$a['name']} hanya di CekDulu.",
        ];
    }
}
