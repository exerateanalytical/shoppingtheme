<?php
/**
 * WooCommerce: loop hooks, review reactions, price filter, AJAX cart, category/product images, fragments, style/sidebar removal, admin notice
 *
 * @package Shopping
 * Extracted from functions.php for maintainability.
 */
if ( ! defined( "ABSPATH" ) ) { exit; }

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

