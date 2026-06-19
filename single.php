<?php
/**
 * Template Name: Alluvia – Blog Post
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
/* POST HERO */
.post-hero{background:linear-gradient(135deg,var(--navy),var(--navy-soft));padding:6rem 2rem 4rem;margin-top:72px}
.post-hero-inner{max-width:800px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:var(--text-light);margin-bottom:1.25rem}
.breadcrumb a{color:var(--teal);text-decoration:none}
.post-cat-tag{display:inline-flex;align-items:center;gap:0.35rem;background:rgba(14,175,159,0.12);color:var(--teal-dark);font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:0.08em;text-transform:uppercase;padding:4px 12px;border-radius:50px;margin-bottom:1rem}
.post-hero h1{font-family:var(--font-display);font-size:clamp(40px,5vw,68px);font-weight:600;color:#fff;line-height:1.2;margin-bottom:1.25rem}
.post-meta-bar{display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap}
.author-row{display:flex;align-items:center;gap:0.75rem}
.author-avatar{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));display:flex;align-items:center;justify-content:center;font-family:var(--font-ui);font-weight:700;color:var(--navy);font-size:var(--fs-ui)}
.author-name{font-family:var(--font-ui);font-weight:600;font-size:var(--fs-ui);color:#fff}
.author-title{font-size:var(--fs-xs);color:rgba(255,255,255,0.65)}
.meta-divider{width:1px;height:30px;background:rgba(255,255,255,0.15)}
.meta-item{display:flex;align-items:center;gap:0.35rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:rgba(255,255,255,0.65)}
.meta-item svg{color:var(--teal)}

/* LAYOUT */
.post-layout{max-width:1200px;margin:0 auto;padding:3.5rem 2rem 5rem;display:grid;grid-template-columns:1fr 300px;gap:3.5rem;align-items:start}

/* ARTICLE */
.article{}
.article-img{background:linear-gradient(135deg,var(--navy),var(--navy-soft));border-radius:var(--radius);height:340px;display:flex;align-items:center;justify-content:center;margin-bottom:2.5rem;position:relative;overflow:hidden}
.article-img::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 50% 50%,rgba(14,175,159,0.12),transparent 70%)}
.article p{font-size:var(--fs-body);line-height:1.9;margin-bottom:1.5rem}
.article h2{font-family:var(--font-display);font-size:28px;font-weight:600;margin:2.5rem 0 1rem}
.article h3{font-family:var(--font-ui);font-size:var(--fs-body);font-weight:700;margin:1.75rem 0 0.75rem}
.article ul,.article ol{padding-left:1.5rem;margin-bottom:1.5rem}
.article ul li,.article ol li{font-size:var(--fs-body);margin-bottom:0.5rem;line-height:1.8}
.article a{color:var(--teal-dark);text-decoration:none}
.article a:hover{text-decoration:underline}
.pull-quote{border-left:4px solid var(--teal);background:rgba(14,175,159,0.05);padding:1.5rem 1.75rem;border-radius:0 var(--radius) var(--radius) 0;margin:2rem 0}
.pull-quote p{font-family:var(--font-display);font-size:21px;font-style:italic;margin:0;line-height:1.6}
.pull-quote cite{display:block;font-family:var(--font-ui);font-size:var(--fs-ui);margin-top:0.5rem;font-style:normal}
.info-box{background:rgba(106,166,198,0.08);border:1px solid rgba(106,166,198,0.25);border-radius:var(--radius);padding:1.5rem;margin:2rem 0}
.info-box h4{font-family:var(--font-ui);font-size:var(--fs-sm);font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--sky);margin-bottom:0.75rem;display:flex;align-items:center;gap:0.4rem}
.info-box p{font-size:var(--fs-base);margin-bottom:0}
.warn-box{background:rgba(198,162,83,0.07);border:1px solid rgba(198,162,83,0.25);border-radius:var(--radius);padding:1.5rem;margin:2rem 0}
.warn-box h4{font-family:var(--font-ui);font-size:var(--fs-sm);font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--gold);margin-bottom:0.75rem;display:flex;align-items:center;gap:0.4rem}
.warn-box p{font-size:var(--fs-base);margin-bottom:0}

