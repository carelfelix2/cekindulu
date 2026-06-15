<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    public function run(): void
    {
        MembershipPlan::create([
            'name' => 'Mingguan',
            'slug' => 'mingguan',
            'price' => 15000,
            'duration_days' => 7,
            'description' => 'Coba fitur premium CekDulu selama 7 hari dengan harga terjangkau.',
            'features' => [
                'Price Alert: notifikasi harga turun',
                'Exclusive Deals: akses promo khusus',
                'Badge Premium Member',
                'Bandingkan hingga 10 produk',
            ],
            'is_active' => true,
        ]);

        MembershipPlan::create([
            'name' => 'Bulanan',
            'slug' => 'bulanan',
            'price' => 49000,
            'duration_days' => 30,
            'description' => 'Nikmati semua fitur premium selama sebulan penuh. Paling populer!',
            'features' => [
                'Price Alert: notifikasi harga turun',
                'Exclusive Deals: akses promo khusus',
                'Badge Premium Member',
                'Bandingkan hingga 10 produk',
                'Prioritas support',
            ],
            'is_active' => true,
        ]);

        MembershipPlan::create([
            'name' => 'Tahunan',
            'slug' => 'tahunan',
            'price' => 399000,
            'duration_days' => 365,
            'description' => 'Hemat lebih banyak dengan langganan tahunan. Hanya Rp33.250/bulan!',
            'features' => [
                'Price Alert: notifikasi harga turun',
                'Exclusive Deals: akses promo khusus',
                'Badge Premium Member',
                'Bandingkan hingga 10 produk',
                'Prioritas support',
                'Early access fitur baru',
                'Diskon 32% dibanding bulanan',
            ],
            'is_active' => true,
        ]);
    }
}
