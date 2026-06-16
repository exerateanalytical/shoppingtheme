<?php
/**
 * Template Name: Alluvia – Disclaimer
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
/* PAGE HERO */
.page-hero{background:linear-gradient(135deg,#5a0a18,#8b1a2e);padding:6rem 2rem 3.5rem;margin-top:72px}
.page-hero-inner{max-width:860px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:rgba(255,255,255,0.65);margin-bottom:1rem}.breadcrumb a{color:rgba(255,255,255,0.8);text-decoration:none}
.page-hero h1{font-family:var(--font-display);font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.75rem}
.page-hero-subtitle{color:rgba(255,255,255,0.65);font-size:var(--fs-base)}

/* PRIMARY BANNER */
.primary-banner{background:linear-gradient(135deg,#7b1c1c,#5a0a18);border:2px solid rgba(255,255,255,0.15);border-radius:var(--radius);padding:2.5rem;max-width:860px;margin:0 auto 2rem;text-align:center}
.primary-banner svg{color:#fff;margin-bottom:1rem}
.primary-banner h2{font-family:var(--font-display);font-size:var(--fs-h2);font-weight:600;color:#fff;margin-bottom:0.75rem}
.primary-banner p{color:rgba(255,255,255,0.75);font-size:var(--fs-body);line-height:1.85;max-width:640px;margin:0 auto}

/* POLICY LAYOUT */
.policy-wrap{max-width:860px;margin:0 auto;padding:2.5rem 2rem 5rem}
.policy-section{background:#fff;border-radius:var(--radius);padding:2rem 2.25rem;margin-bottom:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05)}
.section-num{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#c0405a;margin-bottom:0.25rem}
.policy-section h2{font-family:var(--font-display);font-size:var(--fs-h3);font-weight:600;margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--pearl-dark)}
.policy-section p{font-size:var(--fs-body);color:var(--text-mid);line-height:1.85;margin-bottom:0.9rem}
.policy-section p:last-child{margin-bottom:0}
.policy-section a{color:var(--teal-dark);text-decoration:none}.policy-section a:hover{text-decoration:underline}
.warn-list{list-style:none;display:flex;flex-direction:column;gap:0.6rem;margin-bottom:1rem}
.warn-list li{display:flex;align-items:flex-start;gap:0.6rem;font-size:var(--fs-body);color:var(--text-mid);line-height:1.85}.warn-list li svg{color:#c0405a;flex-shrink:0;margin-top:3px}
.warn-box{background:rgba(192,64,90,0.06);border:1px solid rgba(192,64,90,0.2);border-radius:8px;padding:1rem 1.25rem;margin:1rem 0;font-size:var(--fs-body);color:var(--text-mid)}.warn-box strong{color:var(--text-dark)}

@media(max-width:640px){
  .page-hero h1{font-size:clamp(36px,9vw,52px)!important}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="page-hero"><div class="page-hero-inner">
  <div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a><i data-lucide="chevron-right" width="14" height="14"></i><span>Disclaimer</span></div>
  <h1>Research Use Only Disclaimer</h1>
  <p class="page-hero-subtitle">Please read this disclaimer carefully before purchasing or using any Alluvia Peptides product.</p>
</div></div>

<div class="policy-wrap" style="padding-top:2.5rem">
  <div class="primary-banner" style="background:linear-gradient(135deg,rgba(192,64,90,0.08),rgba(192,64,90,0.03));border:2px solid rgba(192,64,90,0.2);margin-bottom:2rem;border-radius:var(--radius);padding:2rem;text-align:center">
    <i data-lucide="alert-triangle" width="40" height="40" style="color:#c0405a;margin-bottom:1rem"></i>
    <h2 style="font-family:var(--font-display);font-size:1.75rem;font-weight:600;color:var(--text-dark);margin-bottom:0.75rem">FOR RESEARCH USE ONLY</h2>
    <p style="color:var(--text-mid);font-size:0.95rem;line-height:1.8;max-width:640px;margin:0 auto">All products sold by Alluvia Peptides LLC are intended <strong>exclusively for in vitro laboratory research</strong>. They are <strong>NOT</strong> intended for human or veterinary use, consumption, injection, or any diagnostic or therapeutic application.</p>
  </div>

  <div class="policy-section"><div class="section-num">Notice 01</div><h2>Not For Human Use</h2>
    <p>The peptides sold by Alluvia Peptides have not been evaluated or approved by the U.S. Food and Drug Administration (FDA), the European Medicines Agency (EMA), or any equivalent regulatory authority in any jurisdiction. They are not drugs, dietary supplements, or food additives.</p>
    <ul class="warn-list">
      <li><i data-lucide="x-circle" width="15" height="15"></i>NOT for human consumption in any form</li>
      <li><i data-lucide="x-circle" width="15" height="15"></i>NOT for injection, oral ingestion, topical use on humans, or any in vivo human application</li>
      <li><i data-lucide="x-circle" width="15" height="15"></i>NOT a substitute for FDA-approved pharmaceuticals or medical treatment</li>
      <li><i data-lucide="x-circle" width="15" height="15"></i>NOT intended to diagnose, treat, cure, or prevent any disease or health condition</li>
    </ul>
  </div>

  <div class="policy-section"><div class="section-num">Notice 02</div><h2>Qualified Researcher Requirement</h2>
    <p>These products are sold exclusively to qualified researchers — individuals with appropriate scientific training, institutional affiliation, or professional credentials who are conducting legitimate in vitro or pre-clinical research in compliance with all applicable laws and institutional policies.</p>
    <p>By purchasing from Alluvia Peptides, you represent and warrant that you are a qualified researcher aged 18 or over and that you will use the products solely for lawful research purposes.</p>
  </div>

  <div class="policy-section"><div class="section-num">Notice 03</div><h2>No Medical Advice</h2>
    <p>Nothing on this website — including product descriptions, blog articles, research summaries, or any other content — constitutes medical advice, medical diagnosis, or recommendations for use in humans. Information is provided for educational and research purposes only.</p>
    <p>If you have a medical condition or health concern, consult a qualified, licensed medical professional. Do not use any content from this website as a basis for medical decisions.</p>
    <div class="warn-box"><strong>Research summaries on this site</strong> describe findings from preclinical and animal model studies. Animal model data does not automatically translate to equivalent effects in humans.</div>
  </div>

  <div class="policy-section"><div class="section-num">Notice 04</div><h2>Jurisdiction & Legal Compliance</h2>
    <p>It is the customer's sole responsibility to ensure that the purchase, importation, possession, and use of research peptides is legal in their jurisdiction. Alluvia Peptides does not represent that its products are legal in every jurisdiction and accepts no liability for violations of local, national, or international laws by customers.</p>
    <p>We do not ship to jurisdictions where such products are explicitly prohibited. If you are unsure about the legal status of research peptides in your region, consult a legal professional before ordering.</p>
  </div>

  <div class="policy-section"><div class="section-num">Notice 05</div><h2>Limitation of Liability</h2>
    <p>Alluvia Peptides LLC expressly disclaims all liability for any harm, injury, loss, or legal consequence arising from the misuse of its products, including but not limited to use for human or veterinary administration, use in violation of applicable laws, or use by unqualified individuals.</p>
    <p>To the fullest extent permitted by law, Alluvia Peptides' liability for any claim related to its products shall not exceed the purchase price of the specific product giving rise to the claim.</p>
    <p>By purchasing any product from Alluvia Peptides, you agree to indemnify and hold harmless Alluvia Peptides LLC, its officers, directors, employees, and agents from any claims arising from your use or misuse of the products. Please review our full <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms & Conditions</a>.</p>
  </div>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>
<script>lucide.createIcons();</script>
<?php get_footer( 'alluvia' ); ?>
