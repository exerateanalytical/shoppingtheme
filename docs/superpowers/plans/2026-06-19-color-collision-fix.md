# Color Collision Fix — Complete Theme Audit

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Eliminate every dark-text-on-dark-background collision across the entire Alluvia Peptides theme by creating one authoritative dark-platform stylesheet, stripping conflicting rules from templates, and verifying every affected page.

**Architecture:** The platform uses `body.alluvia-site { background: var(--navy) }` globally, but `alluvia-base.css` defaults (`p`, `h1-h6`) assume a light background. The fix: create `assets/css/alluvia-dark-platform.css` injected via `wp_add_inline_style()` attached to `alluvia-commerce`, then strip all conflicting `body.single-product` and layout-level color rules from both `woocommerce.php` and `alluvia-commerce.css`. `wp_add_inline_style()` outputs the CSS as a `<style>` block immediately after the `<link>` for `alluvia-commerce.css` — combined with `!important` this beats every competing rule regardless of source order.

**Tech Stack:** WordPress 7.0, WooCommerce, PHP, CSS custom properties, `wp_enqueue_style`, `wp_add_inline_style`

---

## File Map

| File | Change |
|---|---|
| `assets/css/alluvia-dark-platform.css` | **CREATE** — single source of truth for all dark-platform text colors |
| `functions.php` | **MODIFY** — inject new file via `wp_add_inline_style('alluvia-commerce', ...)` |
| `woocommerce.php` | **MODIFY** — strip ALL color declarations from the `wp_head` inline `<style>` block; keep only layout/spacing/font rules |
| `assets/css/alluvia-commerce.css` | **MODIFY** — remove the two `body.single-product` color override blocks |
| `single.php` | **MODIFY** — remove hardcoded dark colors from `.article` CSS rules |

---

## Color Collision Inventory

### A — Single Product Page (`.single-product`) — CRITICAL

All product detail content sits directly on the navy platform background.

| Element | Current broken color | Correct color |
|---|---|---|
| `h1.product_title` | `var(--navy)` #0a1a27 → invisible | `#c6a253` gold |
| `p.price`, `span.price` | `var(--navy)` → invisible | `#0eaf9f` teal |
| `.short-description p` | `var(--text-mid)` #44515f → near-invisible | `#ffffff` |
| `.product_meta`, `.product_meta a` | `var(--text-light)` → near-invisible | `rgba(255,255,255,0.65)` |
| Tab nav inactive `a` | `var(--text-light)` | `rgba(255,255,255,0.6)` |
| Tab nav active `a` | `var(--navy)` → invisible | `#c6a253` gold |
| Tab nav border | `var(--pearl-dark)` → wrong | `rgba(255,255,255,0.18)` |
| Tab panel `p`, `li` | `var(--text-mid)` | `rgba(255,255,255,0.88)` |
| Tab panel `h2`, `h3` | `var(--navy)` → invisible | `#0eaf9f` teal |
| Tab panel `h4` | `var(--navy)` → invisible | `#c6a253` gold |
| `.related > h2`, `.upsells > h2` | `var(--navy)` → invisible | `#0eaf9f` teal |
| `.alluvia-woo-inner h1` | `var(--navy)` → invisible | `#ffffff` |
| `.woocommerce-breadcrumb` | `var(--text-light)` | `rgba(255,255,255,0.6)` |

### B — Blog Post Page (`single.php`) — MEDIUM

`.post-layout` has no background — article content sits on navy.

| Element | Current color | Correct color |
|---|---|---|
| `.article p` | `var(--text-mid)` | `rgba(255,255,255,0.85)` |
| `.article h2` | `var(--text-dark)` → invisible | `#ffffff` |
| `.article h3` | `var(--text-dark)` → invisible | `rgba(255,255,255,0.9)` |
| `.article ul li, ol li` | `var(--text-mid)` | `rgba(255,255,255,0.85)` |
| `.related-posts h2` | inherits `h2` → `var(--navy)` → invisible | `#ffffff` |
| `.pull-quote p` | `var(--navy)` → invisible | `#0eaf9f` teal accent |
| `.pull-quote cite` | `var(--text-light)` | `rgba(255,255,255,0.55)` |
| `.info-box p`, `.warn-box p` | `var(--text-mid)` | `rgba(255,255,255,0.8)` |
| `.tag` | `var(--text-mid)` on pearl bg → pearl-on-navy wrong | white/translucent |
| `.share-label` | `var(--text-light)` | `rgba(255,255,255,0.55)` |

