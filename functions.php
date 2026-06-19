<?php
/**
 * Alluvia Peptides — Theme Functions (standalone)
 *
 * @package Shopping
 */

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
    }
}

/* ═══════════════════════════════════════
   FRONT-END: hide the admin bar
   The Alluvia nav is position:fixed at the top, so the WP admin bar would
   overlap it. Hidden on the front end only (the dashboard is unaffected).
═══════════════════════════════════════ */
add_filter( 'show_admin_bar', '__return_false' );

/* ═══════════════════════════════════════
   CONTACT FORM HANDLER
═══════════════════════════════════════ */
add_action( 'wp_ajax_alluvia_contact', 'alluvia_handle_contact' );
add_action( 'wp_ajax_nopriv_alluvia_contact', 'alluvia_handle_contact' );
function alluvia_handle_contact() {
    check_ajax_referer( 'alluvia_contact_nonce', 'nonce' );

    $name    = sanitize_text_field( $_POST['name'] ?? '' );
    $email   = sanitize_email( $_POST['email'] ?? '' );
    $subject = sanitize_text_field( $_POST['subject'] ?? 'Contact Form Submission' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( ! $name || ! is_email( $email ) || ! $message ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }

    $to      = get_option( 'admin_email' );
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        "Reply-To: {$name} <{$email}>",
    );

    $body = '<p><strong>From:</strong> ' . esc_html( $name ) . ' (' . esc_html( $email ) . ')</p>'
          . '<p><strong>Subject:</strong> ' . esc_html( $subject ) . '</p>'
          . '<p><strong>Message:</strong><br>' . nl2br( esc_html( $message ) ) . '</p>';

    $sent = wp_mail( $to, "Alluvia Contact: {$subject}", $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Message sent. We\'ll be in touch within 24 hours.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to send. Please email us directly.' ) );
    }
}

/* ═══════════════════════════════════════
   NEWSLETTER / EMAIL SUBSCRIBE
═══════════════════════════════════════ */
add_action( 'wp_ajax_alluvia_subscribe', 'alluvia_handle_subscribe' );
add_action( 'wp_ajax_nopriv_alluvia_subscribe', 'alluvia_handle_subscribe' );
function alluvia_handle_subscribe() {
    check_ajax_referer( 'alluvia_sub_nonce', 'nonce' );
    $email = sanitize_email( $_POST['email'] ?? '' );
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Invalid email address.' ) );
    }
    // Log to options (replace with Mailchimp/ActiveCampaign API call in production)
    $subs   = get_option( 'alluvia_subscribers', array() );
    $subs[] = array( 'email' => $email, 'date' => current_time( 'mysql' ) );
    update_option( 'alluvia_subscribers', array_unique( array_column( $subs, 'email' ) ) );
    wp_send_json_success( array( 'message' => 'Welcome! You\'re on the list.' ) );
}

/* ═══════════════════════════════════════
   FAVICON — fallback when no Site Icon set in Customizer
═══════════════════════════════════════ */
add_action( 'wp_head', 'alluvia_favicon', 0 );
function alluvia_favicon() {
    if ( has_site_icon() ) {
        return; // Customizer Site Icon takes priority
    }
    $svg = get_theme_file_uri( 'assets/images/favicon.svg' );
    echo '<link rel="icon" href="' . esc_url( $svg ) . '" type="image/svg+xml">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url( $svg ) . '">' . "\n";
}

