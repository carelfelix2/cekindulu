# Sprint 1: Database Refactor Design

## CekDulu — Final Database Architecture

---

## 1. Final Table Structure (18 Tables)

### 1.1 Core Entities (Stay as-is)

#### `users` — UNCHANGED
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK, auto-increment |
| name | string(255) | required |
| email | string(255) | unique |
| phone | string(20) | nullable |
| role | enum('admin','member') | default 'member' |
| avatar | string(255) | nullable |
| email_verified_at | timestamp | nullable |
| password | string(255) | required |
| remember_token | string(100) | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

#### `categories` — UNCHANGED
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| name | string(255) | required |
| slug | string(255) | unique |
| icon | string(255) | nullable |
| description | text | nullable |
| is_active | boolean | default true, indexed |
| created_at | timestamp | |
| updated_at | timestamp | |

#### `brands` — UNCHANGED
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| name | string(255) | required |
| slug | string(255) | unique |
| logo | string(255) | nullable |
| description | text | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

#### `marketplaces` — UNCHANGED
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| name | string(255) | required |
| slug | string(255) | unique |
| logo | string(255) | nullable |
| base_url | string(255) | nullable |
| is_active | boolean | default true, indexed |
| created_at | timestamp | |
| updated_at | timestamp | |

#### `products` — ADD `lowest_price` becomes computed, add `score_total`
| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | bigint unsigned | PK | |
| category_id | bigint unsigned | FK→categories, nullable, nullOnDelete | |
| brand_id | bigint unsigned | FK→brands, nullable, nullOnDelete | |
| name | string(255) | required | |
| slug | string(255) | unique | |
| short_description | text | nullable | |
| description | longText | nullable | |
| specifications | json | nullable | |
| pros | json | nullable | |
| cons | json | nullable | |
| thumbnail | string(255) | nullable | |
| worth_it_score | unsignedTinyInt | default 70, indexed | |
| admin_score_adjustment | integer | default 0 | |
| **score_total** | **integer** | **generated: worth_it_score + admin_score_adjustment, indexed** | **NEW — computed column** |
| lowest_price | unsignedBigInt | nullable, indexed | Keep as cached value, updated via observer |
| status | enum('draft','published','archived') | default 'draft', indexed | |
| is_featured | boolean | default false, indexed | |
| is_trending | boolean | default false, indexed | |
| created_at | timestamp | | |
| updated_at | timestamp | | |

#### `product_images` — UNCHANGED
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| product_id | bigint unsigned | FK→products, cascadeOnDelete |
| image_url | string(255) | required |
| sort_order | integer | default 0 |
| created_at | timestamp | |
| updated_at | timestamp | |

#### `articles` — UNCHANGED
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| user_id | bigint unsigned | FK→users, nullable, nullOnDelete |
| title | string(255) | required |
| slug | string(255) | unique |
| excerpt | text | nullable |
| content | longText | nullable |
| featured_image | string(255) | nullable |
| seo_title | string(255) | nullable |
| meta_description | text | nullable |
| status | enum('draft','published','archived') | default 'draft', indexed |
| published_at | timestamp | nullable, indexed |
| created_at | timestamp | |
| updated_at | timestamp | |

#### `article_product` — UNCHANGED
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| article_id | bigint unsigned | FK→articles, cascadeOnDelete |
| product_id | bigint unsigned | FK→products, cascadeOnDelete |
| — | unique(article_id, product_id) | |

### 1.2 Membership Tables (Stay as-is)

#### `membership_plans` — UNCHANGED
#### `transactions` — UNCHANGED
#### `user_memberships` — UNCHANGED

### 1.3 Renamed / New Tables

