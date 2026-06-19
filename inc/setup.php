<?php
/**
 * Theme setup, URL helpers, widgets/init, admin bar
 *
 * @package Shopping
 * Extracted from functions.php for maintainability.
 */
if ( ! defined( "ABSPATH" ) ) { exit; }

/* ═══════════════════════════════════════
   THEME SETUP
═══════════════════════════════════════ */
function shopping_theme_setup() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'shopping' ),
        'footer'  => __( 'Footer Menu', 'shopping' ),
    ) );

    add_action( 'init', 'shopping_init', 1 );
    add_action( 'widgets_init', 'shopping_widgets_init', 15 );
}
add_action( 'after_setup_theme', 'shopping_theme_setup', 11 );

/* ═══════════════════════════════════════
   HELPER: URL FUNCTIONS
   Used by all Alluvia templates.
═══════════════════════════════════════ */
if ( ! function_exists( 'alluvia_shop_url' ) ) {
    function alluvia_shop_url() {
        if ( function_exists( 'wc_get_page_permalink' ) ) {
            return wc_get_page_permalink( 'shop' );
        }
        return home_url( '/shop/' );
    }
}
if ( ! function_exists( 'alluvia_cart_url' ) ) {
    function alluvia_cart_url() {
        if ( function_exists( 'wc_get_cart_url' ) ) {
            return wc_get_cart_url();
        }
        return home_url( '/cart/' );
    }
}
if ( ! function_exists( 'alluvia_checkout_url' ) ) {
    function alluvia_checkout_url() {
        if ( function_exists( 'wc_get_checkout_url' ) ) {
            return wc_get_checkout_url();
        }
        return home_url( '/checkout/' );
    }
}
if ( ! function_exists( 'alluvia_account_url' ) ) {
    function alluvia_account_url() {
        $page_id = get_option( 'woocommerce_myaccount_page_id' );
        if ( $page_id ) {
            return get_permalink( $page_id );
        }
        return home_url( '/my-account/' );
    }
}
if ( ! function_exists( 'alluvia_cat_url' ) ) {
    /**
     * Safe product-category archive URL by slug. Falls back to the shop page
     * if WooCommerce or the term isn't available yet.
     */
    function alluvia_cat_url( $slug ) {
        if ( taxonomy_exists( 'product_cat' ) ) {
            $link = get_term_link( $slug, 'product_cat' );
            if ( ! is_wp_error( $link ) ) {
                return $link;
            }
        }
        return alluvia_shop_url();
    }
}
/**
 * Brand logo mark + wordmark used in nav and footer.
 * Returns the inner markup for an <a class="nav-logo"> link.
 */
if ( ! function_exists( 'alluvia_logo_svg' ) ) {
    function alluvia_logo_svg() {
        return '<svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">'
            . '<polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/>'
            . '<circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/>'
            . '<circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/>'
            . '<circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/>'
            . '<line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/>'
            . '<line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/>'
            . '<line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/>'
            . '</svg>'
            . '<div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div>';
    }
}

/* ═══════════════════════════════════════
   WIDGETS & INIT
═══════════════════════════════════════ */
function shopping_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Header Right', 'shopping' ),
        'id'            => 'header-right',
        'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
        'after_widget'  => '</div></section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'shopping' ),
        'id'            => 'blog-sidebar',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}

function shopping_init() {
    if ( ! is_admin() ) {
        wp_enqueue_script( 'tinynav', get_stylesheet_directory_uri() . '/js/tinynav.js', array( 'jquery' ) );
        $base_css_path = get_stylesheet_directory() . '/assets/css/alluvia-base.css';
        wp_enqueue_style(
            'alluvia-base',
            get_stylesheet_directory_uri() . '/assets/css/alluvia-base.css',
            array(),
            file_exists( $base_css_path ) ? filemtime( $base_css_path ) : '1.0.0' // cache-bust on every edit
        );
        // Dark platform overrides — sitewide, so injected after alluvia-base on every page.
        $dark_css_path = get_stylesheet_directory() . '/assets/css/alluvia-dark-platform.css';
        if ( file_exists( $dark_css_path ) ) {
            wp_add_inline_style( 'alluvia-base', file_get_contents( $dark_css_path ) );
        }
    }
}

/* ═══════════════════════════════════════
   FRONT-END: hide the admin bar
   The Alluvia nav is position:fixed at the top, so the WP admin bar would
   overlap it. Hidden on the front end only (the dashboard is unaffected).
═══════════════════════════════════════ */
add_filter( 'show_admin_bar', '__return_false' );

