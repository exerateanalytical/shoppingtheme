<?php
/**
 * Template Name: Alluvia – Shop
 *
 * @package Shopping
 */

// ── Query parameters ─────────────────────────────────────────────────────────
$current_cat_slug = isset( $_GET['product_cat'] ) ? sanitize_text_field( $_GET['product_cat'] ) : '';
$current_orderby  = isset( $_GET['orderby'] )     ? sanitize_text_field( $_GET['orderby'] )     : 'popularity';
$min_price        = isset( $_GET['min_price'] )   ? floatval( $_GET['min_price'] )               : '';
$max_price        = isset( $_GET['max_price'] )   ? floatval( $_GET['max_price'] )               : '';
$paged            = max( 1, absint( get_query_var( 'paged' ) ) );

// ── Fetch categories ─────────────────────────────────────────────────────────
$uncategorized_id = absint( get_option( 'default_product_cat' ) );
$shop_cats = get_terms( [
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
    'exclude'    => $uncategorized_id ? [ $uncategorized_id ] : [],
] );
if ( is_wp_error( $shop_cats ) ) {
    $shop_cats = [];
}

// ── WP_Query args ─────────────────────────────────────────────────────────────
$query_args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged,
];

if ( $current_cat_slug ) {
    $query_args['tax_query'] = [ [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => $current_cat_slug,
    ] ];
}

switch ( $current_orderby ) {
    case 'price':
        $query_args['meta_key'] = '_price';
        $query_args['orderby']  = 'meta_value_num';
        $query_args['order']    = 'ASC';
        break;
    case 'price-desc':
        $query_args['meta_key'] = '_price';
        $query_args['orderby']  = 'meta_value_num';
        $query_args['order']    = 'DESC';
        break;
    case 'date':
        $query_args['orderby'] = 'date';
        $query_args['order']   = 'DESC';
        break;
    case 'rating':
        $query_args['meta_key'] = '_wc_average_rating';
        $query_args['orderby']  = 'meta_value_num';
        $query_args['order']    = 'DESC';
        break;
    default: // popularity
        $query_args['meta_key'] = 'total_sales';
        $query_args['orderby']  = 'meta_value_num';
        $query_args['order']    = 'DESC';
        break;
}

if ( $min_price !== '' || $max_price !== '' ) {
    $price_meta = [ 'key' => '_price', 'type' => 'NUMERIC' ];
    if ( $min_price !== '' && $max_price !== '' ) {
        $price_meta['compare'] = 'BETWEEN';
        $price_meta['value']   = [ $min_price, $max_price ];
    } elseif ( $min_price !== '' ) {
        $price_meta['compare'] = '>=';
        $price_meta['value']   = $min_price;
    } else {
        $price_meta['compare'] = '<=';
        $price_meta['value']   = $max_price;
    }
    $query_args['meta_query'][] = $price_meta;
}

$shop_query     = new WP_Query( $query_args );
$total_products = $shop_query->found_posts;
$showing        = $shop_query->post_count;

// ── Category icon map ─────────────────────────────────────────────────────────
$cat_icons = [
    'medical-peptides'         => 'heart-pulse',
    'skincare-peptides'        => 'sparkles',
    'collagen-peptides'        => 'bone',
    'sports-recovery'          => 'zap',
    'weight-loss-metabolic'    => 'flame',
    'hormone-anti-aging'       => 'timer',
    'hair-growth-peptides'     => 'sprout',
    'research-peptides'        => 'test-tube-2',
    'lab-supplies-accessories' => 'flask-conical',
];

// ── Shop page URL helper ──────────────────────────────────────────────────────
$shop_base = function_exists( 'alluvia_shop_url' ) ? alluvia_shop_url() : get_permalink();

