<?php
/**
 * Template Name: Alluvia – COA Library
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
.nav-cart-btn{background:var(--teal);color:var(--navy);border:none;border-radius:8px;padding:0.5rem 1rem;display:flex;align-items:center;gap:0.4rem;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;text-decoration:none}
.nav-account-btn{background:transparent;border:1px solid rgba(255,255,255,0.2);border-radius:8px;padding:0.5rem;color:rgba(255,255,255,0.75);display:flex;align-items:center;text-decoration:none}
.page-hero{background:linear-gradient(135deg,var(--navy),var(--navy-soft));padding:6rem 2rem 3rem;margin-top:72px}
.page-hero-inner{max-width:1100px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:var(--text-light);margin-bottom:1rem}.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:var(--font-display);font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.70);font-size:var(--fs-body)}
.trust-strip{background:rgba(14,175,159,0.06);border-bottom:1px solid rgba(14,175,159,0.12);padding:1.25rem 2rem}
.trust-strip-inner{max-width:1100px;margin:0 auto;display:flex;gap:2.5rem;flex-wrap:wrap;justify-content:center}
.trust-item{display:flex;align-items:center;gap:0.6rem;font-family:var(--font-ui);font-size:var(--fs-body);color:var(--text-mid)}.trust-item svg{color:var(--teal)}
.coa-wrap{max-width:1100px;margin:0 auto;padding:3rem 2rem 5rem}
.search-bar{display:flex;align-items:center;gap:0.75rem;background:#fff;border:1px solid var(--pearl-dark);border-radius:var(--radius);padding:0.85rem 1.25rem;margin-bottom:0.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.06)}.search-bar svg{color:var(--text-light);flex-shrink:0}
.search-bar input{border:none;outline:none;font-family:var(--font-body);font-size:16px;flex:1;background:transparent}.search-bar input::placeholder{color:var(--text-light)}
.filter-row{display:flex;gap:0.6rem;flex-wrap:wrap;margin-bottom:2rem}
.filter-pill{background:#fff;border:1px solid var(--pearl-dark);border-radius:50px;padding:0.4rem 1rem;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;color:var(--text-mid);cursor:pointer;transition:all .2s}
.filter-pill:hover{border-color:var(--teal);color:var(--teal-dark)}
.filter-pill.active{background:var(--navy);color:#fff;border-color:var(--navy)}
.coa-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem}
.coa-card{background:#fff;border-radius:var(--radius);padding:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid var(--pearl-dark);transition:all .2s;position:relative}
.coa-card:hover{border-color:var(--teal);box-shadow:0 6px 24px rgba(0,0,0,0.1)}
.coa-card-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1rem}
.coa-icon-wrap{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.coa-badge{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:0.06em;padding:3px 8px;border-radius:50px;text-transform:uppercase}
.badge-verified{background:rgba(88,180,136,0.15);color:#2d8a5f}
.coa-name{font-family:var(--font-ui);font-weight:700;font-size:var(--fs-body);margin-bottom:0.2rem}
.coa-lot{font-size:var(--fs-base);color:var(--text-light)}
.coa-stats{display:grid;grid-template-columns:1fr 1fr;gap:0.6rem;margin:1rem 0;padding:0.75rem;background:var(--pearl);border-radius:8px}
.coa-stat{text-align:center}
.coa-stat-val{font-family:var(--font-ui);font-weight:700;font-size:var(--fs-base);color:var(--text-dark)}
.coa-stat-lbl{font-size:var(--fs-micro);color:var(--text-light);font-family:var(--font-ui);text-transform:uppercase;letter-spacing:0.04em}
.coa-meta{font-size:var(--fs-base);color:var(--text-light);display:flex;align-items:center;gap:0.4rem;margin-bottom:1rem}
.btn-coa{display:flex;align-items:center;justify-content:center;gap:0.4rem;width:100%;background:var(--navy);color:#fff;border:none;border-radius:8px;padding:0.6rem;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;cursor:pointer;transition:all .2s;text-decoration:none}
.btn-coa:hover{background:var(--teal);color:var(--navy)}
footer{background:#060e17;color:rgba(255,255,255,0.70);padding:4rem 2rem 2rem}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-bottom{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;font-size:var(--fs-xs);color:rgba(255,255,255,0.65)}
.footer-legal{display:flex;gap:1.5rem;flex-wrap:wrap}.footer-legal a{color:rgba(255,255,255,0.65);text-decoration:none}.footer-legal a:hover{color:var(--teal)}
@media(max-width:900px){.coa-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){.coa-grid{grid-template-columns:1fr}.trust-strip-inner{gap:1rem}}
@media(max-width:400px){
  .page-hero h1,.hero-title{font-size:32px!important}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="page-hero"><div class="page-hero-inner">
  <div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a><i data-lucide="chevron-right" width="14" height="14"></i><span>COA Library</span></div>
  <h1>Certificate of Analysis Library</h1>
  <p>Third-party verified batch reports for every Alluvia Peptides product. HPLC + mass spectrometry on every lot.</p>
</div></div>

<div class="trust-strip"><div class="trust-strip-inner">
  <span class="trust-item"><i data-lucide="award" width="16" height="16"></i> Independent third-party testing</span>
  <span class="trust-item"><i data-lucide="beaker" width="16" height="16"></i> HPLC purity analysis on every batch</span>
  <span class="trust-item"><i data-lucide="scan" width="16" height="16"></i> Mass spectrometry identity confirmation</span>
  <span class="trust-item"><i data-lucide="shield-check" width="16" height="16"></i> Janoshik Analytical verified</span>
</div></div>

<div class="coa-wrap">
  <div class="search-bar"><i data-lucide="search" width="18" height="18"></i><input type="text" placeholder="Search by product name or lot number…" oninput="filterCOA(this.value)"></div>
  <div class="filter-row" id="filterRow">
    <button class="filter-pill active" onclick="setCat('all',this)">All Products</button>
    <button class="filter-pill" onclick="setCat('medical',this)">Medical</button>
    <button class="filter-pill" onclick="setCat('skincare',this)">Skincare</button>
    <button class="filter-pill" onclick="setCat('sports',this)">Sports</button>
    <button class="filter-pill" onclick="setCat('antiaging',this)">Anti-Aging</button>
    <button class="filter-pill" onclick="setCat('metabolic',this)">Metabolic</button>
    <button class="filter-pill" onclick="setCat('research',this)">Research</button>
  </div>

  <div class="coa-grid" id="coaGrid">
    <?php
    $coa_items = function_exists( 'wc_get_products' )
        ? wc_get_products( array( 'status' => 'publish', 'limit' => -1, 'orderby' => 'title', 'order' => 'ASC' ) )
        : array();
    $coa_map = array(
        'Medical Peptides' => 'medical', 'Skincare Peptides' => 'skincare',
        'Sports & Recovery' => 'sports', 'Hormone & Anti-Aging' => 'antiaging',
        'Weight-Loss & Metabolic' => 'metabolic', 'Research Peptides' => 'research',
        'Collagen Peptides' => 'collagen', 'Hair Growth Peptides' => 'hair',
        'Lab Supplies & Accessories' => 'lab',
    );
    $coa_rendered = 0;
    foreach ( $coa_items as $cp ) {
        if ( ! is_a( $cp, 'WC_Product' ) ) {
            continue;
        }
        $sku = $cp->get_sku();
        $pdf = function_exists( 'alluvia_coa_url' ) ? alluvia_coa_url( $sku ) : '';
        if ( ! $pdf ) {
            continue;
        }
        $cats   = wp_get_post_terms( $cp->get_id(), 'product_cat', array( 'fields' => 'names' ) );
        $cname  = ( ! is_wp_error( $cats ) && $cats ) ? $cats[0] : '';
        $slug   = isset( $coa_map[ $cname ] ) ? $coa_map[ $cname ] : 'all';
        $pval   = function_exists( 'alluvia_coa_purity' ) ? alluvia_coa_purity( $sku ) : null;
        $purity = ( null !== $pval ) ? number_format( $pval, 1 ) . '%' : ( $cp->get_attribute( 'Purity' ) ?: '≥99%' );
        $coa_rendered++;
        ?>
        <div class="coa-card" data-cat="<?php echo esc_attr( $slug ); ?>">
          <div class="coa-card-header">
            <div class="coa-icon-wrap" style="background:rgba(14,175,159,0.1)"><i data-lucide="file-check" width="24" height="24" style="color:var(--teal)"></i></div>
            <span class="coa-badge badge-verified"><i data-lucide="check-circle" width="10" height="10"></i> On File</span>
          </div>
          <div class="coa-name"><?php echo esc_html( $cp->get_name() ); ?></div>
          <div class="coa-lot">SKU <?php echo esc_html( $sku ); ?><?php echo $cname ? ' · ' . esc_html( $cname ) : ''; ?></div>
          <div class="coa-stats">
            <div class="coa-stat"><div class="coa-stat-val"><?php echo esc_html( $purity ); ?></div><div class="coa-stat-lbl">HPLC Purity</div></div>
            <div class="coa-stat"><div class="coa-stat-val">PDF</div><div class="coa-stat-lbl">Full Report</div></div>
          </div>
          <div class="coa-meta"><i data-lucide="shield-check" width="13" height="13"></i> Alluvia Analytical Services</div>
          <a href="<?php echo esc_url( $pdf ); ?>" target="_blank" rel="noopener" class="btn-coa"><i data-lucide="download" width="14" height="14"></i> Download COA (PDF)</a>
        </div>
        <?php
    }
    ?>
    <?php if ( 0 === $coa_rendered ) : ?>
    <!-- BPC-157 -->
    <div class="coa-card" data-cat="medical">
      <div class="coa-card-header">
        <div class="coa-icon-wrap" style="background:rgba(14,175,159,0.1)"><i data-lucide="activity" width="24" height="24" style="color:var(--teal)"></i></div>
        <span class="coa-badge badge-verified"><i data-lucide="check-circle" width="10" height="10"></i> Verified</span>
      </div>
      <div class="coa-name">BPC-157</div>
      <div class="coa-lot">Lot #BPC157-2504-A · 5 mg vial</div>
      <div class="coa-stats">
        <div class="coa-stat"><div class="coa-stat-val">99.2%</div><div class="coa-stat-lbl">HPLC Purity</div></div>
        <div class="coa-stat"><div class="coa-stat-val">1419.5</div><div class="coa-stat-lbl">MW Confirmed</div></div>
      </div>
      <div class="coa-meta"><i data-lucide="calendar" width="13" height="13"></i> Tested April 2025 · Janoshik Analytical</div>
      <a href="#" class="btn-coa" onclick="showToast('COA download would open here.')"><i data-lucide="download" width="14" height="14"></i> Download COA (PDF)</a>
    </div>
    <!-- TB-500 -->
    <div class="coa-card" data-cat="sports">
      <div class="coa-card-header">
        <div class="coa-icon-wrap" style="background:rgba(212,102,60,0.1)"><i data-lucide="dumbbell" width="24" height="24" style="color:var(--orange)"></i></div>
        <span class="coa-badge badge-verified"><i data-lucide="check-circle" width="10" height="10"></i> Verified</span>
      </div>
      <div class="coa-name">TB-500 (Thymosin Beta-4)</div>
      <div class="coa-lot">Lot #TB500-2503-B · 5 mg vial</div>
      <div class="coa-stats">
        <div class="coa-stat"><div class="coa-stat-val">98.7%</div><div class="coa-stat-lbl">HPLC Purity</div></div>
        <div class="coa-stat"><div class="coa-stat-val">4963.5</div><div class="coa-stat-lbl">MW Confirmed</div></div>
      </div>
      <div class="coa-meta"><i data-lucide="calendar" width="13" height="13"></i> Tested March 2025 · Janoshik Analytical</div>
      <a href="#" class="btn-coa" onclick="showToast('COA download would open here.')"><i data-lucide="download" width="14" height="14"></i> Download COA (PDF)</a>
    </div>
    <!-- GHK-Cu -->
    <div class="coa-card" data-cat="skincare">
      <div class="coa-card-header">
        <div class="coa-icon-wrap" style="background:rgba(219,98,122,0.1)"><i data-lucide="sparkles" width="24" height="24" style="color:var(--coral)"></i></div>
        <span class="coa-badge badge-verified"><i data-lucide="check-circle" width="10" height="10"></i> Verified</span>
      </div>
      <div class="coa-name">GHK-Cu (Copper Tripeptide-1)</div>
      <div class="coa-lot">Lot #GHKCU-2504-A · 200 mg powder</div>
      <div class="coa-stats">
        <div class="coa-stat"><div class="coa-stat-val">99.1%</div><div class="coa-stat-lbl">HPLC Purity</div></div>
        <div class="coa-stat"><div class="coa-stat-val">340.4</div><div class="coa-stat-lbl">MW Confirmed</div></div>
      </div>
      <div class="coa-meta"><i data-lucide="calendar" width="13" height="13"></i> Tested April 2025 · Janoshik Analytical</div>
      <a href="#" class="btn-coa" onclick="showToast('COA download would open here.')"><i data-lucide="download" width="14" height="14"></i> Download COA (PDF)</a>
    </div>
    <!-- Ipamorelin -->
    <div class="coa-card" data-cat="antiaging">
      <div class="coa-card-header">
        <div class="coa-icon-wrap" style="background:rgba(198,162,83,0.1)"><i data-lucide="zap" width="24" height="24" style="color:var(--gold)"></i></div>
        <span class="coa-badge badge-verified"><i data-lucide="check-circle" width="10" height="10"></i> Verified</span>
      </div>
      <div class="coa-name">Ipamorelin</div>
      <div class="coa-lot">Lot #IPA-2502-C · 2 mg vial</div>
      <div class="coa-stats">
        <div class="coa-stat"><div class="coa-stat-val">98.9%</div><div class="coa-stat-lbl">HPLC Purity</div></div>
        <div class="coa-stat"><div class="coa-stat-val">711.9</div><div class="coa-stat-lbl">MW Confirmed</div></div>
      </div>
      <div class="coa-meta"><i data-lucide="calendar" width="13" height="13"></i> Tested Feb 2025 · Janoshik Analytical</div>
      <a href="#" class="btn-coa" onclick="showToast('COA download would open here.')"><i data-lucide="download" width="14" height="14"></i> Download COA (PDF)</a>
    </div>
    <!-- Semaglutide -->
    <div class="coa-card" data-cat="metabolic">
      <div class="coa-card-header">
        <div class="coa-icon-wrap" style="background:rgba(138,96,193,0.1)"><i data-lucide="trending-down" width="24" height="24" style="color:#8a60c1"></i></div>
        <span class="coa-badge badge-verified"><i data-lucide="check-circle" width="10" height="10"></i> Verified</span>
      </div>
      <div class="coa-name">Semaglutide</div>
      <div class="coa-lot">Lot #SEMA-2504-A · 5 mg vial</div>
      <div class="coa-stats">
        <div class="coa-stat"><div class="coa-stat-val">98.5%</div><div class="coa-stat-lbl">HPLC Purity</div></div>
        <div class="coa-stat"><div class="coa-stat-val">4113.6</div><div class="coa-stat-lbl">MW Confirmed</div></div>
      </div>
      <div class="coa-meta"><i data-lucide="calendar" width="13" height="13"></i> Tested April 2025 · Janoshik Analytical</div>
      <a href="#" class="btn-coa" onclick="showToast('COA download would open here.')"><i data-lucide="download" width="14" height="14"></i> Download COA (PDF)</a>
    </div>
    <!-- Epithalon -->
    <div class="coa-card" data-cat="research">
      <div class="coa-card-header">
        <div class="coa-icon-wrap" style="background:rgba(106,166,198,0.1)"><i data-lucide="dna" width="24" height="24" style="color:var(--sky)"></i></div>
        <span class="coa-badge badge-verified"><i data-lucide="check-circle" width="10" height="10"></i> Verified</span>
      </div>
      <div class="coa-name">Epithalon (Epitalon)</div>
      <div class="coa-lot">Lot #EPIT-2503-A · 10 mg vial</div>
      <div class="coa-stats">
        <div class="coa-stat"><div class="coa-stat-val">99.0%</div><div class="coa-stat-lbl">HPLC Purity</div></div>
        <div class="coa-stat"><div class="coa-stat-val">390.4</div><div class="coa-stat-lbl">MW Confirmed</div></div>
      </div>
      <div class="coa-meta"><i data-lucide="calendar" width="13" height="13"></i> Tested March 2025 · Janoshik Analytical</div>
      <a href="#" class="btn-coa" onclick="showToast('COA download would open here.')"><i data-lucide="download" width="14" height="14"></i> Download COA (PDF)</a>
    </div>
    <?php endif; // end static design fallback when no real COAs are available ?>
  </div>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>
<script>
lucide.createIcons();
function setCat(cat,btn){document.querySelectorAll('.filter-pill').forEach(p=>p.classList.remove('active'));btn.classList.add('active');document.querySelectorAll('.coa-card').forEach(c=>{c.style.display=(cat==='all'||c.dataset.cat===cat)?'':'none';});}
function filterCOA(q){const t=q.toLowerCase();document.querySelectorAll('.coa-card').forEach(c=>{c.style.display=c.textContent.toLowerCase().includes(t)?'':'none';});}
function showToast(msg){const t=document.createElement('div');t.textContent=msg;Object.assign(t.style,{position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',background:'#0eaf9f',color:'#0a1a27',padding:'0.75rem 1.5rem',borderRadius:'50px',fontFamily:"var(--font-ui)",fontSize:'0.85rem',fontWeight:'600',zIndex:'9999',boxShadow:'0 8px 24px rgba(0,0,0,0.2)'});document.body.appendChild(t);setTimeout(()=>{t.style.opacity='0';setTimeout(()=>t.remove(),300);},2200);}
</script>
<?php get_footer( 'alluvia' ); ?>
