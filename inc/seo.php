<?php
/**
 * Favicon fallback + SEO meta + Product/FAQ JSON-LD schema
 *
 * @package Shopping
 * Extracted from functions.php for maintainability.
 */
if ( ! defined( "ABSPATH" ) ) { exit; }

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

