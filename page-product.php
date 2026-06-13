<?php
/**
 * Template Name: Alluvia – Product
 *
 * @package Shopping
 */

// ── Product data ─────────────────────────────────────────────────────────────
$product      = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
$price_html   = $product ? $product->get_price_html() : '';
$short_desc   = $product ? $product->get_short_description() : '';
$long_desc    = get_the_content();
$avg_rating   = $product ? floatval($product->get_average_rating()) : 0;
$review_count = $product ? $product->get_review_count() : 0;
$stock_status = $product ? $product->get_stock_status() : 'instock';
$is_on_sale   = $product && $product->is_on_sale();
$is_featured  = $product && $product->is_featured();
$add_to_cart_url = $product ? $product->add_to_cart_url() : '#';
$thumb_url    = get_the_post_thumbnail_url(get_the_ID(), 'woocommerce_single');
$terms        = wp_get_post_terms(get_the_ID(), 'product_cat', ['number' => 1]);
$primary_cat  = (!is_wp_error($terms) && !empty($terms)) ? $terms[0] : null;
$cat_name     = $primary_cat ? $primary_cat->name : '';
$cat_url      = $primary_cat ? get_term_link($primary_cat) : alluvia_shop_url();
$related_ids  = $product ? wc_get_related_products(get_the_ID(), 4) : [];

