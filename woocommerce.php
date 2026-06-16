<?php
/**
 * WooCommerce page wrapper — wraps all WooCommerce output inside Alluvia nav/footer.
 * @package Shopping
 */
add_action( 'wp_head', function() {
    echo '<style>
/* WooCommerce page supplements — alluvia-base.css owns nav/footer/buttons/global woo */

/* ── Content wrapper ── */
.alluvia-woo-wrap { padding-top: 88px; min-height: 60vh; background: transparent; }
/* Shop/archive loose text sits on the navy platform background — keep it light */
.alluvia-woo-wrap .woocommerce-products-header__title,
.alluvia-woo-wrap .page-title,
.alluvia-woo-inner h1 { color: #fff; }
.alluvia-woo-wrap .woocommerce-result-count,
.alluvia-woo-wrap .term-description,
.alluvia-woo-wrap .woocommerce-ordering label { color: rgba(255,255,255,0.7); }
.alluvia-woo-wrap .woocommerce-ordering select { background: #fff; color: var(--navy); border: 1.5px solid rgba(255,255,255,0.25); border-radius: 100px; padding: 9px 16px; }
.alluvia-woo-wrap .woocommerce-breadcrumb { color: rgba(255,255,255,0.6); }
.alluvia-woo-wrap .woocommerce-breadcrumb a { color: var(--teal); }
.alluvia-woo-inner { max-width: 1200px; margin: 0 auto; padding: 60px 40px; }
.alluvia-woo-inner h1,
.alluvia-woo-inner .page-title {
  font-family: var(--font-display);
  font-size: var(--fs-h1);
  font-weight: 300;
  color: var(--navy);
  margin-bottom: 32px;
}

/* ── Single product layout ── */
.woocommerce div.product { display: grid; grid-template-columns: minmax(0,460px) 1fr; gap: 56px; align-items: start; max-width: 1200px; margin: 0 auto; }
/* Gallery column */
.woocommerce div.product .woocommerce-product-gallery { float: none !important; width: 100% !important; margin: 0 !important; position: sticky; top: 90px; }
.woocommerce div.product .woocommerce-product-gallery figure { margin: 0 !important; }
.woocommerce div.product .woocommerce-product-gallery .woocommerce-product-gallery__wrapper,
.woocommerce div.product .woocommerce-product-gallery .flex-viewport { background: #fff; border: 1px solid var(--pearl-dark); border-radius: var(--radius-md); overflow: hidden; }
.woocommerce div.product .woocommerce-product-gallery__image a { display: flex; align-items: center; justify-content: center; }
.woocommerce div.product .woocommerce-product-gallery__image img { display: block; width: 100%; height: 100%; aspect-ratio: 1 / 1; object-fit: cover; }
.woocommerce div.product .woocommerce-product-gallery__trigger { top: 1rem; right: 1rem; }
/* Thumbnails */
.woocommerce div.product .flex-control-thumbs { display: flex; gap: 10px; margin: 14px 0 0; padding: 0; list-style: none; }
.woocommerce div.product .flex-control-thumbs li { width: 72px !important; margin: 0 !important; float: none !important; }
.woocommerce div.product .flex-control-thumbs img { border: 2px solid transparent; border-radius: 8px; background: #fff; cursor: pointer; transition: border-color .2s; }
.woocommerce div.product .flex-control-thumbs img.flex-active,
.woocommerce div.product .flex-control-thumbs img:hover { border-color: var(--teal); }
/* Summary column */
.woocommerce div.product .summary { float: none !important; width: 100% !important; margin: 0 !important; }
.woocommerce div.product .product_title { font-family: var(--font-display); font-size: clamp(28px,3.5vw,42px); font-weight: 300; color: var(--navy); margin: 0 0 12px; line-height: 1.1; }
.woocommerce div.product .summary .price,
.woocommerce div.product p.price { font-family: var(--font-display); font-size: 32px; font-weight: 600; color: var(--navy); margin: 0 0 16px; }
.woocommerce div.product .woocommerce-product-details__short-description { font-size: var(--fs-body); line-height: 1.8; color: var(--text-mid); margin: 16px 0; }
.woocommerce div.product .product_meta { font-size: var(--fs-base); color: var(--text-light); margin-top: 20px; }
/* Full-width rows below the two columns */
.woocommerce div.product .woocommerce-tabs,
.woocommerce div.product .related,
.woocommerce div.product .upsells { grid-column: 1 / -1; }

/* ── Add to cart ── */
.woocommerce div.product form.cart { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin: 24px 0; }
.woocommerce div.product form.cart .quantity { display: inline-flex; align-items: center; border: 1.5px solid var(--pearl-dark); border-radius: 100px; overflow: hidden; }
.woocommerce .quantity .alluvia-qty-btn { width: 42px; height: 46px; border: none; background: #fff; color: var(--navy); font-size: var(--fs-sub); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: background .2s; }
.woocommerce .quantity .alluvia-qty-btn:hover { background: var(--pearl); }
.woocommerce div.product form.cart .quantity input.qty { width: 48px; height: 46px; border: none; text-align: center; font-family: var(--font-ui); font-size: var(--fs-body); font-weight: 600; -moz-appearance: textfield; background: #fff; }
.woocommerce div.product form.cart .quantity input.qty::-webkit-outer-spin-button,
.woocommerce div.product form.cart .quantity input.qty::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
.woocommerce div.product form.cart button.single_add_to_cart_button { flex: 1; min-width: 200px; padding: 15px 28px; font-size: var(--fs-ui); }
/* ── Platform button colors (override WooCommerce default purple) ── */
.woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
.woocommerce #respond input#submit, .woocommerce .button.alt,
.woocommerce div.product form.cart button.single_add_to_cart_button,
.woocommerce a.button.add_to_cart_button {
  background: var(--teal); color: var(--navy);
  border: none; border-radius: 100px;
  font-family: var(--font-ui); font-weight: 700; letter-spacing: .03em;
  transition: var(--transition); text-shadow: none; box-shadow: none;
}
.woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,
.woocommerce #respond input#submit:hover, .woocommerce .button.alt:hover,
.woocommerce div.product form.cart button.single_add_to_cart_button:hover,
.woocommerce a.button.add_to_cart_button:hover {
  background: var(--teal-dark); color: var(--navy);
  transform: translateY(-1px); box-shadow: 0 6px 20px rgba(14,175,159,.35);
}
.woocommerce a.button.alt.disabled, .woocommerce button.button.alt.disabled { background: var(--teal); opacity: .55; }
/* Secondary / outline buttons (e.g. "View cart", "Continue shopping") */
.woocommerce .button.wc-backward, .woocommerce .added_to_cart {
  background: transparent; color: var(--navy); border: 1.5px solid var(--pearl-dark);
}
.woocommerce .button.wc-backward:hover, .woocommerce .added_to_cart:hover {
  border-color: var(--navy); color: var(--navy); background: transparent;
}

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
@media (max-width: 900px) {
  .woocommerce div.product { grid-template-columns: 1fr; gap: 28px; }
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
.alluvia-shop-wrap { max-width: 1340px; margin: 0 auto; padding: 48px 40px 100px; display: grid; grid-template-columns: 260px 1fr; gap: 40px; }
.alluvia-shop-sidebar { display: flex; flex-direction: column; gap: 20px; position: sticky; top: 80px; align-self: start; }
.sidebar-card { background: var(--white); border-radius: var(--radius-md); padding: 20px; border: 1px solid var(--pearl-dark); }
.sidebar-card-title { font-family: var(--font-ui); font-size: 11px; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--navy); margin-bottom: 14px; }
.sidebar-cat-link { display: flex; align-items: center; justify-content: space-between; padding: 9px 10px; border-radius: var(--radius-sm); font-size: 14px; font-family: var(--font-ui); font-weight: 500; color: var(--text-dark); text-decoration: none; transition: background .2s; }
.sidebar-cat-link:hover { background: var(--pearl); }
.sidebar-cat-link.current { background: rgba(14,175,159,.08); color: var(--teal); font-weight: 600; }
.sidebar-cat-count { font-size: 11px; background: var(--pearl-dark); border-radius: 100px; padding: 2px 7px; color: var(--text-light); }
.sidebar-cat-link.current .sidebar-cat-count { background: rgba(14,175,159,.15); color: var(--teal); }
.sidebar-reset-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;border-radius:var(--radius-sm);border:1.5px solid var(--pearl-dark);font-family:var(--font-ui);font-size:13px;font-weight:600;color:var(--text-mid);text-decoration:none;background:var(--white);transition:.2s}
.sidebar-reset-btn:hover{border-color:var(--navy);color:var(--navy)}
.sidebar-search{display:flex;align-items:center;gap:9px;border:1.5px solid var(--pearl-dark);border-radius:var(--radius-sm);padding:9px 12px;background:var(--pearl)}
.sidebar-search:focus-within{border-color:var(--teal)}
.sidebar-search svg{color:var(--text-light);flex-shrink:0}
.sidebar-search input{border:none;background:none;outline:none;width:100%;font-family:var(--font-body);font-size:14px;color:var(--text-dark)}
.sidebar-search input::placeholder{color:var(--text-light)}
.sidebar-price-row{display:flex;gap:8px;margin-bottom:10px}
.sidebar-price-input{width:100%;min-width:0;border:1.5px solid var(--pearl-dark);border-radius:var(--radius-sm);padding:8px 12px;font-size:13px;color:var(--text-dark);background:var(--pearl);outline:none;transition:border-color .2s}
.sidebar-price-input:focus{border-color:var(--teal)}
.sidebar-apply-btn{display:flex;align-items:center;justify-content:center;gap:7px;width:100%;padding:10px;border-radius:var(--radius-sm);border:none;background:var(--teal);color:var(--navy);font-family:var(--font-ui);font-size:12px;font-weight:700;cursor:pointer;transition:.2s}
.sidebar-apply-btn:hover{background:var(--teal-dark)}
/* Shop product grid: 4 columns on desktop (scoped to the shop archive so
   related/upsell grids elsewhere keep their own auto-fill layout). */
.alluvia-shop-wrap ul.products{grid-template-columns:repeat(4,1fr)}
@media(max-width:1200px){.alluvia-shop-wrap ul.products{grid-template-columns:repeat(3,1fr)}}
@media(max-width:900px){.alluvia-shop-wrap ul.products{grid-template-columns:repeat(2,1fr)}}
@media(max-width:1000px){.alluvia-shop-wrap{grid-template-columns:200px 1fr;padding:32px 24px 80px}}
@media(max-width:768px){.alluvia-shop-wrap{grid-template-columns:1fr;padding:28px 20px 60px}.alluvia-shop-sidebar{display:none}.alluvia-shop-wrap ul.products{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.alluvia-shop-wrap ul.products{grid-template-columns:repeat(2,1fr);gap:14px}}
</style>';
}, 20 );

get_header( 'alluvia' );
?>

<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="alluvia-woo-wrap" style="padding-top:88px;min-height:60vh;background:transparent">
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
        <form role="search" method="get" action="<?php echo esc_url( home_url('/') ); ?>">
          <input type="hidden" name="post_type" value="product">
          <label class="sidebar-search">
            <i data-lucide="search" style="width:15px;height:15px"></i>
            <span class="screen-reader-text">Search peptides</span>
            <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Search peptides&hellip;">
          </label>
        </form>
      </div>
      <div class="sidebar-card">
        <div class="sidebar-card-title" id="shop-cat-heading">Categories</div>
        <nav aria-labelledby="shop-cat-heading">
          <a href="<?php echo esc_url($shop_base); ?>" class="sidebar-cat-link<?php echo (!$current_cat_obj) ? ' current' : ''; ?>"<?php echo (!$current_cat_obj) ? ' aria-current="page"' : ''; ?>>
            All Peptides <span class="sidebar-cat-count"><?php echo (int) wp_count_posts('product')->publish; ?></span>
          </a>
          <?php if (!is_wp_error($nav_cats) && $nav_cats) : foreach ($nav_cats as $nc) :
            $term_url = get_term_link($nc);
            if (is_wp_error($term_url)) { continue; }
            $is_current = $current_cat_obj && (int) $current_cat_obj->term_id === (int) $nc->term_id;
          ?>
          <a href="<?php echo esc_url($term_url); ?>" class="sidebar-cat-link<?php echo $is_current ? ' current' : ''; ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>>
            <?php echo esc_html($nc->name); ?> <span class="sidebar-cat-count"><?php echo esc_html($nc->count); ?></span>
          </a>
          <?php endforeach; endif; ?>
        </nav>
      </div>
      <div class="sidebar-card">
        <div class="sidebar-card-title">Price Range</div>
        <form method="get" action="<?php echo esc_url( $current_cat_obj && ! is_wp_error( get_term_link( $current_cat_obj ) ) ? get_term_link( $current_cat_obj ) : $shop_base ); ?>">
          <?php if ( ! empty( $_GET['orderby'] ) ) : ?>
            <input type="hidden" name="orderby" value="<?php echo esc_attr( sanitize_text_field( wp_unslash( $_GET['orderby'] ) ) ); ?>">
          <?php endif; ?>
          <div class="sidebar-price-row">
            <input class="sidebar-price-input" type="number" min="0" step="any" name="min_price" value="<?php echo isset( $_GET['min_price'] ) ? esc_attr( (float) $_GET['min_price'] ) : ''; ?>" placeholder="Min $" aria-label="Minimum price">
            <input class="sidebar-price-input" type="number" min="0" step="any" name="max_price" value="<?php echo isset( $_GET['max_price'] ) ? esc_attr( (float) $_GET['max_price'] ) : ''; ?>" placeholder="Max $" aria-label="Maximum price">
          </div>
          <button type="submit" class="sidebar-apply-btn"><i data-lucide="sliders-horizontal" style="width:13px;height:13px"></i> Apply</button>
        </form>
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
