<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Paket gratis dengan fitur dasar',
                'price' => 0,
                'duration_days' => 365,
                'features' => [
                    'Akses produk terbatas',
                    'Perbandingan hingga 2 produk',
                    'Artikel gratis',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Premium Monthly',
                'slug' => 'premium-monthly',
                'description' => 'Paket bulanan dengan semua fitur premium',
                'price' => 49000,
                'duration_days' => 30,
                'features' => [
                    'Akses semua produk',
                    'Perbandingan hingga 5 produk',
                    'Price alert & notifikasi',
                    'Analitik mendalam',
                    'Diskon eksklusif',
                    'Prioritas customer support',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Premium Yearly',
                'slug' => 'premium-yearly',
                'description' => 'Paket tahunan hemat hingga 32%',
                'price' => 399000,
                'duration_days' => 365,
                'features' => [
                    'Akses semua produk',
                    'Perbandingan hingga 5 produk',
                    'Price alert & notifikasi',
                    'Analitik mendalam',
                    'Diskon eksklusif',
                    'Prioritas customer support',
                    'Hemat Rp 189.000',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            MembershipPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }

        $this->command->info('✓ Membership plans seeded successfully!');
    }
}
