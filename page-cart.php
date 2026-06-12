<?php
/**
 * Template Name: Alluvia – Cart
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --navy:#0d1b2a;--navy-mid:#162336;--navy-soft:#1e3050;
  --teal:#00c6b3;--teal-dark:#009e8e;--gold:#c8a96e;
  --coral:#e8758a;--purple:#9b72cf;--orange:#e07b54;
  --mint:#78c9a2;--sky:#7fb8d4;
  --pearl:#f4f2ee;--pearl-dark:#e8e4dc;
  --white:#ffffff;--text-dark:#0d1b2a;--text-mid:#4a5568;--text-light:#8899aa;
  --radius:12px;--radius-sm:8px;
}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--pearl);color:var(--text-dark);line-height:1.6}

/* NAV */
.alluvia-nav{position:fixed;top:0;left:0;right:0;z-index:1000;padding:0 2rem;height:72px;display:flex;align-items:center;justify-content:space-between;background:rgba(13,27,42,0.97);backdrop-filter:blur(20px);border-bottom:1px solid rgba(0,198,179,0.15)}
.nav-logo{display:flex;flex-direction:row;align-items:center;gap:11px;text-decoration:none}
.logo-mark{width:34px;height:34px;flex-shrink:0}
.logo-text{display:flex;flex-direction:column;line-height:1}


.nav-links{display:flex;gap:2rem;list-style:none}
.nav-links a{color:rgba(255,255,255,0.75);text-decoration:none;font-family:'Space Grotesk',sans-serif;font-size:0.85rem;font-weight:500;letter-spacing:0.05em;text-transform:uppercase;transition:color .2s}
.nav-links a:hover{color:var(--teal)}
.nav-right{display:flex;align-items:center;gap:1rem}
.nav-cart-btn{position:relative;background:var(--teal);color:var(--navy);border:none;border-radius:8px;padding:0.5rem 1rem;display:flex;align-items:center;gap:0.4rem;font-family:'Space Grotesk',sans-serif;font-size:0.8rem;font-weight:600;cursor:pointer;text-decoration:none}
.cart-count{background:var(--navy);color:var(--teal);border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700}
.nav-account-btn{background:transparent;border:1px solid rgba(255,255,255,0.2);border-radius:8px;padding:0.5rem;color:rgba(255,255,255,0.75);cursor:pointer;display:flex;align-items:center;text-decoration:none;transition:all .2s}
.nav-account-btn:hover{border-color:var(--teal);color:var(--teal)}
.nav-hamburger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:4px}
.nav-hamburger span{display:block;width:24px;height:2px;background:#fff;border-radius:2px;transition:all .3s}
.mobile-menu{display:none;position:fixed;inset:0;background:rgba(13,27,42,0.98);z-index:999;flex-direction:column;align-items:center;justify-content:center;gap:2.5rem}
.mobile-menu.open{display:flex}
.mobile-menu a{color:#fff;font-family:'Space Grotesk',sans-serif;font-size:1.5rem;font-weight:500;text-decoration:none;letter-spacing:0.05em}
.mobile-menu-close{position:absolute;top:1.5rem;right:1.5rem;background:none;border:none;color:#fff;cursor:pointer}

/* HERO STRIP */
.page-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:6rem 2rem 3rem;margin-top:72px}
.page-hero-inner{max-width:1200px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:0.78rem;color:var(--text-light);margin-bottom:1rem}
.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,5vw,3rem);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.6);font-size:0.95rem}

/* LAYOUT */
.cart-layout{max-width:1200px;margin:0 auto;padding:3rem 2rem;display:grid;grid-template-columns:1fr 360px;gap:2.5rem;align-items:start}