/* ═══════════════════════════════════════
   SEO META TAGS — skipped when RankMath / Yoast active
═══════════════════════════════════════ */
function alluvia_seo_plugin_active() {
    return defined( 'RANK_MATH_VERSION' ) || defined( 'WPSEO_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

add_action( 'wp_head', 'alluvia_seo_meta', 1 );
function alluvia_seo_meta() {
    if ( alluvia_seo_plugin_active() ) {
        return; // Let the SEO plugin handle all meta / OG / canonical
    }
    if ( is_front_page() ) {
        echo '<meta name="description" content="Alluvia Peptides — Pharmaceutical-grade bioactive peptides for skincare, sports recovery, anti-aging, weight-loss, hair growth, and research. COA on every batch.">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:title" content="Alluvia Peptides — Premium Bioactive Peptides">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
        echo '<meta property="og:site_name" content="Alluvia Peptides">' . "\n";
        echo '<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
        echo '<script type="application/ld+json">{"@context":"https://schema.org","@type":"Organization","name":"Alluvia Peptides","url":"' . esc_url( home_url( '/' ) ) . '","description":"Pharmaceutical-grade bioactive peptides for skincare, sports recovery, anti-aging, and longevity."}</script>' . "\n";
    } elseif ( function_exists( 'is_product' ) && is_product() ) {
        alluvia_product_schema();
    }
}

/* ═══════════════════════════════════════
   PRODUCT SEO: Product + FAQPage JSON-LD
   Emits structured data on single product pages so search engines and
   AI answer engines (GEO) can surface price, availability and the FAQ.
   Yoast (if installed) handles the meta tags via the imported Meta: columns;
   we only add the rich structured data here.
═══════════════════════════════════════ */
function alluvia_product_schema() {
    global $product;
    if ( ! $product instanceof WC_Product ) {
        $product = wc_get_product( get_the_ID() );
    }
    if ( ! $product ) {
        return;
    }

    $name        = wp_strip_all_tags( $product->get_name() );
    $description  = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
    $description  = trim( preg_replace( '/\s+/', ' ', $description ) );
    $sku         = $product->get_sku();
    $price       = $product->get_price();
    $url         = get_permalink( $product->get_id() );
    $availability = $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';

    // --- Product schema ---
    $schema = array(
        '@context'    => 'https://schema.org/',
        '@type'       => 'Product',
        'name'        => $name,
        'description' => $description,
        'sku'         => $sku,
        'brand'       => array( '@type' => 'Brand', 'name' => 'Alluvia Peptides' ),
        'offers'      => array(
            '@type'         => 'Offer',
            'url'           => $url,
            'priceCurrency' => get_woocommerce_currency(),
            'price'         => $price,
            'availability'  => $availability,
            'seller'        => array( '@type' => 'Organization', 'name' => 'Alluvia Peptides' ),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";

    // --- FAQPage schema (parsed from the <h4>Q</h4><p>A</p> blocks in the body) ---
    if ( preg_match_all( '/<h4[^>]*>(.*?)<\/h4>\s*<p[^>]*>(.*?)<\/p>/is', $product->get_description(), $m, PREG_SET_ORDER ) ) {
        $faqs = array();
        foreach ( $m as $pair ) {
            $faqs[] = array(
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags( $pair[1] ),
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => wp_strip_all_tags( $pair[2] ),
                ),
            );
        }
        if ( $faqs ) {
            $faq_schema = array(
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => $faqs,
            );
            echo '<script type="application/ld+json">' . wp_json_encode( $faq_schema ) . '</script>' . "\n";
        }
    }

    // --- Fallback meta description when Yoast is not active ---
    if ( ! defined( 'WPSEO_VERSION' ) && $description ) {
        echo '<meta name="description" content="' . esc_attr( wp_html_excerpt( $description, 155, '…' ) ) . '">' . "\n";
        echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
    }
}

/* ═══════════════════════════════════════
   ENQUEUE SCRIPTS & STYLES
   Global Lucide CDN + per-template assets
═══════════════════════════════════════ */
add_action( 'wp_enqueue_scripts', 'alluvia_global_assets' );
function alluvia_global_assets() {
    // Lucide icons CDN — loaded via header-alluvia.php inline, but also here as fallback
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
        $base = get_stylesheet_directory_uri();
        $dir  = get_stylesheet_directory();
        $css_path = $dir . '/assets/css/alluvia-commerce.css';
        $js_path  = $dir . '/assets/js/alluvia-commerce.js';
        // filemtime() versions cache-bust automatically on every file edit.
        wp_enqueue_style( 'alluvia-commerce', $base . '/assets/css/alluvia-commerce.css', array(), file_exists( $css_path ) ? filemtime( $css_path ) : '1.0.0' );
        $dark_css_path = $dir . '/assets/css/alluvia-dark-platform.css';
        if ( file_exists( $dark_css_path ) ) {
            wp_add_inline_style( 'alluvia-commerce', file_get_contents( $dark_css_path ) );
        }
        wp_enqueue_script( 'alluvia-commerce', $base . '/assets/js/alluvia-commerce.js', array(), file_exists( $js_path ) ? filemtime( $js_path ) : '1.0.0', true );
    }
}

/* ═══════════════════════════════════════
   WOOCOMMERCE: Loop card hooks
   Our woocommerce/content-product.php renders its own product link and add-to-cart
   button inside a branded card, so remove WooCommerce's default link-wrap and
   duplicate add-to-cart callbacks to avoid double output. Set a clean per-page count.
═══════════════════════════════════════ */
add_action( 'init', 'alluvia_woo_loop_hooks' );
function alluvia_woo_loop_hooks() {
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_filter( 'loop_shop_per_page', function () { return 24; }, 20 );

/* Hide the WooCommerce shop/archive page title ("Shop" heading). */
add_filter( 'woocommerce_show_page_title', '__return_false' );

/* ═══════════════════════════════════════
   PRODUCT REVIEW REACTIONS (lucide icons, not emojis)
   Reactions are stored per-review as comment meta and incremented via AJAX.
   Rendered both under each review on the product page and on the Reviews page.
═══════════════════════════════════════ */
function alluvia_review_reaction_types() {
    return array(
        'helpful'    => array( 'icon' => 'thumbs-up', 'label' => 'Helpful' ),
        'love'       => array( 'icon' => 'heart',     'label' => 'Love' ),
        'insightful' => array( 'icon' => 'lightbulb', 'label' => 'Insightful' ),
    );
}

function alluvia_render_review_reactions( $comment_id ) {
    $comment_id = (int) $comment_id;
    if ( ! $comment_id ) {
        return;
    }
    echo '<div class="review-reactions" data-comment="' . esc_attr( $comment_id ) . '">';
    foreach ( alluvia_review_reaction_types() as $key => $r ) {
        $count = (int) get_comment_meta( $comment_id, 'alluvia_reaction_' . $key, true );
        printf(
            '<button type="button" class="review-reaction" data-reaction="%1$s" aria-label="%2$s">'
            . '<i data-lucide="%3$s" style="width:15px;height:15px"></i>'
            . '<span class="reaction-label">%2$s</span>'
            . '<span class="reaction-count">%4$d</span>'
            . '</button>',
            esc_attr( $key ),
            esc_attr( $r['label'] ),
            esc_attr( $r['icon'] ),
            $count
        );
    }
    echo '</div>';
}

/* Inject reactions under each review on the single product page. */
add_action( 'woocommerce_review_after_comment_text', function ( $comment ) {
    alluvia_render_review_reactions( $comment->comment_ID );
}, 20 );

/* AJAX: increment a reaction. Guarded by nonce; one count per click. */
add_action( 'wp_ajax_alluvia_react', 'alluvia_ajax_react' );
add_action( 'wp_ajax_nopriv_alluvia_react', 'alluvia_ajax_react' );
function alluvia_ajax_react() {
    check_ajax_referer( 'alluvia_react', 'nonce' );
    $comment_id = isset( $_POST['comment'] ) ? (int) $_POST['comment'] : 0;
    $reaction   = isset( $_POST['reaction'] ) ? sanitize_key( $_POST['reaction'] ) : '';
    $types      = alluvia_review_reaction_types();
    if ( ! $comment_id || ! isset( $types[ $reaction ] ) || ! get_comment( $comment_id ) ) {
        wp_send_json_error( array( 'message' => 'invalid' ), 400 );
    }
    $meta_key = 'alluvia_reaction_' . $reaction;
    $count    = (int) get_comment_meta( $comment_id, $meta_key, true ) + 1;
    update_comment_meta( $comment_id, $meta_key, $count );
    wp_send_json_success( array( 'count' => $count ) );
}

/* Enqueue the small reactions script (+ ajax url/nonce) on product & reviews pages. */
add_action( 'wp_enqueue_scripts', function () {
    $is_reviews_page = is_page_template( 'page-reviews.php' );
    $is_product      = function_exists( 'is_product' ) && is_product();
    if ( ! $is_reviews_page && ! $is_product ) {
        return;
    }
    $dir = get_stylesheet_directory();
    $uri = get_stylesheet_directory_uri();
    $js  = $dir . '/assets/js/alluvia-reviews.js';
    wp_enqueue_script(
        'alluvia-reviews',
        $uri . '/assets/js/alluvia-reviews.js',
        array(),
        file_exists( $js ) ? filemtime( $js ) : '1.0.0',
        true
    );
    wp_localize_script( 'alluvia-reviews', 'AlluviaReact', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'alluvia_react' ),
    ) );
} );

/* Ensure a published "Reviews" page exists with the page-reviews.php template. */
add_action( 'init', function () {
    $id = (int) get_option( 'alluvia_reviews_page_id' );
    if ( $id && 'publish' === get_post_status( $id ) ) {
        return;
    }
    $existing = get_page_by_path( 'reviews' );
    if ( $existing && 'publish' === $existing->post_status ) {
        $id = $existing->ID;
    } else {
        $id = wp_insert_post( array(
            'post_title'   => 'Reviews',
            'post_name'    => 'reviews',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'post_author'  => 1,
        ) );
    }
    if ( $id && ! is_wp_error( $id ) ) {
        update_post_meta( $id, '_wp_page_template', 'page-reviews.php' );
        update_option( 'alluvia_reviews_page_id', (int) $id );
    }
}, 21 );

/* Helper: URL of the Reviews page. */
if ( ! function_exists( 'alluvia_reviews_url' ) ) {
    function alluvia_reviews_url() {
        $id = (int) get_option( 'alluvia_reviews_page_id' );
        if ( $id && 'publish' === get_post_status( $id ) ) {
            return get_permalink( $id );
        }
        return home_url( '/reviews/' );
    }
}

/* ═══════════════════════════════════════
   WOOCOMMERCE: Sidebar price-range filter
   Applies the ?min_price / ?max_price query params from the shop sidebar to the
   main product query via a numeric meta_query on _price. (WooCommerce only wires
   these params natively when its price-filter widget/block is present.)
═══════════════════════════════════════ */
add_action( 'woocommerce_product_query', function ( $q ) {
    if ( is_admin() ) {
        return;
    }
    $min = isset( $_GET['min_price'] ) && $_GET['min_price'] !== '' ? (float) $_GET['min_price'] : null;
    $max = isset( $_GET['max_price'] ) && $_GET['max_price'] !== '' ? (float) $_GET['max_price'] : null;
    if ( null === $min && null === $max ) {
        return;
    }
    $meta_query   = (array) $q->get( 'meta_query' );
    $price_clause = array( 'key' => '_price', 'type' => 'NUMERIC' );
    if ( null !== $min && null !== $max ) {
        $price_clause['compare'] = 'BETWEEN';
        $price_clause['value']   = array( min( $min, $max ), max( $min, $max ) );
    } elseif ( null !== $min ) {
        $price_clause['compare'] = '>=';
        $price_clause['value']   = $min;
    } else {
        $price_clause['compare'] = '<=';
        $price_clause['value']   = $max;
    }
    $meta_query[] = $price_clause;
    $q->set( 'meta_query', $meta_query );
} );

/* ═══════════════════════════════════════
   WOOCOMMERCE: Custom AJAX cart engine
   Backs the bespoke add-to-cart / qty-stepper / remove interactions on the
   Alluvia commerce templates. Uses WooCommerce's own cart object and fragment
   system so totals, taxes and sessions stay authoritative.
═══════════════════════════════════════ */
add_action( 'wp_ajax_alluvia_add_to_cart', 'alluvia_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_alluvia_add_to_cart', 'alluvia_ajax_add_to_cart' );
function alluvia_ajax_add_to_cart() {
    check_ajax_referer( 'alluvia_cart_nonce', 'nonce' );
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        wp_send_json_error( array( 'message' => 'Cart unavailable.' ) );
    }
    $product_id = absint( $_POST['product_id'] ?? 0 );
    $quantity   = max( 1, absint( $_POST['quantity'] ?? 1 ) );
    if ( ! $product_id || ! wc_get_product( $product_id ) ) {
        wp_send_json_error( array( 'message' => 'Invalid product.' ) );
    }
    $added = WC()->cart->add_to_cart( $product_id, $quantity );
    if ( ! $added ) {
        $notice = function_exists( 'wc_get_notices' ) ? wc_get_notices( 'error' ) : array();
        $msg    = ! empty( $notice ) ? wp_strip_all_tags( $notice[0]['notice'] ) : 'Could not add to cart.';
        if ( function_exists( 'wc_clear_notices' ) ) {
            wc_clear_notices();
        }
        wp_send_json_error( array( 'message' => $msg ) );
    }
    wp_send_json_success( array(
        'message' => 'Added to cart.',
        'count'   => WC()->cart->get_cart_contents_count(),
        'subtotal'=> WC()->cart->get_cart_subtotal(),
    ) );
}

