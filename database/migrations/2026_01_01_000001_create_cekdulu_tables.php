<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('icon')->nullable();
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
        });

        Schema::create('brands', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('logo')->nullable();
            $t->text('description')->nullable();
            $t->timestamps();
        });

        Schema::create('marketplaces', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('logo')->nullable();
            $t->string('base_url')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->timestamps();
        });

        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $t->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $t->string('name');
            $t->string('slug')->unique();
            $t->text('short_description')->nullable();
            $t->longText('description')->nullable();
            $t->json('specifications')->nullable();
            $t->json('pros')->nullable();
            $t->json('cons')->nullable();
            $t->string('thumbnail')->nullable();
            $t->unsignedTinyInteger('worth_it_score')->default(70)->index();
            $t->integer('admin_score_adjustment')->default(0);
            $t->unsignedBigInteger('lowest_price')->nullable()->index();
            $t->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $t->boolean('is_featured')->default(false)->index();
            $t->boolean('is_trending')->default(false)->index();
            $t->timestamps();
        });

        Schema::create('product_images', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->string('image_url');
            $t->integer('sort_order')->default(0);
            $t->timestamps();
        });

        Schema::create('product_prices', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->foreignId('marketplace_id')->constrained('marketplaces')->cascadeOnDelete();
            $t->string('seller_name')->nullable();
            $t->text('product_url');
            $t->unsignedBigInteger('price')->index();
            $t->unsignedBigInteger('original_price')->nullable();
            $t->string('discount')->nullable();
            $t->decimal('rating', 3, 2)->nullable();
            $t->unsignedInteger('sold_count')->default(0);
            $t->unsignedInteger('review_count')->default(0);
            $t->boolean('is_recommended')->default(false);
            $t->timestamp('last_updated_at')->nullable();
            $t->timestamps();

            $t->index(['product_id', 'marketplace_id']);
        });

        Schema::create('affiliate_links', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->foreignId('marketplace_id')->constrained('marketplaces')->cascadeOnDelete();
            $t->foreignId('product_price_id')->nullable()->constrained('product_prices')->nullOnDelete();
            $t->text('affiliate_url');
            $t->string('campaign_name')->nullable();
            $t->boolean('is_active')->default(true)->index();
            $t->unsignedInteger('click_count')->default(0);
            $t->timestamps();

            $t->index(['product_id', 'marketplace_id']);
        });

        Schema::create('affiliate_clicks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('affiliate_link_id')->constrained('affiliate_links')->cascadeOnDelete();
            $t->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $t->foreignId('marketplace_id')->nullable()->constrained('marketplaces')->nullOnDelete();
            $t->string('ip_address', 45)->nullable();
            $t->text('user_agent')->nullable();
            $t->text('referrer')->nullable();
            $t->timestamps();

            $t->index(['product_id', 'marketplace_id']);
        });

        Schema::create('articles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('excerpt')->nullable();
            $t->longText('content')->nullable();
            $t->string('featured_image')->nullable();
            $t->string('seo_title')->nullable();
            $t->text('meta_description')->nullable();
            $t->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $t->timestamp('published_at')->nullable()->index();
            $t->timestamps();
        });

        Schema::create('article_product', function (Blueprint $t) {
            $t->id();
            $t->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->unique(['article_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_product');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('affiliate_clicks');
        Schema::dropIfExists('affiliate_links');
        Schema::dropIfExists('product_prices');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('marketplaces');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('categories');
    }
};
