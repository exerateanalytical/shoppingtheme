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
   SEO META TAGS (all Alluvia pages)
═══════════════════════════════════════ */
add_action( 'wp_head', 'alluvia_seo_meta', 1 );
function alluvia_seo_meta() {
    // If a dedicated SEO plugin is active it owns the title/meta/canonical/schema
    // (fed our curated values by the SEO-plugin bridge below) — yield to avoid
    // duplicate tags.
    if ( alluvia_active_seo_plugin() ) {
        return;
    }
    if ( is_front_page() ) {
        $desc = 'Alluvia Peptides — pharmaceutical-grade bioactive peptides for skincare, sports recovery, anti-aging, weight-loss, hair growth, and research. HPLC-verified purity with a Certificate of Analysis on every batch.';
        $logo = get_template_directory_uri() . '/assets/images/favicon.svg';
        echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:title" content="Alluvia Peptides — Premium Bioactive Peptides">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
        echo '<meta property="og:site_name" content="Alluvia Peptides">' . "\n";
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<link rel="canonical" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
        // Organization schema (logo + description). sameAs left empty — add real social profiles only.
        $org = array(
            '@context'    => 'https://schema.org',
            '@type'       => 'Organization',
            'name'        => 'Alluvia Peptides',
            'url'         => home_url( '/' ),
            'logo'        => $logo,
            'description' => $desc,
        );
        echo '<script type="application/ld+json">' . wp_json_encode( $org ) . '</script>' . "\n";
        // WebSite schema with sitelinks search.
        $website = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            'name'            => 'Alluvia Peptides',
            'url'             => home_url( '/' ),
            'potentialAction' => array(
                '@type'       => 'SearchAction',
                'target'      => array( '@type' => 'EntryPoint', 'urlTemplate' => home_url( '/?s={search_term_string}' ) ),
                'query-input' => 'required name=search_term_string',
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode( $website ) . '</script>' . "\n";
    } elseif ( function_exists( 'is_product' ) && is_product() ) {
        alluvia_product_schema();
    } elseif ( is_singular( 'post' ) ) {
        alluvia_post_schema();
    }
}

/* Per-product / per-post SEO <title> — use the curated _alluvia_seo_title when present. */
add_filter( 'pre_get_document_title', 'alluvia_seo_document_title', 1 );
function alluvia_seo_document_title( $title ) {
    // Always provide a strong baseline title at an EARLY priority. If an SEO
    // plugin is active and actually rendering, it runs later on this same filter
    // and overrides us — so a manual title edit inside the plugin still wins. If
    // no plugin is present, or one is installed but not yet rendering (e.g.
    // RankMath before its setup wizard is finished), ours stands and the title is
    // never lost to the bare WordPress default.
    if ( is_front_page() ) {
        return 'Alluvia Peptides — Premium Bioactive Peptides | HPLC-Verified Purity & COA';
    }
    if ( is_singular( array( 'product', 'post' ) ) ) {
        $custom = get_post_meta( get_the_ID(), '_alluvia_seo_title', true );
        if ( $custom ) {
            return $custom;
        }
    }
    return $title;
}

/* ── Blog post SEO/AEO/GEO output (meta + Article/Breadcrumb/FAQ schema) ──
   Mirrors alluvia_product_schema for single posts: curated meta description,
   canonical, Open Graph (article), an Article JSON-LD (GEO), BreadcrumbList,
   and a FAQPage built from the post's _alluvia_seo_faq meta (AEO). */
function alluvia_post_schema() {
    $pid = get_the_ID();
    if ( ! $pid ) {
        return;
    }
    $url       = get_permalink( $pid );
    $title     = wp_strip_all_tags( get_the_title( $pid ) );
    $seo_title = get_post_meta( $pid, '_alluvia_seo_title', true ) ?: ( $title . ' | Alluvia Peptides' );
    $desc      = get_post_meta( $pid, '_alluvia_seo_desc', true );
    if ( ! $desc ) {
        $desc = wp_html_excerpt( wp_strip_all_tags( get_post_field( 'post_content', $pid ) ), 155, '…' );
    }
    $img = get_the_post_thumbnail_url( $pid, 'large' );

    echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:type" content="article">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $seo_title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:site_name" content="Alluvia Peptides">' . "\n";
    if ( $img ) {
        echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

    $publisher = array(
        '@type' => 'Organization',
        'name'  => 'Alluvia Peptides',
        'logo'  => array( '@type' => 'ImageObject', 'url' => get_template_directory_uri() . '/assets/images/favicon.svg' ),
    );
    $article = array(
        '@context'         => 'https://schema.org',
        '@type'            => 'Article',
        'headline'         => $title,
        'description'      => $desc,
        'mainEntityOfPage' => array( '@type' => 'WebPage', '@id' => $url ),
        'datePublished'    => get_the_date( 'c', $pid ),
        'dateModified'     => get_the_modified_date( 'c', $pid ),
        'author'           => array( '@type' => 'Organization', 'name' => 'Alluvia Peptides' ),
        'publisher'        => $publisher,
    );
    if ( $img ) {
        $article['image'] = array( $img );
    }
    echo '<script type="application/ld+json">' . wp_json_encode( $article ) . '</script>' . "\n";

    $blog_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/blog/' );
    $crumbs   = array(
        array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url( '/' ) ),
        array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => $blog_url ),
        array( '@type' => 'ListItem', 'position' => 3, 'name' => $title, 'item' => $url ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $crumbs,
    ) ) . '</script>' . "\n";

    $faq = get_post_meta( $pid, '_alluvia_seo_faq', true );
    if ( is_array( $faq ) && $faq ) {
        $items = array();
        foreach ( $faq as $qa ) {
            if ( empty( $qa['q'] ) || empty( $qa['a'] ) ) {
                continue;
            }
            $items[] = array(
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags( $qa['q'] ),
                'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $qa['a'] ) ),
            );
        }
        if ( $items ) {
            echo '<script type="application/ld+json">' . wp_json_encode( array(
                '@context'   => 'https://schema.org',
                '@type'      => 'FAQPage',
                'mainEntity' => $items,
            ) ) . '</script>' . "\n";
        }
    }
}

