<?php
/**
 * Template Name: Alluvia – Reviews
 *
 * Aggregates real WooCommerce product reviews with a filter sidebar.
 * 3 columns x 3 rows per page (9), paginated. Each card links through to that
 * review on its product page (#comment-ID). Reviews carry lucide-icon reactions.
 *
 * @package Shopping
 */

$paged    = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$per_page = 9; // 3 columns x 3 rows

$rating_filter = isset( $_GET['rating'] ) ? max( 0, min( 5, (int) $_GET['rating'] ) ) : 0;
$cat_filter    = isset( $_GET['review_cat'] ) ? sanitize_title( wp_unslash( $_GET['review_cat'] ) ) : '';

// Per-star counts (drive the sidebar filter + summary average).
$star_counts = array();
for ( $s = 5; $s >= 1; $s-- ) {
    $star_counts[ $s ] = (int) get_comments( array(
        'post_type'  => 'product',
        'status'     => 'approve',
        'type'       => 'review',
        'count'      => true,
        'meta_query' => array( array( 'key' => 'rating', 'value' => $s, 'compare' => '=' ) ),
    ) );
}
$total_all = array_sum( $star_counts );
$avg       = 0;
if ( $total_all ) {
    $sum = 0;
    foreach ( $star_counts as $s => $c ) { $sum += $s * $c; }
    $avg = round( $sum / $total_all, 1 );
}

// Build the filtered review query.
$review_q = array(
    'post_type' => 'product',
    'status'    => 'approve',
    'type'      => 'review',
    'parent'    => 0,
    'number'    => $per_page,
    'offset'    => ( $paged - 1 ) * $per_page,
    'orderby'   => 'comment_date_gmt',
    'order'     => 'DESC',
);
if ( $rating_filter ) {
    $review_q['meta_query'] = array( array( 'key' => 'rating', 'value' => $rating_filter, 'compare' => '=' ) );
}
if ( $cat_filter ) {
    $cat_ids = get_posts( array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'tax_query'      => array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $cat_filter ) ),
    ) );
    $review_q['post__in'] = $cat_ids ? $cat_ids : array( 0 );
}

$reviews     = get_comments( $review_q );
$count_q     = array_merge( $review_q, array( 'count' => true, 'number' => 0, 'offset' => 0 ) );
$total_found = (int) get_comments( $count_q );
$total_pages = (int) ceil( $total_found / $per_page );

// Sidebar category list (only product cats that exist).
$uncat   = absint( get_option( 'default_product_cat' ) );
$cats    = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'orderby' => 'name', 'exclude' => $uncat ? array( $uncat ) : array() ) );
$base_url = get_permalink();

// Helper to build a filter URL preserving the other active filter.
$filter_url = function ( $args ) use ( $base_url ) {
    return esc_url( add_query_arg( $args, $base_url ) );
};

