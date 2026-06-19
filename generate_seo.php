<?php
/**
 * generate_seo.php — Alluvia clean, white-hat SEO/AEO/GEO generator.
 *
 * Writes per-product meta consumed by the theme's SEO layer (functions.php):
 *   _alluvia_seo_title    sales-intent <title> (honest; HPLC/COA/cold-chain)
 *   _alluvia_seo_desc     ~155-char meta description
 *   _alluvia_seo_focuskw  focus keyword (core product entity)
 *   _alluvia_seo_related  curated related-keyword set (comma separated)
 *   _alluvia_seo_faq      4 honest Q&As -> FAQPage schema (AEO)
 *   _alluvia_seo_generated = 1
 *
 * Skips any product flagged _alluvia_seo_manual = 1 (hand-written = protected).
 * Also (re)writes robots.txt and llms.txt (GEO) at the WordPress root.
 *
 * NOTE: deliberately contains NO fake reviews/ratings, no keyword stuffing,
 * and no dark-web/“stealth/crypto/Telegram” language. Run: php generate_seo.php
 */

// Locate wp-load.php by walking up from this file.
$dir = __DIR__;
$wp_load = null;
for ( $i = 0; $i < 9; $i++ ) {
    if ( file_exists( $dir . '/wp-load.php' ) ) { $wp_load = $dir . '/wp-load.php'; break; }
    $dir = dirname( $dir );
}
if ( ! $wp_load ) { fwrite( STDERR, "wp-load.php not found\n" ); exit( 1 ); }
define( 'WP_USE_THEMES', false );
require $wp_load;
$WP_ROOT = dirname( $wp_load );

if ( ! function_exists( 'wc_get_products' ) ) { echo "WooCommerce not active\n"; exit( 1 ); }

$BENEFIT = array(
    'medical-peptides'         => 'tissue repair & recovery research',
    'skincare-peptides'        => 'collagen & dermal research',
    'collagen-peptides'        => 'connective-tissue research',
    'sports-recovery'          => 'performance & recovery research',
    'weight-loss-metabolic'    => 'metabolic research',
    'hormone-anti-aging'       => 'longevity & GH-axis research',
    'hair-growth-peptides'     => 'follicle research',
    'research-peptides'        => 'in-vitro laboratory research',
    'lab-supplies-accessories' => 'laboratory workflows',
);
$DEFAULT_BENEFIT = 'laboratory research';

$ids  = wc_get_products( array( 'limit' => -1, 'status' => 'publish', 'return' => 'ids' ) );
$done = 0; $skip = 0;

foreach ( $ids as $pid ) {
    if ( '1' === get_post_meta( $pid, '_alluvia_seo_manual', true ) ) { $skip++; continue; }
    $p = wc_get_product( $pid );
    if ( ! $p ) { continue; }

    $name = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $p->get_name() ) ) );

    // Split a trailing dose/unit off the base name.
    $dose = ''; $base = $name;
    if ( preg_match( '/\s*([0-9.]+\s?(?:mg|mcg|iu|ml|kit|vial|tabs?))\b/i', $name, $dm ) ) {
        $dose = trim( $dm[1] );
        $base = trim( str_replace( $dm[0], '', $name ) );
    }
    if ( '' === $base ) { $base = $name; }

    $terms = wp_get_post_terms( $pid, 'product_cat', array( 'fields' => 'all' ) );
    $cat_slug = ''; $cat_name = '';
    if ( ! is_wp_error( $terms ) && $terms ) { $cat_slug = $terms[0]->slug; $cat_name = html_entity_decode( $terms[0]->name ); }
    $benefit = isset( $BENEFIT[ $cat_slug ] ) ? $BENEFIT[ $cat_slug ] : $DEFAULT_BENEFIT;

    $lname = strtolower( $name );
    $lbase = strtolower( $base );

    // Lab supplies/accessories are consumables, not peptides — no purity/COA claims.
    $is_supply = ( 'lab-supplies-accessories' === $cat_slug );

    // ── SEO title — rotate honest, commercial-intent templates by id ──
    if ( $is_supply ) {
        $titles = array(
            "Buy {$name} — Sterile Lab Supplies | Alluvia Peptides",
            "{$name} | Peptide Reconstitution Supplies — Shop Alluvia",
            "Order {$name} — Research-Grade Lab Consumables | Alluvia",
            "{$name} for the Lab — Fast Dispatch | Alluvia Peptides",
        );
    } else {
        $titles = array(
            "Buy {$name} — HPLC-Verified + COA | Alluvia Peptides",
            "{$name} for Research — Lab-Tested Purity, COA | Alluvia",
            "Order {$name} — Cold-Chain Shipped, COA | Alluvia Peptides",
            "{$name} | HPLC-Verified Purity & COA — Shop Alluvia",
        );
    }
    $title = $titles[ $pid % 4 ];

    // ── Meta description (~155, sales-intent, truthful) ──
    if ( $is_supply ) {
        $desc = "Buy {$name} for peptide reconstitution and laboratory workflows. Sterile, research-grade consumables with fast, tracked cold-chain dispatch. For laboratory use.";
    } else {
        $desc = "Buy {$name} for {$benefit}. HPLC-verified purity, Certificate of Analysis on every batch, cold-chain dispatch. Research use only — not for human consumption.";
    }
    if ( mb_strlen( $desc ) > 158 ) { $desc = mb_substr( $desc, 0, 155 ) . '…'; }

    // ── Focus + related keywords (curated; no stuffing) ──
    $focus   = $lname;
    $related = array_values( array_unique( array_filter( array(
        "buy {$lname}",
        "{$lname} for sale",
        "{$lname} price",
        "{$lbase} peptide",
        "buy {$lbase} online",
        "{$lname} coa",
        "{$lbase} research",
        $cat_name ? strtolower( $cat_name ) . ' ' . $lbase : '',
        "where to buy {$lbase}",
        "{$lbase} hplc verified",
    ) ) ) );

    // ── FAQ (AEO) — 4 honest Q&As ──
    if ( $is_supply ) {
        $faq = array(
            array( 'q' => "What is {$name}?",          'a' => "{$name} is a research-grade laboratory consumable for peptide reconstitution, mixing and storage, supplied for laboratory use by qualified researchers." ),
            array( 'q' => "What is {$name} used for?", 'a' => "{$name} supports peptide reconstitution and storage workflows in the lab. It is intended for laboratory and in-vitro use only." ),
            array( 'q' => "Is {$name} sterile?",       'a' => "Yes — {$name} is supplied as a sterile, research-grade consumable suitable for laboratory reconstitution and handling workflows." ),
            array( 'q' => "How is {$name} shipped?",   'a' => "Orders dispatch within 24 hours, tracked and protectively packed to arrive in lab-ready condition." ),
        );
    } else {
        $faq = array(
            array( 'q' => "What is {$name}?",          'a' => "{$name} is a research-grade peptide supplied for {$benefit}. Each vial is HPLC-verified and ships with a Certificate of Analysis, intended strictly for laboratory and in-vitro use." ),
            array( 'q' => "What purity is {$name}?",   'a' => "Every batch of {$name} is HPLC-verified, and a Certificate of Analysis documenting purity is provided with your order." ),
            array( 'q' => "Is {$name} for human use?", 'a' => "No. {$name} is sold strictly for laboratory and in-vitro research by qualified researchers. It is not for human or animal consumption and is not a drug, food or supplement." ),
            array( 'q' => "How is {$name} shipped?",   'a' => "Orders dispatch within 24 hours, cold-chain packed and tracked to preserve peptide integrity in transit, with your Certificate of Analysis provided digitally." ),
        );
    }

    update_post_meta( $pid, '_alluvia_seo_title',     $title );
    update_post_meta( $pid, '_alluvia_seo_desc',      $desc );
    update_post_meta( $pid, '_alluvia_seo_focuskw',   $focus );
    update_post_meta( $pid, '_alluvia_seo_related',   implode( ', ', $related ) );
    update_post_meta( $pid, '_alluvia_seo_faq',       $faq );
    update_post_meta( $pid, '_alluvia_seo_generated', '1' );
    $done++;
}
echo "Generated clean SEO for {$done} products (skipped {$skip} manual/protected).\n";

