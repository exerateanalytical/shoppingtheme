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

/* ─────────────────────────────────────────────
   WooCommerce form + content styling
   Scoped to .account-layout so it applies to BOTH
   the logged-in dashboard AND the logged-out login/register.
   Works WITH WooCommerce's native float layout (clearfix added),
   only restyling appearance + widths.
───────────────────────────────────────────── */
.account-layout .woocommerce-MyAccount-navigation{display:none}
.account-layout .woocommerce-MyAccount-content{font-family:var(--font-body);font-size:15px;color:var(--text-dark);width:100%}
/* Cap ALL headings inside account content so nothing renders giant */
.account-layout .woocommerce-MyAccount-content h1{font-family:var(--font-display);color:var(--navy);font-size:26px;font-weight:600;margin:0 0 .75rem}
.account-layout .woocommerce-MyAccount-content h2{font-family:var(--font-display);color:var(--navy);font-size:22px;font-weight:600;margin:0 0 .75rem}
.account-layout .woocommerce-MyAccount-content h3{font-family:var(--font-display);color:var(--navy);font-size:18px;font-weight:600;margin:0 0 .5rem}
.account-layout .woocommerce-MyAccount-content p{margin:0 0 1rem}
.account-layout table.woocommerce-orders-table,.account-layout table.shop_table{width:100%;border-collapse:collapse;font-size:14px}
.account-layout table.woocommerce-orders-table th,.account-layout table.shop_table th{font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-light);padding:.6rem .75rem;text-align:left;border-bottom:1px solid var(--pearl-dark)}
.account-layout table.woocommerce-orders-table td,.account-layout table.shop_table td{padding:1rem .75rem;border-bottom:1px solid var(--pearl);vertical-align:middle}
/* Tables scroll horizontally instead of overflowing on small screens */
.account-layout .woocommerce-orders-table,.account-layout .woocommerce-MyAccount-downloads,.account-layout .shop_table{display:table}
.account-layout .woocommerce-MyAccount-content .woocommerce-table--order-downloads,
.account-layout .woocommerce-MyAccount-content .my_account_orders{overflow-x:auto;display:block;width:100%}
.account-layout table .button,.account-layout table .woocommerce-button{display:inline-flex;align-items:center;padding:6px 14px;border-radius:100px;font-family:var(--font-ui);font-size:12px;font-weight:700;background:var(--navy);color:#fff;text-decoration:none;transition:.2s;white-space:nowrap}
.account-layout table .button:hover,.account-layout table .woocommerce-button:hover{background:var(--teal);color:var(--navy)}

/* ── Addresses ── */
.account-layout .woocommerce-Address{border:1px solid var(--pearl-dark);border-radius:10px;padding:1.25rem;margin-bottom:1rem}
/* Title can be <header>/<h2>/<h3> across WC versions — target all of them */
.account-layout .woocommerce-Address-title,
.account-layout .woocommerce-Address .title{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:.75rem}
.account-layout .woocommerce-Address-title h2,
.account-layout .woocommerce-Address-title h3,
.account-layout .woocommerce-Address .title h2,
.account-layout .woocommerce-Address .title h3{margin:0;font-size:17px;font-weight:600;line-height:1.2}
.account-layout .woocommerce-Address-title a.edit,
.account-layout .woocommerce-Address .title a.edit{flex:0 0 auto;font-family:var(--font-ui);font-size:12px;font-weight:700;color:var(--teal-dark);text-decoration:none;white-space:nowrap}
.account-layout .woocommerce-Address address{font-style:normal;font-size:14px;line-height:1.7;color:var(--text-mid)}

/* col2-set (addresses listing / login+register) — clean flex, no float cramming */
.account-layout .col2-set,.account-layout .u-columns,.account-layout .woocommerce-Addresses{display:flex;gap:1.5rem;flex-wrap:wrap;width:100%;float:none}
.account-layout .col2-set>div,.account-layout .u-columns>div,.account-layout .woocommerce-Addresses>div{flex:1 1 300px;min-width:0;float:none!important;width:auto!important}

/* Clearfix so WooCommerce's floated form-rows never collapse/overlap */
.account-layout form::after{content:"";display:table;clear:both}

/* Form rows: full width by default */
.account-layout form .form-row{
  float:none;width:100%;margin:0 0 1rem;padding:0;box-sizing:border-box;clear:both;
}
/* Two-column pair: first floats left, last floats right (WC-compatible) */
.account-layout form .form-row-first{float:left;width:48%;clear:left;margin-right:4%}
.account-layout form .form-row-last{float:left;width:48%;clear:none;margin-right:0}
.account-layout form .form-row-wide{clear:both;width:100%}

.account-layout form label{
  font-family:var(--font-ui);font-size:12px;font-weight:700;letter-spacing:.06em;
  text-transform:uppercase;color:var(--text-mid);display:block;margin-bottom:.35rem
}
.account-layout form .form-row label.checkbox,
.account-layout form label.woocommerce-form__label-for-checkbox{
  text-transform:none;letter-spacing:0;font-weight:500;font-size:13px;display:inline-flex;align-items:center;gap:.4rem
}
.account-layout form input[type=text],
.account-layout form input[type=email],
.account-layout form input[type=tel],
.account-layout form input[type=password],
.account-layout form input[type=number],
.account-layout form select,
.account-layout form textarea{
  display:block;width:100%;box-sizing:border-box;
  border:1.5px solid var(--pearl-dark);border-radius:8px;padding:.7rem .9rem;
  font-family:var(--font-body);font-size:14px;color:var(--text-dark);
  background:#fff;outline:none;transition:border-color .2s;line-height:1.4
}
.account-layout form input:focus,
.account-layout form select:focus,
.account-layout form textarea:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(14,175,159,.1)}
.account-layout form input[type=checkbox],
.account-layout form input[type=radio]{width:auto;display:inline-block;margin-right:.4rem}
.account-layout form .password-input{display:block;position:relative}
.account-layout form .show-password-input{position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer}
.account-layout .woocommerce-password-strength{font-size:12px;margin-top:6px;padding:6px 10px;border-radius:6px}
.account-layout .woocommerce-password-hint{font-size:12px;color:var(--text-light);margin-top:4px;display:block}
.account-layout form button[type=submit],
.account-layout form input[type=submit],
.account-layout form .button,
.account-layout form .woocommerce-button{
  background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);
  border:none;border-radius:8px;padding:.8rem 2rem;
  font-family:var(--font-ui);font-size:14px;font-weight:700;cursor:pointer;
  transition:all .3s;display:inline-flex;align-items:center;gap:.4rem;
  letter-spacing:.04em;text-decoration:none
}
.account-layout form button[type=submit]:hover,
.account-layout form .button:hover,
.account-layout form .woocommerce-button:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(14,175,159,.3)}
.account-layout form .lost_password{margin-top:.5rem}
.account-layout form .lost_password a{color:var(--teal-dark);font-size:13px;text-decoration:none}
.account-layout .required{color:var(--coral);border:0}
.account-layout .woocommerce-message,.account-layout .woocommerce-info{background:rgba(14,175,159,.08);border-left:3px solid var(--teal);padding:.85rem 1rem;border-radius:0 8px 8px 0;margin-bottom:1.25rem;font-size:14px;list-style:none}
.account-layout .woocommerce-error{background:rgba(219,98,122,.07);border-left:3px solid var(--coral);padding:.85rem 1rem;border-radius:0 8px 8px 0;margin-bottom:1.25rem;font-size:14px;list-style:none}

