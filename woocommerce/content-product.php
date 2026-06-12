<?php
/**
 * Alluvia — product loop card (override of woocommerce/content-product.php).
 *
 * Branded card driven entirely by real WooCommerce product data and the standard
 * AJAX add-to-cart button. Keeps the core loop hooks so extensions still fire.
 *
 * @package Shopping
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$link  = get_permalink( $product->get_id() );
$terms = get_the_terms( $product->get_id(), 'product_cat' );
$cat   = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
?>
<li <?php wc_product_class( '', $product ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php echo esc_url( $link ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
		<?php
		woocommerce_show_product_loop_sale_flash();
		echo $product->get_image( 'woocommerce_thumbnail' );
		?>
	</a>

	<div class="alluvia-card-body">
		<?php if ( $cat ) : ?>
			<span class="alluvia-card-cat"><?php echo esc_html( $cat ); ?></span>
		<?php endif; ?>

		<a href="<?php echo esc_url( $link ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
			<h2 class="woocommerce-loop-product__title"><?php echo esc_html( $product->get_name() ); ?></h2>
		</a>

		<?php if ( wc_review_ratings_enabled() && $product->get_review_count() ) : ?>
			<?php echo wc_get_rating_html( $product->get_average_rating(), $product->get_review_count() ); // phpcs:ignore ?>
		<?php endif; ?>

		<span class="price"><?php echo $product->get_price_html(); // phpcs:ignore ?></span>

		<?php woocommerce_template_loop_add_to_cart(); ?>
	</div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>
