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
.product-wrap{max-width:1200px;margin:0 auto;padding:5.5rem 1.5rem 2rem}
.breadcrumb{display:flex;align-items:center;gap:0.5rem;font-family:var(--font-ui);font-size:var(--fs-ui);color:var(--text-mid);margin-bottom:1.5rem}
.breadcrumb a{color:var(--teal-dark);text-decoration:none}

/* PRODUCT MAIN */
.product-main{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start}

/* GALLERY */
.gallery{}
.gallery-main{background:#fff;border-radius:var(--radius);height:460px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 24px rgba(0,0,0,0.06);position:relative;overflow:hidden;border:1px solid var(--pearl-dark);padding:32px;box-sizing:border-box}
.gallery-main::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 50% 40%,rgba(14,175,159,0.08),transparent 70%)}
.gallery-main .vial-icon{position:relative;z-index:1}
.gallery-img{position:relative;z-index:1;max-width:100%;max-height:100%;width:auto;height:auto;object-fit:contain;display:block}
.gallery-badge{position:absolute;top:1rem;left:1rem;background:var(--teal);color:var(--navy);font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:0.06em;padding:4px 12px;border-radius:50px;text-transform:uppercase;z-index:2}
.gallery-thumbs{display:flex;gap:0.75rem;margin-top:1rem}
.gallery-thumb{flex:1;background:#fff;border-radius:8px;height:80px;display:flex;align-items:center;justify-content:center;cursor:pointer;border:2px solid transparent;transition:all .2s}
.gallery-thumb.active{border-color:var(--teal)}
.gallery-thumb:hover{border-color:rgba(14,175,159,0.4)}

/* PRODUCT INFO */
.product-info{}
.prod-cat{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--teal-dark);margin-bottom:0.5rem}
.product-info h1{font-family:var(--font-display);font-size:clamp(26px,3.5vw,40px);font-weight:600;line-height:1.1;margin-bottom:0.5rem}
.prod-subtitle{font-size:var(--fs-body);color:var(--text-mid);margin-bottom:1rem;line-height:1.8}
.prod-rating{display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem}
.stars{display:flex;gap:2px;color:var(--gold)}
.rating-text{font-family:var(--font-ui);font-size:13px;color:var(--text-mid)}
.rating-text a{color:var(--teal-dark);text-decoration:none}
.prod-price-row{display:flex;align-items:baseline;gap:0.75rem;margin-bottom:1.5rem}
.prod-price{font-family:var(--font-ui);font-size:28px;font-weight:700;color:var(--navy)}
.prod-price-old{font-family:var(--font-ui);font-size:18px;color:var(--text-light);text-decoration:line-through}
.prod-save{background:rgba(219,98,122,0.12);color:#c0405a;font-family:var(--font-ui);font-size:12px;font-weight:700;padding:3px 10px;border-radius:50px}

/* SPEC GRID */
.spec-grid{display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1.5rem;padding:1.25rem;background:#fff;border-radius:var(--radius);border:1px solid var(--pearl-dark)}
.spec-item{display:flex;align-items:center;gap:0.6rem}
.spec-item svg{color:var(--teal);flex-shrink:0}
.spec-label{font-size:var(--fs-micro);color:var(--text-light);font-family:var(--font-ui);text-transform:uppercase;letter-spacing:0.04em}
.spec-value{font-family:var(--font-ui);font-weight:600;font-size:var(--fs-base)}

/* PURCHASE */
.purchase-row{display:flex;gap:1rem;align-items:stretch;margin-bottom:1rem}
.qty-stepper{display:flex;align-items:center;border:1px solid var(--pearl-dark);border-radius:10px;overflow:hidden;background:#fff}
.qty-btn{background:#fff;border:none;width:44px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-mid);transition:all .2s}
.qty-btn:hover{background:var(--teal);color:#fff}
.qty-input{width:50px;border:none;border-left:1px solid var(--pearl-dark);border-right:1px solid var(--pearl-dark);text-align:center;font-family:var(--font-ui);font-weight:600;font-size:16px;outline:none}
.btn-add-cart{flex:1;background:linear-gradient(135deg,var(--teal),var(--teal-dark));color:var(--navy);border:none;border-radius:10px;padding:14px 20px;font-family:var(--font-ui);font-size:15px;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:all .3s;text-decoration:none;min-height:52px}
.btn-add-cart:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(14,175,159,0.35);color:var(--navy)}
.btn-wishlist{width:52px;background:#fff;border:1px solid var(--pearl-dark);border-radius:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-mid);transition:all .2s}
.btn-wishlist:hover{border-color:var(--coral);color:var(--coral)}
.btn-wishlist.active{background:rgba(219,98,122,0.08);border-color:var(--coral);color:var(--coral)}
.buy-now{display:block;width:100%;text-align:center;background:var(--navy);color:#fff;border:none;border-radius:10px;padding:0.85rem;font-family:var(--font-ui);font-size:15px;font-weight:600;letter-spacing:0.04em;cursor:pointer;text-decoration:none;transition:all .2s;margin-bottom:1.25rem}
.buy-now:hover{background:var(--teal-dark)}

/* ASSURANCE */
.assurance{display:flex;flex-direction:column;gap:0.6rem;padding:1.25rem;background:rgba(14,175,159,0.04);border:1px solid rgba(14,175,159,0.15);border-radius:var(--radius)}
.assurance-item{display:flex;align-items:center;gap:0.6rem;font-size:var(--fs-base);color:var(--text-mid)}
.assurance-item svg{color:var(--teal);flex-shrink:0}

/* TABS */
.product-tabs{max-width:1200px;margin:3.5rem auto 0;padding:0 2rem}
.tab-nav{display:flex;gap:0.5rem;border-bottom:2px solid var(--pearl-dark);margin-bottom:2rem;overflow-x:auto}
.tab-btn{background:none;border:none;padding:1rem 1.5rem;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:600;color:var(--text-light);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;transition:all .2s}
.tab-btn:hover{color:var(--teal-dark)}
.tab-btn.active{color:var(--navy);border-bottom-color:var(--teal)}
.tab-pane{display:none;animation:fade .3s}
.tab-pane.active{display:block}
@keyframes fade{from{opacity:0}to{opacity:1}}
.tab-content-card{background:#fff;border-radius:var(--radius);padding:2.25rem;box-shadow:0 2px 12px rgba(0,0,0,0.05)}
.tab-content-card h3{font-family:var(--font-display);font-size:24px;font-weight:600;margin-bottom:1rem}
.tab-content-card h4{font-family:var(--font-ui);font-size:15px;font-weight:700;margin:1.5rem 0 0.5rem}
.tab-content-card p{font-size:var(--fs-body);color:var(--text-mid);line-height:1.8;margin-bottom:1rem}
.research-list{list-style:none;display:flex;flex-direction:column;gap:0.6rem;margin-bottom:1rem}
.research-list li{display:flex;align-items:flex-start;gap:0.6rem;font-size:var(--fs-body);color:var(--text-mid)}
.research-list li svg{color:var(--teal);flex-shrink:0;margin-top:3px}

/* SPECS TABLE */
.specs-table{width:100%;border-collapse:collapse;font-size:var(--fs-body)}
.specs-table td{padding:0.85rem 1rem;border-bottom:1px solid var(--pearl)}
.specs-table tr:last-child td{border-bottom:none}
.specs-table td:first-child{font-family:var(--font-ui);font-weight:600;color:var(--text-dark);width:40%}
.specs-table td:last-child{color:var(--text-mid)}

/* COA BLOCK */
.coa-block{display:flex;align-items:center;justify-content:space-between;background:rgba(14,175,159,0.05);border:1px solid rgba(14,175,159,0.2);border-radius:10px;padding:1.25rem 1.5rem;flex-wrap:wrap;gap:1rem}
.coa-info{display:flex;align-items:center;gap:1rem}
.coa-icon{width:48px;height:48px;border-radius:10px;background:rgba(14,175,159,0.12);display:flex;align-items:center;justify-content:center;color:var(--teal)}
.coa-title{font-family:var(--font-ui);font-weight:700;font-size:15px}
.coa-sub{font-size:13px;color:var(--text-light)}
.btn-coa{background:var(--navy);color:#fff;border:none;border-radius:8px;padding:0.65rem 1.5rem;font-family:var(--font-ui);font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.4rem;text-decoration:none}
.btn-coa:hover{background:var(--teal-dark)}

/* REVIEWS */
.review-summary{display:flex;gap:2.5rem;align-items:center;margin-bottom:2rem;flex-wrap:wrap}
.review-score{text-align:center}
.review-score .big{font-family:var(--font-display);font-size:56px;font-weight:700;line-height:1}
.review-bars{flex:1;min-width:240px}
.review-bar-row{display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;font-size:13px}
.review-bar-row .lbl{font-family:var(--font-ui);color:var(--text-mid);width:40px}
.review-bar-track{flex:1;height:8px;background:var(--pearl);border-radius:8px;overflow:hidden}
.review-bar-fill{height:100%;background:var(--gold);border-radius:8px}
.review-card{border-bottom:1px solid var(--pearl);padding:1.25rem 0}
.review-card:last-child{border-bottom:none}
.review-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem}
.reviewer{display:flex;align-items:center;gap:0.75rem}
.reviewer-avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-dark));display:flex;align-items:center;justify-content:center;font-family:var(--font-ui);font-weight:700;color:var(--navy);font-size:14px}
.reviewer-name{font-family:var(--font-ui);font-weight:600;font-size:14px}
.reviewer-meta{font-size:12px;color:var(--text-light);display:flex;align-items:center;gap:0.3rem}
.verified-tag{color:var(--mint);display:inline-flex;align-items:center;gap:0.2rem;font-weight:600}
.review-body{font-size:var(--fs-body);color:var(--text-mid);line-height:1.8}

/* RELATED */
.related{max-width:1200px;margin:4rem auto;padding:0 2rem}
.related h2{font-family:var(--font-display);font-size:29px;font-weight:600;margin-bottom:1.5rem}
.related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem}
.rel-card{background:#fff;border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.06);transition:all .3s;cursor:pointer;text-decoration:none;color:inherit;display:block}
.rel-card:hover{transform:translateY(-4px);box-shadow:0 8px 28px rgba(0,0,0,0.12)}
.rel-thumb{height:110px;display:flex;align-items:center;justify-content:center}
.rel-body{padding:1rem}
.rel-cat{font-family:var(--font-ui);font-size:10px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-light)}
.rel-name{font-family:var(--font-ui);font-weight:600;font-size:var(--fs-base);margin:0.25rem 0}
.rel-price{font-family:var(--font-ui);font-weight:700;font-size:16px;color:var(--teal-dark)}

@media(max-width:1024px){.product-main{gap:2rem}}
@media(max-width:900px){.product-main{grid-template-columns:1fr;gap:2rem}.related-grid{grid-template-columns:repeat(2,1fr)}.product-tabs{padding:0 1rem}.related{padding:0 1rem}}
@media(max-width:640px){.product-wrap{padding:4.5rem 1rem 2rem}.spec-grid{grid-template-columns:1fr}.related-grid{grid-template-columns:1fr 1fr}.gallery-main{height:320px}.purchase-row{flex-wrap:wrap}.btn-add-cart{flex:1;min-width:200px}.tab-btn{padding:.75rem 1rem;font-size:13px}}
@media(max-width:420px){.related-grid{grid-template-columns:1fr}.product-tabs .tab-nav{gap:0}}</style>
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
          <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="gallery-img">
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
      <?php if ($review_count > 0) : ?>
      <div class="prod-rating">
        <span class="stars">
          <?php for ($s=1;$s<=5;$s++): ?><svg width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $s<=round($avg_rating)?'currentColor':'none'; ?>" stroke="currentColor" stroke-width="1.5"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg><?php endfor; ?>
        </span>
        <span class="rating-text"><?php echo esc_html(number_format($avg_rating,1)); ?> · <a href="#reviews"><?php echo esc_html($review_count . ' ' . _n('verified review', 'verified reviews', $review_count, 'shopping')); ?></a></span>
      </div>
      <?php else : ?>
      <div class="prod-rating">
        <span class="rating-text" style="color:var(--text-light)">No reviews yet</span>
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
    <button class="tab-btn" onclick="showTab('reviews',this)">Reviews<?php if ($review_count > 0) { echo ' (' . (int) $review_count . ')'; } ?></button>
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
      <?php
$research_content = get_post_meta(get_the_ID(), '_research_notes', true);
if ($research_content) {
    echo wp_kses_post(wpautop($research_content));
} else {
    echo '<p style="color:var(--text-light)">Research notes not available for this product.</p>';
}
?>
    </div>
  </div>

  <div class="tab-pane" id="tab-specs">
    <div class="tab-content-card">
      <?php
$attributes = $product ? $product->get_attributes() : [];
$spec_meta = [
    'cas_number'         => get_post_meta(get_the_ID(), '_cas_number', true),
    'molecular_formula'  => get_post_meta(get_the_ID(), '_molecular_formula', true),
    'molecular_weight'   => get_post_meta(get_the_ID(), '_molecular_weight', true),
    'sequence'           => get_post_meta(get_the_ID(), '_amino_acid_sequence', true),
    'purity'             => $product ? $product->get_attribute('purity') : '',
    'form'               => $product ? $product->get_attribute('form') : '',
    'storage'            => $product ? $product->get_attribute('storage') : '',
];
$spec_meta = array_filter($spec_meta);

$label_map = [
    'cas_number'        => 'CAS Number',
    'molecular_formula' => 'Molecular Formula',
    'molecular_weight'  => 'Molecular Weight',
    'sequence'          => 'Amino Acid Sequence',
    'purity'            => 'Purity',
    'form'              => 'Form',
    'storage'           => 'Storage',
];

if (!empty($spec_meta)) : ?>
  <dl class="spec-dl" style="display:grid;grid-template-columns:auto 1fr;gap:8px 24px">
    <?php foreach ($spec_meta as $key => $val) : ?>
      <dt style="font-weight:600;color:var(--text-mid);white-space:nowrap"><?php echo esc_html($label_map[$key] ?? $key); ?></dt>
      <dd style="margin:0;color:var(--text-dark)"><?php echo esc_html($val); ?></dd>
    <?php endforeach; ?>
  </dl>
<?php else : ?>
  <p style="color:var(--text-light)">Technical specifications not available for this product.</p>
<?php endif; ?>
    </div>
  </div>

  <div class="tab-pane" id="tab-coa">
    <div class="tab-content-card">
      <?php
$coa_url = get_post_meta(get_the_ID(), '_coa_pdf_url', true);
$lot_number = get_post_meta(get_the_ID(), '_lot_number', true);
$test_date  = get_post_meta(get_the_ID(), '_coa_test_date', true);
$test_lab   = get_post_meta(get_the_ID(), '_coa_lab', true);

if ($coa_url || $lot_number) : ?>
  <?php if ($lot_number) : ?>
    <p><strong>Lot Number:</strong> <?php echo esc_html($lot_number); ?></p>
  <?php endif; ?>
  <?php if ($test_date) : ?>
    <p><strong>Test Date:</strong> <?php echo esc_html($test_date); ?></p>
  <?php endif; ?>
  <?php if ($test_lab) : ?>
    <p><strong>Testing Laboratory:</strong> <?php echo esc_html($test_lab); ?></p>
  <?php endif; ?>
  <?php if ($coa_url) : ?>
    <a href="<?php echo esc_url($coa_url); ?>" target="_blank" rel="noopener" class="btn-add-cart" style="display:inline-flex;gap:8px;align-items:center;margin-top:16px">
      <i data-lucide="file-text" width="18" height="18"></i> Download COA (PDF)
    </a>
  <?php endif; ?>
<?php else : ?>
  <p style="color:var(--text-light)">Certificate of Analysis not yet available for this product. Contact us for lab documentation.</p>
<?php endif; ?>
    </div>
  </div>

  <div class="tab-pane" id="tab-reviews">
    <div class="tab-content-card" id="reviews">
      <h3>Customer Reviews</h3>
      <?php
      // Real approved reviews for this product (WooCommerce stores reviews as comments of type "review").
      $reviews = get_comments(array(
        'post_id' => get_the_ID(),
        'type'    => 'review',
        'status'  => 'approve',
      ));
      if ($review_count > 0) :
      ?>
      <div class="review-summary">
        <div class="review-score">
          <div class="big"><?php echo esc_html(number_format($avg_rating, 1)); ?></div>
          <span class="stars" style="justify-content:center">
            <?php for ($s = 1; $s <= 5; $s++) : ?>
            <i data-lucide="star" width="14" height="14"<?php echo $s <= round($avg_rating) ? ' fill="currentColor"' : ''; ?>></i>
            <?php endfor; ?>
          </span>
          <div style="font-size:0.78rem;color:var(--text-light);margin-top:0.4rem"><?php echo esc_html($review_count . ' ' . _n('review', 'reviews', $review_count, 'shopping')); ?></div>
        </div>
      </div>
      <?php endif; ?>

      <?php if (!empty($reviews)) : ?>
        <?php foreach ($reviews as $c) :
          $r_name   = trim($c->comment_author);
          if ($r_name === '') { $r_name = __('Anonymous', 'shopping'); }
          $r_rating = (int) get_comment_meta($c->comment_ID, 'rating', true);
          $r_date   = mysql2date(get_option('date_format'), $c->comment_date);
          $initials = '';
          foreach (preg_split('/\s+/', $r_name) as $word) {
            if ($word !== '' && strlen($initials) < 2) { $initials .= strtoupper(substr($word, 0, 1)); }
          }
          if ($initials === '') { $initials = '?'; }
        ?>
        <div class="review-card">
          <div class="review-head">
            <div class="reviewer">
              <div class="reviewer-avatar"><?php echo esc_html($initials); ?></div>
              <div>
                <div class="reviewer-name"><?php echo esc_html($r_name); ?></div>
                <div class="reviewer-meta"><?php echo esc_html($r_date); ?></div>
              </div>
            </div>
            <?php if ($r_rating > 0) : ?>
            <span class="stars"><?php for ($s = 1; $s <= 5; $s++) : ?><i data-lucide="star" width="14" height="14"<?php echo $s <= $r_rating ? ' fill="currentColor"' : ''; ?>></i><?php endfor; ?></span>
            <?php endif; ?>
          </div>
          <p class="review-body"><?php echo wp_kses_post($c->comment_content); ?></p>
        </div>
        <?php endforeach; ?>
      <?php else : ?>
        <p style="color:var(--text-light)">No reviews yet — be the first to review this product.</p>
      <?php endif; ?>
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
function showToast(msg){const t=document.createElement('div');t.textContent=msg;Object.assign(t.style,{position:'fixed',bottom:'2rem',left:'50%',transform:'translateX(-50%)',background:'#0eaf9f',color:'#0a1a27',padding:'0.75rem 1.5rem',borderRadius:'50px',fontFamily:"var(--font-ui)",fontSize:'0.85rem',fontWeight:'600',zIndex:'9999',boxShadow:'0 8px 24px rgba(0,0,0,0.2)',transition:'opacity 0.3s'});document.body.appendChild(t);setTimeout(()=>{t.style.opacity='0';setTimeout(()=>t.remove(),300);},2200);}
</script>
<?php get_footer( 'alluvia' ); ?>