#### `product_offers` — RENAMED FROM `product_prices`
| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | bigint unsigned | PK | |
| product_id | bigint unsigned | FK→products, cascadeOnDelete | |
| marketplace_id | bigint unsigned | FK→marketplaces, cascadeOnDelete | |
| seller_name | string(255) | nullable | |
| **seller_type** | **enum('official','regular')** | **default 'regular'** | **NEW** |
| price | unsignedBigInt | indexed | |
| original_price | unsignedBigInt | nullable | |
| **discount_percentage** | **unsignedTinyInt** | **nullable** | **NEW — computed on save instead of string** |
| **shipping_cost** | **unsignedBigInt** | **nullable, default 0** | **NEW** |
| **estimated_delivery** | **string(100)** | **nullable** | **NEW — e.g. '2-3 hari'** |
| **stock_status** | **enum('in_stock','low_stock','out_of_stock','pre_order')** | **default 'in_stock'** | **NEW** |
| **stock_quantity** | **unsignedInteger** | **nullable** | **NEW** |
| rating | decimal(3,2) | nullable | |
| review_count | unsignedInteger | default 0 | |
| sold_count | unsignedInteger | default 0 | |
| product_url | text | required | |
| **affiliate_url** | **text** | **nullable** | **NEW — merged from affiliate_links** |
| **coupon_available** | **boolean** | **default false** | **NEW** |
| **voucher_available** | **boolean** | **default false** | **NEW** |
| **cashback_information** | **string(255)** | **nullable** | **NEW** |
| **is_official_store** | **boolean** | **default false** | **NEW** |
| is_recommended | boolean | default false | |
| is_active | boolean | default true, indexed | |
| **last_checked_at** | **timestamp** | **nullable** | **NEW — replaces last_updated_at** |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| — | index(product_id, marketplace_id) | | |

#### `offer_clicks` — RENAMED FROM `affiliate_clicks`
| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | bigint unsigned | PK | |
| **product_offer_id** | **bigint unsigned** | **FK→product_offers, cascadeOnDelete** | **NEW — replaces affiliate_link_id** |
| product_id | bigint unsigned | FK→products, nullable, nullOnDelete | |
| marketplace_id | bigint unsigned | FK→marketplaces, nullable, nullOnDelete | |
| **user_id** | **bigint unsigned** | **FK→users, nullable, nullOnDelete** | **NEW** |
| ip_address | string(45) | nullable | |
| user_agent | text | nullable | |
| referrer | text | nullable | |
| **clicked_at** | **timestamp** | **nullable** | **NEW** |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| — | index(product_offer_id) | | |
| — | index(product_id, marketplace_id) | | |

#### `price_histories` — NEW TABLE
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| product_offer_id | bigint unsigned | FK→product_offers, cascadeOnDelete |
| old_price | unsignedBigInt | nullable |
| new_price | unsignedBigInt | required |
| changed_at | timestamp | required |
| created_at | timestamp | |
| updated_at | timestamp | |
| — | index(product_offer_id) | |
| — | index(changed_at) | |

#### `price_alerts` — NEW TABLE
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| user_id | bigint unsigned | FK→users, cascadeOnDelete |
| product_id | bigint unsigned | FK→products, cascadeOnDelete |
| product_offer_id | bigint unsigned | FK→product_offers, nullable, nullOnDelete |
| target_price | unsignedBigInt | required |
| is_active | boolean | default true, indexed |
| triggered_at | timestamp | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |
| — | index(user_id, is_active) | |

#### `product_tags` — NEW TABLE
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| name | string(255) | required |
| slug | string(255) | unique |
| created_at | timestamp | |
| updated_at | timestamp | |

#### `product_tag` — NEW PIVOT TABLE
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| product_id | bigint unsigned | FK→products, cascadeOnDelete |
| tag_id | bigint unsigned | FK→product_tags, cascadeOnDelete |
| — | unique(product_id, tag_id) | |

#### `wishlists` — NEW TABLE
| Column | Type | Constraints |
|--------|------|-------------|
| id | bigint unsigned | PK |
| user_id | bigint unsigned | FK→users, cascadeOnDelete |
| product_id | bigint unsigned | FK→products, cascadeOnDelete |
| created_at | timestamp | |
| updated_at | timestamp | |
| — | unique(user_id, product_id) | |