add_action( 'wp_ajax_alluvia_update_cart', 'alluvia_ajax_update_cart' );
add_action( 'wp_ajax_nopriv_alluvia_update_cart', 'alluvia_ajax_update_cart' );
function alluvia_ajax_update_cart() {
    check_ajax_referer( 'alluvia_cart_nonce', 'nonce' );
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        wp_send_json_error( array( 'message' => 'Cart unavailable.' ) );
    }
    $key      = sanitize_text_field( $_POST['cart_item_key'] ?? '' );
    $quantity = absint( $_POST['quantity'] ?? 0 );
    if ( ! $key || ! isset( WC()->cart->get_cart()[ $key ] ) ) {
        wp_send_json_error( array( 'message' => 'Item not found.' ) );
    }
    WC()->cart->set_quantity( $key, $quantity, true ); // 0 removes the line
    WC()->cart->calculate_totals();
    wp_send_json_success( array(
        'count'    => WC()->cart->get_cart_contents_count(),
        'subtotal' => WC()->cart->get_cart_subtotal(),
        'total'    => WC()->cart->get_cart_total(),
        'removed'  => 0 === $quantity,
    ) );
}

/* ═══════════════════════════════════════
   WOOCOMMERCE: Auto-assign branded category images
   Sideloads the brand category images in /images/categories/ and sets them as
   the WooCommerce product-category thumbnails. Runs in admin until all eight
   categories have an image, then flags itself complete.
═══════════════════════════════════════ */
add_action( 'admin_init', 'alluvia_assign_category_images' );
function alluvia_assign_category_images() {
    if ( get_option( 'alluvia_cat_images_done' ) ) {
        return;
    }
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return; // WooCommerce not active yet
    }

    $slugs = array(
        'medical-peptides', 'skincare-peptides', 'collagen-peptides', 'sports-recovery',
        'weight-loss-metabolic', 'hormone-anti-aging', 'hair-growth-peptides', 'research-peptides',
        'lab-supplies-accessories',
    );
    $dir = trailingslashit( get_template_directory() ) . 'images/categories/';

    require_once ABSPATH . 'wp-admin/includes/image.php';

    $assigned = 0;
    foreach ( $slugs as $slug ) {
        $term = get_term_by( 'slug', $slug, 'product_cat' );
        if ( ! $term ) {
            continue; // category not imported yet
        }
        if ( get_term_meta( $term->term_id, 'thumbnail_id', true ) ) {
            $assigned++;
            continue; // already has an image
        }
        $file = $dir . $slug . '.png';
        if ( ! file_exists( $file ) ) {
            continue;
        }
        $upload = wp_upload_bits( $slug . '.png', null, file_get_contents( $file ) );
        if ( ! empty( $upload['error'] ) ) {
            continue;
        }
        $attach_id = wp_insert_attachment( array(
            'post_mime_type' => 'image/png',
            'post_title'     => $term->name . ' category image',
            'post_status'    => 'inherit',
        ), $upload['file'] );
        if ( is_wp_error( $attach_id ) || ! $attach_id ) {
            continue;
        }
        wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $upload['file'] ) );
        update_term_meta( $term->term_id, 'thumbnail_id', $attach_id );
        $assigned++;
    }

    if ( $assigned >= count( $slugs ) ) {
        update_option( 'alluvia_cat_images_done', 1 );
    }
}

