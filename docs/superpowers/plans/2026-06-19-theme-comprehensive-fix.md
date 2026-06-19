# Theme Comprehensive Fix — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Eliminate all color collisions, mobile gaps, and design inconsistencies across the Alluvia Peptides WordPress theme so every page matches the hero's navy/gold/teal/white palette.

**Architecture:** Expand `alluvia-dark-platform.css` as the single source of truth for all color overrides on the navy platform background. Strip competing dark-color declarations from template inline `<style>` blocks. Fix mobile breakpoints where missing. Fix token inconsistencies in base CSS. The rule: dark-platform.css owns color, templates own layout.

**Tech Stack:** WordPress PHP templates, CSS (no preprocessor), WooCommerce body classes, Lucide icons CDN

---

## Context for every subagent

- **Theme directory (where WordPress serves from):** `C:\laragon\www\orderlimiter\wordpress theme\wordpress-7.0\wordpress\wp-content\themes\alluvia-peptides`
- **Active branch:** `claude/modest-einstein-g6a99j`
- **Local dev URL:** `http://alluviapeptides.test`
- **Design tokens:**
  - `--navy: #0a1a27` — page background (ALL pages)
  - `--teal: #0eaf9f` — accents, prices, active states, links
  - `--gold: #c6a253` — headings, labels, active tabs
  - `--white: #ffffff` — body text on navy
  - `--text-mid: #44515f` — **FORBIDDEN on navy** (1.6:1 contrast — invisible)
  - `--text-dark: #0a1a27` — **FORBIDDEN on navy** (1:1 — completely invisible)
  - `--text-light: #6b7d8e` — **FORBIDDEN on navy** (2.4:1 — fails WCAG AA)
- **Key file:** `assets/css/alluvia-dark-platform.css` — injected via `wp_add_inline_style('alluvia-commerce', ...)` in `functions.php`. All rules use `!important`. This file is the ONLY place color overrides live.
- **Verification protocol per task:** (1) curl check — confirm correct rules in HTML, no forbidden colors remain; (2) browser screenshot of affected page; (3) commit.

---

## File Map

| File | Change |
|------|--------|
| `assets/css/alluvia-dark-platform.css` | Add 6 new page scopes (sections 5–10) |
| `archive.php` | Strip dark color declarations; add mobile breakpoints |
| `search.php` | Strip dark color declarations; add mobile breakpoints |
| `page-product.php` | Strip dark color declarations; add mobile tab breakpoint |
| `alluvia-base.css` | Remove redundant body bg; fix form label + button.alt tokens |
| `alluvia-commerce.css` | Fix active/inactive tab colors; fix button.alt token |
| `functions.php` | Add Lucide icon enqueue if missing |
| `front-page.php` | Remove invisible watermark rule |

---

## Task 1: Expand dark-platform.css — Archive & Blog listing

**Files:**
- Modify: `assets/css/alluvia-dark-platform.css` (append after FAQ section)
- Modify: `archive.php` (strip dark color declarations from inline `<style>`)

- [ ] **Step 1: Read the current end of alluvia-dark-platform.css**

  Open `assets/css/alluvia-dark-platform.css`. The file ends with the FAQ section (section 4). Note the last line number.

- [ ] **Step 2: Append archive/blog scope to alluvia-dark-platform.css**

  Add after the FAQ section:

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

- [ ] **Step 3: Strip dark color declarations from archive.php**

  Open `archive.php`. Find the inline `<style>` block. Remove every line that contains:
  - `color: var(--text-mid)`
  - `color: var(--text-dark)`
  - `color: var(--navy)`
  - `color: var(--text-light)`

  Do NOT remove `color:` declarations on teal/gold backgrounds (button text etc.) — only remove dark colors that would be invisible on the navy platform background.

- [ ] **Step 4: Verify**

  ```bash
  curl -s "http://alluviapeptides.test/blog/" | grep -c "archive-hero h1"
  ```
  Expected: `1` or more (our rule appears in page HTML)

  ```bash
  curl -s "http://alluviapeptides.test/blog/" | grep "text-mid\|text-dark" | grep -v "sidebar-reset\|pearl\|white\|btn"
  ```
  Expected: no output (no forbidden dark colors on content elements)