/* Avoid a duplicate Product JSON-LD: the theme emits its own enriched Product
   schema (alluvia_product_schema), so suppress WooCommerce's default one. */
add_filter( 'woocommerce_structured_data_product', '__return_empty_array' );

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
    $pid = $product->get_id();

    $name        = wp_strip_all_tags( $product->get_name() );
    $description = wp_strip_all_tags( $product->get_short_description() ?: $product->get_description() );
    $description = trim( preg_replace( '/\s+/', ' ', $description ) );
    $sku         = $product->get_sku() ?: ( 'AV-' . $pid );
    $price       = $product->get_price();
    $url         = get_permalink( $pid );
    $img         = wp_get_attachment_image_url( $product->get_image_id(), 'large' );
    $availability = $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';

    $cats        = wp_get_post_terms( $pid, 'product_cat', array( 'fields' => 'all' ) );
    $primary_cat = ( ! is_wp_error( $cats ) && ! empty( $cats ) ) ? html_entity_decode( $cats[0]->name ) : '';

    // Curated SEO title/description (from Phase-2 generation); graceful fallbacks.
    $seo_title = get_post_meta( $pid, '_alluvia_seo_title', true ) ?: ( $name . ' | Alluvia Peptides' );
    $meta_desc = get_post_meta( $pid, '_alluvia_seo_desc', true ) ?: wp_html_excerpt( $description, 155, '…' );

    /* ── Meta description + canonical + Open Graph / Twitter (product) ── */
    echo '<meta name="description" content="' . esc_attr( $meta_desc ) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:type" content="product">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $seo_title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $meta_desc ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
    echo '<meta property="og:site_name" content="Alluvia Peptides">' . "\n";
    if ( $img ) {
        echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
    }
    if ( '' !== $price ) {
        echo '<meta property="product:price:amount" content="' . esc_attr( $price ) . '">' . "\n";
        echo '<meta property="product:price:currency" content="' . esc_attr( get_woocommerce_currency() ) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

    /* ── Product schema (enriched; real reviews only — never fabricated) ── */
    $props = array(
        array( '@type' => 'PropertyValue', 'name' => 'Purity',       'value' => 'HPLC-verified — Certificate of Analysis on every batch' ),
        array( '@type' => 'PropertyValue', 'name' => 'Form',         'value' => 'Lyophilised powder' ),
        array( '@type' => 'PropertyValue', 'name' => 'Intended Use', 'value' => 'Laboratory research use only — not for human consumption' ),
    );
    if ( preg_match( '/([0-9.]+\s?(?:mg|mcg|iu|ml))/i', $name, $dm ) ) {
        array_splice( $props, 1, 0, array( array( '@type' => 'PropertyValue', 'name' => 'Unit Size', 'value' => trim( $dm[1] ) ) ) );
    }

    $schema = array(
        '@context'           => 'https://schema.org/',
        '@type'              => 'Product',
        '@id'                => $url . '#product',
        'name'               => $name,
        'description'        => $description ?: $meta_desc,
        'sku'                => $sku,
        'mpn'                => $sku,
        'category'           => $primary_cat,
        'brand'              => array( '@type' => 'Brand', 'name' => 'Alluvia Peptides', 'url' => home_url( '/' ) ),
        'additionalProperty' => $props,
        'offers'             => array(
            '@type'           => 'Offer',
            'url'             => $url,
            'priceCurrency'   => get_woocommerce_currency(),
            'price'           => $price,
            'availability'    => $availability,
            'priceValidUntil' => gmdate( 'Y' ) . '-12-31',
            'seller'          => array( '@type' => 'Organization', 'name' => 'Alluvia Peptides' ),
        ),
    );
    if ( $img ) {
        $schema['image'] = array( $img );
    }
    $review_count = (int) $product->get_review_count();
    if ( $review_count > 0 ) { // only emit ratings backed by REAL reviews
        $schema['aggregateRating'] = array(
            '@type'       => 'AggregateRating',
            'ratingValue' => (string) $product->get_average_rating(),
            'reviewCount' => (string) $review_count,
            'bestRating'  => '5',
            'worstRating' => '1',
        );
    }
    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";

    /* ── BreadcrumbList schema ── */
    $crumbs = array(
        array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => home_url( '/' ) ),
        array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Shop', 'item' => function_exists( 'alluvia_shop_url' ) ? alluvia_shop_url() : home_url( '/shop/' ) ),
    );
    $pos = 3;
    if ( $primary_cat && ! is_wp_error( $cats ) && ! empty( $cats ) ) {
        $cat_link = get_term_link( $cats[0] );
        if ( ! is_wp_error( $cat_link ) ) {
            $crumbs[] = array( '@type' => 'ListItem', 'position' => $pos++, 'name' => $primary_cat, 'item' => $cat_link );
        }
    }
    $crumbs[] = array( '@type' => 'ListItem', 'position' => $pos, 'name' => $name, 'item' => $url );
    echo '<script type="application/ld+json">' . wp_json_encode( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $crumbs,
    ) ) . '</script>' . "\n";

    /* ── FAQPage schema (AEO) — built from curated meta, else parsed from the
          <h4>Q</h4><p>A</p> blocks already authored in the product body. ── */
    $faqs       = array();
    $faq_stored = get_post_meta( $pid, '_alluvia_seo_faq', true );
    if ( is_array( $faq_stored ) && $faq_stored ) {
        foreach ( $faq_stored as $qa ) {
            if ( empty( $qa['q'] ) || empty( $qa['a'] ) ) {
                continue;
            }
            $faqs[] = array(
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags( $qa['q'] ),
                'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $qa['a'] ) ),
            );
        }
    } elseif ( preg_match_all( '/<h4[^>]*>(.*?)<\/h4>\s*<p[^>]*>(.*?)<\/p>/is', $product->get_description(), $m, PREG_SET_ORDER ) ) {
        foreach ( $m as $pair ) {
            $faqs[] = array(
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags( $pair[1] ),
                'acceptedAnswer' => array( '@type' => 'Answer', 'text' => wp_strip_all_tags( $pair[2] ) ),
            );
        }
    }
    if ( $faqs ) {
        echo '<script type="application/ld+json">' . wp_json_encode( array(
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $faqs,
        ) ) . '</script>' . "\n";
    }
}

