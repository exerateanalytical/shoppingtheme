<?php
/**
 * Activation: auto-create theme pages, WooCommerce pages, my-account routing
 *
 * @package Shopping
 * Extracted from functions.php for maintainability.
 */
if ( ! defined( "ABSPATH" ) ) { exit; }

/* ═══════════════════════════════════════
   AUTO-CREATE PAGES ON THEME ACTIVATION
   Creates all required pages, assigns templates,
   sets homepage and blog page in Reading Settings.
═══════════════════════════════════════ */
add_action( 'after_switch_theme', 'alluvia_create_pages_on_activation' );
function alluvia_create_pages_on_activation() {
    // Only run once
    if ( get_option( 'alluvia_pages_created' ) === '1' ) {
        return;
    }

    $pages = array(
        array(
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => '', // front-page.php handles this automatically
            'is_front' => true,
        ),
        array(
            'title'    => 'Blog',
            'slug'     => 'blog',
            'template' => '',
            'is_blog'  => true,
        ),
        array(
            'title'    => 'About',
            'slug'     => 'about',
            'template' => 'page-about.php',
        ),
        array(
            'title'    => 'Contact',
            'slug'     => 'contact',
            'template' => 'page-contact.php',
        ),
        array(
            'title'    => 'FAQ',
            'slug'     => 'faq',
            'template' => 'page-faq.php',
        ),
        array(
            'title'    => 'COA Library',
            'slug'     => 'coa-library',
            'template' => 'page-coa.php',
        ),
        array(
            'title'    => 'Shipping Policy',
            'slug'     => 'shipping-policy',
            'template' => 'page-shipping-policy.php',
        ),
        array(
            'title'    => 'Terms & Conditions',
            'slug'     => 'terms-conditions',
            'template' => 'page-terms.php',
        ),
        array(
            'title'    => 'Privacy Policy',
            'slug'     => 'privacy-policy',
            'template' => 'page-privacy.php',
        ),
        array(
            'title'    => 'Disclaimer',
            'slug'     => 'disclaimer',
            'template' => 'page-disclaimer.php',
        ),
    );

    $front_page_id = 0;
    $blog_page_id  = 0;

    foreach ( $pages as $page_data ) {
        // Check if page with this slug already exists
        $existing = get_page_by_path( $page_data['slug'] );
        if ( $existing ) {
            $page_id = $existing->ID;
        } else {
            $page_id = wp_insert_post( array(
                'post_title'   => $page_data['title'],
                'post_name'    => $page_data['slug'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
                'post_author'  => 1,
            ) );
        }

        if ( is_wp_error( $page_id ) || ! $page_id ) {
            continue;
        }

        // Assign page template
        if ( ! empty( $page_data['template'] ) ) {
            update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
        }

        if ( ! empty( $page_data['is_front'] ) ) {
            $front_page_id = $page_id;
        }
        if ( ! empty( $page_data['is_blog'] ) ) {
            $blog_page_id = $page_id;
        }
    }

    // Set Reading Settings: static front page + posts page
    if ( $front_page_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id );
    }
    if ( $blog_page_id ) {
        update_option( 'page_for_posts', $blog_page_id );
    }

    // Flush rewrite rules so slugs resolve correctly
    flush_rewrite_rules();

    // Mark as done
    update_option( 'alluvia_pages_created', '1' );
}

/* ── Allow re-running the page creation (useful for dev/testing) ── */
add_action( 'admin_init', function() {
    if ( isset( $_GET['alluvia_reset_pages'] ) && current_user_can( 'manage_options' ) ) {
        delete_option( 'alluvia_pages_created' );
        alluvia_create_pages_on_activation();
        wp_redirect( admin_url() );
        exit;
    }
} );

/* ═══════════════════════════════════════
   WOOCOMMERCE PAGES: ensure shop/cart/checkout/my-account exist
   Runs once until all four WC options are correctly set.
═══════════════════════════════════════ */
add_action( 'init', function() {
    if ( ! function_exists( 'WC' ) ) return;

    $wc_pages = [
        'shop'       => [ 'title' => 'Shop',       'option' => 'woocommerce_shop_page_id',       'content' => '' ],
        'cart'       => [ 'title' => 'Cart',       'option' => 'woocommerce_cart_page_id',       'content' => '[woocommerce_cart]' ],
        'checkout'   => [ 'title' => 'Checkout',   'option' => 'woocommerce_checkout_page_id',   'content' => '[woocommerce_checkout]' ],
        'my-account' => [ 'title' => 'My Account', 'option' => 'woocommerce_myaccount_page_id',  'content' => '[woocommerce_my_account]' ],
    ];

    $all_ok = true;
    foreach ( $wc_pages as $slug => $data ) {
        $page_id = (int) get_option( $data['option'] );
        if ( ! $page_id || 'publish' !== get_post_status( $page_id ) ) {
            $all_ok = false;
            break;
        }
    }
    if ( $all_ok ) return; // nothing to do

    $needs_flush = false;
    foreach ( $wc_pages as $slug => $data ) {
        $page_id = (int) get_option( $data['option'] );
        if ( $page_id && 'publish' === get_post_status( $page_id ) ) continue;

        // Find existing page by slug
        $existing = get_page_by_path( $slug );
        if ( $existing && 'publish' === $existing->post_status ) {
            $page_id = $existing->ID;
        } else {
            $page_id = wp_insert_post( [
                'post_title'   => $data['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => $data['content'],
                'post_author'  => 1,
            ] );
        }
        if ( $page_id && ! is_wp_error( $page_id ) ) {
            update_option( $data['option'], $page_id );
            $needs_flush = true;
        }
    }
    if ( $needs_flush ) {
        flush_rewrite_rules();
    }
}, 20 );

/* ═══════════════════════════════════════
   MY ACCOUNT: ensure /my-account/ always routes to WooCommerce.
   Fixes conflict when a blog post has slug 'my-account'.
═══════════════════════════════════════ */
add_action( 'template_redirect', function() {
    if ( ! function_exists( 'WC' ) ) return;
    if ( is_account_page() ) return; // WC already owns it

    $request = isset( $_SERVER['REQUEST_URI'] ) ? parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
    if ( $request && preg_match( '#^/my-account(/|$)#', $request ) ) {
        $account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' );
        if ( $account_url && trailingslashit( $account_url ) !== trailingslashit( home_url( $request ) ) ) {
            wp_redirect( $account_url, 301 );
            exit;
        }
    }
} );

add_action( 'after_switch_theme', 'flush_rewrite_rules' );
