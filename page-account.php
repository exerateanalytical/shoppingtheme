<?php
/**
 * Template Name: Alluvia – My Account
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
.nav-hamburger{display:none;flex-direction:column;gap:5px;background:none;border:none;cursor:pointer;padding:4px}
.nav-hamburger span{display:block;width:24px;height:2px;background:#fff;border-radius:2px}
.mobile-menu{display:none;position:fixed;inset:0;background:rgba(10,26,39,0.98);z-index:999;flex-direction:column;align-items:center;justify-content:center;gap:2.5rem}
.mobile-menu.open{display:flex}
.mobile-menu a{color:#fff;font-family:'Space Grotesk',sans-serif;font-size:24px;text-decoration:none}
.mobile-menu-close{position:absolute;top:1.5rem;right:1.5rem;background:none;border:none;color:#fff;cursor:pointer}

/* PAGE HERO */
.account-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:5rem 2rem 0;margin-top:72px}
.account-hero-inner{max-width:1200px;margin:0 auto;display:flex;align-items:flex-end;gap:2rem;padding-bottom:0}
.account-avatar{width:88px;height:88px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:35px;font-weight:600;color:var(--navy);flex-shrink:0;border:4px solid rgba(255,255,255,0.1);margin-bottom:-1px}
.account-hero-info{padding-bottom:1.5rem}
.account-hero-info h1{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:600;color:#fff;margin-bottom:0.25rem}
.account-hero-info p{color:rgba(255,255,255,0.5);font-size:14px;display:flex;align-items:center;gap:0.4rem}
.account-hero-info p svg{color:var(--teal)}
.member-badge{display:inline-flex;align-items:center;gap:0.3rem;background:rgba(198,162,83,0.15);border:1px solid rgba(198,162,83,0.3);border-radius:50px;padding:3px 10px;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.08em;color:var(--gold);text-transform:uppercase;margin-left:0.75rem}

/* LAYOUT */
.account-layout{max-width:1200px;margin:0 auto;padding:2.5rem 2rem 5rem;display:grid;grid-template-columns:240px 1fr;gap:2.5rem;align-items:start}

/* SIDEBAR NAV */
.account-sidebar{background:#fff;border-radius:var(--radius);box-shadow:0 2px 16px rgba(0,0,0,0.06);overflow:hidden;position:sticky;top:90px}
.sidebar-user{background:var(--navy);padding:1.25rem}
.sidebar-user-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:15px;color:#fff}
.sidebar-user-email{font-size:12px;color:rgba(255,255,255,0.45);margin-top:2px}
.sidebar-nav{list-style:none;padding:0.5rem 0}
.sidebar-nav li{}
.sidebar-nav li a{display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1.25rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:500;color:var(--text-mid);text-decoration:none;transition:all .2s;cursor:pointer;border-left:3px solid transparent}
.sidebar-nav li a:hover{background:var(--pearl);color:var(--teal);border-left-color:rgba(14,175,159,0.4)}
.sidebar-nav li a.active{background:rgba(14,175,159,0.06);color:var(--teal-dark);border-left-color:var(--teal);font-weight:600}
.sidebar-nav li a svg{flex-shrink:0}
.sidebar-divider{border:none;border-top:1px solid var(--pearl-dark);margin:0.5rem 0}
.sidebar-logout{display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1.25rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:500;color:var(--coral);cursor:pointer;border:none;background:none;width:100%;transition:background .2s}
.sidebar-logout:hover{background:rgba(219,98,122,0.06)}

/* TAB PANELS */
.tab-panel{display:none}
.tab-panel.active{display:block}

/* STAT CARDS */
.stat-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem}
.stat-card{background:#fff;border-radius:var(--radius);padding:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,0.06);border-top:3px solid transparent}
.stat-card.teal{border-top-color:var(--teal)}
.stat-card.gold{border-top-color:var(--gold)}
.stat-card.coral{border-top-color:var(--coral)}
.stat-card.mint{border-top-color:var(--mint)}
.stat-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem}
.stat-icon.teal-bg{background:rgba(14,175,159,0.1);color:var(--teal)}
.stat-icon.gold-bg{background:rgba(198,162,83,0.1);color:var(--gold)}
.stat-icon.coral-bg{background:rgba(219,98,122,0.1);color:var(--coral)}
.stat-icon.mint-bg{background:rgba(88,180,136,0.1);color:var(--mint)}
.stat-num{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;color:var(--text-dark);line-height:1}
.stat-label{font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-light);margin-top:0.3rem}

