<?php

namespace Database\Seeders;

use App\Models\AffiliateLink;
use App\Models\Article;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Marketplace;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Seeding CekDulu database...');

        // Create admin user
        $this->command->info('👤 Creating users...');
        $admin = User::create([
            'name' => 'Admin CekDulu',
            'email' => 'admin@cekdulu.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create member users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        // Seed membership plans
        $this->call([
            MembershipPlanSeeder::class,
        ]);

        // Seed categories (20)
        $this->command->info('📁 Creating 20 categories...');
        Category::factory(20)->create();

        // Seed brands (50)
        $this->command->info('🏷️  Creating 50 brands...');
        Brand::factory(50)->create();

        // Seed marketplaces (5)
        $this->command->info('🛒 Creating 5 marketplaces...');
        Marketplace::factory(5)->create();

        // Seed products (100)
        $this->command->info('📦 Creating 100 products...');
        $products = Product::factory(100)->create();

        // Seed product images (3-6 per product)
        $this->command->info('🖼️  Creating product images...');
        foreach ($products as $product) {
            ProductImage::factory(rand(3, 6))->create([
                'product_id' => $product->id,
            ]);
        }

        // Seed product prices (3-5 per product)
        $this->command->info('💰 Creating product prices...');
        $marketplaces = Marketplace::all();
        foreach ($products as $product) {
            $numPrices = rand(3, 5);
            $selectedMarketplaces = $marketplaces->random(min($numPrices, $marketplaces->count()));

            foreach ($selectedMarketplaces as $marketplace) {
                ProductPrice::factory()->create([
                    'product_id' => $product->id,
                    'marketplace_id' => $marketplace->id,
                ]);
            }
        }

        // Seed affiliate links
        $this->command->info('🔗 Creating affiliate links...');
        $productPrices = ProductPrice::all();
        foreach ($productPrices as $price) {
            AffiliateLink::factory()->create([
                'product_id' => $price->product_id,
                'marketplace_id' => $price->marketplace_id,
                'product_price_id' => $price->id,
            ]);
        }

        // Seed articles (30)
        $this->command->info('📝 Creating 30 articles...');
        $articles = Article::factory(30)->create([
            'user_id' => $admin->id,
        ]);

        // Link articles to products
        $this->command->info('🔗 Linking articles to products...');
        foreach ($articles as $article) {
            $article->products()->attach(
                $products->random(rand(2, 5))->pluck('id')
            );
        }

        // Update lowest prices
        $this->command->info('💵 Updating product lowest prices...');
        foreach ($products as $product) {
            $lowestPrice = ProductPrice::where('product_id', $product->id)->min('price');
            if ($lowestPrice) {
                $product->update(['lowest_price' => $lowestPrice]);
            }
        }

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Categories: ' . Category::count());
        $this->command->info('   - Brands: ' . Brand::count());
        $this->command->info('   - Marketplaces: ' . Marketplace::count());
        $this->command->info('   - Products: ' . Product::count());
        $this->command->info('   - Product Images: ' . ProductImage::count());
        $this->command->info('   - Product Prices: ' . ProductPrice::count());
        $this->command->info('   - Affiliate Links: ' . AffiliateLink::count());
        $this->command->info('   - Articles: ' . Article::count());
    }
}