/* ═══════════════════════════════════════
   SEO PLUGIN BRIDGE
   If a dedicated SEO plugin is later installed, hand it the curated
   _alluvia_seo_* values so they appear PRE-FILLED in the plugin's own editor
   fields (SEO title / meta description / focus keyword) and are used for output.
   The theme's own SEO output (above) yields to the plugin. Non-destructive: a
   plugin field is only filled when empty, so manual edits inside the plugin win.
═══════════════════════════════════════ */
function alluvia_active_seo_plugin() {
    if ( defined( 'WPSEO_VERSION' ) )                                  { return 'yoast'; }
    if ( defined( 'RANK_MATH_VERSION' ) )                              { return 'rankmath'; }
    if ( defined( 'SEOPRESS_VERSION' ) )                               { return 'seopress'; }
    if ( defined( 'AIOSEO_VERSION' ) || defined( 'AIOSEOP_VERSION' ) ) { return 'aioseo'; }
    return '';
}

/* Map our meta to a plugin's post-meta keys. null => not post-meta based (AIOSEO). */
function alluvia_seo_plugin_keymap( $plugin ) {
    switch ( $plugin ) {
        case 'yoast':
            return array( 'title' => '_yoast_wpseo_title', 'desc' => '_yoast_wpseo_metadesc', 'focus' => '_yoast_wpseo_focuskw', 'related' => '_yoast_wpseo_keywordsynonyms', 'combine' => false );
        case 'rankmath':
            return array( 'title' => 'rank_math_title', 'desc' => 'rank_math_description', 'focus' => 'rank_math_focus_keyword', 'related' => null, 'combine' => true );
        case 'seopress':
            return array( 'title' => '_seopress_titles_title', 'desc' => '_seopress_titles_desc', 'focus' => '_seopress_analysis_target_kw', 'related' => null, 'combine' => true );
    }
    return null;
}

/* Copy one product's curated meta into the plugin's keys (only where empty). */
function alluvia_seo_sync_product( $pid, $map ) {
    $title   = get_post_meta( $pid, '_alluvia_seo_title', true );
    $desc    = get_post_meta( $pid, '_alluvia_seo_desc', true );
    $focus   = get_post_meta( $pid, '_alluvia_seo_focuskw', true );
    $related = get_post_meta( $pid, '_alluvia_seo_related', true );
    $fill = function ( $key, $val ) use ( $pid ) {
        if ( $key && '' !== (string) $val && '' === (string) get_post_meta( $pid, $key, true ) ) {
            update_post_meta( $pid, $key, $val );
        }
    };
    $fill( $map['title'], $title );
    $fill( $map['desc'], $desc );
    $fk = ( ! empty( $map['combine'] ) && $related ) ? trim( $focus . ', ' . $related ) : $focus;
    $fill( $map['focus'], $fk );
    if ( ! empty( $map['related'] ) ) {
        $fill( $map['related'], $related );
    }
}

/* One-time migration the first admin load after a supported plugin is detected. */
add_action( 'admin_init', 'alluvia_seo_bridge_migrate' );
function alluvia_seo_bridge_migrate() {
    $plugin = alluvia_active_seo_plugin();
    if ( ! $plugin ) {
        return;
    }
    $map = alluvia_seo_plugin_keymap( $plugin );
    if ( ! $map ) {
        return; // AIOSEO: fed via output filters below, no post-meta to migrate
    }
    $flag = 'alluvia_seo_bridged_' . $plugin;
    if ( get_option( $flag ) ) {
        return;
    }
    $ids = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1, 'fields' => 'ids', 'post_status' => 'any' ) );
    foreach ( $ids as $pid ) {
        alluvia_seo_sync_product( $pid, $map );
    }
    update_option( $flag, time() );
}

