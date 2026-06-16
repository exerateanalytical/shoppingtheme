<?php
/**
 * Template Name: Alluvia – Reviews
 *
 * Aggregates real WooCommerce product reviews. Each card links through to that
 * review on its product page (#comment-ID). Reviews carry lucide-icon reactions.
 *
 * @package Shopping
 */

$paged    = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$per_page = 18;

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
$reviews       = get_comments( $review_q );
$total_reviews = (int) get_comments( array_merge( $review_q, array( 'count' => true, 'number' => 0, 'offset' => 0 ) ) );
$total_pages   = (int) ceil( $total_reviews / $per_page );

add_action( 'wp_head', function () { ?>
<style>
.reviews-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:120px 0 56px;text-align:center}
.reviews-hero-inner{max-width:760px;margin:0 auto;padding:0 24px}
.reviews-hero h1{font-family:var(--font-display);font-size:clamp(34px,5vw,56px);font-weight:300;color:#fff;margin-bottom:14px}
.reviews-hero h1 em{font-style:italic;color:var(--teal)}
.reviews-hero p{color:rgba(255,255,255,.6);font-size:16px;line-height:1.7}
.reviews-wrap{max-width:1280px;margin:0 auto;padding:48px 40px 100px}
.reviews-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.review-card{background:#fff;border:1px solid var(--pearl-dark);border-radius:var(--radius-md);display:flex;flex-direction:column;overflow:hidden;transition:var(--transition)}
.review-card:hover{box-shadow:var(--shadow-md);transform:translateY(-3px);border-color:rgba(14,175,159,.25)}
.review-card-link{display:block;padding:22px 22px 6px;text-decoration:none;color:inherit;flex:1}
.review-head{display:flex;align-items:center;gap:12px;margin-bottom:12px}
.review-avatar{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));display:flex;align-items:center;justify-content:center;font-family:var(--font-ui);font-weight:700;font-size:15px;color:var(--navy);flex-shrink:0}
.review-meta{min-width:0}
.review-author{font-family:var(--font-ui);font-weight:600;font-size:14px;color:var(--navy)}
.review-date{font-size:12px;color:var(--text-light)}
.review-stars{display:flex;gap:2px;color:var(--gold);margin-bottom:8px}
.review-product{font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--teal-dark);margin-bottom:8px}
.review-text{font-size:14px;line-height:1.7;color:var(--text-mid);margin:0 0 12px}
.review-view{display:inline-flex;align-items:center;gap:5px;font-family:var(--font-ui);font-size:12px;font-weight:700;color:var(--teal-dark)}
.review-card-foot{padding:0 22px 18px}
.reviews-empty{grid-column:1/-1;text-align:center;padding:60px 20px;color:rgba(255,255,255,.7)}
.reviews-empty strong{display:block;font-size:22px;color:#fff;margin-bottom:8px;font-family:var(--font-display)}
.reviews-pagination{display:flex;justify-content:center;gap:8px;margin-top:44px}
.reviews-pagination a,.reviews-pagination span{min-width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;border-radius:var(--radius-sm);border:1.5px solid rgba(255,255,255,.18);font-family:var(--font-ui);font-weight:600;font-size:14px;color:rgba(255,255,255,.75);text-decoration:none;transition:var(--transition)}
.reviews-pagination a:hover{border-color:var(--teal);color:var(--teal)}
.reviews-pagination .current{background:var(--teal);border-color:var(--teal);color:var(--navy)}
@media(max-width:1024px){.reviews-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:680px){.reviews-wrap{padding:32px 20px 70px}.reviews-grid{grid-template-columns:1fr}}
</style>
<?php }, 20 );

get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<section class="reviews-hero">
  <div class="reviews-hero-inner">
    <h1>What researchers <em>say</em></h1>
    <p>Verified reviews from <?php echo esc_html( number_format_i18n( $total_reviews ) ); ?> purchases across our peptide catalogue. Tap any review to read it on the product page.</p>
  </div>
</section>

<div class="reviews-wrap">
  <div class="reviews-grid">
    <?php if ( $reviews ) : ?>
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
          <p class="review-text"><?php echo esc_html( wp_trim_words( $c->comment_content, 34 ) ); ?></p>
          <span class="review-view">Read on product <i data-lucide="arrow-right" style="width:13px;height:13px"></i></span>
        </a>
        <div class="review-card-foot">
          <?php alluvia_render_review_reactions( $c->comment_ID ); ?>
        </div>
      </article>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="reviews-empty">
        <strong>No reviews yet</strong>
        Be the first to review a product — your feedback appears here automatically.
      </div>
    <?php endif; ?>
  </div>

  <?php if ( $total_pages > 1 ) : ?>
  <nav class="reviews-pagination" aria-label="Reviews pages">
    <?php
    echo paginate_links( array(
        'total'     => $total_pages,
        'current'   => $paged,
        'type'      => 'list',
        'prev_text' => '‹',
        'next_text' => '›',
    ) );
    ?>
  </nav>
  <?php endif; ?>
</div>

<?php get_template_part( 'partials/footer-alluvia' ); ?>
<?php
// Reactions need lucide re-rendered + the reactions script also loads here.
get_footer( 'alluvia' );