---

## 2. Existing Table Mapping

| Current Table | Action | New Table |
|---------------|--------|-----------|
| users | ✅ STAY | users |
| categories | ✅ STAY | categories |
| brands | ✅ STAY | brands |
| marketplaces | ✅ STAY | marketplaces |
| products | ✅ STAY (add score_total) | products |
| product_images | ✅ STAY | product_images |
| **product_prices** | **🔄 RENAME + EXPAND** | **product_offers** |
| **affiliate_links** | **🗑️ DEPRECATE** | — (merged into product_offers.affiliate_url) |
| **affiliate_clicks** | **🔄 RENAME + EXPAND** | **offer_clicks** |
| articles | ✅ STAY | articles |
| article_product | ✅ STAY | article_product |
| membership_plans | ✅ STAY | membership_plans |
| transactions | ✅ STAY | transactions |
| user_memberships | ✅ STAY | user_memberships |
| — | **🆕 NEW** | price_histories |
| — | **🆕 NEW** | price_alerts |
| — | **🆕 NEW** | product_tags |
| — | **🆕 NEW** | product_tag |
| — | **🆕 NEW** | wishlists |

---

## 3. Which Tables Stay

1. `users` — No changes needed
2. `categories` — No changes needed
3. `brands` — No changes needed
4. `marketplaces` — No changes needed
5. `products` — Add `score_total` generated column
6. `product_images` — No changes needed
7. `articles` — No changes needed
8. `article_product` — No changes needed
9. `membership_plans` — No changes needed
10. `transactions` — No changes needed
11. `user_memberships` — No changes needed

---

## 4. Which Tables Are Renamed

| Old Name | New Name | Reason |
|----------|----------|--------|
| `product_prices` | `product_offers` | Better reflects domain concept: a marketplace listing/offer, not just a price |
| `affiliate_clicks` | `offer_clicks` | Aligns with new naming; tracks clicks on offers rather than abstract links |

---

## 5. Which Tables Are Merged

**`affiliate_links` → merged into `product_offers`**

The `affiliate_links` table is fully deprecated. Its data is absorbed into `product_offers`:

- `affiliate_links.affiliate_url` → `product_offers.affiliate_url` (nullable)
- `affiliate_links.is_active` → `product_offers.is_active`
- `affiliate_links.click_count` → removed (clicks tracked via `offer_clicks` count)
- `affiliate_links.campaign_name` → removed (not relevant at offer level; can be added later as campaign system)
- `affiliate_links.product_price_id` → removed (no longer needed since offer IS the price record)

**Why merge?** In the current architecture, every `product_price` has one or more `affiliate_links`. This is a 1:N relationship that adds unnecessary complexity. In reality, each marketplace offer has exactly one affiliate URL. Merging eliminates:
- The join query on every product page
- The `$price->affiliateLinks->first()` pattern throughout the frontend
- The `product_price_id` nullable FK
- The entire `affiliate_links` model and resource

---

## 6. Which Tables Are Deprecated

| Table | Replacement | Data Migration |
|-------|-------------|----------------|
| `affiliate_links` | `product_offers.affiliate_url` | Migrate affiliate_url to product_offers; click_count is lost (replaced by offer_clicks count) |

---

## 7. Foreign Key Relationships