/* PANEL CARD */
.panel-card{background:#fff;border-radius:var(--radius);box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;margin-bottom:1.5rem}
.panel-card-header{padding:1.25rem 1.5rem;border-bottom:1px solid var(--pearl);display:flex;align-items:center;justify-content:space-between}
.panel-card-header h3{font-family:'Cormorant Garamond',serif;font-size:19px;font-weight:600;display:flex;align-items:center;gap:0.5rem}
.panel-card-header h3 svg{color:var(--teal)}
.btn-sm{background:var(--navy);color:#fff;border:none;border-radius:6px;padding:0.4rem 0.9rem;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:600;cursor:pointer;transition:background .2s;letter-spacing:0.04em;display:flex;align-items:center;gap:0.3rem}
.btn-sm:hover{background:var(--teal);color:var(--navy)}
.btn-sm.outline{background:transparent;border:1px solid var(--pearl-dark);color:var(--text-mid)}
.btn-sm.outline:hover{border-color:var(--teal);color:var(--teal);background:transparent}
.panel-card-body{padding:1.5rem}

/* ORDERS TABLE */
.orders-table{width:100%;border-collapse:collapse;font-size:14px}
.orders-table th{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-light);padding:0.6rem 0.75rem;text-align:left;border-bottom:1px solid var(--pearl-dark)}
.orders-table td{padding:1rem 0.75rem;border-bottom:1px solid var(--pearl);vertical-align:middle}
.orders-table tr:last-child td{border-bottom:none}
.orders-table tr:hover td{background:rgba(0,0,0,0.01)}
.order-id{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:13px;color:var(--teal-dark)}
.order-date{color:var(--text-light);font-size:13px}
.order-items-list{font-size:13px;color:var(--text-mid)}
.status-badge{display:inline-flex;align-items:center;gap:0.3rem;font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.06em;padding:3px 10px;border-radius:50px;text-transform:uppercase}
.status-delivered{background:rgba(88,180,136,0.15);color:#2d8a5f}
.status-processing{background:rgba(14,175,159,0.12);color:var(--teal-dark)}
.status-shipped{background:rgba(106,166,198,0.15);color:#2d6e8a}
.order-total{font-family:'Space Grotesk',sans-serif;font-weight:700}
.order-actions{display:flex;gap:0.4rem}

/* WISHLIST */
.wishlist-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}
.wish-card{border:1px solid var(--pearl-dark);border-radius:10px;overflow:hidden;transition:all .2s}
.wish-card:hover{border-color:var(--teal);box-shadow:0 4px 16px rgba(0,0,0,0.08)}
.wish-thumb{height:80px;display:flex;align-items:center;justify-content:center}
.wish-body{padding:0.85rem}
.wish-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:13px;margin-bottom:0.25rem}
.wish-price{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:14px;color:var(--teal-dark)}
.wish-add{width:100%;background:var(--navy);color:#fff;border:none;border-radius:6px;padding:0.45rem;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:600;cursor:pointer;margin-top:0.6rem;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:0.3rem}
.wish-add:hover{background:var(--teal);color:var(--navy)}

/* PROFILE FORM */
.profile-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
.profile-grid.full{grid-template-columns:1fr}
.form-group{display:flex;flex-direction:column;gap:0.3rem}
.form-group label{font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-mid)}
.form-group input,.form-group select{border:1px solid var(--pearl-dark);border-radius:8px;padding:0.65rem 0.9rem;font-family:'Inter',sans-serif;font-size:14px;color:var(--text-dark);outline:none;transition:border .2s;background:#fff}
.form-group input:focus,.form-group select:focus{border-color:var(--teal)}
.btn-save{background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);border:none;border-radius:8px;padding:0.7rem 2rem;font-family:'Space Grotesk',sans-serif;font-size:14px;font-weight:700;cursor:pointer;transition:all .3s;display:flex;align-items:center;gap:0.4rem;letter-spacing:0.04em}
.btn-save:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(14,175,159,0.3)}

