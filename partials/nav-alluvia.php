<?php
/**
 * Shared navigation partial — included on every Alluvia front-end page.
 * Usage: get_template_part( 'partials/nav-alluvia' );
 */
$cart_count = function_exists('WC') ? WC()->cart->get_cart_contents_count() : 0;
?>
<nav class="alluvia-nav" id="nav">
  <div class="nav-inner">

    <a href="<?php echo esc_url( home_url('/') ); ?>" class="nav-logo">
      <svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/>
        <circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/>
        <circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/>
        <circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/>
        <line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/>
        <line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/>
        <line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/>
      </svg>
      <div class="logo-text">
        <span class="nav-logo-word">Alluvia</span>
        <span class="nav-logo-sub">Peptides</span>
      </div>
    </a>

    <ul class="nav-links">
      <li class="has-dropdown">
        <a href="<?php echo esc_url( alluvia_shop_url() ); ?>">
          Products <i data-lucide="chevron-down" style="width:13px;height:13px;vertical-align:middle;margin-left:2px;transition:transform .25s"></i>
        </a>
        <div class="nav-dropdown">
          <div class="nav-dropdown-inner">
            <a href="<?php echo esc_url( alluvia_shop_url() ); ?>" class="nav-drop-all">
              <span class="nav-drop-icon"><i data-lucide="layers" style="width:16px;height:16px"></i></span>
              <span>All Peptides</span>
            </a>
            <div class="nav-drop-grid">
              <a href="<?php echo esc_url( alluvia_cat_url('medical-peptides') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="heart-pulse" style="width:15px;height:15px"></i></span>
                <span>Medical Peptides</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('skincare-peptides') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="sparkles" style="width:15px;height:15px"></i></span>
                <span>Skincare Peptides</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('collagen-peptides') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="bone" style="width:15px;height:15px"></i></span>
                <span>Collagen Peptides</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('sports-recovery') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="zap" style="width:15px;height:15px"></i></span>
                <span>Sports &amp; Recovery</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('weight-loss-metabolic') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="flame" style="width:15px;height:15px"></i></span>
                <span>Weight-Loss &amp; Metabolic</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('hormone-anti-aging') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="timer" style="width:15px;height:15px"></i></span>
                <span>Hormone &amp; Anti-Aging</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('hair-growth-peptides') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="sprout" style="width:15px;height:15px"></i></span>
                <span>Hair Growth</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('research-peptides') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="test-tube-2" style="width:15px;height:15px"></i></span>
                <span>Research Peptides</span>
              </a>
              <a href="<?php echo esc_url( alluvia_cat_url('lab-supplies-accessories') ); ?>" class="nav-drop-item">
                <span class="nav-drop-icon"><i data-lucide="flask-conical" style="width:15px;height:15px"></i></span>
                <span>Lab Supplies</span>
              </a>
            </div>
          </div>
        </div>
      </li>
      <li><a href="<?php echo esc_url( home_url('/') ); ?>#science">Science</a></li>
      <li><a href="<?php echo esc_url( home_url('/about/') ); ?>">About</a></li>
      <li><a href="<?php echo esc_url( function_exists('alluvia_reviews_url') ? alluvia_reviews_url() : home_url('/reviews/') ); ?>">Reviews</a></li>
      <li><a href="<?php echo esc_url( home_url('/contact/') ); ?>">Contact</a></li>
    </ul>

    <div class="nav-right">
      <a href="<?php echo esc_url( alluvia_cart_url() ); ?>" class="nav-icon-btn">
        <i data-lucide="shopping-cart" style="width:16px;height:16px"></i>
        Cart
        <?php if ( $cart_count > 0 ) : ?>
          <span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
        <?php endif; ?>
      </a>
      <a href="<?php echo esc_url( alluvia_account_url() ); ?>" class="nav-icon-btn" style="padding:9px 12px;" aria-label="My Account">
        <i data-lucide="user" style="width:16px;height:16px"></i>
      </a>
    </div>

    <button class="nav-hamburger" id="hamburger" aria-label="Open menu">
      <span></span><span></span><span></span>
    </button>

  </div>
</nav>

<div class="mobile-overlay" id="mobileNav">
  <button class="mobile-close" id="mobileClose" aria-label="Close menu">
    <i data-lucide="x" style="width:28px;height:28px;color:white"></i>
  </button>
  <a href="<?php echo esc_url( alluvia_shop_url() ); ?>" onclick="closeMobile()">All Products</a>
  <a href="<?php echo esc_url( alluvia_cat_url('medical-peptides') ); ?>" onclick="closeMobile()" style="font-size:clamp(20px,4vw,30px);opacity:.7">Medical Peptides</a>
  <a href="<?php echo esc_url( alluvia_cat_url('skincare-peptides') ); ?>" onclick="closeMobile()" style="font-size:clamp(20px,4vw,30px);opacity:.7">Skincare</a>
  <a href="<?php echo esc_url( alluvia_cat_url('sports-recovery') ); ?>" onclick="closeMobile()" style="font-size:clamp(20px,4vw,30px);opacity:.7">Sports &amp; Recovery</a>
  <a href="<?php echo esc_url( alluvia_cat_url('weight-loss-metabolic') ); ?>" onclick="closeMobile()" style="font-size:clamp(20px,4vw,30px);opacity:.7">Weight-Loss</a>
  <a href="<?php echo esc_url( alluvia_cat_url('hormone-anti-aging') ); ?>" onclick="closeMobile()" style="font-size:clamp(20px,4vw,30px);opacity:.7">Hormone &amp; Anti-Aging</a>
  <a href="<?php echo esc_url( alluvia_cat_url('hair-growth-peptides') ); ?>" onclick="closeMobile()" style="font-size:clamp(20px,4vw,30px);opacity:.7">Hair Growth</a>
  <a href="<?php echo esc_url( alluvia_cat_url('research-peptides') ); ?>" onclick="closeMobile()" style="font-size:clamp(20px,4vw,30px);opacity:.7">Research</a>
  <a href="<?php echo esc_url( home_url('/about/') ); ?>" onclick="closeMobile()">About</a>
  <a href="<?php echo esc_url( home_url('/contact/') ); ?>" onclick="closeMobile()">Contact</a>
  <a href="<?php echo esc_url( alluvia_cart_url() ); ?>" onclick="closeMobile()">
    Cart<?php if ( $cart_count > 0 ) echo ' (' . esc_html($cart_count) . ')'; ?>
  </a>
  <a href="<?php echo esc_url( alluvia_account_url() ); ?>" onclick="closeMobile()">My Account</a>
</div>
<script>
(function(){
  if(window.__alluviaNavInit) return;
  window.__alluviaNavInit = true;
  var nav = document.getElementById('nav');
  var mNav = document.getElementById('mobileNav');
  var hamburger = document.getElementById('hamburger');
  var mClose = document.getElementById('mobileClose');
  window.closeMobile = function(){ mNav.classList.remove('open'); document.body.style.overflow=''; };
  if(hamburger) hamburger.onclick = function(){ mNav.classList.add('open'); document.body.style.overflow='hidden'; };
  if(mClose) mClose.onclick = closeMobile;
  window.addEventListener('scroll', function(){
    if(nav) nav.classList.toggle('scrolled', window.scrollY > 40);
  }, {passive:true});
})();
</script>
