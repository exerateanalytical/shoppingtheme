<?php
/**
 * Template Name: Alluvia – Terms & Conditions
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --navy:#0a1a27;--navy-mid:#15283b;--navy-soft:#213f5d;
  --teal:#0eaf9f;--teal-dark:#0a8174;--gold:#c6a253;
  --coral:#db627a;--purple:#8a60c1;--orange:#d4663c;
  --mint:#58b488;--sky:#6aa6c6;
  --pearl:#f5f0e7;--pearl-dark:#e8e0d2;
  --white:#ffffff;--text-dark:#0a1a27;--text-mid:#44515f;--text-light:#8392a2;
  --radius:12px;
}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--pearl);color:var(--text-dark);line-height:1.6}

/* NAV */
.alluvia-nav{position:fixed;top:0;left:0;right:0;z-index:1000;padding:0 2rem;height:72px;display:flex;align-items:center;justify-content:space-between;background:rgba(10,26,39,0.97);backdrop-filter:blur(20px);border-bottom:1px solid rgba(14,175,159,0.15)}
.nav-logo{display:flex;flex-direction:row;align-items:center;gap:11px;text-decoration:none}
.logo-mark{width:34px;height:34px;flex-shrink:0}
.logo-text{display:flex;flex-direction:column;line-height:1}


.nav-links{display:flex;gap:2rem;list-style:none}
.nav-links a{color:rgba(255,255,255,0.75);text-decoration:none;font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:500;letter-spacing:0.05em;text-transform:uppercase;transition:color .2s}
.nav-links a:hover{color:var(--teal)}
.nav-right{display:flex;align-items:center;gap:1rem}
.nav-cart-btn{background:var(--teal);color:var(--navy);border:none;border-radius:8px;padding:0.5rem 1rem;display:flex;align-items:center;gap:0.4rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none}
.cart-count{background:var(--navy);color:var(--teal);border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700}
.nav-account-btn{background:transparent;border:1px solid rgba(255,255,255,0.2);border-radius:8px;padding:0.5rem;color:rgba(255,255,255,0.75);display:flex;align-items:center;text-decoration:none;transition:all .2s}
.nav-account-btn:hover{border-color:var(--teal);color:var(--teal)}
.nav-hamburger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:4px}
.nav-hamburger span{display:block;width:24px;height:2px;background:#fff;border-radius:2px}
.mobile-menu{display:none;position:fixed;inset:0;background:rgba(10,26,39,0.98);z-index:999;flex-direction:column;align-items:center;justify-content:center;gap:2.5rem}
.mobile-menu.open{display:flex}
.mobile-menu a{color:#fff;font-family:'Space Grotesk',sans-serif;font-size:24px;text-decoration:none}
.mobile-menu-close{position:absolute;top:1.5rem;right:1.5rem;background:none;border:none;color:#fff;cursor:pointer}

/* HERO */
.page-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:6rem 2rem 3rem;margin-top:72px}
.page-hero-inner{max-width:1100px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:13px;color:var(--text-light);margin-bottom:1rem}
.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.55);font-size:15px}

