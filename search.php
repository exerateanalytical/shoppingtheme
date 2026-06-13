<?php
/**
 * Search Results Template
 * @package Shopping
 */
add_action( 'wp_head', function() { ?>
<style>
.search-wrap { max-width: 1000px; margin: 0 auto; padding: 5.5rem 1.5rem 4rem; }
.search-hero { background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%); padding: 80px 0 60px; margin-top: 72px; }
.search-hero-inner { max-width: 1000px; margin: 0 auto; padding: 0 1.5rem; }
.search-hero h1 { font-family: var(--font-display); font-size: clamp(28px,3.5vw,44px); font-weight: 300; color: #fff; margin-bottom: 1.5rem; }
.search-hero h1 em { color: var(--teal); font-style: italic; }
.search-bar { display: flex; gap: 0; background: #fff; border-radius: 100px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,.2); max-width: 580px; }
.search-bar input { flex: 1; border: none; outline: none; padding: 16px 24px; font-family: var(--font-body); font-size: 16px; color: var(--text-dark); background: transparent; }
.search-bar button { background: linear-gradient(135deg,var(--teal),var(--teal-dark)); color: var(--navy); border: none; padding: 16px 28px; font-family: var(--font-ui); font-size: 14px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; cursor: pointer; transition: .3s; white-space: nowrap; }
.search-bar button:hover { background: var(--teal-dark); }
.search-count { font-family: var(--font-ui); font-size: 14px; color: var(--text-mid); margin-bottom: 32px; }
.search-count strong { color: var(--navy); }
.search-results { display: flex; flex-direction: column; gap: 24px; }
.result-card { background: #fff; border-radius: var(--radius-md); padding: 24px; border: 1px solid var(--pearl-dark); transition: var(--transition); }
.result-card:hover { box-shadow: var(--shadow-md); border-color: rgba(14,175,159,.25); }
.result-type { font-family: var(--font-ui); font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--teal); margin-bottom: 6px; }
.result-title { font-family: var(--font-display); font-size: 22px; font-weight: 600; color: var(--navy); margin-bottom: 8px; }
.result-title a { color: inherit; text-decoration: none; }
.result-title a:hover { color: var(--teal); }
.result-excerpt { font-size: 15px; color: var(--text-mid); line-height: 1.6; }
.result-meta { font-size: 13px; color: var(--text-light); margin-top: 10px; font-family: var(--font-ui); }
.no-results { text-align: center; padding: 60px 20px; }
.no-results h2 { font-family: var(--font-display); font-size: 32px; font-weight: 300; color: var(--navy); margin-bottom: 12px; }
.no-results p { color: var(--text-mid); font-size: 16px; margin-bottom: 24px; }
</style>
<?php }, 20 );
get_header('alluvia');
?>
<?php get_template_part('partials/nav-alluvia'); ?>

<div class="search-hero">
  <div class="search-hero-inner">
    <?php if (have_posts()) : ?>
      <h1>Results for <em><?php echo esc_html(get_search_query()); ?></em></h1>
    <?php else : ?>
      <h1>No results for <em><?php echo esc_html(get_search_query()); ?></em></h1>
    <?php endif; ?>
    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-bar">
      <input type="search" name="s" placeholder="Search peptides, research topics…" value="<?php echo esc_attr(get_search_query()); ?>" aria-label="Search">
      <button type="submit"><i data-lucide="search" style="width:16px;height:16px;display:inline-block;vertical-align:middle;margin-right:6px"></i>Search</button>
    </form>
  </div>
</div>

<div class="search-wrap">
  <?php if (have_posts()) : ?>
    <p class="search-count">Found <strong><?php echo $wp_query->found_posts; ?></strong> result<?php echo $wp_query->found_posts !== 1 ? 's' : ''; ?> for "<strong><?php echo esc_html(get_search_query()); ?></strong>"</p>
    <div class="search-results">
      <?php while (have_posts()) : the_post(); ?>
      <div class="result-card">
        <div class="result-type"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></div>
        <h2 class="result-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if (get_the_excerpt()) : ?>
          <p class="result-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
        <?php endif; ?>
        <div class="result-meta"><?php echo get_the_date(); ?> · <?php the_author(); ?></div>
      </div>
      <?php endwhile; ?>
    </div>
    <div style="margin-top:40px;text-align:center">
      <?php echo paginate_links(); ?>
    </div>
  <?php else : ?>
    <div class="no-results">
      <h2>Nothing found.</h2>
      <p>Try different keywords, or browse our peptide collection below.</p>
      <a href="<?php echo esc_url(function_exists('alluvia_shop_url') ? alluvia_shop_url() : home_url('/shop/')); ?>" class="alluvia-btn alluvia-btn-primary">Browse All Peptides</a>
    </div>
  <?php endif; ?>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>
<?php get_footer('alluvia'); ?>