```
users
  └─ hasMany → transactions
  └─ hasMany → user_memberships
  └─ hasMany → wishlists
  └─ hasMany → price_alerts
  └─ hasMany → offer_clicks (via user_id)

categories
  └─ hasMany → products

brands
  └─ hasMany → products

marketplaces
  └─ hasMany → product_offers
  └─ hasMany → offer_clicks

products
  └─ belongsTo → categories (nullable, nullOnDelete)
  └─ belongsTo → brands (nullable, nullOnDelete)
  └─ hasMany → product_images (cascadeOnDelete)
  └─ hasMany → product_offers (cascadeOnDelete)
  └─ hasMany → offer_clicks (nullable, nullOnDelete)
  └─ hasMany → price_alerts
  └─ hasMany → wishlists
  └─ belongsToMany → articles (via article_product)
  └─ belongsToMany → product_tags (via product_tag)

product_offers
  └─ belongsTo → products (cascadeOnDelete)
  └─ belongsTo → marketplaces (cascadeOnDelete)
  └─ hasMany → offer_clicks (cascadeOnDelete)
  └─ hasMany → price_histories (cascadeOnDelete)
  └─ hasMany → price_alerts (nullable, nullOnDelete)

offer_clicks
  └─ belongsTo → product_offers (cascadeOnDelete)
  └─ belongsTo → products (nullable, nullOnDelete)
  └─ belongsTo → marketplaces (nullable, nullOnDelete)
  └─ belongsTo → users (nullable, nullOnDelete)

articles
  └─ belongsTo → users (nullable, nullOnDelete)
  └─ belongsToMany → products (via article_product)

membership_plans
  └─ hasMany → transactions
  └─ hasMany → user_memberships

transactions
  └─ belongsTo → users (cascadeOnDelete)
  └─ belongsTo → membership_plans (cascadeOnDelete)
  └─ hasOne → user_memberships (cascadeOnDelete)

user_memberships
  └─ belongsTo → users (cascadeOnDelete)
  └─ belongsTo → membership_plans (cascadeOnDelete)
  └─ belongsTo → transactions (cascadeOnDelete)
```

---

## 8. Index Strategy

### Primary Indexes (auto)
- All `id` columns — PK, auto-increment

### Unique Indexes
- `categories.slug`
- `brands.slug`
- `marketplaces.slug`
- `products.slug`
- `articles.slug`
- `product_tags.slug`
- `transactions.invoice_number`
- `article_product(article_id, product_id)`
- `product_tag(product_id, tag_id)`
- `wishlists(user_id, product_id)`

### Foreign Key Indexes (auto by Laravel)
- All `*_id` columns referencing FKs

### Performance Indexes
- `categories.is_active`
- `marketplaces.is_active`
- `products.status`
- `products.is_featured`
- `products.is_trending`
- `products.worth_it_score`
- `products.score_total` (NEW)
- `products.lowest_price`
- `product_offers.price`
- `product_offers.is_active`
- `product_offers(product_id, marketplace_id)` — composite
- `offer_clicks(product_offer_id)`
- `offer_clicks(product_id, marketplace_id)` — composite
- `offer_clicks(created_at)` — for time-range queries
- `price_histories(product_offer_id)`
- `price_histories(changed_at)` — for time-range queries
- `price_alerts(user_id, is_active)` — composite
- `articles.status`
- `articles.published_at`
- `membership_plans.is_active`
- `transactions.status`
- `user_memberships.is_active`
- `user_memberships(user_id, is_active)` — composite

---

## 9. Cascade Rules

