<?php
/**
 * Template Name: Alluvia – Cart
 *
 * @package Shopping
 */
// ── Cart data ─────────────────────────────────────────────────────────────────
$cart_items   = function_exists('WC') && WC()->cart ? WC()->cart->get_cart() : [];
$subtotal     = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_subtotal() : '$0.00';
$cart_total   = function_exists('WC') && WC()->cart ? WC()->cart->get_total() : '$0.00';
$cart_count   = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$shipping_total = function_exists('WC') && WC()->cart ? WC()->cart->get_shipping_total() : 0;
$coupon_discount = function_exists('WC') && WC()->cart ? WC()->cart->get_discount_total() : 0;

add_action( 'wp_head', function() {
?>
<style>
/* HERO STRIP */
.page-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:6rem 2rem 3rem;margin-top:72px}
.page-hero-inner{max-width:1200px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:13px;color:var(--text-light);margin-bottom:1rem}
.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.6);font-size:16px}

/* LAYOUT */
.cart-layout{max-width:1200px;margin:0 auto;padding:3rem 2rem;display:grid;grid-template-columns:1fr 360px;gap:2.5rem;align-items:start}

/* CART TABLE */
.cart-section{}
.cart-section h2{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.5rem}
.cart-table{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.06)}
.cart-header{display:grid;grid-template-columns:2fr 1fr 1fr 1fr 40px;gap:1rem;padding:1rem 1.5rem;background:var(--navy);color:rgba(255,255,255,0.65);font-family:'Space Grotesk',sans-serif;font-size:var(--fs-sm);font-weight:600;letter-spacing:0.08em;text-transform:uppercase}
.cart-item{display:grid;grid-template-columns:2fr 1fr 1fr 1fr 40px;gap:1rem;padding:1.25rem 1.5rem;align-items:center;border-bottom:1px solid var(--pearl);transition:background .2s}
.cart-item:last-child{border-bottom:none}
.cart-item:hover{background:var(--pearl)}
.item-info{display:flex;align-items:center;gap:1rem}
.item-thumb{width:60px;height:60px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.item-thumb.teal-bg{background:linear-gradient(135deg,rgba(14,175,159,0.15),rgba(14,175,159,0.05));border:1px solid rgba(14,175,159,0.2)}
.item-thumb.coral-bg{background:linear-gradient(135deg,rgba(219,98,122,0.15),rgba(219,98,122,0.05));border:1px solid rgba(219,98,122,0.2)}
.item-thumb.gold-bg{background:linear-gradient(135deg,rgba(198,162,83,0.15),rgba(198,162,83,0.05));border:1px solid rgba(198,162,83,0.2)}
.item-details{}
.item-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:var(--fs-body);color:var(--text-dark)}
.item-badge{display:inline-block;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:600;letter-spacing:0.06em;padding:2px 8px;border-radius:50px;margin-top:3px}
.badge-teal{background:rgba(14,175,159,0.12);color:var(--teal-dark)}
.badge-coral{background:rgba(219,98,122,0.12);color:#c0405a}
.badge-gold{background:rgba(198,162,83,0.12);color:#a07c3a}
.item-meta{font-size:var(--fs-base);color:var(--text-light);margin-top:2px}
.item-price{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:var(--fs-base)}
.qty-stepper{display:flex;align-items:center;gap:0;border:1px solid var(--pearl-dark);border-radius:8px;overflow:hidden;width:fit-content}
.qty-btn{background:#fff;border:none;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-mid);transition:all .2s}
.qty-btn:hover{background:var(--teal);color:#fff}
.qty-input{width:40px;height:32px;border:none;border-left:1px solid var(--pearl-dark);border-right:1px solid var(--pearl-dark);text-align:center;font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:var(--fs-base);color:var(--text-dark);outline:none;background:#fff}
.item-total{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:var(--fs-body);color:var(--teal-dark)}
.remove-btn{background:none;border:none;cursor:pointer;color:var(--text-light);display:flex;align-items:center;justify-content:center;border-radius:6px;width:32px;height:32px;transition:all .2s}
.remove-btn:hover{background:rgba(219,98,122,0.1);color:var(--coral)}

/* CART ACTIONS */
.cart-actions{display:flex;align-items:center;justify-content:space-between;margin-top:1.5rem;flex-wrap:wrap;gap:1rem}
.coupon-row{display:flex;gap:0.5rem;align-items:center}
.coupon-input{border:1px solid var(--pearl-dark);border-radius:8px;padding:0.6rem 1rem;font-family:'Space Grotesk',sans-serif;font-size:var(--fs-base);color:var(--text-dark);outline:none;width:200px;background:#fff;transition:border .2s}
.coupon-input:focus{border-color:var(--teal)}
.coupon-input::placeholder{color:var(--text-light)}
.btn-apply{background:var(--navy);color:#fff;border:none;border-radius:8px;padding:0.6rem 1.2rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;letter-spacing:0.05em}
.btn-apply:hover{background:var(--teal);color:var(--navy)}
.btn-update{background:transparent;color:var(--text-mid);border:1px solid var(--pearl-dark);border-radius:8px;padding:0.6rem 1.2rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:0.4rem}
.btn-update:hover{border-color:var(--teal);color:var(--teal)}

/* DISCOUNT APPLIED */
.discount-applied{display:flex;align-items:center;justify-content:space-between;background:rgba(14,175,159,0.08);border:1px solid rgba(14,175,159,0.25);border-radius:8px;padding:0.75rem 1rem;margin-top:1rem}
.discount-info{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:14px;color:var(--teal-dark);font-weight:600}
.discount-remove{background:none;border:none;cursor:pointer;color:var(--text-light);display:flex;align-items:center}
.discount-remove:hover{color:var(--coral)}

/* TRUST BADGES */
.trust-badges{display:flex;gap:1rem;margin-top:2rem;flex-wrap:wrap}
.trust-badge{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:13px;color:var(--text-mid);background:#fff;border-radius:8px;padding:0.6rem 1rem;flex:1;min-width:150px;box-shadow:0 1px 6px rgba(0,0,0,0.05)}
.trust-badge svg{color:var(--teal);flex-shrink:0}

/* ORDER SUMMARY */
.order-summary{background:#fff;border-radius:var(--radius);box-shadow:0 4px 24px rgba(0,0,0,0.08);position:sticky;top:90px}
.summary-header{background:var(--navy);padding:1.25rem 1.5rem;border-radius:var(--radius) var(--radius) 0 0}
.summary-header h3{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:#fff}
.summary-body{padding:1.5rem}
.summary-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:0.9rem;font-size:var(--fs-body)}
.summary-row .label{color:var(--text-mid)}
.summary-row .value{font-family:'Space Grotesk',sans-serif;font-weight:600;color:var(--text-dark)}
.summary-row.discount .value{color:var(--teal-dark)}
.summary-row.shipping .value{color:var(--mint)}
.summary-divider{border:none;border-top:1px solid var(--pearl-dark);margin:1rem 0}
.summary-total{display:flex;justify-content:space-between;align-items:center;padding:1rem 0 0.5rem}
.summary-total .label{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:var(--fs-body)}
.summary-total .value{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:700;color:var(--navy)}
.btn-checkout{display:block;width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);border:none;border-radius:10px;padding:1rem;font-family:'Space Grotesk',sans-serif;font-size:16px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;margin-top:1.25rem;transition:all .3s;text-decoration:none;text-align:center;display:flex;align-items:center;justify-content:center;gap:0.5rem}
.btn-checkout:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(14,175,159,0.4)}
.summary-note{text-align:center;font-size:var(--fs-base);color:var(--text-light);margin-top:0.75rem;display:flex;align-items:center;justify-content:center;gap:0.3rem}
.payment-icons{display:flex;justify-content:center;gap:0.5rem;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--pearl-dark)}
.pay-icon{background:var(--pearl);border-radius:4px;padding:4px 8px;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;color:var(--text-mid);letter-spacing:0.04em}
.pay-icon.visa{color:#1a1f71}
.pay-icon.mc{color:#eb001b}
.pay-icon.amex{color:#007bc1}
.pay-icon.paypal{color:#003087}

/* SHIPPING ESTIMATE */
.shipping-estimate{background:rgba(88,180,136,0.08);border:1px solid rgba(88,180,136,0.25);border-radius:8px;padding:1rem;margin-top:1rem}
.shipping-estimate h4{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;color:var(--text-dark);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.06em}
.zip-row{display:flex;gap:0.5rem}
.zip-input{flex:1;border:1px solid var(--pearl-dark);border-radius:6px;padding:0.5rem 0.75rem;font-size:13px;font-family:'Space Grotesk',sans-serif;outline:none;background:#fff}
.zip-input:focus{border-color:var(--teal)}
.zip-btn{background:var(--navy);color:#fff;border:none;border-radius:6px;padding:0.5rem 0.75rem;font-size:13px;font-family:'Space Grotesk',sans-serif;font-weight:600;cursor:pointer;white-space:nowrap}

/* ALSO LIKE */
.also-like{max-width:1200px;margin:0 auto 4rem;padding:0 2rem}
.also-like h2{font-family:'Cormorant Garamond',serif;font-size:29px;font-weight:600;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.5rem}
.also-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem}
.also-card{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer}
.also-card:hover{transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,0.12)}
.also-thumb{height:100px;display:flex;align-items:center;justify-content:center;position:relative}
.also-body{padding:1rem}
.also-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:14px;margin-bottom:0.25rem}
.also-price{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:16px;color:var(--teal-dark)}
.also-add{width:100%;background:var(--navy);color:#fff;border:none;border-radius:6px;padding:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;cursor:pointer;margin-top:0.75rem;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:0.4rem}
.also-add:hover{background:var(--teal);color:var(--navy)}

/* RESPONSIVE */
@media(max-width:1100px){.also-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){
  .cart-layout{grid-template-columns:1fr}
  .order-summary{position:static}
  .cart-header{display:none}
  .cart-item{grid-template-columns:1fr auto;gap:0.75rem}
  .cart-item .item-price,.cart-item .item-total{display:none}
  .item-info{grid-column:1/3}
}
@media(max-width:640px){
  .trust-badges{flex-direction:column}
  .also-grid{grid-template-columns:1fr 1fr}
  .cart-actions{flex-direction:column;align-items:flex-start}
}
@media(max-width:400px){.also-grid{grid-template-columns:1fr}}
</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="page-hero">
  <div class="page-hero-inner">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <i data-lucide="chevron-right" width="14" height="14"></i>
      <span>Shopping Cart</span>
    </div>
    <h1>Your Cart</h1>
    <p>Review your peptide selection before checkout.</p>
  </div>
</div>

<div class="cart-layout">

  <!-- LEFT: CART TABLE -->
  <div class="cart-section">
    <h2><i data-lucide="shopping-cart" width="22" height="22" style="color:var(--teal)"></i> <?php echo $cart_count; ?> Item<?php echo $cart_count !== 1 ? 's' : ''; ?></h2>

    <div class="cart-table">
      <div class="cart-header">
        <span>Product</span>
        <span>Price</span>
        <span>Quantity</span>
        <span>Total</span>
        <span></span>
      </div>

      <?php if (empty($cart_items)) : ?>
        <div class="cart-empty" style="text-align:center;padding:60px 20px">
          <i data-lucide="shopping-cart" width="48" height="48" style="color:var(--text-light);margin-bottom:16px"></i>
          <p style="color:var(--text-mid);font-size:1.1rem">Your cart is empty.</p>
          <a href="<?php echo esc_url(alluvia_shop_url()); ?>" class="btn-add-cart" style="display:inline-flex;margin-top:16px">Browse Products</a>
        </div>
      <?php else : ?>
        <?php foreach ($cart_items as $cart_item_key => $cart_item) :
          $product_id = $cart_item['product_id'];
          $quantity   = $cart_item['quantity'];
          $item_product = $cart_item['data'];
          $item_name  = $item_product->get_name();
          $item_price = WC()->cart->get_product_subtotal($item_product, $quantity);
          $unit_price = wc_price($item_product->get_price());
          $thumb      = get_the_post_thumbnail_url($product_id, 'woocommerce_thumbnail');
          $remove_url = wc_get_cart_remove_url($cart_item_key);
          $update_url = wc_get_cart_url();
        ?>
        <div class="cart-item">
          <div class="item-info">
            <div class="item-thumb teal-bg">
              <?php if ($thumb) : ?>
                <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($item_name); ?>" style="width:60px;height:60px;object-fit:cover;border-radius:8px">
              <?php else : ?>
                <i data-lucide="flask-conical" width="28" height="28" style="color:var(--teal)"></i>
              <?php endif; ?>
            </div>
            <div class="item-details">
              <div class="item-name"><a href="<?php echo esc_url(get_permalink($product_id)); ?>" style="color:inherit;text-decoration:none"><?php echo esc_html($item_name); ?></a></div>
            </div>
          </div>
          <div class="item-price"><?php echo $unit_price; ?></div>
          <div class="qty-stepper">
            <form method="post" action="<?php echo esc_url($update_url); ?>" style="display:contents">
              <input type="hidden" name="cart_item_key" value="<?php echo esc_attr($cart_item_key); ?>">
              <button class="qty-btn" type="button" onclick="changeQty(this,-1)"><i data-lucide="minus" width="12" height="12"></i></button>
              <input class="qty-input" type="number" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" value="<?php echo esc_attr($quantity); ?>" min="1" max="99" onchange="this.form.submit()">
              <button class="qty-btn" type="button" onclick="changeQty(this,1)"><i data-lucide="plus" width="12" height="12"></i></button>
              <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </form>
          </div>
          <div class="item-total"><?php echo $item_price; ?></div>
          <a href="<?php echo esc_url($remove_url); ?>" class="remove-btn" title="Remove"><i data-lucide="trash-2" width="16" height="16"></i></a>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div><!-- .cart-table -->

    <!-- COUPON + UPDATE -->
    <div class="cart-actions">
      <div class="coupon-row">
        <input class="coupon-input" type="text" id="couponInput" placeholder="Promo code (try WELCOME10)" value="">
        <button class="btn-apply" onclick="applyCoupon()">Apply</button>
      </div>
      <button class="btn-update" onclick="updateCart()">
        <i data-lucide="refresh-cw" width="14" height="14"></i>
        Update Cart
      </button>
    </div>

    <div class="discount-applied" id="discountRow" style="display:none">
      <div class="discount-info">
        <i data-lucide="tag" width="16" height="16"></i>
        <span>WELCOME10 — 10% off applied (−$<span id="discountAmt">25.00</span>)</span>
      </div>
      <button class="discount-remove" onclick="removeCoupon()" title="Remove coupon">
        <i data-lucide="x" width="16" height="16"></i>
      </button>
    </div>

    <!-- TRUST BADGES -->
    <div class="trust-badges">
      <div class="trust-badge">
        <i data-lucide="shield-check" width="16" height="16"></i>
        SSL Encrypted Checkout
      </div>
      <div class="trust-badge">
        <i data-lucide="thermometer-snowflake" width="16" height="16"></i>
        Cold-Chain Shipping Available
      </div>
      <div class="trust-badge">
        <i data-lucide="award" width="16" height="16"></i>
        COA on Every Batch
      </div>
      <div class="trust-badge">
        <i data-lucide="rotate-ccw" width="16" height="16"></i>
        Integrity Guarantee
      </div>
    </div>
  </div><!-- .cart-section -->

  <!-- RIGHT: ORDER SUMMARY -->
  <div class="order-summary">
    <div class="summary-header">
      <h3>Order Summary</h3>
    </div>
    <div class="summary-body">
      <div class="summary-row">
        <span class="label">Subtotal (<?php echo $cart_count; ?> item<?php echo $cart_count !== 1 ? 's' : ''; ?>)</span>
        <span class="value" id="subtotalVal"><?php echo $subtotal; ?></span>
      </div>
      <?php if ($coupon_discount > 0) : ?>
      <div class="summary-row discount" id="discountSummaryRow">
        <span class="label">Discount</span>
        <span class="value" style="color:var(--mint)">-<?php echo wc_price($coupon_discount); ?></span>
      </div>
      <?php endif; ?>
      <div class="summary-row shipping">
        <span class="label">Shipping</span>
        <span class="value"><?php echo $shipping_total > 0 ? wc_price($shipping_total) : '<em style="color:var(--mint)">Free</em>'; ?></span>
      </div>
      <hr class="summary-divider">
      <div class="summary-total">
        <span class="label">Total</span>
        <span class="value" id="totalVal" style="font-weight:700"><?php echo $cart_total; ?></span>
      </div>

      <a href="<?php echo esc_url(alluvia_checkout_url()); ?>" class="btn-checkout">
        <i data-lucide="lock" width="16" height="16"></i>
        Proceed to Checkout
      </a>

      <p class="summary-note">
        <i data-lucide="shield" width="12" height="12"></i>
        Secured by 256-bit SSL encryption
      </p>

      <div class="payment-icons">
        <span class="pay-icon visa">VISA</span>
        <span class="pay-icon mc">MC</span>
        <span class="pay-icon amex">AMEX</span>
        <span class="pay-icon paypal">PayPal</span>
      </div>

      <!-- SHIPPING ESTIMATE -->
      <div class="shipping-estimate">
        <h4>Estimate Shipping</h4>
        <div class="zip-row">
          <input class="zip-input" type="text" placeholder="ZIP / Postal Code" id="zipInput">
          <button class="zip-btn" onclick="estimateShipping()">Estimate</button>
        </div>
        <div id="shippingResult" style="font-size:0.82rem;color:var(--teal-dark);margin-top:0.6rem;display:none">
          <i data-lucide="check-circle" width="14" height="14" style="vertical-align:middle;margin-right:4px"></i>
          Standard (3–5 days): <strong>Free</strong> · Express (1–2 days): <strong>$12.99</strong>
        </div>
      </div>
    </div>
  </div><!-- .order-summary -->

</div><!-- .cart-layout -->

<!-- YOU MAY ALSO LIKE -->
<div class="also-like">
  <h2><i data-lucide="heart" width="22" height="22" style="color:var(--coral)"></i> You May Also Like</h2>
  <div class="also-grid">
    <?php
    $featured_args = [
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'meta_key'       => '_featured',
        'meta_value'     => 'yes',
        'orderby'        => 'rand',
    ];
    $featured_q = new WP_Query($featured_args);
    if (!$featured_q->have_posts()) {
        $featured_args = ['post_type'=>'product','posts_per_page'=>4,'orderby'=>'rand'];
        $featured_q = new WP_Query($featured_args);
    }
    if ($featured_q->have_posts()) : while ($featured_q->have_posts()) : $featured_q->the_post();
        $rel_product = wc_get_product(get_the_ID());
        $rel_thumb   = get_the_post_thumbnail_url(get_the_ID(), 'woocommerce_thumbnail');
    ?>
    <a href="<?php echo esc_url(get_permalink()); ?>" class="also-card" style="text-decoration:none;color:inherit">
      <div class="also-thumb" style="background:linear-gradient(135deg,rgba(14,175,159,.12),rgba(14,175,159,.04))">
        <?php if ($rel_thumb) : ?><img src="<?php echo esc_url($rel_thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="width:100%;height:100%;object-fit:cover"><?php else : ?><i data-lucide="flask-conical" width="36" height="36" style="color:var(--teal)"></i><?php endif; ?>
      </div>
      <div class="also-body">
        <div class="also-name"><?php echo esc_html(get_the_title()); ?></div>
        <div class="also-price"><?php echo $rel_product ? $rel_product->get_price_html() : ''; ?></div>
        <button class="also-add"><i data-lucide="plus" width="14" height="14"></i> Add to Cart</button>
      </div>
    </a>
    <?php endwhile; wp_reset_postdata(); endif; ?>
  </div>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>

<script>
lucide.createIcons();

const ITEM_PRICES = [65, 52, 68];

function getQtys() {
  return Array.from(document.querySelectorAll('.qty-input')).map(i => parseInt(i.value) || 1);
}

function changeQty(btn, delta) {
  const input = btn.parentElement.querySelector('.qty-input');
  const newVal = Math.max(1, (parseInt(input.value) || 1) + delta);
  input.value = newVal;
  updateTotals();
}

let couponActive = false;

function updateTotals() {
  const items = document.querySelectorAll('.cart-item');
  let subtotal = 0;
  items.forEach((item, i) => {
    if (i >= ITEM_PRICES.length) return;
    const qty = parseInt(item.querySelector('.qty-input')?.value) || 1;
    const rowTotal = ITEM_PRICES[i] * qty;
    subtotal += rowTotal;
    const totalEl = item.querySelector('.item-total');
    if (totalEl) totalEl.textContent = '$' + rowTotal.toFixed(2);
  });

  const discount = couponActive ? subtotal * 0.10 : 0;
  const tax = (subtotal - discount) * 0.09;
  const total = subtotal - discount + 9.99 + tax;

  document.getElementById('subtotalVal').textContent = '$' + subtotal.toFixed(2);
  document.getElementById('taxVal').textContent = '$' + tax.toFixed(2);
  document.getElementById('totalVal').textContent = '$' + total.toFixed(2);

  if (couponActive) {
    document.getElementById('discountAmt').textContent = discount.toFixed(2);
    document.getElementById('discountSummaryAmt').textContent = discount.toFixed(2);
  }
}

function applyCoupon() {
  const code = document.getElementById('couponInput').value.trim().toUpperCase();
  if (code === 'WELCOME10') {
    couponActive = true;
    document.getElementById('discountRow').style.display = 'flex';
    document.getElementById('discountSummaryRow').style.display = 'flex';
    document.getElementById('couponInput').value = 'WELCOME10';
    updateTotals();
    showToast('Coupon WELCOME10 applied — 10% off!');
  } else if (code === '') {
    showToast('Enter a promo code first.');
  } else {
    showToast('Invalid promo code. Try WELCOME10.', true);
  }
}

function removeCoupon() {
  couponActive = false;
  document.getElementById('discountRow').style.display = 'none';
  document.getElementById('discountSummaryRow').style.display = 'none';
  document.getElementById('couponInput').value = '';
  updateTotals();
}

function removeItem(btn) {
  const item = btn.closest('.cart-item');
  item.style.opacity = '0';
  item.style.transform = 'translateX(20px)';
  item.style.transition = 'all 0.3s';
  setTimeout(() => { item.remove(); updateTotals(); }, 300);
}

function updateCart() { updateTotals(); showToast('Cart updated.'); }

function estimateShipping() {
  const zip = document.getElementById('zipInput').value.trim();
  if (zip.length >= 4) {
    document.getElementById('shippingResult').style.display = 'block';
    lucide.createIcons();
  } else {
    showToast('Enter a valid ZIP code.', true);
  }
}

function showToast(msg, err = false) {
  const t = document.createElement('div');
  t.textContent = msg;
  Object.assign(t.style, {
    position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',
    background: err ? '#c0405a' : '#0eaf9f',color: err ? '#fff' : '#0a1a27',
    padding:'0.75rem 1.5rem',borderRadius:'50px',fontFamily:"'Space Grotesk',sans-serif",
    fontSize:'0.85rem',fontWeight:'600',zIndex:'9999',
    boxShadow:'0 8px 24px rgba(0,0,0,0.2)',transition:'opacity 0.3s'
  });
  document.body.appendChild(t);
  setTimeout(() => { t.style.opacity='0'; setTimeout(() => t.remove(), 300); }, 2500);
}

document.querySelectorAll('.also-add').forEach(btn => {
  btn.addEventListener('click', () => showToast('Added to cart!'));
});
</script>
