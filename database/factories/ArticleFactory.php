<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = fake()->unique()->randomElement([
            '10 Laptop Terbaik di Bawah 10 Juta Tahun 2026',
            'Rekomendasi Gaming Mouse Terbaik untuk Pro Player',
            'SSD Tercepat 2026: NVMe Gen 5 Mana yang Worth It?',
            'Panduan Memilih Mechanical Keyboard untuk Pemula',
            'Best Smartphone Flagship 2026: Mana Paling Worth It?',
            'Monitor 4K Terbaik untuk Desainer dan Editor Video',
            'Tips Memilih Earbuds TWS: Dari Budget Sampai Premium',
            'Perbandingan Prosesor Intel vs AMD untuk Gaming 2026',
            'Rekomendasi Smartwatch Olahraga Terbaik',
            'Kamera Mirrorless Terjangkau untuk Content Creator',
            'Panduan Lengkap Membangun PC Gaming 2026',
            'Best Tablet untuk Mahasiswa dan Pekerja Kreatif',
            'Rekomendasi Headphone Wireless Noise Cancelling',
            'Komparasi GPU: RTX 4070 vs RX 7800 XT, Mana Lebih Worth It?',
            'Tips Memilih Monitor Gaming 144Hz Murah',
            'Rekomendasi Printer untuk Usaha Kecil dan Kantor',
            'Routers Terbaik untuk Gaming Online Stabil',
            'Perbandingan Samsung Galaxy S25 Series: Mana yang Cocok?',
            'Rekomendasi Speaker Bluetooth Outdoor Terbaik',
            'iPhone 16 vs iPhone 16 Pro: Apakah Worth It Upgrade?',
            'Panduan Memilih RAM DDR5 untuk PC Gaming',
            'Best Laptop untuk Programmer 2026',
            'Rekomendasi Power Bank Besar Kapasitas 20000mAh+',
            'Tips Memilih Kamera untuk Live Streaming',
            'Perbandingan iPad Pro vs Samsung Galaxy Tab S10 Ultra',
            'Rekomendasi Webcam untuk WFH dan Meeting Online',
            'Panduan Setup Work From Home yang Produktif',
            'Best Earphone Gaming di Bawah 500 Ribu',
            'Komparasi NVIDIA RTX 4060 vs RTX 4060 Ti, Mana Lebih Worth It?',
            'Rekomendasi Laptop Gaming 20 Jutaan Terbaik 2026',
        ]);

        $excerpts = [
            'Mencari laptop baru tapi bingung pilih yang mana? Kami sudah menguji 10 laptop terbaik di bawah 10 juta untuk membantu kamu.',
            'Buat kamu yang serius main game, mouse yang tepat bisa bikin performa makin maksimal. Ini dia rekomendasi terbaiknya.',
            'SSD Gen 5 sudah mulai turun harga. Tapi apakah benar-benar worth it dibanding Gen 4? Simak analisis lengkapnya.',
            'Dari Cherry MX sampai Gateron, dari 60% sampai Full Size. Panduan ini bakal bikin kamu paham semua opsi mechanical keyboard.',
            'Tiga flagship teratas tahun ini bersaing ketat. Kami breakdown kelebihan dan kekurangan masing-masing.',
            'Monitor 4K bukan cuma buat desainer. Tapi mana yang paling worth it untuk kebutuhan spesifik kamu? Yuk kita bahas.',
            'Dari budget 200 ribuan sampai 2 jutaan, kami punya rekomendasi earbuds TWS terbaik di setiap kelas harga.',
            'Intel vs AMD udah jadi perdebatan abadi. Tapi untuk gaming di 2026, mana yang sebenarnya lebih unggul?',
            'Smartwatch sekarang bukan cuma buat notifikasi. Buat olahraga, fitur apa aja yang wajib ada?',
            'Content creator pemula wajib punya kamera yang tepat. Ini dia rekomendasi mirrorless terjangkau terbaik.',
        ];

        $content = fake()->randomElement($excerpts) . "\n\n" .
            implode("\n\n", [
                "## Pendahuluan\n" . fake()->paragraph(fake()->numberBetween(2, 4)),
                "## Kriteria Pemilihan\n" . fake()->paragraph(fake()->numberBetween(3, 5)),
                "## Daftar Rekomendasi\n" . fake()->paragraph(fake()->numberBetween(3, 5)),
                "## Analisis Detail\n" . fake()->paragraph(fake()->numberBetween(4, 6)),
                "## Perbandingan Harga\n" . fake()->paragraph(fake()->numberBetween(2, 4)),
                "## Kesimpulan\n" . fake()->paragraph(fake()->numberBetween(2, 3)),
            ]);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'title' => $title,
            'slug' => fn(array $a) => str($a['title'])->slug(),
            'excerpt' => fake()->randomElement($excerpts),
            'content' => $content,
            'featured_image' => 'https://picsum.photos/seed/' . fake()->uuid() . '/1200/630',
            'seo_title' => fn(array $a) => $a['title'],
            'meta_description' => fn(array $a) => $a['excerpt'],
            'status' => 'published',
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