| FK Column | Parent Table | On Delete | Rationale |
|-----------|-------------|-----------|-----------|
| products.category_id | categories | SET NULL | Category deleted → products keep existing |
| products.brand_id | brands | SET NULL | Brand deleted → products keep existing |
| product_images.product_id | products | CASCADE | Product deleted → images gone |
| product_offers.product_id | products | CASCADE | Product deleted → offers gone |
| product_offers.marketplace_id | marketplaces | CASCADE | Marketplace deleted → offers gone |
| offer_clicks.product_offer_id | product_offers | CASCADE | Offer deleted → clicks gone |
| offer_clicks.product_id | products | SET NULL | Product deleted → click log preserved |
| offer_clicks.marketplace_id | marketplaces | SET NULL | Marketplace deleted → click log preserved |
| offer_clicks.user_id | users | SET NULL | User deleted → click log preserved |
| price_histories.product_offer_id | product_offers | CASCADE | Offer deleted → history gone |
| price_alerts.user_id | users | CASCADE | User deleted → alerts gone |
| price_alerts.product_id | products | CASCADE | Product deleted → alerts gone |
| price_alerts.product_offer_id | product_offers | SET NULL | Offer deleted → alert preserved (generic) |
| wishlists.user_id | users | CASCADE | User deleted → wishlist gone |
| wishlists.product_id | products | CASCADE | Product deleted → wishlist entries gone |
| article_product.article_id | articles | CASCADE | Article deleted → pivot gone |
| article_product.product_id | products | CASCADE | Product deleted → pivot gone |
| product_tag.product_id | products | CASCADE | Product deleted → pivot gone |
| product_tag.tag_id | product_tags | CASCADE | Tag deleted → pivot gone |
| articles.user_id | users | SET NULL | User deleted → article preserved |
| transactions.user_id | users | CASCADE | User deleted → transactions gone |
| transactions.membership_plan_id | membership_plans | CASCADE | Plan deleted → transactions gone |
| user_memberships.user_id | users | CASCADE | User deleted → membership gone |
| user_memberships.membership_plan_id | membership_plans | CASCADE | Plan deleted → memberships gone |
| user_memberships.transaction_id | transactions | CASCADE | Transaction deleted → membership gone |

---

## 10. Nullable Rules

| Table | Column | Nullable? | Reason |
|-------|--------|-----------|--------|
| products | category_id | YES | Product can exist without category |
| products | brand_id | YES | Product can exist without brand |
| products | short_description | YES | Optional |
| products | description | YES | Optional |
| products | specifications | YES | JSON, optional |
| products | pros | YES | JSON, optional |
| products | cons | YES | JSON, optional |
| products | thumbnail | YES | Image upload, optional |
| products | lowest_price | YES | Computed, may not exist yet |
| product_images | — | NO | All fields required |
| product_offers | seller_name | YES | Not all offers have seller name |
| product_offers | seller_type | NO | Default 'regular' |
| product_offers | original_price | YES | May not have original price |
| product_offers | discount_percentage | YES | Computed, may be null |
| product_offers | shipping_cost | YES | May not be known |
| product_offers | estimated_delivery | YES | May not be known |
| product_offers | stock_quantity | YES | May not be exposed |
| product_offers | rating | YES | May not have ratings |
| product_offers | affiliate_url | YES | May not have affiliate program |
| product_offers | coupon_available | NO | Default false |
| product_offers | voucher_available | NO | Default false |
| product_offers | cashback_information | YES | Optional |
| product_offers | is_official_store | NO | Default false |
| product_offers | last_checked_at | YES | May not have been checked yet |
| offer_clicks | product_id | YES | Denormalized for query speed |
| offer_clicks | marketplace_id | YES | Denormalized for query speed |
| offer_clicks | user_id | YES | Guest clicks have no user |
| offer_clicks | ip_address | YES | May not be available |
| offer_clicks | user_agent | YES | May not be available |
| offer_clicks | referrer | YES | May not be available |
| offer_clicks | clicked_at | YES | May be set after creation |
| price_histories | old_price | YES | First record has no old price |
| price_alerts | product_offer_id | YES | Alert can be product-wide |
| price_alerts | triggered_at | YES | Not triggered yet |
| articles | user_id | YES | Article may be by anonymous |
| articles | excerpt | YES | Optional |
| articles | content | YES | Optional |
| articles | featured_image | YES | Optional |
| articles | seo_title | YES | Optional |
| articles | meta_description | YES | Optional |
| articles | published_at | YES | Not published yet |

---

## 11. Data Migration Strategy

### Phase A: Create New Tables (no data loss)

1. **Create `product_offers`** table with all new columns
2. **Create `offer_clicks`** table with all new columns
3. **Create `price_histories`** table
4. **Create `price_alerts`** table
5. **Create `product_tags`** table
6. **Create `product_tag`** pivot table
7. **Create `wishlists`** table
8. **Add `score_total`** column to `products`

### Phase B: Migrate Data from Old Tables

#### Step 1: `product_prices` → `product_offers`

