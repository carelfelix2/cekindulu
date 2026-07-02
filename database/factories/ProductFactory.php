<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    private static array $productNames = [
        'Laptop' => [
            'ASUS ROG Zephyrus G16', 'Acer Predator Helios Neo 16', 'Lenovo Legion Pro 5i', 'MSI Stealth 16 Studio',
            'HP Pavilion Aero 13', 'Dell XPS 15', 'Apple MacBook Air M3', 'Apple MacBook Pro M3 Pro',
            'ASUS ZenBook 14 OLED', 'Acer Swift Go 14', 'Lenovo ThinkPad X1 Carbon', 'HP Spectre x360 14',
            'Xiaomi Mi Notebook Ultra', 'Samsung Galaxy Book 4 Pro', 'LG Gram 16',
        ],
        'Smartphone' => [
            'Samsung Galaxy S25 Ultra', 'iPhone 16 Pro Max', 'Xiaomi 14 Ultra', 'ASUS Zenfone 11 Ultra',
            'Samsung Galaxy Z Fold 6', 'iPhone 16', 'Xiaomi Redmi Note 14 Pro', 'Samsung Galaxy A55 5G',
            'Samsung Galaxy S25', 'iPhone 16 Pro', 'Xiaomi Poco X7 Pro', 'Samsung Galaxy A35 5G',
        ],
        'Tablet' => [
            'Apple iPad Pro M4', 'Samsung Galaxy Tab S10 Ultra', 'Apple iPad Air M3', 'Xiaomi Pad 7 Pro',
            'Apple iPad 11th Gen', 'Samsung Galaxy Tab S9 FE', 'Lenovo Tab P12', 'Samsung Galaxy Tab A9+',
        ],
        'Monitor' => [
            'Samsung Odyssey OLED G8', 'LG UltraGear 27GR95QE', 'ASUS ROG Swift PG32UQX', 'Dell Alienware AW3423DWF',
            'ViewSonic XG2431', 'BenQ EX2780Q', 'Acer Nitro XV272U', 'MSI Optix MAG274QRF-QD',
        ],
        'Keyboard' => [
            'Logitech MX Mechanical', 'Corsair K70 Pro Mini Wireless', 'Razer BlackWidow V4 Pro', 'SteelSeries Apex Pro TKL',
            'Keychron Q1 Pro', 'ASUS ROG Azoth', 'Logitech G Pro X TKL', 'Ducky One 3 Mini',
        ],
        'Mouse' => [
            'Logitech G Pro X Superlight 2', 'Razer DeathAdder V3 Pro', 'SteelSeries Aerox 5', 'Corsair M75 Air Wireless',
            'ASUS ROG Harpe Ace', 'Logitech MX Master 3S', 'Razer Basilisk V3 Pro', 'Logitech G502 X Plus',
        ],
        'Headphone' => [
            'Sony WH-1000XM5', 'Bose QuietComfort Ultra', 'Sennheiser Momentum 4', 'Apple AirPods Max',
            'Logitech G Pro X 2', 'Razer BlackShark V2 Pro', 'SteelSeries Arctis Nova Pro', 'Corsair Virtuoso Pro',
        ],
        'Earbuds' => [
            'Apple AirPods Pro 2 USB-C', 'Samsung Galaxy Buds 3 Pro', 'Sony WF-1000XM5', 'Xiaomi Buds 5 Pro',
            'Nothing Ear (2)', 'Anker Soundcore Liberty 4 NC', 'Jabra Elite 10', 'Google Pixel Buds Pro',
        ],
        'Smartwatch' => [
            'Apple Watch Ultra 2', 'Samsung Galaxy Watch 7 Ultra', 'Apple Watch Series 10', 'Samsung Galaxy Watch 7',
            'Xiaomi Watch 2 Pro', 'Garmin Epix Pro Gen 2', 'Amazfit T-Rex 3', 'Huawei Watch GT 4',
        ],
        'Gaming' => [
            'Nintendo Switch OLED', 'ASUS ROG Ally X', 'Sony PlayStation 5 Slim', 'Xbox Series X',
            'Steam Deck OLED', 'Nintendo Switch Lite', 'Xbox Series S', 'Sony DualSense Edge',
        ],
        'Camera' => [
            'Canon EOS R6 Mark II', 'Sony A7 IV', 'Nikon Z6 III', 'Fujifilm X-T5',
            'Canon EOS R50', 'Sony ZV-E10 II', 'Panasonic Lumix S5 II', 'DJI Osmo Pocket 3',
        ],
        'Printer' => [
            'Epson L3110', 'Canon Pixma G3070', 'Brother DCP-T720DW', 'HP Smart Tank 585',
            'Epson L8050', 'Canon Pixma TR4670', 'Brother HL-L2350DW', 'HP LaserJet M234sdw',
        ],
        'Networking' => [
            'TP-Link Archer AX90', 'ASUS RT-AX86U Pro', 'TP-Link Deco XE75', 'ASUS ZenWiFi XT8',
            'D-Link R15 Eagle Pro AI', 'Netgear Nighthawk RAX120', 'MikroTik hAP ax3', 'Ubiquiti UniFi 6 Pro',
        ],
        'SSD' => [
            'Samsung 990 Pro', 'WD Black SN850X', 'Crucial T700', 'Seagate FireCuda 530',
            'Kingston KC3000', 'SK Hynix Platinum P41', 'Samsung T7 Shield', 'SanDisk Extreme Pro',
        ],
        'RAM' => [
            'Corsair Dominator Titanium DDR5', 'G.Skill Trident Z5 RGB', 'Kingston Fury Beast DDR5', 'TeamGroup T-Force Delta',
            'Corsair Vengeance DDR5', 'Crucial Pro DDR5', 'ADATA XPG Lancer Blade', 'G.Skill Ripjaws S5',
        ],
        'Processor' => [
            'Intel Core i9-14900K', 'AMD Ryzen 9 7950X3D', 'Intel Core i7-14700K', 'AMD Ryzen 7 7800X3D',
            'Intel Core i5-14600K', 'AMD Ryzen 5 7600X', 'Intel Core i3-14100F', 'AMD Ryzen 9 7950X',
        ],
        'GPU' => [
            'NVIDIA RTX 4090', 'NVIDIA RTX 4080 Super', 'NVIDIA RTX 4070 Ti Super', 'AMD RX 7900 XTX',
            'NVIDIA RTX 4070 Super', 'AMD RX 7800 XT', 'NVIDIA RTX 4060 Ti', 'AMD RX 7600 XT',
        ],
        'Office' => [
            'Samsung M2020', 'Logitech MK850', 'Microsoft Surface Hub 2', 'Xiaomi Smart Office Hub',
            'ASUS ExpertCenter D5', 'Dell OptiPlex 7010', 'Lenovo IdeaCentre AIO 3', 'HP ProDesk 400',
        ],
        'Home Appliance' => [
            'Xiaomi Mi Robot Vacuum S10', 'Philips Airfryer XXL', 'Polytron Kulkas 2 Pintu', 'Sharp Air Purifier KC-G60',
            'Miyako Magic Com', 'Cosmos Blender', 'Maspion Setrika Uap', 'Panasonic Microwave',
        ],
        'Accessories' => [
            'Ugreen USB-C Hub 9-in-1', 'Anker PowerCore 26800', 'Baseus GaN Charger 100W', 'JBL Flip 6',
            'AUKEY USB-C Cable', 'Spigen Ultra Hybrid Case', 'Sandisk iXpand Flash Drive', 'Belkin BoostCharge Pro',
        ],
    ];

    public function definition(): array
    {
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        $brand = Brand::inRandomOrder()->first() ?? Brand::factory()->create();
        $name = array_shift(self::$productNames[$category->name]) ?? fake()->unique()->words(3, true);

        $slug = str()->slug($name);
        $score = fake()->numberBetween(62, 98);
        $lowestPrice = fake()->numberBetween(
            match ($category->name) {
                'Laptop', 'GPU', 'TV' => 3000000,
                'Smartphone', 'Tablet', 'Monitor', 'Processor' => 1000000,
                'SSD', 'RAM', 'Keyboard', 'Headphone' => 200000,
                'Mouse', 'Earbuds' => 100000,
                'Accessories' => 30000,
                'Home Appliance' => 150000,
                default => 500000,
            },
            match ($category->name) {
                'Laptop', 'GPU' => 45000000,
                'Smartphone', 'TV' => 25000000,
                'Tablet', 'Processor', 'Monitor' => 15000000,
                'SSD', 'RAM', 'Keyboard', 'Headphone' => 5000000,
                'Mouse', 'Earbuds' => 3000000,
                'Accessories' => 1500000,
                'Home Appliance' => 10000000,
                default => 20000000,
            }
        );

        $pros = collect([
            'Kualitas build premium dan kokoh',
            'Performa sangat cepat dan responsif',
            'Desain elegan dan modern',
            'Baterai tahan lama hingga seharian',
            'Layar berkualitas tinggi dengan warna akurat',
            'Harga sangat kompetitif di kelasnya',
            'Garansi resmi panjang',
            'Dukungan software yang konsisten',
            'Port lengkap untuk kebutuhan sehari-hari',
            'Bobot ringan dan mudah dibawa',
        ])->random(fake()->numberBetween(3, 5))->toArray();

        $cons = collect([
            'Harga cukup mahal',
            'Tidak dilengkapi charger bawaan',
            'Bobot agak berat',
            'Kipas terdengar saat beban tinggi',
            'Port terbatas hanya 2 USB-C',
            'Software bawaan cukup banyak (bloatware)',
            'Kualitas kamera standar',
            'Tidak tahan air',
            'Material casing mudah kotor',
            'Garansi hanya 1 tahun',
        ])->random(fake()->numberBetween(2, 4))->toArray();

        return [
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'name' => $name,
            'slug' => $slug,
            'short_description' => fake()->sentence(12),
            'description' => implode("\n\n", [
                "## Overview\n" . fake()->paragraph(5),
                "## Desain\n" . fake()->paragraph(4),
                "## Performa\n" . fake()->paragraph(4),
                "## Kesimpulan\n" . fake()->paragraph(3),
            ]),
            'specifications' => self::generateSpecs($category->name, $name),
            'pros' => $pros,
            'cons' => $cons,
            'thumbnail' => 'https://picsum.photos/seed/' . $slug . '/640/480',
            'worth_it_score' => $score,
            'lowest_price' => $lowestPrice,
            'status' => 'published',
            'is_featured' => fake()->boolean(20),
            'is_trending' => fake()->boolean(25),
        ];
    }

    private static function generateSpecs(string $category, string $name): array
    {
        $specs = [
            'Brand' => explode(' ', $name)[0],
            'Model' => $name,
            'Kategori' => $category,
        ];

        return match ($category) {
            'Laptop' => $specs + [
                'Prosesor' => fake()->randomElement(['Intel Core i5-13500H', 'Intel Core i7-13700H', 'Intel Core i9-13900H', 'AMD Ryzen 5 7640HS', 'AMD Ryzen 7 7840HS', 'AMD Ryzen 9 7945HX']),
                'RAM' => fake()->randomElement(['8GB DDR5', '16GB DDR5', '32GB DDR5', '64GB DDR5']),
                'Storage' => fake()->randomElement(['256GB SSD', '512GB SSD', '1TB SSD', '2TB SSD']),
                'Layar' => fake()->randomElement(['14" 2.8K OLED', '15.6" FHD IPS', '16" QHD+ IPS', '13.3" Retina Display']),
                'GPU' => fake()->randomElement(['Integrated', 'NVIDIA RTX 3050', 'NVIDIA RTX 4060', 'NVIDIA RTX 4070', 'NVIDIA RTX 4080']),
                'Baterai' => fake()->randomElement(['4-cell 56Wh', '4-cell 70Wh', '6-cell 90Wh', '6-cell 99.9Wh']),
                'Berat' => fake()->randomElement(['1.2 kg', '1.5 kg', '1.8 kg', '2.1 kg', '2.5 kg']),
                'OS' => 'Windows 11 Home',
            ],
            'Smartphone' => $specs + [
                'Chipset' => fake()->randomElement(['Snapdragon 8 Gen 3', 'Apple A17 Pro', 'Dimensity 9300', 'Snapdragon 8 Gen 2', 'Exynos 2400']),
                'RAM' => fake()->randomElement(['8GB', '12GB', '16GB', '24GB']),
                'Storage' => fake()->randomElement(['128GB', '256GB', '512GB', '1TB']),
                'Layar' => fake()->randomElement(['6.1" AMOLED 120Hz', '6.5" Dynamic AMOLED', '6.7" LTPO AMOLED', '6.8" Super AMOLED']),
                'Kamera Belakang' => fake()->randomElement(['50MP+12MP+12MP', '200MP+12MP+10MP', '50MP+48MP+12MP', '108MP+8MP+2MP']),
                'Baterai' => fake()->randomElement(['4000mAh', '5000mAh', '5500mAh', '6000mAh']),
                'OS' => fake()->randomElement(['Android 14', 'iOS 18']),
            ],
            'Tablet' => $specs + [
                'Chipset' => fake()->randomElement(['Apple M4', 'Snapdragon 8 Gen 3', 'Dimensity 9300', 'Exynos 2400']),
                'RAM' => fake()->randomElement(['8GB', '12GB', '16GB']),
                'Storage' => fake()->randomElement(['128GB', '256GB', '512GB', '1TB']),
                'Layar' => fake()->randomElement(['11" Liquid Retina', '12.4" Super AMOLED', '12.9" Mini-LED', '14.6" Dynamic AMOLED']),
                'Baterai' => fake()->randomElement(['8000mAh', '10000mAh', '12000mAh']),
                'Berat' => fake()->randomElement(['450g', '580g', '680g', '720g']),
            ],
            'Monitor' => $specs + [
                'Ukuran' => fake()->randomElement(['24"', '27"', '32"', '34" Ultrawide', '42"']),
                'Resolusi' => fake()->randomElement(['1920x1080', '2560x1440', '3840x2160', '3440x1440']),
                'Refresh Rate' => fake()->randomElement(['60Hz', '120Hz', '144Hz', '165Hz', '240Hz']),
                'Panel' => fake()->randomElement(['IPS', 'VA', 'OLED', 'Mini-LED']),
                'Response Time' => fake()->randomElement(['1ms', '2ms', '4ms', '0.03ms']),
            ],
            'Keyboard' => $specs + [
                'Switch' => fake()->randomElement(['Cherry MX Red', 'Cherry MX Blue', 'Cherry MX Brown', 'Gateron Red', 'Razer Green', 'Optical Linear']),
                'Layout' => fake()->randomElement(['Full Size', 'TKL', '75%', '65%', '60%']),
                'Koneksi' => fake()->randomElement(['Wired USB-C', 'Wireless 2.4GHz', 'Bluetooth 5.2', 'Tri-Mode']),
                'Backlight' => fake()->randomElement(['RGB Per-Key', 'RGB 16.8M', 'White LED', 'None']),
                'Keycap' => fake()->randomElement(['PBT Double-Shot', 'ABS', 'PBT']),
            ],
            'Mouse' => $specs + [
                'Sensor' => fake()->randomElement(['HERO 25K', 'Focus Pro 30K', 'Razer Focus Pro', 'PAW3395']),
                'DPI' => fake()->randomElement(['800', '1600', '3200', '6400', '25600']),
                'Koneksi' => fake()->randomElement(['Wired', 'Wireless 2.4GHz', 'Bluetooth 5.1', 'Tri-Mode']),
                'Bobot' => fake()->randomElement(['55g', '63g', '74g', '80g', '100g']),
                'Baterai' => fake()->randomElement(['AA Battery', 'Rechargeable 500mAh', 'Rechargeable 750mAh']),
            ],
            'GPU' => $specs + [
                'VRAM' => fake()->randomElement(['8GB GDDR6', '12GB GDDR6X', '16GB GDDR6X', '24GB GDDR6X']),
                'Clock Speed' => fake()->randomElement(['2520 MHz', '2640 MHz', '2700 MHz', '2850 MHz']),
                'TDP' => fake()->randomElement(['150W', '200W', '250W', '320W', '450W']),
                'CUDA Cores' => (string) fake()->randomElement([4352, 5888, 7680, 10240, 16384]),
                'Bus' => fake()->randomElement(['PCIe 4.0 x16', 'PCIe 5.0 x16']),
            ],
            'SSD' => $specs + [
                'Kapasitas' => fake()->randomElement(['250GB', '500GB', '1TB', '2TB', '4TB']),
                'Interface' => fake()->randomElement(['NVMe PCIe 4.0', 'NVMe PCIe 5.0', 'SATA III']),
                'Read Speed' => fake()->randomElement(['3500 MB/s', '5000 MB/s', '7000 MB/s', '10000 MB/s', '12400 MB/s']),
                'Write Speed' => fake()->randomElement(['3000 MB/s', '4500 MB/s', '6000 MB/s', '8500 MB/s', '10000 MB/s']),
                'Form Factor' => fake()->randomElement(['M.2 2280', 'M.2 2230', '2.5 inch']),
            ],
            'RAM' => $specs + [
                'Kapasitas' => fake()->randomElement(['8GB', '16GB', '32GB', '64GB']),
                'Tipe' => fake()->randomElement(['DDR4-3200', 'DDR5-5200', 'DDR5-6000', 'DDR5-6800']),
                'Latency' => fake()->randomElement(['CL36', 'CL32', 'CL30', 'CL28']),
                'Voltage' => '1.35V',
            ],
            default => $specs + [
                'Warna' => fake()->randomElement(['Black', 'White', 'Silver', 'Space Gray', 'Midnight blue']),
                'Dimensi' => fake()->randomElement(['Compact', 'Standard', 'Large']),
                'Garansi' => fake()->randomElement(['1 Tahun', '2 Tahun', '3 Tahun']),
            ],
        };
    }
}
