# Theme Comprehensive Fix — Design Spec

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Eliminate all color collisions, mobile gaps, and design inconsistencies across the entire Alluvia Peptides WordPress theme.

**Architecture:** Expand `alluvia-dark-platform.css` as the single source of truth for all color overrides on the navy platform background. Strip dark-color declarations from template inline `<style>` blocks. Fix mobile breakpoints in templates that have none. The rule: dark-platform.css owns color, templates own layout.

**Tech Stack:** WordPress PHP templates, CSS (no preprocessor), WooCommerce hooks, vanilla JS (Lucide icons CDN)

---

## Design Tokens (reference)

```
--navy:      #0a1a27   ← page background (ALL pages)
--teal:      #0eaf9f   ← accents, prices, active states
--gold:      #c6a253   ← headings, labels, active tabs
--white:     #ffffff   ← body text on navy
--text-mid:  #44515f   ← FORBIDDEN on navy (1.6:1 contrast)
--text-dark: #0a1a27   ← FORBIDDEN on navy (1:1 — invisible)
--text-light:#6b7d8e   ← FORBIDDEN on navy (2.4:1 contrast)
```

---

## Files Modified

| File | Action |
|------|--------|
| `assets/css/alluvia-dark-platform.css` | **Expand** — add 6 new page scopes |
| `archive.php` | **Strip** dark colors + add mobile breakpoints |
| `search.php` | **Strip** dark colors + add mobile breakpoints |
| `page-product.php` | **Strip** dark colors + fix tab mobile tap targets |
| `alluvia-base.css` | **Fix** 3 issues: redundant body bg, form label color, button.alt token |
| `alluvia-commerce.css` | **Fix** active tab color + standardise button.alt token |
| `functions.php` | **Fix** Lucide icon enqueue + watermark opacity |
| `woocommerce.php` | No changes (already clean) |
| `single.php` | No changes (already clean) |

---

## Task 1: Expand alluvia-dark-platform.css — Archive & Blog

**Scope:** `body.archive`, `body.blog`, `body.home` (when showing blog posts)

Add to `alluvia-dark-platform.css` after the existing FAQ section:

```css
/* ══════════════════════════════════════════════════════════════
   5. ARCHIVE / BLOG LISTING
   ══════════════════════════════════════════════════════════════ */

body.archive .archive-hero h1,
body.blog .archive-hero h1,
body.archive .page-title,
body.blog .page-title { color: #c6a253 !important; }

body.archive .archive-hero p,
body.blog .archive-hero p { color: rgba(255,255,255,0.75) !important; }

body.archive .post-card h2,
body.blog .post-card h2 { color: #ffffff !important; }

body.archive .post-card .post-meta,
body.blog .post-card .post-meta,
body.archive .post-card .category-label,
body.blog .post-card .category-label { color: #0eaf9f !important; }

body.archive .post-card .excerpt,
body.blog .post-card .excerpt,
body.archive .post-card .excerpt p,
body.blog .post-card .excerpt p { color: rgba(255,255,255,0.7) !important; }

body.archive .no-posts-found,
body.blog .no-posts-found { color: rgba(255,255,255,0.6) !important; }

body.archive .sidebar-widget h3,
body.archive .sidebar-widget h4,
body.blog .sidebar-widget h3,
body.blog .sidebar-widget h4 { color: #c6a253 !important; }

body.archive .sidebar-widget a,
body.blog .sidebar-widget a { color: rgba(255,255,255,0.75) !important; }

body.archive .sidebar-widget a:hover,
body.blog .sidebar-widget a:hover { color: #0eaf9f !important; }
```

**Also strip** from `archive.php` inline `<style>`: any `color: var(--text-mid)`, `color: var(--text-dark)`, `color: var(--navy)`, `color: var(--text-light)`.

**Verify:** `curl http://alluviapeptides.test/blog/` — confirm `color: #c6a253 !important` present for `.archive-hero h1`, no `var(--text-mid)` in archive.php output.

---

## Task 2: Expand alluvia-dark-platform.css — Search Results

**Scope:** `body.search-results`

```css
/* ══════════════════════════════════════════════════════════════
   6. SEARCH RESULTS
   ══════════════════════════════════════════════════════════════ */

body.search-results .search-page-title,
body.search-results h1 { color: #c6a253 !important; }

body.search-results .search-count,
body.search-results .search-query-text { color: rgba(255,255,255,0.6) !important; }

body.search-results .search-result-title,
body.search-results .search-result-title a { color: #ffffff !important; }

body.search-results .search-result-title a:hover { color: #0eaf9f !important; }

body.search-results .search-result-excerpt,
body.search-results .search-result-excerpt p { color: rgba(255,255,255,0.75) !important; }

body.search-results .search-result-type { color: #0eaf9f !important; }

body.search-results .no-results-message,
body.search-results .no-results-message p { color: rgba(255,255,255,0.6) !important; }
```