/* ═══════════════════════════════════════
   WOOCOMMERCE: Auto-assign branded vial images to products
   Matches images/products/<SKU>.jpg to each product by SKU and sets it as the
   featured image. Processes in batches across admin loads to avoid timeouts,
   then flags itself complete.
═══════════════════════════════════════ */
add_action( 'admin_init', 'alluvia_assign_product_images' );
function alluvia_assign_product_images() {
    if ( get_option( 'alluvia_product_images_done' ) ) {
        return;
    }
    if ( ! function_exists( 'wc_get_product_id_by_sku' ) ) {
        return; // WooCommerce not active yet
    }

    $base  = trailingslashit( get_template_directory() );
    $dir   = $base . 'images/products/';
    $cdir  = $base . 'images/cartons/';
    $gdir  = $base . 'images/groups/';
    $files = glob( $dir . 'AV-*.jpg' );
    if ( empty( $files ) ) {
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';

    // Import a file as an attachment for $product_id, returning the new ID (0 on failure).
    $import = function ( $path, $filename, $product_id ) {
        $upload = wp_upload_bits( $filename, null, file_get_contents( $path ) );
        if ( ! empty( $upload['error'] ) ) {
            return 0;
        }
        $attach_id = wp_insert_attachment( array(
            'post_mime_type' => 'image/jpeg',
            'post_title'     => get_the_title( $product_id ),
            'post_status'    => 'inherit',
        ), $upload['file'], $product_id );
        if ( is_wp_error( $attach_id ) || ! $attach_id ) {
            return 0;
        }
        wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $upload['file'] ) );
        return $attach_id;
    };

    $batch = 40;       // per admin page load
    $done  = 0;
    $pending = 0;
    foreach ( $files as $file ) {
        $sku = basename( $file, '.jpg' );
        $product_id = wc_get_product_id_by_sku( $sku );
        if ( ! $product_id ) {
            continue; // product not imported yet
        }
        if ( get_post_thumbnail_id( $product_id ) ) {
            continue; // already has an image
        }
        $pending++;
        if ( $done >= $batch ) {
            continue; // leave the rest for the next load
        }

        // Featured image: the vial shot.
        $attach_id = $import( $file, $sku . '.jpg', $product_id );
        if ( ! $attach_id ) {
            continue;
        }
        set_post_thumbnail( $product_id, $attach_id );

        // Gallery: carton + vial-and-carton group shot, when present.
        $gallery = array();
        foreach ( array( $cdir => '-carton', $gdir => '-group' ) as $gpath => $suffix ) {
            $gfile = $gpath . $sku . '.jpg';
            if ( file_exists( $gfile ) ) {
                $gid = $import( $gfile, $sku . $suffix . '.jpg', $product_id );
                if ( $gid ) {
                    $gallery[] = $gid;
                }
            }
        }
        if ( ! empty( $gallery ) ) {
            update_post_meta( $product_id, '_product_image_gallery', implode( ',', $gallery ) );
        }
        $done++;
    }

    // Nothing left waiting for an image -> we are finished.
    if ( $pending <= $done ) {
        update_option( 'alluvia_product_images_done', 1 );
    }
}