add_action( 'wp_head', function() {
?>
<style>
.product-wrap{max-width:1200px;margin:0 auto;padding:6.5rem 2rem 2rem}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:'Space Grotesk',sans-serif;font-size:var(--fs-ui);color:var(--text-mid);margin-bottom:1.5rem}
.breadcrumb a{color:var(--teal-dark);text-decoration:none}

/* PRODUCT MAIN */
.product-main{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start}

/* GALLERY */
.gallery{}
.gallery-main{background:#fff;border-radius:var(--radius);height:420px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 24px rgba(0,0,0,0.06);position:relative;overflow:hidden;border:1px solid var(--pearl-dark)}
.gallery-main::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 50% 40%,rgba(14,175,159,0.08),transparent 70%)}
.gallery-main .vial-icon{position:relative;z-index:1}
.gallery-badge{position:absolute;top:1rem;left:1rem;background:var(--teal);color:var(--navy);font-family:'Space Grotesk',sans-serif;font-size:11px;font-weight:700;letter-spacing:0.06em;padding:4px 12px;border-radius:50px;text-transform:uppercase;z-index:2}
.gallery-thumbs{display:flex;gap:0.75rem;margin-top:1rem}
.gallery-thumb{flex:1;background:#fff;border-radius:8px;height:80px;display:flex;align-items:center;justify-content:center;cursor:pointer;border:2px solid transparent;transition:all .2s}
.gallery-thumb.active{border-color:var(--teal)}
.gallery-thumb:hover{border-color:rgba(14,175,159,0.4)}

/* PRODUCT INFO */
.product-info{}
.prod-cat{font-family:'Space Grotesk',sans-serif;font-size:var(--fs-micro);font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--teal-dark);margin-bottom:0.5rem}
.product-info h1{font-family:'Cormorant Garamond',serif;font-size:var(--fs-h1);font-weight:600;line-height:1.1;margin-bottom:0.5rem}
.prod-subtitle{font-size:var(--fs-body);color:var(--text-mid);margin-bottom:1rem;line-height:1.8}
.prod-rating{display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem}
.stars{display:flex;gap:2px;color:var(--gold)}
.rating-text{font-family:'Space Grotesk',sans-serif;font-size:13px;color:var(--text-mid)}
.rating-text a{color:var(--teal-dark);text-decoration:none}
.prod-price-row{display:flex;align-items:baseline;gap:0.75rem;margin-bottom:1.5rem}
.prod-price{font-family:'Cormorant Garamond',serif;font-size:var(--fs-h3);font-weight:700;color:var(--navy)}
.prod-price-old{font-family:'Space Grotesk',sans-serif;font-size:18px;color:var(--text-light);text-decoration:line-through}
.prod-save{background:rgba(219,98,122,0.12);color:#c0405a;font-family:'Space Grotesk',sans-serif;font-size:12px;font-weight:700;padding:3px 10px;border-radius:50px}

/* SPEC GRID */
.spec-grid{display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1.5rem;padding:1.25rem;background:#fff;border-radius:var(--radius);border:1px solid var(--pearl-dark)}
.spec-item{display:flex;align-items:center;gap:0.6rem}
.spec-item svg{color:var(--teal);flex-shrink:0}
.spec-label{font-size:var(--fs-micro);color:var(--text-light);font-family:'Space Grotesk',sans-serif;text-transform:uppercase;letter-spacing:0.04em}
.spec-value{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:var(--fs-base)}

/* PURCHASE */
.purchase-row{display:flex;gap:1rem;align-items:stretch;margin-bottom:1rem}
.qty-stepper{display:flex;align-items:center;border:1px solid var(--pearl-dark);border-radius:10px;overflow:hidden;background:#fff}
.qty-btn{background:#fff;border:none;width:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-mid);transition:all .2s}
.qty-btn:hover{background:var(--teal);color:#fff}
.qty-input{width:50px;border:none;border-left:1px solid var(--pearl-dark);border-right:1px solid var(--pearl-dark);text-align:center;font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:16px;outline:none}
.btn-add-cart{flex:1;background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);border:none;border-radius:10px;font-family:'Space Grotesk',sans-serif;font-size:16px;font-weight:700;letter-spacing:0.05em;text-transform:uppercase;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:all .3s}
.btn-add-cart:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(14,175,159,0.35)}
.btn-wishlist{width:52px;background:#fff;border:1px solid var(--pearl-dark);border-radius:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-mid);transition:all .2s}
.btn-wishlist:hover{border-color:var(--coral);color:var(--coral)}
.btn-wishlist.active{background:rgba(219,98,122,0.08);border-color:var(--coral);color:var(--coral)}
.buy-now{display:block;width:100%;text-align:center;background:var(--navy);color:#fff;border:none;border-radius:10px;padding:0.85rem;font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:600;letter-spacing:0.04em;cursor:pointer;text-decoration:none;transition:all .2s;margin-bottom:1.25rem}
.buy-now:hover{background:var(--teal-dark)}

/* ASSURANCE */
.assurance{display:flex;flex-direction:column;gap:0.6rem;padding:1.25rem;background:rgba(14,175,159,0.04);border:1px solid rgba(14,175,159,0.15);border-radius:var(--radius)}
.assurance-item{display:flex;align-items:center;gap:0.6rem;font-size:var(--fs-base);color:var(--text-mid)}
.assurance-item svg{color:var(--teal);flex-shrink:0}

/* TABS */
.product-tabs{max-width:1200px;margin:3.5rem auto 0;padding:0 2rem}
.tab-nav{display:flex;gap:0.5rem;border-bottom:2px solid var(--pearl-dark);margin-bottom:2rem;overflow-x:auto}
.tab-btn{background:none;border:none;padding:1rem 1.5rem;font-family:'Space Grotesk',sans-serif;font-size:var(--fs-ui);font-weight:600;color:var(--text-light);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;transition:all .2s}
.tab-btn:hover{color:var(--teal-dark)}
.tab-btn.active{color:var(--navy);border-bottom-color:var(--teal)}
.tab-pane{display:none;animation:fade .3s}
.tab-pane.active{display:block}
@keyframes fade{from{opacity:0}to{opacity:1}}
.tab-content-card{background:#fff;border-radius:var(--radius);padding:2.25rem;box-shadow:0 2px 12px rgba(0,0,0,0.05)}
.tab-content-card h3{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;margin-bottom:1rem}
.tab-content-card h4{font-family:'Space Grotesk',sans-serif;font-size:15px;font-weight:700;margin:1.5rem 0 0.5rem}
.tab-content-card p{font-size:var(--fs-body);color:var(--text-mid);line-height:1.8;margin-bottom:1rem}
.research-list{list-style:none;display:flex;flex-direction:column;gap:0.6rem;margin-bottom:1rem}
.research-list li{display:flex;align-items:flex-start;gap:0.6rem;font-size:var(--fs-body);color:var(--text-mid)}
.research-list li svg{color:var(--teal);flex-shrink:0;margin-top:3px}

/* SPECS TABLE */
.specs-table{width:100%;border-collapse:collapse;font-size:var(--fs-body)}
.specs-table td{padding:0.85rem 1rem;border-bottom:1px solid var(--pearl)}
.specs-table tr:last-child td{border-bottom:none}
.specs-table td:first-child{font-family:'Space Grotesk',sans-serif;font-weight:600;color:var(--text-dark);width:40%}
.specs-table td:last-child{color:var(--text-mid)}

/* COA BLOCK */
.coa-block{display:flex;align-items:center;justify-content:space-between;background:rgba(14,175,159,0.05);border:1px solid rgba(14,175,159,0.2);border-radius:10px;padding:1.25rem 1.5rem;flex-wrap:wrap;gap:1rem}
.coa-info{display:flex;align-items:center;gap:1rem}
.coa-icon{width:48px;height:48px;border-radius:10px;background:rgba(14,175,159,0.12);display:flex;align-items:center;justify-content:center;color:var(--teal)}
.coa-title{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:15px}
.coa-sub{font-size:13px;color:var(--text-light)}
.btn-coa{background:var(--navy);color:#fff;border:none;border-radius:8px;padding:0.65rem 1.5rem;font-family:'Space Grotesk',sans-serif;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.4rem;text-decoration:none}
.btn-coa:hover{background:var(--teal-dark)}

/* REVIEWS */
.review-summary{display:flex;gap:2.5rem;align-items:center;margin-bottom:2rem;flex-wrap:wrap}
.review-score{text-align:center}
.review-score .big{font-family:'Cormorant Garamond',serif;font-size:56px;font-weight:700;line-height:1}
.review-bars{flex:1;min-width:240px}
.review-bar-row{display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;font-size:13px}
.review-bar-row .lbl{font-family:'Space Grotesk',sans-serif;color:var(--text-mid);width:40px}
.review-bar-track{flex:1;height:8px;background:var(--pearl);border-radius:8px;overflow:hidden}
.review-bar-fill{height:100%;background:var(--gold);border-radius:8px}
.review-card{border-bottom:1px solid var(--pearl);padding:1.25rem 0}
.review-card:last-child{border-bottom:none}
.review-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem}
.reviewer{display:flex;align-items:center;gap:0.75rem}
.reviewer-avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));display:flex;align-items:center;justify-content:center;font-family:'Space Grotesk',sans-serif;font-weight:700;color:var(--navy);font-size:14px}
.reviewer-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:14px}
.reviewer-meta{font-size:12px;color:var(--text-light);display:flex;align-items:center;gap:0.3rem}
.verified-tag{color:var(--mint);display:inline-flex;align-items:center;gap:0.2rem;font-weight:600}
.review-body{font-size:var(--fs-body);color:var(--text-mid);line-height:1.8}

/* RELATED */
.related{max-width:1200px;margin:4rem auto;padding:0 2rem}
.related h2{font-family:'Cormorant Garamond',serif;font-size:29px;font-weight:600;margin-bottom:1.5rem}
.related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem}
.rel-card{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;text-decoration:none;color:inherit;display:block}
.rel-card:hover{transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,0.12)}
.rel-thumb{height:110px;display:flex;align-items:center;justify-content:center}
.rel-body{padding:1rem}
.rel-cat{font-family:'Space Grotesk',sans-serif;font-size:10px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-light)}
.rel-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:var(--fs-base);margin:0.25rem 0}
.rel-price{font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:16px;color:var(--teal-dark)}