add_action( 'wp_head', function () { ?>
<style>
.reviews-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:120px 0 50px;text-align:center}
.reviews-hero-inner{max-width:760px;margin:0 auto;padding:0 24px}
.reviews-hero h1{font-family:var(--font-display);font-size:clamp(34px,5vw,56px);font-weight:300;color:#fff;margin-bottom:12px}
.reviews-hero h1 em{font-style:italic;color:var(--teal)}
.reviews-hero p{color:rgba(255,255,255,.6);font-size:16px;line-height:1.7}
/* layout: left sidebar + reviews */
.reviews-layout{max-width:1340px;margin:0 auto;padding:44px 40px 100px;display:grid;grid-template-columns:260px 1fr;gap:40px}
.reviews-sidebar{display:flex;flex-direction:column;gap:20px;position:sticky;top:80px;align-self:start}
.rv-card{background:#fff;border:1px solid var(--pearl-dark);border-radius:var(--radius-md);padding:20px}
.rv-card-title{font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--navy);margin-bottom:14px}
.rv-summary{text-align:center}
.rv-avg{font-family:var(--font-display);font-size:46px;font-weight:700;color:var(--navy);line-height:1}
.rv-avg-stars{display:flex;justify-content:center;gap:2px;color:var(--gold);margin:6px 0 4px}
.rv-avg-sub{font-family:var(--font-ui);font-size:12px;color:var(--text-light)}
.rv-filter{display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border-radius:var(--radius-sm);font-family:var(--font-ui);font-size:13px;font-weight:500;color:var(--text-dark);text-decoration:none;transition:background .2s}
.rv-filter:hover{background:var(--pearl)}
.rv-filter.active{background:rgba(14,175,159,.08);color:var(--teal-dark);font-weight:600}
.rv-filter .stars{display:flex;gap:1px;color:var(--gold)}
.rv-filter .rv-count{font-size:11px;background:var(--pearl-dark);border-radius:100px;padding:2px 7px;color:var(--text-light)}
.rv-reset{display:flex;align-items:center;justify-content:center;gap:7px;padding:11px;border-radius:var(--radius-sm);border:1.5px solid var(--pearl-dark);background:#fff;font-family:var(--font-ui);font-size:13px;font-weight:600;color:var(--text-mid);text-decoration:none;transition:.2s}
.rv-reset:hover{border-color:var(--navy);color:var(--navy)}
/* reviews grid: 3 columns */
.reviews-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.review-card{background:#fff;border:1px solid var(--pearl-dark);border-radius:var(--radius-md);display:flex;flex-direction:column;overflow:hidden;transition:var(--transition)}
.review-card:hover{box-shadow:var(--shadow-md);transform:translateY(-3px);border-color:rgba(14,175,159,.25)}
.review-card-link{display:block;padding:22px 22px 6px;text-decoration:none;color:inherit;flex:1}
.review-head{display:flex;align-items:center;gap:12px;margin-bottom:12px}
.review-avatar{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));display:flex;align-items:center;justify-content:center;font-family:var(--font-ui);font-weight:700;font-size:15px;color:var(--navy);flex-shrink:0}
.review-author{font-family:var(--font-ui);font-weight:600;font-size:14px;color:var(--navy)}
.review-date{font-size:12px;color:var(--text-light)}
.review-stars{display:flex;gap:2px;color:var(--gold);margin-bottom:8px}
.review-product{font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--teal-dark);margin-bottom:8px}
.review-text{font-size:14px;line-height:1.7;color:var(--text-mid);margin:0 0 12px}
.review-view{display:inline-flex;align-items:center;gap:5px;font-family:var(--font-ui);font-size:12px;font-weight:700;color:var(--teal-dark)}
.review-card-foot{padding:0 22px 18px}
.reviews-count-bar{grid-column:1/-1;font-family:var(--font-ui);font-size:13px;color:rgba(255,255,255,.6);margin-bottom:4px}
.reviews-count-bar strong{color:#fff}
.reviews-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:rgba(255,255,255,.7)}
.reviews-empty strong{display:block;font-size:22px;color:#fff;margin-bottom:8px;font-family:var(--font-display)}
.reviews-pagination{display:flex;justify-content:center;gap:8px;margin-top:44px}
.reviews-pagination .page-numbers{min-width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;border-radius:var(--radius-sm);border:1.5px solid rgba(255,255,255,.18);font-family:var(--font-ui);font-weight:600;font-size:14px;color:rgba(255,255,255,.75);text-decoration:none;transition:var(--transition);padding:0 6px;list-style:none}
.reviews-pagination a.page-numbers:hover{border-color:var(--teal);color:var(--teal)}
.reviews-pagination .page-numbers.current{background:var(--teal);border-color:var(--teal);color:var(--navy)}
.reviews-pagination ul{display:flex;gap:8px;list-style:none;margin:0;padding:0}
@media(max-width:1100px){.reviews-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){.reviews-layout{grid-template-columns:1fr;padding:32px 24px 80px}.reviews-sidebar{display:none}}
@media(max-width:560px){.reviews-grid{grid-template-columns:1fr}}
</style>
<?php }, 20 );

get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<section class="reviews-hero">
  <div class="reviews-hero-inner">
    <h1>What researchers <em>say</em></h1>
    <p>Verified reviews from <?php echo esc_html( number_format_i18n( $total_all ) ); ?> purchases across our peptide catalogue. Tap any review to read it on the product page.</p>
  </div>
</section>