/* SHARE + TAGS */
.post-footer-bar{display:flex;align-items:center;justify-content:space-between;padding:1.5rem 0;border-top:1px solid var(--pearl-dark);margin-top:2.5rem;flex-wrap:wrap;gap:1rem}
.tags{display:flex;gap:0.5rem;flex-wrap:wrap}
.tag{background:var(--pearl);border-radius:50px;padding:4px 12px;font-family:var(--font-ui);font-size:var(--fs-xs);font-weight:600}
.share-row{display:flex;align-items:center;gap:0.75rem}
.share-label{font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600}
.share-btn{width:36px;height:36px;border-radius:8px;background:var(--pearl-dark);border:none;display:flex;align-items:center;justify-content:center;color:var(--text-mid);cursor:pointer;transition:all .2s}
.share-btn:hover{background:var(--teal);color:var(--navy)}

/* RELATED POSTS */
.related-posts{margin-top:3rem}
.related-posts h2{font-family:var(--font-display);font-size:24px;font-weight:600;margin-bottom:1.25rem}
.related-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
.rel-card{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,0.05);text-decoration:none;color:inherit;display:flex;flex-direction:column;transition:all .25s}
.rel-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,0.1)}
.rel-img{height:100px;display:flex;align-items:center;justify-content:center}
.rel-body{padding:1rem}
.rel-body h4{font-family:var(--font-ui);font-weight:600;font-size:var(--fs-ui);line-height:1.3}
.rel-meta{font-size:var(--fs-xs);color:var(--text-light);margin-top:0.4rem;display:flex;gap:0.5rem}

