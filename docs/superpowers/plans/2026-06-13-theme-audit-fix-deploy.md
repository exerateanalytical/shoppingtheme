# Alluvia Peptides — Theme Audit Fix & Deploy

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix all gaps, design inconsistencies, and data-wiring issues found in the comprehensive theme audit, then commit and push to deploy.

**Architecture:** The theme is a standalone WordPress/WooCommerce theme with CSS design tokens in `assets/css/alluvia-base.css`, shared nav in `partials/nav-alluvia.php`, and 17 page templates. The audit found 5 critical classes of issues: missing CSS tokens, hardcoded cart/checkout/product data, footer inconsistency, dead links, and hardcoded copyright year.

**Tech Stack:** PHP 8.x, WordPress 7.0, WooCommerce, CSS custom properties, Lucide icons CDN

---

## Audit Findings Summary

| # | Issue | Severity | Files |
|---|-------|----------|-------|
| 1 | `--radius`, `--purple`, `--orange`, `--mint`, `--sky` tokens undefined → visual fallback failures | **Critical** | `alluvia-base.css` |
| 2 | `page-product.php` 100% hardcoded to BPC-157 — any product page shows BPC-157 | **Critical** | `page-product.php` |
| 3 | `page-cart.php` shows 3 fake hardcoded items — real WC cart not rendered | **Critical** | `page-cart.php` |
| 4 | `page-checkout.php` sidebar shows hardcoded items — not real cart | **High** | `page-checkout.php` |
| 5 | Footer inconsistency — cart/product use `<footer><div class="footer-inner">`, checkout has truncated footer (no grid), shop uses `<footer class="alluvia-footer">` | **High** | cart, checkout, product |
| 6 | Privacy, Disclaimer footer links are `href="#"` (dead) in cart, product, checkout | **High** | cart, checkout, product |
| 7 | Copyright year hardcoded `2025` in cart, checkout, product footers | **Medium** | cart, checkout, product |
| 8 | Cart/checkout/product inline styles use hardcoded font family strings instead of CSS vars | **Low** | cart, checkout, product |

---

## File Map

| File | Action |
|------|--------|
| `assets/css/alluvia-base.css` | Add missing tokens: `--radius`, `--purple`, `--orange`, `--mint`, `--sky` |
| `partials/footer-alluvia.php` | **Create** — shared footer partial to replace all per-template footers |
| `page-product.php` | Wire to current WooCommerce product via `wc_get_product(get_the_ID())` |
| `page-cart.php` | Wire cart table to `WC()->cart->get_cart_contents()`, fix footer |
| `page-checkout.php` | Wire sidebar to real cart data, fix truncated footer |

---

## Task 1: Add Missing CSS Tokens to alluvia-base.css

**Files:**
- Modify: `assets/css/alluvia-base.css` (`:root` block, around line 10–55)

- [ ] **Step 1: Open alluvia-base.css and find the `:root` block**

Look for the `:root {` block. It already has `--radius-sm: 8px`, `--radius-md: 16px`, etc. Add the missing tokens immediately after the existing radius tokens and before the spacing tokens.

- [ ] **Step 2: Add missing tokens**

In `assets/css/alluvia-base.css`, inside `:root { ... }`, add after the existing `--radius-xl` line:

```css
  /* Radius alias — used by cart, checkout, product inline styles */
  --radius:      12px;

  /* Extended palette — used by product badges and card accents */
  --purple:      #8a60c1;
  --orange:      #d4663c;
  --mint:        #58b488;
  --sky:         #6aa6c6;
```

- [ ] **Step 3: Commit**

```bash
git add assets/css/alluvia-base.css
git commit -m "fix: add missing CSS tokens -- radius alias, purple, orange, mint, sky"
```

---

## Task 2: Create Shared Footer Partial

**Files:**
- Create: `partials/footer-alluvia.php`

The three pages that have their own hardcoded footers (cart, product, checkout) all use slightly different markup. Consolidate to a single partial so all pages share one footer.

