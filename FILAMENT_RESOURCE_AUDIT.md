# Filament Resource Audit — Per-Resource Analysis

**Reference Sources:**
- Migrations: [`database/migrations/2026_01_01_000001_create_cekdulu_tables.php`](database/migrations/2026_01_01_000001_create_cekdulu_tables.php)
- Models: [`app/Models/*.php`](app/Models/)
- Correct reference resources: [`MembershipPlanResource`](app/Filament/Resources/MembershipPlanResource.php), [`TransactionResource`](app/Filament/Resources/TransactionResource.php)

---

## 1. ProductResource

### Current State
[`ProductResource.php`](app/Filament/Resources/ProductResource.php:19)

### Actual Migration Columns (`products` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `category_id` | FK→categories | nullable |
| `brand_id` | FK→brands | nullable |
| `name` | string | |
| `slug` | string | unique |
| `short_description` | text | nullable |
| `description` | longText | nullable |
| `specifications` | json | nullable |
| `pros` | json | nullable |
| `cons` | json | nullable |
| `thumbnail` | string | nullable |
| `worth_it_score` | tinyint(3) | default 70 |
| `admin_score_adjustment` | integer | default 0 |
| `lowest_price` | bigint | nullable, index |
| `status` | enum(draft,published,archived) | default draft |
| `is_featured` | boolean | default false |
| `is_trending` | boolean | default false |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`category_id`, `brand_id`, `name`, `slug`, `short_description`, `description`, `specifications`, `pros`, `cons`, `thumbnail`, `worth_it_score`, `lowest_price`, `status`, `is_featured`, `is_trending`, `admin_score_adjustment`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ✅ Yes | Keep |
| `title` | ❌ No | **REMOVE** — does not exist on products table |
| `slug` | ✅ Yes | Keep |
| `description` | ✅ Yes | Keep |
| `content` | ❌ No | **REMOVE** — does not exist on products table |
| `price` | ❌ No | **REMOVE** — use `lowest_price` instead |
| `affiliate_url` | ❌ No | **REMOVE** — affiliate URLs are on `affiliate_links` table |
| `worth_it_score` | ✅ Yes | Keep |
| `is_active` | ❌ No | **REMOVE** — use `status` enum instead |
| `status` | ✅ Yes | Keep |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `category_id` | Select→relationship | FK to categories |
| `brand_id` | Select→relationship | FK to brands |
| `short_description` | Textarea | Exists in DB, missing from form |
| `specifications` | KeyValue or Repeater | JSON field for specs |
| `pros` | Repeater | JSON array of pros |
| `cons` | Repeater | JSON array of cons |
| `thumbnail` | FileUpload | Image upload |
| `admin_score_adjustment` | TextInput→numeric | Score adjustment |
| `lowest_price` | TextInput→numeric | Auto-calculated, could be disabled |
| `is_featured` | Toggle | Boolean flag |
| `is_trending` | Toggle | Boolean flag |

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | Keep |
| `title` | **REMOVE** — not in DB |
| `slug` | Keep |
| `status` | Keep (badge) |
| `created_at` | Keep |

**Add to table:** `category_id` (via relationship), `brand_id` (via relationship), `worth_it_score`, `is_featured`, `is_trending`

---

## 2. CategoryResource

### Current State
[`CategoryResource.php`](app/Filament/Resources/CategoryResource.php:19)

### Actual Migration Columns (`categories` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `name` | string | |
| `slug` | string | unique |
| `icon` | string | nullable |
| `description` | text | nullable |
| `is_active` | boolean | default true, index |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`name`, `slug`, `icon`, `description`, `is_active`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ✅ Yes | Keep |
| `title` | ❌ No | **REMOVE** |
| `slug` | ✅ Yes | Keep |
| `description` | ✅ Yes | Keep |
| `content` | ❌ No | **REMOVE** |
| `price` | ❌ No | **REMOVE** |
| `affiliate_url` | ❌ No | **REMOVE** |
| `worth_it_score` | ❌ No | **REMOVE** |
| `is_active` | ✅ Yes | Keep |
| `status` | ❌ No | **REMOVE** — categories use `is_active` boolean, not status enum |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `icon` | TextInput | Icon class/name string |

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | Keep |
| `title` | **REMOVE** |
| `slug` | Keep |
| `status` | **REMOVE** — replace with `is_active` IconColumn(boolean) |
| `created_at` | Keep |

