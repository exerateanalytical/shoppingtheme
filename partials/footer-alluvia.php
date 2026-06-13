<?php
/**
 * Shared footer partial — included on commerce pages (cart, checkout, product).
 * Usage: get_template_part( 'partials/footer-alluvia' );
 */
$_footer_shop_url = function_exists('alluvia_shop_url') ? alluvia_shop_url() : home_url('/shop/');
$_footer_cats = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'number'     => 5,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'exclude'    => [absint(get_option('default_product_cat'))],
]);
if (is_wp_error($_footer_cats)) $_footer_cats = [];
?>
<footer class="alluvia-footer">
  <div class="footer-grid">
    <div class="footer-brand">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" style="margin-bottom:4px">
        <?php echo function_exists('alluvia_logo_svg') ? alluvia_logo_svg() : ''; ?>
      </a>
      <p class="footer-desc">Pharmaceutical-grade bioactive peptides — backed by science, delivered with integrity.</p>
      <div class="footer-socials">
        <a href="#" class="social-btn"><i data-lucide="instagram" style="width:16px;height:16px"></i></a>
        <a href="#" class="social-btn"><i data-lucide="twitter" style="width:16px;height:16px"></i></a>
        <a href="#" class="social-btn"><i data-lucide="facebook" style="width:16px;height:16px"></i></a>
        <a href="#" class="social-btn"><i data-lucide="youtube" style="width:16px;height:16px"></i></a>
      </div>
    </div>
    <div>
      <h3 class="footer-col-title">Products</h3>
      <ul class="footer-links">
        <?php if (!empty($_footer_cats)) : ?>
          <?php foreach ($_footer_cats as $_fcat) : ?>
            <li><a href="<?php echo esc_url(add_query_arg('product_cat', $_fcat->slug, $_footer_shop_url)); ?>">
              <i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>
              <?php echo esc_html($_fcat->name); ?>
            </a></li>
          <?php endforeach; ?>
        <?php else : ?>
          <li><a href="<?php echo esc_url($_footer_shop_url); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>All Peptides</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div>
      <h3 class="footer-col-title">Company</h3>
      <ul class="footer-links">
        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>About Us</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Contact</a></li>
        <li><a href="<?php echo esc_url(home_url('/coa-library/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>COA Library</a></li>
        <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Shipping</a></li>
      </ul>
    </div>
    <div>
      <h3 class="footer-col-title">Legal</h3>
      <ul class="footer-links">
        <li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Terms &amp; Conditions</a></li>
        <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Privacy Policy</a></li>
        <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Shipping Policy</a></li>
        <li><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Disclaimer</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; <?php echo date('Y'); ?> Alluvia Peptides. All rights reserved.</p>
    <div class="footer-bottom-links">
      <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms</a>
      <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy</a>
      <a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping</a>
      <a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a>
    </div>
  </div>
</footer>
