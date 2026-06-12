<?php
/**
 * WooCommerce page wrapper — wraps all WooCommerce output inside Alluvia nav/footer.
 * @package Shopping
 */
add_action( 'wp_head', function() {
    echo '<style>
:root{--navy:#0d1b2a;--navy-mid:#162336;--navy-soft:#1e3050;--teal:#00c6b3;--teal-dark:#009e8e;--gold:#c8a96e;--pearl:#f4f2ee;--pearl-dark:#e8e4dc;--white:#fff;--text-dark:#0d1b2a;--text-mid:#4a5568;--text-light:#8899aa;--radius-sm:8px;--radius-md:16px;--radius-lg:28px;--shadow-sm:0 2px 12px rgba(13,27,42,.08);--shadow-md:0 8px 32px rgba(13,27,42,.14);--shadow-lg:0 20px 60px rgba(13,27,42,.2);--transition:.45s cubic-bezier(.23,1,.32,1);--font-display:\'Cormorant Garamond\',Georgia,serif;--font-body:\'Inter\',system-ui,sans-serif;--font-ui:\'Space Grotesk\',system-ui,sans-serif}
*,*::before,*::after{box-sizing:border-box}
body{font-family:var(--font-body);color:var(--text-dark);overflow-x:hidden;background:var(--pearl);margin:0}
.alluvia-nav{position:fixed;top:0;left:0;right:0;z-index:1000;padding:20px 0;background:rgba(13,27,42,.97);backdrop-filter:blur(20px);box-shadow:0 2px 30px rgba(0,0,0,.3)}
.nav-inner{max-width:1280px;margin:0 auto;padding:0 40px;display:flex;align-items:center;justify-content:space-between}
.nav-logo{display:flex;flex-direction:row;align-items:center;gap:11px;text-decoration:none}
.logo-mark{width:34px;height:34px;flex-shrink:0}
.logo-text{display:flex;flex-direction:column;line-height:1}
.nav-logo-word{font-family:var(--font-display);font-size:30px;font-weight:600;color:#fff;letter-spacing:.05em}
.nav-logo-sub{font-family:var(--font-ui);font-size:9px;font-weight:600;letter-spacing:.38em;color:var(--teal);text-transform:uppercase;margin-top:3px}
.nav-links{display:flex;align-items:center;gap:32px;list-style:none;margin:0;padding:0}
.nav-links a{font-family:var(--font-ui);font-size:13px;font-weight:500;letter-spacing:.08em;color:rgba(255,255,255,.75);text-decoration:none;text-transform:uppercase;transition:color .25s}
.nav-links a:hover,.nav-links a.active{color:var(--teal)}
.nav-cta,.nav-cta:visited{color:var(--navy)!important;background:var(--teal);padding:10px 24px;border-radius:100px;font-weight:600!important;transition:var(--transition)!important}
.nav-cta:hover{background:var(--teal-dark)!important}
.nav-right{display:flex;align-items:center;gap:12px}
.nav-icon-btn{display:inline-flex;align-items:center;gap:8px;font-family:var(--font-ui);font-size:13px;font-weight:600;color:#fff;text-decoration:none;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:100px;padding:8px 16px;transition:var(--transition)}
.nav-icon-btn:hover{background:var(--teal);border-color:var(--teal);color:var(--navy)}
.cart-count{background:var(--teal);color:var(--navy);font-size:10px;font-weight:700;width:18px;height:18px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center}
.nav-hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;background:none;border:none;padding:8px}
.nav-hamburger span{display:block;width:24px;height:2px;background:#fff;border-radius:2px}
.mobile-overlay{position:fixed;inset:0;z-index:999;background:var(--navy);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:40px;opacity:0;pointer-events:none;transition:opacity .35s ease}
.mobile-overlay.open{opacity:1;pointer-events:all}
.mobile-overlay a{font-family:var(--font-display);font-size:40px;font-weight:300;color:#fff;text-decoration:none;transition:color .25s}
.mobile-overlay a:hover{color:var(--teal)}
.mobile-close{position:absolute;top:24px;right:28px;background:none;border:none;color:#fff;cursor:pointer;padding:8px;display:flex}
/* CONTENT */
.alluvia-woo-wrap{padding-top:90px;min-height:60vh;background:var(--pearl)}
.alluvia-woo-inner{max-width:1200px;margin:0 auto;padding:60px 40px}
.alluvia-woo-inner h1,.alluvia-woo-inner .page-title{font-family:var(--font-display);font-size:clamp(36px,4vw,60px);font-weight:300;color:var(--navy);margin-bottom:32px}
/* WooCommerce Global Overrides */
.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit{background:var(--teal);color:var(--navy);font-family:var(--font-ui);font-weight:700;border:none;border-radius:100px;padding:12px 28px;transition:var(--transition);font-size:14px;cursor:pointer}
.woocommerce a.button:hover,.woocommerce button.button:hover{background:var(--teal-dark);transform:translateY(-2px)}
.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce #respond input#submit.alt{background:var(--navy);color:#fff}
.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover{background:var(--navy-soft)}
.woocommerce ul.products li.product a.woocommerce-loop-product__link{text-decoration:none;color:var(--text-dark)}
.woocommerce ul.products li.product{background:#fff;border-radius:var(--radius-md);padding:20px;box-shadow:var(--shadow-sm);transition:var(--transition)}
.woocommerce ul.products li.product:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
.woocommerce ul.products li.product .price,.woocommerce .price{color:var(--teal);font-weight:600;font-size:18px}
.woocommerce form .form-row label{font-family:var(--font-ui);font-size:13px;font-weight:600;color:var(--navy);margin-bottom:6px;display:block}
.woocommerce form .form-row input.input-text,.woocommerce form .form-row select,.woocommerce form .form-row textarea{border:1.5px solid var(--pearl-dark);border-radius:var(--radius-sm);padding:12px 16px;font-size:15px;transition:border-color .25s;width:100%;font-family:var(--font-body)}
.woocommerce form .form-row input.input-text:focus,.woocommerce form .form-row select:focus{border-color:var(--teal);outline:none;box-shadow:0 0 0 3px rgba(0,198,179,.12)}
.woocommerce table.shop_table{border-collapse:collapse;width:100%;background:#fff;border-radius:var(--radius-md);overflow:hidden}
.woocommerce table.shop_table th{font-family:var(--font-ui);font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-light);padding:16px;border-bottom:1px solid var(--pearl-dark);background:var(--pearl)}
.woocommerce table.shop_table td{padding:16px;border-bottom:1px solid var(--pearl-dark);vertical-align:middle}
.woocommerce .order-total .amount,.woocommerce .cart-subtotal .amount,.woocommerce .total .amount{color:var(--teal);font-weight:700}
.woocommerce-message,.woocommerce-info{border-top:none;border-left:4px solid var(--teal);background:rgba(0,198,179,.07);padding:16px 20px;border-radius:0 var(--radius-sm) var(--radius-sm) 0;font-family:var(--font-ui);font-size:14px}
.woocommerce-error{border-left-color:#e8758a;background:rgba(232,117,138,.07)}
.woocommerce .woocommerce-breadcrumb{font-family:var(--font-ui);font-size:12px;color:var(--text-light);margin-bottom:24px}
.woocommerce-notices-wrapper .woocommerce-message a.button{padding:8px 18px;font-size:13px}
/* FOOTER */
.alluvia-footer{background:#060e17;padding:80px 0 0}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:60px;padding:0 40px 60px;border-bottom:1px solid rgba(255,255,255,.06);max-width:1280px;margin:0 auto}
.footer-desc{font-size:14px;line-height:1.75;color:rgba(255,255,255,.35);margin-top:20px;max-width:280px}
.footer-socials{display:flex;gap:10px;margin-top:24px}
.social-btn{width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;text-decoration:none;transition:var(--transition);color:rgba(255,255,255,.5)}
.social-btn:hover{background:var(--teal);border-color:var(--teal);color:var(--navy)}
.footer-col-title{font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:#fff;margin-bottom:20px}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:12px;margin:0;padding:0}
.footer-links a{font-size:14px;color:rgba(255,255,255,.4);text-decoration:none;transition:color .25s;display:flex;align-items:center;gap:6px}
.footer-links a:hover{color:var(--teal)}
.footer-bottom{max-width:1280px;margin:0 auto;padding:24px 40px;display:flex;align-items:center;justify-content:space-between;font-size:13px;color:rgba(255,255,255,.25);flex-wrap:wrap;gap:12px}
.footer-bottom-links{display:flex;gap:24px;flex-wrap:wrap}
.footer-bottom-links a{color:rgba(255,255,255,.25);text-decoration:none;font-size:13px;transition:color .25s}
.footer-bottom-links a:hover{color:rgba(255,255,255,.6)}
@media(max-width:900px){.nav-links{display:none}.nav-hamburger{display:flex}.nav-inner,.alluvia-woo-inner{padding-left:24px;padding-right:24px}.footer-grid{grid-template-columns:1fr 1fr;gap:40px;padding-left:24px;padding-right:24px}}
@media(max-width:640px){.footer-grid{grid-template-columns:1fr}.footer-bottom{flex-direction:column;align-items:flex-start;padding:20px 24px}.alluvia-woo-inner{padding:40px 20px}}
</style>';
}, 20 );

get_header( 'alluvia' );
?>

<nav class="alluvia-nav" id="nav">
  <div class="nav-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
      <svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#00c6b3" stroke-width="1.6" fill="none" opacity="0.9"/>
        <circle cx="17" cy="10" r="2.2" fill="#00c6b3"/>
        <circle cx="10.5" cy="21" r="2.2" fill="#00c6b3"/>
        <circle cx="23.5" cy="21" r="2.2" fill="#00c6b3"/>
        <line x1="17" y1="10" x2="10.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/>
        <line x1="17" y1="10" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/>
        <line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/>
      </svg>
      <div class="logo-text">
        <span class="nav-logo-word">Alluvia</span>
        <span class="nav-logo-sub">Peptides</span>
      </div>
    </a>
    <ul class="nav-links">
      <li><a href="<?php echo esc_url( alluvia_shop_url() ); ?>" <?php if ( is_shop() || is_product() ) echo 'class="active"'; ?>>Products</a></li>
      <li><a href="<?php echo esc_url( home_url( '/about/#science' ) ); ?>">Science</a></li>
      <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" <?php if ( is_home() || is_single() ) echo 'class="active"'; ?>>Blog</a></li>
      <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" <?php if ( is_page( 'about' ) ) echo 'class="active"'; ?>>About</a></li>
      <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" <?php if ( is_page( 'contact' ) ) echo 'class="active"'; ?>>Contact</a></li>
      <li><a href="<?php echo esc_url( alluvia_shop_url() ); ?>" class="nav-cta">Shop Now</a></li>
    </ul>
    <div class="nav-right">
      <a href="<?php echo esc_url( alluvia_cart_url() ); ?>" class="nav-icon-btn">
        <i data-lucide="shopping-bag" style="width:16px;height:16px"></i>
        <?php if ( function_exists( 'WC' ) && WC()->cart ) : ?>
          <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php endif; ?>
      </a>
      <a href="<?php echo esc_url( alluvia_account_url() ); ?>" class="nav-icon-btn" style="padding:8px 12px;">
        <i data-lucide="user" style="width:16px;height:16px"></i>
      </a>
      <button class="nav-hamburger" id="hamburger" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>

<div class="mobile-overlay" id="mobileNav">
  <button class="mobile-close" id="mobileClose" aria-label="Close menu">
    <i data-lucide="x" style="width:28px;height:28px;color:white"></i>
  </button>
  <a href="<?php echo esc_url( alluvia_shop_url() ); ?>">Products</a>
  <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a>
  <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a>
  <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
  <a href="<?php echo esc_url( alluvia_shop_url() ); ?>" style="color:var(--teal)">Shop Now</a>
</div>

<div class="alluvia-woo-wrap">
  <div class="alluvia-woo-inner">
    <?php woocommerce_content(); ?>
  </div>
</div>

<footer class="alluvia-footer">
  <div class="footer-grid">
    <div>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
        <svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#00c6b3" stroke-width="1.6" fill="none" opacity="0.9"/>
          <circle cx="17" cy="10" r="2.2" fill="#00c6b3"/>
          <circle cx="10.5" cy="21" r="2.2" fill="#00c6b3"/>
          <circle cx="23.5" cy="21" r="2.2" fill="#00c6b3"/>
          <line x1="17" y1="10" x2="10.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/>
          <line x1="17" y1="10" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/>
          <line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#00c6b3" stroke-width="1.1" opacity="0.5"/>
        </svg>
        <div class="logo-text">
          <span class="nav-logo-word">Alluvia</span>
          <span class="nav-logo-sub">Peptides</span>
        </div>
      </a>
      <p class="footer-desc">Pharmaceutical-grade bioactive peptides — backed by science, delivered with integrity.</p>
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
        <li><a href="<?php echo esc_url( alluvia_shop_url() ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Shop All</a></li>
        <li><a href="<?php echo esc_url( alluvia_shop_url() ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Medical Peptides</a></li>
        <li><a href="<?php echo esc_url( alluvia_shop_url() ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Skincare Peptides</a></li>
        <li><a href="<?php echo esc_url( alluvia_shop_url() ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Sports &amp; Recovery</a></li>
      </ul>
    </div>
    <div>
      <h3 class="footer-col-title">Company</h3>
      <ul class="footer-links">
        <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>About Us</a></li>
        <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Blog</a></li>
        <li><a href="<?php echo esc_url( home_url( '/coa-library/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>COA Library</a></li>
        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Contact</a></li>
      </ul>
    </div>
    <div>
      <h3 class="footer-col-title">Legal</h3>
      <ul class="footer-links">
        <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Privacy Policy</a></li>
        <li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Terms of Service</a></li>
        <li><a href="<?php echo esc_url( home_url( '/shipping-policy/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Shipping Policy</a></li>
        <li><a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>"><i data-lucide="chevron-right" style="width:13px;height:13px;color:var(--teal)"></i>Disclaimer</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?php echo date( 'Y' ); ?> Alluvia Peptides. All rights reserved.</p>
    <div class="footer-bottom-links">
      <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy</a>
      <a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>">Terms</a>
      <a href="<?php echo esc_url( home_url( '/shipping-policy/' ) ); ?>">Shipping</a>
      <a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>
    </div>
  </div>
</footer>

<script>
lucide.createIcons();
window.addEventListener('scroll', function(){ document.getElementById('nav').classList.toggle('scrolled', scrollY > 60); }, {passive:true});
var mNav = document.getElementById('mobileNav');
document.getElementById('hamburger').onclick = function(){ mNav.classList.add('open'); document.body.style.overflow='hidden'; };
document.getElementById('mobileClose').onclick = closeMobile;
function closeMobile(){ mNav.classList.remove('open'); document.body.style.overflow=''; }
</script>

<?php get_footer( 'alluvia' ); ?>