/* ADDRESS CARDS */
.address-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.addr-card{border:1px solid var(--pearl-dark);border-radius:10px;padding:1.25rem;position:relative;transition:all .2s}
.addr-card.default{border-color:var(--teal);background:rgba(14,175,159,0.03)}
.addr-card-type{font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-light);margin-bottom:0.5rem;display:flex;align-items:center;gap:0.4rem}
.addr-card-type svg{color:var(--teal)}
.default-tag{background:rgba(14,175,159,0.12);color:var(--teal-dark);border-radius:50px;padding:2px 8px;font-size:10px;font-weight:700;letter-spacing:0.06em}
.addr-card h4{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:14px;margin-bottom:0.3rem}
.addr-card p{font-size:13px;color:var(--text-mid);line-height:1.6}
.addr-actions{display:flex;gap:0.5rem;margin-top:0.75rem}

/* SECURITY */
.security-item{display:flex;align-items:center;justify-content:space-between;padding:1.25rem 0;border-bottom:1px solid var(--pearl)}
.security-item:last-child{border-bottom:none}
.security-info{display:flex;align-items:center;gap:0.75rem}
.security-icon{width:40px;height:40px;border-radius:10px;background:var(--pearl);display:flex;align-items:center;justify-content:center;color:var(--text-mid)}
.security-title{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:14px}
.security-sub{font-size:13px;color:var(--text-light);margin-top:1px}
.security-status{display:flex;align-items:center;gap:0.4rem;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:600}
.status-on{color:var(--mint)}
.status-off{color:var(--text-light)}