/* CART TABLE */
.cart-section{}
.cart-section h2{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.5rem}
.cart-table{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.06)}
.cart-header{display:grid;grid-template-columns:2fr 1fr 1fr 1fr 40px;gap:1rem;padding:1rem 1.5rem;background:var(--navy);color:rgba(255,255,255,0.6);font-family:'Space Grotesk',sans-serif;font-size:0.75rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase}
.cart-item{display:grid;grid-template-columns:2fr 1fr 1fr 1fr 40px;gap:1rem;padding:1.25rem 1.5rem;align-items:center;border-bottom:1px solid var(--pearl);transition:background .2s}
.cart-item:last-child{border-bottom:none}
.cart-item:hover{background:var(--pearl)}
.item-info{display:flex;align-items:center;gap:1rem}
.item-thumb{width:60px;height:60px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.item-thumb.teal-bg{background:linear-gradient(135deg,rgba(0,198,179,0.15),rgba(0,198,179,0.05));border:1px solid rgba(0,198,179,0.2)}
.item-thumb.coral-bg{background:linear-gradient(135deg,rgba(232,117,138,0.15),rgba(232,117,138,0.05));border:1px solid rgba(232,117,138,0.2)}
.item-thumb.gold-bg{background:linear-gradient(135deg,rgba(200,169,110,0.15),rgba(200,169,110,0.05));border:1px solid rgba(200,169,110,0.2)}
.item-details{}
.item-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:0.9rem;color:var(--text-dark)}
.item-badge{display:inline-block;font-family:'Space Grotesk',sans-serif;font-size:0.68rem;font-weight:600;letter-spacing:0.06em;padding:2px 8px;border-radius:50px;margin-top:3px}
.badge-teal{background:rgba(0,198,179,0.12);color:var(--teal-dark)}
.badge-coral{background:rgba(232,117,138,0.12);color:#c0405a}
.badge-gold{background:rgba(200,169,110,0.12);color:#a07c3a}
.item-meta{font-size:0.78rem;color:var(--text-light);margin-top:2px}
.item-price{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:0.95rem}
.qty-stepper{display:flex;align-items:center;gap:0;border:1px solid var(--pearl-dark);border-radius:8px;overflow:hidden;width:fit-content}
.qty-btn{background:#fff;border:none;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-mid);transition:all .2s}
.qty-btn:hover{background:var(--teal);color:#fff}
.qty-input{width:40px;height:32px;border:none;border-left:1px solid var(--pearl-dark);border-right:1px solid var(--pearl-dark);text-align:center;font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:0.9rem;color:var(--text-dark);outline:none;background:#fff}
.item-total{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:0.95rem;color:var(--teal-dark)}
.remove-btn{background:none;border:none;cursor:pointer;color:var(--text-light);display:flex;align-items:center;justify-content:center;border-radius:6px;width:32px;height:32px;transition:all .2s}
.remove-btn:hover{background:rgba(232,117,138,0.1);color:var(--coral)}

/* CART ACTIONS */
.cart-actions{display:flex;align-items:center;justify-content:space-between;margin-top:1.5rem;flex-wrap:wrap;gap:1rem}
.coupon-row{display:flex;gap:0.5rem;align-items:center}
.coupon-input{border:1px solid var(--pearl-dark);border-radius:8px;padding:0.6rem 1rem;font-family:'Space Grotesk',sans-serif;font-size:0.85rem;color:var(--text-dark);outline:none;width:200px;background:#fff;transition:border .2s}
.coupon-input:focus{border-color:var(--teal)}
.coupon-input::placeholder{color:var(--text-light)}
.btn-apply{background:var(--navy);color:#fff;border:none;border-radius:8px;padding:0.6rem 1.2rem;font-family:'Space Grotesk',sans-serif;font-size:0.82rem;font-weight:600;cursor:pointer;transition:all .2s;letter-spacing:0.05em}
.btn-apply:hover{background:var(--teal);color:var(--navy)}
.btn-update{background:transparent;color:var(--text-mid);border:1px solid var(--pearl-dark);border-radius:8px;padding:0.6rem 1.2rem;font-family:'Space Grotesk',sans-serif;font-size:0.82rem;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:0.4rem}
.btn-update:hover{border-color:var(--teal);color:var(--teal)}

/* DISCOUNT APPLIED */
.discount-applied{display:flex;align-items:center;justify-content:space-between;background:rgba(0,198,179,0.08);border:1px solid rgba(0,198,179,0.25);border-radius:8px;padding:0.75rem 1rem;margin-top:1rem}
.discount-info{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:0.85rem;color:var(--teal-dark);font-weight:600}
.discount-remove{background:none;border:none;cursor:pointer;color:var(--text-light);display:flex;align-items:center}
.discount-remove:hover{color:var(--coral)}

/* TRUST BADGES */
.trust-badges{display:flex;gap:1rem;margin-top:2rem;flex-wrap:wrap}
.trust-badge{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:0.78rem;color:var(--text-mid);background:#fff;border-radius:8px;padding:0.6rem 1rem;flex:1;min-width:150px;box-shadow:0 1px 6px rgba(0,0,0,0.05)}
.trust-badge svg{color:var(--teal);flex-shrink:0}

/* ORDER SUMMARY */
.order-summary{background:#fff;border-radius:var(--radius);box-shadow:0 4px 24px rgba(0,0,0,0.08);position:sticky;top:90px}
.summary-header{background:var(--navy);padding:1.25rem 1.5rem;border-radius:var(--radius) var(--radius) 0 0}
.summary-header h3{font-family:'Cormorant Garamond',serif;font-size:1.25rem;font-weight:600;color:#fff}
.summary-body{padding:1.5rem}
.summary-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:0.9rem;font-size:0.9rem}
.summary-row .label{color:var(--text-mid)}
.summary-row .value{font-family:'Space Grotesk',sans-serif;font-weight:600;color:var(--text-dark)}
.summary-row.discount .value{color:var(--teal-dark)}
.summary-row.shipping .value{color:var(--mint)}
.summary-divider{border:none;border-top:1px solid var(--pearl-dark);margin:1rem 0}
.summary-total{display:flex;justify-content:space-between;align-items:center;padding:1rem 0 0.5rem}
.summary-total .label{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:1rem}
.summary-total .value{font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:700;color:var(--navy)}
.btn-checkout{display:block;width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);border:none;border-radius:10px;padding:1rem;font-family:'Space Grotesk',sans-serif;font-size:0.95rem;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;margin-top:1.25rem;transition:all .3s;text-decoration:none;text-align:center;display:flex;align-items:center;justify-content:center;gap:0.5rem}
.btn-checkout:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,198,179,0.4)}
.summary-note{text-align:center;font-size:0.75rem;color:var(--text-light);margin-top:0.75rem;display:flex;align-items:center;justify-content:center;gap:0.3rem}
.payment-icons{display:flex;justify-content:center;gap:0.5rem;margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid var(--pearl-dark)}
.pay-icon{background:var(--pearl);border-radius:4px;padding:4px 8px;font-family:'Space Grotesk',sans-serif;font-size:0.65rem;font-weight:700;color:var(--text-mid);letter-spacing:0.04em}
.pay-icon.visa{color:#1a1f71}
.pay-icon.mc{color:#eb001b}
.pay-icon.amex{color:#007bc1}
.pay-icon.paypal{color:#003087}

/* SHIPPING ESTIMATE */
.shipping-estimate{background:rgba(120,201,162,0.08);border:1px solid rgba(120,201,162,0.25);border-radius:8px;padding:1rem;margin-top:1rem}
.shipping-estimate h4{font-family:'Space Grotesk',sans-serif;font-size:0.8rem;font-weight:700;color:var(--text-dark);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.06em}
.zip-row{display:flex;gap:0.5rem}
.zip-input{flex:1;border:1px solid var(--pearl-dark);border-radius:6px;padding:0.5rem 0.75rem;font-size:0.82rem;font-family:'Space Grotesk',sans-serif;outline:none;background:#fff}
.zip-input:focus{border-color:var(--teal)}
.zip-btn{background:var(--navy);color:#fff;border:none;border-radius:6px;padding:0.5rem 0.75rem;font-size:0.78rem;font-family:'Space Grotesk',sans-serif;font-weight:600;cursor:pointer;white-space:nowrap}

/* ALSO LIKE */
.also-like{max-width:1200px;margin:0 auto 4rem;padding:0 2rem}
.also-like h2{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-weight:600;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.5rem}
.also-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem}
.also-card{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer}
.also-card:hover{transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,0.12)}
.also-thumb{height:100px;display:flex;align-items:center;justify-content:center;position:relative}
.also-body{padding:1rem}
.also-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:0.88rem;margin-bottom:0.25rem}
.also-price{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:0.95rem;color:var(--teal-dark)}
.also-add{width:100%;background:var(--navy);color:#fff;border:none;border-radius:6px;padding:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:0.78rem;font-weight:600;cursor:pointer;margin-top:0.75rem;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:0.4rem}
.also-add:hover{background:var(--teal);color:var(--navy)}

/* FOOTER */
footer{background:#060e17;color:rgba(255,255,255,0.7);padding:5rem 2rem 2rem}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem}
.footer-brand p{font-size:0.88rem;line-height:1.7;color:rgba(255,255,255,0.5);margin:1rem 0 1.5rem}
.footer-logo{display:flex;flex-direction:column;line-height:1;margin-bottom:0.25rem}
.footer-logo span:first-child{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:#fff}
.footer-logo span:last-child{font-family:'Space Grotesk',sans-serif;font-size:0.5rem;font-weight:600;letter-spacing:0.3em;color:var(--teal);text-transform:uppercase}
.social-links{display:flex;gap:0.75rem}
.social-link{width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);transition:all .2s;cursor:pointer;text-decoration:none}
.social-link:hover{background:var(--teal);border-color:var(--teal);color:var(--navy)}
.footer-col h4{font-family:'Space Grotesk',sans-serif;font-size:0.78rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#fff;margin-bottom:1.25rem}
.footer-col ul{list-style:none}
.footer-col ul li{margin-bottom:0.6rem}
.footer-col ul li a{color:rgba(255,255,255,0.5);text-decoration:none;font-size:0.85rem;transition:color .2s;display:flex;align-items:center;gap:0.3rem}
.footer-col ul li a:hover{color:var(--teal)}
.footer-bottom{border-top:1px solid rgba(255,255,255,0.07);padding-top:2rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;font-size:0.78rem;color:rgba(255,255,255,0.35)}
.footer-legal{display:flex;gap:1.5rem;flex-wrap:wrap}
.footer-legal a{color:rgba(255,255,255,0.35);text-decoration:none;transition:color .2s}
.footer-legal a:hover{color:var(--teal)}

/* RESPONSIVE */
@media(max-width:1100px){.also-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){
  .cart-layout{grid-template-columns:1fr}
  .order-summary{position:static}
  .footer-grid{grid-template-columns:1fr 1fr}
  .cart-header{display:none}
  .cart-item{grid-template-columns:1fr auto;gap:0.75rem}
  .cart-item .item-price,.cart-item .item-total{display:none}
  .item-info{grid-column:1/3}
}
@media(max-width:640px){
  .nav-links{display:none}
  .nav-hamburger{display:flex}
  .trust-badges{flex-direction:column}
  .also-grid{grid-template-columns:1fr 1fr}
  .footer-grid{grid-template-columns:1fr}
  .cart-actions{flex-direction:column;align-items:flex-start}
}
@media(max-width:400px){.also-grid{grid-template-columns:1fr}}
</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<nav class="alluvia-nav" id="nav">
  <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#00c6b3" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#00c6b3"/><circle cx="10.5" cy="21" r="2.2" fill="#00c6b3"/><circle cx="23.5" cy="21" r="2.2" fill="#00c6b3"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a>
  <ul class="nav-links">
    <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>">Products</a></li>
    <li><a href="<?php echo esc_url(home_url('/about/')); ?>#science">Science</a></li>
    <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
    <li><a href="<?php echo esc_url(home_url('/')); ?>#reviews">Reviews</a></li>
    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
  </ul>
  <div class="nav-right">
    <a href="<?php echo esc_url(alluvia_cart_url()); ?>" class="nav-cart-btn">
      <i data-lucide="shopping-bag" width="16" height="16"></i>
      Cart
      <span class="cart-count">4</span>
    </a>
    <a href="<?php echo esc_url(alluvia_account_url()); ?>" class="nav-account-btn">
      <i data-lucide="user" width="18" height="18"></i>
    </a>
    <button class="nav-hamburger" onclick="document.getElementById('mobileMenu').classList.toggle('open')">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div class="mobile-menu" id="mobileMenu">
  <button class="mobile-menu-close" onclick="document.getElementById('mobileMenu').classList.remove('open')">
    <i data-lucide="x" width="28" height="28"></i>
  </button>
  <a href="<?php echo esc_url(alluvia_shop_url()); ?>">Products</a>
  <a href="<?php echo esc_url(home_url('/about/')); ?>">About</a>
  <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a>
  <a href="<?php echo esc_url(alluvia_cart_url()); ?>">Cart (4)</a>
  <a href="<?php echo esc_url(alluvia_account_url()); ?>">Account</a>
</div>

<div class="page-hero">
  <div class="page-hero-inner">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <i data-lucide="chevron-right" width="14" height="14"></i>
      <span>Shopping Cart</span>
    </div>
    <h1>Your Cart</h1>
    <p>Review your peptide selection before checkout.</p>
  </div>
</div>

<div class="cart-layout">

  <!-- LEFT: CART TABLE -->
  <div class="cart-section">
    <h2><i data-lucide="shopping-cart" width="22" height="22" style="color:var(--teal)"></i> 4 Items</h2>

    <div class="cart-table">
      <div class="cart-header">
        <span>Product</span>
        <span>Price</span>
        <span>Quantity</span>
        <span>Total</span>
        <span></span>
      </div>

      <!-- Item 1: BPC-157 ×2 -->
      <div class="cart-item">
        <div class="item-info">
          <div class="item-thumb teal-bg">
            <i data-lucide="activity" width="28" height="28" style="color:var(--teal)"></i>
          </div>
          <div class="item-details">
            <div class="item-name">BPC-157 — 5 mg Vial</div>
            <span class="item-badge badge-teal">Medical Peptide</span>
            <div class="item-meta">Lyophilized · HPLC ≥99% · COA included</div>
          </div>
        </div>
        <div class="item-price">$65.00</div>
        <div class="qty-stepper">
          <button class="qty-btn" onclick="changeQty(this,-1)"><i data-lucide="minus" width="12" height="12"></i></button>
          <input class="qty-input" type="number" value="2" min="1" max="99" onchange="updateTotals()">
          <button class="qty-btn" onclick="changeQty(this,1)"><i data-lucide="plus" width="12" height="12"></i></button>
        </div>
        <div class="item-total">$130.00</div>
        <button class="remove-btn" onclick="removeItem(this)" title="Remove"><i data-lucide="trash-2" width="16" height="16"></i></button>
      </div>

      <!-- Item 2: GHK-Cu ×1 -->
      <div class="cart-item">
        <div class="item-info">
          <div class="item-thumb coral-bg">
            <i data-lucide="sparkles" width="28" height="28" style="color:var(--coral)"></i>
          </div>
          <div class="item-details">
            <div class="item-name">GHK-Cu — 200 mg Powder</div>
            <span class="item-badge badge-coral">Skincare Peptide</span>
            <div class="item-meta">Copper tripeptide-1 · &gt;98% purity · COA included</div>
          </div>
        </div>
        <div class="item-price">$52.00</div>
        <div class="qty-stepper">
          <button class="qty-btn" onclick="changeQty(this,-1)"><i data-lucide="minus" width="12" height="12"></i></button>
          <input class="qty-input" type="number" value="1" min="1" max="99" onchange="updateTotals()">
          <button class="qty-btn" onclick="changeQty(this,1)"><i data-lucide="plus" width="12" height="12"></i></button>
        </div>
        <div class="item-total">$52.00</div>
        <button class="remove-btn" onclick="removeItem(this)" title="Remove"><i data-lucide="trash-2" width="16" height="16"></i></button>
      </div>

      <!-- Item 3: Ipamorelin ×1 -->
      <div class="cart-item">
        <div class="item-info">
          <div class="item-thumb gold-bg">
            <i data-lucide="zap" width="28" height="28" style="color:var(--gold)"></i>
          </div>
          <div class="item-details">
            <div class="item-name">Ipamorelin — 2 mg Vial</div>
            <span class="item-badge badge-gold">Hormone & Anti-Aging</span>
            <div class="item-meta">GH secretagogue · Lyophilized · &gt;98.5% purity</div>
          </div>
        </div>
        <div class="item-price">$68.00</div>
        <div class="qty-stepper">
          <button class="qty-btn" onclick="changeQty(this,-1)"><i data-lucide="minus" width="12" height="12"></i></button>
          <input class="qty-input" type="number" value="1" min="1" max="99" onchange="updateTotals()">
          <button class="qty-btn" onclick="changeQty(this,1)"><i data-lucide="plus" width="12" height="12"></i></button>
        </div>
        <div class="item-total">$68.00</div>
        <button class="remove-btn" onclick="removeItem(this)" title="Remove"><i data-lucide="trash-2" width="16" height="16"></i></button>
      </div>
    </div><!-- .cart-table -->

    <!-- COUPON + UPDATE -->
    <div class="cart-actions">
      <div class="coupon-row">
        <input class="coupon-input" type="text" id="couponInput" placeholder="Promo code (try WELCOME10)" value="">
        <button class="btn-apply" onclick="applyCoupon()">Apply</button>
      </div>
      <button class="btn-update" onclick="updateCart()">
        <i data-lucide="refresh-cw" width="14" height="14"></i>
        Update Cart
      </button>
    </div>

    <div class="discount-applied" id="discountRow" style="display:none">
      <div class="discount-info">
        <i data-lucide="tag" width="16" height="16"></i>
        <span>WELCOME10 — 10% off applied (−$<span id="discountAmt">25.00</span>)</span>
      </div>
      <button class="discount-remove" onclick="removeCoupon()" title="Remove coupon">
        <i data-lucide="x" width="16" height="16"></i>
      </button>
    </div>

    <!-- TRUST BADGES -->
    <div class="trust-badges">
      <div class="trust-badge">
        <i data-lucide="shield-check" width="16" height="16"></i>
        SSL Encrypted Checkout
      </div>
      <div class="trust-badge">
        <i data-lucide="thermometer-snowflake" width="16" height="16"></i>
        Cold-Chain Shipping Available
      </div>
      <div class="trust-badge">
        <i data-lucide="award" width="16" height="16"></i>
        COA on Every Batch
      </div>
      <div class="trust-badge">
        <i data-lucide="rotate-ccw" width="16" height="16"></i>
        Integrity Guarantee
      </div>
    </div>
  </div><!-- .cart-section -->

  <!-- RIGHT: ORDER SUMMARY -->
  <div class="order-summary">
    <div class="summary-header">
      <h3>Order Summary</h3>
    </div>
    <div class="summary-body">
      <div class="summary-row">
        <span class="label">Subtotal (4 items)</span>
        <span class="value" id="subtotalVal">$250.00</span>
      </div>
      <div class="summary-row discount" id="discountSummaryRow" style="display:none">
        <span class="label">Discount (WELCOME10)</span>
        <span class="value">−$<span id="discountSummaryAmt">25.00</span></span>
      </div>
      <div class="summary-row shipping">
        <span class="label">Cold-Chain Fee</span>
        <span class="value">$9.99</span>
      </div>
      <div class="summary-row">
        <span class="label">Estimated Tax</span>
        <span class="value" id="taxVal">$22.50</span>
      </div>
      <hr class="summary-divider">
      <div class="summary-total">
        <span class="label">Total</span>
        <span class="value" id="totalVal">$282.49</span>
      </div>

      <a href="<?php echo esc_url(alluvia_checkout_url()); ?>" class="btn-checkout">
        <i data-lucide="lock" width="16" height="16"></i>
        Proceed to Checkout
      </a>

      <p class="summary-note">
        <i data-lucide="shield" width="12" height="12"></i>
        Secured by 256-bit SSL encryption
      </p>

      <div class="payment-icons">
        <span class="pay-icon visa">VISA</span>
        <span class="pay-icon mc">MC</span>
        <span class="pay-icon amex">AMEX</span>
        <span class="pay-icon paypal">PayPal</span>
      </div>

      <!-- SHIPPING ESTIMATE -->
      <div class="shipping-estimate">
        <h4>Estimate Shipping</h4>
        <div class="zip-row">
          <input class="zip-input" type="text" placeholder="ZIP / Postal Code" id="zipInput">
          <button class="zip-btn" onclick="estimateShipping()">Estimate</button>
        </div>
        <div id="shippingResult" style="font-size:0.82rem;color:var(--teal-dark);margin-top:0.6rem;display:none">
          <i data-lucide="check-circle" width="14" height="14" style="vertical-align:middle;margin-right:4px"></i>
          Standard (3–5 days): <strong>Free</strong> · Express (1–2 days): <strong>$12.99</strong>
        </div>
      </div>
    </div>
  </div><!-- .order-summary -->

</div><!-- .cart-layout -->

<!-- YOU MAY ALSO LIKE -->
<div class="also-like">
  <h2><i data-lucide="heart" width="22" height="22" style="color:var(--coral)"></i> You May Also Like</h2>
  <div class="also-grid">
    <div class="also-card">
      <div class="also-thumb" style="background:linear-gradient(135deg,rgba(155,114,207,0.15),rgba(155,114,207,0.05))">
        <i data-lucide="trending-down" width="32" height="32" style="color:var(--purple)"></i>
      </div>
      <div class="also-body">
        <div class="also-name">AOD-9604 — 5 mg Vial</div>
        <div class="also-price">$58.00</div>
        <button class="also-add"><i data-lucide="plus" width="14" height="14"></i> Add to Cart</button>
      </div>
    </div>
    <div class="also-card">
      <div class="also-thumb" style="background:linear-gradient(135deg,rgba(224,123,84,0.15),rgba(224,123,84,0.05))">
        <i data-lucide="dumbbell" width="32" height="32" style="color:var(--orange)"></i>
      </div>
      <div class="also-body">
        <div class="also-name">TB-500 — 5 mg Vial</div>
        <div class="also-price">$78.00</div>
        <button class="also-add"><i data-lucide="plus" width="14" height="14"></i> Add to Cart</button>
      </div>
    </div>
    <div class="also-card">
      <div class="also-thumb" style="background:linear-gradient(135deg,rgba(120,201,162,0.15),rgba(120,201,162,0.05))">
        <i data-lucide="feather" width="32" height="32" style="color:var(--mint)"></i>
      </div>
      <div class="also-body">
        <div class="also-name">PTD-DBM — 10 mg Vial</div>
        <div class="also-price">$55.00</div>
        <button class="also-add"><i data-lucide="plus" width="14" height="14"></i> Add to Cart</button>
      </div>
    </div>
    <div class="also-card">
      <div class="also-thumb" style="background:linear-gradient(135deg,rgba(127,184,212,0.15),rgba(127,184,212,0.05))">
        <i data-lucide="dna" width="32" height="32" style="color:var(--sky)"></i>
      </div>
      <div class="also-body">
        <div class="also-name">Epithalon — 10 mg Vial</div>
        <div class="also-price">$95.00</div>
        <button class="also-add"><i data-lucide="plus" width="14" height="14"></i> Add to Cart</button>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="footer-inner">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo footer-logo-anchor"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#00c6b3" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#00c6b3"/><circle cx="10.5" cy="21" r="2.2" fill="#00c6b3"/><circle cx="23.5" cy="21" r="2.2" fill="#00c6b3"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a>
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
          <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Research Peptides</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Company</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>About Alluvia</a></li>
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>#science"><i data-lucide="chevron-right" width="12" height="12"></i>Our Science</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Contact Us</a></li>
          <li><a href="#"><i data-lucide="chevron-right" width="12" height="12"></i>COA Library</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <ul>
          <li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Terms & Conditions</a></li>
          <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Shipping Policy</a></li>
          <li><a href="#"><i data-lucide="chevron-right" width="12" height="12"></i>Privacy Policy</a></li>
          <li><a href="#"><i data-lucide="chevron-right" width="12" height="12"></i>Disclaimer</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2025 Alluvia Peptides. All rights reserved.</span>
      <div class="footer-legal">
        <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms</a>
        <a href="#">Privacy</a>
        <a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping</a>
        <a href="#">Disclaimer</a>
      </div>
    </div>
  </div>
</footer>

<script>
lucide.createIcons();

const ITEM_PRICES = [65, 52, 68];

function getQtys() {
  return Array.from(document.querySelectorAll('.qty-input')).map(i => parseInt(i.value) || 1);
}

function changeQty(btn, delta) {
  const input = btn.parentElement.querySelector('.qty-input');
  const newVal = Math.max(1, (parseInt(input.value) || 1) + delta);
  input.value = newVal;
  updateTotals();
}

let couponActive = false;

function updateTotals() {
  const items = document.querySelectorAll('.cart-item');
  let subtotal = 0;
  items.forEach((item, i) => {
    if (i >= ITEM_PRICES.length) return;
    const qty = parseInt(item.querySelector('.qty-input')?.value) || 1;
    const rowTotal = ITEM_PRICES[i] * qty;
    subtotal += rowTotal;
    const totalEl = item.querySelector('.item-total');
    if (totalEl) totalEl.textContent = '$' + rowTotal.toFixed(2);
  });

  const discount = couponActive ? subtotal * 0.10 : 0;
  const tax = (subtotal - discount) * 0.09;
  const total = subtotal - discount + 9.99 + tax;

  document.getElementById('subtotalVal').textContent = '$' + subtotal.toFixed(2);
  document.getElementById('taxVal').textContent = '$' + tax.toFixed(2);
  document.getElementById('totalVal').textContent = '$' + total.toFixed(2);

  if (couponActive) {
    document.getElementById('discountAmt').textContent = discount.toFixed(2);
    document.getElementById('discountSummaryAmt').textContent = discount.toFixed(2);
  }
}

function applyCoupon() {
  const code = document.getElementById('couponInput').value.trim().toUpperCase();
  if (code === 'WELCOME10') {
    couponActive = true;
    document.getElementById('discountRow').style.display = 'flex';
    document.getElementById('discountSummaryRow').style.display = 'flex';
    document.getElementById('couponInput').value = 'WELCOME10';
    updateTotals();
    showToast('Coupon WELCOME10 applied — 10% off!');
  } else if (code === '') {
    showToast('Enter a promo code first.');
  } else {
    showToast('Invalid promo code. Try WELCOME10.', true);
  }
}

function removeCoupon() {
  couponActive = false;
  document.getElementById('discountRow').style.display = 'none';
  document.getElementById('discountSummaryRow').style.display = 'none';
  document.getElementById('couponInput').value = '';
  updateTotals();
}

function removeItem(btn) {
  const item = btn.closest('.cart-item');
  item.style.opacity = '0';
  item.style.transform = 'translateX(20px)';
  item.style.transition = 'all 0.3s';
  setTimeout(() => { item.remove(); updateTotals(); }, 300);
}

function updateCart() { updateTotals(); showToast('Cart updated.'); }

function estimateShipping() {
  const zip = document.getElementById('zipInput').value.trim();
  if (zip.length >= 4) {
    document.getElementById('shippingResult').style.display = 'block';
    lucide.createIcons();
  } else {
    showToast('Enter a valid ZIP code.', true);
  }
}

function showToast(msg, err = false) {
  const t = document.createElement('div');
  t.textContent = msg;
  Object.assign(t.style, {
    position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',
    background: err ? '#c0405a' : '#00c6b3',color: err ? '#fff' : '#0d1b2a',
    padding:'0.75rem 1.5rem',borderRadius:'50px',fontFamily:"'Space Grotesk',sans-serif",
    fontSize:'0.85rem',fontWeight:'600',zIndex:'9999',
    boxShadow:'0 8px 24px rgba(0,0,0,0.2)',transition:'opacity 0.3s'
  });
  document.body.appendChild(t);
  setTimeout(() => { t.style.opacity='0'; setTimeout(() => t.remove(), 300); }, 2500);
}

document.querySelectorAll('.also-add').forEach(btn => {
  btn.addEventListener('click', () => showToast('Added to cart!'));
});
</script>
<?php get_footer( 'alluvia' ); ?>