<div class="reviews-layout">

  <!-- SIDEBAR -->
  <aside class="reviews-sidebar">
    <div class="rv-card rv-summary">
      <div class="rv-avg"><?php echo esc_html( $avg ? number_format( $avg, 1 ) : '—' ); ?></div>
      <div class="rv-avg-stars" aria-hidden="true">
        <?php for ( $s = 1; $s <= 5; $s++ ) : ?>
          <svg width="15" height="15" viewBox="0 0 24 24" fill="<?php echo $s <= round( $avg ) ? 'var(--gold)' : 'none'; ?>" stroke="var(--gold)" stroke-width="1.5"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
        <?php endfor; ?>
      </div>
      <div class="rv-avg-sub"><?php echo esc_html( number_format_i18n( $total_all ) ); ?> review<?php echo 1 === $total_all ? '' : 's'; ?></div>
    </div>

    <div class="rv-card">
      <div class="rv-card-title">Filter by Rating</div>
      <a href="<?php echo $filter_url( array( 'rating' => false, 'paged' => false ) ); ?>" class="rv-filter<?php echo ! $rating_filter ? ' active' : ''; ?>">All ratings <span class="rv-count"><?php echo esc_html( $total_all ); ?></span></a>
      <?php for ( $s = 5; $s >= 1; $s-- ) : ?>
      <a href="<?php echo $filter_url( array( 'rating' => $s, 'paged' => false ) ); ?>" class="rv-filter<?php echo $rating_filter === $s ? ' active' : ''; ?>">
        <span class="stars"><?php for ( $i = 1; $i <= 5; $i++ ) : ?><svg width="12" height="12" viewBox="0 0 24 24" fill="<?php echo $i <= $s ? 'var(--gold)' : 'none'; ?>" stroke="var(--gold)" stroke-width="1.5"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg><?php endfor; ?></span>
        <span class="rv-count"><?php echo esc_html( $star_counts[ $s ] ); ?></span>
      </a>
      <?php endfor; ?>
    </div>

    <?php if ( ! is_wp_error( $cats ) && $cats ) : ?>
    <div class="rv-card">
      <div class="rv-card-title">By Category</div>
      <a href="<?php echo $filter_url( array( 'review_cat' => false, 'paged' => false ) ); ?>" class="rv-filter<?php echo ! $cat_filter ? ' active' : ''; ?>">All products</a>
      <?php foreach ( $cats as $cat ) : ?>
      <a href="<?php echo $filter_url( array( 'review_cat' => $cat->slug, 'paged' => false ) ); ?>" class="rv-filter<?php echo $cat_filter === $cat->slug ? ' active' : ''; ?>"><?php echo esc_html( $cat->name ); ?></a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ( $rating_filter || $cat_filter ) : ?>
    <a href="<?php echo esc_url( $base_url ); ?>" class="rv-reset"><i data-lucide="rotate-ccw" style="width:14px;height:14px"></i> Clear filters</a>
    <?php endif; ?>
  </aside>

  <!-- REVIEWS -->
  <div class="reviews-grid">
    <?php if ( $reviews ) : ?>
      <p class="reviews-count-bar">Showing <strong><?php echo esc_html( count( $reviews ) ); ?></strong> of <strong><?php echo esc_html( $total_found ); ?></strong> reviews</p>
      <?php foreach ( $reviews as $c ) :
          $product_id = (int) $c->comment_post_ID;
          if ( get_post_status( $product_id ) !== 'publish' ) { continue; }
          $rating   = (int) get_comment_meta( $c->comment_ID, 'rating', true );
          $link     = get_comment_link( $c );
          $author   = $c->comment_author ? $c->comment_author : __( 'Anonymous', 'shopping' );
          $initials = strtoupper( mb_substr( $author, 0, 2 ) );
          $prod     = get_the_title( $product_id );
      ?>
      <article class="review-card">
        <a class="review-card-link" href="<?php echo esc_url( $link ); ?>">
          <div class="review-head">
            <div class="review-avatar"><?php echo esc_html( $initials ); ?></div>
            <div class="review-meta">
              <div class="review-author"><?php echo esc_html( $author ); ?></div>
              <div class="review-date"><?php echo esc_html( get_comment_date( '', $c ) ); ?></div>
            </div>
          </div>
          <?php if ( $rating ) : ?>
          <div class="review-stars" aria-label="<?php echo esc_attr( $rating ); ?> out of 5">
            <?php for ( $s = 1; $s <= 5; $s++ ) : ?>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="<?php echo $s <= $rating ? 'var(--gold)' : 'none'; ?>" stroke="var(--gold)" stroke-width="1.5"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
            <?php endfor; ?>
          </div>
          <?php endif; ?>
          <?php if ( $prod ) : ?><div class="review-product"><?php echo esc_html( $prod ); ?></div><?php endif; ?>
          <p class="review-text"><?php echo esc_html( wp_trim_words( $c->comment_content, 30 ) ); ?></p>
          <span class="review-view">Read on product <i data-lucide="arrow-right" style="width:13px;height:13px"></i></span>
        </a>
        <div class="review-card-foot">
          <?php alluvia_render_review_reactions( $c->comment_ID ); ?>
        </div>
      </article>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="reviews-empty">
        <strong>No reviews<?php echo ( $rating_filter || $cat_filter ) ? ' match this filter' : ' yet'; ?></strong>
        <?php echo ( $rating_filter || $cat_filter ) ? 'Try a different rating or category.' : 'Be the first to review a product — your feedback appears here automatically.'; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php if ( $total_pages > 1 ) : ?>
<nav class="reviews-pagination" aria-label="Reviews pages">
  <?php
  echo paginate_links( array(
      'base'      => add_query_arg( 'paged', '%#%', $base_url ),
      'format'    => '',
      'total'     => $total_pages,
      'current'   => $paged,
      'type'      => 'list',
      'prev_text' => '‹',
      'next_text' => '›',
      'add_args'  => array_filter( array(
          'rating'     => $rating_filter ? $rating_filter : null,
          'review_cat' => $cat_filter ? $cat_filter : null,
      ) ),
  ) );
  ?>
</nav>
<?php endif; ?>

<?php get_template_part( 'partials/footer-alluvia' ); ?>
<?php get_footer( 'alluvia' ); ?>