/* FOOTER */
footer{background:#060e17;color:rgba(255,255,255,0.7);padding:5rem 2rem 2rem}
.footer-inner{max-width:1200px;margin:0 auto}
.footer-grid{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:3rem;margin-bottom:3rem}
.footer-brand p{font-size:14px;line-height:1.7;color:rgba(255,255,255,0.5);margin:1rem 0 1.5rem}
.footer-logo{display:flex;flex-direction:column;line-height:1}
.footer-logo span:first-child{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:#fff}
.footer-logo span:last-child{font-family:'Space Grotesk',sans-serif;font-size:8px;font-weight:600;letter-spacing:0.3em;color:var(--teal);text-transform:uppercase}
.social-links{display:flex;gap:0.75rem}
.social-link{width:36px;height:36px;border-radius:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.5);transition:all .2s;text-decoration:none}
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

/* RESPONSIVE */
@media(max-width:1100px){.stat-cards{grid-template-columns:1fr 1fr}.wishlist-grid{grid-template-columns:1fr 1fr}}
@media(max-width:900px){.account-layout{grid-template-columns:1fr}.account-sidebar{position:static}.sidebar-nav{display:flex;overflow-x:auto;padding:0.5rem}.sidebar-nav li a{white-space:nowrap;border-left:none;border-bottom:3px solid transparent}.sidebar-nav li a.active{border-bottom-color:var(--teal);border-left-color:transparent}.footer-grid{grid-template-columns:1fr 1fr}.address-grid{grid-template-columns:1fr}}
@media(max-width:640px){
  .page-hero h1,.hero-title{font-size:clamp(36px,5.5vw,68px)}
  .section-title{font-size:clamp(28px,7vw,42px)!important}
  .featured-title,.post-title{font-size:clamp(24px,6vw,36px)!important}
  .product-title{font-size:clamp(28px,7vw,38px)!important}
  .section-desc,.post-lead,.featured-body{font-size:16px}
  body,p,.article p{font-size:15px;line-height:1.75}
  .still-help h2,.newsletter h2,.cta-title{font-size:clamp(24px,6vw,36px)!important}
.nav-links{display:none}.nav-hamburger{display:flex}.stat-cards{grid-template-columns:1fr 1fr}.wishlist-grid{grid-template-columns:1fr}.profile-grid{grid-template-columns:1fr}.footer-grid{grid-template-columns:1fr}.account-hero-inner{flex-direction:column;align-items:flex-start}.orders-table{font-size:13px}}

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

<!-- ACCOUNT HERO -->
<div class="account-hero">
  <div class="account-hero-inner">
    <div class="account-avatar">AC</div>
    <div class="account-hero-info">
      <h1>Alexandra Chen <span class="member-badge"><i data-lucide="award" width="10" height="10"></i> Pro Member</span></h1>
      <p><i data-lucide="mail" width="14" height="14"></i> alex.chen@research.edu · Member since Jan 2024</p>
    </div>
  </div>
</div>

<div class="account-layout">

  <!-- SIDEBAR -->
  <div class="account-sidebar">
    <div class="sidebar-user">
      <div class="sidebar-user-name">Alexandra Chen</div>
      <div class="sidebar-user-email">alex.chen@research.edu</div>
    </div>
    <ul class="sidebar-nav">
      <li><a href="#" class="active" onclick="switchTab('dashboard',this)"><i data-lucide="layout-dashboard" width="16" height="16"></i> Dashboard</a></li>
      <li><a href="#" onclick="switchTab('orders',this)"><i data-lucide="package" width="16" height="16"></i> My Orders</a></li>
      <li><a href="#" onclick="switchTab('profile',this)"><i data-lucide="user" width="16" height="16"></i> Profile</a></li>
      <li><a href="#" onclick="switchTab('addresses',this)"><i data-lucide="map-pin" width="16" height="16"></i> Addresses</a></li>
      <li><a href="#" onclick="switchTab('wishlist',this)"><i data-lucide="heart" width="16" height="16"></i> Wishlist <span style="background:rgba(219,98,122,0.15);color:var(--coral);border-radius:50px;padding:1px 6px;font-size:10px;font-weight:700;margin-left:4px">5</span></a></li>
      <hr class="sidebar-divider">
      <li><a href="#" onclick="switchTab('security',this)"><i data-lucide="shield" width="16" height="16"></i> Security</a></li>
    </ul>
    <button class="sidebar-logout"><i data-lucide="log-out" width="16" height="16"></i> Sign Out</button>
  </div>

  <!-- MAIN CONTENT -->
  <div>

    <!-- DASHBOARD TAB -->
    <div class="tab-panel active" id="panel-dashboard">
      <div class="stat-cards">
        <div class="stat-card teal">
          <div class="stat-icon teal-bg"><i data-lucide="package" width="20" height="20"></i></div>
          <div class="stat-num">12</div>
          <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card gold">
          <div class="stat-icon gold-bg"><i data-lucide="dollar-sign" width="20" height="20"></i></div>
          <div class="stat-num">$1,847</div>
          <div class="stat-label">Total Spent</div>
        </div>
        <div class="stat-card coral">
          <div class="stat-icon coral-bg"><i data-lucide="heart" width="20" height="20"></i></div>
          <div class="stat-num">5</div>
          <div class="stat-label">Wishlist Items</div>
        </div>
        <div class="stat-card mint">
          <div class="stat-icon mint-bg"><i data-lucide="award" width="20" height="20"></i></div>
          <div class="stat-num">920</div>
          <div class="stat-label">Loyalty Points</div>
        </div>
      </div>

      <!-- RECENT ORDERS -->
      <div class="panel-card">
        <div class="panel-card-header">
          <h3><i data-lucide="clock" width="18" height="18"></i> Recent Orders</h3>
          <button class="btn-sm" onclick="switchTab('orders',document.querySelector('[onclick*=orders]'))">View All</button>
        </div>
        <div class="panel-card-body" style="padding:0;overflow-x:auto">
          <table class="orders-table">
            <thead>
              <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Items</th>
                <th>Status</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><div class="order-id">#ALV-2025-04872</div></td>
                <td><div class="order-date">Jun 10, 2025</div></td>
                <td><div class="order-items-list">BPC-157 ×2, GHK-Cu ×1, Ipamorelin ×1</div></td>
                <td><span class="status-badge status-processing"><i data-lucide="loader" width="10" height="10"></i> Processing</span></td>
                <td><div class="order-total">$282.49</div></td>
                <td><div class="order-actions"><button class="btn-sm outline">Track</button></div></td>
              </tr>
              <tr>
                <td><div class="order-id">#ALV-2025-04201</div></td>
                <td><div class="order-date">May 22, 2025</div></td>
                <td><div class="order-items-list">TB-500 ×1, CJC-1295 ×2</div></td>
                <td><span class="status-badge status-delivered"><i data-lucide="check-circle" width="10" height="10"></i> Delivered</span></td>
                <td><div class="order-total">$218.00</div></td>
                <td><div class="order-actions"><button class="btn-sm outline">Reorder</button></div></td>
              </tr>
              <tr>
                <td><div class="order-id">#ALV-2025-03819</div></td>
                <td><div class="order-date">Apr 14, 2025</div></td>
                <td><div class="order-items-list">Epithalon ×1, Selank ×1</div></td>
                <td><span class="status-badge status-delivered"><i data-lucide="check-circle" width="10" height="10"></i> Delivered</span></td>
                <td><div class="order-total">$170.00</div></td>
                <td><div class="order-actions"><button class="btn-sm outline">Reorder</button></div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- LOYALTY -->
      <div class="panel-card">
        <div class="panel-card-header">
          <h3><i data-lucide="star" width="18" height="18"></i> Loyalty Rewards</h3>
        </div>
        <div class="panel-card-body">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:1rem">
            <div>
              <div style="font-family:'Cormorant Garamond',serif;font-size:40px;font-weight:700;line-height:1">920 <span style="font-size:1rem;color:var(--text-light)">points</span></div>
              <div style="font-family:'Space Grotesk',sans-serif;font-size:12px;color:var(--text-light);margin-top:0.25rem">80 points until Gold tier</div>
            </div>
            <div style="text-align:right">
              <div style="font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--gold)">Pro Member</div>
              <div style="font-size:12px;color:var(--text-light)">5% discount on all orders</div>
            </div>
          </div>
          <div style="background:var(--pearl);border-radius:8px;height:10px;overflow:hidden">
            <div style="background:linear-gradient(90deg,var(--teal),var(--gold));height:100%;width:92%;border-radius:8px;transition:width 1s ease"></div>
          </div>
          <div style="display:flex;justify-content:space-between;font-family:'Space Grotesk',sans-serif;font-size:11px;color:var(--text-light);margin-top:0.4rem">
            <span>Pro (500 pts)</span><span>Gold (1000 pts)</span><span>Platinum (5000 pts)</span>
          </div>
        </div>
      </div>
    </div><!-- /dashboard -->

    <!-- ORDERS TAB -->
    <div class="tab-panel" id="panel-orders">
      <div class="panel-card">
        <div class="panel-card-header">
          <h3><i data-lucide="package" width="18" height="18"></i> All Orders</h3>
          <span style="font-family:'Space Grotesk',sans-serif;font-size:12px;color:var(--text-light)">12 orders total</span>
        </div>
        <div style="overflow-x:auto">
          <table class="orders-table">
            <thead>
              <tr><th>Order ID</th><th>Date</th><th>Items</th><th>Status</th><th>Total</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <tr>
                <td><div class="order-id">#ALV-2025-04872</div></td>
                <td><div class="order-date">Jun 10, 2025</div></td>
                <td>BPC-157 ×2, GHK-Cu, Ipamorelin</td>
                <td><span class="status-badge status-processing">Processing</span></td>
                <td><strong>$282.49</strong></td>
                <td><div class="order-actions"><button class="btn-sm">Track</button><button class="btn-sm outline">Invoice</button></div></td>
              </tr>
              <tr>
                <td><div class="order-id">#ALV-2025-04201</div></td>
                <td><div class="order-date">May 22, 2025</div></td>
                <td>TB-500, CJC-1295 ×2</td>
                <td><span class="status-badge status-delivered">Delivered</span></td>
                <td><strong>$218.00</strong></td>
                <td><div class="order-actions"><button class="btn-sm outline">Reorder</button><button class="btn-sm outline">Invoice</button></div></td>
              </tr>
              <tr>
                <td><div class="order-id">#ALV-2025-03819</div></td>
                <td><div class="order-date">Apr 14, 2025</div></td>
                <td>Epithalon, Selank</td>
                <td><span class="status-badge status-delivered">Delivered</span></td>
                <td><strong>$170.00</strong></td>
                <td><div class="order-actions"><button class="btn-sm outline">Reorder</button><button class="btn-sm outline">Invoice</button></div></td>
              </tr>
              <tr>
                <td><div class="order-id">#ALV-2025-03104</div></td>
                <td><div class="order-date">Mar 2, 2025</div></td>
                <td>Semaglutide ×1</td>
                <td><span class="status-badge status-shipped" style="background:rgba(106,166,198,0.15);color:#2d6e8a">Shipped</span></td>
                <td><strong>$185.00</strong></td>
                <td><div class="order-actions"><button class="btn-sm">Track</button></div></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- /orders -->

    <!-- PROFILE TAB -->
    <div class="tab-panel" id="panel-profile">
      <div class="panel-card">
        <div class="panel-card-header"><h3><i data-lucide="user" width="18" height="18"></i> Personal Information</h3></div>
        <div class="panel-card-body">
          <div class="profile-grid">
            <div class="form-group"><label>First Name</label><input type="text" value="Alexandra"></div>
            <div class="form-group"><label>Last Name</label><input type="text" value="Chen"></div>
          </div>
          <div class="profile-grid">
            <div class="form-group"><label>Email Address</label><input type="email" value="alex.chen@research.edu"></div>
            <div class="form-group"><label>Phone</label><input type="tel" value="+1 (310) 555-0174"></div>
          </div>
          <div class="profile-grid full">
            <div class="form-group"><label>Institution / Organization</label><input type="text" value="UCLA Department of Biochemistry"></div>
          </div>
          <div class="profile-grid full">
            <div class="form-group"><label>Research Field</label>
              <select>
                <option selected>Biochemistry / Molecular Biology</option>
                <option>Dermatology / Skincare Research</option>
                <option>Sports Medicine / Exercise Science</option>
                <option>Endocrinology</option>
                <option>Gerontology</option>
                <option>Other</option>
              </select>
            </div>
          </div>
          <button class="btn-save" onclick="showToast('Profile saved.')"><i data-lucide="save" width="15" height="15"></i> Save Changes</button>
        </div>
      </div>
    </div><!-- /profile -->

    <!-- ADDRESSES TAB -->
    <div class="tab-panel" id="panel-addresses">
      <div class="panel-card">
        <div class="panel-card-header">
          <h3><i data-lucide="map-pin" width="18" height="18"></i> Saved Addresses</h3>
          <button class="btn-sm"><i data-lucide="plus" width="14" height="14"></i> Add New</button>
        </div>
        <div class="panel-card-body">
          <div class="address-grid">
            <div class="addr-card default">
              <div class="addr-card-type"><i data-lucide="home" width="13" height="13"></i> Default Shipping <span class="default-tag">Default</span></div>
              <h4>Alexandra Chen</h4>
              <p>123 Wellness Avenue<br>Los Angeles, CA 90001<br>United States</p>
              <div class="addr-actions">
                <button class="btn-sm outline"><i data-lucide="edit-2" width="12" height="12"></i> Edit</button>
                <button class="btn-sm outline" style="color:var(--coral)"><i data-lucide="trash-2" width="12" height="12"></i> Remove</button>
              </div>
            </div>
            <div class="addr-card">
              <div class="addr-card-type"><i data-lucide="building" width="13" height="13"></i> Research Lab</div>
              <h4>Dr. Alexandra Chen</h4>
              <p>UCLA Biochemistry Building<br>607 Charles E. Young Drive East<br>Los Angeles, CA 90095</p>
              <div class="addr-actions">
                <button class="btn-sm outline"><i data-lucide="edit-2" width="12" height="12"></i> Edit</button>
                <button class="btn-sm">Set Default</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /addresses -->

    <!-- WISHLIST TAB -->
    <div class="tab-panel" id="panel-wishlist">
      <div class="panel-card">
        <div class="panel-card-header"><h3><i data-lucide="heart" width="18" height="18"></i> Wishlist (5 items)</h3></div>
        <div class="panel-card-body">
          <div class="wishlist-grid">
            <div class="wish-card">
              <div class="wish-thumb" style="background:rgba(14,175,159,0.1)"><i data-lucide="activity" width="28" height="28" style="color:var(--teal)"></i></div>
              <div class="wish-body"><div class="wish-name">BPC-157 — 10 mg</div><div class="wish-price">$115.00</div><button class="wish-add"><i data-lucide="shopping-cart" width="12" height="12"></i> Add to Cart</button></div>
            </div>
            <div class="wish-card">
              <div class="wish-thumb" style="background:rgba(138,96,193,0.1)"><i data-lucide="trending-down" width="28" height="28" style="color:var(--purple)"></i></div>
              <div class="wish-body"><div class="wish-name">Semaglutide — 5 mg</div><div class="wish-price">$185.00</div><button class="wish-add"><i data-lucide="shopping-cart" width="12" height="12"></i> Add to Cart</button></div>
            </div>
            <div class="wish-card">
              <div class="wish-thumb" style="background:rgba(106,166,198,0.1)"><i data-lucide="dna" width="28" height="28" style="color:var(--sky)"></i></div>
              <div class="wish-body"><div class="wish-name">Epithalon — 10 mg</div><div class="wish-price">$95.00</div><button class="wish-add"><i data-lucide="shopping-cart" width="12" height="12"></i> Add to Cart</button></div>
            </div>
            <div class="wish-card">
              <div class="wish-thumb" style="background:rgba(88,180,136,0.1)"><i data-lucide="feather" width="28" height="28" style="color:var(--mint)"></i></div>
              <div class="wish-body"><div class="wish-name">PTD-DBM — 10 mg</div><div class="wish-price">$55.00</div><button class="wish-add"><i data-lucide="shopping-cart" width="12" height="12"></i> Add to Cart</button></div>
            </div>
            <div class="wish-card">
              <div class="wish-thumb" style="background:rgba(212,102,60,0.1)"><i data-lucide="dumbbell" width="28" height="28" style="color:var(--orange)"></i></div>
              <div class="wish-body"><div class="wish-name">TB-500 — 5 mg</div><div class="wish-price">$78.00</div><button class="wish-add"><i data-lucide="shopping-cart" width="12" height="12"></i> Add to Cart</button></div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /wishlist -->

    <!-- SECURITY TAB -->
    <div class="tab-panel" id="panel-security">
      <div class="panel-card">
        <div class="panel-card-header"><h3><i data-lucide="shield" width="18" height="18"></i> Account Security</h3></div>
        <div class="panel-card-body">
          <div class="security-item">
            <div class="security-info">
              <div class="security-icon"><i data-lucide="lock" width="18" height="18"></i></div>
              <div><div class="security-title">Password</div><div class="security-sub">Last changed 42 days ago</div></div>
            </div>
            <button class="btn-sm">Change Password</button>
          </div>
          <div class="security-item">
            <div class="security-info">
              <div class="security-icon"><i data-lucide="smartphone" width="18" height="18"></i></div>
              <div>
                <div class="security-title">Two-Factor Authentication</div>
                <div class="security-sub security-status status-on"><i data-lucide="check-circle" width="12" height="12"></i> Enabled via Authenticator App</div>
              </div>
            </div>
            <button class="btn-sm outline">Manage</button>
          </div>
          <div class="security-item">
            <div class="security-info">
              <div class="security-icon"><i data-lucide="monitor" width="18" height="18"></i></div>
              <div><div class="security-title">Active Sessions</div><div class="security-sub">2 devices — Chrome/Mac, Safari/iPhone</div></div>
            </div>
            <button class="btn-sm outline" style="color:var(--coral)">Sign Out All</button>
          </div>
          <div class="security-item">
            <div class="security-info">
              <div class="security-icon"><i data-lucide="bell" width="18" height="18"></i></div>
              <div>
                <div class="security-title">Login Notifications</div>
                <div class="security-sub security-status status-on"><i data-lucide="check-circle" width="12" height="12"></i> Email alerts enabled</div>
              </div>
            </div>
            <button class="btn-sm outline">Settings</button>
          </div>
        </div>
      </div>
    </div><!-- /security -->

  </div><!-- main content -->
</div><!-- .account-layout -->

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
      <div class="footer-col"><h4>Products</h4><ul>
        <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Medical Peptides</a></li>
        <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Skincare Peptides</a></li>
        <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Sports & Recovery</a></li>
        <li><a href="<?php echo esc_url(alluvia_shop_url()); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Anti-Aging</a></li>
      </ul></div>
      <div class="footer-col"><h4>Company</h4><ul>
        <li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>About Alluvia</a></li>
        <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Contact Us</a></li>
        <li><a href="#"><i data-lucide="chevron-right" width="12" height="12"></i>COA Library</a></li>
      </ul></div>
      <div class="footer-col"><h4>Legal</h4><ul>
        <li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Terms & Conditions</a></li>
        <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" width="12" height="12"></i>Shipping Policy</a></li>
        <li><a href="#"><i data-lucide="chevron-right" width="12" height="12"></i>Privacy Policy</a></li>
      </ul></div>
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

function switchTab(tab, el) {
  if (el && el.preventDefault) el.preventDefault();
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.sidebar-nav a').forEach(a => a.classList.remove('active'));
  document.getElementById('panel-' + tab).classList.add('active');
  if (el && el.classList) el.classList.add('active');
  window.scrollTo({top:0,behavior:'smooth'});
  return false;
}

// Make sidebar links work
document.querySelectorAll('.sidebar-nav a').forEach(a => {
  a.addEventListener('click', function(e) {
    e.preventDefault();
    const tab = this.getAttribute('onclick').match(/switchTab\('(\w+)'/)[1];
    switchTab(tab, this);
  });
});

document.querySelectorAll('.wish-add').forEach(b => {
  b.addEventListener('click', () => showToast('Added to cart!'));
});

document.querySelector('.sidebar-logout').addEventListener('click', () => showToast('Signed out.'));

function showToast(msg) {
  const t = document.createElement('div');
  t.textContent = msg;
  Object.assign(t.style, {
    position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',
    background:'#0eaf9f',color:'#0a1a27',padding:'0.75rem 1.5rem',borderRadius:'50px',
    fontFamily:"'Space Grotesk',sans-serif",fontSize:'0.85rem',fontWeight:'600',
    zIndex:'9999',boxShadow:'0 8px 24px rgba(0,0,0,0.2)',transition:'opacity 0.3s'
  });
  document.body.appendChild(t);
  setTimeout(() => { t.style.opacity='0'; setTimeout(() => t.remove(), 300); }, 2200);
}
</script>
<?php get_footer( 'alluvia' ); ?>
