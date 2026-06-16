<?php
/**
 * Fallback template (archives, search results, 404 fallback) for the standalone
 * Alluvia theme. The homepage uses front-page.php, the blog uses home.php,
 * WooCommerce pages use woocommerce.php, and static pages use their page-*.php
 * templates — this covers everything else.
 *
 * @package Shopping
 */

get_header( 'alluvia' );
?>
<style>
  .alluvia-index{max-width:880px;margin:0 auto;padding:130px 24px 90px;font-family:var(--font-body)}
  .alluvia-index .page-title{font-family:var(--font-display);font-size:clamp(34px,5vw,52px);font-weight:600;margin-bottom:36px;color:var(--navy)}
  .alluvia-index article{padding:26px 0;border-bottom:1px solid var(--pearl-dark)}
  .alluvia-index h2{font-size:var(--fs-h3);margin:0 0 8px;font-weight:600;line-height:1.3}
  .alluvia-index h2 a{color:var(--navy);text-decoration:none}
  .alluvia-index h2 a:hover{color:var(--teal-dark)}
  .alluvia-index .meta{font-size:var(--fs-ui);color:var(--text-light);margin-bottom:12px;font-family:var(--font-ui);letter-spacing:.04em;text-transform:uppercase}
  .alluvia-index p{color:var(--text-mid);font-size:var(--fs-body);line-height:1.75;margin:0 0 12px}
  .alluvia-index .more{color:var(--teal-dark);font-weight:600;text-decoration:none}
  .alluvia-index .pagination{margin-top:36px;display:flex;gap:8px;flex-wrap:wrap}
  .alluvia-index .pagination .page-numbers{border:1.5px solid var(--pearl-dark);border-radius:10px;min-width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;color:var(--navy);font-family:var(--font-ui);font-weight:600}
  .alluvia-index .pagination .page-numbers.current,.alluvia-index .pagination a.page-numbers:hover{background:var(--teal);border-color:var(--teal)}
</style>

<?php get_template_part( 'partials/nav-alluvia' ); ?>

<main class="alluvia-index">
  <h1 class="page-title">
    <?php
    if ( is_search() ) {
        printf( esc_html__( 'Search results for “%s”', 'shopping' ), esc_html( get_search_query() ) );
    } elseif ( is_archive() ) {
        the_archive_title();
    } else {
        single_post_title();
    }
    ?>
  </h1>

  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article <?php post_class(); ?>>
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="meta"><?php echo esc_html( get_the_date() ); ?></div>
        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 40 ) ); ?></p>
        <a class="more" href="<?php the_permalink(); ?>">Read more &rarr;</a>
      </article>
    <?php endwhile; ?>
    <div class="pagination"><?php echo paginate_links( array( 'prev_text' => '‹', 'next_text' => '›' ) ); ?></div>
  <?php else : ?>
    <p>Nothing found here. <a class="more" href="<?php echo esc_url( alluvia_shop_url() ); ?>">Browse the shop &rarr;</a></p>
  <?php endif; ?>
</main>

<?php get_template_part( 'partials/footer-alluvia' ); ?>
<?php get_footer( 'alluvia' ); ?>