**Also strip** dark color declarations from `search.php` inline `<style>`.

**Verify:** `curl http://alluviapeptides.test/?s=peptide` — confirm rules present, no dark color declarations in search.php style block.

---

## Task 3: Expand alluvia-dark-platform.css — Checkout

**Scope:** `body.woocommerce-checkout`

```css
/* ══════════════════════════════════════════════════════════════
   7. CHECKOUT PAGE
   ══════════════════════════════════════════════════════════════ */

body.woocommerce-checkout h1,
body.woocommerce-checkout h2,
body.woocommerce-checkout h3 { color: #c6a253 !important; }

body.woocommerce-checkout .woocommerce form .form-row label { color: rgba(255,255,255,0.85) !important; }

body.woocommerce-checkout .woocommerce-checkout-review-order-table th,
body.woocommerce-checkout .woocommerce-checkout-review-order-table td { color: rgba(255,255,255,0.85) !important; }

body.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total .amount { color: #0eaf9f !important; }

body.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot tr:last-child th,
body.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot tr:last-child td { color: #0eaf9f !important; }

body.woocommerce-checkout .woocommerce-info,
body.woocommerce-checkout .woocommerce-message { color: rgba(255,255,255,0.85) !important; }

body.woocommerce-checkout .woocommerce-privacy-policy-text,
body.woocommerce-checkout .woocommerce-privacy-policy-text p { color: rgba(255,255,255,0.55) !important; }
```

**Verify:** `curl http://alluviapeptides.test/checkout/` — rules present in inline CSS output.

---

## Task 4: Expand alluvia-dark-platform.css — Contact & Account

**Contact scope:** `.contact-section` (the page wrapper used in `page-contact.php`)

```css
/* ══════════════════════════════════════════════════════════════
   8. CONTACT PAGE
   ══════════════════════════════════════════════════════════════ */

.contact-section h1,
.contact-section h2,
.contact-section h3 { color: #c6a253 !important; }

.contact-section p,
.contact-layout p { color: rgba(255,255,255,0.85) !important; }

.contact-form-card label { color: rgba(255,255,255,0.85) !important; }

.contact-sidebar a,
.contact-sidebar .contact-detail-value { color: #0eaf9f !important; }

.contact-sidebar .contact-detail-label { color: rgba(255,255,255,0.55) !important; }
```

**Account scope:** `body.woocommerce-account`

```css
/* ══════════════════════════════════════════════════════════════
   9. MY ACCOUNT PAGE
   ══════════════════════════════════════════════════════════════ */

body.woocommerce-account h1,
body.woocommerce-account h2,
body.woocommerce-account h3 { color: #c6a253 !important; }

body.woocommerce-account .woocommerce-MyAccount-navigation ul li a { color: rgba(255,255,255,0.75) !important; }

body.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a { color: #0eaf9f !important; }

body.woocommerce-account .woocommerce-MyAccount-content p,
body.woocommerce-account .woocommerce-MyAccount-content td,
body.woocommerce-account .woocommerce-MyAccount-content th { color: rgba(255,255,255,0.85) !important; }

body.woocommerce-account .woocommerce-orders-table .order-status { color: #3ddc97 !important; }

body.woocommerce-account .woocommerce form .form-row label { color: rgba(255,255,255,0.85) !important; }
```

**Verify:** `curl` both pages — confirm rules in output.

---

## Task 5: Expand alluvia-dark-platform.css — Shop Page

**Scope:** `body.woocommerce-shop`, `body.tax-product_cat`

```css
/* ══════════════════════════════════════════════════════════════
   10. SHOP / PRODUCT CATEGORY ARCHIVE
   ══════════════════════════════════════════════════════════════ */

body.woocommerce-shop h1,
body.tax-product_cat h1,
body.woocommerce-shop .woocommerce-products-header__title,
body.tax-product_cat .woocommerce-products-header__title { color: #c6a253 !important; }

body.woocommerce-shop .woocommerce-result-count,
body.tax-product_cat .woocommerce-result-count { color: rgba(255,255,255,0.6) !important; }

body.woocommerce-shop .woocommerce-ordering select,
body.tax-product_cat .woocommerce-ordering select { color: #0a1a27 !important; }

body.woocommerce-shop ul.products li.product .woocommerce-loop-product__title,
body.tax-product_cat ul.products li.product .woocommerce-loop-product__title { color: #ffffff !important; }

body.woocommerce-shop ul.products li.product .price,
body.tax-product_cat ul.products li.product .price { color: #0eaf9f !important; }
```

