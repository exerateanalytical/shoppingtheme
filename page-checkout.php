<?php
/**
 * Template Name: Alluvia – Checkout
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
/* CHECKOUT NAV SUPPLEMENT */
.nav-secure{display:flex;align-items:center;gap:0.4rem;font-family:'Space Grotesk',sans-serif;font-size:var(--fs-sm);color:rgba(255,255,255,0.70)}
.nav-secure svg{color:var(--teal)}

/* HERO STRIP */
.page-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:6rem 2rem 2.5rem;margin-top:72px}
.page-hero-inner{max-width:1100px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:13px;color:var(--text-light);margin-bottom:1rem}
.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(36px,4.5vw,60px);font-weight:600;color:#fff}

/* PROGRESS STEPS */
.progress-wrap{max-width:1100px;margin:0 auto;padding:2rem 2rem 0}
.progress-steps{display:flex;align-items:center;gap:0;background:#fff;border-radius:var(--radius);padding:1.25rem 2rem;box-shadow:0 2px 12px rgba(0,0,0,0.06);margin-bottom:2rem}
.step{display:flex;align-items:center;gap:0.75rem;flex:1;position:relative}
.step:not(:last-child)::after{content:'';position:absolute;right:0;top:50%;transform:translateY(-50%);width:100%;height:2px;background:var(--pearl-dark);z-index:0;left:60px}
.step-circle{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:15px;flex-shrink:0;z-index:1;position:relative;transition:all .3s}
.step-circle.done{background:var(--teal);color:var(--navy)}
.step-circle.active{background:var(--navy);color:#fff;box-shadow:0 0 0 4px rgba(14,175,159,0.2)}
.step-circle.pending{background:var(--pearl-dark);color:var(--text-light)}
.step-label{font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em}
.step-label.done{color:var(--teal-dark)}
.step-label.active{color:var(--navy)}
.step-label.pending{color:var(--text-light)}

/* LAYOUT */
.checkout-layout{max-width:1100px;margin:0 auto;padding:0 2rem 4rem;display:grid;grid-template-columns:1fr 360px;gap:2.5rem;align-items:start}

/* FORMS */
.checkout-panel{background:#fff;border-radius:var(--radius);box-shadow:0 2px 16px rgba(0,0,0,0.06);overflow:hidden}
.panel-header{background:var(--navy);padding:1.25rem 1.75rem;display:flex;align-items:center;gap:0.75rem}
.panel-header h2{font-family:'Cormorant Garamond',serif;font-size:21px;font-weight:600;color:#fff}
.panel-header svg{color:var(--teal)}
.panel-body{padding:1.75rem}

/* TABS (shipping/payment/review) */
.tab-content{display:none}
.tab-content.active{display:block}

/* FORM FIELDS */
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem}
.form-row.full{grid-template-columns:1fr}
.form-group{display:flex;flex-direction:column;gap:0.35rem}
.form-group label{font-family:'Space Grotesk',sans-serif;font-size:var(--fs-ui);font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-mid)}
.form-group input,.form-group select{border:1px solid var(--pearl-dark);border-radius:8px;padding:0.7rem 1rem;font-family:'Inter',sans-serif;font-size:var(--fs-base);color:var(--text-dark);outline:none;transition:border .2s;background:#fff}
.form-group input:focus,.form-group select:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(14,175,159,0.1)}
.form-group input::placeholder{color:var(--text-light)}

/* SHIPPING OPTIONS */
.shipping-options{display:flex;flex-direction:column;gap:0.75rem;margin:1.25rem 0}
.ship-opt{border:2px solid var(--pearl-dark);border-radius:10px;padding:1rem 1.25rem;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:1rem}
.ship-opt:hover{border-color:var(--teal);background:rgba(14,175,159,0.03)}
.ship-opt.selected{border-color:var(--teal);background:rgba(14,175,159,0.05)}
.ship-opt input[type=radio]{accent-color:var(--teal);width:18px;height:18px;flex-shrink:0}
.ship-info{flex:1}
.ship-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:15px}
.ship-desc{font-size:var(--fs-base);color:var(--text-light);margin-top:2px}
.ship-price{font-family:'Space Grotesk',sans-serif;font-weight:700;color:var(--teal-dark)}
.ship-badge{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.08em;padding:2px 8px;border-radius:50px;text-transform:uppercase}
.badge-free{background:rgba(88,180,136,0.15);color:#2d8a5f}
.badge-cold{background:rgba(106,166,198,0.15);color:#2d6e8a}

/* PAYMENT SECTION */
.payment-methods{display:flex;gap:0.75rem;margin-bottom:1.5rem;flex-wrap:wrap}
.pay-method{border:2px solid var(--pearl-dark);border-radius:8px;padding:0.6rem 1rem;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:0.4rem;font-family:'Space Grotesk',sans-serif;font-size:var(--fs-ui);font-weight:600;color:var(--text-mid)}
.pay-method:hover{border-color:var(--teal)}
.pay-method.active{border-color:var(--teal);color:var(--teal-dark);background:rgba(14,175,159,0.05)}
.card-form{}
.card-number-wrap{position:relative}
.card-icons{position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);display:flex;gap:0.25rem}
.c-icon{font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;padding:2px 5px;border-radius:3px;background:var(--pearl);color:var(--text-mid)}
.secure-note{display:flex;align-items:center;gap:0.4rem;font-size:var(--fs-base);color:var(--text-light);margin-top:1rem}
.secure-note svg{color:var(--teal)}

/* REVIEW ORDER */
.review-items{margin-bottom:1.25rem}
.review-item{display:flex;align-items:center;gap:1rem;padding:0.75rem 0;border-bottom:1px solid var(--pearl)}
.review-item:last-child{border-bottom:none}
.review-thumb{width:48px;height:48px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.review-item-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:var(--fs-base)}
.review-item-qty{font-size:var(--fs-base);color:var(--text-light)}
.review-item-price{margin-left:auto;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:var(--fs-body)}

/* NAV BUTTONS */
.form-nav{display:flex;justify-content:space-between;align-items:center;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--pearl)}
.btn-back{background:transparent;border:1px solid var(--pearl-dark);color:var(--text-mid);border-radius:8px;padding:0.75rem 1.5rem;font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.4rem;transition:all .2s}
.btn-back:hover{border-color:var(--teal);color:var(--teal)}
.btn-next{background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);border:none;border-radius:8px;padding:0.75rem 2rem;font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;letter-spacing:0.05em;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:all .3s}
.btn-next:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(14,175,159,0.35)}
.btn-place{background:linear-gradient(135deg,var(--gold),#a07c3a);color:#fff;border:none;border-radius:8px;padding:0.75rem 2rem;font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;letter-spacing:0.05em;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:all .3s;text-transform:uppercase}
.btn-place:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(198,162,83,0.4)}

/* ORDER SIDEBAR */
.order-sidebar{background:#fff;border-radius:var(--radius);box-shadow:0 4px 24px rgba(0,0,0,0.08);position:sticky;top:90px}
.sidebar-header{background:var(--navy);padding:1.25rem 1.5rem;border-radius:var(--radius) var(--radius) 0 0}
.sidebar-header h3{font-family:'Cormorant Garamond',serif;font-size:19px;font-weight:600;color:#fff}
.sidebar-body{padding:1.5rem}
.sidebar-items{}
.s-item{display:flex;justify-content:space-between;align-items:flex-start;padding:0.6rem 0;border-bottom:1px solid var(--pearl);font-size:var(--fs-base)}
.s-item:last-child{border-bottom:none}
.s-item-name{color:var(--text-dark);font-weight:500}
.s-item-qty{color:var(--text-light);font-size:var(--fs-base)}
.s-item-price{font-family:'Space Grotesk',sans-serif;font-weight:600;flex-shrink:0;margin-left:0.5rem}
.s-divider{border:none;border-top:1px solid var(--pearl-dark);margin:1rem 0}
.s-row{display:flex;justify-content:space-between;font-size:var(--fs-base);margin-bottom:0.6rem}
.s-row .lbl{color:var(--text-mid)}
.s-row .val{font-family:'Space Grotesk',sans-serif;font-weight:600}
.s-total{display:flex;justify-content:space-between;padding-top:0.75rem}
.s-total .lbl{font-family:'Space Grotesk',sans-serif;font-weight:700}
.s-total .val{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:700}
.sidebar-trust{padding:1.25rem 1.5rem;border-top:1px solid var(--pearl);display:flex;flex-direction:column;gap:0.6rem}
.s-trust-item{display:flex;align-items:center;gap:0.5rem;font-size:var(--fs-base);color:var(--text-mid)}
.s-trust-item svg{color:var(--teal);flex-shrink:0}

/* SUCCESS OVERLAY */
.success-overlay{display:none;position:fixed;inset:0;background:rgba(10,26,39,0.92);z-index:2000;align-items:center;justify-content:center}
.success-overlay.show{display:flex}
.success-card{background:#fff;border-radius:16px;padding:3rem;max-width:480px;width:90%;text-align:center;animation:popIn .4s ease}
@keyframes popIn{from{transform:scale(0.8);opacity:0}to{transform:scale(1);opacity:1}}
.success-icon{width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,rgba(14,175,159,0.2),rgba(14,175,159,0.05));border:2px solid var(--teal);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;color:var(--teal)}
.success-card h2{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:600;margin-bottom:0.75rem}
.success-card p{color:var(--text-mid);margin-bottom:0.5rem;font-size:15px}
.success-order{font-family:'Space Grotesk',sans-serif;font-weight:700;color:var(--teal-dark);font-size:16px;margin:0.5rem 0 1.5rem}
.success-actions{display:flex;gap:1rem;justify-content:center;flex-wrap:wrap}
.btn-track{background:var(--navy);color:#fff;border:none;border-radius:8px;padding:0.75rem 1.5rem;font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem}
.btn-continue{background:transparent;color:var(--teal-dark);border:1px solid var(--teal);border-radius:8px;padding:0.75rem 1.5rem;font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem}

/* RESPONSIVE */
@media(max-width:900px){
  .checkout-layout{grid-template-columns:1fr}
  .order-sidebar{position:static}
  .form-row{grid-template-columns:1fr}
}
@media(max-width:640px){
  .progress-steps{padding:1rem;gap:0.5rem}
  .step-label{display:none}
  .step:not(:last-child)::after{left:48px}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<nav class="alluvia-nav">
  <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/><circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/><circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a>
  <div class="nav-secure">
    <i data-lucide="lock" width="14" height="14"></i>
    Secure Checkout
  </div>
</nav>

<div class="page-hero">
  <div class="page-hero-inner">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <i data-lucide="chevron-right" width="14" height="14"></i>
      <a href="<?php echo esc_url(alluvia_cart_url()); ?>">Cart</a>
      <i data-lucide="chevron-right" width="14" height="14"></i>
      <span>Checkout</span>
    </div>
    <h1>Secure Checkout</h1>
  </div>
</div>

<!-- PROGRESS -->
<div class="progress-wrap">
  <div class="progress-steps">
    <div class="step">
      <div class="step-circle active" id="step1-circle">1</div>
      <span class="step-label active" id="step1-label">Shipping</span>
    </div>
    <div class="step">
      <div class="step-circle pending" id="step2-circle">2</div>
      <span class="step-label pending" id="step2-label">Payment</span>
    </div>
    <div class="step">
      <div class="step-circle pending" id="step3-circle">3</div>
      <span class="step-label pending" id="step3-label">Review</span>
    </div>
  </div>
</div>

<div class="checkout-layout">

  <!-- MAIN FORM -->
  <div class="checkout-panel">
    <div class="panel-header">
      <i data-lucide="map-pin" width="20" height="20" id="panelIcon"></i>
      <h2 id="panelTitle">Shipping Information</h2>
    </div>
    <div class="panel-body">

      <!-- STEP 1: SHIPPING -->
      <div class="tab-content active" id="tab1">
        <div class="form-row">
          <div class="form-group">
            <label>First Name</label>
            <input type="text" placeholder="Alexandra">
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" placeholder="Chen">
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label>Email Address</label>
            <input type="email" placeholder="alex@example.com">
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" placeholder="+1 (555) 000-0000">
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label>Address Line 1</label>
            <input type="text" placeholder="123 Wellness Avenue">
          </div>
        </div>
        <div class="form-row full">
          <div class="form-group">
            <label>Address Line 2 (optional)</label>
            <input type="text" placeholder="Suite, apt, floor…">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>City</label>
            <input type="text" placeholder="Los Angeles">
          </div>
          <div class="form-group">
            <label>State / Province</label>
            <input type="text" placeholder="CA">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>ZIP / Postal Code</label>
            <input type="text" placeholder="90001">
          </div>
          <div class="form-group">
            <label>Country</label>
            <select>
              <option>United States</option>
              <option>Canada</option>
              <option>United Kingdom</option>
              <option>Australia</option>
              <option>Germany</option>
              <option>Other</option>
            </select>
          </div>
        </div>

        <h3 style="font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-top:1.5rem;margin-bottom:0.5rem">Shipping Method</h3>
        <div class="shipping-options">
          <label class="ship-opt selected">
            <input type="radio" name="shipping" value="standard" checked onchange="selectShipping(this)">
            <div class="ship-info">
              <div class="ship-name">Standard Shipping <span class="ship-badge badge-free">Free</span></div>
              <div class="ship-desc">3–5 business days · Standard packaging</div>
            </div>
            <div class="ship-price">Free</div>
          </label>
          <label class="ship-opt">
            <input type="radio" name="shipping" value="express" onchange="selectShipping(this)">
            <div class="ship-info">
              <div class="ship-name">Express Shipping</div>
              <div class="ship-desc">1–2 business days · Signature required</div>
            </div>
            <div class="ship-price">$12.99</div>
          </label>
          <label class="ship-opt">
            <input type="radio" name="shipping" value="coldchain" onchange="selectShipping(this)">
            <div class="ship-info">
              <div class="ship-name">Cold-Chain Overnight <span class="ship-badge badge-cold">Recommended</span></div>
              <div class="ship-desc">Next business day · Insulated + ice packs · Integrity guaranteed</div>
            </div>
            <div class="ship-price">$24.99</div>
          </label>
        </div>

        <div class="form-nav">
          <a href="<?php echo esc_url(alluvia_cart_url()); ?>" class="btn-back"><i data-lucide="arrow-left" width="16" height="16"></i> Back to Cart</a>
          <button class="btn-next" onclick="goStep(2)">Continue to Payment <i data-lucide="arrow-right" width="16" height="16"></i></button>
        </div>
      </div>

      <!-- STEP 2: PAYMENT -->
      <div class="tab-content" id="tab2">
        <div class="payment-methods">
          <button class="pay-method active" onclick="setPayMethod(this,'card')">
            <i data-lucide="credit-card" width="16" height="16"></i> Credit / Debit
          </button>
          <button class="pay-method" onclick="setPayMethod(this,'paypal')">
            <i data-lucide="wallet" width="16" height="16"></i> PayPal
          </button>
          <button class="pay-method" onclick="setPayMethod(this,'crypto')">
            <i data-lucide="bitcoin" width="16" height="16"></i> Crypto
          </button>
        </div>

        <div id="cardForm">
          <div class="form-row full">
            <div class="form-group">
              <label>Name on Card</label>
              <input type="text" placeholder="Alexandra Chen">
            </div>
          </div>
          <div class="form-row full">
            <div class="form-group">
              <label>Card Number</label>
              <div class="card-number-wrap">
                <input type="text" placeholder="1234 5678 9012 3456" maxlength="19" oninput="formatCard(this)">
                <div class="card-icons">
                  <span class="c-icon">VISA</span>
                  <span class="c-icon">MC</span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Expiry Date</label>
              <input type="text" placeholder="MM / YY" maxlength="7">
            </div>
            <div class="form-group">
              <label>CVC / CVV</label>
              <input type="text" placeholder="•••" maxlength="4">
            </div>
          </div>
          <div class="secure-note">
            <i data-lucide="shield-check" width="14" height="14"></i>
            Your payment info is encrypted and never stored on our servers.
          </div>
        </div>

        <div id="paypalForm" style="display:none;text-align:center;padding:2rem 0">
          <i data-lucide="wallet" width="48" height="48" style="color:#003087;margin-bottom:1rem"></i>
          <p style="color:var(--text-mid);font-size:14px">You will be redirected to PayPal to complete your purchase securely.</p>
        </div>

        <div id="cryptoForm" style="display:none;text-align:center;padding:2rem 0">
          <i data-lucide="bitcoin" width="48" height="48" style="color:var(--gold);margin-bottom:1rem"></i>
          <p style="color:var(--text-mid);font-size:14px">Accepted: BTC, ETH, USDC. A wallet address will be provided after order review.</p>
        </div>

        <div class="form-nav">
          <button class="btn-back" onclick="goStep(1)"><i data-lucide="arrow-left" width="16" height="16"></i> Back</button>
          <button class="btn-next" onclick="goStep(3)">Review Order <i data-lucide="arrow-right" width="16" height="16"></i></button>
        </div>
      </div>

      <!-- STEP 3: REVIEW -->
      <div class="tab-content" id="tab3">
        <h3 style="font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:1rem">Order Items</h3>
        <div class="review-items">
          <div class="review-item">
            <div class="review-thumb" style="background:rgba(14,175,159,0.1)"><i data-lucide="activity" width="22" height="22" style="color:var(--teal)"></i></div>
            <div>
              <div class="review-item-name">BPC-157 — 5 mg Vial</div>
              <div class="review-item-qty">Qty: 2</div>
            </div>
            <div class="review-item-price">$130.00</div>
          </div>
          <div class="review-item">
            <div class="review-thumb" style="background:rgba(219,98,122,0.1)"><i data-lucide="sparkles" width="22" height="22" style="color:var(--coral)"></i></div>
            <div>
              <div class="review-item-name">GHK-Cu — 200 mg Powder</div>
              <div class="review-item-qty">Qty: 1</div>
            </div>
            <div class="review-item-price">$52.00</div>
          </div>
          <div class="review-item">
            <div class="review-thumb" style="background:rgba(198,162,83,0.1)"><i data-lucide="zap" width="22" height="22" style="color:var(--gold)"></i></div>
            <div>
              <div class="review-item-name">Ipamorelin — 2 mg Vial</div>
              <div class="review-item-qty">Qty: 1</div>
            </div>
            <div class="review-item-price">$68.00</div>
          </div>
        </div>

        <div style="background:var(--pearl);border-radius:8px;padding:1rem;margin-bottom:1rem">
          <h4 style="font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.75rem;color:var(--text-mid)">Shipping To</h4>
          <p style="font-size:14px;color:var(--text-dark)">Alexandra Chen · 123 Wellness Avenue, Los Angeles, CA 90001, US</p>
          <p style="font-size:12px;color:var(--teal-dark);margin-top:0.25rem;display:flex;align-items:center;gap:0.3rem"><i data-lucide="thermometer-snowflake" width="13" height="13"></i> Cold-Chain Overnight</p>
        </div>

        <div style="background:var(--pearl);border-radius:8px;padding:1rem">
          <h4 style="font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.5rem;color:var(--text-mid)">Payment</h4>
          <p style="font-size:14px;color:var(--text-dark);display:flex;align-items:center;gap:0.4rem"><i data-lucide="credit-card" width="15" height="15" style="color:var(--teal)"></i> Visa ending in ••••3456</p>
        </div>

        <div style="margin-top:1rem;padding:0.75rem 1rem;background:rgba(14,175,159,0.06);border:1px solid rgba(14,175,159,0.2);border-radius:8px;font-size:13px;color:var(--text-mid)">
          <i data-lucide="info" width="13" height="13" style="color:var(--teal);vertical-align:middle;margin-right:4px"></i>
          All peptides are sold strictly for research purposes. By placing this order you confirm you are 18+ and agree to our <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>" style="color:var(--teal-dark)">Terms & Conditions</a>.
        </div>

        <div class="form-nav">
          <button class="btn-back" onclick="goStep(2)"><i data-lucide="arrow-left" width="16" height="16"></i> Back</button>
          <button class="btn-place" onclick="placeOrder()">
            <i data-lucide="lock" width="16" height="16"></i> Place Order — $282.49
          </button>
        </div>
      </div>

    </div><!-- .panel-body -->
  </div><!-- .checkout-panel -->

  <!-- SIDEBAR -->
  <div class="order-sidebar">
    <div class="sidebar-header">
      <h3>Order Summary</h3>
    </div>
    <div class="sidebar-body">
      <div class="sidebar-items">
        <div class="s-item">
          <div><div class="s-item-name">BPC-157 — 5 mg</div><div class="s-item-qty">×2</div></div>
          <div class="s-item-price">$130.00</div>
        </div>
        <div class="s-item">
          <div><div class="s-item-name">GHK-Cu — 200 mg</div><div class="s-item-qty">×1</div></div>
          <div class="s-item-price">$52.00</div>
        </div>
        <div class="s-item">
          <div><div class="s-item-name">Ipamorelin — 2 mg</div><div class="s-item-qty">×1</div></div>
          <div class="s-item-price">$68.00</div>
        </div>
      </div>
      <hr class="s-divider">
      <div class="s-row"><span class="lbl">Subtotal</span><span class="val">$250.00</span></div>
      <div class="s-row" style="color:var(--teal-dark)"><span class="lbl">Discount (WELCOME10)</span><span class="val" style="color:var(--teal-dark)">−$25.00</span></div>
      <div class="s-row"><span class="lbl">Shipping</span><span class="val" id="sideShipping">$24.99</span></div>
      <div class="s-row"><span class="lbl">Tax (9%)</span><span class="val">$22.50</span></div>
      <hr class="s-divider">
      <div class="s-total"><span class="lbl">Total</span><span class="val" id="sideTotal">$272.49</span></div>
    </div>
    <div class="sidebar-trust">
      <div class="s-trust-item"><i data-lucide="shield-check" width="14" height="14"></i> 256-bit SSL encryption</div>
      <div class="s-trust-item"><i data-lucide="award" width="14" height="14"></i> COA on every product</div>
      <div class="s-trust-item"><i data-lucide="thermometer-snowflake" width="14" height="14"></i> Cold-chain integrity</div>
      <div class="s-trust-item"><i data-lucide="rotate-ccw" width="14" height="14"></i> Integrity guarantee</div>
    </div>
  </div>

</div><!-- .checkout-layout -->

<!-- SUCCESS OVERLAY -->
<div class="success-overlay" id="successOverlay">
  <div class="success-card">
    <div class="success-icon"><i data-lucide="check" width="40" height="40"></i></div>
    <h2>Order Confirmed!</h2>
    <p>Thank you for your order. A confirmation has been sent to your email.</p>
    <div class="success-order">Order #ALV-2025-04872</div>
    <p style="font-size:13px;color:var(--text-light)">Estimated delivery: 1–2 business days via Cold-Chain Overnight</p>
    <div class="success-actions">
      <a href="<?php echo esc_url(alluvia_account_url()); ?>" class="btn-track"><i data-lucide="package" width="15" height="15"></i> Track Order</a>
      <a href="<?php echo esc_url(alluvia_shop_url()); ?>" class="btn-continue"><i data-lucide="shopping-bag" width="15" height="15"></i> Continue Shopping</a>
    </div>
  </div>
</div>

<footer>
  <div class="footer-inner">
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

let currentStep = 1;
const panelIcons = ['map-pin','credit-card','clipboard-list'];
const panelTitles = ['Shipping Information','Payment Details','Review & Place Order'];

function goStep(n) {
  document.getElementById('tab' + currentStep).classList.remove('active');
  currentStep = n;
  document.getElementById('tab' + n).classList.add('active');

  for (let i = 1; i <= 3; i++) {
    const circle = document.getElementById('step' + i + '-circle');
    const label = document.getElementById('step' + i + '-label');
    if (i < n) {
      circle.className = 'step-circle done';
      circle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
      label.className = 'step-label done';
    } else if (i === n) {
      circle.className = 'step-circle active';
      circle.textContent = i;
      label.className = 'step-label active';
    } else {
      circle.className = 'step-circle pending';
      circle.textContent = i;
      label.className = 'step-label pending';
    }
  }

  document.getElementById('panelTitle').textContent = panelTitles[n-1];
  window.scrollTo({top:72,behavior:'smooth'});
  lucide.createIcons();
}

function selectShipping(radio) {
  document.querySelectorAll('.ship-opt').forEach(o => o.classList.remove('selected'));
  radio.closest('.ship-opt').classList.add('selected');
  const prices = {standard:0, express:12.99, coldchain:24.99};
  const p = prices[radio.value];
  document.getElementById('sideShipping').textContent = p === 0 ? 'Free' : '$' + p.toFixed(2);
}

function setPayMethod(btn, method) {
  document.querySelectorAll('.pay-method').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('cardForm').style.display = method === 'card' ? 'block' : 'none';
  document.getElementById('paypalForm').style.display = method === 'paypal' ? 'block' : 'none';
  document.getElementById('cryptoForm').style.display = method === 'crypto' ? 'block' : 'none';
}

function formatCard(input) {
  let v = input.value.replace(/\D/g,'').slice(0,16);
  input.value = v.replace(/(.{4})/g,'$1 ').trim();
}

function placeOrder() {
  const overlay = document.getElementById('successOverlay');
  overlay.classList.add('show');
  lucide.createIcons();
}

document.getElementById('successOverlay').addEventListener('click', function(e) {
  if (e.target === this) this.classList.remove('show');
});
</script>
<?php get_footer( 'alluvia' ); ?>
