<?php
/**
 * 404 Error Page
 * @package Shopping
 */
add_action( 'wp_head', function() { ?>
<style>
.error-wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--navy);padding:2rem;text-align:center;flex-direction:column;gap:2rem}
.error-code{font-family:var(--font-display);font-size:clamp(100px,20vw,180px);font-weight:700;color:rgba(14,175,159,.18);line-height:1;display:block}
.error-title{font-family:var(--font-display);font-size:clamp(28px,4vw,48px);font-weight:300;color:#fff;margin-bottom:.5rem}
.error-sub{font-size:16px;color:rgba(255,255,255,.55);max-width:440px;line-height:1.7}
.error-actions{display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;margin-top:1rem}
.error-actions a{display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:100px;font-family:var(--font-ui);font-size:14px;font-weight:700;letter-spacing:.05em;text-decoration:none;transition:.3s;text-transform:uppercase}
.error-btn-primary{background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy)}
.error-btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(14,175,159,.35)}
.error-btn-outline{border:1.5px solid rgba(255,255,255,.2);color:rgba(255,255,255,.8)}
.error-btn-outline:hover{border-color:var(--teal);color:var(--teal)}
</style>
<?php }, 20 );
get_header('alluvia');
?>
<?php get_template_part('partials/nav-alluvia'); ?>

<div class="error-wrap">
  <div>
    <span class="error-code">404</span>
    <h1 class="error-title">Page Not Found</h1>
    <p class="error-sub">The page you're looking for doesn't exist or has been moved. Let's get you back on track.</p>
    <div class="error-actions">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="error-btn-primary"><i data-lucide="home" width="16" height="16"></i>Go Home</a>
      <a href="<?php echo esc_url(function_exists('alluvia_shop_url') ? alluvia_shop_url() : home_url('/shop/')); ?>" class="error-btn-outline"><i data-lucide="shopping-bag" width="16" height="16"></i>Browse Shop</a>
    </div>
  </div>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>
<?php get_footer('alluvia'); ?>