---

## 3. BrandResource

### Current State
[`BrandResource.php`](app/Filament/Resources/BrandResource.php:19)

### Actual Migration Columns (`brands` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `name` | string | |
| `slug` | string | unique |
| `logo` | string | nullable |
| `description` | text | nullable |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`name`, `slug`, `logo`, `description`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ✅ Yes | Keep |
| `title` | ❌ No | **REMOVE** |
| `slug` | ✅ Yes | Keep |
| `description` | ✅ Yes | Keep |
| `content` | ❌ No | **REMOVE** |
| `price` | ❌ No | **REMOVE** |
| `affiliate_url` | ❌ No | **REMOVE** |
| `worth_it_score` | ❌ No | **REMOVE** |
| `is_active` | ❌ No | **REMOVE** — brands table has NO `is_active` column |
| `status` | ❌ No | **REMOVE** |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `logo` | FileUpload | Brand logo image |

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | Keep |
| `title` | **REMOVE** |
| `slug` | Keep |
| `status` | **REMOVE** — no status on brands |
| `created_at` | Keep |

**Add to table:** `logo` (ImageColumn), product count (relationship)

---

## 4. MarketplaceResource

### Current State
[`MarketplaceResource.php`](app/Filament/Resources/MarketplaceResource.php:19)

### Actual Migration Columns (`marketplaces` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `name` | string | |
| `slug` | string | unique |
| `logo` | string | nullable |
| `base_url` | string | nullable |
| `is_active` | boolean | default true, index |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`name`, `slug`, `logo`, `base_url`, `is_active`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ✅ Yes | Keep |
| `title` | ❌ No | **REMOVE** |
| `slug` | ✅ Yes | Keep |
| `description` | ❌ No | **REMOVE** — no description on marketplaces |
| `content` | ❌ No | **REMOVE** |
| `price` | ❌ No | **REMOVE** |
| `affiliate_url` | ❌ No | **REMOVE** |
| `worth_it_score` | ❌ No | **REMOVE** |
| `is_active` | ✅ Yes | Keep |
| `status` | ❌ No | **REMOVE** — uses `is_active` boolean |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `logo` | FileUpload | Marketplace logo |
| `base_url` | TextInput | Base URL of marketplace |

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | Keep |
| `title` | **REMOVE** |
| `slug` | Keep |
| `status` | **REMOVE** — replace with `is_active` IconColumn(boolean) |
| `created_at` | Keep |

**Add to table:** `base_url`, `logo` (ImageColumn)

---

## 5. ProductPriceResource

### Current State
[`ProductPriceResource.php`](app/Filament/Resources/ProductPriceResource.php:19)

### Actual Migration Columns (`product_prices` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `product_id` | FK→products | cascadeOnDelete |
| `marketplace_id` | FK→marketplaces | cascadeOnDelete |
| `seller_name` | string | nullable |
| `product_url` | text | |
| `price` | unsignedBigint | index |
| `original_price` | unsignedBigint | nullable |
| `discount` | string | nullable |
| `rating` | decimal(3,2) | nullable |
| `sold_count` | unsignedInteger | default 0 |
| `review_count` | unsignedInteger | default 0 |
| `is_recommended` | boolean | default false |
| `last_updated_at` | timestamp | nullable |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`product_id`, `marketplace_id`, `seller_name`, `product_url`, `price`, `original_price`, `discount`, `rating`, `sold_count`, `review_count`, `is_recommended`, `last_updated_at`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ❌ No | **REMOVE** |
| `title` | ❌ No | **REMOVE** |
| `slug` | ❌ No | **REMOVE** |
| `description` | ❌ No | **REMOVE** |
| `content` | ❌ No | **REMOVE** |
| `price` | ✅ Yes | Keep |
| `affiliate_url` | ❌ No | **REMOVE** — use `product_url` instead |
| `worth_it_score` | ❌ No | **REMOVE** |
| `is_active` | ❌ No | **REMOVE** — no is_active on product_prices |
| `status` | ❌ No | **REMOVE** |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `product_id` | Select→relationship | FK to products |
| `marketplace_id` | Select→relationship | FK to marketplaces |
| `seller_name` | TextInput | Seller/store name |
| `product_url` | TextInput→url | Product page URL |
| `original_price` | TextInput→numeric | Original (before discount) price |
| `discount` | TextInput | Discount string (e.g., "50%") |
| `rating` | TextInput→numeric | Product rating (0.00-5.00) |
| `sold_count` | TextInput→numeric | Units sold |
| `review_count` | TextInput→numeric | Review count |
| `is_recommended` | Toggle | Recommended badge |
| `last_updated_at` | DateTimePicker | Last price update |

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | **REMOVE** |
| `title` | **REMOVE** |
| `slug` | **REMOVE** |
| `status` | **REMOVE** |
| `created_at` | Keep |

