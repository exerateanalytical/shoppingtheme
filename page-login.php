<?php
/**
 * Template Name: Alluvia – Login (legacy redirect)
 *
 * This legacy template held a non-functional demo login/register form whose
 * JavaScript redirected to a static alluvia-account.html file. Authentication
 * is now handled by WooCommerce on the My Account page. Redirect there so the
 * real login/register form is always used.
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