@media(max-width:900px){.product-main{grid-template-columns:1fr;gap:2rem}.related-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){.spec-grid{grid-template-columns:1fr}.related-grid{grid-template-columns:1fr}.gallery-main{height:300px}}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<div class="product-wrap">
  <div class="breadcrumb">
    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
    <i data-lucide="chevron-right" width="14" height="14"></i>
    <a href="<?php echo esc_url(alluvia_shop_url()); ?>">Shop</a>
    <i data-lucide="chevron-right" width="14" height="14"></i>
    <?php if ($cat_name) : ?>
      <a href="<?php echo esc_url(is_wp_error($cat_url) ? alluvia_shop_url() : $cat_url); ?>"><?php echo esc_html($cat_name); ?></a>
      <i data-lucide="chevron-right" width="14" height="14"></i>
    <?php endif; ?>
    <span><?php echo esc_html(get_the_title()); ?></span>
  </div>

  <div class="product-main">
    <!-- GALLERY -->
    <div class="gallery">
      <div class="gallery-main">
        <?php if ($is_featured) : ?>
          <span class="gallery-badge">Best Seller</span>
        <?php elseif ($is_on_sale) : ?>
          <span class="gallery-badge" style="background:var(--coral);color:#fff">Sale</span>
        <?php endif; ?>
        <?php if ($thumb_url) : ?>
          <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
        <?php else : ?>
          <i class="vial-icon" data-lucide="flask-conical" width="120" height="120" style="color:var(--teal)"></i>
        <?php endif; ?>
      </div>
      <div class="gallery-thumbs">
        <div class="gallery-thumb active"><i data-lucide="activity" width="32" height="32" style="color:var(--teal)"></i></div>
        <div class="gallery-thumb"><i data-lucide="flask-conical" width="32" height="32" style="color:var(--teal-dark)"></i></div>
        <div class="gallery-thumb"><i data-lucide="file-text" width="32" height="32" style="color:var(--gold)"></i></div>
        <div class="gallery-thumb"><i data-lucide="microscope" width="32" height="32" style="color:var(--sky)"></i></div>
      </div>
    </div>

    <!-- INFO -->
    <div class="product-info">
      <?php if ($cat_name) : ?><div class="prod-cat"><?php echo esc_html($cat_name); ?></div><?php endif; ?>
      <h1><?php echo esc_html(get_the_title()); ?></h1>
      <?php if ($short_desc) : ?><p class="prod-subtitle"><?php echo wp_kses_post($short_desc); ?></p><?php endif; ?>
      <?php if ($avg_rating > 0) : ?>
      <div class="prod-rating">
        <span class="stars">
          <?php for ($s=1;$s<=5;$s++): ?><svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $s<=round($avg_rating)?'currentColor':'none'; ?>" stroke="currentColor" stroke-width="1.5"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg><?php endfor; ?>
        </span>
        <span class="rating-text"><?php echo esc_html(number_format($avg_rating,1)); ?><?php if($review_count>0): ?> · <a href="#reviews"><?php echo esc_html($review_count); ?> verified reviews</a><?php endif; ?></span>
      </div>
      <?php endif; ?>
      <div class="prod-price-row">
        <span class="prod-price"><?php echo $price_html; ?></span>
      </div>

      <div class="spec-grid">
        <div class="spec-item"><i data-lucide="check-circle" width="18" height="18"></i><div>
          <div class="spec-label">Stock</div>
          <div class="spec-value" style="color:<?php echo $stock_status==='instock'?'var(--mint)':'var(--coral)'; ?>">
            <?php echo $stock_status==='instock'?'In Stock':($stock_status==='onbackorder'?'On Backorder':'Out of Stock'); ?>
          </div>
        </div></div>
        <?php if($product&&$product->get_sku()): ?>
        <div class="spec-item"><i data-lucide="tag" width="18" height="18"></i><div><div class="spec-label">SKU</div><div class="spec-value"><?php echo esc_html($product->get_sku()); ?></div></div></div>
        <?php endif; ?>
        <?php if($product&&$product->get_attribute('purity')): ?>
        <div class="spec-item"><i data-lucide="beaker" width="18" height="18"></i><div><div class="spec-label">Purity</div><div class="spec-value"><?php echo esc_html($product->get_attribute('purity')); ?></div></div></div>
        <?php endif; ?>
        <?php if($product&&$product->get_attribute('form')): ?>
        <div class="spec-item"><i data-lucide="snowflake" width="18" height="18"></i><div><div class="spec-label">Form</div><div class="spec-value"><?php echo esc_html($product->get_attribute('form')); ?></div></div></div>
        <?php endif; ?>
      </div>

      <div class="purchase-row">
        <div class="qty-stepper">
          <button class="qty-btn" onclick="changeQty(-1)"><i data-lucide="minus" width="14" height="14"></i></button>
          <input class="qty-input" id="qty" type="number" value="1" min="1" max="99">
          <button class="qty-btn" onclick="changeQty(1)"><i data-lucide="plus" width="14" height="14"></i></button>
        </div>
        <?php if($stock_status==='instock'): ?>
          <a href="<?php echo esc_url($add_to_cart_url); ?>" class="btn-add-cart"><i data-lucide="shopping-cart" width="18" height="18"></i> Add to Cart</a>
        <?php else: ?>
          <button class="btn-add-cart" disabled style="opacity:.5;cursor:not-allowed;background:var(--pearl-dark);color:var(--text-mid)">Out of Stock</button>
        <?php endif; ?>
        <button class="btn-wishlist" id="wishBtn" onclick="toggleWish()"><i data-lucide="heart" width="20" height="20"></i></button>
      </div>
      <a href="<?php echo esc_url(alluvia_checkout_url()); ?>" class="buy-now">Buy Now — Express Checkout</a>

      <div class="assurance">
        <div class="assurance-item"><i data-lucide="award" width="16" height="16"></i> Third-party HPLC tested — COA included with every order</div>
        <div class="assurance-item"><i data-lucide="thermometer-snowflake" width="16" height="16"></i> Cold-chain shipping available to preserve bioactivity</div>
        <div class="assurance-item"><i data-lucide="truck" width="16" height="16"></i> Same-day dispatch on orders before 1 PM EST</div>
        <div class="assurance-item"><i data-lucide="shield-check" width="16" height="16"></i> Discreet packaging · Integrity guarantee</div>
      </div>
    </div>
  </div>
