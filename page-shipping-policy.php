<?php
/**
 * Template Name: Alluvia – Shipping Policy
 *
 * @package Shopping
 */
add_action( 'wp_head', function() {
?>
<style>
/* HERO */
.page-hero{background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);padding:6rem 2rem 3rem;margin-top:72px}
.page-hero-inner{max-width:900px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:var(--text-light);margin-bottom:1rem}
.breadcrumb a{color:var(--teal);text-decoration:none}
.page-hero h1{font-family:var(--font-display);font-size:clamp(44px,5.5vw,76px);font-weight:600;color:#fff;margin-bottom:0.5rem}
.page-hero p{color:rgba(255,255,255,0.65);font-size:var(--fs-base)}

/* COLD CHAIN COMMITMENT */
.cold-chain-block{background:linear-gradient(135deg,var(--navy-mid),var(--navy-soft));padding:3.5rem 2rem;border-bottom:1px solid rgba(14,175,159,0.15)}
.cold-chain-inner{max-width:900px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr 1fr;gap:2rem}
.cold-stat{text-align:center;padding:1.5rem;border-radius:var(--radius);background:rgba(255,255,255,0.04);border:1px solid rgba(14,175,159,0.12)}
.cold-stat-icon{width:56px;height:56px;border-radius:50%;background:rgba(14,175,159,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;color:var(--teal)}
.cold-stat-num{font-family:var(--font-display);font-size:35px;font-weight:700;color:#fff;line-height:1}
.cold-stat-label{font-family:var(--font-ui);font-size:12px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-light);margin-top:0.3rem}

/* MAIN CONTENT */
.shipping-content{max-width:900px;margin:0 auto;padding:4rem 2rem}

/* SECTION */
.shipping-section{background:#fff;border-radius:var(--radius);padding:2rem;margin-bottom:2rem;box-shadow:0 2px 12px rgba(0,0,0,0.05)}
.section-header{display:flex;align-items:center;gap:0.75rem;margin-bottom:1.5rem}
.section-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.section-header h2{font-family:var(--font-display);font-size:24px;font-weight:600}

/* SHIPPING TABLE */
.ship-table{width:100%;border-collapse:collapse;font-size:14px}
.ship-table th{background:var(--navy);color:rgba(255,255,255,0.7);font-family:var(--font-ui);font-size:12px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;padding:0.75rem 1rem;text-align:left}
.ship-table th:first-child{border-radius:8px 0 0 0}
.ship-table th:last-child{border-radius:0 8px 0 0}
.ship-table td{padding:0.85rem 1rem;border-bottom:1px solid var(--pearl);vertical-align:middle}
.ship-table tr:last-child td{border-bottom:none}
.ship-table tr:hover td{background:var(--pearl)}
.method-name{font-family:var(--font-ui);font-weight:600;font-size:14px}
.method-sub{font-size:12px;color:var(--text-light);margin-top:2px}
.price-cell{font-family:var(--font-ui);font-weight:700;color:var(--teal-dark)}
.price-free{color:var(--mint)}
.eta-cell{color:var(--text-mid)}
.ship-badge-sm{font-family:var(--font-ui);font-size:10px;font-weight:700;padding:2px 7px;border-radius:50px;letter-spacing:0.06em}
.badge-rec{background:rgba(106,166,198,0.15);color:#2d6e8a}
.badge-fast{background:rgba(212,102,60,0.15);color:#a04020}

/* INFO CARD */
.info-card{border-left:3px solid var(--teal);background:rgba(14,175,159,0.05);border-radius:0 8px 8px 0;padding:1rem 1.25rem;margin-bottom:1rem;font-size:14px;color:var(--text-mid)}
.info-card strong{color:var(--text-dark)}
.warn-card{border-left:3px solid var(--gold);background:rgba(198,162,83,0.07);border-radius:0 8px 8px 0;padding:1rem 1.25rem;margin-bottom:1rem;font-size:14px;color:var(--text-mid)}

/* LIST ITEMS */
.check-list{list-style:none;display:flex;flex-direction:column;gap:0.6rem}
.check-list li{display:flex;align-items:flex-start;gap:0.6rem;font-size:var(--fs-body);color:var(--text-mid);line-height:1.85}
.check-list li svg{color:var(--teal);flex-shrink:0;margin-top:2px}

/* FAQ */
.faq-item{border:1px solid var(--pearl-dark);border-radius:8px;margin-bottom:0.75rem;overflow:hidden}
.faq-q{padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;cursor:pointer;font-family:var(--font-ui);font-weight:600;font-size:var(--fs-body);background:#fff;transition:background .2s;user-select:none}
.faq-q:hover{background:var(--pearl)}
.faq-q svg{transition:transform .3s;color:var(--teal);flex-shrink:0}
.faq-a{max-height:0;overflow:hidden;transition:max-height .3s ease,padding .3s}
.faq-a.open{max-height:300px;padding:0 1.25rem 1rem}
.faq-a p{font-size:var(--fs-body);color:var(--text-mid);line-height:1.85}

/* PACKAGING GRID */
.pkg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}
.pkg-card{border:1px solid var(--pearl-dark);border-radius:10px;padding:1.25rem;text-align:center}
.pkg-card-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem}
.pkg-card h4{font-family:var(--font-ui);font-size:var(--fs-sm);font-weight:700;margin-bottom:0.3rem}
.pkg-card p{font-size:var(--fs-sm);color:var(--text-light)}

@media(max-width:900px){.cold-chain-inner{grid-template-columns:1fr 1fr}.pkg-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){
  .page-hero h1{font-size:clamp(36px,9vw,52px)!important}
  .cold-chain-inner{grid-template-columns:1fr}.pkg-grid{grid-template-columns:1fr}
}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="page-hero">
  <div class="page-hero-inner">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      <i data-lucide="chevron-right" width="14" height="14"></i>
      <span>Shipping Policy</span>
    </div>
    <h1>Shipping & Delivery</h1>
    <p>Last updated: June 2025 · Effective immediately</p>
  </div>
</div>

<!-- COLD CHAIN STATS -->
<div class="cold-chain-block">
  <div class="cold-chain-inner">
    <div class="cold-stat">
      <div class="cold-stat-icon"><i data-lucide="thermometer-snowflake" width="24" height="24"></i></div>
      <div class="cold-stat-num">2–8°C</div>
      <div class="cold-stat-label">Maintained throughout cold-chain transit</div>
    </div>
    <div class="cold-stat">
      <div class="cold-stat-icon"><i data-lucide="package-check" width="24" height="24"></i></div>
      <div class="cold-stat-num">99.7%</div>
      <div class="cold-stat-label">Orders arrive with full peptide integrity</div>
    </div>
    <div class="cold-stat">
      <div class="cold-stat-icon"><i data-lucide="clock" width="24" height="24"></i></div>
      <div class="cold-stat-num">Same Day</div>
      <div class="cold-stat-label">Dispatch for orders placed before 1 PM EST</div>
    </div>
  </div>
</div>

<div class="shipping-content">

  <!-- DISPATCH -->
  <div class="shipping-section">
    <div class="section-header">
      <div class="section-icon" style="background:rgba(14,175,159,0.1)"><i data-lucide="package" width="22" height="22" style="color:var(--teal)"></i></div>
      <h2>Order Processing & Dispatch</h2>
    </div>
    <div class="info-card">
      <strong>Cut-off time: 1:00 PM EST Monday–Friday.</strong> Orders received before this window dispatch the same business day. Orders received after 1 PM or on weekends dispatch the next business day.
    </div>
    <ul class="check-list">
      <li><i data-lucide="check-circle" width="16" height="16"></i>All peptides undergo pre-shipment quality verification before packaging</li>
      <li><i data-lucide="check-circle" width="16" height="16"></i>COA (Certificate of Analysis) is included digitally with every order confirmation email</li>
      <li><i data-lucide="check-circle" width="16" height="16"></i>Lyophilized (freeze-dried) vials are sealed under nitrogen and vacuum-checked before dispatch</li>
      <li><i data-lucide="check-circle" width="16" height="16"></i>Tracking information emailed within 2 hours of dispatch</li>
      <li><i data-lucide="check-circle" width="16" height="16"></i>Discreet packaging — no brand name on exterior label</li>
    </ul>
  </div>

  <!-- US DOMESTIC RATES -->
  <div class="shipping-section">
    <div class="section-header">
      <div class="section-icon" style="background:rgba(106,166,198,0.1)"><i data-lucide="map" width="22" height="22" style="color:var(--sky)"></i></div>
      <h2>US Domestic Shipping Rates</h2>
    </div>
    <div style="overflow-x:auto">
    <table class="ship-table">
      <thead>
        <tr>
          <th>Method</th>
          <th>Estimated Delivery</th>
          <th>Cost</th>
          <th>Cold-Chain</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><div class="method-name">Standard Shipping</div><div class="method-sub">USPS Priority Mail</div></td>
          <td class="eta-cell">3–5 business days</td>
          <td class="price-cell price-free">Free (orders $50+)<br><span style="color:var(--text-light);font-weight:400">$5.99 under $50</span></td>
          <td><span style="color:var(--text-light);font-size:13px">Not included</span></td>
        </tr>
        <tr>
          <td><div class="method-name">Express Shipping</div><div class="method-sub">FedEx / UPS 2-Day</div></td>
          <td class="eta-cell">1–2 business days</td>
          <td class="price-cell">$12.99</td>
          <td><span style="color:var(--text-light);font-size:13px">Not included</span></td>
        </tr>
        <tr>
          <td>
            <div class="method-name">Cold-Chain Overnight <span class="ship-badge-sm badge-rec">Recommended</span></div>
            <div class="method-sub">FedEx Overnight + insulated packaging</div>
          </td>
          <td class="eta-cell">Next business day</td>
          <td class="price-cell">$24.99</td>
          <td><i data-lucide="check-circle" width="16" height="16" style="color:var(--teal)"></i></td>
        </tr>
        <tr>
          <td>
            <div class="method-name">Cold-Chain Saturday <span class="ship-badge-sm badge-fast">Weekend</span></div>
            <div class="method-sub">FedEx Saturday Delivery</div>
          </td>
          <td class="eta-cell">Saturday delivery</td>
          <td class="price-cell">$34.99</td>
          <td><i data-lucide="check-circle" width="16" height="16" style="color:var(--teal)"></i></td>
        </tr>
      </tbody>
    </table>
    </div>
    <div class="warn-card" style="margin-top:1rem">
      <strong style="color:var(--text-dark)">Why we recommend Cold-Chain:</strong> Peptide bonds are susceptible to thermal degradation. While lyophilized peptides tolerate short ambient exposure, prolonged warm transit can reduce bioactivity. Cold-chain shipping ensures 2–8°C throughout the entire journey, preserving ≥99% potency.
    </div>
  </div>

  <!-- INTERNATIONAL -->
  <div class="shipping-section">
    <div class="section-header">
      <div class="section-icon" style="background:rgba(138,96,193,0.1)"><i data-lucide="globe" width="22" height="22" style="color:var(--purple)"></i></div>
      <h2>International Shipping</h2>
    </div>
    <div style="overflow-x:auto">
    <table class="ship-table">
      <thead>
        <tr>
          <th>Region</th>
          <th>Method</th>
          <th>Estimated Delivery</th>
          <th>Cost</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>Canada</strong></td>
          <td>FedEx International Economy</td>
          <td class="eta-cell">5–7 business days</td>
          <td class="price-cell">$18.99</td>
        </tr>
        <tr>
          <td><strong>United Kingdom</strong></td>
          <td>FedEx International Priority</td>
          <td class="eta-cell">3–5 business days</td>
          <td class="price-cell">$28.99</td>
        </tr>
        <tr>
          <td><strong>European Union</strong></td>
          <td>FedEx International Priority</td>
          <td class="eta-cell">4–6 business days</td>
          <td class="price-cell">$32.99</td>
        </tr>
        <tr>
          <td><strong>Australia / NZ</strong></td>
          <td>FedEx International Economy</td>
          <td class="eta-cell">7–10 business days</td>
          <td class="price-cell">$38.99</td>
        </tr>
        <tr>
          <td><strong>Rest of World</strong></td>
          <td>DHL Express</td>
          <td class="eta-cell">7–14 business days</td>
          <td class="price-cell">$44.99</td>
        </tr>
      </tbody>
    </table>
    </div>
    <div class="info-card" style="margin-top:1rem">
      <strong>Import duties and taxes:</strong> International customers are responsible for any customs duties, import taxes, or fees levied by their country. Alluvia Peptides ships DDP (Delivered Duty Paid) for Canada and the UK; all other regions are DAP (Delivered At Place). Please check local regulations regarding peptide importation before ordering.
    </div>
  </div>

  <!-- PACKAGING -->
  <div class="shipping-section">
    <div class="section-header">
      <div class="section-icon" style="background:rgba(88,180,136,0.1)"><i data-lucide="box" width="22" height="22" style="color:var(--mint)"></i></div>
      <h2>Packaging Standards</h2>
    </div>
    <div class="pkg-grid">
      <div class="pkg-card">
        <div class="pkg-card-icon" style="background:rgba(106,166,198,0.1)"><i data-lucide="thermometer-snowflake" width="22" height="22" style="color:var(--sky)"></i></div>
        <h4>Insulated Liner</h4>
        <p>Foil-laminated foam insulation maintains internal temperature for 48+ hours</p>
      </div>
      <div class="pkg-card">
        <div class="pkg-card-icon" style="background:rgba(14,175,159,0.1)"><i data-lucide="cloud-snow" width="22" height="22" style="color:var(--teal)"></i></div>
        <h4>Dry Ice / Ice Packs</h4>
        <p>Pharmaceutical-grade dry ice or gel packs calibrated to order size and transit time</p>
      </div>
      <div class="pkg-card">
        <div class="pkg-card-icon" style="background:rgba(198,162,83,0.1)"><i data-lucide="shield" width="22" height="22" style="color:var(--gold)"></i></div>
        <h4>Tamper Evidence</h4>
        <p>Tamper-evident seals on all vials and outer packaging with lot number verification</p>
      </div>
    </div>
    <ul class="check-list" style="margin-top:1.25rem">
      <li><i data-lucide="check-circle" width="16" height="16"></i>Nitrogen-sealed vials inside individual resealable pouches</li>
      <li><i data-lucide="check-circle" width="16" height="16"></i>Outer box bears no peptide or brand markings — fully discreet</li>
      <li><i data-lucide="check-circle" width="16" height="16"></i>Temperature indicator card included in every cold-chain shipment</li>
      <li><i data-lucide="check-circle" width="16" height="16"></i>Shock-absorbent foam inserts prevent vial breakage during transit</li>
    </ul>
  </div>

  <!-- FAQ -->
  <div class="shipping-section">
    <div class="section-header">
      <div class="section-icon" style="background:rgba(219,98,122,0.1)"><i data-lucide="help-circle" width="22" height="22" style="color:var(--coral)"></i></div>
      <h2>Shipping FAQs</h2>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        What if my order arrives warm?
        <i data-lucide="chevron-down" width="18" height="18"></i>
      </div>
      <div class="faq-a">
        <p>If you selected Cold-Chain shipping and your order arrives at ambient temperature, contact us within 24 hours with a photo of the temperature indicator card. We will reship at no charge. Standard shipping does not include a temperature guarantee, though lyophilized peptides tolerate transit at ambient temperatures for short periods.</p>
      </div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        Can I change my shipping address after ordering?
        <i data-lucide="chevron-down" width="18" height="18"></i>
      </div>
      <div class="faq-a">
        <p>Address changes can be requested up to 1 hour after order placement by contacting support@alluviapeptides.com. Once an order enters the dispatch queue, address changes may not be possible and a rerouting fee may apply.</p>
      </div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        Do you ship to PO Boxes?
        <i data-lucide="chevron-down" width="18" height="18"></i>
      </div>
      <div class="faq-a">
        <p>Standard USPS shipping can deliver to PO Boxes. Cold-Chain Overnight and Express shipping via FedEx/UPS require a physical street address. We recommend using a street address for all cold-chain orders to ensure next-day delivery availability.</p>
      </div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        What happens if my package is lost or damaged?
        <i data-lucide="chevron-down" width="18" height="18"></i>
      </div>
      <div class="faq-a">
        <p>All orders are insured up to their full value. For lost packages, we initiate a carrier trace within 24 hours of the expected delivery date. If the package is confirmed lost, we reship at no charge. For damaged packaging, please photograph and email us within 48 hours — we will assess and reship affected items.</p>
      </div>
    </div>
    <div class="faq-item">
      <div class="faq-q" onclick="toggleFaq(this)">
        How are peptides stored before shipping?
        <i data-lucide="chevron-down" width="18" height="18"></i>
      </div>
      <div class="faq-a">
        <p>All peptides are stored in our climate-controlled facility at 2–8°C for solutions and −20°C for lyophilized powders, from the moment they pass HPLC testing until the moment they are packaged for dispatch. Our cold-storage chain begins at synthesis and ends at your door.</p>
      </div>
    </div>
  </div>

</div><!-- .shipping-content -->

<?php get_template_part('partials/footer-alluvia'); ?>

<script>
lucide.createIcons();
function toggleFaq(el) {
  const answer = el.nextElementSibling;
  const icon = el.querySelector('svg');
  answer.classList.toggle('open');
  icon.style.transform = answer.classList.contains('open') ? 'rotate(180deg)' : '';
}
</script>
<?php get_footer( 'alluvia' ); ?>