**Add to table:** `product_id` (via relationship), `marketplace_id` (via relationship), `price` (formatted), `seller_name`, `rating`, `is_recommended` (IconColumn)

---

## 6. AffiliateLinkResource

### Current State
[`AffiliateLinkResource.php`](app/Filament/Resources/AffiliateLinkResource.php:19)

### Actual Migration Columns (`affiliate_links` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `product_id` | FK→products | cascadeOnDelete |
| `marketplace_id` | FK→marketplaces | cascadeOnDelete |
| `product_price_id` | FK→product_prices | nullable, nullOnDelete |
| `affiliate_url` | text | |
| `campaign_name` | string | nullable |
| `is_active` | boolean | default true, index |
| `click_count` | unsignedInteger | default 0 |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`product_id`, `marketplace_id`, `product_price_id`, `affiliate_url`, `campaign_name`, `is_active`, `click_count`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ❌ No | **REMOVE** |
| `title` | ❌ No | **REMOVE** |
| `slug` | ❌ No | **REMOVE** |
| `description` | ❌ No | **REMOVE** |
| `content` | ❌ No | **REMOVE** |
| `price` | ❌ No | **REMOVE** |
| `affiliate_url` | ✅ Yes | Keep |
| `worth_it_score` | ❌ No | **REMOVE** |
| `is_active` | ✅ Yes | Keep |
| `status` | ❌ No | **REMOVE** — uses `is_active` boolean |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `product_id` | Select→relationship | FK to products |
| `marketplace_id` | Select→relationship | FK to marketplaces |
| `product_price_id` | Select→relationship | FK to product_prices (nullable) |
| `campaign_name` | TextInput | Campaign tracking name |
| `click_count` | TextInput→numeric | Read-only counter |

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | **REMOVE** |
| `title` | **REMOVE** |
| `slug` | **REMOVE** |
| `status` | **REMOVE** — replace with `is_active` IconColumn(boolean) |
| `created_at` | Keep |

**Add to table:** `product.name` (via relationship), `marketplace.name` (via relationship), `affiliate_url`, `campaign_name`, `click_count`

---

## 7. AffiliateClickResource

### Current State
[`AffiliateClickResource.php`](app/Filament/Resources/AffiliateClickResource.php:19)

### Actual Migration Columns (`affiliate_clicks` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `affiliate_link_id` | FK→affiliate_links | cascadeOnDelete |
| `product_id` | FK→products | nullable, nullOnDelete |
| `marketplace_id` | FK→marketplaces | nullable, nullOnDelete |
| `ip_address` | string(45) | nullable |
| `user_agent` | text | nullable |
| `referrer` | text | nullable |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`affiliate_link_id`, `product_id`, `marketplace_id`, `ip_address`, `user_agent`, `referrer`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ❌ No | **REMOVE** |
| `title` | ❌ No | **REMOVE** |
| `slug` | ❌ No | **REMOVE** |
| `description` | ❌ No | **REMOVE** |
| `content` | ❌ No | **REMOVE** |
| `price` | ❌ No | **REMOVE** |
| `affiliate_url` | ❌ No | **REMOVE** |
| `worth_it_score` | ❌ No | **REMOVE** |
| `is_active` | ❌ No | **REMOVE** |
| `status` | ❌ No | **REMOVE** |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `affiliate_link_id` | Select→relationship | FK to affiliate_links |
| `product_id` | Select→relationship | FK to products (nullable) |
| `marketplace_id` | Select→relationship | FK to marketplaces (nullable) |
| `ip_address` | TextInput | Read-only IP log |
| `user_agent` | Textarea | Read-only UA log |
| `referrer` | TextInput | Read-only referrer log |

