<?php
/**
 * Alluvia Peptides — Theme Functions (standalone)
 *
 * This file is intentionally thin: it loads focused modules from inc/.
 * Each module owns one responsibility and registers its own hooks.
 *
 * @package Shopping
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$alluvia_inc = get_stylesheet_directory() . '/inc/';

require_once $alluvia_inc . 'setup.php';        // Theme setup, URL helpers, widgets/init, admin bar
require_once $alluvia_inc . 'ajax-forms.php';   // Contact form + newsletter subscribe AJAX
require_once $alluvia_inc . 'seo.php';          // Favicon, SEO meta, Product/FAQ JSON-LD
require_once $alluvia_inc . 'enqueue.php';      // Scripts & styles (fonts, Lucide, commerce)
require_once $alluvia_inc . 'woocommerce.php';  // WooCommerce hooks, cart, reactions, images
require_once $alluvia_inc . 'compliance.php';   // Research-Use-Only + Certificate of Analysis
require_once $alluvia_inc . 'activation.php';   // Auto-create pages, WooCommerce pages, routing