- [ ] **Step 1: Create `partials/footer-alluvia.php`**

```php
<?php
/**
 * Shared footer partial — included on commerce pages (cart, checkout, product).
 * Usage: get_template_part( 'partials/footer-alluvia' );
 * For pages already using <footer class="alluvia-footer"> from alluvia-base.css,
 * keep using that structure; this partial matches it.
 */
$shop_url = function_exists('alluvia_shop_url') ? alluvia_shop_url() : home_url('/shop/');
$shop_cats = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'number'     => 5,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'exclude'    => [absint(get_option('default_product_cat'))],
]);
if (is_wp_error($shop_cats)) $shop_cats = [];
?>
<footer class="alluvia-footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" style="margin-bottom:4px">
        <?php echo alluvia_logo_svg(); ?>
      </a>
      <p class="footer-desc">Pharmaceutical-grade bioactive peptides — backed by science, delivered with integrity.</p>
      <div class="footer-socials">
        <a href="#" class="social-btn"><i data-lucide="instagram" style="width:16px;height:16px"></i></a>
        <a href="#" class="social-btn"><i data-lucide="twitter" style="width:16px;height:16px"></i></a>
        <a href="#" class="social-btn"><i data-lucide="facebook" style="width:16px;height:16px"></i></a>
        <a href="#" class="social-btn"><i data-lucide="youtube" style="width:16px;height:16px"></i></a>
      </div>
    </div>
    <div>
      <h3 class="footer-col-title">Products</h3>
      <ul class="footer-links">
        <?php if (!empty($shop_cats)) : foreach ($shop_cats as $cat) : ?>
          <li><a href="<?php echo esc_url(add_query_arg('product_cat', $cat->slug, $shop_url)); ?>">
            <i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>
            <?php echo esc_html($cat->name); ?>
          </a></li>
        <?php endforeach; else : ?>
          <li><a href="<?php echo esc_url($shop_url); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>All Peptides</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div>
      <h3 class="footer-col-title">Company</h3>
      <ul class="footer-links">
        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>About Us</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Contact</a></li>
        <li><a href="<?php echo esc_url(home_url('/coa-library/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>COA Library</a></li>
        <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Shipping</a></li>
      </ul>
    </div>
    <div>
      <h3 class="footer-col-title">Legal</h3>
      <ul class="footer-links">
        <li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Terms &amp; Conditions</a></li>
        <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Privacy Policy</a></li>
        <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Shipping Policy</a></li>
        <li><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Disclaimer</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?php echo date('Y'); ?> Alluvia Peptides. All rights reserved.</p>
    <div class="footer-bottom-links">
      <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms</a>
      <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy</a>
      <a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping</a>
      <a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a>
    </div>
  </div>
</footer>
```

- [ ] **Step 2: Commit**

```bash
git add partials/footer-alluvia.php
git commit -m "feat: add shared footer partial with live categories and real URLs"
```

---

## Task 3: Wire page-product.php to Live WooCommerce Product

**Files:**
- Modify: `page-product.php`

Currently shows BPC-157 hardcoded for every product. Must use `wc_get_product(get_the_ID())`.

- [ ] **Step 1: Add PHP data block at the top of page-product.php (before `add_action('wp_head'...)`)**

Replace the `<?php /**` header block through to `add_action( 'wp_head'...` with:

```php
<?php
/**
 * Template Name: Alluvia – Product
 *
 * @package Shopping
 */

// ── Product data ─────────────────────────────────────────────────────────────
global $post;
$product     = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
$price_html  = $product ? $product->get_price_html() : '';
$short_desc  = $product ? wp_kses_post($product->get_short_description()) : '';
$long_desc   = get_the_content();
$avg_rating  = $product ? floatval($product->get_average_rating()) : 0;
$review_count = $product ? $product->get_review_count() : 0;
$stock_status = $product ? $product->get_stock_status() : 'instock';
$is_on_sale  = $product && $product->is_on_sale();
$is_featured = $product && $product->is_featured();
$add_to_cart_url = $product ? $product->add_to_cart_url() : '#';
$thumb_url   = get_the_post_thumbnail_url(get_the_ID(), 'woocommerce_single');

// Primary category
$terms       = wp_get_post_terms(get_the_ID(), 'product_cat', ['number' => 1]);
$primary_cat = (!is_wp_error($terms) && !empty($terms)) ? $terms[0] : null;
$cat_name    = $primary_cat ? $primary_cat->name : '';
$cat_url     = $primary_cat ? get_term_link($primary_cat) : alluvia_shop_url();

// Specs from product meta (with fallbacks)
$sku         = $product ? $product->get_sku() : '';
$weight      = $product ? $product->get_weight() : '';

// Related products (WC native)
$related_ids = $product ? wc_get_related_products(get_the_ID(), 4) : [];
```

- [ ] **Step 2: Replace the hardcoded breadcrumb**

Find:
```php
    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
    <i data-lucide="chevron-right" width="14" height="14"></i>
    <a href="<?php echo esc_url(alluvia_shop_url()); ?>">Shop</a>
    <i data-lucide="chevron-right" width="14" height="14"></i>
    <a href="<?php echo esc_url(alluvia_shop_url()); ?>">Medical Peptides</a>
    <i data-lucide="chevron-right" width="14" height="14"></i>
    <span>BPC-157</span>
```

Replace with:
```php
    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
    <i data-lucide="chevron-right" width="14" height="14"></i>
    <a href="<?php echo esc_url(alluvia_shop_url()); ?>">Shop</a>
    <?php if ($cat_name) : ?>
      <i data-lucide="chevron-right" width="14" height="14"></i>
      <a href="<?php echo esc_url(is_wp_error($cat_url) ? alluvia_shop_url() : $cat_url); ?>"><?php echo esc_html($cat_name); ?></a>
    <?php endif; ?>
    <i data-lucide="chevron-right" width="14" height="14"></i>
    <span><?php echo esc_html(get_the_title()); ?></span>
```

- [ ] **Step 3: Replace hardcoded product hero section**

Find the `<div class="gallery-main">` block through `</div><!-- INFO -->` and replace the hardcoded values:

**Gallery main image:**
```php
      <div class="gallery-main">
        <?php if ($is_featured) : ?>
          <span class="gallery-badge">Best Seller</span>
        <?php elseif ($is_on_sale) : ?>
          <span class="gallery-badge" style="background:var(--coral);color:#fff">Sale</span>
        <?php endif; ?>
        <?php if ($thumb_url) : ?>
          <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
        <?php else : ?>
          <i class="vial-icon" data-lucide="flask-conical" width="120" height="120" style="color:var(--teal)"></i>
        <?php endif; ?>
      </div>
```

**Product info — category, title, subtitle, rating, price:**
```php
      <div class="product-info">
        <?php if ($cat_name) : ?>
          <div class="prod-cat"><?php echo esc_html($cat_name); ?></div>
        <?php endif; ?>
        <h1><?php echo esc_html(get_the_title()); ?></h1>
        <?php if ($short_desc) : ?>
          <p class="prod-subtitle"><?php echo $short_desc; ?></p>
        <?php endif; ?>
        <?php if ($avg_rating > 0) : ?>
        <div class="prod-rating">
          <span class="stars">
            <?php for ($s = 1; $s <= 5; $s++) : ?>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $s <= round($avg_rating) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="1.5"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
            <?php endfor; ?>
          </span>
          <span class="rating-text"><?php echo esc_html(number_format($avg_rating, 1)); ?><?php if ($review_count > 0) echo ' · <a href="#reviews">' . esc_html($review_count) . ' verified reviews</a>'; ?></span>
        </div>
        <?php endif; ?>
        <div class="prod-price-row">
          <span class="prod-price"><?php echo $price_html; ?></span>
        </div>
```