/* Keep new / re-saved products bridged. */
add_action( 'save_post_product', 'alluvia_seo_bridge_on_save', 20 );
function alluvia_seo_bridge_on_save( $pid ) {
    if ( wp_is_post_revision( $pid ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
        return;
    }
    $plugin = alluvia_active_seo_plugin();
    if ( ! $plugin ) {
        return;
    }
    $map = alluvia_seo_plugin_keymap( $plugin );
    if ( $map ) {
        alluvia_seo_sync_product( $pid, $map );
    }
}

/* AIOSEO keeps SEO data in its own table, so feed it through its output filters. */
add_filter( 'aioseo_title', 'alluvia_seo_aioseo_title' );
function alluvia_seo_aioseo_title( $title ) {
    if ( is_singular( 'product' ) ) {
        $t = get_post_meta( get_the_ID(), '_alluvia_seo_title', true );
        if ( $t ) {
            return $t;
        }
    }
    return $title;
}
add_filter( 'aioseo_description', 'alluvia_seo_aioseo_desc' );
function alluvia_seo_aioseo_desc( $desc ) {
    if ( is_singular( 'product' ) ) {
        $d = get_post_meta( get_the_ID(), '_alluvia_seo_desc', true );
        if ( $d ) {
            return $d;
        }
    }
    return $desc;
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
    echo '<div class="alluvia-ruo-notice" role="note" style="margin:18px 0;padding:14px 16px;border:1px solid var(--gold,#c6a253);border-left:4px solid var(--gold,#c6a253);background:#fbf7ef;border-radius:8px;font-size:15px;line-height:1.5;color:#3a3320;">'
        . '<strong style="display:block;letter-spacing:1px;text-transform:uppercase;color:var(--navy,#0a1a27);margin-bottom:4px;">For Research Use Only</strong>'
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

/* ═══════════════════════════════════════
   THEME COLORS — live Customizer controls
   Appearance → Customize → Theme Colors. Three pickers (primary/teal,
   accent/gold, navy background) recolor the whole platform by overriding the
   CSS custom properties defined in alluvia-base.css. Defaults match the shipped
   palette; the override is only emitted for colors the owner actually changes,
   so the stock look is untouched until customised. Related shades (teal-dark,
   gold-light, navy-deep/mid/soft) are derived with color-mix() so the palette
   stays coherent from just three inputs.
═══════════════════════════════════════ */
define( 'ALLUVIA_COLOR_DEFAULTS', array(
    'alluvia_color_primary' => '#0eaf9f', // --teal
    'alluvia_color_accent'  => '#c6a253', // --gold
    'alluvia_color_bg'      => '#0a1a27', // --navy
) );

add_action( 'customize_register', 'alluvia_customize_colors' );
function alluvia_customize_colors( $wp_customize ) {
    $wp_customize->add_section( 'alluvia_theme_colors', array(
        'title'       => __( 'Theme Colors', 'shopping' ),
        'priority'    => 30,
        'description' => __( 'Recolor the whole site. Related shades adjust automatically.', 'shopping' ),
    ) );

    $fields = array(
        'alluvia_color_primary' => __( 'Primary (teal)', 'shopping' ),
        'alluvia_color_accent'  => __( 'Accent (gold)', 'shopping' ),
        'alluvia_color_bg'      => __( 'Background (navy)', 'shopping' ),
    );
    $defaults = ALLUVIA_COLOR_DEFAULTS;

    foreach ( $fields as $id => $label ) {
        $wp_customize->add_setting( $id, array(
            'default'           => $defaults[ $id ],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage', // instant live preview via customize-preview.js
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array(
            'label'   => $label,
            'section' => 'alluvia_theme_colors',
        ) ) );
    }
}

/* Build the :root override CSS from the saved colors (only for changed values). */
function alluvia_color_overrides_css() {
    $defaults = ALLUVIA_COLOR_DEFAULTS;
    $primary  = sanitize_hex_color( get_theme_mod( 'alluvia_color_primary', $defaults['alluvia_color_primary'] ) );
    $accent   = sanitize_hex_color( get_theme_mod( 'alluvia_color_accent',  $defaults['alluvia_color_accent'] ) );
    $bg       = sanitize_hex_color( get_theme_mod( 'alluvia_color_bg',       $defaults['alluvia_color_bg'] ) );

    $vars = '';
    if ( $primary && strtolower( $primary ) !== $defaults['alluvia_color_primary'] ) {
        $vars .= "--teal:{$primary};";
        $vars .= "--teal-dark:color-mix(in srgb,{$primary},#000 26%);";
        $vars .= "--teal-glow:color-mix(in srgb,{$primary} 18%,transparent);";
    }
    if ( $accent && strtolower( $accent ) !== $defaults['alluvia_color_accent'] ) {
        $vars .= "--gold:{$accent};";
        $vars .= "--gold-light:color-mix(in srgb,{$accent},#fff 28%);";
    }
    if ( $bg && strtolower( $bg ) !== $defaults['alluvia_color_bg'] ) {
        $vars .= "--navy:{$bg};";
        $vars .= "--navy-deep:color-mix(in srgb,{$bg},#000 45%);";
        $vars .= "--navy-mid:color-mix(in srgb,{$bg},#fff 12%);";
        $vars .= "--navy-soft:color-mix(in srgb,{$bg},#fff 26%);";
    }
    return $vars ? ":root{{$vars}}" : '';
}

/* Print the override late in <head> so it wins over alluvia-base.css's :root. */
add_action( 'wp_head', 'alluvia_print_color_overrides', 100 );
function alluvia_print_color_overrides() {
    $css = alluvia_color_overrides_css();
    if ( $css ) {
        echo "<style id=\"alluvia-theme-colors\">{$css}</style>\n";
    }
}

/* Enqueue the live-preview binder inside the Customizer preview frame. */
add_action( 'customize_preview_init', 'alluvia_customize_preview_js' );
function alluvia_customize_preview_js() {
    $path = get_stylesheet_directory() . '/assets/js/customize-preview.js';
    wp_enqueue_script(
        'alluvia-customize-preview',
        get_stylesheet_directory_uri() . '/assets/js/customize-preview.js',
        array( 'customize-preview' ),
        file_exists( $path ) ? filemtime( $path ) : '1.0.0',
        true
    );
}

/* ═══════════════════════════════════════
   POST-PURCHASE REVIEW REQUEST (multilingual)
   When an order is marked completed, schedule a one-off email (after a delay,
   so the shipment has arrived) inviting the customer to review the exact
   products they bought. Copy is localised by billing country
   (EN/FR/DE/NL/IT/ES) and each CTA links to that product's review form. Real,
   verified-buyer reviews then accrue natively in WooCommerce and feed the
   existing real-reviews-only Product/AggregateRating schema. No fabrication.

   Controls:
     option  'alluvia_review_request_enabled'  ('yes' default) — master switch
     filter  'alluvia_review_request_delay'    — seconds, default 10 days
     filter  'alluvia_review_request_language'  — force a language code
     admin   ?alluvia_review_preview=<order_id>[&lang=fr]  — render, do NOT send
     admin   ?alluvia_review_send_now=<order_id>           — send immediately
═══════════════════════════════════════ */
define( 'ALLUVIA_REVIEW_CRON', 'alluvia_review_request_send' );

/* Master on/off (default on), filterable. */
function alluvia_review_request_enabled() {
    return apply_filters( 'alluvia_review_request_enabled', 'yes' === get_option( 'alluvia_review_request_enabled', 'yes' ) );
}

/* Map an order to one of the six supported languages, by stored locale or
   billing country. Always returns a supported code; filterable. */
function alluvia_order_language( $order ) {
    $lang = '';
    if ( $order ) {
        $stored = $order->get_meta( 'wpml_language' );
        if ( ! $stored ) { $stored = $order->get_meta( '_locale' ); }
        if ( $stored ) { $lang = strtolower( substr( $stored, 0, 2 ) ); }
        if ( ! $lang ) {
            $country = strtoupper( (string) $order->get_billing_country() );
            $map = array(
                'FR' => 'fr', 'MC' => 'fr',
                'DE' => 'de', 'AT' => 'de', 'CH' => 'de', 'LI' => 'de',
                'NL' => 'nl', 'BE' => 'nl',
                'IT' => 'it', 'SM' => 'it', 'VA' => 'it',
                'ES' => 'es', 'MX' => 'es', 'AR' => 'es', 'CL' => 'es', 'CO' => 'es',
                'PE' => 'es', 'VE' => 'es', 'EC' => 'es', 'UY' => 'es', 'BO' => 'es',
                'PY' => 'es', 'CR' => 'es', 'PA' => 'es', 'DO' => 'es', 'GT' => 'es',
            );
            if ( isset( $map[ $country ] ) ) { $lang = $map[ $country ]; }
        }
    }
    if ( ! in_array( $lang, array( 'en', 'fr', 'de', 'nl', 'it', 'es' ), true ) ) {
        $lang = 'en';
    }
    return apply_filters( 'alluvia_review_request_language', $lang, $order );
}

/* Localised microcopy for the review-request email. Compliant by design: the
   ask is about quality, packaging, delivery and service — never efficacy. */
function alluvia_review_request_strings( $lang ) {
    $t = array(
        'en' => array(
            'subject'        => '{shop}: how was your recent order?',
            'heading'        => 'How did we do?',
            'greeting'       => 'Hi {name},',
            'greeting_noname'=> 'Hi there,',
            'intro'          => 'Thank you for your recent order from {shop}. Your research matters to us — and so does your honest feedback.',
            'ask'            => "If you have a moment, we'd love to hear what you thought about:",
            'bullets'        => array( 'Product quality and purity', 'Packaging and cold-chain condition on arrival', 'Delivery speed', 'Our customer service' ),
            'products_intro' => 'Leave a quick review for the products you ordered:',
            'cta'            => 'Write a review',
            'closing'        => 'It takes less than a minute, and your verified-buyer review helps fellow researchers order with confidence.',
            'signoff'        => "With appreciation,\nThe {shop} team",
            'ruo'            => 'All products are supplied for laboratory research use only — not for human or animal consumption.',
            'fallback_name'  => '',
        ),
        'fr' => array(
            'subject'        => '{shop} : comment s\'est passée votre commande ?',
            'heading'        => 'Votre avis compte',
            'greeting'       => 'Bonjour {name},',
            'greeting_noname'=> 'Bonjour,',
            'intro'          => 'Merci pour votre récente commande chez {shop}. Vos recherches comptent pour nous, tout comme votre avis sincère.',
            'ask'            => 'Si vous avez un instant, nous aimerions savoir ce que vous avez pensé de :',
            'bullets'        => array( 'La qualité et la pureté du produit', 'L\'emballage et l\'état de la chaîne du froid à la réception', 'La rapidité de livraison', 'Notre service client' ),
            'products_intro' => 'Laissez un court avis sur les produits commandés :',
            'cta'            => 'Rédiger un avis',
            'closing'        => 'Cela prend moins d\'une minute, et votre avis d\'acheteur vérifié aide d\'autres chercheurs à commander en toute confiance.',
            'signoff'        => "Avec nos remerciements,\nL'équipe {shop}",
            'ruo'            => 'Tous les produits sont fournis exclusivement à des fins de recherche en laboratoire — ne convient pas à la consommation humaine ou animale.',
            'fallback_name'  => '',
        ),
        'de' => array(
            'subject'        => '{shop}: Wie war Ihre Bestellung?',
            'heading'        => 'Ihre Meinung zählt',
            'greeting'       => 'Hallo {name},',
            'greeting_noname'=> 'Hallo,',
            'intro'          => 'Vielen Dank für Ihre kürzliche Bestellung bei {shop}. Ihre Forschung ist uns wichtig – und Ihr ehrliches Feedback ebenso.',
            'ask'            => 'Wenn Sie einen Moment Zeit haben, würden wir gerne erfahren, wie Ihnen Folgendes gefallen hat:',
            'bullets'        => array( 'Produktqualität und Reinheit', 'Verpackung und Zustand der Kühlkette bei Ankunft', 'Liefergeschwindigkeit', 'Unser Kundenservice' ),
            'products_intro' => 'Hinterlassen Sie eine kurze Bewertung für die bestellten Produkte:',
            'cta'            => 'Bewertung schreiben',
            'closing'        => 'Es dauert weniger als eine Minute, und Ihre Bewertung als verifizierter Käufer hilft anderen Forschenden, mit Vertrauen zu bestellen.',
            'signoff'        => "Mit herzlichem Dank,\nIhr {shop}-Team",
            'ruo'            => 'Alle Produkte werden ausschließlich für Forschungszwecke im Labor geliefert – nicht für den menschlichen oder tierischen Gebrauch bestimmt.',
            'fallback_name'  => '',
        ),
        'nl' => array(
            'subject'        => '{shop}: hoe was uw bestelling?',
            'heading'        => 'Uw mening telt',
            'greeting'       => 'Hallo {name},',
            'greeting_noname'=> 'Hallo,',
            'intro'          => 'Bedankt voor uw recente bestelling bij {shop}. Uw onderzoek is belangrijk voor ons, en uw eerlijke feedback net zo goed.',
            'ask'            => 'Als u even tijd heeft, horen we graag wat u vond van:',
            'bullets'        => array( 'Productkwaliteit en zuiverheid', 'Verpakking en staat van de koelketen bij aankomst', 'Leversnelheid', 'Onze klantenservice' ),
            'products_intro' => 'Laat een korte review achter voor de bestelde producten:',
            'cta'            => 'Schrijf een review',
            'closing'        => 'Het kost minder dan een minuut, en uw review als geverifieerde koper helpt andere onderzoekers met vertrouwen te bestellen.',
            'signoff'        => "Met dank,\nHet team van {shop}",
            'ruo'            => 'Alle producten worden uitsluitend geleverd voor laboratoriumonderzoek — niet voor menselijke of dierlijke consumptie.',
            'fallback_name'  => '',
        ),
        'it' => array(
            'subject'        => '{shop}: com\'è andato il tuo ordine?',
            'heading'        => 'La tua opinione conta',
            'greeting'       => 'Ciao {name},',
            'greeting_noname'=> 'Ciao,',
            'intro'          => 'Grazie per il tuo recente ordine su {shop}. La tua ricerca è importante per noi, così come il tuo parere sincero.',
            'ask'            => 'Se hai un momento, ci piacerebbe sapere cosa ne pensi di:',
            'bullets'        => array( 'Qualità e purezza del prodotto', 'Imballaggio e stato della catena del freddo all\'arrivo', 'Velocità di consegna', 'Il nostro servizio clienti' ),
            'products_intro' => 'Lascia una breve recensione per i prodotti ordinati:',
            'cta'            => 'Scrivi una recensione',
            'closing'        => 'Bastano meno di un minuto e la tua recensione di acquirente verificato aiuta altri ricercatori a ordinare con fiducia.',
            'signoff'        => "Con gratitudine,\nIl team di {shop}",
            'ruo'            => 'Tutti i prodotti sono forniti esclusivamente per uso di ricerca in laboratorio — non destinati al consumo umano o animale.',
            'fallback_name'  => '',
        ),
        'es' => array(
            'subject'        => '{shop}: ¿qué tal tu pedido?',
            'heading'        => 'Tu opinión cuenta',
            'greeting'       => 'Hola {name},',
            'greeting_noname'=> 'Hola,',
            'intro'          => 'Gracias por tu reciente pedido en {shop}. Tu investigación nos importa, y tu opinión sincera también.',
            'ask'            => 'Si tienes un momento, nos encantaría saber qué te pareció:',
            'bullets'        => array( 'La calidad y pureza del producto', 'El embalaje y el estado de la cadena de frío a la llegada', 'La rapidez de entrega', 'Nuestra atención al cliente' ),
            'products_intro' => 'Deja una breve reseña de los productos que pediste:',
            'cta'            => 'Escribir una reseña',
            'closing'        => 'Te llevará menos de un minuto, y tu reseña como comprador verificado ayuda a otros investigadores a pedir con confianza.',
            'signoff'        => "Con agradecimiento,\nEl equipo de {shop}",
            'ruo'            => 'Todos los productos se suministran exclusivamente para uso de investigación en laboratorio, no aptos para el consumo humano o animal.',
            'fallback_name'  => '',
        ),
    );
    return isset( $t[ $lang ] ) ? $t[ $lang ] : $t['en'];
}

/* Unique, published, reviewable product IDs from an order's line items. */
function alluvia_order_reviewable_products( $order ) {
    $ids = array();
    if ( ! $order || ! method_exists( $order, 'get_items' ) ) {
        return $ids;
    }
    foreach ( $order->get_items() as $item ) {
        $pid = (int) $item->get_product_id();
        if ( $pid && 'product' === get_post_type( $pid ) && 'publish' === get_post_status( $pid ) && ! in_array( $pid, $ids, true ) ) {
            $ids[] = $pid;
        }
    }
    return $ids;
}

/* Build the localised review-request email. Returns [subject, html]. Pure: it
   takes plain inputs so it can be previewed without sending a real message. */
function alluvia_review_request_render( $lang, $first_name, $product_ids, $order = null ) {
    $s    = alluvia_review_request_strings( $lang );
    $shop = get_bloginfo( 'name' );

    $teal = '#0eaf9f'; $navy = '#0a1a27'; $gold = '#c6a253';
    $ink  = '#1b2733'; $muted = '#5b6b78'; $line = '#e6ebef';

    $first_name = trim( (string) $first_name );
    $greeting   = $first_name
        ? str_replace( '{name}', $first_name, $s['greeting'] )
        : $s['greeting_noname'];

    $items = '';
    foreach ( (array) $product_ids as $pid ) {
        $pid = (int) $pid;
        if ( ! $pid || 'product' !== get_post_type( $pid ) ) {
            continue;
        }
        $url   = esc_url( get_permalink( $pid ) . '#reviews' );
        $title = esc_html( get_the_title( $pid ) );
        $items .= '<tr><td style="padding:11px 0;border-bottom:1px solid ' . $line . '">'
            . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>'
            . '<td style="font-family:Arial,Helvetica,sans-serif;font-size:15px;color:' . $ink . ';font-weight:600;vertical-align:middle;padding-right:12px">' . $title . '</td>'
            . '<td align="right" style="vertical-align:middle"><a href="' . $url . '" style="display:inline-block;background:' . $teal . ';color:' . $navy . ';font-family:Arial,Helvetica,sans-serif;font-size:13px;font-weight:700;text-decoration:none;padding:9px 16px;border-radius:100px;white-space:nowrap">' . esc_html( $s['cta'] ) . '</a></td>'
            . '</tr></table></td></tr>';
    }

    $bullets = '';
    foreach ( $s['bullets'] as $b ) {
        $bullets .= '<li style="margin:0 0 6px">' . esc_html( $b ) . '</li>';
    }

    $signoff = str_replace( '{shop}', $shop, $s['signoff'] );

    $content  = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:1.7;color:' . $ink . '">';
    $content .= '<p style="margin:0 0 14px">' . esc_html( $greeting ) . '</p>';
    $content .= '<p style="margin:0 0 14px">' . esc_html( str_replace( '{shop}', $shop, $s['intro'] ) ) . '</p>';
    $content .= '<p style="margin:0 0 8px">' . esc_html( $s['ask'] ) . '</p>';
    $content .= '<ul style="margin:0 0 18px;padding-left:20px;color:' . $muted . '">' . $bullets . '</ul>';
    $content .= '<p style="margin:0 0 4px;font-weight:600">' . esc_html( $s['products_intro'] ) . '</p>';
    $content .= '<table role="presentation" width="100%" cellpadding="0" cellspacing="0">' . $items . '</table>';
    $content .= '<p style="margin:18px 0 14px">' . esc_html( $s['closing'] ) . '</p>';
    $content .= '<p style="margin:0">' . nl2br( esc_html( $signoff ) ) . '</p>';
    $content .= '</div>';

    $html  = '<!DOCTYPE html><html lang="' . esc_attr( $lang ) . '"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>';
    $html .= '<body style="margin:0;padding:0;background:#f4f6f8">';
    $html .= '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 0"><tr><td align="center">';
    $html .= '<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:600px;max-width:92%;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid ' . $line . '">';
    $html .= '<tr><td style="background:' . $navy . ';padding:22px 28px">'
        . '<span style="font-family:Georgia,\'Times New Roman\',serif;font-size:20px;color:#ffffff;font-weight:600;letter-spacing:.5px">' . esc_html( $shop ) . '</span>'
        . '<span style="display:block;height:3px;width:46px;background:' . $gold . ';margin-top:10px;border-radius:2px"></span></td></tr>';
    $html .= '<tr><td style="padding:28px 28px 0"><h1 style="margin:0;font-family:Georgia,\'Times New Roman\',serif;font-size:24px;font-weight:600;color:' . $navy . '">' . esc_html( $s['heading'] ) . '</h1></td></tr>';
    $html .= '<tr><td style="padding:16px 28px 28px">' . $content . '</td></tr>';
    $html .= '<tr><td style="background:#f0f3f5;padding:18px 28px">'
        . '<p style="margin:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:1.6;color:' . $muted . '">' . esc_html( $s['ruo'] ) . '</p>'
        . '<p style="margin:8px 0 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:' . $muted . '">&copy; ' . esc_html( gmdate( 'Y' ) ) . ' ' . esc_html( $shop ) . '</p></td></tr>';
    $html .= '</table></td></tr></table></body></html>';

    $subject = str_replace( '{shop}', $shop, $s['subject'] );
    return array( 'subject' => $subject, 'html' => $html );
}

/* Send via WooCommerce's mailer (proper From + HTML) with a wp_mail fallback. */
function alluvia_review_request_dispatch( $to, $subject, $html ) {
    $headers = array( 'Content-Type: text/html; charset=UTF-8' );
    if ( function_exists( 'WC' ) && WC()->mailer() ) {
        return (bool) WC()->mailer()->send( $to, $subject, $html, $headers );
    }
    return (bool) wp_mail( $to, $subject, $html, $headers );
}

/* On order completion, schedule the request once, after a delay. */
add_action( 'woocommerce_order_status_completed', 'alluvia_schedule_review_request', 20, 1 );
function alluvia_schedule_review_request( $order_id ) {
    if ( ! alluvia_review_request_enabled() ) {
        return;
    }
    $order = wc_get_order( $order_id );
    if ( ! $order || $order->get_meta( '_alluvia_review_request_sent' ) || $order->get_meta( '_alluvia_review_request_scheduled' ) ) {
        return;
    }
    if ( ! $order->get_billing_email() ) {
        return;
    }
    $delay = (int) apply_filters( 'alluvia_review_request_delay', 10 * DAY_IN_SECONDS, $order );
    $args  = array( (int) $order_id );
    if ( ! wp_next_scheduled( ALLUVIA_REVIEW_CRON, $args ) ) {
        wp_schedule_single_event( time() + max( 60, $delay ), ALLUVIA_REVIEW_CRON, $args );
    }
    $order->update_meta_data( '_alluvia_review_request_scheduled', time() );
    $order->save();
}

/* Cancelled / refunded before send → drop the pending request. */
add_action( 'woocommerce_order_status_cancelled', 'alluvia_unschedule_review_request' );
add_action( 'woocommerce_order_status_refunded', 'alluvia_unschedule_review_request' );
function alluvia_unschedule_review_request( $order_id ) {
    $args = array( (int) $order_id );
    $ts   = wp_next_scheduled( ALLUVIA_REVIEW_CRON, $args );
    if ( $ts ) {
        wp_unschedule_event( $ts, ALLUVIA_REVIEW_CRON, $args );
    }
}

/* The scheduled callback: build + send once, then mark the order. */
add_action( ALLUVIA_REVIEW_CRON, 'alluvia_send_review_request', 10, 1 );
function alluvia_send_review_request( $order_id ) {
    if ( ! alluvia_review_request_enabled() ) {
        return;
    }
    $order = wc_get_order( $order_id );
    if ( ! $order || $order->get_meta( '_alluvia_review_request_sent' ) ) {
        return;
    }
    $to = $order->get_billing_email();
    if ( ! $to ) {
        return;
    }
    $product_ids = alluvia_order_reviewable_products( $order );
    if ( empty( $product_ids ) ) {
        return;
    }
    $lang  = alluvia_order_language( $order );
    $email = alluvia_review_request_render( $lang, $order->get_billing_first_name(), $product_ids, $order );

    if ( alluvia_review_request_dispatch( $to, $email['subject'], $email['html'] ) ) {
        $order->update_meta_data( '_alluvia_review_request_sent', time() );
        $order->update_meta_data( '_alluvia_review_request_lang', $lang );
        $order->save();
        if ( method_exists( $order, 'add_order_note' ) ) {
            $order->add_order_note( sprintf( 'Review-request email sent (%s).', strtoupper( $lang ) ) );
        }
    }
}

/* Admin helpers: preview (no send) and send-now. Mirrors the existing
   ?alluvia_reset_pages pattern; gated to manage_options. */
add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['alluvia_review_preview'] ) ) {
        $oid   = absint( $_GET['alluvia_review_preview'] );
        $order = $oid ? wc_get_order( $oid ) : null;
        $lang  = isset( $_GET['lang'] ) ? sanitize_key( wp_unslash( $_GET['lang'] ) ) : ( $order ? alluvia_order_language( $order ) : 'en' );
        $first = $order ? $order->get_billing_first_name() : 'Alex';
        $pids  = $order ? alluvia_order_reviewable_products( $order ) : array();
        if ( empty( $pids ) && function_exists( 'wc_get_products' ) ) {
            $pids = wc_get_products( array( 'limit' => 2, 'status' => 'publish', 'return' => 'ids' ) );
        }
        $email = alluvia_review_request_render( $lang, $first, $pids, $order );
        header( 'Content-Type: text/html; charset=utf-8' );
        echo '<div style="font-family:monospace;background:#101820;color:#37e0a8;padding:10px 14px">PREVIEW ONLY — not sent &nbsp;|&nbsp; LANG: ' . esc_html( $lang ) . ' &nbsp;|&nbsp; SUBJECT: ' . esc_html( $email['subject'] ) . '</div>';
        echo $email['html']; // already escaped during build
        exit;
    }
    if ( isset( $_GET['alluvia_review_send_now'] ) ) {
        $oid = absint( $_GET['alluvia_review_send_now'] );
        if ( $oid ) {
            alluvia_send_review_request( $oid );
        }
        wp_safe_redirect( admin_url( 'admin.php?page=wc-orders' ) );
        exit;
    }
} );