- [ ] **Step 5: Screenshot**

  Open `http://alluviapeptides.test/blog/` in browser. Hard-refresh (Ctrl+Shift+R). Confirm: page title is gold, post card titles are white, meta/category labels are teal, excerpt text is white/near-white. Take screenshot.

- [ ] **Step 6: Commit**

  ```bash
  git add assets/css/alluvia-dark-platform.css archive.php
  git commit -m "feat(dark-platform): add archive/blog color scope; strip dark tokens from archive.php"
  ```

---

## Task 2: Expand dark-platform.css — Search Results

**Files:**
- Modify: `assets/css/alluvia-dark-platform.css` (append after archive section)
- Modify: `search.php` (strip dark color declarations)

- [ ] **Step 1: Append search results scope to alluvia-dark-platform.css**

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

- [ ] **Step 2: Strip dark color declarations from search.php**

  Open `search.php`. In the inline `<style>` block, remove any lines with:
  - `color: var(--text-mid)`
  - `color: var(--text-dark)`
  - `color: var(--navy)`
  - `color: var(--text-light)`

- [ ] **Step 3: Verify**

  ```bash
  curl -s "http://alluviapeptides.test/?s=peptide" | grep -c "search-page-title"
  ```
  Expected: `1` or more

  ```bash
  curl -s "http://alluviapeptides.test/?s=peptide" | grep "text-mid\|text-dark" | grep -v "sidebar\|btn"
  ```
  Expected: no output

- [ ] **Step 4: Screenshot**

  Open `http://alluviapeptides.test/?s=peptide`. Hard-refresh. Confirm: heading is gold, result titles white, excerpts white/near-white.

- [ ] **Step 5: Commit**

  ```bash
  git add assets/css/alluvia-dark-platform.css search.php
  git commit -m "feat(dark-platform): add search results color scope; strip dark tokens from search.php"
  ```

---

## Task 3: Expand dark-platform.css — Checkout Page

**Files:**
- Modify: `assets/css/alluvia-dark-platform.css` (append after search section)