**SKU spec item** — replace the hardcoded spec-grid block:
```php
        <div class="spec-grid">
          <?php if ($sku) : ?>
            <div class="spec-item"><i data-lucide="tag" width="18" height="18"></i><div><div class="spec-label">SKU</div><div class="spec-value"><?php echo esc_html($sku); ?></div></div></div>
          <?php endif; ?>
          <div class="spec-item"><i data-lucide="check-circle" width="18" height="18"></i><div>
            <div class="spec-label">Stock</div>
            <div class="spec-value" style="color:<?php echo $stock_status === 'instock' ? 'var(--mint)' : 'var(--coral)'; ?>">
              <?php echo $stock_status === 'instock' ? 'In Stock' : 'Out of Stock'; ?>
            </div>
          </div></div>
          <?php if ($product && $product->get_attribute('Purity')) : ?>
            <div class="spec-item"><i data-lucide="beaker" width="18" height="18"></i><div><div class="spec-label">Purity</div><div class="spec-value"><?php echo esc_html($product->get_attribute('Purity')); ?></div></div></div>
          <?php endif; ?>
          <?php if ($product && $product->get_attribute('Form')) : ?>
            <div class="spec-item"><i data-lucide="snowflake" width="18" height="18"></i><div><div class="spec-label">Form</div><div class="spec-value"><?php echo esc_html($product->get_attribute('Form')); ?></div></div></div>
          <?php endif; ?>
        </div>
```

**Add to cart / buy now buttons:**
```php
        <div class="purchase-row">
          <div class="qty-stepper">
            <button class="qty-btn" onclick="changeQty(-1)"><i data-lucide="minus" width="14" height="14"></i></button>
            <input class="qty-input" id="qty" type="number" value="1" min="1" max="99">
            <button class="qty-btn" onclick="changeQty(1)"><i data-lucide="plus" width="14" height="14"></i></button>
          </div>
          <?php if ($stock_status === 'instock') : ?>
            <a href="<?php echo esc_url($add_to_cart_url); ?>" class="btn-add-cart">
              <i data-lucide="shopping-cart" width="18" height="18"></i> Add to Cart
            </a>
          <?php else : ?>
            <button class="btn-add-cart" disabled style="opacity:.5;cursor:not-allowed">Out of Stock</button>
          <?php endif; ?>
          <button class="btn-wishlist" id="wishBtn" onclick="toggleWish()"><i data-lucide="heart" width="20" height="20"></i></button>
        </div>
        <a href="<?php echo esc_url(alluvia_checkout_url()); ?>" class="buy-now">Buy Now — Express Checkout</a>
```

- [ ] **Step 4: Replace hardcoded tabs content**

The Description tab should show the actual product `$long_desc`. Find:
```html
      <p>BPC-157 (Body Protection Compound-157) is a synthetic...
```
Replace with:
```php
      <?php if ($long_desc) : ?>
        <?php echo apply_filters('the_content', $long_desc); ?>
      <?php else : ?>
        <p><?php echo $short_desc; ?></p>
      <?php endif; ?>
```

- [ ] **Step 5: Replace hardcoded related products**

Find the `<div class="related-grid">` block and replace it:

```php
    <div class="related-grid">
      <?php if (!empty($related_ids)) : foreach (array_slice($related_ids, 0, 4) as $rel_id) :
          $rel = wc_get_product($rel_id);
          if (!$rel) continue;
          $rel_thumb = get_the_post_thumbnail_url($rel_id, 'woocommerce_thumbnail');
          $rel_cats = wp_get_post_terms($rel_id, 'product_cat', ['number' => 1]);
          $rel_cat_name = (!is_wp_error($rel_cats) && !empty($rel_cats)) ? $rel_cats[0]->name : '';
      ?>
        <a href="<?php echo esc_url(get_permalink($rel_id)); ?>" class="rel-card">
          <div class="rel-thumb" style="background:linear-gradient(135deg,rgba(14,175,159,0.12),rgba(14,175,159,0.04))">
            <?php if ($rel_thumb) : ?>
              <img src="<?php echo esc_url($rel_thumb); ?>" alt="<?php echo esc_attr($rel->get_name()); ?>" style="width:100%;height:100%;object-fit:cover">
            <?php else : ?>
              <i data-lucide="flask-conical" width="36" height="36" style="color:var(--teal)"></i>
            <?php endif; ?>
          </div>
          <div class="rel-body">
            <?php if ($rel_cat_name) : ?><div class="rel-cat"><?php echo esc_html($rel_cat_name); ?></div><?php endif; ?>
            <div class="rel-name"><?php echo esc_html($rel->get_name()); ?></div>
            <div class="rel-price"><?php echo $rel->get_price_html(); ?></div>
          </div>
        </a>
      <?php endforeach; endif; ?>
    </div>
```