### C — FAQ Page — MINOR

`.faq-item { background: #fff }` saves accordion bodies. Only section labels collide.

| Element | Current | Correct |
|---|---|---|
| `.faq-section-title` | `var(--text-light)` | `rgba(255,255,255,0.55)` |
| `.faq-section-title` border | `var(--pearl-dark)` | `rgba(255,255,255,0.1)` |

### D — WooCommerce Archive / Shop — ALREADY FIXED
Shop header, result count, breadcrumb already white in woocommerce.php inline style. Product cards `background:#fff`. No collision.

### E — Cart / Checkout / Account — PARTIALLY
Form content on white surfaces. Only `.alluvia-woo-inner h1` collides (color: var(--navy)).

---

## Why Previous !important Fixes Didn't Stick

The `woocommerce.php` `wp_head` hook at priority 20 outputs a `<style>` block AFTER the linked `alluvia-commerce.css` `<link>` tag. Inside that inline `<style>` block, there are TWO conflicting rules without `!important`:

```css
/* Rule A — specificity (0,1,1), no !important, AFTER alluvia-commerce.css */
.alluvia-woo-inner h1 { color: var(--navy); }

/* Rule B — specificity (0,4,2), no !important, AFTER alluvia-commerce.css */
body.single-product .woocommerce div.product .product_title { color: var(--gold); }
```

Our `alluvia-commerce.css` rule has `!important` and should win. However, it's possible WooCommerce plugin CSS (enqueued by the WooCommerce plugin, potentially AFTER theme CSS) also sets colors — and some WooCommerce default styles use `!important`. The safest solution is `wp_add_inline_style()` which injects our CSS as a block after the last registered stylesheet, combined with `!important`. This guarantees the highest possible cascade priority.

---

## Task 1: Create `alluvia-dark-platform.css`

**Files:**
- Create: `assets/css/alluvia-dark-platform.css`

- [ ] **Step 1: Create the file**