**Note:** AffiliateClicks are typically **read-only logs** — the form should be minimal or disabled. The real value is in the table view.

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | **REMOVE** |
| `title` | **REMOVE** |
| `slug` | **REMOVE** |
| `status` | **REMOVE** |
| `created_at` | Keep |

**Add to table:** `affiliate_link_id` (via relationship), `product.name` (via relationship), `marketplace.name` (via relationship), `ip_address`, `referrer`

---

## 8. ArticleResource

### Current State
[`ArticleResource.php`](app/Filament/Resources/ArticleResource.php:19)

### Actual Migration Columns (`articles` table)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint AI | |
| `user_id` | FK→users | nullable, nullOnDelete |
| `title` | string | |
| `slug` | string | unique |
| `excerpt` | text | nullable |
| `content` | longText | nullable |
| `featured_image` | string | nullable |
| `seo_title` | string | nullable |
| `meta_description` | text | nullable |
| `status` | enum(draft,published,archived) | default draft, index |
| `published_at` | timestamp | nullable, index |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

### Model Fillable
`user_id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `seo_title`, `meta_description`, `status`, `published_at`

### Current Form Fields vs Actual Columns

| Form Field | Exists in DB? | Action |
|---|---|---|
| `name` | ❌ No | **REMOVE** — articles use `title`, not `name` |
| `title` | ✅ Yes | Keep |
| `slug` | ✅ Yes | Keep |
| `description` | ❌ No | **REMOVE** — articles use `excerpt`, not `description` |
| `content` | ✅ Yes | Keep |
| `price` | ❌ No | **REMOVE** |
| `affiliate_url` | ❌ No | **REMOVE** |
| `worth_it_score` | ❌ No | **REMOVE** |
| `is_active` | ❌ No | **REMOVE** — articles use `status` enum |
| `status` | ✅ Yes | Keep |

### Missing Fields to ADD
| Field | Type | Reason |
|---|---|---|
| `user_id` | Select→relationship | Author (FK to users) |
| `excerpt` | Textarea | Article summary |
| `featured_image` | FileUpload | Cover image |
| `seo_title` | TextInput | SEO-optimized title |
| `meta_description` | Textarea | Meta description |
| `published_at` | DateTimePicker | Publish timestamp |

### Table Columns to Fix
| Current Column | Action |
|---|---|
| `id` | Keep |
| `name` | **REMOVE** |
| `title` | Keep |
| `slug` | Keep |
| `status` | Keep (badge) |
| `created_at` | Keep |

**Add to table:** `user.name` (via relationship), `published_at`, `featured_image` (ImageColumn)

---

## Summary of Changes Required

| Resource | Fields to REMOVE | Fields to ADD | Table Columns to FIX |
|---|---|---|---|
| **ProductResource** | `title`, `content`, `price`, `affiliate_url`, `is_active` | `category_id`, `brand_id`, `short_description`, `specifications`, `pros`, `cons`, `thumbnail`, `admin_score_adjustment`, `lowest_price`, `is_featured`, `is_trending` | Remove `title`, add category/brand/score/featured/trending |
| **CategoryResource** | `title`, `content`, `price`, `affiliate_url`, `worth_it_score`, `status` | `icon` | Remove `title`, `status`; add `is_active`(IconColumn) |
| **BrandResource** | `title`, `content`, `price`, `affiliate_url`, `worth_it_score`, `is_active`, `status` | `logo` | Remove `title`, `status`; add `logo`(ImageColumn) |
| **MarketplaceResource** | `title`, `description`, `content`, `price`, `affiliate_url`, `worth_it_score`, `status` | `logo`, `base_url` | Remove `title`, `status`; add `logo`, `base_url`, `is_active` |
| **ProductPriceResource** | `name`, `title`, `slug`, `description`, `content`, `affiliate_url`, `worth_it_score`, `is_active`, `status` | `product_id`, `marketplace_id`, `seller_name`, `product_url`, `original_price`, `discount`, `rating`, `sold_count`, `review_count`, `is_recommended`, `last_updated_at` | Complete rewrite needed |
| **AffiliateLinkResource** | `name`, `title`, `slug`, `description`, `content`, `price`, `worth_it_score`, `status` | `product_id`, `marketplace_id`, `product_price_id`, `campaign_name`, `click_count` | Remove `name`, `title`, `slug`, `status`; add relationships + click_count |
| **AffiliateClickResource** | `name`, `title`, `slug`, `description`, `content`, `price`, `affiliate_url`, `worth_it_score`, `is_active`, `status` | `affiliate_link_id`, `product_id`, `marketplace_id`, `ip_address`, `user_agent`, `referrer` | Complete rewrite needed |
| **ArticleResource** | `name`, `description`, `price`, `affiliate_url`, `worth_it_score`, `is_active` | `user_id`, `excerpt`, `featured_image`, `seo_title`, `meta_description`, `published_at` | Remove `name`; add user, excerpt, published_at |

## Improvements Beyond Bug Fixes

### Form Improvements (following MembershipPlanResource pattern)
1. **Use `Section` layout** — Group related fields (e.g., "Basic Info", "Media", "SEO")
2. **Use `columns(2)`** — Two-column layouts for better space utilization
3. **Add proper labels** — Indonesian labels for admin UX consistency
4. **Add `required()` validation** — Mark required fields
5. **Add `unique(ignoreRecord: true)`** — For slug fields
6. **Use `FileUpload`** — For images (thumbnail, logo, featured_image)
7. **Use `Repeater`** — For JSON arrays (pros, cons, specifications, features)
8. **Use `RichEditor`** — For content/long text fields
9. **Use `DateTimePicker`** — For timestamp fields

### Table Improvements
1. **Add proper labels** — Indonesian column headers
2. **Add `searchable()`** — On name/title fields
3. **Add `sortable()`** — On numeric/date fields
4. **Use `badge()`** — For status columns with color mapping
5. **Use `IconColumn`** — For boolean fields (is_active, is_featured, etc.)
6. **Use `ImageColumn`** — For logo/thumbnail/featured_image
7. **Add relationship columns** — Show related model names
8. **Add `toggleable(isToggledHiddenByDefault: true)`** — For less important columns

### Filter Improvements
1. **Add `SelectFilter`** — For foreign key relationships (category, brand, marketplace)
2. **Add `TernaryFilter`** — For boolean fields (is_active, is_featured, is_trending)
3. **Add `Filter`** — For status enum fields

### Action Improvements
1. **Add `ViewAction::make()`** — For read-only detail views
2. **Add `DeleteAction::make()`** — For single-record deletion
3. **Keep `EditAction::make()`** — For editing
4. **Keep `DeleteBulkAction::make()`** — For bulk deletion

### Navigation Improvements
1. **Add `navigationGroup`** — Group related resources (e.g., "Products", "Content", "Marketing")
2. **Add `navigationSort`** — Order within groups
3. **Use descriptive `navigationIcon`** — Different icons per resource (not all `heroicon-o-rectangle-stack`)

---

## Implementation Order

| Order | Resource | Complexity | Reason |
|---|---|---|---|
| 1 | **CategoryResource** | Low | Simple model, few fields |
| 2 | **BrandResource** | Low | Simple model, few fields |
| 3 | **MarketplaceResource** | Low | Simple model, few fields |
| 4 | **ArticleResource** | Medium | More fields, RichEditor, FileUpload |
| 5 | **ProductResource** | Medium-High | Complex form with Repeaters, relationships |
| 6 | **ProductPriceResource** | Medium | Multiple relationships, numeric fields |
| 7 | **AffiliateLinkResource** | Medium | Relationships, read-only counter |
| 8 | **AffiliateClickResource** | Low | Mostly read-only, simple form |