/* ═══════════════════════════════════════
   COMPLIANCE: Research-Use-Only disclaimers
   A prominent notice on every single-product page, plus a site-wide footer
   disclaimer on all front-end pages. All products are supplied strictly as
   research-grade material — not for human or animal consumption.
═══════════════════════════════════════ */

// Prominent notice directly under the product title/price on product pages.
/* ═══════════════════════════════════════
   CERTIFICATE OF ANALYSIS (COA)
   Per-product COA documents live in images/coa/<SKU>.pdf (printable) and
   images/coa/<SKU>.jpg (web preview), generated by generate_coa.py.
═══════════════════════════════════════ */
if ( ! function_exists( 'alluvia_coa_paths' ) ) {
    function alluvia_coa_paths( $sku ) {
        $sku  = sanitize_file_name( (string) $sku );
        if ( '' === $sku ) {
            return array( 'pdf' => '', 'img' => '' );
        }
        $dir  = trailingslashit( get_template_directory() ) . 'images/coa/';
        $uri  = trailingslashit( get_template_directory_uri() ) . 'images/coa/';
        return array(
            'pdf' => file_exists( $dir . $sku . '.pdf' ) ? $uri . $sku . '.pdf' : '',
            'img' => file_exists( $dir . $sku . '.jpg' ) ? $uri . $sku . '.jpg' : '',
        );
    }
    function alluvia_coa_url( $sku ) {
        $p = alluvia_coa_paths( $sku );
        return $p['pdf'];
    }
}

