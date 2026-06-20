<?php
/**
 * Template Name: Alluvia – Blog Listing
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
.page-hero{background:linear-gradient(135deg,var(--navy),var(--navy-soft));padding:6rem 2rem 3rem;margin-top:72px;text-align:center}
.breadcrumb{display:flex;align-items:center;justify-content:center;gap:0.5rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:var(--text-light);margin-bottom:1rem}
.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:var(--font-display);font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.65);font-size:var(--fs-base);max-width:560px;margin:0 auto}
.blog-wrap{max-width:1200px;margin:0 auto;padding:3rem 2rem 4rem}
.cat-filter{display:flex;gap:0.6rem;justify-content:center;flex-wrap:wrap;margin-bottom:2.5rem}
.cat-pill{background:#fff;border:1px solid var(--pearl-dark);border-radius:50px;padding:0.5rem 1.25rem;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;color:var(--text-mid);cursor:pointer;transition:all .2s}
.cat-pill:hover{border-color:var(--teal);color:var(--teal-dark)}
.cat-pill.active{background:var(--navy);color:#fff;border-color:var(--navy)}
/* FEATURED */
.featured-post{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);display:grid;grid-template-columns:1.1fr 1fr;margin-bottom:3rem;cursor:pointer;text-decoration:none;color:inherit}
.featured-img{background:linear-gradient(135deg,var(--navy),var(--navy-soft));min-height:320px;display:flex;align-items:center;justify-content:center;position:relative}
.featured-img::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 50% 50%,rgba(14,175,159,0.15),transparent 70%)}
.featured-body{padding:2.5rem;display:flex;flex-direction:column;justify-content:center}
.post-cat{display:inline-flex;align-items:center;gap:0.3rem;font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--teal-dark);margin-bottom:0.75rem;width:fit-content;background:rgba(14,175,159,0.1);padding:3px 10px;border-radius:50px}
.featured-body h2{font-family:var(--font-display);font-size:30px;font-weight:600;line-height:1.2;margin-bottom:0.75rem}
.featured-body p{font-size:var(--fs-body);color:var(--text-mid);margin-bottom:1.25rem}
.post-meta{display:flex;align-items:center;gap:1rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:var(--text-light)}
.post-meta span{display:flex;align-items:center;gap:0.3rem}
.read-tag{display:inline-flex;align-items:center;gap:0.4rem;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;color:var(--teal-dark);margin-top:1.25rem}
/* GRID */
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.75rem}
.blog-card{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;text-decoration:none;color:inherit;display:flex;flex-direction:column}
.blog-card:hover{transform:translateY(-5px);box-shadow:0 12px 32px rgba(0,0,0,0.12)}
.blog-card-img{height:180px;display:flex;align-items:center;justify-content:center;position:relative}
.blog-card-body{padding:1.5rem;display:flex;flex-direction:column;flex:1}
.blog-card-body h3{font-family:var(--font-display);font-size:21px;font-weight:600;line-height:1.25;margin:0.5rem 0}
.blog-card-body p{font-size:var(--fs-body);color:var(--text-mid);margin-bottom:1rem;flex:1}
/* NEWSLETTER */
.newsletter{background:linear-gradient(135deg,var(--navy),var(--navy-soft));border-radius:var(--radius);padding:3rem;text-align:center;margin-top:3.5rem}
.newsletter h2{font-family:var(--font-display);font-size:32px;font-weight:600;color:#fff;margin-bottom:0.5rem}
.newsletter p{color:rgba(255,255,255,0.65);font-size:var(--fs-base);margin-bottom:1.5rem}
.newsletter-form{display:flex;gap:0.75rem;max-width:480px;margin:0 auto}
.newsletter-form input{flex:1;border:none;border-radius:8px;padding:0.85rem 1.25rem;font-family:var(--font-body);font-size:var(--fs-base);outline:none}
.newsletter-form button{background:var(--teal);color:var(--navy);border:none;border-radius:8px;padding:0.85rem 1.75rem;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:700;cursor:pointer;white-space:nowrap;transition:all .2s}
.newsletter-form button:hover{background:#fff}
/* PAGINATION */
.pagination{display:flex;justify-content:center;align-items:center;gap:0.5rem;margin-top:3rem}
.page-btn{width:40px;height:40px;border-radius:8px;border:1px solid var(--pearl-dark);background:#fff;font-family:var(--font-ui);font-weight:600;font-size:var(--fs-ui);color:var(--text-mid);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s}
.page-btn:hover{border-color:var(--teal);color:var(--teal)}
.page-btn.active{background:var(--navy);color:#fff;border-color:var(--navy)}
@media(max-width:900px){.featured-post{grid-template-columns:1fr}.featured-img{min-height:220px}.blog-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){
  .page-hero h1,.hero-title{font-size:clamp(36px,9vw,52px)!important}
  .section-title{font-size:clamp(28px,7vw,42px)!important}
  .featured-title,.post-title{font-size:clamp(24px,6vw,36px)!important}
  .product-title{font-size:clamp(28px,7vw,38px)!important}
  .section-desc,.post-lead,.featured-body{font-size:var(--fs-base)}
  body,p,.article p{font-size:var(--fs-base);line-height:1.75}
  .still-help h2,.newsletter h2,.cta-title{font-size:clamp(24px,6vw,36px)!important}
  .blog-grid{grid-template-columns:1fr}.newsletter-form{flex-direction:column}.featured-body{padding:1.5rem}}

@media(max-width:400px){
  .page-hero h1,.hero-title{font-size:32px!important}
  .section-title{font-size:26px!important}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="page-hero">
  <div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a><i data-lucide="chevron-right" width="14" height="14"></i><span>Blog</span></div>
  <h1>The Alluvia Journal</h1>
  <p>Peptide science, research insights, and longevity protocols — written for the curious and the rigorous.</p>
</div>

<div class="blog-wrap">
  <?php $b_filter_cats = get_categories( array( 'hide_empty' => true ) ); ?>
  <?php if ( ! empty( $b_filter_cats ) && ! is_wp_error( $b_filter_cats ) ) : ?>
  <div class="cat-filter">
    <a class="cat-pill<?php echo ( is_home() || is_front_page() ) ? ' active' : ''; ?>" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' ) ); ?>">All Articles</a>
    <?php foreach ( $b_filter_cats as $b_filter_cat ) : ?>
    <a class="cat-pill<?php echo is_category( $b_filter_cat->term_id ) ? ' active' : ''; ?>" href="<?php echo esc_url( get_category_link( $b_filter_cat ) ); ?>"><?php echo esc_html( $b_filter_cat->name ); ?></a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if ( have_posts() ) : $a_idx = 0; ?>
  <?php while ( have_posts() ) : the_post();
    $b_cats = get_the_category();
    $b_cat  = ( $b_cats && ! is_wp_error( $b_cats ) ) ? $b_cats[0]->name : 'Research';
    $b_read = max( 1, (int) round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
    if ( 0 === $a_idx ) : ?>
      <a href="<?php the_permalink(); ?>" class="featured-post">
        <div class="featured-img"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } else { ?><i data-lucide="microscope" width="90" height="90" style="color:var(--teal);position:relative;z-index:1"></i><?php } ?></div>
        <div class="featured-body">
          <span class="post-cat"><i data-lucide="flask-conical" width="11" height="11"></i> <?php echo esc_html( $b_cat ); ?> · Featured</span>
          <h2><?php the_title(); ?></h2>
          <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 36 ) ); ?></p>
          <div class="post-meta">
            <span><i data-lucide="user" width="13" height="13"></i> <?php $b_author = get_the_author(); echo esc_html( $b_author ? $b_author : 'Alluvia Research Team' ); ?></span>
            <span><i data-lucide="calendar" width="13" height="13"></i> <?php echo esc_html( get_the_date() ); ?></span>
            <span><i data-lucide="clock" width="13" height="13"></i> <?php echo (int) $b_read; ?> min read</span>
          </div>
          <span class="read-tag">Read Article <i data-lucide="arrow-right" width="15" height="15"></i></span>
        </div>
      </a>
      <div class="blog-grid">
    <?php else : ?>
      <a href="<?php the_permalink(); ?>" class="blog-card">
        <div class="blog-card-img"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); } else { ?><i data-lucide="flask-conical" width="48" height="48" style="color:var(--teal)"></i><?php } ?></div>
        <div class="blog-card-body">
          <span class="post-cat"><i data-lucide="book-open" width="11" height="11"></i> <?php echo esc_html( $b_cat ); ?></span>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
          <div class="post-meta"><span><i data-lucide="calendar" width="13" height="13"></i> <?php echo esc_html( get_the_date( 'M j' ) ); ?></span><span><i data-lucide="clock" width="13" height="13"></i> <?php echo (int) $b_read; ?> min</span></div>
        </div>
      </a>
    <?php endif; $a_idx++; endwhile; ?>
    </div><!-- /.blog-grid (always opened on the featured iteration) -->
    <div class="pagination"><?php echo paginate_links( array( 'mid_size' => 2, 'prev_text' => '‹', 'next_text' => '›' ) ); ?></div>
  <?php else : ?>
    <p style="text-align:center;padding:80px 20px;color:var(--text-light);font-family:var(--font-ui)">No articles published yet — check back soon.</p>
  <?php endif; ?>

  <?php if ( false ) : // legacy demo articles retained for design reference, not rendered ?>
  <!-- FEATURED -->
  <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="featured-post">
    <div class="featured-img"><i data-lucide="microscope" width="90" height="90" style="color:var(--teal);position:relative;z-index:1"></i></div>
    <div class="featured-body">
      <span class="post-cat"><i data-lucide="flask-conical" width="11" height="11"></i> Research · Featured</span>
      <h2>BPC-157 and the Science of Tissue Repair: What the Research Actually Says</h2>
      <p>A deep dive into the pentadecapeptide that has captured the attention of regenerative researchers worldwide — separating the peer-reviewed evidence from the hype.</p>
      <div class="post-meta">
        <span><i data-lucide="user" width="13" height="13"></i> Dr. Elena Voss</span>
        <span><i data-lucide="calendar" width="13" height="13"></i> June 8, 2025</span>
        <span><i data-lucide="clock" width="13" height="13"></i> 9 min read</span>
      </div>
      <span class="read-tag">Read Article <i data-lucide="arrow-right" width="15" height="15"></i></span>
    </div>
  </a>

  <!-- GRID -->
  <div class="blog-grid">
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="blog-card">
      <div class="blog-card-img" style="background:linear-gradient(135deg,rgba(219,98,122,0.12),rgba(219,98,122,0.04))"><i data-lucide="sparkles" width="48" height="48" style="color:var(--coral)"></i></div>
      <div class="blog-card-body">
        <span class="post-cat" style="color:#c0405a;background:rgba(219,98,122,0.1)"><i data-lucide="droplet" width="11" height="11"></i> Skincare</span>
        <h3>GHK-Cu: The Copper Peptide Rewriting Skincare Science</h3>
        <p>How a single tripeptide-copper complex became the most researched ingredient in regenerative dermatology.</p>
        <div class="post-meta"><span><i data-lucide="calendar" width="13" height="13"></i> Jun 4</span><span><i data-lucide="clock" width="13" height="13"></i> 6 min</span></div>
      </div>
    </a>
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="blog-card">
      <div class="blog-card-img" style="background:linear-gradient(135deg,rgba(212,102,60,0.12),rgba(212,102,60,0.04))"><i data-lucide="dumbbell" width="48" height="48" style="color:var(--orange)"></i></div>
      <div class="blog-card-body">
        <span class="post-cat" style="color:#a04020;background:rgba(212,102,60,0.1)"><i data-lucide="activity" width="11" height="11"></i> Recovery</span>
        <h3>TB-500 vs BPC-157: Understanding the Recovery Stack</h3>
        <p>Two of the most popular recovery peptides — how their mechanisms differ and why researchers study them together.</p>
        <div class="post-meta"><span><i data-lucide="calendar" width="13" height="13"></i> May 28</span><span><i data-lucide="clock" width="13" height="13"></i> 7 min</span></div>
      </div>
    </a>
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="blog-card">
      <div class="blog-card-img" style="background:linear-gradient(135deg,rgba(198,162,83,0.12),rgba(198,162,83,0.04))"><i data-lucide="hourglass" width="48" height="48" style="color:var(--gold)"></i></div>
      <div class="blog-card-body">
        <span class="post-cat" style="color:#a07c3a;background:rgba(198,162,83,0.1)"><i data-lucide="zap" width="11" height="11"></i> Anti-Aging</span>
        <h3>Epithalon and Telomerase: The Longevity Frontier</h3>
        <p>Exploring the research behind the peptide linked to telomere maintenance and cellular aging.</p>
        <div class="post-meta"><span><i data-lucide="calendar" width="13" height="13"></i> May 21</span><span><i data-lucide="clock" width="13" height="13"></i> 8 min</span></div>
      </div>
    </a>
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="blog-card">
      <div class="blog-card-img" style="background:linear-gradient(135deg,rgba(14,175,159,0.12),rgba(14,175,159,0.04))"><i data-lucide="droplets" width="48" height="48" style="color:var(--teal)"></i></div>
      <div class="blog-card-body">
        <span class="post-cat"><i data-lucide="book-open" width="11" height="11"></i> Guides</span>
        <h3>Peptide Reconstitution: A Complete Lab Guide</h3>
        <p>Step-by-step best practices for reconstituting, storing, and handling lyophilized peptides in a research setting.</p>
        <div class="post-meta"><span><i data-lucide="calendar" width="13" height="13"></i> May 15</span><span><i data-lucide="clock" width="13" height="13"></i> 5 min</span></div>
      </div>
    </a>
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="blog-card">
      <div class="blog-card-img" style="background:linear-gradient(135deg,rgba(138,96,193,0.12),rgba(138,96,193,0.04))"><i data-lucide="trending-down" width="48" height="48" style="color:var(--purple)"></i></div>
      <div class="blog-card-body">
        <span class="post-cat" style="color:#6b4a9c;background:rgba(138,96,193,0.1)"><i data-lucide="flask-conical" width="11" height="11"></i> Research</span>
        <h3>GLP-1 Peptides: The Metabolic Research Revolution</h3>
        <p>From Semaglutide to AOD-9604 — a look at the peptides reshaping metabolic science.</p>
        <div class="post-meta"><span><i data-lucide="calendar" width="13" height="13"></i> May 9</span><span><i data-lucide="clock" width="13" height="13"></i> 10 min</span></div>
      </div>
    </a>
    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="blog-card">
      <div class="blog-card-img" style="background:linear-gradient(135deg,rgba(106,166,198,0.12),rgba(106,166,198,0.04))"><i data-lucide="shield-check" width="48" height="48" style="color:var(--sky)"></i></div>
      <div class="blog-card-body">
        <span class="post-cat" style="color:#2d6e8a;background:rgba(106,166,198,0.1)"><i data-lucide="book-open" width="11" height="11"></i> Guides</span>
        <h3>How to Read a Certificate of Analysis (COA)</h3>
        <p>Understanding HPLC charts, mass spec data, and purity percentages so you can verify what you're buying.</p>
        <div class="post-meta"><span><i data-lucide="calendar" width="13" height="13"></i> May 2</span><span><i data-lucide="clock" width="13" height="13"></i> 6 min</span></div>
      </div>
    </a>
  </div>

  <div class="pagination">
    <button class="page-btn"><i data-lucide="chevron-left" width="16" height="16"></i></button>
    <button class="page-btn active">1</button>
    <button class="page-btn">2</button>
    <button class="page-btn">3</button>
    <button class="page-btn"><i data-lucide="chevron-right" width="16" height="16"></i></button>
  </div>
  <?php endif; // end legacy demo articles ?>

  <!-- NEWSLETTER -->
  <div class="newsletter">
    <h2>Stay Ahead of the Research</h2>
    <p>Get our monthly digest of peptide science and protocol updates.</p>
    <form class="newsletter-form" onsubmit="alluviaBlogSub(event)">
      <input type="email" placeholder="your@email.com" required>
      <button type="submit">Subscribe</button>
    </form>
    <script>
    function alluviaBlogSub(e){e.preventDefault();var f=e.target,b=f.querySelector('button'),i=f.querySelector('input[type=email]'),cfg=window.alluviaAjax||{};b.textContent='…';fetch(cfg.ajax_url||'/wp-admin/admin-ajax.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:new URLSearchParams({action:'alluvia_subscribe',nonce:cfg.sub_nonce||'',email:i.value})}).then(function(r){return r.json();}).then(function(res){var msg=(res&&res.data&&res.data.message)||'Subscribed!';if(typeof showToast==='function')showToast(msg);if(res&&res.success)i.value='';b.textContent='Subscribe';}).catch(function(){b.textContent='Subscribe';});}
    </script>
  </div>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>
<script>
lucide.createIcons();
function showToast(msg){const t=document.createElement('div');t.textContent=msg;Object.assign(t.style,{position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',background:'#0eaf9f',color:'#0a1a27',padding:'0.75rem 1.5rem',borderRadius:'50px',fontFamily:"var(--font-ui)",fontSize:'0.85rem',fontWeight:'600',zIndex:'9999',boxShadow:'0 8px 24px rgba(0,0,0,0.2)',transition:'opacity 0.3s'});document.body.appendChild(t);setTimeout(()=>{t.style.opacity='0';setTimeout(()=>t.remove(),300);},2200);}
</script>
<?php get_footer( 'alluvia' ); ?>
