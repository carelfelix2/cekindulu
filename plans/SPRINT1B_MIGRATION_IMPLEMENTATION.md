# Sprint 1B: Database Migration Implementation Plan

## Safety Adjustment

Per user approval: `affiliate_links` is **renamed** to `deprecated_affiliate_links` — NOT dropped. Data is preserved for rollback and verification. It will be dropped only in a later cleanup sprint.

---

## 1. Migration File Plan

### Migration File: `2026_06_27_100000_refactor_product_offer_system.php`

A single migration file containing all changes, organized in this order:

```
Step 1:  Create new tables (price_histories, price_alerts, product_tags, product_tag, wishlists)
Step 2:  Rename product_prices → product_offers
Step 3:  Add new columns to product_offers
Step 4:  Copy affiliate_url data from affiliate_links into product_offers
Step 5:  Rename affiliate_clicks → offer_clicks
Step 6:  Add new columns to offer_clicks (user_id, clicked_at)
Step 7:  Rename affiliate_links → deprecated_affiliate_links
Step 8:  Add score_total to products
Step 9:  Add indexes
Step 10: Add foreign keys safely
```

### Why a single migration?
- Atomic operation — all changes succeed or roll back together
- Avoids interleaving issues where partial migrations could leave inconsistent state
- Easier to review and test as one unit

---

## 2. Exact Migration Steps

### Step 1: Create New Tables

#### `price_histories`
```php
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
```

#### `price_alerts`
```php
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
```

#### `product_tags`
```php
Schema::create('product_tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});
```

#### `product_tag` (pivot)
```php
Schema::create('product_tag', function (Blueprint $table) {
    $table->id();
    $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained('product_tags')->cascadeOnDelete();
    $table->unique(['product_id', 'tag_id']);
});
```

#### `wishlists`
```php
Schema::create('wishlists', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
    $table->timestamps();
    $table->unique(['user_id', 'product_id']);
});
```

### Step 2: Rename `product_prices` → `product_offers`

```php
Schema::rename('product_prices', 'product_offers');
```

### Step 3: Add New Columns to `product_offers`

```php
Schema::table('product_offers', function (Blueprint $table) {
    // New columns after existing ones
    $table->enum('seller_type', ['official', 'regular'])->default('regular')->after('seller_name');
    $table->unsignedTinyInteger('discount_percentage')->nullable()->after('original_price');
    $table->unsignedBigInteger('shipping_cost')->nullable()->default(0)->after('discount_percentage');
    $table->string('estimated_delivery', 100)->nullable()->after('shipping_cost');
    $table->enum('stock_status', ['in_stock', 'low_stock', 'out_of_stock', 'pre_order'])->default('in_stock')->after('estimated_delivery');
    $table->unsignedInteger('stock_quantity')->nullable()->after('stock_status');
    $table->text('affiliate_url')->nullable()->after('product_url');
    $table->boolean('coupon_available')->default(false)->after('affiliate_url');
    $table->boolean('voucher_available')->default(false)->after('coupon_available');
    $table->string('cashback_information', 255)->nullable()->after('voucher_available');
    $table->boolean('is_official_store')->default(false)->after('cashback_information');
    $table->boolean('is_active')->default(true)->after('is_recommended');
    $table->timestamp('last_checked_at')->nullable()->after('is_active');

    // Rename last_updated_at → last_checked_at
    // Note: Laravel doesn't support column rename natively in all versions.
    // We'll handle this in data migration instead.
});
```

**Important**: Laravel's `Schema::rename()` doesn't work for columns in all database systems. Since we're using MySQL, we can use a raw DB statement:

```php
DB::statement('ALTER TABLE product_offers CHANGE COLUMN last_updated_at last_checked_at TIMESTAMP NULL');
```

### Step 4: Copy Affiliate URL Data

```php
// For each product_offer, find the matching affiliate_link and copy affiliate_url
DB::statement('
    UPDATE product_offers po
    INNER JOIN affiliate_links al ON al.product_id = po.product_id
        AND al.marketplace_id = po.marketplace_id
    SET po.affiliate_url = al.affiliate_url,
        po.is_active = COALESCE(al.is_active, 1)
    WHERE po.affiliate_url IS NULL
');
```

**Note**: If multiple `affiliate_links` exist for the same product+marketplace, MySQL will use the first match (non-deterministic). This is acceptable because in practice each product+marketplace pair has one affiliate link.

### Step 5: Rename `affiliate_clicks` → `offer_clicks`

```php
Schema::rename('affiliate_clicks', 'offer_clicks');
```

### Step 6: Add New Columns to `offer_clicks`

```php
Schema::table('offer_clicks', function (Blueprint $table) {
    // Add user_id after marketplace_id
    $table->foreignId('user_id')->nullable()->after('marketplace_id');
    // Add clicked_at after referrer
    $table->timestamp('clicked_at')->nullable()->after('referrer');
});

// Add foreign key for user_id
Schema::table('offer_clicks', function (Blueprint $table) {
    $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
});
```

