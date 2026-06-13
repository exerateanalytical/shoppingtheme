<?php
/**
 * Template Name: Alluvia – About
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
/* HERO */
.page-hero{position:relative;background:var(--navy);padding:160px 0 100px;overflow:hidden;text-align:center}
.page-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 50% 50%,rgba(14,175,159,.08) 0%,transparent 65%),radial-gradient(ellipse 40% 40% at 20% 80%,rgba(198,162,83,.06) 0%,transparent 50%)}
.page-hero-inner{position:relative;z-index:2;max-width:800px;margin:0 auto;padding:0 40px}
.breadcrumb{display:flex;align-items:center;gap:8px;justify-content:center;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:500;letter-spacing:.08em;color:rgba(255,255,255,.65);text-transform:uppercase;margin-bottom:28px}
.breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none;transition:color .25s}
.breadcrumb a:hover{color:var(--teal)}
.breadcrumb-sep{color:rgba(255,255,255,.35)}
.page-hero-label{display:inline-flex;align-items:center;gap:8px;background:rgba(14,175,159,.1);border:1px solid rgba(14,175,159,.25);border-radius:100px;padding:7px 16px;margin-bottom:24px;font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:var(--teal)}
.page-hero h1{font-family:var(--font-display);font-size:clamp(40px,6vw,80px);font-weight:300;line-height:1.05;color:var(--white);margin-bottom:24px}
.page-hero h1 em{font-style:italic;color:var(--teal)}
.page-hero h1 .gold{font-style:italic;color:var(--gold)}
.page-hero-desc{font-size:var(--fs-lead);font-weight:300;line-height:1.8;color:rgba(255,255,255,.7);max-width:600px;margin:0 auto}

/* SECTION COMMONS */
.section-title{font-family:var(--font-display);font-size:clamp(30px,4vw,52px);font-weight:300;line-height:1.1;color:var(--navy);margin-bottom:20px}
.section-title em{font-style:italic;color:var(--teal)}
.section-title .gold{font-style:italic;color:var(--gold)}
.section-desc{font-size:var(--fs-body);font-weight:300;line-height:1.85;color:var(--text-mid)}
.btn-outline{display:inline-flex;align-items:center;gap:10px;background:transparent;color:var(--navy);font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;padding:14px 30px;border-radius:100px;text-decoration:none;border:2px solid var(--navy);transition:var(--transition)}
.btn-outline:hover{background:var(--navy);color:var(--white)}

.reveal{opacity:0;transform:translateY(28px);transition:opacity .7s ease,transform .7s ease}
.reveal.reveal-done{opacity:1;transform:translateY(0)}
.reveal-delay-1{transition-delay:.1s}
.reveal-delay-2{transition-delay:.2s}
.reveal-delay-3{transition-delay:.3s}
.reveal-delay-4{transition-delay:.4s}
.reveal-delay-5{transition-delay:.5s}
.reveal-delay-6{transition-delay:.6s}

/* MISSION & VISION */
.mv-section{padding:100px 0;background:var(--white)}
.mv-grid{display:grid;grid-template-columns:1fr 1fr;gap:2px;border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-md)}
.mv-card{padding:64px 56px;position:relative;overflow:hidden}
.mv-card:first-child{background:var(--navy)}
.mv-card:last-child{background:var(--pearl)}
.mv-card::before{content:'';position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:rgba(14,175,159,.06)}
.mv-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:28px;position:relative;z-index:1}
.mv-card:first-child .mv-icon{background:rgba(14,175,159,.12);border:1px solid rgba(14,175,159,.2);color:var(--teal)}
.mv-card:last-child .mv-icon{background:rgba(198,162,83,.12);border:1px solid rgba(198,162,83,.2);color:var(--gold)}
.mv-label{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:.2em;text-transform:uppercase;margin-bottom:16px;position:relative;z-index:1}
.mv-card:first-child .mv-label{color:var(--teal)}
.mv-card:last-child .mv-label{color:var(--gold)}
.mv-title{font-family:var(--font-display);font-size:clamp(28px,3vw,42px);font-weight:300;line-height:1.1;margin-bottom:20px;position:relative;z-index:1}
.mv-card:first-child .mv-title{color:var(--white)}
.mv-card:last-child .mv-title{color:var(--navy)}
.mv-text{font-size:var(--fs-body);font-weight:300;line-height:1.85;position:relative;z-index:1}
.mv-card:first-child .mv-text{color:rgba(255,255,255,.70)}
.mv-card:last-child .mv-text{color:var(--text-mid)}