```css
/* =============================================================
   Alluvia Dark Platform — Text color overrides for navy background
   Injected via wp_add_inline_style() — single source of truth.
   Never add layout, spacing, or font-size here — only color.
   ============================================================= */

/* ══════════════════════════════════════════════════════════════
   1. SINGLE PRODUCT PAGE
   ══════════════════════════════════════════════════════════════ */

body.single-product .woocommerce-breadcrumb { color: rgba(255,255,255,0.6) !important; }
body.single-product .woocommerce-breadcrumb a { color: #0eaf9f !important; }

/* Product title → gold */
body.single-product .woocommerce div.product .product_title,
body.single-product .woocommerce div.product h1.product_title { color: #c6a253 !important; }

/* Price → teal */
body.single-product .woocommerce div.product p.price,
body.single-product .woocommerce div.product span.price,
body.single-product .woocommerce div.product .summary .price { color: #0eaf9f !important; }
body.single-product .woocommerce div.product p.price del,
body.single-product .woocommerce div.product span.price del { color: rgba(255,255,255,0.35) !important; }

/* Short description */
body.single-product .woocommerce div.product .woocommerce-product-details__short-description,
body.single-product .woocommerce div.product .woocommerce-product-details__short-description p,
body.single-product .woocommerce div.product .woocommerce-product-details__short-description li { color: #ffffff !important; }

/* Product meta */
body.single-product .woocommerce div.product .product_meta,
body.single-product .woocommerce div.product .product_meta span,
body.single-product .woocommerce div.product .product_meta a { color: rgba(255,255,255,0.65) !important; }
body.single-product .woocommerce div.product .product_meta { border-top-color: rgba(255,255,255,0.12) !important; }

/* Stock status */
body.single-product .woocommerce div.product .stock.in-stock { color: #3ddc97 !important; }
body.single-product .woocommerce div.product .stock.out-of-stock { color: #db627a !important; }

/* Tab nav */
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs { border-bottom-color: rgba(255,255,255,0.18) !important; }
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs li a { color: rgba(255,255,255,0.6) !important; }
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover { color: #c6a253 !important; border-bottom-color: #0eaf9f !important; }

/* Tab panel content */
body.single-product .woocommerce div.product .woocommerce-tabs .panel,
body.single-product .woocommerce div.product .woocommerce-tabs .panel p,
body.single-product .woocommerce div.product .woocommerce-tabs .panel li { color: rgba(255,255,255,0.88) !important; }
body.single-product .woocommerce div.product .woocommerce-tabs .panel h2,
body.single-product .woocommerce div.product .woocommerce-tabs .panel h3 { color: #0eaf9f !important; }
body.single-product .woocommerce div.product .woocommerce-tabs .panel h4 { color: #c6a253 !important; }
body.single-product .woocommerce div.product .woocommerce-tabs .panel a { color: #0eaf9f !important; }

/* Related / upsells */
body.single-product .woocommerce .related > h2,
body.single-product .woocommerce .upsells > h2 { color: #0eaf9f !important; }

/* ══════════════════════════════════════════════════════════════
   2. ALL WOO PAGES — inner page heading on navy platform
   ══════════════════════════════════════════════════════════════ */

.alluvia-woo-inner h1,
.alluvia-woo-inner .page-title { color: #ffffff !important; }

/* ══════════════════════════════════════════════════════════════
   3. BLOG POST — .post-layout article sits on navy
   ══════════════════════════════════════════════════════════════ */

.post-layout .article p,
.post-layout .article li { color: rgba(255,255,255,0.85) !important; }
.post-layout .article h2 { color: #ffffff !important; }
.post-layout .article h3 { color: rgba(255,255,255,0.9) !important; }
.post-layout .article .pull-quote p { color: #0eaf9f !important; }
.post-layout .article .pull-quote cite { color: rgba(255,255,255,0.55) !important; }
.post-layout .article .pull-quote { background: rgba(14,175,159,0.08) !important; border-left-color: #0eaf9f !important; }
.post-layout .article .info-box p,
.post-layout .article .warn-box p { color: rgba(255,255,255,0.8) !important; }
.post-layout .related-posts h2 { color: #ffffff !important; }
.post-layout .post-footer-bar { border-top-color: rgba(255,255,255,0.12) !important; }
.post-layout .tag { background: rgba(255,255,255,0.1) !important; color: rgba(255,255,255,0.75) !important; }
.post-layout .share-label { color: rgba(255,255,255,0.55) !important; }
.post-layout .share-btn { background: rgba(255,255,255,0.1) !important; color: rgba(255,255,255,0.65) !important; }
.post-layout .share-btn:hover { background: #0eaf9f !important; color: #0a1a27 !important; }

/* ══════════════════════════════════════════════════════════════
   4. FAQ — section title labels between white accordion cards
   ══════════════════════════════════════════════════════════════ */

.faq-section-title { color: rgba(255,255,255,0.55) !important; border-bottom-color: rgba(255,255,255,0.1) !important; }
```

- [ ] **Step 2: Commit**

```bash
git add "assets/css/alluvia-dark-platform.css"
git commit -m "feat(css): create alluvia-dark-platform.css — single source of truth for navy-bg overrides"
```

---

## Task 2: Enqueue `alluvia-dark-platform.css` in `functions.php`

**Files:**
- Modify: `functions.php` (around line 332–336)

- [ ] **Step 1: Find the alluvia-commerce enqueue block**

The relevant lines look like:
```php
$css_path = $dir . '/assets/css/alluvia-commerce.css';
$js_path  = $dir . '/assets/js/alluvia-commerce.js';
wp_enqueue_style( 'alluvia-commerce', $base . '/assets/css/alluvia-commerce.css', array(), file_exists( $css_path ) ? filemtime( $css_path ) : '1.0.0' );
```

- [ ] **Step 2: Add dark-platform inline style immediately after**

After the `wp_enqueue_style( 'alluvia-commerce', ... )` line, insert:

```php
$dark_css_path = $dir . '/assets/css/alluvia-dark-platform.css';
if ( file_exists( $dark_css_path ) ) {
    wp_add_inline_style( 'alluvia-commerce', file_get_contents( $dark_css_path ) );
}
```

