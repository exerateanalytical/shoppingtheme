<?php
/**
 * Template Name: Alluvia – My Account (legacy redirect)
 *
 * Superseded by page-my-account.php, which serves the real WooCommerce
 * account at /my-account/. This legacy template previously held hardcoded
 * demo data (fake user, fake orders). It now redirects to the live account
 * so any page still assigned this template never shows placeholder content.
 *
 * @package Shopping
 */

$account_url = function_exists( 'wc_get_page_permalink' )
    ? wc_get_page_permalink( 'myaccount' )
    : home_url( '/my-account/' );

if ( ! $account_url ) {
    $account_url = home_url( '/' );
}

wp_safe_redirect( $account_url, 302 );
exit;