### Step 7: Rename `affiliate_links` → `deprecated_affiliate_links`

```php
Schema::rename('affiliate_links', 'deprecated_affiliate_links');
```

### Step 8: Add `score_total` to Products

```php
Schema::table('products', function (Blueprint $table) {
    $table->integer('score_total')->nullable()->after('admin_score_adjustment')->index();
});

// Populate score_total for existing records
DB::statement('UPDATE products SET score_total = worth_it_score + COALESCE(admin_score_adjustment, 0)');
```

### Step 9: Add Indexes

```php
// product_offers indexes
Schema::table('product_offers', function (Blueprint $table) {
    $table->index('is_active');
    $table->index('price');
    // product_id + marketplace_id composite already exists from original migration
});

// offer_clicks indexes
Schema::table('offer_clicks', function (Blueprint $table) {
    $table->index('product_offer_id');
    $table->index('created_at');
    // product_id + marketplace_id composite already exists from original migration
});
```

### Step 10: Add Foreign Keys Safely

The foreign keys for `product_offers` (product_id, marketplace_id) already exist from the original `product_prices` table since we renamed it.

New foreign keys to add:

```php
// offer_clicks.user_id → users (already added in Step 6)
// price_histories.product_offer_id → product_offers (added in table creation)
// price_alerts.* → users, products, product_offers (added in table creation)
// product_tag.* → products, product_tags (added in table creation)
// wishlists.* → users, products (added in table creation)
```

---

## 3. Data Migration Strategy

### 3.1 `product_prices` → `product_offers` (automatic via rename)
No data loss — the table is simply renamed. All existing rows and their IDs are preserved.

### 3.2 `affiliate_clicks` → `offer_clicks` (automatic via rename)
No data loss — the table is simply renamed. All existing rows and their IDs are preserved.

### 3.3 `affiliate_links` → `deprecated_affiliate_links` (automatic via rename)
No data loss — the table is simply renamed. All existing rows and their IDs are preserved.

### 3.4 Affiliate URL copy
The `affiliate_url` from `affiliate_links` is copied into `product_offers.affiliate_url`. This is a non-destructive UPDATE — it only modifies `product_offers` and does not touch `affiliate_links`.

### 3.5 `score_total` population
Simple arithmetic UPDATE: `worth_it_score + COALESCE(admin_score_adjustment, 0)`. Non-destructive.

### 3.6 Initial `price_histories` records
After migration, a separate seeder or post-migration script can create initial price history records:

```sql
INSERT INTO price_histories (product_offer_id, old_price, new_price, changed_at, created_at, updated_at)
SELECT id, NULL, price, COALESCE(last_checked_at, created_at), NOW(), NOW()
FROM product_offers;
```

This is optional and can be run after the migration is verified.

---

## 4. Rollback Strategy

The `down()` method reverses each step in reverse order:

```php
public function down(): void
{
    // Step 10: Drop new foreign keys (handled by dropping tables)
    
    // Step 9: Drop new indexes (handled by dropping tables/columns)
    
    // Step 8: Remove score_total from products
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('score_total');
    });
    
    // Step 7: Rename deprecated_affiliate_links → affiliate_links
    Schema::rename('deprecated_affiliate_links', 'affiliate_links');
    
    // Step 6: Remove new columns from offer_clicks
    Schema::table('offer_clicks', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn(['user_id', 'clicked_at']);
    });
    
    // Step 5: Rename offer_clicks → affiliate_clicks
    Schema::rename('offer_clicks', 'affiliate_clicks');
    
    // Step 4: Clear affiliate_url from product_offers (reversible)
    DB::statement('UPDATE product_offers SET affiliate_url = NULL, is_active = 1');
    
    // Step 3: Remove new columns from product_offers
    Schema::table('product_offers', function (Blueprint $table) {
        $table->dropColumn([
            'seller_type', 'discount_percentage', 'shipping_cost',
            'estimated_delivery', 'stock_status', 'stock_quantity',
            'affiliate_url', 'coupon_available', 'voucher_available',
            'cashback_information', 'is_official_store', 'is_active',
            'last_checked_at',
        ]);
    });
    
    // Step 3b: Rename last_checked_at back to last_updated_at
    DB::statement('ALTER TABLE product_offers CHANGE COLUMN last_checked_at last_updated_at TIMESTAMP NULL');
    
    // Step 2: Rename product_offers → product_prices
    Schema::rename('product_offers', 'product_prices');
    
    // Step 1: Drop new tables
    Schema::dropIfExists('wishlists');
    Schema::dropIfExists('product_tag');
    Schema::dropIfExists('product_tags');
    Schema::dropIfExists('price_alerts');
    Schema::dropIfExists('price_histories');
}
```

---

## 5. Verification SQL Queries

Run these after migration to verify integrity:

### 5.1 Row Count Verification
```sql
-- Verify product_prices → product_offers
SELECT 'product_offers' AS table_name, COUNT(*) AS row_count FROM product_offers
UNION ALL
-- Verify affiliate_clicks → offer_clicks
SELECT 'offer_clicks', COUNT(*) FROM offer_clicks
UNION ALL
-- Verify affiliate_links → deprecated_affiliate_links
SELECT 'deprecated_affiliate_links', COUNT(*) FROM deprecated_affiliate_links
UNION ALL
-- Verify new tables are empty
SELECT 'price_histories', COUNT(*) FROM price_histories
UNION ALL
SELECT 'price_alerts', COUNT(*) FROM price_alerts
UNION ALL
SELECT 'product_tags', COUNT(*) FROM product_tags
UNION ALL
SELECT 'product_tag', COUNT(*) FROM product_tag
UNION ALL
SELECT 'wishlists', COUNT(*) FROM wishlists;
```

### 5.2 Data Integrity Checks
```sql
-- Check affiliate_url was copied correctly
SELECT COUNT(*) AS offers_with_affiliate_url
FROM product_offers
WHERE affiliate_url IS NOT NULL;

-- Compare with original
SELECT COUNT(*) AS original_affiliate_links
FROM deprecated_affiliate_links;

-- Check for offers that should have affiliate_url but don't
SELECT po.id, po.product_id, po.marketplace_id
FROM product_offers po
INNER JOIN deprecated_affiliate_links dal
    ON dal.product_id = po.product_id
    AND dal.marketplace_id = po.marketplace_id
WHERE po.affiliate_url IS NULL;
```

### 5.3 Schema Verification
```sql
-- Verify product_offers has all new columns
DESCRIBE product_offers;

-- Verify offer_clicks has user_id and clicked_at
DESCRIBE offer_clicks;

-- Verify products has score_total
DESCRIBE products;

-- Verify deprecated_affiliate_links exists
SHOW TABLES LIKE 'deprecated_affiliate_links';
```

### 5.4 Foreign Key Verification
```sql
-- Check all foreign keys exist
SELECT TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME IN ('product_offers', 'offer_clicks', 'price_histories', 'price_alerts', 'product_tags', 'product_tag', 'wishlists')
    AND REFERENCED_TABLE_NAME IS NOT NULL;
```

### 5.5 Score Total Verification
```sql
-- Verify score_total was computed correctly
SELECT
    COUNT(*) AS total_products,
    SUM(CASE WHEN score_total = worth_it_score + COALESCE(admin_score_adjustment, 0) THEN 1 ELSE 0 END) AS correct_scores,
    SUM(CASE WHEN score_total != worth_it_score + COALESCE(admin_score_adjustment, 0) THEN 1 ELSE 0 END) AS incorrect_scores
FROM products;
```

---

## 6. Risk Notes

| # | Risk | Mitigation |
|---|------|------------|
| 1 | **Migration runs during active requests** | Run in maintenance mode: `php artisan down` before migration |
| 2 | **`discount` column (string) in product_prices is replaced by `discount_percentage` (integer)** | Old string values like '50%' or 'Rp 100.000' are lost. The new column stores computed percentage. Run a pre-migration script to parse existing values if needed |
| 3 | **Multiple affiliate_links per product+marketplace** | The UPDATE JOIN picks one non-deterministically. Run a pre-migration report to identify duplicates |
| 4 | **`last_updated_at` → `last_checked_at` rename** | MySQL `CHANGE COLUMN` is used. Ensure no application code references `last_updated_at` on product_offers after migration |
| 5 | **Foreign key on `offer_clicks.user_id` references `users`** | Existing rows will have NULL user_id (since old affiliate_clicks didn't track users). This is correct behavior |
| 6 | **`score_total` is nullable** | Set to nullable initially to avoid issues with existing rows. After population, it could be made non-nullable in a future migration |
| 7 | **`is_active` column added to product_offers** | Defaults to `true` for all existing records. Old affiliate_links.is_active values are copied where possible |
| 8 | **Migration timeout on large datasets** | If tables are large, the UPDATE JOIN may take time. Consider batching or running outside peak hours |

---

## 7. Pre-Migration Checklist

- [ ] Take full database backup (mysqldump)
- [ ] Run `php artisan down` to enable maintenance mode
- [ ] Verify current row counts for all affected tables
- [ ] Check for duplicate affiliate_links per product+marketplace
- [ ] Run migration
- [ ] Run verification queries
- [ ] Verify application works in maintenance mode
- [ ] Run `php artisan up`
- [ ] Monitor error logs for 24 hours

---

## 8. Post-Migration Cleanup (Future Sprint)

- [ ] Drop `deprecated_affiliate_links` table
- [ ] Make `score_total` non-nullable
- [ ] Remove old model files (AffiliateLink, AffiliateClick, ProductPrice)
- [ ] Remove old Filament Resource directories
- [ ] Run `php artisan optimize`