```sql
INSERT INTO product_offers (
    product_id, marketplace_id, seller_name, seller_type,
    price, original_price, discount_percentage,
    rating, review_count, sold_count,
    product_url, affiliate_url,
    is_recommended, is_active, last_checked_at,
    created_at, updated_at
)
SELECT
    pp.product_id, pp.marketplace_id, pp.seller_name, 'regular',
    pp.price, pp.original_price,
    CASE
        WHEN pp.original_price IS NOT NULL AND pp.original_price > pp.price
        THEN ROUND(((pp.original_price - pp.price) / pp.original_price) * 100)
        ELSE NULL
    END,
    pp.rating, pp.review_count, pp.sold_count,
    pp.product_url, al.affiliate_url,
    pp.is_recommended, COALESCE(al.is_active, true), pp.last_updated_at,
    pp.created_at, pp.updated_at
FROM product_prices pp
LEFT JOIN affiliate_links al
    ON al.product_price_id = pp.id
    AND al.product_id = pp.product_id
    AND al.marketplace_id = pp.marketplace_id;
```

**Important**: If multiple `affiliate_links` exist for one `product_price`, only the first one (by ID) is used. This is acceptable because the old schema allowed 1:N but in practice each price has exactly one affiliate link.

#### Step 2: `affiliate_clicks` → `offer_clicks`

```sql
INSERT INTO offer_clicks (
    product_offer_id, product_id, marketplace_id, user_id,
    ip_address, user_agent, referrer, clicked_at,
    created_at, updated_at
)
SELECT
    po.id, ac.product_id, ac.marketplace_id, NULL,
    ac.ip_address, ac.user_agent, ac.referrer, ac.created_at,
    ac.created_at, ac.updated_at
FROM affiliate_clicks ac
JOIN product_offers po ON po.product_id = ac.product_id
    AND po.marketplace_id = ac.marketplace_id;
```

**Note**: This JOIN may produce multiple matches if multiple offers exist for the same product+marketplace. To handle this, first deduplicate by matching the affiliate_link_id through a subquery:

```sql
INSERT INTO offer_clicks (...)
SELECT
    po.id, ac.product_id, ac.marketplace_id, NULL,
    ac.ip_address, ac.user_agent, ac.referrer, ac.created_at,
    ac.created_at, ac.updated_at
FROM affiliate_clicks ac
JOIN affiliate_links al ON al.id = ac.affiliate_link_id
JOIN product_offers po ON po.product_id = al.product_id
    AND po.marketplace_id = al.marketplace_id
    AND (
        -- Match by product_price_id if available
        (al.product_price_id IS NOT NULL AND po.id = (
            SELECT pp_map.id FROM product_offers pp_map
            WHERE pp_map.product_id = al.product_id
            AND pp_map.marketplace_id = al.marketplace_id
            LIMIT 1
        ))
        OR
        -- Fallback: match first offer for product+marketplace
        (al.product_price_id IS NULL AND po.id = (
            SELECT po2.id FROM product_offers po2
            WHERE po2.product_id = al.product_id
            AND po2.marketplace_id = al.marketplace_id
            ORDER BY po2.id ASC
            LIMIT 1
        ))
    );
```

#### Step 3: Generate initial `price_histories`

For each `product_offer`, create an initial price history record:

```sql
INSERT INTO price_histories (product_offer_id, old_price, new_price, changed_at, created_at, updated_at)
SELECT id, NULL, price, created_at, NOW(), NOW()
FROM product_offers;
```

#### Step 4: Update `products.score_total`

```sql
UPDATE products
SET score_total = worth_it_score + admin_score_adjustment;
```

### Phase C: Verify Data Integrity

Run verification queries:
- `SELECT COUNT(*) FROM product_prices` vs `SELECT COUNT(*) FROM product_offers`
- `SELECT COUNT(*) FROM affiliate_clicks` vs `SELECT COUNT(*) FROM offer_clicks`
- Spot-check random records for data accuracy