This injects the file content as a `<style>` block immediately after the `alluvia-commerce.css` `<link>` tag in the HTML. Combined with `!important`, this wins all cascade battles.

- [ ] **Step 3: Verify in page source**

Visit `http://alluviapeptides.test/product/bpc-157-5mg/` and view source (Ctrl+U). Search for `alluvia-dark-platform` or `single source of truth`. The `<style>` block must appear immediately after the `alluvia-commerce.css` `<link>` line.

- [ ] **Step 4: Commit**

```bash
git add functions.php
git commit -m "feat(enqueue): inject alluvia-dark-platform.css via wp_add_inline_style after alluvia-commerce"
```

---

## Task 3: Strip color rules from `woocommerce.php` inline style

**Files:**
- Modify: `woocommerce.php`

The inline `<style>` in `woocommerce.php` must keep layout/font/spacing rules but lose all `color:` declarations that now belong to `alluvia-dark-platform.css`.

- [ ] **Step 1: Remove `color` from `.alluvia-woo-inner h1`**

Find (around line 22–29):
```css
.alluvia-woo-inner h1,
.alluvia-woo-inner .page-title {
  font-family: var(--font-display);
  font-size: var(--fs-h1);
  font-weight: 300;
  color: var(--navy);
  margin-bottom: 32px;
}
```
Remove ONLY the `color: var(--navy);` line.

- [ ] **Step 2: Remove `color` from `.woocommerce div.product .product_title`**

Find (around line 49):
```css
.woocommerce div.product .product_title { font-family: var(--font-display); font-size: clamp(28px,3.5vw,42px); font-weight: 300; color: var(--navy); margin: 0 0 12px; line-height: 1.1; }
```
Remove `color: var(--navy);`.

- [ ] **Step 3: Remove `color` from price rule**

Find (around line 50–51):
```css
.woocommerce div.product .summary .price,
.woocommerce div.product p.price { font-family: var(--font-display); font-size: 32px; font-weight: 600; color: var(--navy); margin: 0 0 16px; }
```
Remove `color: var(--navy);`.

- [ ] **Step 4: Remove `color` from short description**

Find (around line 52):
```css
.woocommerce div.product .woocommerce-product-details__short-description { font-size: var(--fs-body); line-height: 1.8; color: var(--text-mid); margin: 16px 0; }
```
Remove `color: var(--text-mid);`.

- [ ] **Step 5: Delete the entire `body.single-product` color block**

Find the comment block starting with:
```
/* ── Single product sits on the navy platform background (no card): recolor ...
```
Delete from that comment through and including:
```css
body.single-product .woocommerce div.product .stock.out-of-stock { color: var(--coral,#db627a); }
```
This is approximately lines 59–87. Everything between `/* ── Single product sits...` and `/* ── Add to cart ── */` should be removed.

- [ ] **Step 6: Remove `color` from tab panel rules**

In the `/* ── Product tabs ── */` section (around line 133–136):
```css
.woocommerce div.product .woocommerce-tabs .panel { font-size: var(--fs-body); line-height: 1.8; color: var(--text-mid); }
.woocommerce div.product .woocommerce-tabs .panel h2,
.woocommerce div.product .woocommerce-tabs .panel h3 { font-family: var(--font-display); color: var(--navy); font-weight: 600; }
.woocommerce div.product .woocommerce-tabs .panel h4 { font-family: var(--font-ui); font-size: var(--fs-title); color: var(--navy); margin: 18px 0 4px; }
```
Remove `color: var(--text-mid);` and both `color: var(--navy);` declarations.

Also in the tab nav:
```css
.woocommerce div.product .woocommerce-tabs ul.tabs li a { ... color: var(--text-light); ... }
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover { color: var(--navy); border-bottom-color: var(--teal); }
```
Remove both `color:` declarations.

- [ ] **Step 7: Remove `color` from related/upsell and cart_totals headings**

Find (around line 142):
```css
.woocommerce .related > h2,
.woocommerce .upsells > h2 { font-family: var(--font-display); font-size: var(--fs-h2); font-weight: 500; color: var(--navy); margin-bottom: 24px; }
```
Remove `color: var(--navy);`.

