<?php
/**
 * Archive Template — blog category / tag / date / author archives
 * @package Shopping
 */
add_action( 'wp_head', function() { ?>
<style>
.archive-wrap { max-width: 1100px; margin: 0 auto; padding: 5.5rem 1.5rem 4rem; }
.archive-hero { background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%); padding: 80px 0 60px; margin-top: 72px; }
.archive-hero-inner { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
.archive-hero h1 { font-family: var(--font-display); font-size: clamp(32px,4vw,52px); font-weight: 300; color: #fff; margin-bottom: .5rem; }
.archive-hero h1 em { font-style: italic; color: var(--teal); }
.archive-hero p { color: rgba(255,255,255,.6); font-size: 16px; }
.archive-breadcrumb { display: flex; align-items: center; gap: 6px; font-family: var(--font-ui); font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.5); margin-bottom: 16px; }
.archive-breadcrumb a { color: rgba(255,255,255,.5); text-decoration: none; }
.archive-breadcrumb a:hover { color: var(--teal); }
.archive-layout { display: grid; grid-template-columns: 1fr 280px; gap: 48px; }
.post-grid { display: flex; flex-direction: column; gap: 32px; }
.post-card { background: #fff; border-radius: var(--radius-md); border: 1px solid var(--pearl-dark); overflow: hidden; transition: var(--transition); }
.post-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
.post-card-img { height: 220px; background: linear-gradient(135deg, var(--navy) 0%, var(--navy-soft) 100%); overflow: hidden; }
.post-card-img img { width: 100%; height: 100%; object-fit: cover; }
.post-card-body { padding: 24px; }
.post-meta { display: flex; align-items: center; gap: 12px; font-family: var(--font-ui); font-size: 12px; color: var(--text-light); margin-bottom: 10px; }
.post-meta a { color: var(--teal); text-decoration: none; font-weight: 600; }
.post-card-title { font-family: var(--font-display); font-size: clamp(20px,2vw,26px); font-weight: 600; color: var(--navy); line-height: 1.2; margin-bottom: 10px; }
.post-card-title a { color: inherit; text-decoration: none; }
.post-card-title a:hover { color: var(--teal); }
.post-excerpt { font-size: 15px; color: var(--text-mid); line-height: 1.7; }
.read-more { display: inline-flex; align-items: center; gap: 6px; margin-top: 16px; font-family: var(--font-ui); font-size: 13px; font-weight: 700; color: var(--teal); text-decoration: none; letter-spacing: .04em; text-transform: uppercase; }
.read-more:hover { color: var(--teal-dark); }
.archive-sidebar { position: sticky; top: 88px; align-self: start; display: flex; flex-direction: column; gap: 24px; }
.sidebar-widget { background: #fff; border-radius: var(--radius-md); padding: 24px; border: 1px solid var(--pearl-dark); }
.sidebar-widget h3 { font-family: var(--font-ui); font-size: 11px; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--navy); margin-bottom: 16px; }
.archive-pagination { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 48px; }
.archive-pagination .page-numbers { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px; border: 1.5px solid var(--pearl-dark); font-family: var(--font-ui); font-size: 13px; font-weight: 600; color: var(--text-mid); text-decoration: none; transition: var(--transition); }
.archive-pagination .page-numbers:hover { border-color: var(--teal); color: var(--teal); }
.archive-pagination .page-numbers.current { background: var(--navy); border-color: var(--navy); color: #fff; }
@media(max-width:860px) { .archive-layout { grid-template-columns: 1fr; } .archive-sidebar { position: static; } }
@media(max-width:600px) { .post-card-img { height: 180px; } }
</style>
<?php }, 20 );
get_header('alluvia');
?>
<?php get_template_part('partials/nav-alluvia'); ?>

<div class="archive-hero">
  <div class="archive-hero-inner">
    <div class="archive-breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <i data-lucide="chevron-right" style="width:10px;height:10px"></i>
      <span><?php
        if (is_category()) echo 'Category';
        elseif (is_tag()) echo 'Tag';
        elseif (is_author()) echo 'Author';
        elseif (is_date()) echo 'Archive';
        else echo 'Blog';
      ?></span>
    </div>
    <h1><?php
      if (is_category()) { echo 'Category: <em>'; single_cat_title(); echo '</em>'; }
      elseif (is_tag()) { echo 'Tag: <em>'; single_tag_title(); echo '</em>'; }
      elseif (is_author()) { echo 'Posts by <em>' . get_the_author() . '</em>'; }
      elseif (is_year()) { echo 'Year: <em>' . get_the_date('Y') . '</em>'; }
      elseif (is_month()) { echo 'Month: <em>' . get_the_date('F Y') . '</em>'; }
      else { echo 'Our <em>Blog</em>'; }
    ?></h1>
    <?php if (is_category() && category_description()) : ?>
      <p><?php echo category_description(); ?></p>
    <?php endif; ?>
  </div>
</div>

<div class="archive-wrap">
  <div class="archive-layout">
    <main>
      <?php if (have_posts()) : ?>
        <div class="post-grid">
          <?php while (have_posts()) : the_post(); ?>
          <article class="post-card">
            <?php if (has_post_thumbnail()) : ?>
            <div class="post-card-img">
              <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large', ['loading' => 'lazy']); ?></a>
            </div>
            <?php else : ?>
            <div class="post-card-img"></div>
            <?php endif; ?>
            <div class="post-card-body">
              <div class="post-meta">
                <?php the_category(', '); ?>
                <span><?php echo get_the_date(); ?></span>
                <span><?php echo get_the_author(); ?></span>
              </div>
              <h2 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 28); ?></p>
              <a href="<?php the_permalink(); ?>" class="read-more">Read More <i data-lucide="arrow-right" style="width:14px;height:14px"></i></a>
            </div>
          </article>
          <?php endwhile; ?>
        </div>
        <div class="archive-pagination">
          <?php echo paginate_links(['type' => 'list', 'prev_text' => '&larr;', 'next_text' => '&rarr;']); ?>
        </div>
      <?php else : ?>
        <div style="text-align:center;padding:60px 20px;color:var(--text-mid)">
          <p style="font-size:18px">No posts found.</p>
          <a href="<?php echo esc_url(home_url('/')); ?>" style="display:inline-block;margin-top:16px;color:var(--teal)">← Back to Home</a>
        </div>
      <?php endif; ?>
    </main>

    <aside class="archive-sidebar">
      <?php if (is_active_sidebar('blog-sidebar')) : ?>
        <?php dynamic_sidebar('blog-sidebar'); ?>
      <?php else : ?>
        <div class="sidebar-widget">
          <h3>Categories</h3>
          <ul style="list-style:none;display:flex;flex-direction:column;gap:4px">
            <?php wp_list_categories(['show_count' => true, 'title_li' => '', 'hide_empty' => false]); ?>
          </ul>
        </div>
        <div class="sidebar-widget">
          <h3>Recent Posts</h3>
          <ul style="list-style:none;display:flex;flex-direction:column;gap:10px">
            <?php $recent = get_posts(['numberposts' => 5]); foreach ($recent as $p) : ?>
            <li><a href="<?php echo get_permalink($p->ID); ?>" style="font-size:14px;color:var(--navy);text-decoration:none;font-weight:500"><?php echo esc_html($p->post_title); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
    </aside>
  </div>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>
<?php get_footer('alluvia'); ?>