- [ ] **Step 6: Replace hardcoded footer**

Find the `<footer>` through `</footer>` block at the bottom of page-product.php and replace with:
```php
<?php get_template_part('partials/footer-alluvia'); ?>
```

- [ ] **Step 7: Commit**

```bash
git add page-product.php
git commit -m "feat: wire page-product.php to live WooCommerce product data"
```

---

## Task 4: Wire page-cart.php to Real WooCommerce Cart

**Files:**
- Modify: `page-cart.php`

- [ ] **Step 1: Add PHP data block at top of page-cart.php (before `add_action`)**

```php
<?php
/**
 * Template Name: Alluvia – Cart
 *
 * @package Shopping
 */

// ── Cart data ─────────────────────────────────────────────────────────────────
$cart        = function_exists('WC') ? WC()->cart : null;
$cart_items  = $cart ? $cart->get_cart() : [];
$cart_count  = $cart ? $cart->get_cart_contents_count() : 0;
$subtotal    = $cart ? floatval($cart->get_subtotal()) : 0;
$total       = $cart ? floatval($cart->get_total('edit')) : 0;
```

- [ ] **Step 2: Replace the hardcoded cart table body**

Find everything between `<div class="cart-table">` opening and `</div><!-- .cart-table -->` and replace with:

```php
    <div class="cart-table">
      <?php if (!empty($cart_items)) : ?>
        <div class="cart-header">
          <span>Product</span><span>Price</span><span>Quantity</span><span>Total</span><span></span>
        </div>
        <?php foreach ($cart_items as $cart_item_key => $cart_item) :
            $_product   = $cart_item['data'];
            $qty        = $cart_item['quantity'];
            $price      = floatval($_product->get_price());
            $line_total = $price * $qty;
            $thumb_url  = get_the_post_thumbnail_url($cart_item['product_id'], 'woocommerce_thumbnail');
            $cats       = wp_get_post_terms($cart_item['product_id'], 'product_cat', ['number' => 1]);
            $cat_name   = (!is_wp_error($cats) && !empty($cats)) ? $cats[0]->name : '';
            $remove_url = wc_get_cart_remove_url($cart_item_key);
        ?>
        <div class="cart-item" data-price="<?php echo esc_attr($price); ?>">
          <div class="item-info">
            <div class="item-thumb teal-bg">
              <?php if ($thumb_url) : ?>
                <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($_product->get_name()); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:6px">
              <?php else : ?>
                <i data-lucide="flask-conical" width="28" height="28" style="color:var(--teal)"></i>
              <?php endif; ?>
            </div>
            <div class="item-details">
              <div class="item-name"><a href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>" style="color:inherit;text-decoration:none"><?php echo esc_html($_product->get_name()); ?></a></div>
              <?php if ($cat_name) : ?><span class="item-badge badge-teal"><?php echo esc_html($cat_name); ?></span><?php endif; ?>
              <div class="item-meta"><?php echo esc_html($_product->get_sku() ? 'SKU: ' . $_product->get_sku() : ''); ?></div>
            </div>
          </div>
          <div class="item-price"><?php echo wc_price($price); ?></div>
          <div class="qty-stepper">
            <button class="qty-btn" onclick="changeQty(this,-1)"><i data-lucide="minus" width="12" height="12"></i></button>
            <input class="qty-input" type="number" value="<?php echo esc_attr($qty); ?>" min="1" max="99"
                   name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" onchange="updateTotals()">
            <button class="qty-btn" onclick="changeQty(this,1)"><i data-lucide="plus" width="12" height="12"></i></button>
          </div>
          <div class="item-total"><?php echo wc_price($line_total); ?></div>
          <a href="<?php echo esc_url($remove_url); ?>" class="remove-btn" title="Remove">
            <i data-lucide="trash-2" width="16" height="16"></i>
          </a>
        </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div style="padding:48px;text-align:center;color:var(--text-mid)">
          <i data-lucide="shopping-cart" style="width:48px;height:48px;opacity:.3;margin-bottom:16px"></i>
          <p style="font-size:18px;font-weight:600;color:var(--navy)">Your cart is empty</p>
          <a href="<?php echo esc_url(alluvia_shop_url()); ?>" style="display:inline-flex;align-items:center;gap:8px;margin-top:16px;background:var(--teal);color:var(--navy);padding:12px 24px;border-radius:100px;font-weight:700;text-decoration:none">
            <i data-lucide="arrow-left" style="width:14px;height:14px"></i> Browse Peptides
          </a>
        </div>
      <?php endif; ?>
    </div><!-- .cart-table -->
```