/* SIDEBAR */
.post-sidebar{position:sticky;top:90px;display:flex;flex-direction:column;gap:1.75rem}
.sidebar-card{background:#fff;border-radius:var(--radius);padding:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,0.06)}
.sidebar-card h4{font-family:var(--font-ui);font-size:var(--fs-sm);font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-dark);margin-bottom:1rem;display:flex;align-items:center;gap:0.4rem}
.sidebar-card h4 svg{color:var(--teal)}
.toc-links{list-style:none;display:flex;flex-direction:column;gap:0.25rem}
.toc-links a{display:block;font-size:var(--fs-ui);color:var(--text-mid);text-decoration:none;padding:0.35rem 0.5rem;border-radius:6px;border-left:2px solid transparent;transition:all .2s}
.toc-links a:hover,.toc-links a.active{color:var(--teal-dark);border-left-color:var(--teal);background:rgba(14,175,159,0.05)}
.sidebar-product{border:1px solid var(--pearl-dark);border-radius:10px;padding:1.25rem;text-decoration:none;color:inherit;display:block;transition:all .2s;margin-bottom:0.75rem}
.sidebar-product:hover{border-color:var(--teal);background:rgba(14,175,159,0.03)}
.sidebar-product:last-child{margin-bottom:0}
.sp-head{display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem}
.sp-icon{width:40px;height:40px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sp-name{font-family:var(--font-ui);font-weight:600;font-size:var(--fs-ui)}
.sp-price{font-family:var(--font-ui);font-weight:700;font-size:var(--fs-ui);color:var(--teal-dark)}
.sp-btn{display:block;width:100%;background:var(--navy);color:#fff;border:none;border-radius:6px;padding:0.45rem;font-family:var(--font-ui);font-size:var(--fs-xs);font-weight:600;cursor:pointer;margin-top:0.6rem;transition:background .2s}
.sp-btn:hover{background:var(--teal);color:var(--navy)}

@media(max-width:1000px){.post-layout{grid-template-columns:1fr}.post-sidebar{position:static}.related-grid{grid-template-columns:1fr 1fr}}
@media(max-width:900px){.post-layout{grid-template-columns:1fr}.post-sidebar{display:none}}
@media(max-width:640px){
  .post-hero h1{font-size:clamp(36px,9vw,52px)!important}
  .section-desc,.post-lead{font-size:var(--fs-base)}
  body,p,.article p{font-size:var(--fs-base);line-height:1.75}
  .post-meta-bar{gap:1rem}.meta-divider{display:none}.related-grid{grid-template-columns:1fr}}

@media(max-width:400px){
  .post-hero h1{font-size:32px!important}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<?php while ( have_posts() ) : the_post();
  $a_cats    = get_the_category();
  $a_catname = ( $a_cats && ! is_wp_error( $a_cats ) ) ? $a_cats[0]->name : 'Research';
  $a_author  = get_the_author();
  $a_parts   = preg_split( '/\s+/', trim( $a_author ) );
  $a_init    = strtoupper( mb_substr( $a_parts[0], 0, 1 ) . ( isset( $a_parts[1] ) ? mb_substr( $a_parts[1], 0, 1 ) : '' ) );
  $a_read    = max( 1, (int) round( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) );
  $a_bio     = get_the_author_meta( 'description' );
?>
<div class="post-hero">
  <div class="post-hero-inner">
    <div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a><i data-lucide="chevron-right" width="14" height="14"></i><a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a><i data-lucide="chevron-right" width="14" height="14"></i><span><?php the_title(); ?></span></div>
    <span class="post-cat-tag"><i data-lucide="flask-conical" width="11" height="11"></i> <?php echo esc_html( $a_catname ); ?></span>
    <h1><?php the_title(); ?></h1>
    <div class="post-meta-bar">
      <div class="author-row">
        <div class="author-avatar"><?php echo esc_html( $a_init ); ?></div>
        <div><div class="author-name"><?php echo esc_html( $a_author ); ?></div><div class="author-title"><?php echo esc_html( $a_bio ? $a_bio : 'Research Editor' ); ?></div></div>
      </div>
      <div class="meta-divider"></div>
      <span class="meta-item"><i data-lucide="calendar" width="14" height="14"></i> <?php echo esc_html( get_the_date() ); ?></span>
      <span class="meta-item"><i data-lucide="clock" width="14" height="14"></i> <?php echo (int) $a_read; ?> min read</span>
    </div>
  </div>
</div>

<div class="post-layout">
  <!-- ARTICLE -->
  <div class="article">
    <?php if ( has_post_thumbnail() ) : ?>
      <div class="article-img"><?php the_post_thumbnail( 'large' ); ?></div>
    <?php endif; ?>

    <div class="post-prose"><?php the_content(); ?></div>

    <?php if ( false ) : // legacy demo copy retained for design reference, not rendered ?>
    <div class="article-img">
      <i data-lucide="microscope" width="80" height="80" style="color:var(--teal);position:relative;z-index:1"></i>
    </div>

    <p>Few peptides have captured the imagination of the research community quite like BPC-157. Over the past two decades, it has appeared in hundreds of studies — many of them remarkable in scope — investigating everything from tendon healing to neuroprotection. Yet it remains poorly understood outside specialist circles, and a significant gap exists between what the data shows and how it's often described online.</p>
    <p>This article examines the peer-reviewed evidence on BPC-157's mechanisms and research findings, with the aim of giving researchers and informed readers an accurate picture of where the science actually stands.</p>

    <h2 id="what">What Is BPC-157?</h2>
    <p>BPC-157 is a synthetic pentadecapeptide — a chain of 15 amino acids — derived from a partial sequence of a cytoprotective protein found in human gastric juice. The full name, Body Protection Compound-157, reflects its origin: it was isolated in the 1990s by a research group studying endogenous compounds produced by the gastric mucosa.</p>
    <p>Unlike many peptide compounds, BPC-157 has demonstrated remarkable stability in gastric acid environments, an unusual property for a peptide that has attracted significant pharmacological interest. This stability has been proposed as a contributing factor to its observed effects in gastrointestinal mucosal research.</p>

    <div class="pull-quote">
      <p>"BPC-157 has consistently demonstrated dose-dependent cytoprotective and healing effects across diverse tissue models — a pattern of findings rare in peptide research."</p>
      <cite>— Sikiric et al., Journal of Physiology-Paris, 2018</cite>
    </div>

    <h2 id="mechanism">Proposed Mechanisms of Action</h2>
    <p>The literature proposes several distinct but potentially overlapping mechanisms through which BPC-157 may exert its observed effects in experimental models:</p>

    <h3>1. VEGFR2-Akt-eNOS Signaling</h3>
    <p>Among the most studied pathways is BPC-157's apparent interaction with the VEGFR2 (vascular endothelial growth factor receptor 2) pathway. Studies in rodent models suggest it upregulates VEGF expression, which in turn promotes angiogenesis — the formation of new blood vessels. This has been proposed as a central mechanism underlying observed effects on tissue healing, as adequate vascularization is fundamental to repair processes.</p>

    <h3>2. Nitric Oxide (NO) System Modulation</h3>
    <p>Several studies have identified BPC-157's interaction with the nitric oxide system. The peptide appears to influence both eNOS (endothelial) and nNOS (neuronal) nitric oxide synthase activity. Given NO's roles in vasodilation, neuroprotection, and gastrointestinal mucosal protection, this pathway may explain the breadth of BPC-157's observed activities across different tissue types.</p>

    <h3>3. Growth Hormone Receptor Upregulation</h3>
    <p>Research has demonstrated that BPC-157 appears to upregulate growth hormone (GH) receptor expression in fibroblasts — cells central to connective tissue repair. This finding provides a plausible mechanistic explanation for the accelerated tendon and ligament healing observed in animal models, as GH signalling drives fibroblast proliferation and collagen synthesis.</p>

    <div class="info-box">
      <h4><i data-lucide="info" width="14" height="14"></i> Research Context</h4>
      <p>The overwhelming majority of BPC-157 research has been conducted in rodent models (rats and mice). While animal model findings are valuable for hypothesis generation, they do not automatically translate to equivalent effects in humans. No large-scale, placebo-controlled human clinical trials have yet been published.</p>
    </div>

    <h2 id="findings">Key Research Findings</h2>
    <p>The body of published research on BPC-157 spans multiple organ systems and tissue types. Below is a structured summary of the primary areas of investigation:</p>

    <h3>Musculoskeletal and Connective Tissue</h3>
    <p>The most extensive body of research concerns tendon, ligament, and muscle healing. Studies in transected rat Achilles tendon models have shown BPC-157 administration to significantly accelerate tendon-to-bone healing compared to controls. Similar findings have been reported in studies of anterior cruciate ligament (ACL) injury models and rotator cuff transection.</p>
    <ul>
      <li>Achilles tendon transection models: accelerated collagen organization and vascularity</li>
      <li>Quadriceps tendon repair: improved tensile strength versus controls</li>
      <li>Muscle crush injury: reduced inflammatory infiltration, faster functional recovery</li>
    </ul>

    <h3>Gastrointestinal Protection</h3>
    <p>Given BPC-157's origin in gastric research, its GI protective properties are extensively documented. It has shown efficacy in models of NSAID-induced gastric lesions, inflammatory bowel disease, and intestinal fistula. Notably, it appears to protect the mucosa against damage from alcohol, stress, and various chemical agents.</p>

    <h3>Central Nervous System</h3>
    <p>More recent research has explored BPC-157 in neurological contexts, including models of dopaminergic disruption, traumatic brain injury, and spinal cord injury. Effects on dopamine and serotonin systems have been identified, and some studies suggest neuroprotective properties. This is an emerging area requiring significantly more research.</p>

    <div class="warn-box">
      <h4><i data-lucide="alert-triangle" width="14" height="14"></i> Important Disclaimer</h4>
      <p>All BPC-157 products sold by Alluvia Peptides are strictly for in vitro and laboratory research use. They are not approved for human use by the FDA or any equivalent regulatory body, and must not be administered to humans or animals. This article is for educational and research purposes only.</p>
    </div>

    <h2 id="storage">Storage and Handling for Researchers</h2>
    <p>Proper storage is critical to maintaining BPC-157's integrity for research purposes. Lyophilized BPC-157 is highly stable at −20°C and can be stored for 24+ months without significant degradation when kept away from moisture and light. Once reconstituted with bacteriostatic water, solutions should be stored at 2–8°C and used within 30 days.</p>

    <h2 id="conclusion">Summary</h2>
    <p>BPC-157's research profile is genuinely compelling — a consistent pattern of findings across multiple tissue types and animal models, with plausible mechanistic explanations. The challenge for the field is translating this preclinical evidence into controlled human trials. Until that work is done, BPC-157 remains a highly promising research compound rather than a validated therapeutic.</p>
    <p>For researchers seeking high-purity BPC-157 for in vitro or in vivo animal studies, Alluvia Peptides' offering is HPLC-verified at ≥99% purity with full COA documentation.</p>

    <?php endif; // end legacy demo copy ?>

    <div class="post-footer-bar">
      <div class="tags">
        <?php
        $a_tags = get_the_tags();
        if ( $a_tags && ! is_wp_error( $a_tags ) ) {
            foreach ( $a_tags as $a_tag ) {
                echo '<span class="tag">' . esc_html( $a_tag->name ) . '</span>';
            }
        } else {
            $a_cl = get_the_category();
            if ( $a_cl && ! is_wp_error( $a_cl ) ) {
                echo '<span class="tag">' . esc_html( $a_cl[0]->name ) . '</span>';
            }
        }
        ?>
      </div>
      <div class="share-row">
        <span class="share-label">Share</span>
        <button class="share-btn"><i data-lucide="twitter" width="15" height="15"></i></button>
        <button class="share-btn"><i data-lucide="linkedin" width="15" height="15"></i></button>
        <button class="share-btn"><i data-lucide="link" width="15" height="15"></i></button>
      </div>
    </div>

    <div class="related-posts">
      <h2>Related Articles</h2>
      <div class="related-grid">
        <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="rel-card">
          <div class="rel-img" style="background:linear-gradient(135deg,rgba(212,102,60,0.12),rgba(212,102,60,0.04))"><i data-lucide="dumbbell" width="36" height="36" style="color:var(--orange)"></i></div>
          <div class="rel-body"><h4>TB-500 vs BPC-157: Understanding the Recovery Stack</h4><div class="rel-meta"><span>May 28</span><span>·</span><span>7 min</span></div></div>
        </a>
        <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="rel-card">
          <div class="rel-img" style="background:linear-gradient(135deg,rgba(14,175,159,0.12),rgba(14,175,159,0.04))"><i data-lucide="droplets" width="36" height="36" style="color:var(--teal)"></i></div>
          <div class="rel-body"><h4>Peptide Reconstitution: A Complete Lab Guide</h4><div class="rel-meta"><span>May 15</span><span>·</span><span>5 min</span></div></div>
        </a>
      </div>
    </div>
  </div>

  <?php
  // Comments — renders comments.php when open or existing comments are present.
  if ( comments_open() || get_comments_number() ) {
    comments_template();
  }
  ?>

  <?php endwhile; ?>

  <!-- SIDEBAR -->
  <aside class="post-sidebar">
    <div class="sidebar-card">
      <h4><i data-lucide="list" width="14" height="14"></i> In This Article</h4>
      <ul class="toc-links">
        <li><a href="#what" class="active">What Is BPC-157?</a></li>
        <li><a href="#mechanism">Mechanisms of Action</a></li>
        <li><a href="#findings">Key Research Findings</a></li>
        <li><a href="#storage">Storage & Handling</a></li>
        <li><a href="#conclusion">Summary</a></li>
      </ul>
    </div>

    <div class="sidebar-card">
      <h4><i data-lucide="shopping-bag" width="14" height="14"></i> In This Article</h4>
      <a href="<?php echo esc_url(alluvia_shop_url()); ?>" class="sidebar-product">
        <div class="sp-head">
          <div class="sp-icon" style="background:rgba(14,175,159,0.1)"><i data-lucide="activity" width="20" height="20" style="color:var(--teal)"></i></div>
          <div><div class="sp-name">BPC-157 — 5 mg</div><div class="sp-price">$65.00 · ≥99% purity</div></div>
        </div>
        <button class="sp-btn">View Product</button>
      </a>
      <a href="<?php echo esc_url(alluvia_shop_url()); ?>" class="sidebar-product">
        <div class="sp-head">
          <div class="sp-icon" style="background:rgba(212,102,60,0.1)"><i data-lucide="dumbbell" width="20" height="20" style="color:var(--orange)"></i></div>
          <div><div class="sp-name">TB-500 — 5 mg</div><div class="sp-price">$78.00 · ≥98.5% purity</div></div>
        </div>
        <button class="sp-btn">View Product</button>
      </a>
    </div>

    <div class="sidebar-card" style="background:var(--navy)">
      <h4 style="color:rgba(255,255,255,0.7)"><i data-lucide="mail" width="14" height="14"></i> Research Digest</h4>
      <p style="font-size:var(--fs-base);color:rgba(255,255,255,0.65);margin-bottom:1rem">Monthly peptide science updates, new COA releases, and protocol guides.</p>
      <input type="email" placeholder="your@email.com" style="width:100%;border:1px solid rgba(255,255,255,0.15);border-radius:8px;padding:0.6rem 0.9rem;background:rgba(255,255,255,0.07);color:#fff;font-size:var(--fs-base);outline:none;font-family:var(--font-body);margin-bottom:0.6rem">
      <button onclick="showToast('Subscribed!')" style="width:100%;background:var(--teal);color:var(--navy);border:none;border-radius:8px;padding:0.6rem;font-family:var(--font-ui);font-weight:700;font-size:var(--fs-ui);cursor:pointer">Subscribe Free</button>
    </div>
  </aside>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>
<script>
lucide.createIcons();
function showToast(msg){const t=document.createElement('div');t.textContent=msg;Object.assign(t.style,{position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',background:'#0eaf9f',color:'#0a1a27',padding:'0.75rem 1.5rem',borderRadius:'50px',fontFamily:"var(--font-ui)",fontSize:'0.85rem',fontWeight:'600',zIndex:'9999',boxShadow:'0 8px 24px rgba(0,0,0,0.2)'});document.body.appendChild(t);setTimeout(()=>{t.style.opacity='0';setTimeout(()=>t.remove(),300);},2200);}
window.addEventListener('scroll',()=>{const links=document.querySelectorAll('.toc-links a');links.forEach(a=>{const sec=document.querySelector(a.getAttribute('href'));if(sec&&window.scrollY>=sec.offsetTop-140)links.forEach(x=>x.classList.remove('active'))&&a.classList.add('active');});});
document.querySelectorAll('.share-btn').forEach(b=>b.addEventListener('click',()=>showToast('Link copied!')));
</script>
<?php get_footer( 'alluvia' ); ?>
