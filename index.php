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
  body{background:#f5f0e7;color:#0a1a27}
  .alluvia-topbar{position:fixed;top:0;left:0;right:0;z-index:1000;background:rgba(10,26,39,.97);backdrop-filter:blur(20px);padding:16px 24px;display:flex;align-items:center;justify-content:space-between}
  .alluvia-topbar a.brand{color:#fff;text-decoration:none;font-family:'Cormorant Garamond',Georgia,serif;font-size:24px;font-weight:600;letter-spacing:.03em}
  .alluvia-topbar a.brand span{color:#0eaf9f}
  .alluvia-topbar a.shop{color:#0a1a27;background:#0eaf9f;text-decoration:none;font-family:'Space Grotesk',system-ui,sans-serif;font-size:13px;font-weight:600;padding:9px 20px;border-radius:100px}
  .alluvia-index{max-width:880px;margin:0 auto;padding:130px 24px 90px;font-family:'Inter',system-ui,sans-serif}
  .alluvia-index .page-title{font-family:'Cormorant Garamond',Georgia,serif;font-size:clamp(34px,5vw,52px);font-weight:600;margin-bottom:36px}
  .alluvia-index article{padding:26px 0;border-bottom:1px solid #e8e0d2}
  .alluvia-index h2{font-size:23px;margin:0 0 8px;font-weight:600;line-height:1.3}
  .alluvia-index h2 a{color:#0a1a27;text-decoration:none}
  .alluvia-index h2 a:hover{color:#0a8174}
  .alluvia-index .meta{font-size:13px;color:#8392a2;margin-bottom:12px;font-family:'Space Grotesk',system-ui,sans-serif;letter-spacing:.04em;text-transform:uppercase}
  .alluvia-index p{color:#44515f;line-height:1.75;margin:0 0 12px}
  .alluvia-index .more{color:#0a8174;font-weight:600;text-decoration:none}
  .alluvia-index .pagination{margin-top:36px;display:flex;gap:8px;flex-wrap:wrap}
  .alluvia-index .pagination .page-numbers{border:1.5px solid #e8e0d2;border-radius:10px;min-width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;color:#0a1a27;font-family:'Space Grotesk',system-ui,sans-serif;font-weight:600}
  .alluvia-index .pagination .page-numbers.current,.alluvia-index .pagination a.page-numbers:hover{background:#0eaf9f;border-color:#0eaf9f}
</style>

<div class="alluvia-topbar">
  <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">Alluvia <span>Peptides</span></a>
  <a class="shop" href="<?php echo esc_url( alluvia_shop_url() ); ?>">Shop</a>
</div>

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

<?php get_footer( 'alluvia' ); ?>
