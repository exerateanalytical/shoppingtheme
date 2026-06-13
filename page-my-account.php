<?php
/**
 * My Account Page Template
 * @package Shopping
 */
add_action( 'wp_head', function() { ?>
<style>
.account-wrap { max-width: 1100px; margin: 0 auto; padding: 5.5rem 1.5rem 5rem; }
.account-hero { background: linear-gradient(135deg, var(--navy) 0%, #0b1c2e 100%); padding: 72px 0 52px; margin-top: 72px; }
.account-hero-inner { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; display: flex; align-items: center; gap: 20px; }
.account-avatar { width: 64px; height: 64px; border-radius: 50%; background: rgba(14,175,159,.15); border: 2px solid rgba(14,175,159,.3); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.account-hero h1 { font-family: var(--font-display); font-size: clamp(28px,3.5vw,44px); font-weight: 300; color: #fff; margin: 0 0 4px; }
.account-hero p { color: rgba(255,255,255,.55); font-size: 15px; font-family: var(--font-ui); margin: 0; }

/* Layout */
.account-layout { display: grid; grid-template-columns: 220px 1fr; gap: 40px; }
.account-nav-card { background: #fff; border-radius: var(--radius-md); border: 1px solid var(--pearl-dark); padding: 8px 0; position: sticky; top: 88px; align-self: start; }
.account-nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; font-family: var(--font-ui); font-size: 14px; font-weight: 500; color: var(--text-mid); text-decoration: none; transition: .2s; }
.account-nav-item:hover { color: var(--navy); background: var(--pearl); }
.account-nav-item.active { color: var(--teal); background: rgba(14,175,159,.06); font-weight: 600; }
.account-nav-item svg { flex-shrink: 0; }
.account-nav-divider { height: 1px; background: var(--pearl-dark); margin: 6px 0; }
.account-nav-item.logout { color: var(--coral); }
.account-nav-item.logout:hover { background: rgba(220,80,80,.06); }

/* Main content */
.account-main { background: #fff; border-radius: var(--radius-md); border: 1px solid var(--pearl-dark); padding: 32px; min-height: 400px; }
.account-main .woocommerce { font-family: var(--font-body); }
.account-main .woocommerce-MyAccount-navigation { display: none; } /* hidden — we have our own nav */
.account-main h2 { font-family: var(--font-display); font-size: 24px; font-weight: 600; color: var(--navy); margin-bottom: 20px; }
.account-main h3 { font-family: var(--font-display); font-size: 20px; font-weight: 600; color: var(--navy); margin-bottom: 12px; }
.account-main p { color: var(--text-mid); line-height: 1.7; }
.account-main a { color: var(--teal); }
.account-main table.woocommerce-orders-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.account-main table.woocommerce-orders-table th { font-family: var(--font-ui); font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--text-light); padding: 10px 12px; border-bottom: 1.5px solid var(--pearl-dark); text-align: left; }
.account-main table.woocommerce-orders-table td { padding: 14px 12px; border-bottom: 1px solid var(--pearl-dark); color: var(--text-dark); vertical-align: middle; }
.account-main table.woocommerce-orders-table .button { display: inline-flex; align-items: center; padding: 7px 14px; border-radius: 100px; font-family: var(--font-ui); font-size: 12px; font-weight: 700; background: var(--navy); color: #fff; text-decoration: none; transition: .2s; }
.account-main table.woocommerce-orders-table .button:hover { background: var(--teal); color: var(--navy); }
.account-main .woocommerce-Address { border: 1px solid var(--pearl-dark); border-radius: var(--radius-sm); padding: 20px 24px; margin-bottom: 24px; }
.account-main .woocommerce-Address-title { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
.account-main .woocommerce-Address-title h3 { margin: 0; font-size: 16px; }
.account-main .woocommerce-Address-title a { font-family: var(--font-ui); font-size: 13px; color: var(--teal); text-decoration: none; font-weight: 600; }
.account-main form .form-row { margin-bottom: 16px; }
.account-main form .form-row label { font-family: var(--font-ui); font-size: 13px; font-weight: 600; color: var(--text-dark); display: block; margin-bottom: 6px; }
.account-main form .form-row input { width: 100%; padding: 11px 14px; border: 1.5px solid var(--pearl-dark); border-radius: var(--radius-sm); font-family: var(--font-body); font-size: 15px; color: var(--text-dark); outline: none; transition: border-color .2s; }
.account-main form .form-row input:focus { border-color: var(--teal); }
.account-main form .button { background: linear-gradient(135deg,var(--teal),var(--teal-dark)); color: var(--navy); padding: 12px 28px; border: none; border-radius: 100px; font-family: var(--font-ui); font-size: 14px; font-weight: 700; cursor: pointer; transition: .2s; }
.account-main .woocommerce-order-details table th,
.account-main .woocommerce-customer-details address { font-size: 14px; }
.woocommerce-message, .woocommerce-info { background: rgba(14,175,159,.08); border-left: 3px solid var(--teal); padding: 14px 18px; border-radius: 0 var(--radius-sm) var(--radius-sm) 0; margin-bottom: 20px; font-size: 14px; color: var(--text-dark); }
.woocommerce-error { background: rgba(220,80,80,.07); border-left: 3px solid var(--coral); padding: 14px 18px; border-radius: 0 var(--radius-sm) var(--radius-sm) 0; margin-bottom: 20px; font-size: 14px; }

@media(max-width:768px) {
  .account-layout { grid-template-columns: 1fr; }
  .account-nav-card { position: static; display: flex; flex-wrap: wrap; padding: 8px; gap: 4px; border-radius: var(--radius-sm); }
  .account-nav-item { padding: 8px 14px; border-radius: 6px; font-size: 13px; }
  .account-nav-divider { display: none; }
  .account-main { padding: 20px; }
}
@media(max-width:480px) {
  .account-wrap { padding: 4.5rem 1rem 3rem; }
}
</style>
<?php }, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<?php
$current_user = wp_get_current_user();
$display_name = $current_user->display_name ?: 'My Account';
$user_email   = $current_user->user_email ?: '';

// Determine active endpoint for nav highlighting
$active_endpoint = 'dashboard';
$endpoints = WC()->query->get_query_vars();
foreach ( $endpoints as $key => $var ) {
    if ( ! empty( get_query_var( $var ) ) ) {
        $active_endpoint = $key;
        break;
    }
}
$account_url = wc_get_page_permalink( 'myaccount' );
?>

<div class="account-hero">
  <div class="account-hero-inner">
    <div class="account-avatar">
      <i data-lucide="user" style="width:28px;height:28px;color:var(--teal)"></i>
    </div>
    <div>
      <h1><?php echo is_user_logged_in() ? esc_html( 'Hello, ' . $display_name ) : 'My Account'; ?></h1>
      <?php if ( is_user_logged_in() && $user_email ) : ?>
        <p><?php echo esc_html( $user_email ); ?></p>
      <?php elseif ( ! is_user_logged_in() ) : ?>
        <p>Sign in to manage your orders and account details.</p>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="account-wrap">
  <?php if ( is_user_logged_in() ) : ?>
  <div class="account-layout">
    <!-- Sidebar Nav -->
    <nav class="account-nav-card">
      <a href="<?php echo esc_url( $account_url ); ?>" class="account-nav-item<?php echo $active_endpoint === 'dashboard' ? ' active' : ''; ?>">
        <i data-lucide="layout-dashboard" style="width:16px;height:16px"></i> Dashboard
      </a>
      <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="account-nav-item<?php echo $active_endpoint === 'orders' ? ' active' : ''; ?>">
        <i data-lucide="package" style="width:16px;height:16px"></i> Orders
      </a>
      <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'downloads' ) ); ?>" class="account-nav-item<?php echo $active_endpoint === 'downloads' ? ' active' : ''; ?>">
        <i data-lucide="download" style="width:16px;height:16px"></i> Downloads
      </a>
      <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-address' ) ); ?>" class="account-nav-item<?php echo $active_endpoint === 'edit-address' ? ' active' : ''; ?>">
        <i data-lucide="map-pin" style="width:16px;height:16px"></i> Addresses
      </a>
      <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>" class="account-nav-item<?php echo $active_endpoint === 'edit-account' ? ' active' : ''; ?>">
        <i data-lucide="settings" style="width:16px;height:16px"></i> Account Details
      </a>
      <div class="account-nav-divider"></div>
      <a href="<?php echo esc_url( wc_logout_url() ); ?>" class="account-nav-item logout">
        <i data-lucide="log-out" style="width:16px;height:16px"></i> Sign Out
      </a>
    </nav>

    <!-- WooCommerce Content -->
    <div class="account-main">
      <?php
      while ( have_posts() ) :
          the_post();
          the_content();
      endwhile;
      ?>
    </div>
  </div>

  <?php else : ?>
  <!-- Not logged in — show login/register -->
  <div style="max-width:480px;margin:0 auto">
    <div class="account-main">
      <?php
      while ( have_posts() ) :
          the_post();
          the_content();
      endwhile;
      ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<?php get_template_part( 'partials/footer-alluvia' ); ?>