- [ ] **Step 1: Append checkout scope to alluvia-dark-platform.css**

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

  body.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total .amount,
  body.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot tr:last-child th,
  body.woocommerce-checkout .woocommerce-checkout-review-order-table tfoot tr:last-child td { color: #0eaf9f !important; }

  body.woocommerce-checkout .woocommerce-info,
  body.woocommerce-checkout .woocommerce-message { color: rgba(255,255,255,0.85) !important; }

  body.woocommerce-checkout .woocommerce-privacy-policy-text,
  body.woocommerce-checkout .woocommerce-privacy-policy-text p { color: rgba(255,255,255,0.55) !important; }
  ```

- [ ] **Step 2: Verify**

  ```bash
  curl -s "http://alluviapeptides.test/checkout/" | grep -c "woocommerce-checkout h1"
  ```
  Expected: `1` or more

- [ ] **Step 3: Screenshot**

  Open `http://alluviapeptides.test/checkout/`. Hard-refresh. Confirm: section headings are gold, form labels are white, order total is teal.

- [ ] **Step 4: Commit**

  ```bash
  git add assets/css/alluvia-dark-platform.css
  git commit -m "feat(dark-platform): add checkout color scope"
  ```

---

## Task 4: Expand dark-platform.css — Contact & Account Pages

**Files:**
- Modify: `assets/css/alluvia-dark-platform.css` (append after checkout section)

- [ ] **Step 1: Verify contact page wrapper class**

  ```bash
  grep -n "class=" "C:/laragon/www/orderlimiter/wordpress theme/wordpress-7.0/wordpress/wp-content/themes/alluvia-peptides/page-contact.php" | grep "section\|layout\|wrap" | head -5
  ```

  Note the outermost wrapper class used (expected: `.contact-section`).

- [ ] **Step 2: Append contact + account scopes to alluvia-dark-platform.css**

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

- [ ] **Step 3: Verify contact page**

  ```bash
  curl -s "http://alluviapeptides.test/contact/" | grep -c "contact-section h1"
  ```
  Expected: `1` or more

- [ ] **Step 4: Screenshot both pages**

  Open `http://alluviapeptides.test/contact/` and `http://alluviapeptides.test/my-account/`. Hard-refresh each. Confirm headings are gold, body text white, links/values teal.

- [ ] **Step 5: Commit**

  ```bash
  git add assets/css/alluvia-dark-platform.css
  git commit -m "feat(dark-platform): add contact and account color scopes"
  ```

---

## Task 5: Expand dark-platform.css — Shop / Product Archive

**Files:**
- Modify: `assets/css/alluvia-dark-platform.css` (append after account section)

- [ ] **Step 1: Append shop scope to alluvia-dark-platform.css**

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

- [ ] **Step 2: Verify**

  ```bash
  curl -s "http://alluviapeptides.test/shop/" | grep -c "woocommerce-shop h1"
  ```
  Expected: `1` or more

- [ ] **Step 3: Screenshot**

  Open `http://alluviapeptides.test/shop/`. Hard-refresh. Confirm: page title gold, result count white/dim, product titles white, prices teal.

- [ ] **Step 4: Commit**

  ```bash
  git add assets/css/alluvia-dark-platform.css
  git commit -m "feat(dark-platform): add shop/product-archive color scope"
  ```

---

## Task 6: Fix page-product.php — strip dark colors + mobile tab fix

**Files:**
- Modify: `page-product.php` (strip dark colors from inline `<style>`; add mobile breakpoint)
- Modify: `assets/css/alluvia-dark-platform.css` (add product page breadcrumb/tab/assurance rules)

- [ ] **Step 1: Read page-product.php inline style block**

  Open `page-product.php`. Find the inline `<style>` block. Identify lines containing:
  - `.breadcrumb { color: var(--text-mid)` or similar
  - `.rating-text { color:`
  - `.tab-btn { color:`
  - `.assurance-item { color:`

- [ ] **Step 2: Strip those color declarations from page-product.php**

  For each line found in Step 1, remove the `color: ...` property only (keep other properties like font-size, padding etc. on those selectors).

- [ ] **Step 3: Add mobile breakpoint for tabs to page-product.php**

  Inside the inline `<style>` block, add at the end (before `</style>`):

  ```css
  @media (max-width: 600px) {
    .tab-nav { gap: 4px; }
    .tab-btn { padding: 10px 14px; font-size: 13px; min-height: 44px; }
  }
  ```

- [ ] **Step 4: Add product page overrides to alluvia-dark-platform.css**

  In `alluvia-dark-platform.css`, find the existing `/* 1. SINGLE PRODUCT PAGE */` section. Add these rules to it (after the existing stock status lines):

  ```css
  /* Product page extras */
  body.single-product .breadcrumb { color: rgba(255,255,255,0.6) !important; }
  body.single-product .breadcrumb a { color: #0eaf9f !important; }
  body.single-product .rating-text { color: rgba(255,255,255,0.7) !important; }
  body.single-product .tab-btn { color: rgba(255,255,255,0.65) !important; }
  body.single-product .tab-btn.active,
  body.single-product .tab-btn:focus { color: #c6a253 !important; }
  body.single-product .assurance-item { color: rgba(255,255,255,0.8) !important; }
  body.single-product .assurance-item svg { stroke: #0eaf9f !important; }
  ```

- [ ] **Step 5: Verify**

  ```bash
  curl -s "http://alluviapeptides.test/product/bpc-157-5mg/" | grep "text-mid\|text-light" | grep -v "sidebar\|btn\|reset"
  ```
  Expected: no output (no forbidden dark colors in product page content elements)

- [ ] **Step 6: Screenshot**

  Open `http://alluviapeptides.test/product/bpc-157-5mg/`. Hard-refresh. Confirm: breadcrumb is white/teal, tabs readable, assurance items white. Resize to 480px — tab buttons should be tall enough to tap.

- [ ] **Step 7: Commit**

  ```bash
  git add page-product.php assets/css/alluvia-dark-platform.css
  git commit -m "fix(product-page): strip dark color tokens; add mobile tab breakpoint; extend dark-platform overrides"
  ```

---

## Task 7: Fix archive.php + search.php mobile breakpoints

**Files:**
- Modify: `archive.php` (add responsive breakpoints inside existing inline `<style>`)
- Modify: `search.php` (add responsive breakpoints inside existing inline `<style>`)

- [ ] **Step 1: Add mobile breakpoints to archive.php**

  Open `archive.php`. Find the inline `<style>` block. Add at the end before `</style>`:

  ```css
  @media (max-width: 768px) {
    .archive-layout { grid-template-columns: 1fr; }
    .archive-sidebar { position: static; width: 100%; margin-top: 32px; }
    .post-card-image { height: 160px; }
  }
  @media (max-width: 480px) {
    .archive-grid { grid-template-columns: 1fr; gap: 16px; }
    .archive-hero { padding: 40px 20px; }
  }
  ```

- [ ] **Step 2: Add mobile breakpoints to search.php**

  Open `search.php`. Find the inline `<style>` block. Add at the end before `</style>`:

  ```css
  @media (max-width: 600px) {
    .search-bar { max-width: 100%; padding: 0 16px; }
    .search-bar input { font-size: 15px; padding: 12px 16px; }
    .search-results-grid { grid-template-columns: 1fr; gap: 16px; }
    .search-result-card { padding: 16px; }
  }
  ```

- [ ] **Step 3: Verify**

  ```bash
  curl -s "http://alluviapeptides.test/blog/" | grep -c "max-width: 768px"
  ```
  Expected: `1`

  ```bash
  curl -s "http://alluviapeptides.test/?s=test" | grep -c "max-width: 600px"
  ```
  Expected: `1`

- [ ] **Step 4: Screenshot at mobile width**

  Open `http://alluviapeptides.test/blog/` in browser. Open DevTools → toggle device toolbar → set width to 375px. Hard-refresh. Confirm sidebar stacks below cards and layout is single column.

- [ ] **Step 5: Commit**

  ```bash
  git add archive.php search.php
  git commit -m "fix(mobile): add responsive breakpoints to archive and search templates"
  ```

---

## Task 8: Fix alluvia-base.css + alluvia-commerce.css token issues

**Files:**
- Modify: `assets/css/alluvia-base.css`
- Modify: `assets/css/alluvia-commerce.css`

- [ ] **Step 1: Remove redundant body background from alluvia-base.css**

  Open `assets/css/alluvia-base.css`. Find the line:
  ```css
  body { background-color: #fff; }
  ```
  Remove the `background-color: #fff;` property (or the entire rule if it only contains that property). The navy override `body.alluvia-site { background: var(--navy) }` is the authoritative rule.

- [ ] **Step 2: Fix WooCommerce form label color in alluvia-base.css**

  Find:
  ```css
  .woocommerce form .form-row label { color: var(--navy); }
  ```
  Change to:
  ```css
  .woocommerce form .form-row label { color: var(--color-on-navy); }
  ```
  (`--color-on-navy` is defined as `#ffffff` in `:root` — this makes the label white on navy pages)

- [ ] **Step 3: Fix button.alt token in alluvia-base.css**

  Find:
  ```css
  .woocommerce a.button.alt { ... color: #fff ... }
  ```
  Change `color: #fff` to `color: var(--color-on-navy)`.

- [ ] **Step 4: Fix active tab color in alluvia-commerce.css**

  Open `assets/css/alluvia-commerce.css`. Find:
  ```css
  .woocommerce div.product .woocommerce-tabs ul.tabs li.active a { color: var(--navy); ... }
  ```
  Change `color: var(--navy)` to `color: var(--gold)`.

- [ ] **Step 5: Fix inactive tab color in alluvia-commerce.css**

  Find:
  ```css
  .woocommerce div.product .woocommerce-tabs ul.tabs li a { color: var(--text-light); }
  ```
  Change `color: var(--text-light)` to `color: rgba(255,255,255,0.6)`.

- [ ] **Step 6: Standardise button.alt token in alluvia-commerce.css**

  Find any `color: #fff` on `.button.alt` or `a.button.alt` in alluvia-commerce.css. Change to `color: var(--color-on-navy)`.

- [ ] **Step 7: Verify**

  ```bash
  grep -n "color: var(--navy)\|color: var(--text-light)\|color: var(--text-mid)\|color: var(--text-dark)" "assets/css/alluvia-base.css" "assets/css/alluvia-commerce.css"
  ```
  Expected: no lines returned for content-element selectors (only allowed on white-bg components like sidebar cards)

- [ ] **Step 8: Screenshot product page**

  Open `http://alluviapeptides.test/product/bpc-157-5mg/`. Hard-refresh. Confirm product tabs are readable — inactive tabs are white/semi-transparent, active tab is gold.

- [ ] **Step 9: Commit**

  ```bash
  git add assets/css/alluvia-base.css assets/css/alluvia-commerce.css
  git commit -m "fix(tokens): standardise button.alt token; fix form label + tab colors in base and commerce CSS"
  ```

---

## Task 9: Fix functions.php — Lucide icons + front-page.php watermark

**Files:**
- Modify: `functions.php` (add Lucide enqueue if missing)
- Modify: `front-page.php` (remove or fix invisible watermark)

- [ ] **Step 1: Check if Lucide is already enqueued in functions.php**

  ```bash
  grep -n "lucide" "functions.php"
  ```

  If output shows a `wp_enqueue_script` call for lucide: **skip Step 2** (already handled).

  If no output: proceed to Step 2.

- [ ] **Step 2: Add Lucide CDN enqueue to functions.php (only if Step 1 found nothing)**

  In `functions.php`, find the main `wp_enqueue_scripts` action function (where `alluvia-base` is enqueued). Add these two lines immediately after the `wp_enqueue_style('alluvia-base', ...)` call:

  ```php
  wp_enqueue_script( 'lucide', 'https://unpkg.com/lucide@latest/dist/umd/lucide.min.js', array(), null, true );
  wp_add_inline_script( 'lucide', 'document.addEventListener("DOMContentLoaded",function(){if(window.lucide)lucide.createIcons();});' );
  ```

- [ ] **Step 3: Verify Lucide icons render**

  Open `http://alluviapeptides.test/` in browser. Hard-refresh. Open DevTools → Elements. Search for `<i data-lucide`. Confirm the element has been replaced by an `<svg>` (Lucide replaces `<i>` with `<svg>` on init). If still `<i>`, Lucide is not loading.

- [ ] **Step 4: Fix invisible watermark in front-page.php**

  Open `front-page.php`. Search for `opacity: 0.025` or `rgba(10,26,39, .025)` or `.about-section::before`. Either:
  - Remove the entire `::before` rule if it's purely decorative and invisible, OR
  - Change opacity from `0.025` to `0.05` if a subtle texture is intended

  If the rule is not found, skip this step.

- [ ] **Step 5: Verify page loads without JS errors**

  Open `http://alluviapeptides.test/` in browser. Open DevTools → Console. Hard-refresh. Confirm: no JS errors related to Lucide or undefined functions.

- [ ] **Step 6: Commit**

  ```bash
  git add functions.php front-page.php
  git commit -m "fix: ensure Lucide icons enqueued; remove invisible watermark from front-page"
  ```

---

## Task 10: Final visual pass — all pages

**No file changes in this task — verification only.**

- [ ] **Step 1: Visit and hard-refresh every page**

  For each URL below, open in browser and press `Ctrl+Shift+R`:

  | Page | URL | Check |
  |------|-----|-------|
  | Home/Hero | `http://alluviapeptides.test/` | Hero text white, headings gold |
  | Shop | `http://alluviapeptides.test/shop/` | Title gold, product titles white, prices teal |
  | Single product | `http://alluviapeptides.test/product/bpc-157-5mg/` | Title gold, price teal, description white |
  | Blog archive | `http://alluviapeptides.test/blog/` | Title gold, cards readable |
  | Search | `http://alluviapeptides.test/?s=peptide` | Heading gold, results white |
  | FAQ | `http://alluviapeptides.test/faq/` | Section labels visible, accordion readable |
  | Contact | `http://alluviapeptides.test/contact/` | Headings gold, labels white |
  | Checkout | `http://alluviapeptides.test/checkout/` | Headings gold, labels white, total teal |
  | My Account | `http://alluviapeptides.test/my-account/` | Headings gold, nav white |

- [ ] **Step 2: Mobile check**

  Open DevTools → device toolbar → set to 375px width. Visit shop, product, and blog. Confirm no overflowing text or layout breaks.

- [ ] **Step 3: Report any remaining issues**

  If any page still has dark-on-dark text: note the page URL, the element (inspect it in DevTools → Computed tab → color value), and the CSS rule winning the cascade. Report back before continuing.

- [ ] **Step 4: Final commit + push**

  ```bash
  git log --oneline -10
  git push origin claude/modest-einstein-g6a99j
  ```

---

## Verification Protocol (every task)

1. **curl check** — `curl -s <url> | grep "color.*!important"` confirms dark-platform rules appear in HTML; `grep "text-mid\|text-dark"` confirms no forbidden colors remain on content elements
2. **Screenshot** — browser hard-refresh of affected page, visual confirmation before commit
3. **Commit** — one commit per task, message follows `fix(scope): description` convention
