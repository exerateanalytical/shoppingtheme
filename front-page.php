<?php
/**
 * Alluvia Peptides — Premium Landing Page Template
 *
 * @package Shopping
 */
get_header();
?>

<div class="alluvia-landing">

  <!-- ═══════════════════════════════════════
       NAVIGATION
  ═══════════════════════════════════════ -->
  <nav class="alluvia-nav" role="navigation" aria-label="Primary navigation">
    <div class="nav-inner">

      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
        <span class="nav-logo-word">Alluvia</span>
        <span class="nav-logo-sub">Peptides</span>
      </a>

      <ul class="nav-links">
        <li><a href="#categories">Products</a></li>
        <li><a href="#science">Science</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#testimonials">Reviews</a></li>
        <li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="nav-cta">Shop Now</a></li>
      </ul>

      <button class="nav-hamburger" aria-label="Open menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  <!-- Mobile Overlay -->
  <div class="mobile-nav-overlay" role="dialog" aria-modal="true" aria-label="Navigation menu">
    <button class="mobile-nav-close" aria-label="Close menu">&times;</button>
    <a href="#categories">Products</a>
    <a href="#science">Science</a>
    <a href="#about">About</a>
    <a href="#testimonials">Reviews</a>
    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Shop Now</a>
  </div>


  <!-- ═══════════════════════════════════════
       HERO
  ═══════════════════════════════════════ -->
  <section class="hero" id="hero" aria-label="Hero">
    <canvas id="hero-canvas" aria-hidden="true"></canvas>
    <div class="hero-gradient" aria-hidden="true"></div>

    <div class="hero-inner">
      <!-- Left Content -->
      <div class="hero-content">
        <div class="hero-badge">
          <span class="hero-badge-dot" aria-hidden="true"></span>
          <span class="hero-badge-text">Bioactive Peptide Science</span>
        </div>

        <h1 class="hero-title">
          Science That Makes<br>
          You <em class="hero-typewriter">Younger</em>
        </h1>

        <p class="hero-desc">
          Alluvia Peptides delivers pharmaceutical-grade bioactive peptides backed by
          peer-reviewed research — formulated for real, measurable results in skin,
          body, and longevity.
        </p>

        <div class="hero-actions">
          <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary">
            Explore Products
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
              <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </a>
          <a href="#science" class="btn-ghost">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
              <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.2"/>
              <path d="M6 10l4-4M6 6h4v4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            Our Science
          </a>
        </div>

        <div class="hero-stats">
          <div class="stat-item">
            <span class="stat-number"><span data-count="98" data-suffix="%"></span><span>%</span></span>
            <span class="stat-label">Purity Grade</span>
          </div>
          <div class="stat-item">
            <span class="stat-number"><span data-count="8"></span></span>
            <span class="stat-label">Categories</span>
          </div>
          <div class="stat-item">
            <span class="stat-number"><span data-count="50">50</span><span>+</span></span>
            <span class="stat-label">Active Peptides</span>
          </div>
        </div>
      </div>

      <!-- Right Visual -->
      <div class="hero-visual" aria-hidden="true">
        <div class="hero-molecule">
          <div class="molecule-ring"></div>
          <div class="molecule-ring"></div>
          <div class="molecule-ring"></div>
          <div class="molecule-core">
            <div class="molecule-core-icon">🧬</div>
            <div class="molecule-core-label">Bioactive</div>
          </div>
        </div>

        <div class="hero-floating-cards">
          <div class="hero-card-float">
            <div class="float-card-icon">✓</div>
            <div class="float-card-text">
              <span class="float-card-title">Lab Certified</span>
              <span class="float-card-sub">COA Available</span>
            </div>
          </div>
          <div class="hero-card-float">
            <div class="float-card-icon">🔬</div>
            <div class="float-card-text">
              <span class="float-card-title">98%+ Purity</span>
              <span class="float-card-sub">HPLC Verified</span>
            </div>
          </div>
          <div class="hero-card-float">
            <div class="float-card-icon">⚡</div>
            <div class="float-card-text">
              <span class="float-card-title">Fast Shipping</span>
              <span class="float-card-sub">Cold-Chain Packed</span>
            </div>
          </div>
        </div>
      </div>
    </div><!-- .hero-inner -->
  </section>


  <!-- ═══════════════════════════════════════
       TRUST STRIP
  ═══════════════════════════════════════ -->
  <div class="trust-strip" role="complementary" aria-label="Certifications">
    <div class="trust-strip-inner">
      <div class="trust-item">
        <span class="trust-icon" aria-hidden="true">🏭</span>
        <span class="trust-text">GMP Manufactured</span>
      </div>
      <div class="trust-item">
        <span class="trust-icon" aria-hidden="true">🔬</span>
        <span class="trust-text">HPLC Tested</span>
      </div>
      <div class="trust-item">
        <span class="trust-icon" aria-hidden="true">📋</span>
        <span class="trust-text">COA on Every Batch</span>
      </div>
      <div class="trust-item">
        <span class="trust-icon" aria-hidden="true">🌿</span>
        <span class="trust-text">No Fillers</span>
      </div>
      <div class="trust-item">
        <span class="trust-icon" aria-hidden="true">🚚</span>
        <span class="trust-text">Cold-Chain Shipping</span>
      </div>
      <div class="trust-item">
        <span class="trust-icon" aria-hidden="true">💊</span>
        <span class="trust-text">Pharmaceutical Grade</span>
      </div>
    </div>
  </div>


  <!-- ═══════════════════════════════════════
       ABOUT / BRAND STORY
  ═══════════════════════════════════════ -->
  <section class="about-section" id="about" aria-label="About Alluvia">
    <div class="container">
      <div class="about-grid">

        <!-- Visual -->
        <div class="about-visual reveal">
          <div class="about-image-wrap">
            <div class="about-image-placeholder">
              <div class="about-dna-visual" aria-hidden="true">
                <div class="dna-strand"></div>
              </div>
            </div>
          </div>
          <div class="about-accent-card reveal reveal-delay-2">
            <div class="about-accent-number">8</div>
            <div class="about-accent-text">Peptide Categories</div>
          </div>
        </div>

        <!-- Content -->
        <div class="about-content">
          <div class="reveal">
            <p class="section-label">Our Story</p>
            <h2 class="section-title">
              Built on <em>Biology</em>,<br>
              Delivered with <span class="gold">Precision</span>
            </h2>
          </div>

          <p class="section-desc reveal reveal-delay-1">
            Alluvia Peptides was founded on a simple belief: your body already knows how
            to heal, regenerate, and perform — it just needs the right molecular signals.
            We source, synthesize, and deliver the world's most studied bioactive peptides
            directly to you, with zero compromise on quality.
          </p>

          <ul class="about-list reveal reveal-delay-2">
            <li>
              <span class="about-list-check" aria-hidden="true">✓</span>
              Every product is independently tested and comes with a Certificate of Analysis
            </li>
            <li>
              <span class="about-list-check" aria-hidden="true">✓</span>
              Formulated by biochemists, not marketers — doses that actually work
            </li>
            <li>
              <span class="about-list-check" aria-hidden="true">✓</span>
              Transparent sourcing with full supply chain traceability
            </li>
            <li>
              <span class="about-list-check" aria-hidden="true">✓</span>
              Cold-chain preserved and shipped to maintain structural integrity
            </li>
          </ul>

          <div class="reveal reveal-delay-3">
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>" class="btn-primary" style="display:inline-flex; background: var(--navy); color: var(--white);">
              Read Our Story
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════════
       CATEGORIES
  ═══════════════════════════════════════ -->
  <section class="categories-section" id="categories" aria-label="Product categories">
    <div class="container">

      <div class="categories-header">
        <p class="section-label">What We Offer</p>
        <h2 class="section-title">
          Eight Pathways to<br><em>Peak Performance</em>
        </h2>
        <p class="section-desc">
          From cellular repair to hormonal balance — Alluvia covers every dimension of
          human optimisation with purpose-built peptide formulations.
        </p>
      </div>

      <div class="categories-grid" role="list">

        <!-- 1 Medical -->
        <article class="cat-card reveal" style="--cat-color:#00c6b3;" role="listitem">
          <div class="cat-number" aria-hidden="true">01</div>
          <div class="cat-icon-wrap" aria-hidden="true">💊</div>
          <h3 class="cat-name">Medical Peptides</h3>
          <p class="cat-desc">Therapeutic-grade peptides designed for healing, immune modulation, and systemic recovery under clinical guidance.</p>
          <a href="<?php echo esc_url( get_term_link( 'medical-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Medical Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

        <!-- 2 Skincare -->
        <article class="cat-card reveal reveal-delay-1" style="--cat-color:#c8a96e;" role="listitem">
          <div class="cat-number" aria-hidden="true">02</div>
          <div class="cat-icon-wrap" aria-hidden="true">✨</div>
          <h3 class="cat-name">Skincare Peptides</h3>
          <p class="cat-desc">Signal peptides that stimulate collagen synthesis, reduce fine lines, and restore youthful skin architecture at the cellular level.</p>
          <a href="<?php echo esc_url( get_term_link( 'skincare-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Skincare Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

        <!-- 3 Collagen -->
        <article class="cat-card reveal reveal-delay-2" style="--cat-color:#7fb8d4;" role="listitem">
          <div class="cat-number" aria-hidden="true">03</div>
          <div class="cat-icon-wrap" aria-hidden="true">🦴</div>
          <h3 class="cat-name">Collagen Peptides</h3>
          <p class="cat-desc">Hydrolysed collagen fractions that support joint integrity, connective tissue health, and skin density from within.</p>
          <a href="<?php echo esc_url( get_term_link( 'collagen-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Collagen Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

        <!-- 4 Sports -->
        <article class="cat-card reveal reveal-delay-3" style="--cat-color:#e07b54;" role="listitem">
          <div class="cat-number" aria-hidden="true">04</div>
          <div class="cat-icon-wrap" aria-hidden="true">⚡</div>
          <h3 class="cat-name">Sports & Recovery</h3>
          <p class="cat-desc">Performance peptides that accelerate muscle repair, reduce DOMS, and enhance endurance for serious athletes.</p>
          <a href="<?php echo esc_url( get_term_link( 'sports-recovery-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Sports Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

        <!-- 5 Weight-loss -->
        <article class="cat-card reveal reveal-delay-4" style="--cat-color:#9b72cf;" role="listitem">
          <div class="cat-number" aria-hidden="true">05</div>
          <div class="cat-icon-wrap" aria-hidden="true">🔥</div>
          <h3 class="cat-name">Weight-Loss & Metabolic</h3>
          <p class="cat-desc">Metabolic peptides that modulate appetite, enhance fat oxidation, and improve insulin sensitivity for body recomposition.</p>
          <a href="<?php echo esc_url( get_term_link( 'weight-loss-metabolic-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Weight-Loss Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

        <!-- 6 Hormone & Anti-aging -->
        <article class="cat-card reveal reveal-delay-5" style="--cat-color:#c8a96e;" role="listitem">
          <div class="cat-number" aria-hidden="true">06</div>
          <div class="cat-icon-wrap" aria-hidden="true">⏳</div>
          <h3 class="cat-name">Hormone & Anti-Aging</h3>
          <p class="cat-desc">Longevity peptides that support GH secretion, regulate cortisol, and activate cellular regeneration pathways for graceful ageing.</p>
          <a href="<?php echo esc_url( get_term_link( 'hormone-anti-aging-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Anti-Aging Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

        <!-- 7 Hair Growth -->
        <article class="cat-card reveal reveal-delay-6" style="--cat-color:#78c9a2;" role="listitem">
          <div class="cat-number" aria-hidden="true">07</div>
          <div class="cat-icon-wrap" aria-hidden="true">🌱</div>
          <h3 class="cat-name">Hair Growth Peptides</h3>
          <p class="cat-desc">Follicle-activating peptides that extend the anagen phase, reduce miniaturisation, and restore visible hair density.</p>
          <a href="<?php echo esc_url( get_term_link( 'hair-growth-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Hair Growth Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

        <!-- 8 Research -->
        <article class="cat-card reveal reveal-delay-7" style="--cat-color:#00c6b3;" role="listitem">
          <div class="cat-number" aria-hidden="true">08</div>
          <div class="cat-icon-wrap" aria-hidden="true">🔬</div>
          <h3 class="cat-name">Research Peptides</h3>
          <p class="cat-desc">High-purity peptide standards for in-vitro and laboratory research, supplied with full analytical documentation.</p>
          <a href="<?php echo esc_url( get_term_link( 'research-peptides', 'product_cat' ) ); ?>" class="cat-arrow" aria-label="Shop Research Peptides">
            Shop Category
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </article>

      </div><!-- .categories-grid -->
    </div>
  </section>


  <!-- ═══════════════════════════════════════
       STATS
  ═══════════════════════════════════════ -->
  <section class="stats-section" aria-label="Key statistics">
    <div class="container">
      <div class="stats-grid">
        <div class="stats-item">
          <div class="stats-num teal">
            <span data-count="98" data-suffix="%">98%</span>
          </div>
          <div class="stats-label">Average Purity</div>
        </div>
        <div class="stats-item">
          <div class="stats-num">
            <span data-count="50" data-suffix="+">50+</span>
          </div>
          <div class="stats-label">Peptide SKUs</div>
        </div>
        <div class="stats-item">
          <div class="stats-num gold">
            <span data-count="100" data-suffix="%">100%</span>
          </div>
          <div class="stats-label">COA Documented</div>
        </div>
        <div class="stats-item">
          <div class="stats-num teal">
            <span data-count="24" data-suffix="h">24h</span>
          </div>
          <div class="stats-label">Dispatch Time</div>
        </div>
      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════════
       SCIENCE / PROCESS
  ═══════════════════════════════════════ -->
  <section class="science-section" id="science" aria-label="Our science">
    <div class="container">
      <div class="science-grid">

        <!-- Process -->
        <div>
          <div class="reveal">
            <p class="section-label">Our Process</p>
            <h2 class="section-title">
              Precision at Every<br><em>Step</em>
            </h2>
            <p class="section-desc">
              From synthesis to your door, Alluvia maintains a rigorous quality chain
              that no shortcut can bypass.
            </p>
          </div>

          <div class="process-steps">
            <div class="process-step">
              <div class="process-step-line">
                <div class="process-step-num">01</div>
                <div class="process-step-connector"></div>
              </div>
              <div class="process-step-content">
                <h4 class="process-step-title">Synthesis & Sourcing</h4>
                <p class="process-step-text">Peptides are synthesised using solid-phase peptide synthesis (SPPS) in cGMP-compliant facilities, ensuring sequence accuracy and minimal impurities.</p>
              </div>
            </div>

            <div class="process-step">
              <div class="process-step-line">
                <div class="process-step-num">02</div>
                <div class="process-step-connector"></div>
              </div>
              <div class="process-step-content">
                <h4 class="process-step-title">Independent Laboratory Testing</h4>
                <p class="process-step-text">Every batch is tested by a third-party ISO-accredited laboratory using HPLC, mass spectrometry, and microbiological screening before release.</p>
              </div>
            </div>

            <div class="process-step">
              <div class="process-step-line">
                <div class="process-step-num">03</div>
                <div class="process-step-connector"></div>
              </div>
              <div class="process-step-content">
                <h4 class="process-step-title">Cold-Chain Preservation</h4>
                <p class="process-step-text">Lyophilised peptides are sealed under inert atmosphere, stored at -20°C, and shipped in temperature-controlled packaging to preserve bioactivity.</p>
              </div>
            </div>

            <div class="process-step">
              <div class="process-step-line">
                <div class="process-step-num">04</div>
                <div class="process-step-connector"></div>
              </div>
              <div class="process-step-content">
                <h4 class="process-step-title">Transparent Documentation</h4>
                <p class="process-step-text">Certificate of Analysis and full batch records are available for every product — no hidden formulas, no proprietary blends.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Certs -->
        <div>
          <div class="science-certs" style="margin-top: 80px;">
            <div class="cert-card reveal">
              <div class="cert-icon" aria-hidden="true">🏭</div>
              <div class="cert-title">GMP Certified</div>
              <p class="cert-text">Manufactured in Good Manufacturing Practice (GMP) certified facilities to pharmaceutical standards.</p>
            </div>
            <div class="cert-card reveal reveal-delay-1">
              <div class="cert-icon" aria-hidden="true">🔬</div>
              <div class="cert-title">HPLC Verified</div>
              <p class="cert-text">High-Performance Liquid Chromatography confirms peptide sequence, purity, and concentration on every batch.</p>
            </div>
            <div class="cert-card reveal reveal-delay-2">
              <div class="cert-icon" aria-hidden="true">📋</div>
              <div class="cert-title">Full COA</div>
              <p class="cert-text">Certificate of Analysis provided with every order — including mass spec data, purity percentage, and lot number.</p>
            </div>
            <div class="cert-card reveal reveal-delay-3">
              <div class="cert-icon" aria-hidden="true">❄️</div>
              <div class="cert-title">Cold-Chain Intact</div>
              <p class="cert-text">Temperature-monitored shipping with phase-change packs ensures peptides arrive as potent as they left the lab.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════════
       TESTIMONIALS
  ═══════════════════════════════════════ -->
  <section class="testimonials-section" id="testimonials" aria-label="Customer testimonials">
    <div class="container">
      <div class="testimonials-header">
        <p class="section-label">Real Results</p>
        <h2 class="section-title">
          What Our Customers<br><em>Are Saying</em>
        </h2>
        <p class="section-desc">
          From biohackers to dermatologists — Alluvia is trusted by people who demand
          results they can measure.
        </p>
      </div>

      <div class="testimonials-grid">

        <article class="testi-card">
          <div class="testi-stars" aria-label="5 stars">★★★★★</div>
          <blockquote class="testi-quote">
            After 8 weeks on BPC-157 I saw measurable improvement in my shoulder tendon pain
            that I had been managing for two years. The COA gave me real confidence in the product.
          </blockquote>
          <footer class="testi-author">
            <div class="testi-avatar" aria-hidden="true">MK</div>
            <div>
              <div class="testi-name">Marcus K.</div>
              <div class="testi-meta">Strength & Conditioning Coach</div>
            </div>
            <span class="testi-product">Medical</span>
          </footer>
        </article>

        <article class="testi-card">
          <div class="testi-stars" aria-label="5 stars">★★★★★</div>
          <blockquote class="testi-quote">
            The skincare peptides are the real deal. Matrixyl and GHK-Cu together genuinely
            changed the texture and firmness of my skin within 6 weeks. I'm completely hooked.
          </blockquote>
          <footer class="testi-author">
            <div class="testi-avatar" aria-hidden="true">SP</div>
            <div>
              <div class="testi-name">Sophie P.</div>
              <div class="testi-meta">Aesthetics Practitioner</div>
            </div>
            <span class="testi-product">Skincare</span>
          </footer>
        </article>

        <article class="testi-card">
          <div class="testi-stars" aria-label="5 stars">★★★★★</div>
          <blockquote class="testi-quote">
            I use the Ipamorelin/CJC stack for sleep and recovery. Delivery was fast,
            product arrived cold, and the results on deep sleep quality were immediate. Top tier.
          </blockquote>
          <footer class="testi-author">
            <div class="testi-avatar" aria-hidden="true">RJ</div>
            <div>
              <div class="testi-name">Ryan J.</div>
              <div class="testi-meta">Longevity Researcher</div>
            </div>
            <span class="testi-product">Anti-Aging</span>
          </footer>
        </article>

      </div>
    </div>
  </section>


  <!-- ═══════════════════════════════════════
       CTA / NEWSLETTER
  ═══════════════════════════════════════ -->
  <section class="cta-section" id="contact" aria-label="Newsletter signup">
    <div class="cta-inner">
      <p class="section-label" style="justify-content:center;">Join the Community</p>
      <h2 class="section-title">
        Start Your<br><span class="gold">Peptide Journey</span>
      </h2>
      <p class="section-desc" style="margin-bottom:40px;">
        Subscribe for early access to new peptides, exclusive science content,
        and first-time customer offers.
      </p>

      <form class="email-form" role="form" aria-label="Email subscription">
        <label for="alluvia-email" style="position:absolute;left:-9999px;">Email address</label>
        <input type="email" id="alluvia-email" placeholder="Your email address" required autocomplete="email">
        <button type="submit">Join Now</button>
      </form>

      <p class="cta-guarantee">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true">
          <circle cx="7" cy="7" r="6" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
          <path d="M4.5 7l2 2 3-3" stroke="rgba(255,255,255,0.3)" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        No spam, ever. Unsubscribe anytime. We respect your privacy.
      </p>
    </div>
  </section>


  <!-- ═══════════════════════════════════════
       FOOTER
  ═══════════════════════════════════════ -->
  <footer class="alluvia-footer" role="contentinfo">
    <div class="container">
      <div class="footer-grid">

        <!-- Brand -->
        <div class="footer-brand">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
            <span class="nav-logo-word">Alluvia</span>
            <span class="nav-logo-sub">Peptides</span>
          </a>
          <p class="footer-brand-desc">
            Pharmaceutical-grade bioactive peptides for performance, longevity,
            and beauty — backed by science, delivered with integrity.
          </p>
          <div class="footer-socials">
            <a href="#" class="social-btn" aria-label="Instagram">📸</a>
            <a href="#" class="social-btn" aria-label="Twitter">🐦</a>
            <a href="#" class="social-btn" aria-label="Facebook">📘</a>
            <a href="#" class="social-btn" aria-label="YouTube">▶️</a>
          </div>
        </div>

        <!-- Products -->
        <div>
          <h3 class="footer-col-title">Products</h3>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url( get_term_link( 'medical-peptides', 'product_cat' ) ); ?>">Medical Peptides</a></li>
            <li><a href="<?php echo esc_url( get_term_link( 'skincare-peptides', 'product_cat' ) ); ?>">Skincare Peptides</a></li>
            <li><a href="<?php echo esc_url( get_term_link( 'collagen-peptides', 'product_cat' ) ); ?>">Collagen Peptides</a></li>
            <li><a href="<?php echo esc_url( get_term_link( 'sports-recovery-peptides', 'product_cat' ) ); ?>">Sports & Recovery</a></li>
            <li><a href="<?php echo esc_url( get_term_link( 'weight-loss-metabolic-peptides', 'product_cat' ) ); ?>">Weight-Loss & Metabolic</a></li>
            <li><a href="<?php echo esc_url( get_term_link( 'hormone-anti-aging-peptides', 'product_cat' ) ); ?>">Hormone & Anti-Aging</a></li>
            <li><a href="<?php echo esc_url( get_term_link( 'hair-growth-peptides', 'product_cat' ) ); ?>">Hair Growth</a></li>
            <li><a href="<?php echo esc_url( get_term_link( 'research-peptides', 'product_cat' ) ); ?>">Research Peptides</a></li>
          </ul>
        </div>

        <!-- Company -->
        <div>
          <h3 class="footer-col-title">Company</h3>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'about' ) ) ); ?>">About Us</a></li>
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'science' ) ) ); ?>">Our Science</a></li>
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'blog' ) ) ); ?>">Blog</a></li>
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>">Contact</a></li>
          </ul>
        </div>

        <!-- Support -->
        <div>
          <h3 class="footer-col-title">Support</h3>
          <ul class="footer-links">
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'faq' ) ) ); ?>">FAQ</a></li>
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'shipping' ) ) ); ?>">Shipping Info</a></li>
            <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( 'returns' ) ) ); ?>">Returns</a></li>
            <li><a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>">My Account</a></li>
          </ul>
        </div>

      </div><!-- .footer-grid -->

      <div class="footer-bottom">
        <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Alluvia Peptides. All rights reserved.</p>
        <div class="footer-bottom-links">
          <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'privacy-policy' ) ) ); ?>">Privacy Policy</a>
          <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'terms-of-service' ) ) ); ?>">Terms of Service</a>
          <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'disclaimer' ) ) ); ?>">Disclaimer</a>
        </div>
      </div>
    </div>
  </footer>

</div><!-- .alluvia-landing -->

<?php get_footer(); ?>