/* STORY TIMELINE */
.story-section{padding:100px 0;background:var(--pearl);position:relative;overflow:hidden}
.story-section::before{content:'STORY';position:absolute;font-family:var(--font-display);font-size:clamp(80px,15vw,200px);font-weight:700;color:rgba(10,26,39,.025);top:50%;left:50%;transform:translate(-50%,-50%);white-space:nowrap;pointer-events:none;user-select:none}
.story-header{text-align:center;max-width:640px;margin:0 auto 72px}
.timeline{position:relative;max-width:900px;margin:0 auto}
.timeline::before{content:'';position:absolute;left:50%;transform:translateX(-50%);top:0;bottom:0;width:1px;background:linear-gradient(to bottom,transparent,var(--teal),var(--gold),var(--teal),transparent)}
.timeline-item{display:grid;grid-template-columns:1fr 60px 1fr;gap:0;align-items:start;margin-bottom:64px}
.timeline-item:last-child{margin-bottom:0}
.timeline-content-l,.timeline-content-r{padding:0 40px}
.timeline-content-l{text-align:right}
.timeline-content-r{text-align:left}
.timeline-item:nth-child(even) .timeline-content-l{grid-column:3;order:3}
.timeline-item:nth-child(even) .timeline-dot-wrap{grid-column:2;order:2}
.timeline-item:nth-child(even) .timeline-content-r{grid-column:1;order:1;text-align:right}
.timeline-dot-wrap{display:flex;flex-direction:column;align-items:center;gap:8px}
.timeline-dot{width:48px;height:48px;border-radius:50%;background:var(--navy);border:3px solid var(--teal);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--teal);transition:var(--transition)}
.timeline-item:hover .timeline-dot{background:var(--teal);color:var(--navy);box-shadow:var(--shadow-glow)}
.timeline-year{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:.12em;color:var(--teal);text-align:center;white-space:nowrap}
.timeline-card{background:var(--white);border-radius:var(--radius-md);padding:28px 32px;border:1px solid var(--pearl-dark);transition:var(--transition);display:inline-block;width:100%}
.timeline-card:hover{border-color:rgba(14,175,159,.2);box-shadow:var(--shadow-md);transform:translateY(-4px)}
.timeline-card-title{font-family:var(--font-ui);font-size:15px;font-weight:700;color:var(--navy);margin-bottom:8px}
.timeline-card-text{font-size:var(--fs-body);color:var(--text-mid);line-height:1.7}

/* VALUES */
.values-section{padding:100px 0;background:var(--navy);position:relative;overflow:hidden}
.values-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 50% 60% at 100% 50%,rgba(14,175,159,.06) 0%,transparent 55%),radial-gradient(ellipse 40% 50% at 0% 30%,rgba(198,162,83,.04) 0%,transparent 50%);pointer-events:none}
.values-header{text-align:center;margin-bottom:72px}
.values-header .section-title{color:var(--white)}
.values-header .section-desc{color:rgba(255,255,255,.70);margin:0 auto;max-width:560px}
.values-header .section-label{justify-content:center}
.values-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.value-card{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.07);border-radius:var(--radius-md);padding:40px 32px;transition:var(--transition);position:relative;overflow:hidden}
.value-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--val-color,var(--teal));transform:scaleX(0);transform-origin:left;transition:transform .45s ease}
.value-card:hover::before{transform:scaleX(1)}
.value-card:hover{border-color:rgba(255,255,255,.15);transform:translateY(-6px);box-shadow:0 20px 50px rgba(0,0,0,.3)}
.value-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);transition:var(--transition);color:rgba(255,255,255,.6)}
.value-card:hover .value-icon{background:var(--val-color,var(--teal));border-color:var(--val-color,var(--teal));color:var(--navy)}
.value-title{font-family:var(--font-ui);font-size:16px;font-weight:600;color:var(--white);margin-bottom:12px}
.value-text{font-size:var(--fs-body);font-weight:300;color:rgba(255,255,255,.65);line-height:1.7;transition:color .3s}
.value-card:hover .value-text{color:rgba(255,255,255,.85)}