add_action( 'wp_head', function() {
?>
<style>
/* PAGE HERO */
.shop-hero{background:var(--navy);padding:120px 0 60px;position:relative;overflow:hidden}
.shop-hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 60% 80% at 80% 50%,rgba(14,175,159,.07) 0%,transparent 60%)}
.shop-hero-inner{max-width:1340px;margin:0 auto;padding:0 40px;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:24px;position:relative;z-index:2}
.breadcrumb{display:flex;align-items:center;gap:6px;font-family:var(--font-ui);font-size:var(--fs-ui);letter-spacing:.08em;color:rgba(255,255,255,.65);text-transform:uppercase;margin-bottom:16px}
.breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none;transition:color .2s}.breadcrumb a:hover{color:var(--teal)}
.shop-hero h1{font-family:var(--font-display);font-size:clamp(36px,5vw,64px);font-weight:300;color:var(--white);line-height:1.05;margin-bottom:12px}
.shop-hero h1 em{font-style:italic;color:var(--teal)}
.shop-hero-desc{font-size:var(--fs-body);color:rgba(255,255,255,.65);font-weight:300;max-width:480px;line-height:1.7}
.hero-cats{display:flex;flex-wrap:wrap;gap:8px;margin-top:20px}
.hero-cat-pill{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:100px;border:1px solid rgba(255,255,255,.1);font-family:var(--font-ui);font-size:11px;font-weight:600;color:rgba(255,255,255,.5);cursor:pointer;transition:var(--transition);text-decoration:none}
.hero-cat-pill:hover,.hero-cat-pill.active{border-color:var(--teal);color:var(--teal);background:rgba(14,175,159,.08)}
/* MAIN LAYOUT */
.shop-main{max-width:1340px;margin:0 auto;padding:48px 40px 100px;display:grid;grid-template-columns:260px 1fr;gap:40px}
/* SIDEBAR */
.shop-sidebar{display:flex;flex-direction:column;gap:24px;position:sticky;top:80px;align-self:start}
.sidebar-block{background:var(--white);border-radius:var(--radius-md);padding:24px;border:1px solid var(--pearl-dark)}
.sidebar-block-title{font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--navy);margin-bottom:16px;display:flex;align-items:center;gap:8px}
.sidebar-block-title svg{color:var(--teal)}
.search-wrap{display:flex;align-items:center;gap:10px;background:var(--pearl);border:1.5px solid var(--pearl-dark);border-radius:var(--radius-sm);padding:10px 14px;transition:border-color .2s}
.search-wrap:focus-within{border-color:var(--teal)}
.search-wrap svg{color:var(--text-light);flex-shrink:0}
.search-wrap input{background:none;border:none;outline:none;font-family:var(--font-body);font-size:14px;color:var(--text-dark);width:100%}
.search-wrap input::placeholder{color:var(--text-light)}
.cat-filter-list{display:flex;flex-direction:column;gap:2px}
.cat-filter-item{display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border-radius:var(--radius-sm);transition:background .2s;text-decoration:none;color:inherit}
.cat-filter-item:hover{background:var(--pearl)}
.cat-filter-item.active{background:rgba(14,175,159,.08);color:var(--teal)}
.cat-filter-left{display:flex;align-items:center;gap:10px;font-size:var(--fs-ui);font-weight:500;color:inherit}
.cat-filter-left svg{width:16px;height:16px}
.cat-filter-item.active .cat-filter-left{color:var(--teal)}
.cat-count{font-family:var(--font-ui);font-size:11px;font-weight:600;background:var(--pearl-dark);border-radius:100px;padding:2px 8px;color:var(--text-light)}
.cat-filter-item.active .cat-count{background:rgba(14,175,159,.15);color:var(--teal)}
.price-range{display:flex;flex-direction:column;gap:12px}
.price-row{display:flex;gap:10px}
.price-input{background:var(--pearl);border:1.5px solid var(--pearl-dark);border-radius:var(--radius-sm);padding:8px 12px;font-size:13px;color:var(--text-dark);width:100%;outline:none;transition:border-color .2s}
.price-input:focus{border-color:var(--teal)}
.price-apply-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:10px;border-radius:var(--radius-sm);background:var(--teal);border:none;font-family:var(--font-ui);font-size:12px;font-weight:700;color:var(--navy);cursor:pointer;transition:var(--transition)}
.price-apply-btn:hover{background:var(--teal-dark)}
.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:4px 0}
.toggle-label{font-size:var(--fs-ui);color:var(--text-mid)}
.toggle-switch{width:40px;height:22px;background:var(--pearl-dark);border-radius:100px;position:relative;cursor:pointer;transition:background .3s;flex-shrink:0}
.toggle-switch.on{background:var(--teal)}
.toggle-switch::after{content:'';position:absolute;top:3px;left:3px;width:16px;height:16px;border-radius:50%;background:var(--white);transition:transform .3s;box-shadow:0 1px 4px rgba(0,0,0,.2)}
.toggle-switch.on::after{transform:translateX(18px)}
.reset-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;border-radius:var(--radius-sm);background:none;border:1.5px solid var(--pearl-dark);font-family:var(--font-ui);font-size:13px;font-weight:600;color:var(--text-mid);cursor:pointer;transition:var(--transition);text-decoration:none}
.reset-btn:hover{border-color:var(--navy);color:var(--navy)}
/* PRODUCTS AREA */
.shop-content{}
.shop-toolbar{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.results-count{font-size:var(--fs-ui);color:var(--text-mid)}
.results-count strong{color:var(--navy)}
.toolbar-right{display:flex;align-items:center;gap:12px}
.sort-select{background:var(--white);border:1.5px solid var(--pearl-dark);border-radius:var(--radius-sm);padding:9px 36px 9px 14px;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:500;color:var(--text-dark);outline:none;cursor:pointer;-webkit-appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238899aa' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;transition:border-color .2s}
.sort-select:focus{border-color:var(--teal)}
.view-toggle{display:flex;border:1.5px solid var(--pearl-dark);border-radius:var(--radius-sm);overflow:hidden}
.view-btn{padding:8px 12px;background:none;border:none;cursor:pointer;color:var(--text-light);transition:var(--transition);display:flex;align-items:center}
.view-btn.active{background:var(--navy);color:var(--white)}
/* PRODUCT GRID */
.products-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.product-card{background:linear-gradient(160deg,#0e2235 0%,var(--navy) 100%);border-radius:var(--radius-md);border:1px solid rgba(14,175,159,.12);overflow:hidden;transition:var(--transition);display:flex;flex-direction:column}
.product-card:hover{border-color:rgba(14,175,159,.35);box-shadow:0 8px 32px rgba(0,0,0,.3);transform:translateY(-4px)}
.product-img{position:relative;aspect-ratio:4/3;background:linear-gradient(135deg,rgba(14,175,159,.08) 0%,rgba(14,175,159,.02) 100%);display:flex;align-items:center;justify-content:center;overflow:hidden;border-bottom:1px solid rgba(255,255,255,.06)}
.product-img img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.product-img svg,.product-img-placeholder{opacity:.35;color:var(--teal)}
.product-img-bg{position:absolute;inset:0;opacity:.06;background-image:radial-gradient(circle at 30% 40%,var(--teal) 0%,transparent 40%),radial-gradient(circle at 70% 70%,var(--gold) 0%,transparent 40%)}
.product-badges{position:absolute;top:12px;left:12px;display:flex;flex-direction:column;gap:6px;z-index:2}
.badge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:100px;font-family:var(--font-ui);font-size:10px;font-weight:700;letter-spacing:.05em;text-transform:uppercase}
.badge-cat{background:rgba(10,26,39,.7);color:var(--white);backdrop-filter:blur(8px)}
.badge-bestseller{background:var(--gold);color:var(--navy)}
.badge-new{background:var(--teal);color:var(--navy)}
.badge-low{background:var(--coral);color:var(--white)}
.product-info{padding:18px;display:flex;flex-direction:column;gap:8px;flex:1}
.product-category{font-family:var(--font-ui);font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--teal)}
.product-name{font-family:var(--font-ui);font-size:15px;font-weight:700;color:#fff;line-height:1.3;text-decoration:none;display:block}
.product-name:hover{color:var(--teal)}
.product-desc{font-size:13px;color:rgba(255,255,255,.55);line-height:1.5;flex:1}
.product-footer{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:auto;padding-top:14px;border-top:1px solid rgba(255,255,255,.07)}
.product-price{font-family:var(--font-ui);font-size:20px;font-weight:700;color:#fff}
.product-price ins{text-decoration:none;color:var(--teal)}
.product-price del{font-size:14px;color:rgba(255,255,255,.4);font-weight:400}
.add-cart-btn{display:flex;align-items:center;gap:7px;background:var(--teal);color:var(--navy);border:none;border-radius:100px;padding:9px 18px;font-family:var(--font-ui);font-size:12px;font-weight:700;cursor:pointer;transition:var(--transition);white-space:nowrap;text-decoration:none}
.add-cart-btn:hover{background:var(--teal-dark);transform:translateY(-1px);box-shadow:0 6px 20px rgba(14,175,159,.35);color:var(--navy)}
.no-products{padding:60px 20px;text-align:center;color:var(--text-mid);font-size:var(--fs-body);grid-column:1/-1}
.no-products strong{display:block;font-size:var(--fs-h3);color:var(--navy);margin-bottom:8px}
/* PAGINATION */
.pagination{display:flex;align-items:center;justify-content:center;gap:8px;margin-top:48px}
.page-btn{width:40px;height:40px;border-radius:var(--radius-sm);border:1.5px solid var(--pearl-dark);background:var(--white);font-family:var(--font-ui);font-size:13px;font-weight:600;color:var(--text-mid);cursor:pointer;transition:var(--transition);display:flex;align-items:center;justify-content:center;text-decoration:none}
.page-btn:hover{border-color:var(--teal);color:var(--teal)}
.page-btn.active,.page-btn.current{background:var(--navy);border-color:var(--navy);color:var(--white)}
.page-btn.arrow{background:none}
@media(max-width:1100px){.shop-main{grid-template-columns:220px 1fr}.products-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){.shop-main{grid-template-columns:1fr;padding:32px 24px 80px}.shop-sidebar{position:static;display:grid;grid-template-columns:1fr 1fr;gap:16px}}
@media(max-width:640px){.shop-sidebar{grid-template-columns:1fr}.products-grid{grid-template-columns:1fr 1fr}.shop-hero-inner{padding:0 24px}}
@media(max-width:420px){.products-grid{grid-template-columns:1fr}}</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>

<section class="shop-hero">
  <div class="shop-hero-inner">
    <div>
      <div class="breadcrumb"><a href="<?php echo esc_url( home_url('/') ); ?>">Home</a><i data-lucide="chevron-right" style="width:11px;height:11px"></i><span>Shop</span></div>
      <h1>Our <em>Peptide</em> Collection</h1>
      <p class="shop-hero-desc"><?php echo esc_html( $total_products ); ?>+ pharmaceutical-grade peptides, each independently tested and COA-documented. Find your stack below.</p>
      <div class="hero-cats">
        <a href="<?php echo esc_url( $shop_base ); ?>" class="hero-cat-pill<?php echo ! $current_cat_slug ? ' active' : ''; ?>">
          <i data-lucide="layers" style="width:12px;height:12px"></i>All
        </a>
        <?php foreach ( $shop_cats as $cat ) :
            $icon = isset( $cat_icons[ $cat->slug ] ) ? $cat_icons[ $cat->slug ] : 'tag';
            $is_active = $current_cat_slug === $cat->slug;
        ?>
        <a href="<?php echo esc_url( add_query_arg( 'product_cat', $cat->slug, $shop_base ) ); ?>"
           class="hero-cat-pill<?php echo $is_active ? ' active' : ''; ?>">
          <i data-lucide="<?php echo esc_attr( $icon ); ?>" style="width:12px;height:12px"></i><?php echo esc_html( $cat->name ); ?>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<div class="shop-main">
  <!-- SIDEBAR -->
  <aside class="shop-sidebar">

    <div class="sidebar-block">
      <form method="get" action="<?php echo esc_url( $shop_base ); ?>">
        <?php if ( $current_cat_slug ) : ?>
          <input type="hidden" name="product_cat" value="<?php echo esc_attr( $current_cat_slug ); ?>">
        <?php endif; ?>
        <div class="search-wrap">
          <i data-lucide="search" style="width:15px;height:15px"></i>
          <input type="text" name="s" placeholder="Search peptides…" value="<?php echo esc_attr( get_search_query() ); ?>">
        </div>
      </form>
    </div>

    <div class="sidebar-block">
      <div class="sidebar-block-title"><i data-lucide="filter" style="width:14px;height:14px"></i>Categories</div>
      <div class="cat-filter-list">
        <a href="<?php echo esc_url( $shop_base ); ?>"
           class="cat-filter-item<?php echo ! $current_cat_slug ? ' active' : ''; ?>">
          <div class="cat-filter-left"><i data-lucide="layers" style="width:16px;height:16px"></i>All Peptides</div>
          <span class="cat-count"><?php echo esc_html( $total_products ); ?></span>
        </a>
        <?php foreach ( $shop_cats as $cat ) :
            $icon      = isset( $cat_icons[ $cat->slug ] ) ? $cat_icons[ $cat->slug ] : 'tag';
            $is_active = $current_cat_slug === $cat->slug;
            $cat_url   = add_query_arg( 'product_cat', $cat->slug, $shop_base );
        ?>
        <a href="<?php echo esc_url( $cat_url ); ?>"
           class="cat-filter-item<?php echo $is_active ? ' active' : ''; ?>">
          <div class="cat-filter-left">
            <i data-lucide="<?php echo esc_attr( $icon ); ?>" style="width:16px;height:16px"></i>
            <?php echo esc_html( $cat->name ); ?>
          </div>
          <span class="cat-count"><?php echo esc_html( $cat->count ); ?></span>
        </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="sidebar-block">
      <div class="sidebar-block-title"><i data-lucide="dollar-sign" style="width:14px;height:14px"></i>Price Range</div>
      <form method="get" action="<?php echo esc_url( $shop_base ); ?>" id="price-filter-form">
        <?php if ( $current_cat_slug ) : ?>
          <input type="hidden" name="product_cat" value="<?php echo esc_attr( $current_cat_slug ); ?>">
        <?php endif; ?>
        <?php if ( $current_orderby && $current_orderby !== 'popularity' ) : ?>
          <input type="hidden" name="orderby" value="<?php echo esc_attr( $current_orderby ); ?>">
        <?php endif; ?>
        <div class="price-range">
          <div class="price-row">
            <input class="price-input" type="number" name="min_price" placeholder="Min $" value="<?php echo esc_attr( $min_price ); ?>" min="0">
            <input class="price-input" type="number" name="max_price" placeholder="Max $" value="<?php echo esc_attr( $max_price ); ?>" min="0">
          </div>
          <button type="submit" class="price-apply-btn"><i data-lucide="search" style="width:13px;height:13px"></i>Apply</button>
        </div>
      </form>
    </div>

    <a href="<?php echo esc_url( $shop_base ); ?>" class="reset-btn">
      <i data-lucide="rotate-ccw" style="width:14px;height:14px"></i>Reset Filters
    </a>

  </aside>

  <!-- PRODUCTS -->
  <div class="shop-content">
    <form method="get" action="<?php echo esc_url( $shop_base ); ?>" id="sort-form">
      <?php if ( $current_cat_slug ) : ?>
        <input type="hidden" name="product_cat" value="<?php echo esc_attr( $current_cat_slug ); ?>">
      <?php endif; ?>
      <?php if ( $min_price !== '' ) : ?>
        <input type="hidden" name="min_price" value="<?php echo esc_attr( $min_price ); ?>">
      <?php endif; ?>
      <?php if ( $max_price !== '' ) : ?>
        <input type="hidden" name="max_price" value="<?php echo esc_attr( $max_price ); ?>">
      <?php endif; ?>
      <div class="shop-toolbar">
        <p class="results-count">Showing <strong><?php echo esc_html( $showing ); ?></strong> of <strong><?php echo esc_html( $total_products ); ?></strong> peptides</p>
        <div class="toolbar-right">
          <select class="sort-select" name="orderby" onchange="document.getElementById('sort-form').submit()">
            <option value="popularity"<?php selected( $current_orderby, 'popularity' ); ?>>Best Selling</option>
            <option value="price"<?php selected( $current_orderby, 'price' ); ?>>Price: Low to High</option>
            <option value="price-desc"<?php selected( $current_orderby, 'price-desc' ); ?>>Price: High to Low</option>
            <option value="date"<?php selected( $current_orderby, 'date' ); ?>>Newest First</option>
            <option value="rating"<?php selected( $current_orderby, 'rating' ); ?>>Top Rated</option>
          </select>
          <div class="view-toggle">
            <button type="button" class="view-btn active" id="gridViewBtn"><i data-lucide="grid-2x2" style="width:15px;height:15px"></i></button>
            <button type="button" class="view-btn" id="listViewBtn"><i data-lucide="list" style="width:15px;height:15px"></i></button>
          </div>
        </div>
      </div>
    </form>

    <div class="products-grid" id="productsGrid">

      <?php if ( $shop_query->have_posts() ) : ?>
        <?php while ( $shop_query->have_posts() ) : $shop_query->the_post();
            $product     = wc_get_product( get_the_ID() );
            if ( ! $product ) continue;
            $thumb_url   = get_the_post_thumbnail_url( get_the_ID(), 'woocommerce_thumbnail' );
            $price_html  = $product->get_price_html();
            $short_desc  = $product->get_short_description();
            $avg_rating  = $product->get_average_rating();
            $review_count = $product->get_review_count();
            $is_on_sale  = $product->is_on_sale();
            $is_featured = $product->is_featured();
            $stock_status = $product->get_stock_status();
            $add_to_cart_url = $product->add_to_cart_url();

            // Primary category
            $terms = wp_get_post_terms( get_the_ID(), 'product_cat', [ 'number' => 1 ] );
            $primary_cat = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? $terms[0] : null;
            $primary_cat_name = $primary_cat ? $primary_cat->name : '';

            // Pick icon
            $card_icon = 'flask-conical';
            if ( $primary_cat ) {
                $card_icon = isset( $cat_icons[ $primary_cat->slug ] ) ? $cat_icons[ $primary_cat->slug ] : 'flask-conical';
            }
        ?>
        <div class="product-card">
          <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-img">
            <?php if ( $thumb_url ) : ?>
              <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
            <?php else : ?>
              <div class="product-img-bg"></div>
              <i data-lucide="<?php echo esc_attr( $card_icon ); ?>" style="width:56px;height:56px;opacity:.2;color:var(--teal)"></i>
            <?php endif; ?>
            <div class="product-badges">
              <?php if ( $primary_cat_name ) : ?>
                <span class="badge badge-cat"><?php echo esc_html( $primary_cat_name ); ?></span>
              <?php endif; ?>
              <?php if ( $is_featured ) : ?>
                <span class="badge badge-bestseller">Best Seller</span>
              <?php endif; ?>
              <?php if ( $is_on_sale ) : ?>
                <span class="badge badge-new">Sale</span>
              <?php endif; ?>
              <?php if ( $stock_status === 'outofstock' ) : ?>
                <span class="badge badge-low">Out of Stock</span>
              <?php endif; ?>
            </div>
          </a>
          <div class="product-info">
            <?php if ( $primary_cat_name ) : ?>
              <div class="product-category"><?php echo esc_html( $primary_cat_name ); ?></div>
            <?php endif; ?>
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-name"><?php echo esc_html( get_the_title() ); ?></a>
            <?php if ( $short_desc ) : ?>
              <p class="product-desc"><?php echo wp_kses_post( wp_trim_words( $short_desc, 20 ) ); ?></p>
            <?php endif; ?>
            <?php if ( $avg_rating > 0 ) : ?>
              <div class="product-rating" style="display:flex;align-items:center;gap:6px">
                <div class="stars" style="display:flex;gap:2px;color:var(--gold)">
                  <?php for ( $s = 1; $s <= 5; $s++ ) : ?>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="<?php echo $s <= round( $avg_rating ) ? 'var(--gold)' : 'none'; ?>" stroke="var(--gold)" stroke-width="1.5"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
                  <?php endfor; ?>
                </div>
                <span style="font-family:var(--font-ui);font-size:12px;font-weight:600;color:var(--text-mid)"><?php echo esc_html( number_format( $avg_rating, 1 ) ); ?></span>
                <?php if ( $review_count > 0 ) : ?>
                  <span style="font-size:11px;color:var(--text-light)">(<?php echo esc_html( $review_count ); ?> reviews)</span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <div class="product-footer">
              <span class="product-price"><?php echo $price_html; ?></span>
              <?php if ( $stock_status !== 'outofstock' ) : ?>
                <a href="<?php echo esc_url( $add_to_cart_url ); ?>" class="add-cart-btn" data-product_id="<?php echo esc_attr( get_the_ID() ); ?>">
                  <i data-lucide="shopping-cart" style="width:13px;height:13px"></i>Add to Cart
                </a>
              <?php else : ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>" class="add-cart-btn" style="background:var(--pearl-dark);color:var(--text-mid)">
                  View Product
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
      <?php else : ?>
        <div class="no-products">
          <strong>No products found</strong>
          Try a different category or <a href="<?php echo esc_url( $shop_base ); ?>" style="color:var(--teal)">view all peptides</a>.
        </div>
      <?php endif; ?>

    </div>

    <?php if ( $shop_query->max_num_pages > 1 ) : ?>
    <div class="pagination">
      <?php if ( $paged > 1 ) : ?>
        <a href="<?php echo esc_url( add_query_arg( 'paged', $paged - 1 ) ); ?>" class="page-btn arrow">
          <i data-lucide="chevron-left" style="width:16px;height:16px"></i>
        </a>
      <?php endif; ?>
      <?php for ( $p = 1; $p <= $shop_query->max_num_pages; $p++ ) : ?>
        <a href="<?php echo esc_url( add_query_arg( 'paged', $p ) ); ?>"
           class="page-btn<?php echo $p === $paged ? ' active' : ''; ?>">
          <?php echo esc_html( $p ); ?>
        </a>
      <?php endfor; ?>
      <?php if ( $paged < $shop_query->max_num_pages ) : ?>
        <a href="<?php echo esc_url( add_query_arg( 'paged', $paged + 1 ) ); ?>" class="page-btn arrow">
          <i data-lucide="chevron-right" style="width:16px;height:16px"></i>
        </a>
      <?php endif; ?>
    </div>
    <?php endif; ?>

  </div>
</div>

<footer class="alluvia-footer">
  <div class="footer-grid">
    <div class="footer-brand"><a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" style="margin-bottom:4px"><svg class="logo-mark" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><polygon points="17,2 30,9.5 30,24.5 17,32 4,24.5 4,9.5" stroke="#0eaf9f" stroke-width="1.6" fill="none" opacity="0.9"/><circle cx="17" cy="10" r="2.2" fill="#0eaf9f"/><circle cx="10.5" cy="21" r="2.2" fill="#0eaf9f"/><circle cx="23.5" cy="21" r="2.2" fill="#0eaf9f"/><line x1="17" y1="10" x2="10.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="17" y1="10" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/><line x1="10.5" y1="21" x2="23.5" y2="21" stroke="#0eaf9f" stroke-width="1.1" opacity="0.5"/></svg><div class="logo-text"><span class="nav-logo-word">Alluvia</span><span class="nav-logo-sub">Peptides</span></div></a><p class="footer-desc">Pharmaceutical-grade bioactive peptides — backed by science, delivered with integrity.</p><div class="footer-socials"><a href="#" class="social-btn"><i data-lucide="instagram" style="width:16px;height:16px"></i></a><a href="#" class="social-btn"><i data-lucide="twitter" style="width:16px;height:16px"></i></a><a href="#" class="social-btn"><i data-lucide="facebook" style="width:16px;height:16px"></i></a><a href="#" class="social-btn"><i data-lucide="youtube" style="width:16px;height:16px"></i></a></div></div>
    <div><h3 class="footer-col-title">Products</h3><ul class="footer-links">
      <?php foreach ( array_slice( $shop_cats, 0, 5 ) as $fcat ) : ?>
        <li><a href="<?php echo esc_url( add_query_arg( 'product_cat', $fcat->slug, $shop_base ) ); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i><?php echo esc_html( $fcat->name ); ?></a></li>
      <?php endforeach; ?>
    </ul></div>
    <div><h3 class="footer-col-title">Company</h3><ul class="footer-links"><li><a href="<?php echo esc_url(home_url('/about/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>About Us</a></li><li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Contact</a></li><li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Shipping</a></li></ul></div>
    <div><h3 class="footer-col-title">Legal</h3><ul class="footer-links"><li><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Terms &amp; Conditions</a></li><li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Privacy Policy</a></li><li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Shipping Policy</a></li><li><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>"><i data-lucide="chevron-right" style="width:12px;height:12px;color:var(--teal)"></i>Disclaimer</a></li></ul></div>
  </div>
  <div class="footer-bottom"><p>&copy; <?php echo date('Y'); ?> Alluvia Peptides. All rights reserved.</p><div class="footer-bottom-links"><a href="<?php echo esc_url(home_url('/terms-conditions/')); ?>">Terms</a><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy</a><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>">Shipping</a><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a></div></div>
</footer>

<script>
lucide.createIcons();
// View toggle
document.getElementById('gridViewBtn').addEventListener('click', function(){
  document.getElementById('productsGrid').style.gridTemplateColumns = '';
  document.getElementById('gridViewBtn').classList.add('active');
  document.getElementById('listViewBtn').classList.remove('active');
  lucide.createIcons();
});
document.getElementById('listViewBtn').addEventListener('click', function(){
  document.getElementById('productsGrid').style.gridTemplateColumns = '1fr';
  document.getElementById('listViewBtn').classList.add('active');
  document.getElementById('gridViewBtn').classList.remove('active');
  lucide.createIcons();
});
</script>
<?php get_footer( 'alluvia' ); ?>