### Phase D: Drop Old Tables (after verification)

```sql
DROP TABLE IF EXISTS affiliate_clicks;
DROP TABLE IF EXISTS affiliate_links;
DROP TABLE IF EXISTS product_prices;
```

---

## 12. Risks

| # | Risk | Impact | Mitigation |
|---|------|--------|------------|
| 1 | **Data loss during migration** | High — lost affiliate click history | Run migration in transaction; verify counts before and after; keep backup |
| 2 | **Multiple affiliate_links per product_price** | Medium — data ambiguity | Use `GROUP BY` or `FIRST()` aggregation; document limitation |
| 3 | **affiliate_clicks with orphan affiliate_link_id** | Low — clicks with no matching offer | LEFT JOIN and log orphans; set product_offer_id to NULL |
| 4 | **Frontend breaks during deployment** | High — 500 errors for users | Deploy new models + resources first, then run migration; use feature flags |
| 5 | **Filament Resources reference old models** | High — admin panel breaks | Update all Filament Resources in same deploy as migration |
| 6 | **Route `affiliate.go` uses AffiliateLink model** | High — redirect breaks | Update controller to use ProductOffer; keep backward-compatible route |
| 7 | **Blade views use `$price->affiliateLinks->first()`** | Medium — product show page breaks | Update Blade views to use `$offer->affiliate_url` directly |
| 8 | **Product `bestPrice()` uses `$this->prices`** | Low — method name changes | Update to `$this->offers` and rename method to `bestOffer()` |
| 9 | **`lowest_price` on products becomes stale** | Medium — incorrect price display | Add observer/model event to recalculate on offer save/delete |
| 10 | **Downtime during migration** | Medium — site unavailable | Run migration during low-traffic window; use Laravel maintenance mode |

---

## 13. Rollback Strategy

### If migration fails before old tables are dropped:
1. Simply delete the new tables
2. No data loss — old tables are untouched
3. Fix the migration and retry

### If migration fails after old tables are dropped:
1. **Restore from backup** (database dump taken before migration)
2. Alternative: Use the reverse migration:

```sql
-- Reverse: offer_clicks → affiliate_clicks
INSERT INTO affiliate_clicks (affiliate_link_id, product_id, marketplace_id, ip_address, user_agent, referrer, created_at, updated_at)
SELECT
    (SELECT id FROM affiliate_links WHERE product_id = oc.product_id AND marketplace_id = oc.marketplace_id LIMIT 1),
    oc.product_id, oc.marketplace_id, oc.ip_address, oc.user_agent, oc.referrer, oc.created_at, oc.updated_at
FROM offer_clicks oc;

-- Reverse: product_offers → product_prices
INSERT INTO product_prices (product_id, marketplace_id, seller_name, product_url, price, original_price, discount, rating, sold_count, review_count, is_recommended, last_updated_at, created_at, updated_at)
SELECT product_id, marketplace_id, seller_name, product_url, price, original_price, CAST(discount_percentage AS CHAR), rating, sold_count, review_count, is_recommended, last_checked_at, created_at, updated_at
FROM product_offers;

-- Reverse: affiliate_links recreation (from product_offers that have affiliate_url)
INSERT INTO affiliate_links (product_id, marketplace_id, product_price_id, affiliate_url, is_active, click_count, created_at, updated_at)
SELECT po.product_id, po.marketplace_id, NULL, po.affiliate_url, po.is_active, 0, po.created_at, po.updated_at
FROM product_offers po WHERE po.affiliate_url IS NOT NULL;
```

### Full rollback procedure:
1. `php artisan down` — maintenance mode
2. Run reverse SQL queries above
3. Run `php artisan migrate:rollback` for new migrations
4. Delete new model files
5. Restore old model files from Git
6. `php artisan up`

---

## 14. Recommended Implementation Order