</div>

<!-- TABS -->
<div class="product-tabs">
  <div class="tab-nav">
    <button class="tab-btn active" onclick="showTab('desc',this)">Description</button>
    <button class="tab-btn" onclick="showTab('research',this)">Research</button>
    <button class="tab-btn" onclick="showTab('specs',this)">Specifications</button>
    <button class="tab-btn" onclick="showTab('coa',this)">COA</button>
    <button class="tab-btn" onclick="showTab('reviews',this)">Reviews (214)</button>
  </div>

  <div class="tab-pane active" id="tab-desc">
    <div class="tab-content-card">
      <h3>About <?php echo esc_html(get_the_title()); ?></h3>
      <?php if($long_desc): echo apply_filters('the_content',$long_desc);
      elseif($short_desc): echo '<p>'.wp_kses_post($short_desc).'</p>';
      else: echo '<p style="color:var(--text-light)">No description available.</p>';
      endif; ?>
    </div>
  </div>

  <div class="tab-pane" id="tab-research">
    <div class="tab-content-card">
      <h3>Research Background</h3>
      <p>BPC-157 has been the subject of numerous peer-reviewed studies, predominantly in rodent models. Its proposed mechanism of action centers on the upregulation of growth factors and the promotion of angiogenesis via the VEGFR2-Akt-eNOS signaling pathway.</p>
      <h4>Mechanism of Action (Proposed)</h4>
      <p>Studies suggest BPC-157 interacts with the nitric oxide (NO) system, modulates dopaminergic and serotonergic systems, and upregulates expression of growth hormone receptors in fibroblasts — a pathway that may explain its observed effects on tendon fibroblast proliferation.</p>
      <h4>Storage & Reconstitution</h4>
      <ul class="research-list">
        <li><i data-lucide="snowflake" width="16" height="16"></i>Store lyophilized vial at −20°C; stable for 24+ months</li>
        <li><i data-lucide="droplet" width="16" height="16"></i>Reconstitute with bacteriostatic water for research handling</li>
        <li><i data-lucide="refrigerator" width="16" height="16"></i>Once reconstituted, store at 2–8°C and use within 30 days</li>
        <li><i data-lucide="sun-dim" width="16" height="16"></i>Protect from light and repeated freeze-thaw cycles</li>
      </ul>
      <div style="background:rgba(198,162,83,0.07);border:1px solid rgba(198,162,83,0.25);border-radius:8px;padding:1rem 1.25rem;font-size:0.85rem;color:var(--text-mid);margin-top:1rem">
        <strong>For research use only.</strong> This product is not intended for human or veterinary use. See our <a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>" style="color:var(--teal-dark)">Terms & Conditions</a> for full disclaimer.
      </div>
    </div>
  </div>

  <div class="tab-pane" id="tab-specs">
    <div class="tab-content-card">
      <h3>Technical Specifications</h3>
      <table class="specs-table">
        <tr><td>Product Name</td><td>BPC-157 (Body Protection Compound-157)</td></tr>
        <tr><td>CAS Number</td><td>137525-51-0</td></tr>
        <tr><td>Molecular Formula</td><td>C₆₂H₉₈N₁₆O₂₂</td></tr>
        <tr><td>Molecular Weight</td><td>1419.53 g/mol</td></tr>
        <tr><td>Sequence</td><td>Gly-Glu-Pro-Pro-Pro-Gly-Lys-Pro-Ala-Asp-Asp-Ala-Gly-Leu-Val</td></tr>
        <tr><td>Purity</td><td>≥99% by HPLC</td></tr>
        <tr><td>Form</td><td>Lyophilized white powder</td></tr>
        <tr><td>Quantity</td><td>5 mg per vial</td></tr>
        <tr><td>Storage</td><td>−20°C, protect from light</td></tr>
        <tr><td>Solubility</td><td>Soluble in water, bacteriostatic water</td></tr>
      </table>
    </div>
  </div>

  <div class="tab-pane" id="tab-coa">
    <div class="tab-content-card">
      <h3>Certificate of Analysis</h3>
      <p>Every batch of BPC-157 is independently tested by third-party laboratories for identity, purity, and mass confirmation. The COA for your specific lot number is included in your order confirmation email and available in our COA library.</p>
      <div class="coa-block">
        <div class="coa-info">
          <div class="coa-icon"><i data-lucide="file-check" width="24" height="24"></i></div>
          <div>
            <div class="coa-title">Lot #BPC157-2504-A · HPLC + MS Verified</div>
            <div class="coa-sub">Purity: 99.2% · Tested: April 2025 · Janoshik Analytical</div>
          </div>
        </div>
        <a href="<?php echo esc_url(home_url('/coa-library/')); ?>" class="btn-coa"><i data-lucide="download" width="15" height="15"></i> View COA Library</a>
      </div>
      <ul class="research-list" style="margin-top:1.5rem">
        <li><i data-lucide="check-circle" width="16" height="16"></i>HPLC purity analysis (≥99%)</li>
        <li><i data-lucide="check-circle" width="16" height="16"></i>Mass spectrometry identity confirmation</li>
        <li><i data-lucide="check-circle" width="16" height="16"></i>Endotoxin and sterility screening</li>
        <li><i data-lucide="check-circle" width="16" height="16"></i>Independent third-party verification</li>
      </ul>
    </div>
  </div>

  <div class="tab-pane" id="tab-reviews">
    <div class="tab-content-card" id="reviews">
      <h3>Customer Reviews</h3>
      <div class="review-summary">
        <div class="review-score">
          <div class="big">4.9</div>
          <span class="stars" style="justify-content:center">
            <i data-lucide="star" width="14" height="14" fill="currentColor"></i>
            <i data-lucide="star" width="14" height="14" fill="currentColor"></i>
            <i data-lucide="star" width="14" height="14" fill="currentColor"></i>
            <i data-lucide="star" width="14" height="14" fill="currentColor"></i>
            <i data-lucide="star" width="14" height="14" fill="currentColor"></i>
          </span>
          <div style="font-size:0.78rem;color:var(--text-light);margin-top:0.4rem">214 reviews</div>
        </div>
        <div class="review-bars">
          <div class="review-bar-row"><span class="lbl">5 star</span><div class="review-bar-track"><div class="review-bar-fill" style="width:92%"></div></div><span>92%</span></div>
          <div class="review-bar-row"><span class="lbl">4 star</span><div class="review-bar-track"><div class="review-bar-fill" style="width:6%"></div></div><span>6%</span></div>
          <div class="review-bar-row"><span class="lbl">3 star</span><div class="review-bar-track"><div class="review-bar-fill" style="width:1%"></div></div><span>1%</span></div>
          <div class="review-bar-row"><span class="lbl">2 star</span><div class="review-bar-track"><div class="review-bar-fill" style="width:1%"></div></div><span>1%</span></div>
          <div class="review-bar-row"><span class="lbl">1 star</span><div class="review-bar-track"><div class="review-bar-fill" style="width:0%"></div></div><span>0%</span></div>
        </div>
      </div>

      <div class="review-card">
        <div class="review-head">
          <div class="reviewer">
            <div class="reviewer-avatar">DM</div>
            <div>
              <div class="reviewer-name">Dr. Michael R.</div>
              <div class="reviewer-meta"><span class="verified-tag"><i data-lucide="badge-check" width="12" height="12"></i> Verified Buyer</span> · May 2025</div>
            </div>
          </div>
          <span class="stars"><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i></span>
        </div>
        <p class="review-body">Consistent purity across multiple orders. The COA matched my own independent HPLC verification within margin. Cold-chain packaging arrived perfectly intact with the temperature card still in range. This is now my standard supplier for tissue-repair research.</p>
      </div>
      <div class="review-card">
        <div class="review-head">
          <div class="reviewer">
            <div class="reviewer-avatar">SK</div>
            <div>
              <div class="reviewer-name">Sarah K.</div>
              <div class="reviewer-meta"><span class="verified-tag"><i data-lucide="badge-check" width="12" height="12"></i> Verified Buyer</span> · April 2025</div>
            </div>
          </div>
          <span class="stars"><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i></span>
        </div>
        <p class="review-body">Fast dispatch and excellent reconstitution clarity — no cloudiness, fully soluble. The lyophilized cake was intact and properly sealed under nitrogen. Documentation was thorough. Highly recommend for any serious lab.</p>
      </div>
      <div class="review-card">
        <div class="review-head">
          <div class="reviewer">
            <div class="reviewer-avatar">JT</div>
            <div>
              <div class="reviewer-name">James T.</div>
              <div class="reviewer-meta"><span class="verified-tag"><i data-lucide="badge-check" width="12" height="12"></i> Verified Buyer</span> · March 2025</div>
            </div>
          </div>
          <span class="stars"><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14" fill="currentColor"></i><i data-lucide="star" width="14" height="14"></i></span>
        </div>
        <p class="review-body">Reliable quality and the loyalty points are a nice touch. Took one star off only because express shipping was a day later than estimated, but the product itself is top-tier. Will order again.</p>
      </div>
    </div>
  </div>
