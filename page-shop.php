<?php
/**
 * Template Name: Alluvia – Shop (legacy redirect)
 *
 * The live shop is the WooCommerce product archive rendered by woocommerce.php
 * (with the category + search + price-range sidebar). This standalone Template
 * had diverged into a second, parallel shop implementation. It now redirects to
 * the real shop so there is a single source of truth and no stale duplicate.
 *
 * @package Shopping
 */

$shop_url = function_exists( 'alluvia_shop_url' )
    ? alluvia_shop_url()
    : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ) );

if ( ! $shop_url ) {
    $shop_url = home_url( '/' );
}

wp_safe_redirect( $shop_url, 302 );
exit;