### Step 1: Create New Models (no DB changes yet)
- Create `ProductOffer.php` model
- Create `OfferClick.php` model
- Create `PriceHistory.php` model
- Create `PriceAlert.php` model
- Create `ProductTag.php` model
- Create `Wishlist.php` model
- Update `Product.php` — add `offers()`, `tags()`, `wishlistedByUsers()`, `priceAlerts()` relationships
- Update `User.php` — add `wishlists()`, `priceAlerts()`, `offerClicks()` relationships
- Update `Marketplace.php` — add `offers()`, `offerClicks()` relationships

### Step 2: Create New Filament Resources
- `ProductOfferResource.php` — replaces ProductPriceResource
- `OfferClickResource.php` — replaces AffiliateClickResource
- `PriceHistoryResource.php` — read-only log viewer
- `PriceAlertResource.php` — admin management
- `ProductTagResource.php` — simple CRUD
- `WishlistResource.php` — read-only viewer

### Step 3: Update Existing Filament Resources
- `ProductResource.php` — update `prices()` → `offers()`, update `prices_count` → `offers_count`
- Remove `AffiliateLinkResource.php` — deprecated
- Remove `AffiliateClickResource.php` — replaced by OfferClickResource
- Remove `ProductPriceResource.php` — replaced by ProductOfferResource

### Step 4: Create Database Migration
- Single migration file creating all new tables
- Add `score_total` column to products
- Data migration commands in the same migration (or separate seeder)

### Step 5: Run Data Migration
- Execute the SQL migration scripts
- Verify data integrity

### Step 6: Update Controllers
- `AffiliateRedirectController.php` — use `ProductOffer` instead of `AffiliateLink`
- `ProductController.php` — update queries to use `offers()` instead of `prices()`

### Step 7: Update Blade Views
- `products/show.blade.php` — update `$price->affiliateLinks->first()` → `$offer->affiliate_url`
- `products/show.blade.php` — update `$product->prices` → `$product->offers`
- `product-card.blade.php` — update `$product->bestPrice()` → `$product->bestOffer()`

### Step 8: Update Routes
- Update `Route::get('/go/{affiliateLink}')` → `Route::get('/go/{productOffer}')`
- Keep old route as redirect for backward compatibility (optional)

### Step 9: Drop Old Tables
- After verification period, drop `affiliate_clicks`, `affiliate_links`, `product_prices`

### Step 10: Clean Up
- Delete old model files: `AffiliateLink.php`, `AffiliateClick.php`, `ProductPrice.php`
- Delete old Filament Resource directories
- Run `php artisan optimize`
- Run full test suite

---

## Entity Relationship Diagram

```mermaid
erDiagram
    users ||--o{ transactions : has
    users ||--o{ user_memberships : has
    users ||--o{ wishlists : has
    users ||--o{ price_alerts : has
    users ||--o{ offer_clicks : "records"

    categories ||--o{ products : contains
    brands ||--o{ products : contains

    products ||--o{ product_images : has
    products ||--o{ product_offers : offers
    products ||--o{ offer_clicks : tracks
    products ||--o{ price_alerts : monitors
    products ||--o{ wishlists : appears_in
    products }o--o| categories : belongs_to
    products }o--o| brands : belongs_to
    products }o--o{ articles : referenced_in
    products }o--o{ product_tags : tagged

    product_offers ||--o{ offer_clicks : receives
    product_offers ||--o{ price_histories : has
    product_offers ||--o{ price_alerts : targets
    product_offers }o--|| products : belongs_to
    product_offers }o--|| marketplaces : belongs_to

    marketplaces ||--o{ product_offers : lists
    marketplaces ||--o{ offer_clicks : logs

    articles ||--o{ article_product : pivots
    products ||--o{ article_product : pivots

    product_tags ||--o{ product_tag : pivots
    products ||--o{ product_tag : pivots

    membership_plans ||--o{ transactions : generates
    membership_plans ||--o{ user_memberships : defines
    users ||--o{ transactions : makes
    transactions ||--o| user_memberships : results_in
    users ||--o{ user_memberships : holds