</div>

<!-- RELATED -->
<div class="related">
  <h2>Frequently Bought Together</h2>
  <div class="related-grid">
    <?php if(!empty($related_ids)): foreach(array_slice($related_ids,0,4) as $rel_id):
      $rel=wc_get_product($rel_id); if(!$rel) continue;
      $rel_thumb=get_the_post_thumbnail_url($rel_id,'woocommerce_thumbnail');
      $rel_cats=wp_get_post_terms($rel_id,'product_cat',['number'=>1]);
      $rel_cat=(!is_wp_error($rel_cats)&&!empty($rel_cats))?$rel_cats[0]->name:'';
    ?>
      <a href="<?php echo esc_url(get_permalink($rel_id)); ?>" class="rel-card">
        <div class="rel-thumb" style="background:linear-gradient(135deg,rgba(14,175,159,.12),rgba(14,175,159,.04))">
          <?php if($rel_thumb): ?><img src="<?php echo esc_url($rel_thumb); ?>" alt="<?php echo esc_attr($rel->get_name()); ?>" style="width:100%;height:100%;object-fit:cover"><?php else: ?><i data-lucide="flask-conical" width="36" height="36" style="color:var(--teal)"></i><?php endif; ?>
        </div>
        <div class="rel-body">
          <?php if($rel_cat): ?><div class="rel-cat"><?php echo esc_html($rel_cat); ?></div><?php endif; ?>
          <div class="rel-name"><?php echo esc_html($rel->get_name()); ?></div>
          <div class="rel-price"><?php echo $rel->get_price_html(); ?></div>
        </div>
      </a>
    <?php endforeach; endif; ?>
  </div>