/* RESEARCH DISCLAIMER BANNER */
.disclaimer-banner{background:linear-gradient(135deg,#c0405a,#a02040);padding:1.25rem 2rem}
.disclaimer-inner{max-width:1100px;margin:0 auto;display:flex;align-items:flex-start;gap:1rem}
.disclaimer-inner svg{color:#fff;flex-shrink:0;margin-top:2px}
.disclaimer-text{color:#fff;font-size:14px;line-height:1.6}
.disclaimer-text strong{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;display:block;margin-bottom:0.25rem}

/* LAYOUT */
.terms-layout{max-width:1100px;margin:0 auto;padding:3rem 2rem 5rem;display:grid;grid-template-columns:260px 1fr;gap:3rem;align-items:start}

/* SIDEBAR TOC */
.toc-sidebar{position:sticky;top:90px;background:#fff;border-radius:var(--radius);box-shadow:0 2px 16px rgba(0,0,0,0.06);overflow:hidden}
.toc-header{background:var(--navy);padding:1rem 1.25rem}
.toc-header h3{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.7)}
.toc-list{list-style:none;padding:0.75rem 0}
.toc-list li a{display:flex;align-items:center;gap:0.5rem;padding:0.5rem 1.25rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:500;color:var(--text-mid);text-decoration:none;transition:all .2s;border-left:2px solid transparent}
.toc-list li a:hover{color:var(--teal);border-left-color:var(--teal);background:rgba(14,175,159,0.04)}
.toc-list li a.active{color:var(--teal-dark);border-left-color:var(--teal);background:rgba(14,175,159,0.06);font-weight:600}
.toc-list li a svg{flex-shrink:0}

/* TERMS CONTENT */
.terms-content{}
.terms-section{background:#fff;border-radius:var(--radius);padding:2.25rem;margin-bottom:2rem;box-shadow:0 2px 12px rgba(0,0,0,0.05);scroll-margin-top:90px}
.section-num{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--teal);margin-bottom:0.25rem}
.terms-section h2{font-family:'Cormorant Garamond',serif;font-size:26px;font-weight:600;margin-bottom:1.25rem;padding-bottom:0.75rem;border-bottom:1px solid var(--pearl-dark)}
.terms-section p{font-size:15px;color:var(--text-mid);line-height:1.8;margin-bottom:1rem}
.terms-section p:last-child{margin-bottom:0}
.terms-section h3{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;color:var(--text-dark);margin:1.25rem 0 0.5rem}
.terms-list{list-style:none;display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1rem}
.terms-list li{display:flex;align-items:flex-start;gap:0.6rem;font-size:14px;color:var(--text-mid)}
.terms-list li svg{color:var(--teal);flex-shrink:0;margin-top:3px}
.terms-section a{color:var(--teal-dark);text-decoration:none}
.terms-section a:hover{text-decoration:underline}
.highlight-box{background:rgba(14,175,159,0.05);border:1px solid rgba(14,175,159,0.2);border-radius:8px;padding:1rem 1.25rem;margin:1rem 0;font-size:14px;color:var(--text-mid)}
.warn-box{background:rgba(198,162,83,0.07);border:1px solid rgba(198,162,83,0.25);border-radius:8px;padding:1rem 1.25rem;margin:1rem 0;font-size:14px;color:var(--text-mid)}
.warn-box strong,.highlight-box strong{color:var(--text-dark)}

/* FOOTER */
footer{background:#060e17;color:rgba(255,255,255,0.7);padding:5rem 2rem 2rem}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem}
.footer-brand p{font-size:14px;line-height:1.7;color:rgba(255,255,255,0.5);margin:1rem 0 1.5rem}
.footer-logo{display:flex;flex-direction:column;line-height:1}
.footer-logo span:first-child{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:#fff}
.footer-logo span:last-child{font-family:'Space Grotesk',sans-serif;font-size:8px;font-weight:600;letter-spacing:0.3em;color:var(--teal);text-transform:uppercase}
.social-links{display:flex;gap:0.75rem}
.social-link{width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);transition:all .2s;cursor:pointer;text-decoration:none}
.social-link:hover{background:var(--teal);border-color:var(--teal);color:var(--navy)}
.footer-col h4{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#fff;margin-bottom:1.25rem}
.footer-col ul{list-style:none}
.footer-col ul li{margin-bottom:0.6rem}
.footer-col ul li a{color:rgba(255,255,255,0.5);text-decoration:none;font-size:14px;transition:color .2s;display:flex;align-items:center;gap:0.3rem}
.footer-col ul li a:hover{color:var(--teal)}
.footer-bottom{border-top:1px solid rgba(255,255,255,0.07);padding-top:2rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;font-size:13px;color:rgba(255,255,255,0.35)}
.footer-legal{display:flex;gap:1.5rem;flex-wrap:wrap}
.footer-legal a{color:rgba(255,255,255,0.35);text-decoration:none;transition:color .2s}
.footer-legal a:hover{color:var(--teal)}

@media(max-width:900px){.terms-layout{grid-template-columns:1fr}.toc-sidebar{position:static;margin-bottom:1.5rem}.footer-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){
  .page-hero h1,.hero-title{font-size:clamp(36px,9vw,52px)!important}
  .section-title{font-size:clamp(28px,7vw,42px)!important}
  .featured-title,.post-title{font-size:clamp(24px,6vw,36px)!important}
  .product-title{font-size:clamp(28px,7vw,38px)!important}
  .section-desc,.post-lead,.featured-body{font-size:16px}
  body,p,.article p{font-size:15px;line-height:1.75}
  .still-help h2,.newsletter h2,.cta-title{font-size:clamp(24px,6vw,36px)!important}
.nav-links{display:none}.nav-hamburger{display:flex}.footer-grid{grid-template-columns:1fr}}

@media(max-width:400px){
  .page-hero h1,.hero-title{font-size:32px!important}
  .section-title{font-size:26px!important}
  .btn-primary,.btn-ghost,.btn-help{font-size:14px;padding:13px 22px}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<nav class="alluvia-nav" id="nav">
  <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/><circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/><circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a>
  <ul class="nav-links">
    <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>">Products</a></li>
    <li><a href="<?php echo esc_url(home_url('/about/')); ?>#science">Science</a></li>
    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
    <li><a href="<?php echo esc_url(home_url('/')); ?>#reviews">Reviews</a></li>
    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
  </ul>
  <div class="nav-right">
    <a href="<?php echo esc_url(alluvia_cart_url()); ?>" class="nav-cart-btn"><i data-lucide="shopping-bag" width="16" height="16"></i> Cart <span class="cart-count">4</span></a>
    <a href="<?php echo esc_url(alluvia_account_url()); ?>" class="nav-account-btn"><i data-lucide="user" width="18" height="18"></i></a>
    <button class="nav-hamburger" onclick="document.getElementById('mobileMenu').classList.toggle('open')"><span></span><span></span><span></span></button>
  </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <button class="mobile-menu-close" onclick="document.getElementById('mobileMenu').classList.remove('open')"><i data-lucide="x" width="28" height="28"></i></button>
  <a href="<?php echo esc_url(alluvia_shop_url()); ?>">Products</a>
  <a href="<?php echo esc_url(home_url('/about/')); ?>">About</a>
  <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a>
  <a href="<?php echo esc_url(alluvia_cart_url()); ?>">Cart</a>
</div>

<div class="page-hero">
  <div class="page-hero-inner">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <i data-lucide="chevron-right" width="14" height="14"></i>
      <span>Terms & Conditions</span>
    </div>
    <h1>Terms & Conditions</h1>
    <p>Effective Date: June 1, 2025 · Last Updated: June 2025</p>
  </div>
</div>

<div class="disclaimer-banner">
  <div class="disclaimer-inner">
    <i data-lucide="alert-triangle" width="20" height="20"></i>
    <div class="disclaimer-text">
      <strong>Research Use Only — Not for Human Consumption</strong>
      All peptides sold by Alluvia Peptides are intended exclusively for laboratory and in vitro research purposes. They are not approved by the FDA for human or veterinary use, and are not to be used as drugs, food additives, dietary supplements, or for any diagnostic or therapeutic purposes. By purchasing from this site, you confirm you are a qualified researcher aged 18 or older.
    </div>
  </div>
</div>

<div class="terms-layout">

  <!-- SIDEBAR TOC -->
  <div class="toc-sidebar">
    <div class="toc-header"><h3>Contents</h3></div>
    <ul class="toc-list" id="tocList">
      <li><a href="#sec1" class="active"><i data-lucide="dot" width="12" height="12"></i>1. Acceptance of Terms</a></li>
      <li><a href="#sec2"><i data-lucide="dot" width="12" height="12"></i>2. Eligibility</a></li>
      <li><a href="#sec3"><i data-lucide="dot" width="12" height="12"></i>3. Research Use Only</a></li>
      <li><a href="#sec4"><i data-lucide="dot" width="12" height="12"></i>4. Orders & Payment</a></li>
      <li><a href="#sec5"><i data-lucide="dot" width="12" height="12"></i>5. Pricing & Availability</a></li>
      <li><a href="#sec6"><i data-lucide="dot" width="12" height="12"></i>6. Shipping & Delivery</a></li>
      <li><a href="#sec7"><i data-lucide="dot" width="12" height="12"></i>7. Returns & Refunds</a></li>
      <li><a href="#sec8"><i data-lucide="dot" width="12" height="12"></i>8. Intellectual Property</a></li>
      <li><a href="#sec9"><i data-lucide="dot" width="12" height="12"></i>9. Disclaimer of Warranties</a></li>
      <li><a href="#sec10"><i data-lucide="dot" width="12" height="12"></i>10. Limitation of Liability</a></li>
      <li><a href="#sec11"><i data-lucide="dot" width="12" height="12"></i>11. Governing Law</a></li>
      <li><a href="#sec12"><i data-lucide="dot" width="12" height="12"></i>12. Contact & Changes</a></li>
    </ul>
  </div>

  <!-- TERMS CONTENT -->
  <div class="terms-content">

    <div class="terms-section" id="sec1">
      <div class="section-num">Section 01</div>
      <h2>Acceptance of Terms</h2>
      <p>By accessing or using the Alluvia Peptides website (alluviapeptides.com) or placing any order, you agree to be bound by these Terms & Conditions in their entirety, together with our Privacy Policy and Shipping Policy, which are incorporated herein by reference.</p>
      <p>If you do not agree with any part of these terms, you must not use this website or purchase any products. These terms constitute a legally binding agreement between you ("Customer" or "User") and Alluvia Peptides LLC ("Alluvia," "we," "us," or "our").</p>
      <div class="highlight-box"><strong>Agreement by use:</strong> Continued use of this website after any update to these Terms constitutes your acceptance of the revised Terms. We recommend reviewing this page periodically.</div>
    </div>

    <div class="terms-section" id="sec2">
      <div class="section-num">Section 02</div>
      <h2>Eligibility</h2>
      <p>To purchase from Alluvia Peptides, you must meet all of the following criteria:</p>
      <ul class="terms-list">
        <li><i data-lucide="check-circle" width="15" height="15"></i>Be at least 18 years of age</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Be a qualified researcher, licensed professional, or institutional buyer with legitimate research purposes</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Reside in a jurisdiction where the purchase, importation, and possession of research peptides is not prohibited by applicable law</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Provide accurate, complete, and truthful information when placing orders or creating an account</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Have the legal right and authority to bind yourself (or your organization) to these Terms</li>
      </ul>
      <p>Alluvia Peptides reserves the right to verify eligibility at any time and to refuse service to any individual or entity that does not meet these requirements or that we reasonably believe intends to misuse our products.</p>
    </div>

    <div class="terms-section" id="sec3">
      <div class="section-num">Section 03</div>
      <h2>Research Use Only</h2>
      <div class="warn-box"><strong>CRITICAL NOTICE:</strong> All products sold by Alluvia Peptides are sold exclusively for in vitro research and laboratory use. They are not drugs, supplements, or therapeutic agents, and have not been evaluated or approved by the U.S. Food and Drug Administration (FDA) or any equivalent regulatory body.</div>
      <p>You expressly acknowledge and agree that:</p>
      <ul class="terms-list">
        <li><i data-lucide="alert-circle" width="15" height="15" style="color:var(--coral)"></i>Products are NOT intended for human or animal consumption, injection, or any in vivo use</li>
        <li><i data-lucide="alert-circle" width="15" height="15" style="color:var(--coral)"></i>You will not use, distribute, or sell products for any purpose other than legitimate scientific research</li>
        <li><i data-lucide="alert-circle" width="15" height="15" style="color:var(--coral)"></i>You are solely responsible for ensuring compliance with all applicable laws and regulations in your jurisdiction</li>
        <li><i data-lucide="alert-circle" width="15" height="15" style="color:var(--coral)"></i>Alluvia Peptides bears no responsibility for any harm, legal consequence, or liability arising from misuse of its products</li>
      </ul>
      <p>Any misrepresentation of intended use will result in immediate cancellation of your account and any pending orders, and may be reported to relevant authorities.</p>
    </div>

    <div class="terms-section" id="sec4">
      <div class="section-num">Section 04</div>
      <h2>Orders & Payment</h2>
      <p>All orders placed through our website constitute an offer to purchase subject to our acceptance. We reserve the right to refuse or cancel any order at our sole discretion.</p>
      <h3>Order Confirmation</h3>
      <p>An automated confirmation email does not constitute acceptance of your order. Acceptance occurs when we dispatch your order. If we are unable to fulfill your order, we will notify you and issue a full refund within 5 business days.</p>
      <h3>Payment Methods</h3>
      <ul class="terms-list">
        <li><i data-lucide="credit-card" width="15" height="15"></i>Visa, Mastercard, American Express (via SSL-encrypted gateway)</li>
        <li><i data-lucide="wallet" width="15" height="15"></i>PayPal — subject to PayPal's own terms of service</li>
        <li><i data-lucide="bitcoin" width="15" height="15"></i>Cryptocurrency (BTC, ETH, USDC) — exchange rates fixed at time of order placement</li>
      </ul>
      <p>All prices are listed in US Dollars (USD). We do not store full payment card details; transactions are processed by PCI-DSS compliant third-party processors.</p>
    </div>

    <div class="terms-section" id="sec5">
      <div class="section-num">Section 05</div>
      <h2>Pricing & Product Availability</h2>
      <p>All prices displayed are subject to change without notice. We make every effort to ensure pricing accuracy, but errors may occur. In the event of a pricing error, we will notify you and offer the option to proceed at the correct price or cancel your order for a full refund.</p>
      <p>Products are subject to availability. In the event of stock unavailability after order placement, we will provide an estimated restock date and hold your order, or offer a full refund at your choice. Alluvia Peptides does not engage in backorder practices without explicit customer consent.</p>
      <div class="highlight-box"><strong>Batch lot variation:</strong> Due to the nature of peptide synthesis, purity levels, lot numbers, and COA reference numbers may vary between batches. All batches meet our minimum purity threshold of ≥98% unless otherwise stated on the product page.</div>
    </div>

    <div class="terms-section" id="sec6">
      <div class="section-num">Section 06</div>
      <h2>Shipping & Delivery</h2>
      <p>Shipping is governed by our <a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping Policy</a>, which is incorporated into these Terms by reference. Key provisions include:</p>
      <ul class="terms-list">
        <li><i data-lucide="check-circle" width="15" height="15"></i>Title and risk of loss transfer to you upon dispatch</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Delivery timelines are estimates and not guarantees</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>International customers are responsible for customs duties and compliance with local import regulations</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Cold-chain shipping is strongly recommended for all peptide orders; Alluvia is not liable for degradation resulting from customer's choice to use standard shipping</li>
      </ul>
    </div>

    <div class="terms-section" id="sec7">
      <div class="section-num">Section 07</div>
      <h2>Returns & Refunds</h2>
      <h3>Eligible for Refund / Reship</h3>
      <ul class="terms-list">
        <li><i data-lucide="check-circle" width="15" height="15"></i>Items lost in transit (confirmed by carrier trace)</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Items damaged during cold-chain shipping (photo evidence required within 48 hours)</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Incorrect items received (contact within 72 hours of delivery)</li>
        <li><i data-lucide="check-circle" width="15" height="15"></i>Items with purity below the stated COA minimum (third-party HPLC evidence required)</li>
      </ul>
      <h3>Not Eligible for Refund</h3>
      <ul class="terms-list">
        <li><i data-lucide="x-circle" width="15" height="15" style="color:var(--coral)"></i>Change of mind after dispatch</li>
        <li><i data-lucide="x-circle" width="15" height="15" style="color:var(--coral)"></i>Degradation resulting from improper customer storage after receipt</li>
        <li><i data-lucide="x-circle" width="15" height="15" style="color:var(--coral)"></i>Orders refused at customs due to local regulations</li>
        <li><i data-lucide="x-circle" width="15" height="15" style="color:var(--coral)"></i>Products that have been reconstituted or opened</li>
      </ul>
      <p>To initiate a return or refund, contact <a href="mailto:support@alluviapeptides.com">support@alluviapeptides.com</a> with your order number and relevant evidence. Refunds are processed to the original payment method within 5–10 business days of approval.</p>
    </div>

    <div class="terms-section" id="sec8">
      <div class="section-num">Section 08</div>
      <h2>Intellectual Property</h2>
      <p>All content on this website — including but not limited to text, product descriptions, molecular graphics, the Alluvia Peptides brand name and logo, photography, and design elements — is the exclusive property of Alluvia Peptides LLC and is protected by applicable copyright, trademark, and trade dress laws.</p>
      <p>You may not reproduce, distribute, republish, or create derivative works from any content on this site without our express prior written permission. Limited use for research citation purposes is permitted provided full attribution is given.</p>
    </div>

    <div class="terms-section" id="sec9">
      <div class="section-num">Section 09</div>
      <h2>Disclaimer of Warranties</h2>
      <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, ALLUVIA PEPTIDES PROVIDES THIS WEBSITE AND ALL PRODUCTS "AS IS" AND "AS AVAILABLE," WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT.</p>
      <p>We do not warrant that the website will be uninterrupted, error-free, or free from viruses. Research results and biological outcomes from the use of our peptides will vary based on experimental conditions, and we make no representations regarding expected outcomes.</p>
    </div>

    <div class="terms-section" id="sec10">
      <div class="section-num">Section 10</div>
      <h2>Limitation of Liability</h2>
      <p>TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW, ALLUVIA PEPTIDES LLC AND ITS OFFICERS, DIRECTORS, EMPLOYEES, AND AGENTS SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES, INCLUDING LOSS OF PROFITS, DATA, GOODWILL, OR BUSINESS INTERRUPTION.</p>
      <p>In no event shall our total aggregate liability exceed the greater of (a) the amount paid by you for the specific order giving rise to the claim, or (b) one hundred US dollars ($100.00).</p>
      <div class="warn-box"><strong>Indemnification:</strong> You agree to indemnify, defend, and hold harmless Alluvia Peptides LLC from any claims, liabilities, damages, losses, and expenses (including reasonable attorneys' fees) arising from your misuse of products, violation of these Terms, or infringement of any third-party rights.</div>
    </div>

    <div class="terms-section" id="sec11">
      <div class="section-num">Section 11</div>
      <h2>Governing Law & Dispute Resolution</h2>
      <p>These Terms shall be governed by and construed in accordance with the laws of the State of Delaware, United States, without regard to its conflict of law provisions.</p>
      <p>Any dispute arising from or relating to these Terms or your use of our services shall first be subject to good-faith negotiation. If unresolved within 30 days, disputes shall be submitted to binding arbitration under the rules of the American Arbitration Association (AAA). Class action claims are expressly waived.</p>
      <p>Nothing in this section prevents either party from seeking emergency injunctive relief from a court of competent jurisdiction to prevent irreparable harm.</p>
    </div>

    <div class="terms-section" id="sec12">
      <div class="section-num">Section 12</div>
      <h2>Contact & Modifications</h2>
      <p>We reserve the right to modify these Terms at any time. Changes will be effective upon posting to this page with an updated effective date. It is your responsibility to review these Terms periodically.</p>
      <p>For questions, concerns, or legal notices regarding these Terms, please contact:</p>
      <div class="highlight-box">
        <strong>Alluvia Peptides LLC — Legal Department</strong><br>
        Email: <a href="mailto:legal@alluviapeptides.com">legal@alluviapeptides.com</a><br>
        Support: <a href="mailto:support@alluviapeptides.com">support@alluviapeptides.com</a><br>
        Address: 1234 Research Blvd, Suite 200, Wilmington, DE 19801, USA
      </div>
      <p>For general customer service inquiries, visit our <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact page</a>.</p>
    </div>

  </div><!-- .terms-content -->

</div><!-- .terms-layout -->

<footer>
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo footer-logo-anchor"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/><circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/><circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a>
        <p>Pharmaceutical-grade bioactive peptides engineered for performance, longevity, and cellular renewal. HPLC verified. COA on every batch.</p>
        <div class="social-links">
          <a class="social-link" href="#"><i data-lucide="instagram" width="16" height="16"></i></a>
          <a class="social-link" href="#"><i data-lucide="twitter" width="16" height="16"></i></a>
          <a class="social-link" href="#"><i data-lucide="facebook" width="16" height="16"></i></a>
          <a class="social-link" href="#"><i data-lucide="youtube" width="16" height="16"></i></a>
        </div>
      </div>
      <div class="footer-col">
        <h4>Products</h4>
        <ul>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Medical Peptides</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Skincare Peptides</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Sports & Recovery</a></li>
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Anti-Aging</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>About Alluvia</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Contact Us</a></li>
          <li><a href="<?php echo esc_url( home_url( '/coa-library/' ) ); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>COA Library</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Terms & Conditions</a></li>
          <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Shipping Policy</a></li>
          <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Privacy Policy</a></li>
          <li><a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Disclaimer</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2025 Alluvia Peptides LLC. All rights reserved.</span>
      <div class="footer-legal">
        <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms</a>
        <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy</a>
        <a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping</a>
        <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>
      </div>
    </div>
  </div>
</footer>

<script>
lucide.createIcons();

// Scroll-spy TOC
const sections = document.querySelectorAll('.terms-section');
const tocLinks = document.querySelectorAll('.toc-list a');

window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(sec => {
    if (window.scrollY >= sec.offsetTop - 120) current = sec.id;
  });
  tocLinks.forEach(a => {
    a.classList.toggle('active', a.getAttribute('href') === '#' + current);
  });
});
</script>
<?php get_footer( 'alluvia' ); ?>