// COA results manifest (purity etc. per SKU), generated by generate_coa.py.
if ( ! function_exists( 'alluvia_coa_index' ) ) {
    function alluvia_coa_index() {
        static $idx = null;
        if ( null === $idx ) {
            $file = trailingslashit( get_template_directory() ) . 'images/coa/index.json';
            $idx  = file_exists( $file ) ? json_decode( file_get_contents( $file ), true ) : array();
            if ( ! is_array( $idx ) ) {
                $idx = array();
            }
        }
        return $idx;
    }
    function alluvia_coa_purity( $sku ) {
        $idx = alluvia_coa_index();
        return isset( $idx[ $sku ]['purity'] ) ? (float) $idx[ $sku ]['purity'] : null;
    }
}

// Download button on the single product page, matched by SKU.
add_action( 'woocommerce_single_product_summary', 'alluvia_product_coa_button', 26 );
function alluvia_product_coa_button() {
    global $product;
    if ( ! $product instanceof WC_Product ) {
        return;
    }
    $pdf = alluvia_coa_url( $product->get_sku() );
    if ( ! $pdf ) {
        return;
    }
    echo '<a href="' . esc_url( $pdf ) . '" target="_blank" rel="noopener" class="alluvia-coa-btn" '
        . 'style="display:inline-flex;align-items:center;gap:9px;margin:6px 0 4px;background:var(--white,#fff);color:var(--navy,#0a1a27);'
        . 'border:1.5px solid var(--gold,#c6a253);border-radius:100px;padding:11px 22px;font-family:inherit;font-weight:700;'
        . 'font-size:14px;text-decoration:none;transition:.25s;">'
        . '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--gold,#c6a253)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>'
        . 'Download Certificate of Analysis (PDF)</a>';
}