/* TEAM */
.team-section{padding:100px 0;background:var(--white)}
.team-header{text-align:center;margin-bottom:64px}
.team-header .section-desc{margin:0 auto;max-width:560px}
.team-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.team-card{background:var(--pearl);border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--pearl-dark);transition:var(--transition)}
.team-card:hover{border-color:rgba(14,175,159,.2);box-shadow:var(--shadow-md);transform:translateY(-6px)}
.team-photo{aspect-ratio:1;background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.team-photo-initials{font-family:var(--font-display);font-size:56px;font-weight:300;color:rgba(255,255,255,.15)}
.team-photo-ring{position:absolute;width:120px;height:120px;border-radius:50%;border:1px solid rgba(14,175,159,.2);animation:spin-slow 12s linear infinite}
.team-photo-ring-2{position:absolute;width:80px;height:80px;border-radius:50%;border:1px solid rgba(198,162,83,.15);animation:spin-slow 8s linear infinite reverse}
.team-info{padding:28px 24px}
.team-name{font-family:var(--font-ui);font-size:16px;font-weight:700;color:var(--navy);margin-bottom:4px}
.team-role{font-family:var(--font-ui);font-size:var(--fs-sm);font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:var(--teal);margin-bottom:14px}
.team-bio{font-size:var(--fs-body);color:var(--text-mid);line-height:1.7}

/* COMMITMENTS */
.commit-section{padding:100px 0;background:var(--pearl)}
.commit-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.commit-list{display:flex;flex-direction:column;gap:0;margin-top:40px}
.commit-item{display:flex;gap:20px;padding:24px 0;border-bottom:1px solid var(--pearl-dark);transition:var(--transition)}
.commit-item:first-child{padding-top:0}
.commit-item:last-child{border-bottom:none;padding-bottom:0}
.commit-item:hover{padding-left:8px}
.commit-icon{width:48px;height:48px;border-radius:12px;background:rgba(14,175,159,.08);border:1px solid rgba(14,175,159,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--teal);transition:var(--transition)}
.commit-item:hover .commit-icon{background:var(--teal);color:var(--navy);border-color:var(--teal)}
.commit-text-title{font-family:var(--font-ui);font-size:15px;font-weight:600;color:var(--navy);margin-bottom:6px}
.commit-text-desc{font-size:var(--fs-body);color:var(--text-mid);line-height:1.7}
.commit-visual{position:relative;border-radius:var(--radius-lg);background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);aspect-ratio:4/5;display:flex;align-items:center;justify-content:center;overflow:hidden}
.commit-visual-inner{display:flex;flex-direction:column;align-items:center;gap:20px;position:relative;z-index:2}
.commit-circle{width:160px;height:160px;border-radius:50%;border:2px solid rgba(14,175,159,.3);display:flex;align-items:center;justify-content:center;position:relative}
.commit-circle::before{content:'';position:absolute;width:130px;height:130px;border-radius:50%;border:1px solid rgba(198,162,83,.2);animation:spin-slow 16s linear infinite}
.commit-circle::after{content:'';position:absolute;width:100px;height:100px;border-radius:50%;background:rgba(14,175,159,.08)}
.commit-circle svg{position:relative;z-index:2;color:var(--teal)}
.commit-visual-text{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:600;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.65)}
.commit-badge{position:absolute;background:var(--teal);color:var(--navy);border-radius:12px;padding:14px 20px;font-family:var(--font-ui);font-size:var(--fs-xs);font-weight:700}
.commit-badge-top{top:24px;right:-16px}
.commit-badge-bot{bottom:32px;left:-16px}

