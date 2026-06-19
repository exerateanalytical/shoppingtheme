<?php
/**
 * The template for displaying comments on blog posts.
 *
 * @package Shopping
 */

// Don't load directly, and bail if the post is password-protected.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="alluvia-comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$alluvia_comment_count = get_comments_number();
			if ( '1' === $alluvia_comment_count ) {
				echo esc_html__( 'One comment', 'alluvia' );
			} else {
				printf(
					/* translators: %s: comment count number */
					esc_html( _n( '%s comment', '%s comments', $alluvia_comment_count, 'alluvia' ) ),
					esc_html( number_format_i18n( $alluvia_comment_count ) )
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( 'Older comments', 'alluvia' ),
				'next_text' => esc_html__( 'Newer comments', 'alluvia' ),
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'alluvia' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php
	comment_form();
	?>

</div>