- [ ] **Step 3: Update the cart section header and summary values**

Replace `<h2><i data-lucide="shopping-cart"...> 4 Items</h2>` with:
```php
    <h2><i data-lucide="shopping-cart" width="22" height="22" style="color:var(--teal)"></i> <?php echo esc_html($cart_count); ?> <?php echo _n('Item', 'Items', $cart_count, 'shopping'); ?></h2>
```

Replace the hardcoded summary rows in `<div class="order-summary">`:
```php
      <div class="summary-row">
        <span class="label">Subtotal (<?php echo esc_html($cart_count); ?> items)</span>
        <span class="value" id="subtotalVal"><?php echo wc_price($subtotal); ?></span>
      </div>
      <div class="summary-row shipping">
        <span class="label">Shipping</span>
        <span class="value">Calculated at checkout</span>
      </div>
      <div class="summary-row">
        <span class="label">Tax</span>
        <span class="value">Calculated at checkout</span>
      </div>
      <hr class="summary-divider">
      <div class="summary-total">
        <span class="label">Estimated Total</span>
        <span class="value"><?php echo wc_price($subtotal); ?></span>
      </div>
```

- [ ] **Step 4: Replace hardcoded "You May Also Like" with live WooCommerce products**

Find the `<div class="also-grid">` block and replace:
```php
    <div class="also-grid">
      <?php
      $also_query = new WP_Query(['post_type'=>'product','post_status'=>'publish','posts_per_page'=>4,'orderby'=>'rand','post__not_in'=>array_column($cart_items,'product_id')]);
      while ($also_query->have_posts()) : $also_query->the_post();
          $also_product = wc_get_product(get_the_ID());
          if (!$also_product) continue;
          $also_thumb = get_the_post_thumbnail_url(get_the_ID(), 'woocommerce_thumbnail');
      ?>
      <div class="also-card">
        <a href="<?php echo esc_url(get_permalink()); ?>" class="also-thumb" style="background:linear-gradient(135deg,rgba(14,175,159,0.12),rgba(14,175,159,0.04));display:flex;align-items:center;justify-content:center;height:100px;text-decoration:none">
          <?php if ($also_thumb) : ?>
            <img src="<?php echo esc_url($also_thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="width:100%;height:100%;object-fit:cover">
          <?php else : ?>
            <i data-lucide="flask-conical" width="32" height="32" style="color:var(--teal)"></i>
          <?php endif; ?>
        </a>
        <div class="also-body">
          <div class="also-name"><?php echo esc_html(get_the_title()); ?></div>
          <div class="also-price"><?php echo $also_product->get_price_html(); ?></div>
          <a href="<?php echo esc_url($also_product->add_to_cart_url()); ?>" class="also-add">
            <i data-lucide="plus" width="14" height="14"></i> Add to Cart
          </a>
        </div>
      </div>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
```