/* CTA */
.cta-section{padding:100px 0;background:var(--navy);position:relative;overflow:hidden;text-align:center}
.cta-section::before{content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:700px;height:700px;border-radius:50%;background:radial-gradient(circle,rgba(14,175,159,.08) 0%,transparent 65%);pointer-events:none}
.cta-inner{position:relative;z-index:2;max-width:640px;margin:0 auto;padding:0 40px}
.cta-section .section-label{justify-content:center}
.cta-section .section-title{color:var(--white);font-size:clamp(32px,5vw,60px)}
.cta-section .section-desc{color:rgba(255,255,255,.70);margin:0 auto 44px}
.cta-actions{display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap}
.btn-primary-light{display:inline-flex;align-items:center;gap:10px;background:var(--teal);color:var(--navy);font-family:var(--font-ui);font-size:14px;font-weight:700;padding:15px 32px;border-radius:100px;text-decoration:none;transition:var(--transition)}
.btn-primary-light:hover{background:var(--teal-dark);transform:translateY(-3px);box-shadow:0 12px 40px rgba(14,175,159,.4)}
.btn-ghost-light{display:inline-flex;align-items:center;gap:10px;background:transparent;color:rgba(255,255,255,.75);font-family:var(--font-ui);font-size:14px;font-weight:500;padding:15px 28px;border-radius:100px;text-decoration:none;border:1px solid rgba(255,255,255,.2);transition:var(--transition)}
.btn-ghost-light:hover{border-color:rgba(255,255,255,.5);color:var(--white)}

/* FOOTER (page-specific) */
.footer-brand{display:flex;flex-direction:column;gap:20px}