/* ═══════════════════════════════════════
   CONTACT PAGE INFO — editable in the Customizer
   Appearance → Customize → "Contact Page Info". Every contact detail on the
   Contact page (email, phone, location, business hours, response times) is a
   text setting whose default is the original copy, so the page is unchanged
   until the owner edits it. page-contact.php reads these via alluvia_contact().
═══════════════════════════════════════ */
function alluvia_contact_fields() {
	return array(
		'email'           => array( 'Email address', 'hello@alluviapeptides.com' ),
		'email_note'      => array( 'Email — response note', 'Response within 4 hours' ),
		'phone'           => array( 'Phone number', '+1 (800) 555-0192' ),
		'phone_note'      => array( 'Phone — hours note', 'Mon–Fri 9am–6pm EST' ),
		'chat_note'       => array( 'Live chat — hours note', 'Mon–Fri 9am–8pm EST' ),
		'location'        => array( 'Location', 'Miami, Florida, USA' ),
		'location_note'   => array( 'Location — note', 'By appointment only' ),
		'wholesale_email' => array( 'Wholesale / B2B email', 'wholesale@alluviapeptides.com' ),
		'hours_weekday'   => array( 'Business hours — Mon–Fri', '9:00am – 6:00pm EST' ),
		'hours_sat'       => array( 'Business hours — Saturday', 'Closed' ),
		'hours_sun'       => array( 'Business hours — Sunday', 'Closed' ),
		'resp_email'      => array( 'Response time — Email', 'Within 4 hours' ),
		'resp_chat'       => array( 'Response time — Live Chat', 'Instant' ),
		'resp_phone'      => array( 'Response time — Phone', 'Immediate' ),
		'resp_wholesale'  => array( 'Response time — Wholesale', 'Within 24h' ),
	);
}
/* Get a contact field value (Customizer override, else the original default). */
function alluvia_contact( $key ) {
	$fields  = alluvia_contact_fields();
	$default = isset( $fields[ $key ] ) ? $fields[ $key ][1] : '';
	return get_theme_mod( 'alluvia_contact_' . $key, $default );
}
add_action( 'customize_register', 'alluvia_customize_contact' );
function alluvia_customize_contact( $wp_customize ) {
	$wp_customize->add_section( 'alluvia_contact_info', array(
		'title'       => __( 'Contact Page Info', 'shopping' ),
		'priority'    => 35,
		'description' => __( 'Edit the details shown on the Contact page — email, phone, location, hours and response times.', 'shopping' ),
	) );
	foreach ( alluvia_contact_fields() as $key => $f ) {
		$id = 'alluvia_contact_' . $key;
		$wp_customize->add_setting( $id, array(
			'default'           => $f[1],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $f[0],
			'section' => 'alluvia_contact_info',
			'type'    => 'text',
		) );
	}
}
