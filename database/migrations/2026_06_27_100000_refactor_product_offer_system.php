<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // =========================================================================
        // STEP 1: Rename product_prices → product_offers FIRST
        // (Must happen before creating tables that reference product_offers via FK)
        // =========================================================================
        if (Schema::hasTable('product_prices') && !Schema::hasTable('product_offers')) {
            Schema::rename('product_prices', 'product_offers');
        }

        // =========================================================================
        // STEP 2: Add new columns to product_offers
        // (Only add columns that don't already exist)
        // =========================================================================
        if (Schema::hasTable('product_offers')) {
            Schema::table('product_offers', function (Blueprint $table) {
                // Rename last_updated_at → last_checked_at (MySQL-specific)
                if (!Schema::hasColumn('product_offers', 'last_checked_at')) {
                    DB::statement('ALTER TABLE product_offers CHANGE COLUMN last_updated_at last_checked_at TIMESTAMP NULL');
                }

                // New columns — only add if they don't exist
                if (!Schema::hasColumn('product_offers', 'seller_type')) {
                    $table->enum('seller_type', ['official', 'regular'])->default('regular')->after('seller_name');
                }
                if (!Schema::hasColumn('product_offers', 'discount_percentage')) {
                    $table->unsignedTinyInteger('discount_percentage')->nullable()->after('original_price');
                }
                if (!Schema::hasColumn('product_offers', 'shipping_cost')) {
                    $table->unsignedBigInteger('shipping_cost')->nullable()->default(0)->after('discount_percentage');
                }
                if (!Schema::hasColumn('product_offers', 'estimated_delivery')) {
                    $table->string('estimated_delivery', 100)->nullable()->after('shipping_cost');
                }
                if (!Schema::hasColumn('product_offers', 'stock_status')) {
                    $table->enum('stock_status', ['in_stock', 'low_stock', 'out_of_stock', 'pre_order'])->default('in_stock')->after('estimated_delivery');
                }
                if (!Schema::hasColumn('product_offers', 'stock_quantity')) {
                    $table->unsignedInteger('stock_quantity')->nullable()->after('stock_status');
                }
                if (!Schema::hasColumn('product_offers', 'affiliate_url')) {
                    $table->text('affiliate_url')->nullable()->after('product_url');
                }
                if (!Schema::hasColumn('product_offers', 'coupon_available')) {
                    $table->boolean('coupon_available')->default(false)->after('affiliate_url');
                }
                if (!Schema::hasColumn('product_offers', 'voucher_available')) {
                    $table->boolean('voucher_available')->default(false)->after('coupon_available');
                }
                if (!Schema::hasColumn('product_offers', 'cashback_information')) {
                    $table->string('cashback_information', 255)->nullable()->after('voucher_available');
                }
                if (!Schema::hasColumn('product_offers', 'is_official_store')) {
                    $table->boolean('is_official_store')->default(false)->after('cashback_information');
                }
                if (!Schema::hasColumn('product_offers', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('is_official_store');
                }
            });
        }

        // =========================================================================
        // STEP 3: Copy affiliate_url from affiliate_links into product_offers
        // (Only if affiliate_links still exists and product_offers has affiliate_url)
        // =========================================================================
        if (Schema::hasTable('affiliate_links') && Schema::hasTable('product_offers') && Schema::hasColumn('product_offers', 'affiliate_url')) {
            DB::statement('
                UPDATE product_offers po
                INNER JOIN affiliate_links al
                    ON al.product_id = po.product_id
                    AND al.marketplace_id = po.marketplace_id
                SET po.affiliate_url = al.affiliate_url,
                    po.is_active = COALESCE(al.is_active, 1)
                WHERE po.affiliate_url IS NULL
            ');
        }

        // =========================================================================
        // STEP 4: Rename affiliate_clicks → offer_clicks
        // =========================================================================
        if (Schema::hasTable('affiliate_clicks') && !Schema::hasTable('offer_clicks')) {
            Schema::rename('affiliate_clicks', 'offer_clicks');
        }

        // =========================================================================
        // STEP 5: Rename affiliate_link_id → product_offer_id in offer_clicks
        // (The original column references affiliate_links, which is being deprecated)
        // =========================================================================
        if (Schema::hasTable('offer_clicks') && Schema::hasColumn('offer_clicks', 'affiliate_link_id') && !Schema::hasColumn('offer_clicks', 'product_offer_id')) {
            // 5a. Drop the old foreign key on affiliate_link_id
            // Laravel auto-names FKs as table_column_foreign
            Schema::table('offer_clicks', function (Blueprint $table) {
                $table->dropForeign(['affiliate_link_id']);
            });

            // 5b. Rename the column
            DB::statement('ALTER TABLE offer_clicks CHANGE COLUMN affiliate_link_id product_offer_id BIGINT UNSIGNED NOT NULL');

            // 5c. Add new foreign key referencing product_offers
            Schema::table('offer_clicks', function (Blueprint $table) {
                $table->foreign('product_offer_id')->references('id')->on('product_offers')->cascadeOnDelete();
            });
        }

        // =========================================================================
        // STEP 6: Add new columns to offer_clicks
        // =========================================================================
        if (Schema::hasTable('offer_clicks')) {
            Schema::table('offer_clicks', function (Blueprint $table) {
                if (!Schema::hasColumn('offer_clicks', 'user_id')) {
                    $table->foreignId('user_id')->nullable()->after('marketplace_id');
                }
                if (!Schema::hasColumn('offer_clicks', 'clicked_at')) {
                    $table->timestamp('clicked_at')->nullable()->after('referrer');
                }
            });

            // Add foreign key for user_id separately (only if column exists and FK doesn't)
            if (Schema::hasColumn('offer_clicks', 'user_id')) {
                Schema::table('offer_clicks', function (Blueprint $table) {
                    $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
                });
            }
        }

        // =========================================================================
        // STEP 7: Rename affiliate_links → deprecated_affiliate_links
        // =========================================================================
        if (Schema::hasTable('affiliate_links') && !Schema::hasTable('deprecated_affiliate_links')) {
            Schema::rename('affiliate_links', 'deprecated_affiliate_links');
        }

        // =========================================================================
        // STEP 8: Create new tables (now product_offers exists for FK references)
        // =========================================================================

        // 8a. price_histories — track price changes per offer
        if (!Schema::hasTable('price_histories')) {
            Schema::create('price_histories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_offer_id')->constrained('product_offers')->cascadeOnDelete();
                $table->unsignedBigInteger('old_price')->nullable();
                $table->unsignedBigInteger('new_price');
                $table->timestamp('changed_at');
                $table->timestamps();

                $table->index('product_offer_id');
                $table->index('changed_at');
            });
        }

        // 8b. price_alerts — user-set price drop notifications
        if (!Schema::hasTable('price_alerts')) {
            Schema::create('price_alerts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->foreignId('product_offer_id')->nullable()->constrained('product_offers')->nullOnDelete();
                $table->unsignedBigInteger('target_price');
                $table->boolean('is_active')->default(true);
                $table->timestamp('triggered_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'is_active']);
            });
        }

        // 8c. product_tags — tag/category system for products
        if (!Schema::hasTable('product_tags')) {
            Schema::create('product_tags', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });
        }

        // 8d. product_tag — pivot table for products ↔ tags
        if (!Schema::hasTable('product_tag')) {
            Schema::create('product_tag', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->foreignId('tag_id')->constrained('product_tags')->cascadeOnDelete();
                $table->unique(['product_id', 'tag_id']);
            });
        }

        // 8e. wishlists — user product wishlists
        if (!Schema::hasTable('wishlists')) {
            Schema::create('wishlists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['user_id', 'product_id']);
            });
        }

        // =========================================================================
        // STEP 9: Add score_total to products
        // =========================================================================
        if (Schema::hasTable('products') && !Schema::hasColumn('products', 'score_total')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('score_total')->nullable()->after('admin_score_adjustment')->index();
            });

            // Populate score_total for existing records
            DB::statement('UPDATE products SET score_total = worth_it_score + COALESCE(admin_score_adjustment, 0)');
        }

        // =========================================================================
        // STEP 10: Add indexes (only if they don't exist)
        // =========================================================================
        if (Schema::hasTable('product_offers')) {
            Schema::table('product_offers', function (Blueprint $table) {
                $table->index('is_active');
                $table->index('price');
            });
        }

        if (Schema::hasTable('offer_clicks')) {
            Schema::table('offer_clicks', function (Blueprint $table) {
                $table->index('product_offer_id');
                $table->index('created_at');
            });
        }
    }

    public function down(): void
    {
        // =========================================================================
        // REVERSE STEP 10: Drop indexes
        // =========================================================================
        if (Schema::hasTable('offer_clicks')) {
            Schema::table('offer_clicks', function (Blueprint $table) {
                $table->dropIndex(['product_offer_id']);
                $table->dropIndex(['created_at']);
            });
        }

        if (Schema::hasTable('product_offers')) {
            Schema::table('product_offers', function (Blueprint $table) {
                $table->dropIndex(['is_active']);
                $table->dropIndex(['price']);
            });
        }

        // =========================================================================
        // REVERSE STEP 9: Remove score_total from products
        // =========================================================================
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'score_total')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('score_total');
            });
        }

        // =========================================================================
        // REVERSE STEP 8: Drop new tables
        // =========================================================================
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('price_alerts');
        Schema::dropIfExists('price_histories');

        // =========================================================================
        // REVERSE STEP 7: Rename deprecated_affiliate_links → affiliate_links
        // =========================================================================
        if (Schema::hasTable('deprecated_affiliate_links') && !Schema::hasTable('affiliate_links')) {
            Schema::rename('deprecated_affiliate_links', 'affiliate_links');
        }

        // =========================================================================
        // REVERSE STEP 6: Remove new columns from offer_clicks
        // =========================================================================
        if (Schema::hasTable('offer_clicks')) {
            Schema::table('offer_clicks', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn(['user_id', 'clicked_at']);
            });
        }

        // =========================================================================
        // REVERSE STEP 5: Rename offer_clicks → affiliate_clicks
        // =========================================================================
        if (Schema::hasTable('offer_clicks') && !Schema::hasTable('affiliate_clicks')) {
            Schema::rename('offer_clicks', 'affiliate_clicks');
        }

        // =========================================================================
        // REVERSE STEP 4: Clear affiliate_url from product_offers
        // =========================================================================
        if (Schema::hasTable('product_offers') && Schema::hasColumn('product_offers', 'affiliate_url')) {
            DB::statement('UPDATE product_offers SET affiliate_url = NULL, is_active = 1');
        }

        // =========================================================================
        // REVERSE STEP 3: Remove new columns from product_offers
        // =========================================================================
        if (Schema::hasTable('product_offers')) {
            Schema::table('product_offers', function (Blueprint $table) {
                $table->dropColumn([
                    'seller_type',
                    'discount_percentage',
                    'shipping_cost',
                    'estimated_delivery',
                    'stock_status',
                    'stock_quantity',
                    'affiliate_url',
                    'coupon_available',
                    'voucher_available',
                    'cashback_information',
                    'is_official_store',
                    'is_active',
                ]);
            });

            // Rename last_checked_at back to last_updated_at
            if (Schema::hasColumn('product_offers', 'last_checked_at')) {
                DB::statement('ALTER TABLE product_offers CHANGE COLUMN last_checked_at last_updated_at TIMESTAMP NULL');
            }
        }

        // =========================================================================
        // REVERSE STEP 2: Rename product_offers → product_prices
        // =========================================================================
        if (Schema::hasTable('product_offers') && !Schema::hasTable('product_prices')) {
            Schema::rename('product_offers', 'product_prices');
        }

        // =========================================================================
        // REVERSE STEP 1: Rename product_offer_id → affiliate_link_id in offer_clicks
        // (Reverse of STEP 5 in up(): restore the original FK to affiliate_links)
        // =========================================================================
        // Note: At this point in down(), offer_clicks has already been renamed back
        // to affiliate_clicks (REVERSE STEP 5), and deprecated_affiliate_links has
        // been renamed back to affiliate_links (REVERSE STEP 7).
        // So we need to operate on affiliate_clicks, referencing affiliate_links.

        if (Schema::hasTable('affiliate_clicks') && Schema::hasColumn('affiliate_clicks', 'product_offer_id') && !Schema::hasColumn('affiliate_clicks', 'affiliate_link_id')) {
            // 1a. Drop the FK on product_offer_id (currently in affiliate_clicks table)
            Schema::table('affiliate_clicks', function (Blueprint $table) {
                $table->dropForeign(['product_offer_id']);
            });

            // 1b. Rename product_offer_id → affiliate_link_id
            DB::statement('ALTER TABLE affiliate_clicks CHANGE COLUMN product_offer_id affiliate_link_id BIGINT UNSIGNED NOT NULL');

            // 1c. Re-add FK on affiliate_link_id referencing affiliate_links
            if (Schema::hasTable('affiliate_links')) {
                Schema::table('affiliate_clicks', function (Blueprint $table) {
                    $table->foreign('affiliate_link_id')->references('id')->on('affiliate_links')->cascadeOnDelete();
                });
            }
        }
    }
};
