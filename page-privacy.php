<?php
/**
 * Template Name: Alluvia – Privacy Policy
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
/* PAGE HERO */
.page-hero{background:linear-gradient(135deg,var(--navy),var(--navy-soft));padding:6rem 2rem 3rem;margin-top:72px}
.page-hero-inner{max-width:900px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:var(--fs-ui);color:var(--text-light);margin-bottom:1rem}.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.65);font-size:var(--fs-base)}

/* POLICY LAYOUT */
.policy-wrap{max-width:900px;margin:0 auto;padding:3rem 2rem 5rem}
.policy-section{background:#fff;border-radius:var(--radius);padding:2rem 2.25rem;margin-bottom:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05)}
.section-num{font-family:'Space Grotesk',sans-serif;font-size:var(--fs-micro);font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--teal);margin-bottom:0.25rem}
.policy-section h2{font-family:'Cormorant Garamond',serif;font-size:var(--fs-h3);font-weight:600;margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--pearl-dark)}
.policy-section h3{font-family:'Space Grotesk',sans-serif;font-size:var(--fs-h3);font-weight:700;color:var(--text-dark);margin:1.25rem 0 0.5rem}
.policy-section p{font-size:var(--fs-body);color:var(--text-mid);line-height:1.85;margin-bottom:0.9rem}
.policy-section p:last-child{margin-bottom:0}
.policy-list{list-style:none;display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1rem}
.policy-list li{display:flex;align-items:flex-start;gap:0.6rem;font-size:var(--fs-body);color:var(--text-mid);line-height:1.85}.policy-list li svg{color:var(--teal);flex-shrink:0;margin-top:3px}
.policy-section a{color:var(--teal-dark);text-decoration:none}.policy-section a:hover{text-decoration:underline}
.highlight-box{background:rgba(14,175,159,0.05);border:1px solid rgba(14,175,159,0.2);border-radius:8px;padding:1rem 1.25rem;margin:1rem 0;font-size:var(--fs-body);color:var(--text-mid)}.highlight-box strong{color:var(--text-dark)}

@media(max-width:640px){
  .page-hero h1{font-size:clamp(36px,9vw,52px)!important}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="page-hero"><div class="page-hero-inner">
  <div class="breadcrumb"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a><i data-lucide="chevron-right" width="14" height="14"></i><span>Privacy Policy</span></div>
  <h1>Privacy Policy</h1><p>Effective Date: June 1, 2025 · Last Updated: June 2025</p>
</div></div>

<div class="policy-wrap">
  <div class="policy-section"><div class="section-num">Section 01</div><h2>Information We Collect</h2>
    <h3>Information You Provide</h3>
    <ul class="policy-list">
      <li><i data-lucide="check-circle" width="15" height="15"></i>Account registration: name, email, password (hashed)</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Order placement: billing/shipping address, phone number, payment method (processed by PCI-DSS third parties — we do not store card numbers)</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Communications: emails, support tickets, newsletter subscriptions</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Research profile: institution, research field (optional, improves recommendations)</li>
    </ul>
    <h3>Information Collected Automatically</h3>
    <ul class="policy-list">
      <li><i data-lucide="check-circle" width="15" height="15"></i>IP address, browser type, operating system, referring URL</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Pages visited, time on site, click patterns (via analytics cookies)</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Device identifiers for fraud prevention</li>
    </ul>
  </div>

  <div class="policy-section"><div class="section-num">Section 02</div><h2>How We Use Your Information</h2>
    <ul class="policy-list">
      <li><i data-lucide="check-circle" width="15" height="15"></i>Processing and fulfilling your orders, including dispatch notifications and tracking</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Account management and customer support</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Sending transactional emails (order confirmations, shipping updates, COA delivery)</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Sending marketing communications <strong>only</strong> with your explicit opt-in consent</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Fraud detection and prevention</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Improving our website and product offerings through anonymized analytics</li>
    </ul>
    <p>We do not sell, rent, or trade your personal information to third parties for their marketing purposes.</p>
  </div>

  <div class="policy-section"><div class="section-num">Section 03</div><h2>Cookies & Tracking</h2>
    <p>We use essential cookies (required for the site to function), analytics cookies (Google Analytics — anonymized IP), and preference cookies (language, currency). We do not use intrusive advertising trackers or retargeting pixels by default.</p>
    <p>You can manage cookie preferences at any time via your browser settings. Disabling essential cookies may affect checkout functionality.</p>
  </div>

  <div class="policy-section"><div class="section-num">Section 04</div><h2>Data Sharing & Third Parties</h2>
    <p>We share your data only with service providers necessary to operate our business:</p>
    <ul class="policy-list">
      <li><i data-lucide="check-circle" width="15" height="15"></i><strong>Payment processors</strong> (Stripe, PayPal) — receive payment data under their own privacy policies</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i><strong>Shipping carriers</strong> (FedEx, UPS, USPS) — receive name and address for delivery</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i><strong>Email platform</strong> — transactional and marketing emails only</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i><strong>Analytics</strong> (Google Analytics, anonymized) — site performance only</li>
    </ul>
    <p>We may disclose your information if required by law, court order, or to protect the rights and safety of Alluvia Peptides, its users, or the public.</p>
  </div>

  <div class="policy-section"><div class="section-num">Section 05</div><h2>Your Rights</h2>
    <p>Depending on your jurisdiction (GDPR, CCPA, etc.), you may have the right to:</p>
    <ul class="policy-list">
      <li><i data-lucide="check-circle" width="15" height="15"></i>Access the personal data we hold about you</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Correct inaccurate data</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Request deletion of your data ("right to be forgotten")</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Opt out of marketing communications at any time (unsubscribe link in every email)</li>
      <li><i data-lucide="check-circle" width="15" height="15"></i>Data portability — request your data in machine-readable format</li>
    </ul>
    <div class="highlight-box"><strong>To exercise any of these rights,</strong> contact <a href="mailto:privacy@alluviapeptides.com">privacy@alluviapeptides.com</a>. We will respond within 30 days.</div>
  </div>

  <div class="policy-section"><div class="section-num">Section 06</div><h2>Data Security & Retention</h2>
    <p>We implement industry-standard security measures including SSL/TLS encryption, hashed passwords (bcrypt), PCI-DSS compliant payment processing, and regular security audits. No system is 100% secure — if you discover a vulnerability, please report it to <a href="mailto:security@alluviapeptides.com">security@alluviapeptides.com</a>.</p>
    <p>We retain personal data for as long as your account is active or as needed to provide services. Order records are retained for 7 years for tax and legal compliance. You may request deletion of non-essential data at any time.</p>
  </div>

  <div class="policy-section"><div class="section-num">Section 07</div><h2>Contact</h2>
    <div class="highlight-box"><strong>Privacy Officer — Alluvia Peptides LLC</strong><br>Email: <a href="mailto:privacy@alluviapeptides.com">privacy@alluviapeptides.com</a><br>Address: 1234 Research Blvd, Suite 200, Wilmington, DE 19801, USA</div>
  </div>
</div>

<footer><div class="footer-inner"><div class="footer-bottom"><span>© 2025 Alluvia Peptides LLC. All rights reserved.</span><div class="footer-legal"><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms</a><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy</a><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping</a><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a></div></div></div></footer>
<script>lucide.createIcons();</script>
<?php get_footer( 'alluvia' ); ?>