Find (around line 148):
```css
.woocommerce .cart_totals h2 { font-family: var(--font-display); font-size: var(--fs-h2); font-weight: 500; color: var(--navy); margin-bottom: 16px; }
```
Remove `color: var(--navy);`.

- [ ] **Step 8: Commit**

```bash
git add woocommerce.php
git commit -m "refactor(woocommerce): strip color declarations from inline style — owned by alluvia-dark-platform.css"
```

---

## Task 4: Remove duplicate `body.single-product` blocks from `alluvia-commerce.css`

**Files:**
- Modify: `assets/css/alluvia-commerce.css`

- [ ] **Step 1: Remove first single-product block (lines ~52–59)**

Find and delete:
```css
/* Single product on navy platform — override dark defaults with light colors */
body.single-product .woocommerce div.product .product_title{color:#c6a253 !important}
body.single-product .woocommerce div.product p.price,
body.single-product .woocommerce div.product span.price{color:#0eaf9f !important}
body.single-product .woocommerce div.product .woocommerce-product-details__short-description p,
body.single-product .woocommerce div.product .woocommerce-product-details__short-description{color:#ffffff !important}
body.single-product .woocommerce div.product .product_meta,
body.single-product .woocommerce div.product .product_meta a{color:rgba(255,255,255,0.7) !important}
```

- [ ] **Step 2: Remove second single-product block (lines ~95–108)**

Find and delete:
```css
/* ---- Single product on navy platform background — light text overrides ---- */
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs{border-bottom-color:rgba(255,255,255,0.18)}
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs li a{color:rgba(255,255,255,0.65)}
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
body.single-product .woocommerce div.product .woocommerce-tabs ul.tabs li a:hover{color:#c6a253 !important;border-bottom-color:#0eaf9f !important}
body.single-product .woocommerce div.product .woocommerce-tabs .panel p,
body.single-product .woocommerce div.product .woocommerce-tabs .panel li,
body.single-product .woocommerce div.product .woocommerce-tabs .panel{color:#ffffff !important}
body.single-product .woocommerce div.product .woocommerce-tabs .panel h2,
body.single-product .woocommerce div.product .woocommerce-tabs .panel h3{color:#0eaf9f !important}
body.single-product .woocommerce div.product .woocommerce-tabs .panel h4{color:#c6a253 !important}
body.single-product .woocommerce .related>h2,
body.single-product .woocommerce .upsells>h2{color:#0eaf9f !important}
body.single-product .woocommerce div.product .stock.in-stock { color: var(--mint,#3ddc97); }
body.single-product .woocommerce div.product .stock.out-of-stock { color: var(--coral,#db627a); }
```

- [ ] **Step 3: Commit**

```bash
git add "assets/css/alluvia-commerce.css"
git commit -m "refactor(commerce): remove duplicate single-product color blocks — owned by alluvia-dark-platform.css"
```

---

## Task 5: Fix blog post color rules in `single.php`

**Files:**
- Modify: `single.php` (inline `<style>` block at top, around lines 33–57)

- [ ] **Step 1: Remove `color` from `.article p`**

Find: `.article p{font-size:var(--fs-body);color:var(--text-mid);line-height:1.9;margin-bottom:1.5rem}`
Change to: `.article p{font-size:var(--fs-body);line-height:1.9;margin-bottom:1.5rem}`

- [ ] **Step 2: Remove `color` from `.article h2`**

Find: `.article h2{font-family:var(--font-display);font-size:28px;font-weight:600;color:var(--text-dark);margin:2.5rem 0 1rem}`
Change to: `.article h2{font-family:var(--font-display);font-size:28px;font-weight:600;margin:2.5rem 0 1rem}`

- [ ] **Step 3: Remove `color` from `.article h3`**

Find: `.article h3{font-family:var(--font-ui);font-size:var(--fs-body);font-weight:700;color:var(--text-dark);margin:1.75rem 0 0.75rem}`
Change to: `.article h3{font-family:var(--font-ui);font-size:var(--fs-body);font-weight:700;margin:1.75rem 0 0.75rem}`

- [ ] **Step 4: Remove `color` from list items**

Find: `.article ul li,.article ol li{font-size:var(--fs-body);color:var(--text-mid);margin-bottom:0.5rem;line-height:1.8}`
Change to: `.article ul li,.article ol li{font-size:var(--fs-body);margin-bottom:0.5rem;line-height:1.8}`