- [ ] **Step 5: Replace the hardcoded footer**

Remove the entire `<footer>...</footer>` block and replace with:
```php
<?php get_template_part('partials/footer-alluvia'); ?>
```

- [ ] **Step 6: Commit**

```bash
git add page-cart.php
git commit -m "feat: wire page-cart.php to live WooCommerce cart data"
```

---

## Task 5: Wire page-checkout.php Sidebar + Fix Footer

**Files:**
- Modify: `page-checkout.php`

The checkout page's order sidebar shows hardcoded items. The sidebar should reflect what's actually in the cart.

- [ ] **Step 1: Add PHP data block at top of page-checkout.php**

```php
<?php
/**
 * Template Name: Alluvia – Checkout
 *
 * @package Shopping
 */

$cart       = function_exists('WC') ? WC()->cart : null;
$cart_items = $cart ? $cart->get_cart() : [];
$subtotal   = $cart ? floatval($cart->get_subtotal()) : 0;
$cart_count = $cart ? $cart->get_cart_contents_count() : 0;
```

- [ ] **Step 2: Replace hardcoded sidebar items**

Find the `<div class="sidebar-items">` block and replace:
```php
      <div class="sidebar-items">
        <?php foreach ($cart_items as $item) :
            $_product = $item['data'];
        ?>
        <div class="s-item">
          <div>
            <div class="s-item-name"><?php echo esc_html($_product->get_name()); ?></div>
            <div class="s-item-qty">×<?php echo esc_html($item['quantity']); ?></div>
          </div>
          <div class="s-item-price"><?php echo wc_price(floatval($_product->get_price()) * $item['quantity']); ?></div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($cart_items)) : ?>
          <div class="s-item"><div class="s-item-name" style="color:var(--text-light)">No items in cart</div></div>
        <?php endif; ?>
      </div>
      <hr class="s-divider">
      <div class="s-row"><span class="lbl">Subtotal</span><span class="val"><?php echo wc_price($subtotal); ?></span></div>
      <div class="s-row"><span class="lbl">Shipping</span><span class="val" id="sideShipping">Calculated</span></div>
      <div class="s-row"><span class="lbl">Tax</span><span class="val">Calculated</span></div>
      <hr class="s-divider">
      <div class="s-total"><span class="lbl">Estimated Total</span><span class="val"><?php echo wc_price($subtotal); ?></span></div>
```

- [ ] **Step 3: Replace truncated footer**

Find the `<footer>` through `</footer>` block (which only has `footer-bottom`, missing the grid) and replace with:
```php
<?php get_template_part('partials/footer-alluvia'); ?>
```

- [ ] **Step 4: Commit**

```bash
git add page-checkout.php
git commit -m "feat: wire checkout sidebar to real cart, fix truncated footer"
```

---

## Task 6: Push All Changes

- [ ] **Step 1: Verify no PHP errors**

Browse to `alluviapeptides.test/shop/`, `/cart/`, `/checkout/`, and any product page. Confirm no white screen or PHP fatal errors.

- [ ] **Step 2: Push to GitHub**

```bash
git push origin claude/modest-einstein-g6a99j
```

Expected output: `claude/modest-einstein-g6a99j -> claude/modest-einstein-g6a99j`

---

## Self-Review

**Spec coverage:**
- ✅ Task 1: Missing CSS tokens (`--radius`, `--purple`, `--orange`, `--mint`, `--sky`)
- ✅ Task 2: Shared footer partial with real URLs, live categories, dynamic copyright year
- ✅ Task 3: `page-product.php` wired to current product
- ✅ Task 4: `page-cart.php` wired to real cart
- ✅ Task 5: `page-checkout.php` sidebar wired, footer fixed
- ✅ Task 6: Push and deploy

**Placeholder scan:** All code blocks are complete and executable.

**Type consistency:** `wc_get_product()` used consistently; `WC()->cart->get_cart()` used in cart and checkout with the same `$cart_items` variable naming.
