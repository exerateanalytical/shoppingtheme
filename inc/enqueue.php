<?php
/**
 * Front-end script & style enqueue (fonts, Lucide, commerce)
 *
 * @package Shopping
 * Extracted from functions.php for maintainability.
 */
if ( ! defined( "ABSPATH" ) ) { exit; }

/* ═══════════════════════════════════════
   ENQUEUE SCRIPTS & STYLES
   Global Lucide CDN + per-template assets
═══════════════════════════════════════ */
add_action( 'wp_enqueue_scripts', 'alluvia_global_assets' );
function alluvia_global_assets() {
    $base = get_stylesheet_directory_uri();
    $dir  = get_stylesheet_directory();

    // Google Fonts — enqueued (not @import / not a hardcoded <link>) so it is
    // managed, non-render-blocking, and pinned to a single request.
    wp_enqueue_style(
        'alluvia-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
        array(),
        null
    );

    // Lucide icons — self-hosted and version-pinned (no external CDN at runtime).
    $lucide_path = $dir . '/assets/js/vendor/lucide.min.js';
    wp_enqueue_script( 'lucide', $base . '/assets/js/vendor/lucide.min.js', array(), file_exists( $lucide_path ) ? filemtime( $lucide_path ) : '0.460.0', true );
    wp_add_inline_script( 'lucide', 'document.addEventListener("DOMContentLoaded",function(){if(window.lucide)lucide.createIcons();});' );
    wp_localize_script( 'jquery', 'alluviaAjax', array(
        'ajax_url'      => admin_url( 'admin-ajax.php' ),
        'contact_nonce' => wp_create_nonce( 'alluvia_contact_nonce' ),
        'sub_nonce'     => wp_create_nonce( 'alluvia_sub_nonce' ),
        'cart_nonce'    => wp_create_nonce( 'alluvia_cart_nonce' ),
        'cart_url'      => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ),
    ) );

    // Brand commerce styling + quantity-stepper enhancement on WooCommerce pages.
    $is_woo = ( function_exists( 'is_woocommerce' ) && is_woocommerce() )
        || ( function_exists( 'is_cart' ) && is_cart() )
        || ( function_exists( 'is_checkout' ) && is_checkout() )
        || ( function_exists( 'is_account_page' ) && is_account_page() );
    if ( $is_woo ) {
        $css_path = $dir . '/assets/css/alluvia-commerce.css';
        $js_path  = $dir . '/assets/js/alluvia-commerce.js';
        // filemtime() versions cache-bust automatically on every file edit.
        wp_enqueue_style( 'alluvia-commerce', $base . '/assets/css/alluvia-commerce.css', array(), file_exists( $css_path ) ? filemtime( $css_path ) : '1.0.0' );
        wp_enqueue_script( 'alluvia-commerce', $base . '/assets/js/alluvia-commerce.js', array(), file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.0', true );
    }
}