/* Logged-out: login + register card */
.account-login-wrap{max-width:920px;margin:0 auto}
.account-login-wrap .woocommerce>h2,.account-login-wrap .u-column1>h2,.account-login-wrap .u-column2>h2{font-family:var(--font-display);font-size:24px;font-weight:600;color:var(--navy);margin-bottom:1rem}
.account-login-wrap .col-1,.account-login-wrap .col-2,
.account-login-wrap .u-column1,.account-login-wrap .u-column2{
  background:#fff;border-radius:var(--radius);padding:2rem;box-shadow:0 2px 16px rgba(0,0,0,.06)
}
.account-login-wrap form.login,.account-login-wrap form.register{border:0;padding:0;margin:0}

@media(max-width:640px){
  .account-layout form .form-row-first,
  .account-layout form .form-row-last{float:none;width:100%;margin-right:0}
}

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

// Active endpoint for nav highlighting.
// NOTE: get_query_var() returns '' for endpoints like edit-address (falsy),
// so we use is_wc_endpoint_url() which is reliable even for empty values.
$active_ep = 'dashboard';
if ( function_exists( 'is_wc_endpoint_url' ) ) {
    foreach ( array( 'orders', 'downloads', 'edit-address', 'edit-account', 'view-order', 'payment-methods', 'add-payment-method', 'lost-password', 'customer-logout' ) as $ep ) {
        if ( is_wc_endpoint_url( $ep ) ) { $active_ep = $ep; break; }
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