/* ── robots.txt (allow crawl; keep transactional/account paths out of the index) ── */
$home = untrailingslashit( home_url() );
$robots = "User-agent: *\nAllow: /\n"
    . "Disallow: /cart/\nDisallow: /checkout/\nDisallow: /my-account/\n"
    . "Disallow: /*?add-to-cart=\nDisallow: /*?orderby=\n"
    . "Sitemap: {$home}/wp-sitemap.xml\n";
file_put_contents( $WP_ROOT . '/robots.txt', $robots );
echo "Wrote robots.txt\n";

/* ── llms.txt (GEO — concise, factual store map for AI/answer engines) ── */
$cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
$cat_lines = '';
if ( ! is_wp_error( $cats ) ) {
    foreach ( $cats as $c ) {
        $b = isset( $BENEFIT[ $c->slug ] ) ? $BENEFIT[ $c->slug ] : $DEFAULT_BENEFIT;
        $cat_lines .= '- [' . html_entity_decode( $c->name ) . '](' . get_term_link( $c ) . ") — {$c->count} products — {$b}\n";
    }
}
$total = count( $ids );
$llms = "# Alluvia Peptides\n\n"
    . "> Pharmaceutical-grade bioactive peptides supplied for laboratory research. HPLC-verified purity with a Certificate of Analysis (COA) on every batch. Research use only — not for human or animal consumption.\n\n"
    . "## About\n"
    . "Alluvia Peptides is an online supplier of research-grade peptides ({$total} products across " . ( is_wp_error( $cats ) ? 0 : count( $cats ) ) . " categories). Every product is HPLC-verified, ships with a Certificate of Analysis, and is cold-chain dispatched within 24 hours. All products are intended strictly for in-vitro and laboratory research by qualified professionals.\n\n"
    . "## Key facts\n"
    . "- Purity: HPLC-verified; Certificate of Analysis provided on every batch\n"
    . "- Shipping: cold-chain packed, tracked, dispatched within 24 hours\n"
    . "- Intended use: laboratory / in-vitro research only — not for human consumption\n"
    . "- Brand: Alluvia Peptides ({$home})\n\n"
    . "## Product categories\n"
    . $cat_lines . "\n"
    . "## Resources\n"
    . "- Shop: {$home}/shop/\n"
    . "- Sitemap: {$home}/wp-sitemap.xml\n"
    . "- Certificate of Analysis library: {$home}/coa-library/\n";
file_put_contents( $WP_ROOT . '/llms.txt', $llms );
echo "Wrote llms.txt ({$total} products, " . ( is_wp_error( $cats ) ? 0 : count( $cats ) ) . " categories)\n";