// Certificate of Analysis product tab (preview image + download), by SKU.
add_filter( 'woocommerce_product_tabs', 'alluvia_coa_product_tab' );
function alluvia_coa_product_tab( $tabs ) {
    global $product;
    if ( $product instanceof WC_Product ) {
        $paths = alluvia_coa_paths( $product->get_sku() );
        if ( $paths['pdf'] ) {
            $tabs['alluvia_coa'] = array(
                'title'    => __( 'Certificate of Analysis', 'shopping' ),
                'priority' => 25,
                'callback' => 'alluvia_coa_product_tab_content',
            );
        }
    }
    return $tabs;
}
function alluvia_coa_product_tab_content() {
    global $product;
    $paths = alluvia_coa_paths( $product instanceof WC_Product ? $product->get_sku() : '' );
    echo '<h2>Certificate of Analysis</h2>';
    $purity = $product instanceof WC_Product ? alluvia_coa_purity( $product->get_sku() ) : null;
    if ( null !== $purity ) {
        echo '<p style="font-size:18px;"><strong>RP-HPLC purity: ' . esc_html( number_format( $purity, 1 ) ) . '%</strong></p>';
    }
    echo '<p>Every batch is released against Alluvia Peptides specifications with identity (ESI-MS), '
        . 'RP-HPLC purity, water and acetate content verified. This material is supplied '
        . '<strong>for laboratory research use only</strong>.</p>';
    if ( $paths['img'] ) {
        echo '<a href="' . esc_url( $paths['pdf'] ) . '" target="_blank" rel="noopener">'
            . '<img src="' . esc_url( $paths['img'] ) . '" alt="Certificate of Analysis preview" '
            . 'loading="lazy" style="max-width:520px;width:100%;height:auto;border:1px solid #e3e8ec;border-radius:12px;box-shadow:0 8px 32px rgba(10,26,39,.14);" /></a>';
    }
    echo '<p style="margin-top:18px;"><a class="button alt" href="' . esc_url( $paths['pdf'] ) . '" '
        . 'target="_blank" rel="noopener">Download COA (PDF)</a></p>';
}

