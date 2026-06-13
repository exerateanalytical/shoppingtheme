<?php
/**
 * My Account Page Template — matches alluvia-account.html
 * @package Shopping
 */
add_action( 'wp_head', function() { ?>
<style>
/* ACCOUNT HERO */
.account-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:5rem 2rem 0;margin-top:72px}
.account-hero-inner{max-width:1200px;margin:0 auto;display:flex;align-items:flex-end;gap:2rem;padding-bottom:0}
.account-avatar{width:88px;height:88px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:35px;font-weight:600;color:var(--navy);flex-shrink:0;border:4px solid rgba(255,255,255,.1);margin-bottom:-1px}
.account-hero-info{padding-bottom:1.5rem}
.account-hero-info h1{font-family:var(--font-display);font-size:2rem;font-weight:600;color:#fff;margin-bottom:.25rem}
.account-hero-info p{color:rgba(255,255,255,.5);font-size:14px;display:flex;align-items:center;gap:.4rem;font-family:var(--font-ui)}

/* LAYOUT */
.account-layout{max-width:1200px;margin:0 auto;padding:2.5rem 2rem 5rem;display:grid;grid-template-columns:240px 1fr;gap:2.5rem;align-items:start}

/* SIDEBAR */
.account-sidebar{background:#fff;border-radius:var(--radius);box-shadow:0 2px 16px rgba(0,0,0,.06);overflow:hidden;position:sticky;top:90px}
.sidebar-user{background:var(--navy);padding:1.25rem}
.sidebar-user-name{font-family:var(--font-ui);font-weight:600;font-size:15px;color:#fff}
.sidebar-user-email{font-size:12px;color:rgba(255,255,255,.45);margin-top:2px}
.sidebar-nav{list-style:none;padding:.5rem 0;margin:0}
.sidebar-nav li a{display:flex;align-items:center;gap:.75rem;padding:.75rem 1.25rem;font-family:var(--font-ui);font-size:13px;font-weight:500;color:var(--text-mid);text-decoration:none;transition:all .2s;border-left:3px solid transparent}
.sidebar-nav li a:hover{background:var(--pearl);color:var(--teal);border-left-color:rgba(14,175,159,.4)}
.sidebar-nav li a.active{background:rgba(14,175,159,.06);color:var(--teal-dark);border-left-color:var(--teal);font-weight:600}
.sidebar-divider{border:none;border-top:1px solid var(--pearl-dark);margin:.5rem 0}
.sidebar-logout{display:flex;align-items:center;gap:.75rem;padding:.75rem 1.25rem;font-family:var(--font-ui);font-size:13px;font-weight:500;color:var(--coral);text-decoration:none;transition:background .2s;width:100%;background:none;border:none;cursor:pointer}
.sidebar-logout:hover{background:rgba(219,98,122,.06)}

/* WC CONTENT WRAPPER */
.account-main{}

/* STAT CARDS */
.stat-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem}
.stat-card{background:#fff;border-radius:var(--radius);padding:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,.06);border-top:3px solid transparent}
.stat-card.teal{border-top-color:var(--teal)}
.stat-card.gold{border-top-color:var(--gold)}
.stat-card.coral{border-top-color:var(--coral)}
.stat-card.mint{border-top-color:var(--mint)}
.stat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem}
.stat-icon.teal-bg{background:rgba(14,175,159,.1);color:var(--teal)}
.stat-icon.gold-bg{background:rgba(198,162,83,.1);color:var(--gold)}
.stat-icon.coral-bg{background:rgba(219,98,122,.1);color:var(--coral)}
.stat-icon.mint-bg{background:rgba(88,180,136,.1);color:var(--mint)}
.stat-num{font-family:var(--font-display);font-size:2rem;font-weight:700;color:var(--text-dark);line-height:1}
.stat-label{font-family:var(--font-ui);font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--text-light);margin-top:.3rem}

/* PANEL CARD */
.panel-card{background:#fff;border-radius:var(--radius);box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;margin-bottom:1.5rem}
.panel-card-header{padding:1.25rem 1.5rem;border-bottom:1px solid var(--pearl);display:flex;align-items:center;justify-content:space-between}
.panel-card-header h3{font-family:var(--font-display);font-size:19px;font-weight:600;display:flex;align-items:center;gap:.5rem;margin:0}
.panel-card-header h3 svg{color:var(--teal)}
.panel-card-body{padding:1.5rem}
.btn-sm{background:var(--navy);color:#fff;border:none;border-radius:6px;padding:.4rem .9rem;font-family:var(--font-ui);font-size:12px;font-weight:600;cursor:pointer;transition:background .2s;letter-spacing:.04em;display:inline-flex;align-items:center;gap:.3rem;text-decoration:none}
.btn-sm:hover{background:var(--teal);color:var(--navy)}
.btn-sm.outline{background:transparent;border:1px solid var(--pearl-dark);color:var(--text-mid)}
.btn-sm.outline:hover{border-color:var(--teal);color:var(--teal);background:transparent}

/* WooCommerce overrides inside account */
.account-main .woocommerce-MyAccount-navigation{display:none}
.account-main .woocommerce-MyAccount-content{font-family:var(--font-body);font-size:15px;color:var(--text-dark)}
.account-main .woocommerce-MyAccount-content h2,.account-main .woocommerce-MyAccount-content h3{font-family:var(--font-display);color:var(--navy)}
.account-main table.woocommerce-orders-table,.account-main table.shop_table{width:100%;border-collapse:collapse;font-size:14px}
.account-main table.woocommerce-orders-table th,.account-main table.shop_table th{font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-light);padding:.6rem .75rem;text-align:left;border-bottom:1px solid var(--pearl-dark)}
.account-main table.woocommerce-orders-table td,.account-main table.shop_table td{padding:1rem .75rem;border-bottom:1px solid var(--pearl);vertical-align:middle}
.account-main table .button{display:inline-flex;align-items:center;padding:6px 14px;border-radius:100px;font-family:var(--font-ui);font-size:12px;font-weight:700;background:var(--navy);color:#fff;text-decoration:none;transition:.2s}
.account-main table .button:hover{background:var(--teal);color:var(--navy)}
.account-main .woocommerce-Address{border:1px solid var(--pearl-dark);border-radius:10px;padding:1.25rem;margin-bottom:1rem}
.account-main .woocommerce-Address-title{display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem}
.account-main .woocommerce-Address-title h3{margin:0;font-size:16px}
/* col2-set: WC address two-column — use flex not grid to avoid conflicts */
.account-main .col2-set{display:flex;gap:1.5rem;flex-wrap:wrap}
.account-main .col2-set .col-1,.account-main .col2-set .col-2{flex:1;min-width:240px}
/* WooCommerce form layout — override floats with a clean approach */
.account-main form{width:100%}
.account-main form p.form-row,
.account-main form .form-row{
  float:none !important;
  width:100% !important;
  margin-bottom:1rem;
  clear:none;
  box-sizing:border-box;
}
/* Two-column rows: pair first+last side by side */
.account-main form .form-row-first,
.account-main form .form-row-last{
  display:inline-block;
  width:calc(50% - 8px) !important;
  vertical-align:top;
  float:none !important;
}
.account-main form .form-row-first{margin-right:16px}
.account-main form .form-row-wide,.account-main form .clear{display:block;width:100% !important;clear:both}
.account-main form .clear{height:0;overflow:hidden}
.account-main form .form-row label,
.account-main form p.form-row label{
  font-family:var(--font-ui);font-size:12px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--text-mid);display:block;margin-bottom:.35rem
}
.account-main form .form-row input[type=text],
.account-main form .form-row input[type=email],
.account-main form .form-row input[type=tel],
.account-main form .form-row input[type=password],
.account-main form .form-row input[type=number],
.account-main form .form-row select,
.account-main form .form-row textarea{
  border:1.5px solid var(--pearl-dark);border-radius:8px;padding:.65rem .9rem;
  font-family:var(--font-body);font-size:14px;color:var(--text-dark);
  outline:none;transition:border-color .2s;background:#fff;
  width:100%;box-sizing:border-box;
}
.account-main form .form-row input:focus,
.account-main form .form-row select:focus,
.account-main form .form-row textarea:focus{border-color:var(--teal)}
.account-main form .woocommerce-password-strength{font-size:12px;margin-top:4px;padding:4px 8px;border-radius:4px}
.account-main form .show-password-input{position:relative}
.account-main form button[type=submit],
.account-main form input[type=submit],
.account-main form .button{
  background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);
  border:none;border-radius:8px;padding:.7rem 2rem;
  font-family:var(--font-ui);font-size:14px;font-weight:700;cursor:pointer;
  transition:all .3s;display:inline-flex;align-items:center;gap:.4rem;
  letter-spacing:.04em;text-decoration:none;
}
.account-main form button[type=submit]:hover,
.account-main form .button:hover{background:var(--teal-dark)}
/* Required star */
.account-main form .required{color:var(--coral)}
/* WC notices inside account */
.account-main .woocommerce-notices-wrapper .woocommerce-message{margin-bottom:1rem}
@media(max-width:640px){
  .account-main form .form-row-first,
  .account-main form .form-row-last{width:100% !important;display:block;margin-right:0}
}
.account-main .woocommerce-message,.account-main .woocommerce-info{background:rgba(14,175,159,.08);border-left:3px solid var(--teal);padding:.85rem 1rem;border-radius:0 8px 8px 0;margin-bottom:1.25rem;font-size:14px}
.account-main .woocommerce-error{background:rgba(219,98,122,.07);border-left:3px solid var(--coral);padding:.85rem 1rem;border-radius:0 8px 8px 0;margin-bottom:1.25rem;font-size:14px}

/* Login form when not logged in */
.account-login-wrap{max-width:520px;margin:0 auto;background:#fff;border-radius:var(--radius);padding:2rem;box-shadow:0 2px 16px rgba(0,0,0,.06)}

@media(max-width:900px){
  .account-layout{grid-template-columns:1fr}
  .account-sidebar{position:static}
  .sidebar-nav{display:flex;overflow-x:auto;padding:.5rem}
  .sidebar-nav li a{white-space:nowrap;border-left:none;border-bottom:3px solid transparent;padding:.6rem 1rem}
  .sidebar-nav li a.active{border-bottom-color:var(--teal);border-left-color:transparent}
  .stat-cards{grid-template-columns:1fr 1fr}
  .account-main .col2-set{grid-template-columns:1fr}
}
@media(max-width:640px){
  .account-hero-inner{flex-direction:column;align-items:flex-start}
  .stat-cards{grid-template-columns:1fr 1fr}
  .account-layout{padding:1.5rem 1rem 3rem}
}
</style>
<?php }, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<?php
$current_user  = wp_get_current_user();
$display_name  = $current_user->display_name ?: 'My Account';
$user_email    = $current_user->user_email ?: '';
// Initials avatar
$initials = '';
if ( $current_user->first_name ) $initials .= strtoupper( substr( $current_user->first_name, 0, 1 ) );
if ( $current_user->last_name )  $initials .= strtoupper( substr( $current_user->last_name,  0, 1 ) );
if ( ! $initials ) $initials = strtoupper( substr( $display_name, 0, 2 ) );

// Active endpoint for nav highlighting
$active_ep = 'dashboard';
if ( function_exists( 'WC' ) && WC()->query ) {
    foreach ( WC()->query->get_query_vars() as $key => $var ) {
        if ( get_query_var( $var ) ) { $active_ep = $key; break; }
    }
}
$account_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : home_url( '/my-account/' );
?>

<!-- ACCOUNT HERO -->
<div class="account-hero">
  <div class="account-hero-inner">
    <?php if ( is_user_logged_in() ) : ?>
      <div class="account-avatar"><?php echo esc_html( $initials ?: 'AC' ); ?></div>
      <div class="account-hero-info">
        <h1><?php echo esc_html( $display_name ); ?></h1>
        <p><?php echo esc_html( $user_email ); ?> · Member since <?php echo esc_html( date( 'M Y', strtotime( $current_user->user_registered ) ) ); ?></p>
      </div>
    <?php else : ?>
      <div class="account-hero-info" style="padding-bottom:1.5rem">
        <h1>My Account</h1>
        <p>Sign in to manage your orders, addresses, and account details.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="account-layout">

  <?php if ( is_user_logged_in() ) : ?>
  <!-- SIDEBAR NAV -->
  <div class="account-sidebar">
    <div class="sidebar-user">
      <div class="sidebar-user-name"><?php echo esc_html( $display_name ); ?></div>
      <div class="sidebar-user-email"><?php echo esc_html( $user_email ); ?></div>
    </div>
    <ul class="sidebar-nav">
      <li><a href="<?php echo esc_url( $account_url ); ?>" class="<?php echo $active_ep === 'dashboard' ? 'active' : ''; ?>">
        <i data-lucide="layout-dashboard" style="width:16px;height:16px"></i> Dashboard
      </a></li>
      <li><a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>" class="<?php echo $active_ep === 'orders' ? 'active' : ''; ?>">
        <i data-lucide="package" style="width:16px;height:16px"></i> My Orders
      </a></li>
      <li><a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-account' ) ); ?>" class="<?php echo $active_ep === 'edit-account' ? 'active' : ''; ?>">
        <i data-lucide="user" style="width:16px;height:16px"></i> Profile
      </a></li>
      <li><a href="<?php echo esc_url( wc_get_account_endpoint_url( 'edit-address' ) ); ?>" class="<?php echo $active_ep === 'edit-address' ? 'active' : ''; ?>">
        <i data-lucide="map-pin" style="width:16px;height:16px"></i> Addresses
      </a></li>
      <li><a href="<?php echo esc_url( wc_get_account_endpoint_url( 'downloads' ) ); ?>" class="<?php echo $active_ep === 'downloads' ? 'active' : ''; ?>">
        <i data-lucide="download" style="width:16px;height:16px"></i> Downloads
      </a></li>
      <hr class="sidebar-divider">
      <li><a href="<?php echo esc_url( wc_logout_url( $account_url ) ); ?>" class="sidebar-logout">
        <i data-lucide="log-out" style="width:16px;height:16px"></i> Sign Out
      </a></li>
    </ul>
  </div>

  <!-- MAIN CONTENT -->
  <div class="account-main">
    <?php
    // Dashboard: show stat cards above WC content
    if ( $active_ep === 'dashboard' ) :
        $order_count   = wc_get_customer_order_count( $current_user->ID );
        $total_spent   = wc_get_customer_total_spent( $current_user->ID );
    ?>
    <div class="stat-cards">
      <div class="stat-card teal">
        <div class="stat-icon teal-bg"><i data-lucide="package" style="width:20px;height:20px"></i></div>
        <div class="stat-num"><?php echo esc_html( $order_count ); ?></div>
        <div class="stat-label">Total Orders</div>
      </div>
      <div class="stat-card gold">
        <div class="stat-icon gold-bg"><i data-lucide="dollar-sign" style="width:20px;height:20px"></i></div>
        <div class="stat-num">$<?php echo esc_html( number_format( $total_spent, 0 ) ); ?></div>
        <div class="stat-label">Total Spent</div>
      </div>
      <div class="stat-card coral">
        <div class="stat-icon coral-bg"><i data-lucide="heart" style="width:20px;height:20px"></i></div>
        <div class="stat-num">—</div>
        <div class="stat-label">Wishlist</div>
      </div>
      <div class="stat-card mint">
        <div class="stat-icon mint-bg"><i data-lucide="award" style="width:20px;height:20px"></i></div>
        <div class="stat-num">—</div>
        <div class="stat-label">Loyalty Pts</div>
      </div>
    </div>
    <?php endif; ?>

    <div class="panel-card">
      <div class="panel-card-body">
        <?php
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
        ?>
      </div>
    </div>
  </div>

  <?php else : ?>
  <!-- NOT LOGGED IN — login/register form -->
  <div style="grid-column:1/-1">
    <div class="account-login-wrap">
      <?php
      while ( have_posts() ) :
          the_post();
          the_content();
      endwhile;
      ?>
    </div>
  </div>
  <?php endif; ?>

</div><!-- .account-layout -->

<?php get_template_part( 'partials/footer-alluvia' ); ?>