**Verify:** `curl http://alluviapeptides.test/shop/` — rules present.

---

## Task 6: Fix page-product.php — Strip dark colors + mobile tabs

**Strip from `page-product.php` inline `<style>`:**
- `.breadcrumb { color: var(--text-mid) }` → remove color
- `.rating-text { color: var(--text-mid) }` → remove color
- `.tab-btn { color: var(--text-light) }` → remove color
- `.assurance-item { color: var(--text-mid) }` → remove color

**Add to `alluvia-dark-platform.css` (single-product section or new section):**
```css
body.single-product .breadcrumb { color: rgba(255,255,255,0.6) !important; }
body.single-product .breadcrumb a { color: #0eaf9f !important; }
body.single-product .rating-text { color: rgba(255,255,255,0.7) !important; }
body.single-product .tab-btn { color: rgba(255,255,255,0.65) !important; }
body.single-product .tab-btn.active { color: #c6a253 !important; }
body.single-product .assurance-item { color: rgba(255,255,255,0.8) !important; }
body.single-product .assurance-item svg { stroke: #0eaf9f !important; }
```

**Add mobile breakpoint to `page-product.php`:**
```css
@media (max-width: 600px) {
  .tab-nav { gap: 4px; }
  .tab-btn { padding: 10px 14px; font-size: 13px; min-height: 44px; }
}
```

---

## Task 7: Fix archive.php + search.php mobile breakpoints

**archive.php** — add inside inline `<style>`:
```css
@media (max-width: 768px) {
  .archive-layout { grid-template-columns: 1fr; }
  .archive-sidebar { position: static; width: 100%; }
  .post-card-image { height: 160px; }
}
@media (max-width: 480px) {
  .archive-grid { grid-template-columns: 1fr; }
}
```

**search.php** — add inside inline `<style>`:
```css
@media (max-width: 600px) {
  .search-bar { max-width: 100%; padding: 0 16px; }
  .search-bar input { font-size: 15px; }
  .search-results-grid { grid-template-columns: 1fr; gap: 16px; }
}
```

---

## Task 8: Fix alluvia-base.css + alluvia-commerce.css token issues

**alluvia-base.css changes:**
1. Line 81: Remove `body { background-color: #fff; }` (redundant — navy is the only background)
2. Line 240: Change `.woocommerce form .form-row label { color: var(--navy) }` → `color: var(--color-on-navy)`
3. Line 239: Change `.woocommerce a.button.alt { color: #fff }` → `color: var(--color-on-navy)`

**alluvia-commerce.css changes:**
1. Active tab: Change `color: var(--navy)` → `color: var(--gold)` for `.woocommerce-tabs ul.tabs li.active a`
2. Inactive tab: Change `color: var(--text-light)` → `color: rgba(255,255,255,0.6)` for `.woocommerce-tabs ul.tabs li a`

---

## Task 9: Fix functions.php — Lucide icons + watermark

**Lucide icons:** Search `functions.php` for `lucide`. If not found, add CDN enqueue:
```php
wp_enqueue_script( 'lucide', 'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js', array(), null, true );
wp_add_inline_script( 'lucide', 'document.addEventListener("DOMContentLoaded", function(){ if(window.lucide) lucide.createIcons(); });' );
```

**Watermark:** In `front-page.php` find `.about-section::before` or similar and either:
- Remove the rule if it serves no purpose
- Or change opacity from `0.025` to `0.05` if a subtle texture is desired

---

## Verification Protocol

After each task:
1. **curl check** — `curl -s <page-url> | grep -c "color.*!important"` and confirm no `var(--text-mid)`, `var(--text-dark)`, `var(--navy)` in content elements
2. **Screenshot** — browser screenshot of the affected page before committing

After all tasks:
3. **Final visual pass** — hard-refresh each page: `/`, `/shop/`, `/product/bpc-157-5mg/`, `/blog/`, `/?s=peptide`, `/checkout/`, `/my-account/`, `/contact/`, `/faq/`

---

## Out of Scope

- New features, new pages, new components
- Changing the navy background itself
- Typography changes (font sizes, weights)
- WooCommerce payment gateway styling