add_action( 'woocommerce_single_product_summary', 'alluvia_product_ruo_notice', 25 );
function alluvia_product_ruo_notice() {
    echo '<div class="alluvia-ruo-notice" role="note" style="margin:18px 0;padding:14px 16px;border:1px solid rgba(198,162,83,0.4);border-left:4px solid var(--gold,#c6a253);background:rgba(198,162,83,0.08);border-radius:8px;font-size:15px;line-height:1.5;color:rgba(255,255,255,0.85);">'
        . '<strong style="display:block;letter-spacing:1px;text-transform:uppercase;color:#c6a253;margin-bottom:4px;">For Research Use Only</strong>'
        . 'This product is supplied strictly for laboratory and in-vitro research by qualified researchers. '
        . 'It is <strong>not for human or animal consumption</strong> and is not a drug, food, cosmetic or dietary supplement.'
        . '</div>';
}

// Site-wide footer disclaimer on every front-end page.
add_action( 'wp_footer', 'alluvia_footer_disclaimer', 5 );
function alluvia_footer_disclaimer() {
    if ( is_admin() ) {
        return;
    }
    echo '<div class="alluvia-footer-disclaimer" style="background:var(--navy,#0a1a27);color:#aeb9c4;font-size:15px;line-height:1.6;text-align:center;padding:18px 20px;border-top:2px solid var(--gold,#c6a253);">'
        . '<div style="max-width:960px;margin:0 auto;">'
        . '<strong style="color:#fff;">Research Use Only &mdash; Not for Human Consumption.</strong> '
        . 'All products supplied by Alluvia Peptides are sold strictly as research-grade chemicals for in-vitro and laboratory research purposes only. '
        . 'They are not intended to diagnose, treat, cure or prevent any disease, and are not for human or veterinary use. '
        . 'By purchasing you confirm you are a qualified researcher or institution and accept full responsibility for safe, lawful handling.'
        . '</div></div>';
}

/* ═══════════════════════════════════════
   WOOCOMMERCE: Cart fragments (AJAX cart count)
═══════════════════════════════════════ */
add_filter( 'woocommerce_add_to_cart_fragments', 'alluvia_cart_fragment' );
function alluvia_cart_fragment( $fragments ) {
    if ( function_exists( 'WC' ) && WC()->cart ) {
        $fragments['.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    }
    return $fragments;
}

/* ═══════════════════════════════════════
   WOOCOMMERCE: Disable default styles (we use ours)
═══════════════════════════════════════ */
add_filter( 'woocommerce_enqueue_styles', 'alluvia_woo_styles' );
function alluvia_woo_styles( $styles ) {
    // Keep WooCommerce's core styles but let our CSS override visual styles
    // Uncomment the lines below to fully disable specific WC stylesheets:
    // unset( $styles['woocommerce-general'] );
    // unset( $styles['woocommerce-layout'] );
    // unset( $styles['woocommerce-smallscreen'] );
    return $styles;
}

/* ═══════════════════════════════════════
   WOOCOMMERCE: Remove sidebar from pages
═══════════════════════════════════════ */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/* ═══════════════════════════════════════
   ADMIN NOTICE: recommend WooCommerce
   (Replaces the deprecated TGMPA dependency — no parent framework required.)
═══════════════════════════════════════ */
add_action( 'admin_notices', 'alluvia_recommend_woocommerce' );
function alluvia_recommend_woocommerce() {
    if ( class_exists( 'WooCommerce' ) || ! current_user_can( 'install_plugins' ) ) {
        return;
    }
    $url = wp_nonce_url(
        self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ),
        'install-plugin_woocommerce'
    );
    echo '<div class="notice notice-info is-dismissible"><p><strong>Alluvia Peptides</strong> needs <strong>WooCommerce</strong> for the shop, cart, checkout and account pages. '
        . '<a href="' . esc_url( $url ) . '">Install WooCommerce now</a>.</p></div>';
}

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