- [ ] **Step 5: Remove `color` from pull-quote**

Find: `.pull-quote p{font-family:var(--font-display);font-size:21px;font-style:italic;color:var(--navy);margin:0;line-height:1.6}`
Change to: `.pull-quote p{font-family:var(--font-display);font-size:21px;font-style:italic;margin:0;line-height:1.6}`

Find: `.pull-quote cite{display:block;font-family:var(--font-ui);font-size:var(--fs-ui);color:var(--text-light);margin-top:0.5rem;font-style:normal}`
Change to: `.pull-quote cite{display:block;font-family:var(--font-ui);font-size:var(--fs-ui);margin-top:0.5rem;font-style:normal}`

- [ ] **Step 6: Remove `color` from info-box and warn-box paragraphs**

Find: `.info-box p{font-size:var(--fs-base);margin-bottom:0;color:var(--text-mid)}`
Change to: `.info-box p{font-size:var(--fs-base);margin-bottom:0}`

Find: `.warn-box p{font-size:var(--fs-base);margin-bottom:0;color:var(--text-mid)}`
Change to: `.warn-box p{font-size:var(--fs-base);margin-bottom:0}`

- [ ] **Step 7: Remove `color` from `.tag` and `.share-label`**

Find: `.tag{background:var(--pearl);border-radius:50px;padding:4px 12px;font-family:var(--font-ui);font-size:var(--fs-xs);font-weight:600;color:var(--text-mid)}`
Change to: `.tag{background:var(--pearl);border-radius:50px;padding:4px 12px;font-family:var(--font-ui);font-size:var(--fs-xs);font-weight:600}`

Find: `.share-label{font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;color:var(--text-light)}`
Change to: `.share-label{font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600}`

- [ ] **Step 8: Commit**

```bash
git add single.php
git commit -m "refactor(blog): strip hardcoded dark colors from article CSS — now in alluvia-dark-platform.css"
```

---

## Task 6: Visual verification

- [ ] **Step 1: Hard-refresh single product page**

Navigate to `http://alluviapeptides.test/product/bpc-157-5mg/`. Press `Ctrl+Shift+R`.

Expected:
- Product title: **gold** (#c6a253) ✓
- Price: **teal** (#0eaf9f) ✓
- Short description: **white** ✓
- Tab labels inactive: white semi-transparent ✓
- Tab labels active: gold ✓
- Tab body text: white ✓
- Tab headings h2/h3: teal; h4: gold ✓
- Related section heading: teal ✓
- Background: still navy (unchanged) ✓

- [ ] **Step 2: DevTools inspection**

Right-click product title → Inspect → Styles panel. Verify `alluvia-dark-platform.css` rule `color: #c6a253 !important` appears and is NOT struck-through.

- [ ] **Step 3: Check blog post**

Navigate to any post under `/blog/`. Article text should be white. Headings white. Pull-quote teal.

- [ ] **Step 4: Check FAQ**

Navigate to `/faq/`. Section labels (between accordion items) should be white/translucent. White card accordion items unaffected.

- [ ] **Step 5: Check cart / account headings**

Navigate to `/cart/` and `/my-account/`. Page h1 should be white. Form inputs inside white cards should remain dark.

---

## Task 7: Push to GitHub

- [ ] **Step 1: Push branch**

```bash
git push origin claude/elated-chatterjee-23f855
```

---

## Self-Review

**Spec coverage:**
- ✅ All 14 single-product collisions in Section A → Task 1 (dark-platform.css) + Tasks 3-4 (cleanup)
- ✅ All 10 blog post collisions in Section B → Task 1 + Task 5
- ✅ FAQ section titles in Section C → Task 1
- ✅ WooCommerce inner heading → Task 1 (Section 2)
- ✅ Enqueue order guaranteed → Task 2 (`wp_add_inline_style`)
- ✅ Conflict elimination → Tasks 3-4
- ✅ Visual verification → Task 6

**Placeholder scan:** No TBD, no TODO, all code blocks are complete.

**Type consistency:** CSS class names match exactly what exists in the PHP template files (verified via file reads).
