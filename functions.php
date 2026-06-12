<?php
/**
 * Alluvia Peptides — Shopping Child Theme Functions
 *
 * @package Shopping
 */

/* ═══════════════════════════════════════
   THEME SETUP
═══════════════════════════════════════ */
function shopping_theme_setup() {
    add_theme_support( 'omega-footer-widgets', 3 );
    add_theme_support( 'plugin-activation' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

    // Remove Omega's default header/nav hooks (Alluvia has its own)
    remove_action( 'omega_before_header', 'omega_get_primary_menu' );
    remove_action( 'omega_after_header',  'omega_get_primary_menu' );

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
    }
}

/* ═══════════════════════════════════════
   HIDE OMEGA HEADER on Alluvia pages
═══════════════════════════════════════ */
function alluvia_maybe_hide_omega_header() {
    // When Alluvia's custom header is used, suppress Omega's visual output
    add_action( 'omega_header', '__return_false', 1 );
    add_action( 'omega_before_header', '__return_false', 1 );
}
// We hook this on any page using get_header('alluvia') by detecting the template
add_action( 'template_redirect', function() {
    $tpl = get_page_template_slug();
    $front = is_front_page();
    $woo   = is_woocommerce();
    $blog  = is_home() || is_single();

    if ( $front || $woo || $blog || $tpl ) {
        // These pages use header-alluvia.php — hide the Omega visual header
        add_filter( 'show_admin_bar', '__return_false' );
        // The actual Omega header suppression is handled because we call
        // get_header('alluvia') which loads header-alluvia.php instead of header.php
    }
} );

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

    $body = "<p><strong>From:</strong> {$name} ({$email})</p>
             <p><strong>Subject:</strong> {$subject}</p>
             <p><strong>Message:</strong><br>" . nl2br( $message ) . "</p>";

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
   SEO META TAGS (all Alluvia pages)
═══════════════════════════════════════ */
add_action( 'wp_head', 'alluvia_seo_meta', 1 );
function alluvia_seo_meta() {
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
   PLUGIN ACTIVATION (TGM)
═══════════════════════════════════════ */
add_action( 'tgmpa_register', 'shopping_register_plugins' );
function shopping_register_plugins() {
    $plugins = array(
        array(
            'name'     => 'WooCommerce',
            'slug'     => 'woocommerce',
            'required' => false,
        ),
        array(
            'name'     => 'Contact Form 7',
            'slug'     => 'contact-form-7',
            'required' => false,
        ),
    );

    $config = array(
        'default_path'     => '',
        'parent_menu_slug' => 'themes.php',
        'parent_url_slug'  => 'themes.php',
        'menu'             => 'install-required-plugins',
        'has_notices'      => true,
        'is_automatic'     => false,
        'message'          => '',
        'strings'          => array(
            'page_title'                      => __( 'Install Required Plugins', 'shopping' ),
            'menu_title'                      => __( 'Install Plugins', 'shopping' ),
            'installing'                      => __( 'Installing Plugin: %s', 'shopping' ),
            'oops'                            => __( 'Something went wrong with the plugin API.', 'shopping' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin.', 'Sorry, but you do not have the correct permissions to install the %s plugins.' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin.', 'Sorry, but you do not have the correct permissions to activate the %s plugins.' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated: %1$s.', 'The following plugins need to be updated: %1$s.' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin.', 'Sorry, but you do not have the correct permissions to update the %s plugins.' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'shopping' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'shopping' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'shopping' ),
            'nag_type'                        => 'updated',
        ),
    );

    if ( function_exists( 'tgmpa' ) ) {
        tgmpa( $plugins, $config );
    }
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
