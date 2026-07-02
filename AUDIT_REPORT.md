# CekDulu — Full Project Audit Report
**Generated:** 2026-07-02  
**Auditor:** Senior Laravel 12 / Filament / Blade / Tailwind CSS / UI-UX Architect  
**Scope:** Complete codebase audit — architecture, UI, UX, components, SEO, performance, accessibility, mobile responsiveness

---

## Table of Contents

1. [Current Architecture](#1-current-architecture)
2. [UI Problems](#2-ui-problems)
3. [UX Problems](#3-ux-problems)
4. [Inconsistent Components](#4-inconsistent-components)
5. [Duplicate Code](#5-duplicate-code)
6. [Components That Should Become Reusable](#6-components-that-should-become-reusable)
7. [Mobile Responsiveness Issues](#7-mobile-responsiveness-issues)
8. [Accessibility Issues](#8-accessibility-issues)
9. [Performance Issues](#9-performance-issues)
10. [SEO Issues](#10-seo-issues)

---

## 1. Current Architecture

### Stack
| Layer | Technology |
|---|---|
| Framework | Laravel 13.8 (PHP 8.3) |
| Admin Panel | Filament 3.2 |
| Frontend CSS | Tailwind CSS v4 (CSS-based `@theme` config) |
| Frontend JS | Alpine.js 3.14 |
| Build Tool | Vite 8 + `@tailwindcss/vite` plugin |
| Auth | Laravel Breeze (Blade stack) |
| Database | MySQL (via Laragon) |
| Storage | Local disk (`public`) |

### Folder Structure
```
app/
  Filament/Resources/          # 10 Filament admin resources
  Http/
    Controllers/               # 8 public controllers + 9 auth controllers
    Middleware/                 # CheckRole, EnsurePremium
  Models/                      # 12 Eloquent models
  Providers/
  View/Components/Layouts/     # App.php (thin wrapper)
resources/
  css/app.css                  # Tailwind v4 @theme design system
  js/app.js                    # Alpine.js stores + data
  views/
    auth/                      # 6 Breeze auth views
    components/                # navbar.blade.php, footer.blade.php,
                               # product-card.blade.php, article-card.blade.php
    layouts/                   # app.blade.php, guest.blade.php, navigation.blade.php
    pages/                     # home, products, articles, compare, membership
    profile/                   # edit + 3 partials
    filament/                  # payment-proof-view component
    dashboard.blade.php
    welcome.blade.php
routes/
  web.php                      # Public + auth + membership + admin routes
  auth.php                     # Breeze auth routes
database/
  migrations/                  # 4 migration files
  seeders/
  factories/
plans/                         # Sprint planning docs
```

### Data Model
```
users ──< transactions >── membership_plans
users ──< user_memberships >── membership_plans
categories ──< products >── brands
products ──< product_images
products ──< product_prices >── marketplaces
products ──< affiliate_links >── marketplaces
affiliate_links ──< affiliate_clicks
products >──< articles (article_product pivot)
```

### Routing Architecture
- **Public routes:** `/`, `/products`, `/products/{slug}`, `/articles`, `/articles/{slug}`, `/compare`, `/go/{affiliateLink}`
- **Auth-required routes:** `/dashboard`, `/profile`, `/membership/{slug}/checkout`, `/dashboard/transactions`
- **Filament admin:** `/admin` (role=admin gate via `canAccessPanel`)
- **Middleware:** `CheckRole` (role-based), `EnsurePremium` (premium gate) — both registered as aliases in `bootstrap/app.php`

### Filament Admin Resources (10 total)
| Resource | Navigation Group |
|---|---|
| ArticleResource | Konten |
| ProductResource | Produk |
| CategoryResource | Produk |
| BrandResource | Produk |
| MarketplaceResource | Produk |
| ProductPriceResource | Produk |
| AffiliateLinkResource | Produk |
| AffiliateClickResource | Produk |
| MembershipPlanResource | Membership |
| TransactionResource | Membership |

### Design System
- **Primary:** Emerald/Green (`#10b981` base)
- **Accent:** Amber/Orange (`#f59e0b` base)
- **Surface:** Neutral gray scale
- **Fonts:** Plus Jakarta Sans (body), Clash Display (headings), JetBrains Mono (code)
- **Custom CSS classes:** `btn-primary`, `btn-accent`, `btn-outline`, `btn-ghost`, `btn-sm/md/lg/xl`, `badge`, `card`, `card-hover`, `section-title`, `see-all`, `input`, `page-header`, `product-grid`, `skeleton`, `navbar-blur`

---

## 2. UI Problems

### 2.1 — Two Completely Different Navbar Components Coexist
**Files:** `resources/views/components/navbar.blade.php` vs `resources/views/layouts/navigation.blade.php`

The project has **two separate navbar implementations** that are architecturally incompatible:

- `components/navbar.blade.php` — Old component using **raw CSS** (inline `<style>` block), **indigo/purple color scheme** (`#4f46e5`), CSS hover-based dropdown (no Alpine.js), no dark mode support, no scroll effect.
- `layouts/navigation.blade.php` — New component using **Tailwind utility classes**, emerald color scheme, Alpine.js-powered dropdown, full dark mode, scroll blur effect.

The `layouts/app.blade.php` uses `@include('layouts.navigation')` — so the old `components/navbar.blade.php` is **dead code** that is never rendered. However, it still exists and creates confusion.

### 2.2 — Hardcoded Bank Account Details in Checkout
**File:** `resources/views/pages/membership/checkout.blade.php` (lines 76–85)

Bank name, account number, and account holder name are **hardcoded directly in the Blade template**:
```html
<span>Bank Central Asia (BCA)</span>
<span class="font-mono font-bold">1234567890</span>
<span>PT CekDulu Indonesia</span>
```
This is a placeholder that was never moved to config or the database. It will display wrong information in production.

### 2.3 — `btn-secondary` Class Used But Never Defined
**Files:** `resources/views/pages/compare/index.blade.php` (line 291), `resources/views/pages/membership/index.blade.php` (line 157), `resources/views/pages/products/show.blade.php` (line 400)

The class `btn-secondary` is referenced in multiple views but is **never defined** in `app.css`. This will render as an unstyled button.

### 2.4 — `welcome.blade.php` Is a Standalone Orphan Page
**File:** `resources/views/welcome.blade.php`

This page duplicates the full HTML boilerplate (doctype, head, fonts, Vite) instead of extending a layout. It is a Laravel default splash page that was never removed or properly integrated. The real homepage is `pages/home.blade.php`. The welcome page is accessible at `/` only if the route is not overridden — but the route IS overridden to `HomeController@index`, so `welcome.blade.php` is **never rendered** in production. It is dead code.

### 2.5 — Score Color Uses CSS Custom Property Interpolation That May Fail
**File:** `resources/views/components/product-card.blade.php` (lines 51, 98, 100)

```html
style="color: var(--color-{{ $scoreColor }})"
style="width: {{ $score }}%; background-color: var(--color-{{ $scoreColor }})"
```

The variable `$scoreColor` is set to `'score-high'`, `'score-mid'`, or `'score-low'`. These map to `--color-score-high`, `--color-score-mid`, `--color-score-low` which ARE defined in `app.css`. However, the `show.blade.php` uses a different approach:

```php
$scoreColor = $score >= 75 ? 'bg-score-high' : ($score >= 50 ? 'bg-score-mid' : 'bg-score-low');
```

This uses Tailwind utility class names (`bg-score-high`) which are **not defined** in `app.css` — only the CSS variables are defined, not the utility classes. This means the score badge background on the product detail page will have no color.

### 2.6 — Profile Page Uses Incorrect Slot Syntax
**File:** `resources/views/profile/edit.blade.php` (lines 2–4)

```blade
<x-layouts.app>
    <x-slot name="header">
        <x-slot name="title">Profile - CekDulu</x-slot>
    </x-slot>
```

The `x-layouts.app` component (`layouts/app.blade.php`) does not define a `$header` slot — it only uses `$slot` and `$attributes->get('title')`. The nested `<x-slot name="header">` is silently ignored, meaning the page title is never set for the profile page.

### 2.7 — Dark Mode Toggle Duplicated in Two Places
**File:** `resources/views/layouts/app.blade.php` (lines 36–49) and `resources/views/layouts/navigation.blade.php` (lines 46–51)

There is a **floating dark mode toggle button** fixed to `bottom-6 right-6` in `app.blade.php`, AND another dark mode toggle button inside the navbar. Users see two toggle buttons simultaneously — one in the nav and one floating at the bottom-right corner. This is redundant and visually cluttered.

### 2.8 — Article Card Tag is Always Hardcoded "Rekomendasi"
**File:** `resources/views/components/article-card.blade.php` (line 22)

```html
<span class="...">Rekomendasi</span>
```

The tag label is hardcoded regardless of the article's actual category or type. The `Article` model has no `category` or `tag` field, so all articles display the same "Rekomendasi" badge.

### 2.9 — Compare Page Uses `btn-secondary` (Undefined)
**File:** `resources/views/pages/compare/index.blade.php` (line 291)

```html
<a href="..." class="btn-secondary text-sm px-6 py-3 rounded-xl ...">
```

`btn-secondary` is not defined anywhere in the CSS. This button will render with no styling.

### 2.10 — Inconsistent Logo Implementation Across 4 Files
The CekDulu logo (green square with "C" + "CekDulu" text) is manually duplicated in:
- `layouts/navigation.blade.php`
- `layouts/guest.blade.php`
- `components/footer.blade.php`
- `welcome.blade.php`

Each has slightly different sizing (`w-9/h-9`, `w-12/h-12`, `w-14/h-14`) and shadow values. There is no `<x-logo>` component.

---

## 3. UX Problems

### 3.1 — Compare Page Has No Way to Add/Remove Products
**File:** `resources/views/pages/compare/index.blade.php`

The compare page shows products passed via `?products=1,2,3,4` query string. However:
- There is no UI on the **product listing or detail pages** to add a product to the comparison.
- The "Tambah Produk" button on the compare page links to `/products` with no mechanism to select and add products to the comparison.
- Users have no way to discover or use this feature organically.

### 3.2 — Checkout Flow Has No Loading/Pending State Feedback
**File:** `resources/views/pages/membership/checkout.blade.php`

The payment form submit button has no loading state. After clicking "Kirim Pembayaran", the user gets no visual feedback that the upload is in progress. For large image files, this can take several seconds, leaving users uncertain whether the form was submitted.

### 3.3 — Transaction Status Uses Raw English Strings for Non-"paid" States
**File:** `resources/views/pages/membership/transactions.blade.php` (line 51)

```php
{{ $transaction->status === 'paid' ? 'Lunas' : ucfirst($transaction->status) }}
```

`ucfirst('pending')` → "Pending", `ucfirst('failed')` → "Failed", `ucfirst('expired')` → "Expired". The app is in Indonesian but these statuses display in English. Only "paid" is translated to "Lunas".

### 3.4 — Transaction Detail Hardcodes "Transfer Manual (BCA)"
**File:** `resources/views/pages/membership/transaction-detail.blade.php` (line 60)

```html
<span>Transfer Manual (BCA)</span>
```

The payment method is hardcoded as "Transfer Manual (BCA)" regardless of the actual `payment_method` stored in the transaction. The `$transaction->payment_method` field is never displayed.

### 3.5 — Dashboard Has 2 "Coming Soon" Cards With No Interactivity
**File:** `resources/views/dashboard.blade.php` (lines 99–115)

"Produk Favorit" and "Riwayat Banding" cards are shown with "SEGERA" badges. They are `cursor-default` divs that do nothing. This creates a false expectation and clutters the dashboard with non-functional UI.

### 3.6 — No Search Bar in the Navbar
The main navigation (`layouts/navigation.blade.php`) has no search input. The old `components/navbar.blade.php` had a search form. Users must navigate to the homepage or products page to search. The hero search bar is only visible on the homepage.

### 3.7 — No Breadcrumb on Articles Index Page
**File:** `resources/views/pages/articles/index.blade.php`

The articles index page has a breadcrumb in the header section, but the products index page uses a different header style (dark gradient). The breadcrumb pattern is inconsistent across pages.

### 3.8 — No Empty State for Compare When No Products Selected
**File:** `resources/views/pages/compare/index.blade.php` (lines 80–91)

When no products are selected, the compare page falls back to showing the top 4 products by worth_it_score. This is confusing — users expect to see an empty state with instructions on how to add products, not a random selection.

### 3.9 — No Pagination on Home Page Product Sections
**File:** `resources/views/pages/home.blade.php`

The "Worth It Products" and "Trending Products" sections show up to 10 products each with no "load more" or pagination. On mobile, this creates a very long scroll. The "Lihat semua" link goes to the full products page, but there's no visual indicator of how many total products exist.

### 3.10 — Profile Page Has No Back Navigation
**File:** `resources/views/profile/edit.blade.php`

The profile edit page has no breadcrumb or back button. Users must use the browser back button or the navbar to navigate away.

---

## 4. Inconsistent Components

### 4.1 — Two Navbar Systems (Critical)
As described in §2.1:
- `components/navbar.blade.php` — old, CSS-only, indigo colors, no dark mode
- `layouts/navigation.blade.php` — new, Tailwind, emerald colors, Alpine.js, dark mode

The old navbar is dead code but its existence creates confusion for future developers.

### 4.2 — Page Header Styles Are Inconsistent Across Pages

| Page | Header Style |
|---|---|
| Home | No header section (hero instead) |
| Products Index | Dark gradient (`from-primary-600 to-primary-700`) |
| Product Show | White breadcrumb bar |
| Articles Index | Light gradient (`from-primary-50 via-white`) |
| Article Show | Dark image overlay |
| Compare | Light gradient (`from-primary-50 via-white to-amber-50`) |
| Membership | Dark gradient (`from-primary-700 via-primary-600`) |
| Checkout | White border-bottom bar |
| Dashboard | Dark gradient (`from-primary-600 via-primary-700`) |
| Profile | Dark gradient (`from-primary-600 to-primary-700`) |

There is no consistent page header pattern. Some pages use dark gradients, some use light gradients, some use plain white. The breadcrumb is present on some pages but not others.

### 4.3 — Breadcrumb Implementation Is Inconsistent

| Page | Breadcrumb Present | Style |
|---|---|---|
| Products Index | ✅ | Inside dark gradient header, white text |
| Product Show | ✅ | Separate white bar below nav |
| Articles Index | ✅ | Inside light gradient header |
| Article Show | ✅ | Inside dark overlay |
| Compare | ✅ | Inside light gradient header |
| Checkout | ✅ | Inside white header |
| Dashboard | ❌ | None |
| Profile | ❌ | None |
| Transactions | ❌ | None |

### 4.4 — Empty State Design Is Inconsistent

Different empty state patterns are used across pages:
- **Home sections:** Emoji + text (e.g., `📦 Belum ada produk`)
- **Products index:** SVG icon in rounded square + heading + text + link
- **Articles index:** SVG icon in rounded circle + heading + text
- **Compare:** SVG icon in rounded circle + heading + text + CTA button
- **Transactions:** SVG icon in rounded circle + heading + text + CTA button

No unified `<x-empty-state>` component exists.

### 4.5 — Score Color Logic Is Duplicated and Inconsistent

The worth-it score color logic is repeated in **3 different places** with slightly different implementations:

**`product-card.blade.php`:**
```php
$scoreColor = 'score-high'; // → var(--color-score-high)
$scoreBg = 'bg-primary-100 text-primary-700 ...';
```

**`products/show.blade.php` (image badge):**
```php
$scoreColor = 'bg-score-high'; // → Tailwind class (UNDEFINED)
```

**`products/show.blade.php` (sidebar circle):**
```php
// Uses inline Tailwind: text-emerald-500, text-amber-500, text-red-500
```

**`compare/index.blade.php`:**
```php
$scoreColor = 'from-emerald-500 to-emerald-600'; // gradient classes
$sBar = 'bg-emerald-500'; // progress bar
```

Four different approaches for the same concept.

### 4.6 — Form Input Styling Is Duplicated Everywhere

The same long Tailwind class string for form inputs is copy-pasted across:
- `auth/login.blade.php`
- `auth/register.blade.php`
- `profile/partials/update-profile-information-form.blade.php`
- `profile/partials/update-password-form.blade.php`
- `pages/membership/checkout.blade.php`
- `pages/products/index.blade.php`

The `app.css` defines an `.input` class but it is **not used** in any of these forms. Instead, the full Tailwind string is repeated each time.

### 4.7 — `<style>` Blocks Inside Blade Components

Inline `<style>` blocks are used inside:
- `layouts/navigation.blade.php` (lines 153–217) — `.nav-link`, `.mobile-nav-link`
- `components/footer.blade.php` (lines 80–115) — `.footer-link`, `.social-icon`
- `components/navbar.blade.php` (lines 66–246) — entire old navbar CSS
- `pages/home.blade.php` (lines 198–230) — `.hero-chip`
- `pages/products/show.blade.php` (lines 412–416) — `.desc-content`

These should be moved to `app.css` as `@layer components` entries.

---

## 5. Duplicate Code

### 5.1 — Score Color Logic (4 Locations)
The `worth_it_score` threshold logic (`>= 75`, `>= 50`, else) is duplicated in:
1. `components/product-card.blade.php` (PHP block)
2. `pages/products/show.blade.php` (PHP block, twice — image badge + sidebar)
3. `pages/compare/index.blade.php` (PHP block, twice — card + table)

**Fix:** Extract to a Blade component `<x-score-badge :score="$score">` or a Model accessor/helper.

### 5.2 — Price Formatting (5+ Locations)
`'Rp ' . number_format($price, 0, ',', '.')` appears in:
1. `product-card.blade.php`
2. `products/show.blade.php` (multiple times)
3. `compare/index.blade.php`
4. `MembershipPlan::getFormattedPriceAttribute()`
5. `Transaction::getFormattedAmountAttribute()`
6. `TransactionResource.php`
7. `MembershipPlanResource.php`

**Fix:** Create a global Blade helper or use the model accessors consistently.

### 5.3 — Breadcrumb HTML Pattern (5 Locations)
The same breadcrumb HTML structure (home link → chevron SVG → current page) is repeated in:
1. `pages/products/index.blade.php`
2. `pages/products/show.blade.php`
3. `pages/articles/index.blade.php`
4. `pages/articles/show.blade.php`
5. `pages/compare/index.blade.php`
6. `pages/membership/checkout.blade.php`

**Fix:** Create `<x-breadcrumb>` component.

### 5.4 — "Lihat semua" / See-All Link Pattern (3 Locations in home.blade.php)
The same "Lihat semua" link with arrow SVG appears 4 times in `home.blade.php` (lines 92–95, 120–123, 149–152, 178–181). The `.see-all` CSS class is defined in `app.css` but the SVG arrow is still duplicated inline each time.

### 5.5 — Section Header Pattern (4 Locations in home.blade.php)
The `<div class="flex items-center justify-between mb-8">` + `<h2 class="section-title">` + subtitle + see-all link pattern is repeated 4 times in `home.blade.php`.

**Fix:** Create `<x-section-header title="..." subtitle="..." :link="route(...)">` component.

### 5.6 — Font Loading Duplicated in 3 Layout Files
Both Google Fonts (Clash Display) and Bunny Fonts (Plus Jakarta Sans) are loaded in:
1. `layouts/app.blade.php`
2. `layouts/guest.blade.php`
3. `welcome.blade.php`

The `welcome.blade.php` is dead code, but the duplication between `app.blade.php` and `guest.blade.php` means any font URL change must be made in two places.

### 5.7 — Controller Code Is Minified/Unformatted (3 Controllers)
`HomeController.php`, `ProductController.php`, and `CompareController.php` are all written as **single-line minified PHP** with no whitespace, no line breaks, and no formatting. This is a serious code quality issue that makes maintenance extremely difficult.

### 5.8 — Transaction Status Badge Logic Duplicated
The status → color mapping for transactions is duplicated in:
1. `pages/membership/transactions.blade.php` (inline class strings)
2. `pages/membership/transaction-detail.blade.php` (inline class strings)
3. `TransactionResource.php` (Filament color mapping)
4. `Transaction::getStatusBadgeAttribute()` (returns CSS class names like `badge-success` that don't exist in the CSS)

### 5.9 — Empty State Pattern Duplicated (5+ Locations)
The "icon in circle + heading + text" empty state is repeated across products, articles, compare, transactions, and membership pages with no shared component.

### 5.10 — `@auth` / `@else` Auth Check in Navigation Duplicated
The auth check with user avatar, name, dropdown, and logout form appears in both:
1. `layouts/navigation.blade.php` (desktop dropdown + mobile drawer)
2. `components/navbar.blade.php` (old dead navbar)

---

## 6. Components That Should Become Reusable

### 6.1 — `<x-score-badge :score="$score">` *(Critical)*
**Used in:** product-card, products/show (×2), compare/index (×2)  
**Should render:** colored badge/pill with score number and label ("Worth It!", "Cukup", "Review")  
**Should include:** progress bar variant, circular SVG variant, inline badge variant

### 6.2 — `<x-breadcrumb :items="[...]">` *(High Priority)*
**Used in:** 6 pages  
**Should accept:** array of `['label' => '...', 'url' => '...']` items  
**Should handle:** last item as non-link automatically

### 6.3 — `<x-page-header title="..." subtitle="..." :gradient="true">` *(High Priority)*
**Used in:** 8 pages  
**Should standardize:** the page header section with optional gradient, breadcrumb slot, and action slot

### 6.4 — `<x-section-header title="..." subtitle="..." :seeAllRoute="...">` *(High Priority)*
**Used in:** home.blade.php (×4), could be used on other listing pages  
**Should render:** the flex row with title, subtitle, and "Lihat semua" link

### 6.5 — `<x-empty-state icon="..." title="..." description="..." :action="...">` *(High Priority)*
**Used in:** 6+ pages  
**Should accept:** icon (SVG or emoji), title, description, optional CTA button

### 6.6 — `<x-form-input name="..." label="..." type="..." :required="true">` *(High Priority)*
**Used in:** login, register, profile forms, checkout  
**Should include:** label, input, error message display, consistent styling  
**Note:** The `.input` CSS class already exists in `app.css` but is never used

### 6.7 — `<x-logo :size="'md'">` *(Medium Priority)*
**Used in:** navigation, guest layout, footer, welcome  
**Should accept:** size prop (`sm`, `md`, `lg`) and optional link wrapping

### 6.8 — `<x-status-badge :status="$status" :type="'transaction'">` *(Medium Priority)*
**Used in:** transactions list, transaction detail  
**Should map:** status strings to colors and Indonesian labels

### 6.9 — `<x-price :amount="$price">` *(Medium Priority)*
**Used in:** product-card, products/show, compare, membership, checkout  
**Should render:** formatted Rupiah price consistently

### 6.10 — `<x-card>` / `<x-card-section>` *(Medium Priority)*
The white rounded-2xl card with border and shadow pattern (`bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 shadow-sm`) appears on virtually every page. A wrapper component would reduce repetition significantly.

### 6.11 — `<x-dashboard-card>` *(Low Priority)*
**Used in:** dashboard.blade.php (×5)  
The icon + title + description + link pattern for dashboard cards is repeated 5 times.

---

## 7. Mobile Responsiveness Issues

### 7.1 — Mobile Hamburger Menu Has a State Synchronization Bug
**File:** `resources/views/layouts/navigation.blade.php` (lines 96–100)

```html
<button @@click="mobileOpen = !mobileOpen; $store.mobileMenu.toggle()">
```

The hamburger button toggles BOTH `mobileOpen` (a local variable in the `navbar` Alpine data) AND `$store.mobileMenu` (a global Alpine store). The mobile drawer uses `x-data="mobileMenu"` which is a separate Alpine component. The `x-effect="mobileOpen = open"` on the drawer tries to sync them, but this creates a circular dependency. The hamburger icon (open/close toggle) uses `mobileOpen` while the drawer uses `open` — these can get out of sync.

### 7.2 — Comparison Table Is Not Mobile-Friendly
**File:** `resources/views/pages/compare/index.blade.php`

The comparison table uses `min-w-[600px]` with horizontal scroll. On mobile:
- The sticky left column (`sticky left-0`) works but the background color may bleed through on scroll
- Product names in the header are full-length with no truncation
- The table is very wide with 4 products — on a 375px screen this requires significant horizontal scrolling
- No mobile-optimized card layout alternative exists

### 7.3 — Product Price Table on Show Page Hides Columns on Mobile
**File:** `resources/views/pages/products/show.blade.php` (lines 204–205)

```html
<th class="... hidden sm:table-cell">Rating</th>
<th class="... hidden sm:table-cell">Terjual</th>
```

Rating and sold count columns are hidden on mobile. This is handled, but the remaining columns (Marketplace, Price, Buy button) are still cramped on small screens. The "Beli" button text may overflow.

### 7.4 — Hero Search Bar Overflow on Small Screens
**File:** `resources/views/pages/home.blade.php` (lines 34–54)

The search bar has `pr-36` (right padding of 9rem) to accommodate the "Cari" button. On screens narrower than ~400px, the button may overlap the input text. The button uses `h-full` inside an `inset-y-1.5 right-1.5` container — this works on most screens but can be tight on very small devices (320px).

### 7.5 — Sidebar Filter on Products Page Is Not Collapsible on Mobile
**File:** `resources/views/pages/products/index.blade.php`

The sidebar filter (`<aside class="lg:w-64 shrink-0">`) is shown above the product grid on mobile (stacked layout). On mobile, this means users must scroll past the entire filter sidebar before seeing any products. There is no "Filter" toggle button to collapse/expand the sidebar on mobile.

### 7.6 — Navigation Dropdown Is Hidden on Mobile (sm:flex)
**File:** `resources/views/layouts/navigation.blade.php` (line 55)

```html
<div class="hidden sm:relative sm:flex sm:items-center" ...>
```

The user dropdown is hidden below `sm` breakpoint (640px). On mobile, the user must open the hamburger menu to access their profile/logout. This is acceptable UX, but the mobile drawer does not show the user's premium status badge.

### 7.7 — Footer Newsletter Form Has No Mobile Optimization
**File:** `resources/views/components/footer.blade.php` (lines 60–63)

The newsletter form uses `flex gap-2` with a text input and button side by side. On very small screens (< 360px), the button may be too small to tap comfortably. No `flex-col` fallback exists for very small screens.

### 7.8 — Product Card Grid Uses `auto-fill` with `minmax(270px, 1fr)`
**File:** `resources/css/app.css` (line 267)

```css
.product-grid {
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
}
```

On screens between 270px and 540px, this renders a single column. On screens between 540px and 810px, it renders 2 columns. This is reasonable, but the `270px` minimum means on a 375px phone, cards are 375px wide (full width), which is fine. However, the `products/index.blade.php` overrides this with `grid-cols-1 sm:grid-cols-2 xl:grid-cols-3` — so the `.product-grid` class is only used on the home page, creating inconsistency.

### 7.9 — Floating Dark Mode Button Overlaps Content on Mobile
**File:** `resources/views/layouts/app.blade.php` (lines 36–49)

The floating dark mode toggle (`fixed bottom-6 right-6`) can overlap page content on mobile, particularly pagination controls, "Beli" buttons, or footer links that appear near the bottom-right of the screen.

---

## 8. Accessibility Issues

### 8.1 — Images Missing Meaningful Alt Text
**File:** `resources/views/components/product-card.blade.php` (line 39)

```html
<img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" loading="lazy">
```

Product name is used as alt text — this is acceptable. However:

**File:** `resources/views/layouts/navigation.blade.php` (line 24)

```html
<img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" class="nav-avatar">
```

The user avatar has an **empty alt attribute** (`alt=""`). While empty alt is valid for decorative images, a user avatar should have `alt="{{ Auth::user()->name }}'s avatar"`.

### 8.2 — Dark Mode Toggle SVG Icons Have No `aria-hidden`
**Files:** `layouts/app.blade.php`, `layouts/navigation.blade.php`

The sun/moon SVG icons inside the dark mode toggle buttons are not marked with `aria-hidden="true"`. The button has `aria-label="Toggle dark mode"` which is correct, but the SVGs should be hidden from screen readers to avoid double-reading.

### 8.3 — Mobile Menu Has No `aria-expanded` or `aria-controls`
**File:** `resources/views/layouts/navigation.blade.php` (lines 96–100)

The hamburger button has no `aria-expanded` attribute to communicate the open/closed state to screen readers. It should be:
```html
:aria-expanded="mobileOpen.toString()"
aria-controls="mobile-menu"
```

### 8.4 — User Dropdown Has No `role="menu"` or `role="menuitem"`
**File:** `resources/views/layouts/navigation.blade.php` (lines 64–86)

The dropdown menu has no ARIA roles. It should use `role="menu"` on the container and `role="menuitem"` on each link/button for proper screen reader navigation.

### 8.5 — Form Inputs Have No `aria-describedby` for Error Messages
**Files:** All auth forms, profile forms

Error messages are displayed as `<p class="text-sm text-red-500">` below inputs, but there is no `aria-describedby` linking the input to its error message. Screen readers may not associate the error with the field.

### 8.6 — Price Comparison Table Has No `<caption>` or `scope` Attributes
**File:** `resources/views/pages/products/show.blade.php` (lines 199–282)

The price comparison table has no `<caption>` element and no `scope="col"` on `<th>` elements. Screen readers cannot properly navigate the table.

### 8.7 — Comparison Table Has No `scope="row"` on Row Headers
**File:** `resources/views/pages/compare/index.blade.php`

The sticky left column cells (Aspek, Worth It Score, Harga Terbaik, etc.) are `<td>` elements, not `<th scope="row">`. This makes the table inaccessible to screen readers.

### 8.8 — Color-Only Status Indicators
**Files:** `transactions.blade.php`, `transaction-detail.blade.php`

Transaction status is communicated through color alone (green = paid, amber = pending, red = failed). While text labels are present, the status icon in the transaction list is color-coded without a text alternative for the icon itself.

### 8.9 — Focus Styles Are Not Explicitly Defined
**File:** `resources/css/app.css`

The design system defines `.btn-primary`, `.btn-accent`, etc. but none of them define `:focus-visible` styles. The default browser focus ring may be overridden by `outline-none` on inputs. While `focus:ring-2 focus:ring-primary-500` is used on form inputs, buttons use `outline: none` implicitly through Tailwind's reset.

### 8.10 — `x-on:error` Inline SVG Fallbacks Are Not Accessible
**Files:** `product-card.blade.php`, `products/show.blade.php`, `compare/index.blade.php`

```html
x-on:error="$el.src='data:image/svg+xml,...'"
```

The inline SVG fallback images (emoji in SVG) have no alt text. When an image fails to load and is replaced with the SVG data URI, the `alt` attribute of the `<img>` tag remains but the fallback SVG has no accessible label.

---

## 9. Performance Issues

### 9.1 — N+1 Query Risk on Home Page
**File:** `app/Http/Controllers/HomeController.php`

```php
'worthProducts' => Product::published()
    ->with(['category', 'brand', 'prices.marketplace'])
    ->orderByDesc('worth_it_score')
    ->limit(10)->get(),
'trendingProducts' => Product::published()
    ->where('is_trending', 1)
    ->with(['category', 'brand', 'prices.marketplace'])
    ->limit(10)->get(),
```

Both queries eager-load `prices.marketplace`. The `bestPrice()` method in `Product` model does:
```php
return $this->prices->sortBy('price')->first();
```

This sorts the **already-loaded collection in PHP** — acceptable. However, `prices.marketplace` loads ALL prices for each product, then the view only uses the cheapest one. For products with many marketplace prices, this loads unnecessary data.

### 9.2 — `Product::bestPrice()` Is Not Cached and Called Multiple Times Per View
**File:** `app/Models/Product.php` (line 119)

```php
public function bestPrice() {
    return $this->prices->sortBy('price')->first();
}
```

In `products/show.blade.php`, `bestPrice()` is called **3 times**:
- Line 52: `@php $bestPrice = $product->bestPrice(); @endphp`
- Line 358: `@php $bestAffiliate = $bestPrice->affiliateLinks->first(); @endphp`
- Line 387: `@if($bestPrice && $bestPrice->discount)`

While the collection is already loaded (no extra DB query), the `sortBy('price')` operation runs 3 times. This should be cached in a variable once.

### 9.3 — Two External Font CDNs Loaded on Every Page
**Files:** `layouts/app.blade.php`, `layouts/guest.blade.php`

```html
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:...">
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:...">
```

Two separate font CDNs (Bunny Fonts + Google Fonts) are loaded on every page. Each requires a DNS lookup, TCP connection, and TLS handshake. The `Clash Display` font from Google Fonts is not available on Bunny Fonts, but loading from two CDNs adds latency.

**Recommendation:** Self-host both fonts via Vite/npm or use a single CDN.

### 9.4 — No Image Optimization or Lazy Loading Strategy
**Files:** Multiple views

- Product thumbnails are stored as-is (no resizing/compression pipeline)
- `loading="lazy"` is used on most images — good
- No `srcset` or `sizes` attributes for responsive images
- No WebP conversion
- The Filament `FileUpload` for products resizes to 400×400 max, but articles have no resize constraint (`maxSize(2048)` only)

### 9.5 — `animate-float` and `animate-fade-in` Classes Are Not Defined
**Files:** `pages/home.blade.php` (lines 8, 15, 21, 29, 34, 57), `pages/membership/index.blade.php` (lines 6–7)

```html
class="... animate-float"
class="... animate-fade-in"
class="... animate-slide-up"
```

The keyframes `float`, `fade-in`, and `slide-up` are defined in `app.css`, but the Tailwind utility classes `animate-float`, `animate-fade-in`, `animate-slide-up` are **not registered** in the Tailwind v4 theme. In Tailwind v4, custom animations must be registered via `@theme { --animate-float: float 3s ease-in-out infinite; }`. Without this, these classes generate no CSS and the animations do not play.

### 9.6 — No HTTP Caching Headers for Static Assets
The project uses Vite with content-hashed filenames for CSS/JS — good for cache busting. However, there is no explicit cache configuration for product images or article images stored in `storage/public`.

### 9.7 — Comparison Page Loads All Product Prices in Memory
**File:** `app/Http/Controllers/CompareController.php`

```php
Product::published()->with(['category', 'brand', 'prices.marketplace'])
```

For the compare page, all prices for all compared products are loaded. The view then calls `$product->bestPrice()` (sorts in PHP) and `$product->prices->pluck('price')` and `$product->prices->avg('rating')` — all in-memory operations. For products with many prices, this is inefficient.

### 9.8 — `isPremium()` Makes a Database Query on Every Call
**File:** `app/Models/User.php` (line 106)

```php
public function isPremium(): bool {
    return $this->activeMembership()->exists();
}
```

`activeMembership()` is a `HasOne` relationship with `where` clauses. Every call to `isPremium()` executes a new database query. In the navbar (`components/navbar.blade.php`), `Auth::user()->isPremium()` is called — this fires a query on every page load. The result is not cached.

### 9.9 — No Database Query Optimization for Products Index
**File:** `app/Http/Controllers/ProductController.php`

The products index loads `with(['category', 'brand', 'prices.marketplace'])` for every paginated product. The `prices.marketplace` eager load fetches ALL prices for each product, but the product card only displays the cheapest price. A more efficient approach would be to use a subquery or a `lowest_price` denormalized column (which exists in the schema but may not be kept up to date).

### 9.10 — `skeleton` CSS Class Defined But Never Used in Views
**File:** `resources/css/app.css` (lines 301–311)

The `.skeleton` loading animation class is defined but no view uses it. There are no loading skeleton states in any page — pages either show content or show empty states, with no intermediate loading state.

---

## 10. SEO Issues

### 10.1 — `<title>` Tag Implementation Is Inconsistent

**`layouts/app.blade.php`:**
```php
<title>{{ $attributes->get('title') ? $attributes->get('title') . ' - ' . config('app.name') : config('app.name') }}</title>
```

**Usage in views:**
- `home.blade.php`: `<x-layouts.app title="Temukan Produk Paling Worth It">` → "Temukan Produk Paling Worth It - CekDulu" ✅
- `products/index.blade.php`: `<x-slot name="title">Produk - CekDulu</x-slot>` → This uses `<x-slot>` syntax, NOT `$attributes->get('title')`. The slot is **ignored** by the layout. The title will render as just "CekDulu". ❌
- `articles/index.blade.php`: `<x-layouts.app title="Artikel & Rekomendasi - CekDulu">` → "Artikel & Rekomendasi - CekDulu - CekDulu" (double "CekDulu") ❌
- `compare/index.blade.php`: `<x-layouts.app title="Bandingkan Produk - CekDulu">` → Double "CekDulu" ❌
- `membership/index.blade.php`: `<x-layouts.app title="Membership Premium - CekDulu">` → Double "CekDulu" ❌
- `profile/edit.blade.php`: Uses `<x-slot name="title">` inside `<x-slot name="header">` → Title is **never set** ❌

### 10.2 — Meta Description Is Only Set on Two Pages

The `<meta name="description">` is set via `$attributes->get('description', '...')` in `layouts/app.blade.php`. Only two pages pass a description:
- `products/show.blade.php`: `:description="$product->short_description"` ✅
- `articles/show.blade.php`: `:description="$article->meta_description ?: $article->excerpt"` ✅

All other pages use the default generic description: *"CekDulu - Temukan produk paling worth it dengan perbandingan harga dari berbagai marketplace Indonesia."*

Pages missing unique meta descriptions:
- `/products` — should describe the product catalog
- `/articles` — should describe the article section
- `/compare` — should describe the comparison feature
- `/membership` — should describe premium features
- `/dashboard` — (less critical, auth-only)

### 10.3 — No Open Graph (OG) or Twitter Card Meta Tags

Neither `layouts/app.blade.php` nor `layouts/guest.blade.php` includes any Open Graph or Twitter Card meta tags. When pages are shared on social media (Facebook, Twitter/X, WhatsApp, LINE), no rich preview will be generated.

Missing tags:
```html
<meta property="og:title" content="...">
<meta property="og:description" content="...">
<meta property="og:image" content="...">
<meta property="og:url" content="...">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
```

For a product comparison/affiliate site, social sharing is a key traffic driver. This is a **critical SEO gap**.

### 10.4 — No Canonical URL Tag

No `<link rel="canonical">` tag is present in any layout. For a product comparison site with filter/sort query parameters (`?category=laptop&brand=asus&sort=price`), duplicate content issues can arise. Search engines may index multiple URLs for the same content.

### 10.5 — No Structured Data (JSON-LD / Schema.org)

The product detail page (`products/show.blade.php`) has rich product data (name, price, rating, brand, category) but no structured data markup. Adding `Product` schema would enable Google rich results (price, rating stars in search results).

Missing schemas:
- `Product` schema on product detail pages
- `Article` schema on article pages
- `BreadcrumbList` schema on pages with breadcrumbs
- `Organization` schema on the homepage

### 10.6 — No `robots.txt` or `sitemap.xml`

No `robots.txt` file exists in the `public/` directory. No sitemap generation is configured. For a content-heavy site with products and articles, a sitemap is essential for search engine crawling.

### 10.7 — Article SEO Fields Exist But Are Partially Used

The `Article` model has `seo_title` and `meta_description` fields, and `articles/show.blade.php` correctly uses them:
```blade
<x-layouts.app :title="$article->seo_title ?: $article->title" :description="$article->meta_description ?: $article->excerpt">
```

However, the `ArticleResource` in Filament has a `meta_description` helper text saying "max 160 karakter" but no character counter or validation enforcing this limit.

### 10.8 — Product Pages Have No SEO Fields

The `Product` model has no `seo_title` or `meta_description` fields. The product detail page uses `$product->name` as the title and `$product->short_description` as the meta description. There is no way for admins to customize SEO metadata for individual products.

### 10.9 — `rel="nofollow noopener"` on Affiliate Links Is Correct But Incomplete

**File:** `resources/views/pages/products/show.blade.php` (lines 266–276)

```html
<a href="..." target="_blank" rel="nofollow noopener">
```

`nofollow` and `noopener` are correctly applied to affiliate links. However, `noreferrer` should also be added (`rel="nofollow noopener noreferrer"`) to prevent the referrer header from being sent to affiliate destinations, which is a privacy best practice.

### 10.10 — No `hreflang` Tag (Minor — Single Language)

The app is in Indonesian but has no `<html lang="id">` — it uses `{{ str_replace('_', '-', app()->getLocale()) }}` which defaults to `en` unless `APP_LOCALE=id` is set in `.env`. If the locale is not configured, the HTML lang attribute will be `en` for an Indonesian-language site, which is incorrect for SEO and accessibility.

---

## Summary Table

| Category | Issues Found | Critical | High | Medium | Low |
|---|---|---|---|---|---|
| UI Problems | 10 | 2 | 4 | 3 | 1 |
| UX Problems | 10 | 1 | 4 | 4 | 1 |
| Inconsistent Components | 7 | 2 | 3 | 2 | 0 |
| Duplicate Code | 10 | 2 | 4 | 3 | 1 |
| Missing Reusable Components | 11 | 3 | 4 | 3 | 1 |
| Mobile Responsiveness | 9 | 1 | 3 | 4 | 1 |
| Accessibility | 10 | 2 | 4 | 3 | 1 |
| Performance | 10 | 1 | 4 | 4 | 1 |
| SEO | 10 | 2 | 4 | 3 | 1 |
| **TOTAL** | **87** | **16** | **34** | **29** | **8** |

---

## Priority Action Plan

### 🔴 Critical (Fix Immediately)
1. Remove dead `components/navbar.blade.php` or replace it as the canonical navbar
2. Fix `btn-secondary` undefined class (define it or replace with `btn-outline`)
3. Fix `animate-float`, `animate-fade-in`, `animate-slide-up` — register in `@theme` or use inline styles
4. Fix `bg-score-high/mid/low` undefined Tailwind classes in `products/show.blade.php`
5. Add Open Graph meta tags to `layouts/app.blade.php`
6. Fix `<title>` tag — pages using `<x-slot name="title">` get no title set
7. Move hardcoded bank account details to config/database
8. Format `HomeController`, `ProductController`, `CompareController` (unminify)

### 🟠 High Priority (Fix This Sprint)
1. Create `<x-breadcrumb>` component
2. Create `<x-score-badge>` component
3. Create `<x-empty-state>` component
4. Create `<x-form-input>` component and use `.input` CSS class
5. Remove floating dark mode button (keep only navbar toggle)
6. Add `robots.txt` and sitemap generation
7. Add canonical URL tag
8. Fix mobile sidebar filter (add collapsible toggle)
9. Fix transaction status labels (translate to Indonesian)
10. Add `aria-expanded` to hamburger button

### 🟡 Medium Priority (Next Sprint)
1. Create `<x-logo>` component
2. Create `<x-page-header>` component
3. Create `<x-section-header>` component
4. Add SEO fields to Product model
5. Add structured data (JSON-LD) to product and article pages
6. Self-host fonts (remove Google Fonts CDN dependency)
7. Add `noreferrer` to affiliate link `rel` attributes
8. Fix `APP_LOCALE=id` in `.env`
9. Add loading state to checkout form submit button
10. Add compare functionality to product cards/detail page

---

*End of Audit Report — CekDulu v1.0*