</div>

<?php get_template_part('partials/footer-alluvia'); ?>

<script>
lucide.createIcons();
function changeQty(d){const i=document.getElementById('qty');i.value=Math.max(1,(parseInt(i.value)||1)+d);}
function showTab(id,btn){document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));document.getElementById('tab-'+id).classList.add('active');btn.classList.add('active');}
function toggleWish(){document.getElementById('wishBtn').classList.toggle('active');}
document.querySelectorAll('.gallery-thumb').forEach(t=>t.addEventListener('click',function(){document.querySelectorAll('.gallery-thumb').forEach(x=>x.classList.remove('active'));this.classList.add('active');}));
function showToast(msg){const t=document.createElement('div');t.textContent=msg;Object.assign(t.style,{position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',background:'#0eaf9f',color:'#0a1a27',padding:'0.75rem 1.5rem',borderRadius:'50px',fontFamily:"'Space Grotesk',sans-serif",fontSize:'0.85rem',fontWeight:'600',zIndex:'9999',boxShadow:'0 8px 24px rgba(0,0,0,0.2)',transition:'opacity 0.3s'});document.body.appendChild(t);setTimeout(()=>{t.style.opacity='0';setTimeout(()=>t.remove(),300);},2200);}
</script>
<?php get_footer( 'alluvia' ); ?>