@keyframes spin-slow{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
@keyframes dna-pulse{0%,100%{opacity:.4}50%{opacity:1}}

@media(max-width:1100px){
  .values-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:900px){
  .mv-grid{grid-template-columns:1fr}
  .commit-grid{grid-template-columns:1fr}
  .commit-visual{display:none}
  .timeline::before{left:28px;transform:none}
  .timeline-item{grid-template-columns:60px 1fr}
  .timeline-content-l{display:none}
  .timeline-dot-wrap{grid-column:1}
  .timeline-content-r{grid-column:2;text-align:left;padding:0 0 0 20px}
  .timeline-item:nth-child(even) .timeline-content-r{grid-column:2;order:2;text-align:left}
  .timeline-item:nth-child(even) .timeline-dot-wrap{grid-column:1;order:1}
  .timeline-item:nth-child(even) .timeline-content-l{display:none}
  .team-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
  .page-hero{padding:120px 0 60px}
  .page-hero-inner{padding:0 24px}
  .team-grid{grid-template-columns:1fr}
  .values-grid{grid-template-columns:1fr}
  .mv-card{padding:40px 28px}
  .cta-inner{padding:0 24px}
  .cta-actions{flex-direction:column;align-items:stretch}
  .btn-primary-light,.btn-ghost-light{justify-content:center}
}
@media(max-width:400px){
  .page-hero h1,.hero-title{font-size:32px!important}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>


<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <span class="breadcrumb-sep"><i data-lucide="chevron-right" style="width:12px;height:12px"></i></span>
      <span>About</span>
    </div>
    <div class="page-hero-label">
      <i data-lucide="dna" style="width:14px;height:14px"></i>
      Our Story
    </div>
    <h1>Built on <em>Biology</em>,<br>Delivered with <span class="gold">Precision</span></h1>
    <p class="page-hero-desc">We are scientists, researchers, and optimisers who believe the body's own chemical language holds the key to peak human performance.</p>
  </div>
</section>


<!-- MISSION & VISION -->
<section class="mv-section">
  <div class="container">
    <div class="mv-grid reveal">
      <div class="mv-card">
        <div class="mv-icon"><i data-lucide="target" class="icon-xl"></i></div>
        <div class="mv-label">Our Mission</div>
        <h2 class="mv-title">To Make Peptide<br>Science Accessible</h2>
        <p class="mv-text">Alluvia Peptides exists to close the gap between cutting-edge biochemical research and the people who need it most. We believe pharmaceutical-grade peptides should be available to everyone — not just research institutions — with the same rigorous quality controls, full documentation, and transparent sourcing that science demands.</p>
      </div>
      <div class="mv-card">
        <div class="mv-icon"><i data-lucide="eye" class="icon-xl"></i></div>
        <div class="mv-label">Our Vision</div>
        <h2 class="mv-title">A World of Informed<br>Human Optimisation</h2>
        <p class="mv-text">We envision a future where every person has access to the molecular tools their body needs to heal faster, age better, and perform at its peak — guided by data, not hype. Alluvia is building the infrastructure for that future: one verified peptide, one honest COA, and one educated customer at a time.</p>
      </div>
    </div>
  </div>
</section>


<!-- STORY TIMELINE -->
<section class="story-section">
  <div class="container">
    <div class="story-header reveal">
      <p class="section-label">How We Got Here</p>
      <h2 class="section-title">The Alluvia <em>Story</em></h2>
      <p class="section-desc">From a shared frustration with low-quality, undocumented peptides to building one of the most trusted sources in the industry — this is our journey.</p>
    </div>

    <div class="timeline">

      <div class="timeline-item reveal">
        <div class="timeline-content-l">
          <div class="timeline-card">
            <div class="timeline-card-title">The Problem Identified</div>
            <p class="timeline-card-text">Our founders — a biochemist and a sports physician — discovered that most peptide suppliers offered products with no purity data, inconsistent dosing, and zero traceability. The market was broken.</p>
          </div>
        </div>
        <div class="timeline-dot-wrap">
          <div class="timeline-dot"><i data-lucide="search" style="width:18px;height:18px"></i></div>
          <div class="timeline-year">2020</div>
        </div>
        <div class="timeline-content-r"></div>
      </div>

      <div class="timeline-item reveal reveal-delay-1">
        <div class="timeline-content-l"></div>
        <div class="timeline-dot-wrap">
          <div class="timeline-dot"><i data-lucide="flask-conical" style="width:18px;height:18px"></i></div>
          <div class="timeline-year">2021</div>
        </div>
        <div class="timeline-content-r">
          <div class="timeline-card">
            <div class="timeline-card-title">First Lab Partnerships</div>
            <p class="timeline-card-text">We secured relationships with three ISO-accredited synthesis facilities and an independent testing laboratory — establishing the quality chain that defines every Alluvia product to this day.</p>
          </div>
        </div>
      </div>

      <div class="timeline-item reveal reveal-delay-2">
        <div class="timeline-content-l">
          <div class="timeline-card">
            <div class="timeline-card-title">Launch &amp; First Products</div>
            <p class="timeline-card-text">Alluvia launched with seven foundational peptides, each accompanied by a full Certificate of Analysis. Within six months, we had served over 500 customers across 12 countries — all on organic reputation alone.</p>
          </div>
        </div>
        <div class="timeline-dot-wrap">
          <div class="timeline-dot"><i data-lucide="rocket" style="width:18px;height:18px"></i></div>
          <div class="timeline-year">2022</div>
        </div>
        <div class="timeline-content-r"></div>
      </div>

      <div class="timeline-item reveal reveal-delay-3">
        <div class="timeline-content-l"></div>
        <div class="timeline-dot-wrap">
          <div class="timeline-dot"><i data-lucide="layers" style="width:18px;height:18px"></i></div>
          <div class="timeline-year">2023</div>
        </div>
        <div class="timeline-content-r">
          <div class="timeline-card">
            <div class="timeline-card-title">Full Category Expansion</div>
            <p class="timeline-card-text">We expanded to all 8 peptide categories — skincare, collagen, sports, metabolic, anti-aging, hair growth, and research — bringing our catalogue to 50+ SKUs, each formulated by our in-house biochemistry team.</p>
          </div>
        </div>
      </div>

      <div class="timeline-item reveal reveal-delay-4">
        <div class="timeline-content-l">
          <div class="timeline-card">
            <div class="timeline-card-title">Today &amp; Beyond</div>
            <p class="timeline-card-text">Alluvia continues to grow as the benchmark for quality and transparency in the peptide industry. Our mission remains unchanged: make the science real, make it accessible, and make it verifiable.</p>
          </div>
        </div>
        <div class="timeline-dot-wrap">
          <div class="timeline-dot" style="background:var(--teal);border-color:var(--teal);color:var(--navy)"><i data-lucide="star" style="width:18px;height:18px;fill:var(--navy);stroke:none"></i></div>
          <div class="timeline-year">2025</div>
        </div>
        <div class="timeline-content-r"></div>
      </div>

    </div>
  </div>
</section>


<!-- VALUES -->
<section class="values-section">
  <div class="container">
    <div class="values-header">
      <p class="section-label">What Drives Us</p>
      <h2 class="section-title" style="color:var(--white)">Our Core <em>Values</em></h2>
      <p class="section-desc">Every decision at Alluvia — from supplier selection to dosage formulation — flows from these six principles.</p>
    </div>
    <div class="values-grid">
      <div class="value-card reveal" style="--val-color:#0eaf9f;">
        <div class="value-icon"><i data-lucide="shield-check" class="icon-lg"></i></div>
        <h3 class="value-title">Uncompromising Quality</h3>
        <p class="value-text">Every peptide is independently tested before it reaches you. If a batch fails our standards, it doesn't ship — full stop.</p>
      </div>
      <div class="value-card reveal reveal-delay-1" style="--val-color:#c6a253;">
        <div class="value-icon"><i data-lucide="eye" class="icon-lg"></i></div>
        <h3 class="value-title">Radical Transparency</h3>
        <p class="value-text">Every product page shows the full COA — purity percentage, lot number, and mass spec data. No proprietary blends, no hidden ingredients.</p>
      </div>
      <div class="value-card reveal reveal-delay-2" style="--val-color:#6aa6c6;">
        <div class="value-icon"><i data-lucide="book-open" class="icon-lg"></i></div>
        <h3 class="value-title">Science-Led Decisions</h3>
        <p class="value-text">We only carry peptides with substantial peer-reviewed research behind them. If the evidence doesn't support a product, we don't sell it.</p>
      </div>
      <div class="value-card reveal reveal-delay-3" style="--val-color:#d4663c;">
        <div class="value-icon"><i data-lucide="users" class="icon-lg"></i></div>
        <h3 class="value-title">Customer Education</h3>
        <p class="value-text">We publish protocols, dosage guides, and peer-reviewed references — because an informed customer is a safe and successful one.</p>
      </div>
      <div class="value-card reveal reveal-delay-4" style="--val-color:#8a60c1;">
        <div class="value-icon"><i data-lucide="leaf" class="icon-lg"></i></div>
        <h3 class="value-title">Responsible Sourcing</h3>
        <p class="value-text">Full supply chain traceability on every product — we know exactly where every peptide was synthesised, tested, and packaged.</p>
      </div>
      <div class="value-card reveal reveal-delay-5" style="--val-color:#58b488;">
        <div class="value-icon"><i data-lucide="heart-handshake" class="icon-lg"></i></div>
        <h3 class="value-title">Community First</h3>
        <p class="value-text">From forum support to personalised protocol advice from our team — we're here for every step of your peptide journey.</p>
      </div>
    </div>
  </div>
</section>


<!-- TEAM -->
<section class="team-section">
  <div class="container">
    <div class="team-header reveal">
      <p class="section-label">The People Behind Alluvia</p>
      <h2 class="section-title">Meet Our <em>Team</em></h2>
      <p class="section-desc">Scientists, clinicians, and optimisers who are customers before they're colleagues.</p>
    </div>
    <div class="team-grid">
      <div class="team-card reveal">
        <div class="team-photo">
          <div class="team-photo-ring"></div>
          <div class="team-photo-ring-2"></div>
          <span class="team-photo-initials">DR</span>
        </div>
        <div class="team-info">
          <div class="team-name">Dr. Rachel Osei</div>
          <div class="team-role">Chief Science Officer</div>
          <p class="team-bio">PhD in Biochemistry, 12 years in peptide synthesis research. Rachel oversees all formulation decisions and quality standards at Alluvia.</p>
        </div>
      </div>
      <div class="team-card reveal reveal-delay-1">
        <div class="team-photo">
          <div class="team-photo-ring"></div>
          <div class="team-photo-ring-2"></div>
          <span class="team-photo-initials">JM</span>
        </div>
        <div class="team-info">
          <div class="team-name">James Mercer</div>
          <div class="team-role">Co-Founder & CEO</div>
          <p class="team-bio">Former competitive athlete turned biohacker. James co-founded Alluvia after years of frustration with the lack of quality peptide suppliers in the market.</p>
        </div>
      </div>
      <div class="team-card reveal reveal-delay-2">
        <div class="team-photo">
          <div class="team-photo-ring"></div>
          <div class="team-photo-ring-2"></div>
          <span class="team-photo-initials">AL</span>
        </div>
        <div class="team-info">
          <div class="team-name">Dr. Amara Levi</div>
          <div class="team-role">Medical Advisor</div>
          <p class="team-bio">Sports medicine physician with a focus on regenerative therapies. Amara advises on protocols, dosing recommendations, and safety standards.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- COMMITMENTS -->
<section class="commit-section">
  <div class="container">
    <div class="commit-grid">
      <div>
        <div class="reveal">
          <p class="section-label">Our Promises</p>
          <h2 class="section-title">Quality You Can<br><em>Verify</em></h2>
          <p class="section-desc">Every commitment we make is backed by documentation you can check yourself — not marketing language.</p>
        </div>
        <div class="commit-list">
          <div class="commit-item reveal">
            <div class="commit-icon"><i data-lucide="file-check-2" class="icon-lg"></i></div>
            <div><div class="commit-text-title">COA on Every Product</div><p class="commit-text-desc">Third-party Certificate of Analysis with purity percentage, mass spec, and lot number — downloadable from every product page.</p></div>
          </div>
          <div class="commit-item reveal reveal-delay-1">
            <div class="commit-icon"><i data-lucide="thermometer-snowflake" class="icon-lg"></i></div>
            <div><div class="commit-text-title">Cold-Chain Guarantee</div><p class="commit-text-desc">Every order is packed with phase-change cooling media and tracked. If the cold-chain is broken in transit, we reship at no charge.</p></div>
          </div>
          <div class="commit-item reveal reveal-delay-2">
            <div class="commit-icon"><i data-lucide="rotate-ccw" class="icon-lg"></i></div>
            <div><div class="commit-text-title">Satisfaction Guarantee</div><p class="commit-text-desc">If you're not fully satisfied, we'll work with you on a resolution — replacement, credit, or refund. We stand behind every batch.</p></div>
          </div>
          <div class="commit-item reveal reveal-delay-3">
            <div class="commit-icon"><i data-lucide="headphones" class="icon-lg"></i></div>
            <div><div class="commit-text-title">Expert Support</div><p class="commit-text-desc">Real scientists available via live chat and email — not generic customer service. Protocol questions welcome.</p></div>
          </div>
        </div>
      </div>
      <div class="commit-visual reveal reveal-delay-2">
        <div class="commit-visual-inner">
          <div class="commit-circle">
            <i data-lucide="award" style="width:56px;height:56px;color:var(--teal);stroke-width:1.2"></i>
          </div>
          <p class="commit-visual-text">Quality Verified</p>
        </div>
        <div class="commit-badge commit-badge-top">98%+ Purity</div>
        <div class="commit-badge commit-badge-bot" style="background:var(--gold);">COA Guaranteed</div>
      </div>
    </div>
  </div>
</section>


<!-- CTA -->
<section class="cta-section">
  <div class="cta-inner">
    <p class="section-label">Ready to Start?</p>
    <h2 class="section-title">Explore the <span class="gold">Full Range</span></h2>
    <p class="section-desc">Browse all eight peptide categories — each product comes with COA, clear protocols, and expert support.</p>
    <div class="cta-actions">
      <a href="<?php echo esc_url(home_url('/')); ?>#categories" class="btn-primary-light">
        <i data-lucide="grid-2x2" class="icon-sm"></i>
        Browse All Products
      </a>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-ghost-light">
        <i data-lucide="message-circle" class="icon-sm"></i>
        Talk to an Expert
      </a>
    </div>
  </div>
</section>


<!-- FOOTER -->
<footer class="alluvia-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo">
          <svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/><circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/><circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div>
        </a>
        <p class="footer-desc">Pharmaceutical-grade bioactive peptides for performance, longevity, and beauty — backed by science, delivered with integrity.</p>
        <div class="footer-socials">
          <a href="#" class="social-btn" aria-label="Instagram"><i data-lucide="instagram" style="width:17px;height:17px"></i></a>
          <a href="#" class="social-btn" aria-label="Twitter"><i data-lucide="twitter" style="width:17px;height:17px"></i></a>
          <a href="#" class="social-btn" aria-label="Facebook"><i data-lucide="facebook" style="width:17px;height:17px"></i></a>
          <a href="#" class="social-btn" aria-label="YouTube"><i data-lucide="youtube" style="width:17px;height:17px"></i></a>
        </div>
      </div>
      <div>
        <h3 class="footer-col-title">Products</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url( alluvia_cat_url( 'medical-peptides' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Medical Peptides</a></li>
          <li><a href="<?php echo esc_url( alluvia_cat_url( 'skincare-peptides' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Skincare Peptides</a></li>
          <li><a href="<?php echo esc_url( alluvia_cat_url( 'collagen-peptides' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Collagen Peptides</a></li>
          <li><a href="<?php echo esc_url( alluvia_cat_url( 'sports-recovery' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Sports &amp; Recovery</a></li>
          <li><a href="<?php echo esc_url( alluvia_cat_url( 'hormone-anti-aging' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Hormone &amp; Anti-Aging</a></li>
        </ul>
      </div>
      <div>
        <h3 class="footer-col-title">Company</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>About Us</a></li>
          <li><a href="<?php echo esc_url( home_url( '/about/#science' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Our Science</a></li>
          <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Blog</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Contact</a></li>
        </ul>
      </div>
      <div>
        <h3 class="footer-col-title">Support</h3>
        <ul class="footer-links">
          <li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>FAQ</a></li>
          <li><a href="<?php echo esc_url( home_url( '/shipping-policy/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Shipping Info</a></li>
          <li><a href="<?php echo esc_url( home_url( '/shipping-policy/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Returns</a></li>
          <li><a href="<?php echo esc_url( alluvia_account_url() ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>My Account</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Alluvia Peptides. All rights reserved.</p>
      <div class="footer-bottom-links">
        <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>
        <a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms of Service</a>
        <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>
      </div>
    </div>
  </div>
</footer>

<script>
lucide.createIcons();

// Scroll Reveal
var ro=new IntersectionObserver(function(e){e.forEach(function(x){if(x.isIntersecting){x.target.classList.add('reveal-done');ro.unobserve(x.target);}});},{threshold:.1,rootMargin:'0px 0px -30px 0px'});
document.querySelectorAll('.reveal,.team-card,.value-card,.timeline-item').forEach(function(el){ro.observe(el);});
</script>
<?php get_footer( 'alluvia' ); ?>
