<?php
/**
 * WooCommerce page wrapper — wraps all WooCommerce output inside Alluvia nav/footer.
 * @package Shopping
 */
add_action( 'wp_head', function() {
    echo '<style>
/* WooCommerce page supplements — alluvia-base.css owns nav/footer/buttons/global woo */

/* ── Content wrapper ── */
.alluvia-woo-wrap { padding-top: 88px; min-height: 60vh; background: var(--pearl); }
.alluvia-woo-inner { max-width: 1200px; margin: 0 auto; padding: 60px 40px; }
.alluvia-woo-inner h1,
.alluvia-woo-inner .page-title {
  font-family: var(--font-display);
  font-size: var(--fs-h1);
  font-weight: 300;
  color: var(--navy);
  margin-bottom: 32px;
}

/* ── Single product ── */
.woocommerce div.product .product_title { font-family: var(--font-display); font-size: var(--fs-h1); font-weight: 300; color: var(--navy); margin: 0 0 12px; }
.woocommerce div.product .woocommerce-product-details__short-description { font-size: var(--fs-body); line-height: 1.8; color: var(--text-mid); margin: 16px 0; }
.woocommerce div.product .product_meta { font-size: var(--fs-base); color: var(--text-light); margin-top: 20px; }

/* ── Add to cart ── */
.woocommerce div.product form.cart { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin: 24px 0; }
.woocommerce div.product form.cart .quantity { display: inline-flex; align-items: center; border: 1.5px solid var(--pearl-dark); border-radius: 100px; overflow: hidden; }
.woocommerce .quantity .alluvia-qty-btn { width: 42px; height: 46px; border: none; background: #fff; color: var(--navy); font-size: var(--fs-sub); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: background .2s; }
.woocommerce .quantity .alluvia-qty-btn:hover { background: var(--pearl); }
.woocommerce div.product form.cart .quantity input.qty { width: 48px; height: 46px; border: none; text-align: center; font-family: var(--font-ui); font-size: var(--fs-body); font-weight: 600; -moz-appearance: textfield; background: #fff; }
.woocommerce div.product form.cart .quantity input.qty::-webkit-outer-spin-button,
.woocommerce div.product form.cart .quantity input.qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
.woocommerce div.product form.cart button.single_add_to_cart_button { flex: 1; min-width: 200px; padding: 15px 28px; font-size: var(--fs-ui); }

/* ── Product tabs ── */
.woocommerce div.product .woocommerce-tabs { grid-column: 1/-1; margin-top: 24px; }
.woocommerce div.product .woocommerce-tabs ul.tabs { padding: 0; margin: 0 0 24px; display: flex; gap: 8px; flex-wrap: wrap; border-bottom: 1px solid var(--pearl-dark); }
.woocommerce div.product .woocommerce-tabs ul.tabs::before { display: none; }
.woocommerce div.product .woocommerce-tabs ul.tabs li { background: none; border: none; border-radius: 0; margin: 0; padding: 0; }
.woocommerce div.product .woocommerce-tabs ul.tabs li a { font-family: var(--font-ui); font-size: var(--fs-ui); font-weight: 600; letter-spacing: .04em; text-transform: uppercase; color: var(--text-light); padding: 14px 18px; display: block; border-bottom: 2px solid transparent; }
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover { color: var(--navy); border-bottom-color: var(--teal); }
.woocommerce div.product .woocommerce-tabs ul.tabs li.active { background: none; }
.woocommerce div.product .woocommerce-tabs .panel { font-size: var(--fs-body); line-height: 1.8; color: var(--text-mid); }
.woocommerce div.product .woocommerce-tabs .panel h2,
.woocommerce div.product .woocommerce-tabs .panel h3 { font-family: var(--font-display); color: var(--navy); font-weight: 600; }
.woocommerce div.product .woocommerce-tabs .panel h4 { font-family: var(--font-ui); font-size: var(--fs-title); color: var(--navy); margin: 18px 0 4px; }

/* ── Related / upsells ── */
.woocommerce .related,
.woocommerce .upsells { grid-column: 1/-1; margin-top: 48px; }
.woocommerce .related > h2,
.woocommerce .upsells > h2 { font-family: var(--font-display); font-size: var(--fs-h2); font-weight: 500; color: var(--navy); margin-bottom: 24px; }

/* ── Cart ── */
.woocommerce .cart-collaterals,
.woocommerce-page .cart-collaterals { width: 100%; margin-top: 32px; display: flex; justify-content: flex-end; }
.woocommerce .cart-collaterals .cart_totals { width: 100%; max-width: 420px; }
.woocommerce .cart_totals h2 { font-family: var(--font-display); font-size: var(--fs-h2); font-weight: 500; color: var(--navy); margin-bottom: 16px; }
.woocommerce table.cart img { width: 64px; height: 64px; object-fit: cover; border-radius: var(--radius-sm); }
.woocommerce a.remove { color: var(--coral) !important; font-weight: 700; }
.woocommerce a.remove:hover { background: var(--coral) !important; color: #fff !important; }
.woocommerce .actions .coupon input#coupon_code { border: 1.5px solid var(--pearl-dark); border-radius: 100px; padding: 12px 18px; font-size: var(--fs-base); }

/* ── Checkout payment ── */
.woocommerce-checkout #payment { background: transparent; border-radius: 0; }
.woocommerce-checkout #payment ul.payment_methods { border: none; padding: 0; }
.woocommerce-checkout #payment div.payment_box { background: var(--pearl); border-radius: var(--radius-sm); }
.woocommerce-checkout #payment div.payment_box::before { border-bottom-color: var(--pearl); }
#add_payment_method #payment div.form-row,
.woocommerce-cart #payment div.form-row,
.woocommerce-checkout #payment div.form-row { padding: 18px; }

/* ── My Account navigation ── */
.woocommerce-account:not(.logged-in) .woocommerce > .u-columns,
.woocommerce .col2-set.addresses { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
.woocommerce form.login, .woocommerce form.register { border: 1px solid var(--pearl-dark); border-radius: var(--radius-md); padding: 28px; }

/* ── Responsive ── */
@media (max-width: 1024px) {
  .woocommerce div.product .woocommerce-product-gallery { position: static; max-width: 520px; }
}
@media (max-width: 860px) {
  .woocommerce-account:not(.logged-in) .woocommerce > .u-columns,
  .woocommerce .col2-set.addresses { grid-template-columns: 1fr; gap: 28px; }
  .woocommerce-account .woocommerce-MyAccount-navigation { margin-bottom: 24px; }
  .woocommerce .cart-collaterals .cart_totals { max-width: 100%; }
}
@media (max-width: 680px) {
  .alluvia-woo-inner { padding: 40px 20px; }
  .woocommerce div.product form.cart { flex-direction: column; align-items: stretch; }
  .woocommerce div.product form.cart .quantity { align-self: flex-start; }
  .woocommerce div.product form.cart button.single_add_to_cart_button { width: 100%; }
}
/* ── Shop layout with sidebar ── */
body.woocommerce.post-type-archive-product,.woocommerce-page.post-type-archive-product{background:var(--navy)}
.alluvia-woo-wrap.shop-wrap{background:var(--navy)}
.alluvia-shop-wrap { max-width: 1340px; margin: 0 auto; padding: 48px 40px 100px; display: grid; grid-template-columns: 260px 1fr; gap: 40px; }
.alluvia-shop-sidebar { display: flex; flex-direction: column; gap: 20px; position: sticky; top: 80px; align-self: start; }
.sidebar-card { background: rgba(255,255,255,.05); border-radius: 12px; padding: 20px; border: 1px solid rgba(255,255,255,.08); }
.sidebar-card-title { font-family: var(--font-ui); font-size: 11px; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--teal); margin-bottom: 14px; }
.sidebar-cat-link { display: flex; align-items: center; justify-content: space-between; padding: 9px 10px; border-radius: 8px; font-size: 14px; font-family: var(--font-ui); font-weight: 500; color: rgba(255,255,255,.75); text-decoration: none; transition: background .2s; }
.sidebar-cat-link:hover { background: rgba(255,255,255,.07); color: #fff; }
.sidebar-cat-link.current { background: rgba(14,175,159,.15); color: var(--teal); font-weight: 600; }
.sidebar-cat-count { font-size: 11px; background: rgba(255,255,255,.1); border-radius: 100px; padding: 2px 7px; color: rgba(255,255,255,.5); }
.sidebar-cat-link.current .sidebar-cat-count { background: rgba(14,175,159,.15); color: var(--teal); }
.sidebar-reset-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;border-radius:8px;border:1.5px solid rgba(255,255,255,.1);font-family:var(--font-ui);font-size:13px;font-weight:600;color:rgba(255,255,255,.6);text-decoration:none;background:rgba(255,255,255,.05);transition:.2s}
.sidebar-reset-btn:hover{background:rgba(255,255,255,.1);color:#fff}
@media(max-width:1000px){.alluvia-shop-wrap{grid-template-columns:200px 1fr;padding:32px 24px 80px}}
@media(max-width:768px){.alluvia-shop-wrap{grid-template-columns:1fr;padding:28px 20px 60px}.alluvia-shop-sidebar{display:none}}
</style>';
}, 20 );

get_header( 'alluvia' );
?>

<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="alluvia-woo-wrap<?php echo (function_exists('is_shop') && (is_shop() || is_product_category())) ? ' shop-wrap' : ''; ?>" style="padding-top:88px;min-height:60vh;background:<?php echo (function_exists('is_shop') && (is_shop() || is_product_category())) ? 'var(--navy)' : 'var(--pearl)'; ?>">
<?php if ( function_exists('is_shop') && (is_shop() || is_product_category()) ) :
  $uncategorized_id = absint(get_option('default_product_cat'));
  $nav_cats = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
    'exclude'    => $uncategorized_id ? [$uncategorized_id] : [],
  ]);
  $current_cat_obj = is_product_category() ? get_queried_object() : null;
  $shop_base = function_exists('alluvia_shop_url') ? alluvia_shop_url() : get_option('shop_url');
?>
  <div class="alluvia-shop-wrap">
    <aside class="alluvia-shop-sidebar">
      <div class="sidebar-card">
        <div class="sidebar-card-title">Categories</div>
        <nav>
          <a href="<?php echo esc_url($shop_base); ?>" class="sidebar-cat-link<?php echo (!$current_cat_obj) ? ' current' : ''; ?>">
            All Peptides <span class="sidebar-cat-count"><?php echo wp_count_posts('product')->publish; ?></span>
          </a>
          <?php if (!is_wp_error($nav_cats) && $nav_cats) : foreach ($nav_cats as $nc) : ?>
          <a href="<?php echo esc_url(get_term_link($nc)); ?>" class="sidebar-cat-link<?php echo ($current_cat_obj && $current_cat_obj->term_id === $nc->term_id) ? ' current' : ''; ?>">
            <?php echo esc_html($nc->name); ?> <span class="sidebar-cat-count"><?php echo esc_html($nc->count); ?></span>
          </a>
          <?php endforeach; endif; ?>
        </nav>
      </div>
      <a href="<?php echo esc_url($shop_base); ?>" class="sidebar-reset-btn">Reset Filters</a>
    </aside>
    <div>
      <?php woocommerce_content(); ?>
    </div>
  </div>
<?php else : ?>
  <div class="alluvia-woo-inner">
    <?php woocommerce_content(); ?>
  </div>
<?php endif; ?>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>

<script>
lucide.createIcons();

</script>

<?php get_footer( 'alluvia' ); ?>
