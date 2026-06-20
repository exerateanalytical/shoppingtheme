<?php
/**
 * Template Name: Alluvia – Checkout
 *
 * Renders the REAL WooCommerce checkout (the page's wp:woocommerce/checkout block)
 * inside the Alluvia chrome. The previous hand-rolled checkout had NO <form>, no
 * field name attributes, a fake "Visa ending ••••3456" line and a Place-Order
 * button that only showed a JS overlay — it created no order and took no payment.
 * This renders the live, nonce-protected, gateway-backed checkout.
 *
 * @package Shopping
 */
add_action( 'wp_head', function () { ?>
<style>
.alluvia-commerce-page{padding:104px 20px 72px;min-height:62vh}
.alluvia-commerce-inner{max-width:1180px;margin:0 auto;background:#fff;border-radius:18px;padding:2.4rem 2.4rem 2.8rem;box-shadow:0 24px 60px rgba(0,0,0,.4)}
.commerce-page-title{font-family:var(--font-display);font-size:clamp(26px,3.4vw,38px);font-weight:600;color:var(--navy);margin:0 0 1.5rem}
.alluvia-commerce-inner .wc-block-components-notice-banner,
.alluvia-commerce-inner .woocommerce-message,
.alluvia-commerce-inner .woocommerce-info,
.alluvia-commerce-inner .woocommerce-error{border-radius:10px}
.alluvia-commerce-inner .wc-block-components-checkout-place-order-button,
.alluvia-commerce-inner #place_order,
.alluvia-commerce-inner .wc-block-components-button:not(.wc-block-components-button--text){background:var(--teal);color:var(--navy)}
@media(max-width:640px){.alluvia-commerce-inner{padding:1.5rem 1.1rem 1.8rem;border-radius:14px}.alluvia-commerce-page{padding:90px 12px 56px}}
</style>
<?php }, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>
<div class="alluvia-commerce-page">
  <div class="alluvia-commerce-inner">
    <?php
    while ( have_posts() ) :
        the_post();
        echo '<h1 class="commerce-page-title">' . esc_html__( 'Checkout', 'shopping' ) . '</h1>';
        the_content(); // renders the real wp:woocommerce/checkout block
    endwhile;
    ?>
  </div>
</div>
<?php get_template_part( 'partials/footer-alluvia' ); ?>
<script>if(window.lucide){lucide.createIcons();}</script>
<?php get_footer( 'alluvia' ); ?>
