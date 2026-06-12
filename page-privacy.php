<?php
/**
 * Template Name: Alluvia – Privacy Policy
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{--navy:#0a1a27;--navy-soft:#213f5d;--teal:#0eaf9f;--teal-dark:#0a8174;--gold:#c6a253;--pearl:#f5f0e7;--pearl-dark:#e8e0d2;--text-dark:#0a1a27;--text-mid:#44515f;--text-light:#8392a2;--radius:12px}
html{scroll-behavior:smooth}body{font-family:'Inter',sans-serif;background:var(--pearl);color:var(--text-dark);line-height:1.6}
.alluvia-nav{position:fixed;top:0;left:0;right:0;z-index:1000;padding:0 2rem;height:72px;display:flex;align-items:center;justify-content:space-between;background:rgba(10,26,39,0.97);backdrop-filter:blur(20px);border-bottom:1px solid rgba(14,175,159,0.15)}
.nav-logo{display:flex;flex-direction:row;align-items:center;gap:11px;text-decoration:none}
.logo-mark{width:34px;height:34px;flex-shrink:0}
.logo-text{display:flex;flex-direction:column;line-height:1}


.nav-links{display:flex;gap:2rem;list-style:none}.nav-links a{color:rgba(255,255,255,0.75);text-decoration:none;font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:500;letter-spacing:0.05em;text-transform:uppercase;transition:color .2s}.nav-links a:hover{color:var(--teal)}
.nav-right{display:flex;align-items:center;gap:1rem}
.nav-cart-btn{background:var(--teal);color:var(--navy);border:none;border-radius:8px;padding:0.5rem 1rem;display:flex;align-items:center;gap:0.4rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;text-decoration:none}
.cart-count{background:var(--navy);color:var(--teal);border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700}
.nav-account-btn{background:transparent;border:1px solid rgba(255,255,255,0.2);border-radius:8px;padding:0.5rem;color:rgba(255,255,255,0.75);display:flex;align-items:center;text-decoration:none}
.nav-hamburger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:4px}.nav-hamburger span{display:block;width:24px;height:2px;background:#fff;border-radius:2px}
.page-hero{background:linear-gradient(135deg,var(--navy),var(--navy-soft));padding:6rem 2rem 3rem;margin-top:72px}
.page-hero-inner{max-width:900px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:13px;color:var(--text-light);margin-bottom:1rem}.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.55);font-size:15px}
.policy-wrap{max-width:900px;margin:0 auto;padding:3rem 2rem 5rem}
.policy-section{background:#fff;border-radius:var(--radius);padding:2rem 2.25rem;margin-bottom:1.75rem;box-shadow:0 2px 12px rgba(0,0,0,0.05)}
.section-num{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--teal);margin-bottom:0.25rem}
.policy-section h2{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--pearl-dark)}
.policy-section p{font-size:15px;color:var(--text-mid);line-height:1.8;margin-bottom:0.9rem}
.policy-section p:last-child{margin-bottom:0}
.policy-section h3{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;color:var(--text-dark);margin:1.25rem 0 0.5rem}
.policy-list{list-style:none;display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1rem}
.policy-list li{display:flex;align-items:flex-start;gap:0.6rem;font-size:14px;color:var(--text-mid)}.policy-list li svg{color:var(--teal);flex-shrink:0;margin-top:3px}
.policy-section a{color:var(--teal-dark);text-decoration:none}.policy-section a:hover{text-decoration:underline}
.highlight-box{background:rgba(14,175,159,0.05);border:1px solid rgba(14,175,159,0.2);border-radius:8px;padding:1rem 1.25rem;margin:1rem 0;font-size:14px;color:var(--text-mid)}.highlight-box strong{color:var(--text-dark)}
footer{background:#060e17;color:rgba(255,255,255,0.7);padding:4rem 2rem 2rem}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-bottom{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;font-size:13px;color:rgba(255,255,255,0.35)}
.footer-legal{display:flex;gap:1.5rem;flex-wrap:wrap}.footer-legal a{color:rgba(255,255,255,0.35);text-decoration:none}.footer-legal a:hover{color:var(--teal)}
@media(max-width:640px){
  .page-hero h1,.hero-title{font-size:clamp(36px,9vw,52px)!important}
  .section-title{font-size:clamp(28px,7vw,42px)!important}
  .featured-title,.post-title{font-size:clamp(24px,6vw,36px)!important}
  .product-title{font-size:clamp(28px,7vw,38px)!important}
  .section-desc,.post-lead,.featured-body{font-size:16px}
  body,p,.article p{font-size:15px;line-height:1.75}
  .still-help h2,.newsletter h2,.cta-title{font-size:clamp(24px,6vw,36px)!important}
.nav-links{display:none}.nav-hamburger{display:flex}}

@media(max-width:400px){
  .page-hero h1,.hero-title{font-size:32px!important}
  .section-title{font-size:26px!important}
  .btn-primary,.btn-ghost,.btn-help{font-size:14px;padding:13px 22px}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<nav class="alluvia-nav"><a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/><circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/><circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a>
<ul class="nav-links"><li><a href="<?php echo esc_url(alluvia_shop_url()); ?>">Products</a></li><li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li><li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li></ul>
<div class="nav-right"><a href="<?php echo esc_url(alluvia_cart_url()); ?>" class="nav-cart-btn"><i data-lucide="shopping-bag" width="16" height="16"></i> Cart <span class="cart-count">4</span></a><a href="<?php echo esc_url(alluvia_account_url()); ?>" class="nav-account-btn"><i data-lucide="user" width="18" height="18"></i></a><button class="nav-hamburger"><span></span><span></span><span></span></button></div></nav>

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
