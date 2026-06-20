<?php
/**
 * Front Page — no Template Name needed.
 *
 * @package Shopping
 */

/**
 * Fetch a few live products from a category for the hero slide showcases.
 * Returns an array of card data (permalink, title, thumb, price, category).
 */
function alluvia_hero_products( $cat_slug, $limit = 4 ) {
	$out = array();
	if ( ! function_exists( 'wc_get_product' ) ) {
		return $out;
	}
	$q = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $limit,
		'orderby'        => 'meta_value_num',
		'meta_key'       => 'total_sales',
		'order'          => 'DESC',
		'tax_query'      => array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $cat_slug ) ),
		'no_found_rows'  => true,
	) );
	foreach ( $q->posts as $p ) {
		$product = wc_get_product( $p->ID );
		if ( ! $product ) { continue; }
		$terms = wp_get_post_terms( $p->ID, 'product_cat', array( 'number' => 1 ) );
		$out[] = array(
			'url'   => get_permalink( $p->ID ),
			'name'  => get_the_title( $p->ID ),
			'thumb' => get_the_post_thumbnail_url( $p->ID, 'woocommerce_thumbnail' ),
			'price' => $product->get_price_html(),
			'cat'   => ( ! is_wp_error( $terms ) && $terms ) ? $terms[0]->name : '',
		);
	}
	wp_reset_postdata();
	return $out;
}

$hero_medical  = alluvia_hero_products( 'medical-peptides', 2 );
$hero_skincare = alluvia_hero_products( 'skincare-peptides', 2 );
$hero_sports   = alluvia_hero_products( 'sports-recovery', 2 );

// Shared stats row, rendered inside each slide just above its CTA buttons.
$hero_stats_html =
	'<div class="hero-stats hero-stats-inline">'
	. '<div class="stat-item"><span class="stat-number">98%</span><span class="stat-label">Purity Grade</span></div>'
	. '<div class="stat-item"><span class="stat-number">8</span><span class="stat-label">Categories</span></div>'
	. '<div class="stat-item"><span class="stat-number">50+</span><span class="stat-label">Active Peptides</span></div>'
	. '</div>';

/** Render a compact hero product-card grid (2 col desktop / 1 col mobile). */
function alluvia_hero_card_grid( $items ) {
	if ( empty( $items ) ) { return; }
	echo '<div class="hero-product-grid">';
	foreach ( $items as $it ) {
		echo '<a class="hpc" href="' . esc_url( $it['url'] ) . '">';
		echo '<div class="hpc-img">';
		if ( $it['thumb'] ) {
			echo '<img src="' . esc_url( $it['thumb'] ) . '" alt="' . esc_attr( $it['name'] ) . '" loading="lazy">';
		} else {
			echo '<span class="hpc-ph"><i data-lucide="flask-conical" style="width:30px;height:30px;color:var(--teal)"></i></span>';
		}
		echo '</div><div class="hpc-body">';
		if ( $it['cat'] ) { echo '<div class="hpc-cat">' . esc_html( $it['cat'] ) . '</div>'; }
		echo '<div class="hpc-name">' . esc_html( $it['name'] ) . '</div>';
		echo '<div class="hpc-price">' . wp_kses_post( $it['price'] ) . '</div>';
		echo '</div></a>';
	}
	echo '</div>';
}

add_action( 'wp_head', function() {
?>
<style>
/* HERO */
.hero{position:relative;min-height:70vh;background:var(--navy);display:flex;align-items:center;overflow:hidden}
/* Hero visual slider (molecule on slides 1&5, product grids on 2/3/4) */
.hero-vslide{display:none}
.hero-vslide.active{display:block;animation:fadeRight .6s ease}
.hero-showcase{display:flex;flex-direction:column;gap:18px}
.hero-showcase .hero-stats{margin:0;padding-top:18px;border-top:1px solid rgba(255,255,255,.12);border-bottom:none}
.hero-showcase-cta{align-self:flex-start;margin-top:0}
.hero-product-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.hpc{display:flex;flex-direction:column;background:#fff;border-radius:14px;overflow:hidden;text-decoration:none;border:1px solid rgba(255,255,255,.1);transition:transform .25s,box-shadow .25s}
.hpc:hover{transform:translateY(-4px);box-shadow:0 16px 38px rgba(0,0,0,.38)}
.hpc-img{aspect-ratio:1/1;background:linear-gradient(135deg,var(--navy),var(--navy-soft));display:flex;align-items:center;justify-content:center;overflow:hidden}
.hpc-img img{width:100%;height:100%;object-fit:cover;display:block}
.hpc-body{padding:12px 14px 14px;display:flex;flex-direction:column;gap:3px}
.hpc-cat{font-family:var(--font-ui);font-size:9px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--teal-dark)}
.hpc-name{font-family:var(--font-ui);font-size:13px;font-weight:700;color:var(--navy);line-height:1.25}
.hpc-price{font-family:var(--font-ui);font-size:14px;font-weight:700;color:var(--navy);margin-top:2px}
.hpc-price del{color:var(--text-light);font-weight:400;font-size:12px;margin-right:4px}
.hpc-price ins{text-decoration:none}
#hero-canvas{position:absolute;inset:0;width:100%;height:100%;pointer-events:none}
.hero-gradient{position:absolute;inset:0;background:radial-gradient(ellipse 70% 60% at 80% 50%,rgba(14,175,159,.12) 0%,transparent 60%),radial-gradient(ellipse 50% 80% at 20% 80%,rgba(198,162,83,.08) 0%,transparent 50%),linear-gradient(135deg,#0a1a27 0%,#15283b 50%,#0a1a27 100%)}
.hero-inner{position:relative;z-index:2;max-width:1280px;margin:0 auto;padding:108px 40px 64px;display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(14,175,159,.1);border:1px solid rgba(14,175,159,.3);border-radius:100px;padding:8px 18px;margin-bottom:28px;opacity:0;transform:translateY(20px);animation:fadeUp .8s .2s ease forwards}
.hero-badge-dot{width:7px;height:7px;border-radius:50%;background:var(--teal);animation:pulse-dot 2s ease-in-out infinite;flex-shrink:0}
.hero-badge-text{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:var(--teal)}
.hero-title{font-family:var(--font-display);font-size:clamp(31px,3.9vw,59px);font-weight:300;line-height:1.03;color:var(--white);margin-bottom:30px;opacity:0;transform:translateY(30px);animation:fadeUp .9s .35s ease forwards}
.hero-title em{font-style:italic;color:var(--teal)}
.hero-desc{font-size:var(--fs-lead);font-weight:300;line-height:1.85;color:rgba(255,255,255,.85);max-width:520px;margin-bottom:48px;opacity:0;transform:translateY(30px);animation:fadeUp .9s .5s ease forwards}
.hero-actions{display:flex;align-items:center;gap:16px;flex-wrap:wrap;opacity:0;transform:translateY(30px);animation:fadeUp .9s .65s ease forwards}
.hero-stats{display:flex;gap:40px;margin-top:56px;padding-top:40px;border-top:1px solid rgba(255,255,255,.1);opacity:0;transform:translateY(20px);animation:fadeUp .9s .85s ease forwards;flex-wrap:wrap}
/* Stats placed inside each slide, just above the CTA buttons */
.hero-stats.hero-stats-inline{margin:6px 0 22px;padding-top:20px;padding-bottom:0;border-top:1px solid rgba(255,255,255,.1);border-bottom:none;gap:28px;animation:none;opacity:1;transform:none}
.hero-stats-inline .stat-number{font-size:clamp(24px,2.6vw,32px)}
.stat-item{display:flex;flex-direction:column}
.stat-number{font-family:var(--font-display);font-size:36px;font-weight:600;color:var(--white);line-height:1}
.stat-number span{color:var(--teal)}
.stat-label{font-size:var(--fs-micro);font-weight:500;letter-spacing:.1em;color:rgba(255,255,255,.70);margin-top:6px;text-transform:uppercase}

/* Hero Visual */
.hero-visual{position:relative;opacity:0;transform:translateX(40px) scale(.96);animation:fadeRight 1s .6s ease forwards}
.hero-molecule{position:relative;width:100%;aspect-ratio:1;display:flex;align-items:center;justify-content:center}
/* soft radial aura pulsing behind the whole orbit system */
.hero-molecule::before{content:'';position:absolute;width:78%;height:78%;border-radius:50%;background:radial-gradient(circle,rgba(14,175,159,.22),rgba(14,175,159,.06) 46%,transparent 72%);filter:blur(6px);z-index:0;animation:corePulse 5s ease-in-out infinite}
.molecule-ring{position:absolute;border-radius:50%;border:1.5px solid rgba(14,175,159,.30);box-shadow:inset 0 0 32px rgba(14,175,159,.05);z-index:1;animation:spin-slow 20s linear infinite}
.molecule-ring:nth-child(1){width:90%;height:90%;animation-duration:30s;border-color:rgba(14,175,159,.30)}
.molecule-ring:nth-child(2){width:70%;height:70%;animation-duration:22s;animation-direction:reverse;border-color:rgba(198,162,83,.34)}
.molecule-ring:nth-child(3){width:50%;height:50%;animation-duration:16s;border-color:rgba(14,175,159,.42)}
/* orbiting particles — brighter & larger, with a second counter particle per ring */
.molecule-ring::before{content:'';position:absolute;top:-6.5px;left:50%;transform:translateX(-50%);width:13px;height:13px;border-radius:50%;background:var(--teal);box-shadow:0 0 22px 4px var(--teal)}
.molecule-ring:nth-child(2)::before{background:var(--gold);box-shadow:0 0 22px 4px var(--gold)}
.molecule-ring::after{content:'';position:absolute;bottom:-5px;left:50%;transform:translateX(-50%);width:9px;height:9px;border-radius:50%;background:#fff;box-shadow:0 0 15px 3px var(--teal)}
.molecule-ring:nth-child(2)::after{box-shadow:0 0 15px 3px var(--gold)}
.molecule-core{position:relative;z-index:2;width:188px;height:188px;border-radius:50%;background:linear-gradient(135deg,var(--navy-soft),var(--navy-mid));border:1.5px solid rgba(14,175,159,.5);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;box-shadow:0 0 70px rgba(14,175,159,.28),inset 0 1px 0 rgba(255,255,255,.12);animation:corePulse 4s ease-in-out infinite}
.molecule-core svg{color:var(--teal);filter:drop-shadow(0 0 10px var(--teal-glow))}
@keyframes corePulse{0%,100%{box-shadow:0 0 60px rgba(14,175,159,.24),inset 0 1px 0 rgba(255,255,255,.12)}50%{box-shadow:0 0 104px rgba(14,175,159,.48),inset 0 1px 0 rgba(255,255,255,.14)}}
.molecule-core-label{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--teal)}
.hero-floating-cards{position:absolute;inset:0;pointer-events:none;z-index:3}
.hero-card-float{position:absolute;background:linear-gradient(135deg,rgba(28,46,68,.97),rgba(16,28,45,.95));backdrop-filter:blur(16px);border:1px solid rgba(14,175,159,.42);border-radius:16px;padding:15px 20px;display:flex;align-items:center;gap:13px;box-shadow:0 20px 46px -16px rgba(0,0,0,.72),0 0 26px -6px rgba(14,175,159,.40),inset 0 1px 0 rgba(255,255,255,.06);animation:float-card 4s ease-in-out infinite}
/* "verified" tick badge on every trust card */
.hero-card-float::after{content:'';position:absolute;top:-8px;right:-8px;width:22px;height:22px;border-radius:50%;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'/%3E%3C/svg%3E") center/12px no-repeat,linear-gradient(135deg,var(--teal),var(--teal-dark));box-shadow:0 0 0 2.5px rgba(10,26,39,.92),0 5px 12px rgba(14,175,159,.55)}
.hero-card-float:nth-child(1){top:6%;right:5%;animation-delay:0s}
.hero-card-float:nth-child(2){bottom:16%;left:1%;animation-delay:1.5s}
.hero-card-float:nth-child(3){top:54%;right:3%;animation-delay:.8s}
.float-card-icon{width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,var(--teal),var(--teal-dark));border:1px solid rgba(255,255,255,.18);box-shadow:0 6px 16px -5px rgba(14,175,159,.6);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff}
.float-card-title{font-family:var(--font-ui);font-size:var(--fs-base);font-weight:700;color:var(--white);white-space:nowrap;letter-spacing:.01em}
.float-card-sub{font-size:var(--fs-sm);color:rgba(255,255,255,.80);white-space:nowrap;margin-top:2px}

/* TRUST STRIP */
.trust-strip{background:var(--white);border-top:1px solid var(--pearl-dark);border-bottom:1px solid var(--pearl-dark);padding:24px 0;overflow:hidden}

/* PROMISE SECTION */
.promise-section{padding:88px 0 96px;background:var(--pearl);position:relative;overflow:hidden}
.promise-section::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,transparent,var(--teal) 30%,var(--gold) 65%,var(--teal) 85%,transparent)}
.promise-section::after{content:'';position:absolute;bottom:0;left:0;right:0;height:1px;background:var(--pearl-dark)}
.promise-header{text-align:center;margin-bottom:56px}
.promise-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.promise-card{background:var(--white);border-radius:var(--radius-md);padding:44px 36px 40px;border:1px solid var(--pearl-dark);display:flex;flex-direction:column;gap:18px;transition:var(--transition);position:relative;overflow:hidden}
.promise-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--pc-color,var(--teal));opacity:.7;transition:opacity .3s}
.promise-card:hover{border-color:var(--pc-color,var(--teal));box-shadow:0 16px 48px rgba(10,26,39,.10);transform:translateY(-6px)}
.promise-card:hover::before{opacity:1}
.promise-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;background:color-mix(in srgb,var(--pc-color,var(--teal)) 12%,transparent);border:1px solid color-mix(in srgb,var(--pc-color,var(--teal)) 28%,transparent);color:var(--pc-color,var(--teal));transition:var(--transition)}
.promise-card:hover .promise-icon{background:var(--pc-color,var(--teal));color:var(--white);box-shadow:0 8px 24px color-mix(in srgb,var(--pc-color,var(--teal)) 40%,transparent)}
.promise-title{font-family:var(--font-ui);font-size:20px;font-weight:700;color:var(--navy);line-height:1.2}
.promise-desc{font-size:15px;font-weight:400;line-height:1.75;color:var(--text-mid)}
.promise-badge{display:inline-flex;align-items:center;gap:6px;background:color-mix(in srgb,var(--pc-color,var(--teal)) 10%,transparent);border:1px solid color-mix(in srgb,var(--pc-color,var(--teal)) 24%,transparent);border-radius:100px;padding:5px 14px;font-family:var(--font-ui);font-size:11px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--pc-color,var(--teal));align-self:flex-start;margin-top:4px}
@media(max-width:860px){.promise-grid{grid-template-columns:1fr;max-width:520px;margin:0 auto}}
@media(max-width:640px){.promise-section{padding:64px 0 72px}.promise-card{padding:34px 26px 30px}}
.trust-inner{max-width:1280px;margin:0 auto;padding:0 40px;display:flex;align-items:center;justify-content:center;gap:48px;flex-wrap:wrap}
.trust-item{display:flex;align-items:center;gap:10px;opacity:.9;transition:opacity .3s,transform .3s;cursor:default}
.trust-item:hover{opacity:1;transform:translateY(-2px)}
.trust-item svg{color:var(--t-accent,var(--teal));transition:color .3s}
.trust-inner .trust-item:nth-child(1){--t-accent:#11b6a3}
.trust-inner .trust-item:nth-child(2){--t-accent:#1fb074}
.trust-inner .trust-item:nth-child(3){--t-accent:#6aa6c6}
.trust-inner .trust-item:nth-child(4){--t-accent:#58b488}
.trust-inner .trust-item:nth-child(5){--t-accent:#c6a253}
.trust-inner .trust-item:nth-child(6){--t-accent:#e07b43}
.trust-text{font-family:var(--font-ui);font-size:var(--fs-sm);font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--navy);white-space:nowrap}

/* SECTION COMMONS */
.section-title{font-family:var(--font-display);font-size:clamp(38px,4.5vw,68px);font-weight:300;line-height:1.08;color:var(--navy);margin-bottom:22px}
.section-title em{font-style:italic;color:var(--teal)}
.section-title .gold{font-style:italic;color:var(--gold)}
.section-desc{font-size:var(--fs-body);font-weight:300;line-height:1.85;color:var(--text-mid);max-width:580px}

/* ABOUT */
.about-section{padding:120px 0;background:var(--pearl);position:relative;overflow:hidden}
.about-section::before{content:'ALLUVIA';position:absolute;font-family:var(--font-display);font-size:clamp(100px,18vw,220px);font-weight:700;color:rgba(10,26,39,.025);top:50%;left:50%;transform:translate(-50%,-50%);white-space:nowrap;pointer-events:none;user-select:none}
.about-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.about-image-wrap{border-radius:var(--radius-lg);overflow:hidden;aspect-ratio:4/5;background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);display:flex;align-items:center;justify-content:center;position:relative}
.dna-animation{position:relative;width:140px;height:280px}
.dna-col{position:absolute;top:0;bottom:0;width:3px;border-radius:2px;background:linear-gradient(to bottom,transparent,var(--teal),var(--gold),var(--teal),transparent)}
.dna-col-l{left:30px}
.dna-col-r{right:30px}
.dna-rung{position:absolute;left:33px;right:33px;height:2px;border-radius:2px;animation:dna-pulse 2s ease-in-out infinite}
.dna-rung:nth-child(odd){background:var(--teal)}
.dna-rung:nth-child(even){background:var(--gold)}
.about-accent-card{position:absolute;bottom:-24px;right:-24px;background:var(--teal);color:var(--navy);border-radius:var(--radius-md);padding:24px 28px;min-width:190px;box-shadow:var(--shadow-lg)}
.about-accent-num{font-family:var(--font-display);font-size:48px;font-weight:600;line-height:1;margin-bottom:4px}
.about-accent-text{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:600;letter-spacing:.12em;text-transform:uppercase;opacity:.8}
.about-visual{position:relative}
.about-content{display:flex;flex-direction:column;gap:32px}
.about-list{list-style:none;display:flex;flex-direction:column;gap:14px;margin:0;padding:0}
.about-list li{display:flex;align-items:flex-start;gap:12px;font-size:var(--fs-body);color:var(--text-mid);line-height:1.65}
.check-wrap{flex-shrink:0;width:22px;height:22px;border-radius:50%;background:rgba(14,175,159,.1);border:1px solid var(--teal);display:flex;align-items:center;justify-content:center;margin-top:1px;color:var(--teal)}

/* CATEGORIES */
.categories-section{padding:120px 0;background:var(--navy);position:relative;overflow:hidden}
.categories-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 55% 50% at 0% 45%,rgba(17,182,163,.10) 0%,transparent 60%),radial-gradient(ellipse 45% 55% at 100% 22%,rgba(231,111,147,.08) 0%,transparent 55%),radial-gradient(ellipse 50% 60% at 62% 112%,rgba(198,162,83,.07) 0%,transparent 55%);pointer-events:none}
.categories-header{text-align:center;margin-bottom:72px}
.categories-header .section-title{color:var(--white)}
.categories-header .section-desc{color:rgba(255,255,255,.55);margin:0 auto}
.categories-header .section-label{justify-content:center}
.categories-grid{display:flex;flex-wrap:wrap;justify-content:center;gap:20px}
.cat-card{flex:0 1 calc(25% - 15px);position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;text-decoration:none;min-height:152px;border-radius:var(--radius-md);padding:28px 20px;background:linear-gradient(165deg,color-mix(in srgb,var(--cat-color,var(--teal)) 13%,transparent) 0%,rgba(255,255,255,.03) 60%);border:1px solid color-mix(in srgb,var(--cat-color,var(--teal)) 24%,rgba(255,255,255,.07));cursor:pointer;transition:var(--transition);overflow:hidden}
.cat-card::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--cat-color,var(--teal)),transparent 60%);opacity:0;transition:opacity .45s ease}
.cat-card:hover::before{opacity:.14}
.cat-card:hover{border-color:color-mix(in srgb,var(--cat-color,var(--teal)) 55%,transparent);transform:translateY(-6px);box-shadow:0 24px 60px rgba(0,0,0,.34)}
.cat-card:focus-visible{outline:2px solid var(--cat-color,var(--teal));outline-offset:3px}
.cat-icon-wrap{width:80px;height:80px;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;background:color-mix(in srgb,var(--cat-color,var(--teal)) 18%,transparent);border:1px solid color-mix(in srgb,var(--cat-color,var(--teal)) 38%,transparent);transition:var(--transition);position:relative;z-index:1;color:var(--cat-color,var(--teal))}
.cat-icon-wrap svg{width:44px;height:44px}
.cat-card:hover .cat-icon-wrap{background:var(--cat-color,var(--teal));border-color:var(--cat-color,var(--teal));color:var(--navy);box-shadow:0 12px 30px color-mix(in srgb,var(--cat-color,var(--teal)) 48%,transparent);transform:scale(1.08) rotate(-4deg)}
.cat-name{font-family:var(--font-ui);font-size:var(--fs-body);font-weight:700;color:var(--white);margin:0;line-height:1.28;letter-spacing:.01em;position:relative;z-index:1;transition:color .3s}
.cat-card:hover .cat-name{color:#fff}

/* HOW IT WORKS */
.hiw-section{padding:120px 0;background:var(--navy);position:relative;overflow:hidden}
.hiw-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 50% 50%,rgba(14,175,159,.05) 0%,transparent 65%);pointer-events:none}
.hiw-header{text-align:center;margin-bottom:80px}
.hiw-header .section-title{color:var(--white)}
.hiw-header .section-desc{color:rgba(255,255,255,.55);margin:0 auto}
.hiw-header .section-label{justify-content:center}
.hiw-steps{display:grid;grid-template-columns:repeat(4,1fr);gap:0;position:relative}
.hiw-steps::before{content:'';position:absolute;top:52px;left:calc(12.5% + 26px);right:calc(12.5% + 26px);height:1px;background:linear-gradient(90deg,transparent,rgba(14,175,159,.3) 20%,rgba(14,175,159,.3) 80%,transparent);z-index:0}
.hiw-step{display:flex;flex-direction:column;align-items:center;text-align:center;padding:0 24px;position:relative}
.hiw-step-top{position:relative;z-index:1;margin-bottom:28px}
.hiw-step-num{position:absolute;top:-10px;right:-10px;width:22px;height:22px;border-radius:50%;background:var(--teal);color:var(--navy);font-family:var(--font-ui);font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;line-height:1}
.hiw-icon-ring{width:104px;height:104px;border-radius:50%;background:rgba(255,255,255,.04);border:1px solid rgba(14,175,159,.2);display:flex;align-items:center;justify-content:center;transition:var(--transition);color:var(--teal)}
.hiw-step:hover .hiw-icon-ring{background:rgba(14,175,159,.1);border-color:rgba(14,175,159,.5);box-shadow:0 0 40px rgba(14,175,159,.2);transform:scale(1.06)}
.hiw-step-title{font-family:var(--font-ui);font-size:16px;font-weight:700;color:var(--white);margin-bottom:12px;letter-spacing:.01em}
.hiw-step-desc{font-size:var(--fs-body);font-weight:300;color:rgba(255,255,255,.70);line-height:1.75;max-width:200px}
.hiw-arrow{position:absolute;top:44px;right:-12px;z-index:2;color:rgba(14,175,159,.4)}
.hiw-step:last-child .hiw-arrow{display:none}

/* SCIENCE / PROCESS */
.science-section{padding:120px 0;background:var(--pearl);position:relative;overflow:hidden}
.science-section::before{content:'';position:absolute;inset:0;pointer-events:none;background:radial-gradient(ellipse 42% 52% at 100% 2%,rgba(17,182,163,.09),transparent 55%),radial-gradient(ellipse 46% 56% at 0% 100%,rgba(231,111,147,.06),transparent 55%),radial-gradient(ellipse 40% 50% at 80% 100%,rgba(198,162,83,.06),transparent 55%)}
.science-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start;position:relative;z-index:1}
.process-steps{display:flex;flex-direction:column;margin-top:48px}
.process-step{display:flex;gap:20px;padding-bottom:32px}
.process-step:last-child{padding-bottom:0}
.process-step-line{display:flex;flex-direction:column;align-items:center;flex-shrink:0}
.process-step-num{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--navy),var(--navy-soft));color:var(--teal);font-family:var(--font-ui);font-size:13px;font-weight:700;display:flex;align-items:center;justify-content:center;border:2px solid rgba(14,175,159,.3);transition:var(--transition);flex-shrink:0}
.process-step:hover .process-step-num{background:var(--teal);color:var(--navy);border-color:var(--teal);box-shadow:var(--shadow-glow)}
.process-connector{flex:1;width:1px;background:linear-gradient(to bottom,rgba(14,175,159,.3),transparent);margin:6px 0;min-height:20px}
.process-step:last-child .process-connector{display:none}
.process-content{padding-top:8px}
.process-title{font-family:var(--font-ui);font-size:15px;font-weight:600;color:var(--navy);margin-bottom:6px}
.process-text{font-size:var(--fs-body);color:var(--text-mid);line-height:1.7}
.science-certs{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:10px}
.cert-card{background:var(--white);border-radius:var(--radius-md);padding:28px 24px;border:1px solid var(--pearl-dark);transition:var(--transition);display:flex;flex-direction:column;gap:12px}
.cert-card:hover{border-color:var(--teal);box-shadow:0 8px 32px rgba(14,175,159,.1);transform:translateY(-4px)}
.cert-icon{color:var(--teal)}
.cert-title{font-family:var(--font-ui);font-size:14px;font-weight:700;color:var(--navy)}
.cert-text{font-size:var(--fs-body);color:var(--text-mid);line-height:1.6}

/* STATS */
.stats-section{padding:80px 0;background:linear-gradient(135deg,var(--navy) 0%,var(--navy-soft) 100%);position:relative;overflow:hidden}
.stats-section::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--teal),var(--gold),var(--teal))}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:40px;text-align:center}
.stats-item{display:flex;flex-direction:column;align-items:center;gap:8px;opacity:0;transform:translateY(24px);transition:var(--transition)}
.stats-item.reveal-done{opacity:1;transform:translateY(0)}
.stats-num{font-family:var(--font-display);font-size:clamp(40px,5vw,56px);font-weight:600;color:var(--white);line-height:1}
.stats-num.teal{color:var(--teal)}
.stats-num.gold{color:var(--gold)}
.stats-label{font-family:var(--font-ui);font-size:var(--fs-micro);font-weight:500;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.70)}

/* TESTIMONIALS */
.testimonials-section{padding:120px 0;background:var(--white)}
.testimonials-header{text-align:center;margin-bottom:72px}
.testimonials-header .section-label{justify-content:center}
.testimonials-header .section-desc{margin:0 auto}
.testimonials-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.testi-card{--tc:var(--teal);background:var(--pearl);border-radius:var(--radius-md);padding:34px 32px;border:1px solid var(--pearl-dark);border-top:3px solid var(--tc);display:flex;flex-direction:column;gap:20px;transition:var(--transition)}
.testimonials-grid .testi-card:nth-child(3n+2){--tc:#e76f93}
.testimonials-grid .testi-card:nth-child(3n){--tc:#d4b566}
.testi-card:hover{border-color:color-mix(in srgb,var(--tc) 32%,var(--pearl-dark));box-shadow:0 14px 38px color-mix(in srgb,var(--tc) 15%,transparent);transform:translateY(-4px)}
.testi-stars{display:flex;gap:3px;color:var(--gold)}
.testi-stars svg{fill:var(--gold);stroke:none}
.testi-quote{font-family:var(--font-display);font-size:18px;font-weight:300;font-style:italic;line-height:1.7;color:var(--navy);flex:1}
.quote-open{color:var(--tc);font-family:var(--font-display);font-size:56px;line-height:.6;display:block;margin-bottom:4px;font-style:normal}
.testi-author{display:flex;align-items:center;gap:12px;border-top:1px solid var(--pearl-dark);padding-top:18px}
.testi-avatar{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--tc),var(--navy));display:flex;align-items:center;justify-content:center;font-family:var(--font-ui);font-size:14px;font-weight:700;color:var(--white);flex-shrink:0}
.testi-name{font-family:var(--font-ui);font-size:14px;font-weight:600;color:var(--navy)}
.testi-meta{font-size:var(--fs-sm);color:var(--text-light);margin-top:2px}
.testi-product{display:inline-flex;align-items:center;font-size:var(--fs-micro);font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--tc);background:color-mix(in srgb,var(--tc) 10%,transparent);border:1px solid color-mix(in srgb,var(--tc) 20%,transparent);border-radius:100px;padding:4px 10px;margin-left:auto;white-space:nowrap}

/* CTA */
.cta-section{padding:120px 0;background:var(--navy);position:relative;overflow:hidden;text-align:center}
.cta-section::before{content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:900px;height:900px;border-radius:50%;background:radial-gradient(circle at 38% 40%,rgba(17,182,163,.14) 0%,transparent 55%),radial-gradient(circle at 66% 60%,rgba(231,111,147,.10) 0%,transparent 55%),radial-gradient(circle at 52% 52%,rgba(198,162,83,.08) 0%,transparent 60%);pointer-events:none}
.cta-inner{position:relative;z-index:2;max-width:680px;margin:0 auto;padding:0 40px}
.cta-section .section-label{justify-content:center}
.cta-section .section-title{color:var(--white);font-size:clamp(36px,5vw,64px)}
.cta-section .section-desc{color:rgba(255,255,255,.55);margin:0 auto 48px}
.email-form{display:flex;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:100px;padding:6px 6px 6px 24px;width:100%;max-width:460px;margin:0 auto;transition:border-color .3s}
.email-form:focus-within{border-color:rgba(14,175,159,.5)}
.email-form input{flex:1;background:transparent;border:none;color:var(--white);font-family:var(--font-body);font-size:14px;padding:10px 0;outline:none;min-width:0}
.email-form input::placeholder{color:rgba(255,255,255,.3)}
.email-form button{display:flex;align-items:center;gap:8px;background:var(--teal);color:var(--navy);border:none;border-radius:100px;padding:12px 22px;font-family:var(--font-ui);font-size:var(--fs-ui);font-weight:700;cursor:pointer;transition:var(--transition);white-space:nowrap}
.email-form button:hover{background:var(--teal-dark)}
.cta-note{font-size:var(--fs-xs);color:rgba(255,255,255,.45);margin-top:18px;display:flex;align-items:center;justify-content:center;gap:6px}
.cta-note svg{color:rgba(255,255,255,.45)}

/* ANIMATIONS */
@keyframes fadeUp{to{opacity:1;transform:translateY(0)}}
@keyframes fadeRight{to{opacity:1;transform:translateX(0) scale(1)}}
@keyframes spin-slow{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
@keyframes pulse-dot{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.6;transform:scale(.8)}}
@keyframes float-card{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
@keyframes dna-pulse{0%,100%{opacity:.4}50%{opacity:1}}

.reveal{opacity:0;transform:translateY(32px);transition:opacity .7s ease,transform .7s ease}
.reveal.reveal-done{opacity:1;transform:translateY(0)}
.reveal-delay-1{transition-delay:.1s}
.reveal-delay-2{transition-delay:.2s}
.reveal-delay-3{transition-delay:.3s}
.reveal-delay-4{transition-delay:.4s}
.reveal-delay-5{transition-delay:.5s}
.reveal-delay-6{transition-delay:.6s}
.reveal-delay-7{transition-delay:.7s}
.reveal-delay-8{transition-delay:.8s}

/* ── RESPONSIVE ── */
@media(max-width:1100px){
  .cat-card{flex-basis:calc(50% - 10px)}
  .hiw-steps{grid-template-columns:repeat(2,1fr);gap:48px}
  .hiw-steps::before{display:none}
  .hiw-step .hiw-arrow{display:none}
}
@media(max-width:900px){
  .hero-inner{grid-template-columns:1fr;padding:110px 24px 70px}
  /* hide only the decorative molecule on mobile; product grids stay (1 column) */
  .hero-vslide.is-molecule{display:none}
  .hero-product-grid{grid-template-columns:1fr 1fr;gap:12px;max-width:480px}
  .hpc-img{aspect-ratio:16/10}
  .about-grid,.science-grid{grid-template-columns:1fr;gap:60px}
  .about-visual{display:none}
  .stats-grid{grid-template-columns:repeat(2,1fr)}
  .testimonials-grid{grid-template-columns:1fr;max-width:520px;margin:0 auto}
}
@media(max-width:640px){
  .categories-grid{gap:14px}
  .cat-card{flex-basis:calc(50% - 7px);min-height:128px;padding:22px 12px}
  .cat-icon-wrap{width:62px;height:62px;border-radius:16px;margin-bottom:10px}
  .cat-icon-wrap svg{width:32px;height:32px}
  .cat-name{font-size:13px}
  .hiw-steps{grid-template-columns:1fr;gap:40px}
  .hiw-icon-ring{width:88px;height:88px}
  .stats-grid{grid-template-columns:1fr 1fr}
  .hero-stats{gap:24px}
  .trust-inner{gap:24px}
  .cta-inner{padding:0 24px}
  .science-certs{grid-template-columns:1fr}
  .about-section{padding:80px 0}
  .categories-section,.science-section,.testimonials-section,.cta-section,.hiw-section{padding:80px 0}
}
@media(max-width:560px){
  .section-title{font-size:clamp(30px,7.5vw,40px)}
  .section-desc{font-size:var(--fs-base)}
  .hero-title{font-size:clamp(30px,8vw,44px)}
  .hero-inner{padding:92px 20px 54px;gap:34px}
  .hero-desc{margin-bottom:32px}
  .hero-stats.hero-stats-inline{gap:18px}
  .promise-section,.about-section,.categories-section,.science-section,.testimonials-section,.cta-section,.hiw-section,.stats-section{padding:64px 0}
  .promise-header,.categories-header,.hiw-header,.testimonials-header{margin-bottom:38px}
}
@media(max-width:380px){
  .hero-actions{flex-direction:column;align-items:stretch}
}
</style>
<?php
}, 20 );
get_header( 'alluvia' );
?>
<?php get_template_part( 'partials/nav-alluvia' ); ?>


<style>
/* ── Richer hero base + dynamic colour glow ── */
.hero{background:radial-gradient(ellipse 62% 72% at 72% 30%,#123150 0%,#0b2034 46%,var(--navy) 82%)}
.hero-glow{position:absolute;inset:0;pointer-events:none;z-index:1;
  background:
    radial-gradient(ellipse 46% 54% at 72% 40%,var(--hero-accent,rgba(14,175,159,.26)),transparent 62%),
    radial-gradient(ellipse 40% 48% at 14% 84%,rgba(198,162,83,.08),transparent 60%);
  transition:background 1.1s ease;opacity:.9}

/* ── Hero slider ── */
.hero-content{position:relative;z-index:2}
.hero-slider{position:relative}
.hero-slide{display:none}
.hero-slide.active{display:block;animation:heroSlideIn .6s cubic-bezier(.23,1,.32,1)}
@keyframes heroSlideIn{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}
/* Keep the active slide's content visible at rest. The badge/title/desc/actions
   use a one-shot fadeUp entrance (opacity:0 baseline); the slider's go() only
   toggles .active and never replays it, so when the carousel returns to a slide
   its text would stay invisible. On slides 1 & 5 that left the whole hero blank
   on mobile (their molecule visual is display:none there) — i.e. "not responsive".
   Pinning the resting state to visible fixes it; the entrance still plays the
   first time each slide is shown (display:none -> block starts the animation). */
.hero-slide.active .hero-badge,
.hero-slide.active .hero-title,
.hero-slide.active .hero-desc,
.hero-slide.active .hero-actions{opacity:1;transform:none}

/* per-slide accent palette — vitality / healing / radiance / energy / premium */
.hero-slide{--accent:var(--teal);--accent-dark:var(--teal-dark)}
.hero-slide:nth-child(1){--accent:#11b6a3;--accent-dark:#0a8174}
.hero-slide:nth-child(2){--accent:#1fb074;--accent-dark:#0e7d50}
.hero-slide:nth-child(3){--accent:#e76f93;--accent-dark:#c44e6e}
.hero-slide:nth-child(4){--accent:#ef8246;--accent-dark:#c95c27}
.hero-slide:nth-child(5){--accent:#d4b566;--accent-dark:#a8853c}

.hero-slide .hero-badge{background:color-mix(in srgb,var(--accent) 16%,transparent);border:1px solid color-mix(in srgb,var(--accent) 40%,transparent);backdrop-filter:blur(6px)}
.hero-slide .hero-badge-dot{background:var(--accent);box-shadow:0 0 12px var(--accent)}
.hero-slide .hero-badge-text{color:var(--accent)}
.hero-slide .hero-title em{color:var(--accent);font-style:italic;text-shadow:0 4px 30px color-mix(in srgb,var(--accent) 45%,transparent)}
.hero-slide .btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent-dark));color:#fff;border:none;box-shadow:0 16px 38px -12px var(--accent),0 0 0 1px color-mix(in srgb,var(--accent) 30%,transparent)}
.hero-slide .btn-primary:hover{transform:translateY(-2px);box-shadow:0 22px 48px -12px var(--accent)}

.hero-slider-nav{display:flex;align-items:center;gap:16px;margin-top:30px}
.hero-dots{display:flex;gap:8px}
.hero-dot{width:9px;height:9px;border-radius:50%;background:rgba(255,255,255,.25);border:none;cursor:pointer;padding:0;transition:all .3s}
.hero-dot:hover{background:rgba(255,255,255,.45)}
.hero-dot.active{background:var(--accent,var(--teal));width:26px;border-radius:5px}
.hero-arrow{width:40px;height:40px;border-radius:50%;border:1px solid rgba(255,255,255,.18);background:rgba(255,255,255,.05);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .25s;flex-shrink:0}
.hero-arrow:hover{background:rgba(255,255,255,.14);border-color:rgba(255,255,255,.4)}
@media(max-width:640px){.hero-slider-nav{gap:12px;margin-top:22px}.hero-arrow{width:36px;height:36px}}
</style>

<!-- HERO -->
<section class="hero" id="hero">
  <canvas id="hero-canvas"></canvas>
  <div class="hero-gradient"></div>
  <div class="hero-glow" id="heroGlow"></div>
  <div class="hero-inner">
    <div class="hero-content">
      <div class="hero-slider" id="heroSlider">

        <!-- Slide 1 — Longevity -->
        <div class="hero-slide active">
          <div class="hero-badge"><span class="hero-badge-dot"></span><span class="hero-badge-text">Bioactive Peptide Science</span></div>
          <h1 class="hero-title">Science That Makes<br>You <em>Younger</em></h1>
          <p class="hero-desc">Pharmaceutical-grade bioactive peptides backed by peer-reviewed research — formulated for real, measurable results in skin, body, and longevity.</p>
          <?php echo $hero_stats_html; ?>
          <div class="hero-actions">
            <a href="<?php echo esc_url( alluvia_shop_url() ); ?>" class="btn-primary">Explore Products <i data-lucide="arrow-right" class="icon-sm"></i></a>
            <a href="#science" class="btn-ghost"><i data-lucide="flask-conical" class="icon-sm"></i> Our Science</a>
          </div>
        </div>

        <!-- Slide 2 — Medical / Recovery -->
        <div class="hero-slide">
          <div class="hero-badge"><span class="hero-badge-dot"></span><span class="hero-badge-text">Tissue Repair &amp; Recovery</span></div>
          <h1 class="hero-title">Repair. Recover.<br><em>Rebuild.</em></h1>
          <p class="hero-desc">BPC-157, TB-500 and recovery peptides engineered to accelerate healing of tendons, gut lining and soft tissue — the gold standard for repair.</p>
        </div>

        <!-- Slide 3 — Skincare -->
        <div class="hero-slide">
          <div class="hero-badge"><span class="hero-badge-dot"></span><span class="hero-badge-text">Dermal Renewal</span></div>
          <h1 class="hero-title">Radiance From<br><em>Within</em></h1>
          <p class="hero-desc">Copper peptides and matrikines like GHK-Cu that stimulate collagen synthesis, firmness and visible skin renewal at the dermal matrix.</p>
        </div>

        <!-- Slide 4 — Sports / Performance -->
        <div class="hero-slide">
          <div class="hero-badge"><span class="hero-badge-dot"></span><span class="hero-badge-text">Performance Engineered</span></div>
          <h1 class="hero-title">Peak Performance,<br><em>Engineered</em></h1>
          <p class="hero-desc">Growth-hormone secretagogues and recovery stacks for lean mass, deeper sleep and faster training adaptation — cleanly dosed.</p>
        </div>

        <!-- Slide 5 — Quality / COA -->
        <div class="hero-slide">
          <div class="hero-badge"><span class="hero-badge-dot"></span><span class="hero-badge-text">Verified Purity</span></div>
          <h1 class="hero-title">Proven Pure,<br><em>Every Batch</em></h1>
          <p class="hero-desc">HPLC ≥99% verified with a Certificate of Analysis on every lot, cold-chain shipped to preserve peptide integrity end to end.</p>
          <?php echo $hero_stats_html; ?>
          <div class="hero-actions">
            <a href="<?php echo esc_url( home_url('/coa-library/') ); ?>" class="btn-primary">View COA Library <i data-lucide="arrow-right" class="icon-sm"></i></a>
          </div>
        </div>

      </div>

      <div class="hero-slider-nav">
        <button class="hero-arrow" data-dir="-1" aria-label="Previous slide"><i data-lucide="chevron-left" style="width:18px;height:18px"></i></button>
        <div class="hero-dots" id="heroDots"></div>
        <button class="hero-arrow" data-dir="1" aria-label="Next slide"><i data-lucide="chevron-right" style="width:18px;height:18px"></i></button>
      </div>
    </div>

    <div class="hero-visual">

      <!-- Molecule visual — shown on slides 1 (Longevity) & 5 (Quality) -->
      <div class="hero-vslide is-molecule active" data-for="0,4">
        <div class="hero-molecule">
          <div class="molecule-ring"></div>
          <div class="molecule-ring"></div>
          <div class="molecule-ring"></div>
          <div class="molecule-core">
            <i data-lucide="dna" style="width:48px;height:48px;color:var(--teal);stroke-width:1.2"></i>
            <span class="molecule-core-label">Bioactive</span>
          </div>
        </div>
        <div class="hero-floating-cards">
          <div class="hero-card-float">
            <div class="float-card-icon"><i data-lucide="shield-check" class="icon-md"></i></div>
            <div><div class="float-card-title">Lab Certified</div><div class="float-card-sub">COA Available</div></div>
          </div>
          <div class="hero-card-float">
            <div class="float-card-icon"><i data-lucide="microscope" class="icon-md"></i></div>
            <div><div class="float-card-title">98%+ Purity</div><div class="float-card-sub">HPLC Verified</div></div>
          </div>
          <div class="hero-card-float">
            <div class="float-card-icon"><i data-lucide="package" class="icon-md"></i></div>
            <div><div class="float-card-title">Fast Shipping</div><div class="float-card-sub">Cold-Chain Packed</div></div>
          </div>
        </div>
      </div>

      <!-- Product showcases — synced to slides 2/3/4 (cards -> stats -> CTA) -->
      <div class="hero-vslide" data-for="1">
        <div class="hero-showcase">
          <?php alluvia_hero_card_grid( $hero_medical ); ?>
          <?php echo $hero_stats_html; ?>
          <a href="<?php echo esc_url( alluvia_cat_url('medical-peptides') ); ?>" class="btn-primary hero-showcase-cta">Shop Medical Peptides <i data-lucide="arrow-right" class="icon-sm"></i></a>
        </div>
      </div>
      <div class="hero-vslide" data-for="2">
        <div class="hero-showcase">
          <?php alluvia_hero_card_grid( $hero_skincare ); ?>
          <?php echo $hero_stats_html; ?>
          <a href="<?php echo esc_url( alluvia_cat_url('skincare-peptides') ); ?>" class="btn-primary hero-showcase-cta">Shop Skincare <i data-lucide="arrow-right" class="icon-sm"></i></a>
        </div>
      </div>
      <div class="hero-vslide" data-for="3">
        <div class="hero-showcase">
          <?php alluvia_hero_card_grid( $hero_sports ); ?>
          <?php echo $hero_stats_html; ?>
          <a href="<?php echo esc_url( alluvia_cat_url('sports-recovery') ); ?>" class="btn-primary hero-showcase-cta">Shop Sports &amp; Recovery <i data-lucide="arrow-right" class="icon-sm"></i></a>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- TRUST STRIP -->
<div class="trust-strip">
  <div class="trust-inner">
    <div class="trust-item"><i data-lucide="building-2" class="icon-md"></i><span class="trust-text">GMP Manufactured</span></div>
    <div class="trust-item"><i data-lucide="microscope" class="icon-md"></i><span class="trust-text">HPLC Tested</span></div>
    <div class="trust-item"><i data-lucide="file-check-2" class="icon-md"></i><span class="trust-text">COA on Every Batch</span></div>
    <div class="trust-item"><i data-lucide="leaf" class="icon-md"></i><span class="trust-text">No Fillers</span></div>
    <div class="trust-item"><i data-lucide="thermometer-snowflake" class="icon-md"></i><span class="trust-text">Cold-Chain Shipping</span></div>
    <div class="trust-item"><i data-lucide="pill" class="icon-md"></i><span class="trust-text">Pharmaceutical Grade</span></div>
  </div>
</div>


<!-- PROMISE — Quality · 24/7 Support · Fast Delivery -->
<section class="promise-section">
  <div class="container">
    <div class="promise-header reveal">
      <p class="section-label">The Alluvia Commitment</p>
      <h2 class="section-title">Built Around <em>You</em></h2>
      <p class="section-desc" style="margin:0 auto">Every order is backed by pharmaceutical-grade standards, round-the-clock support, and delivery that respects your time.</p>
    </div>
    <div class="promise-grid">

      <div class="promise-card reveal" style="--pc-color:#0eaf9f">
        <div class="promise-icon">
          <i data-lucide="shield-check" style="width:28px;height:28px;stroke-width:1.6"></i>
        </div>
        <h3 class="promise-title">Uncompromising Quality</h3>
        <p class="promise-desc">Every peptide is independently tested to &ge;98% purity via HPLC and mass spectrometry. No fillers, no proprietary blends &mdash; just verified pharmaceutical-grade bioactives with a Certificate of Analysis on every batch.</p>
        <span class="promise-badge"><i data-lucide="microscope" style="width:12px;height:12px"></i> COA on Every Batch</span>
      </div>

      <div class="promise-card reveal reveal-delay-1" style="--pc-color:#c6a253">
        <div class="promise-icon">
          <i data-lucide="headphones" style="width:28px;height:28px;stroke-width:1.6"></i>
        </div>
        <h3 class="promise-title">24/7 Customer Support</h3>
        <p class="promise-desc">Questions about dosing, reconstitution, or your order? Our science-literate support team is available around the clock &mdash; via live chat, email, and phone &mdash; so you're never left without an answer.</p>
        <span class="promise-badge"><i data-lucide="clock" style="width:12px;height:12px"></i> Always Available</span>
      </div>

      <div class="promise-card reveal reveal-delay-2" style="--pc-color:#ef8246">
        <div class="promise-icon">
          <i data-lucide="zap" style="width:28px;height:28px;stroke-width:1.6"></i>
        </div>
        <h3 class="promise-title">Fast, Cold-Chain Delivery</h3>
        <p class="promise-desc">Orders dispatch within 24 hours, cold-chain packed to maintain 2&ndash;8 &deg;C throughout transit. Tracked, insured, and discreetly shipped &mdash; your COA arrives digitally the moment your parcel ships.</p>
        <span class="promise-badge"><i data-lucide="package-check" style="width:12px;height:12px"></i> Ships in 24 Hours</span>
      </div>

    </div>
  </div>
</section>


<!-- ABOUT -->
<section class="about-section" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-visual reveal">
        <div class="about-image-wrap">
          <div class="dna-animation" id="dna-anim">
            <div class="dna-col dna-col-l"></div>
            <div class="dna-col dna-col-r"></div>
          </div>
        </div>
        <div class="about-accent-card">
          <div class="about-accent-num">8</div>
          <div class="about-accent-text">Peptide Categories</div>
        </div>
      </div>
      <div class="about-content">
        <div class="reveal">
          <p class="section-label">Our Story</p>
          <h2 class="section-title">Built on <em>Biology</em>,<br>Delivered with <span class="gold">Precision</span></h2>
        </div>
        <p class="section-desc reveal reveal-delay-1">
          Alluvia Peptides was founded on a simple belief: your body already knows how to heal,
          regenerate, and perform — it just needs the right molecular signals. We deliver the
          world's most studied bioactive peptides directly to you, with zero compromise on quality.
        </p>
        <ul class="about-list reveal reveal-delay-2">
          <li><span class="check-wrap"><i data-lucide="check" style="width:12px;height:12px;stroke-width:3"></i></span>Every product is independently tested with a Certificate of Analysis</li>
          <li><span class="check-wrap"><i data-lucide="check" style="width:12px;height:12px;stroke-width:3"></i></span>Formulated by biochemists, not marketers — doses that actually work</li>
          <li><span class="check-wrap"><i data-lucide="check" style="width:12px;height:12px;stroke-width:3"></i></span>Transparent sourcing with full supply chain traceability</li>
          <li><span class="check-wrap"><i data-lucide="check" style="width:12px;height:12px;stroke-width:3"></i></span>Cold-chain preserved and shipped to maintain structural integrity</li>
        </ul>
        <div class="reveal reveal-delay-3">
          <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn-primary" style="background:var(--navy);color:var(--white);display:inline-flex;">
            Read Our Story
            <i data-lucide="arrow-right" class="icon-sm"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- CATEGORIES -->
<section class="categories-section" id="categories">
  <div class="container">
    <div class="categories-header">
      <p class="section-label">What We Offer</p>
      <h2 class="section-title">Nine Pathways to<br><em>Peak Performance</em></h2>
      <p class="section-desc">From cellular repair to hormonal balance — Alluvia covers every dimension of human optimisation with purpose-built peptide formulations.</p>
    </div>
    <div class="categories-grid">

      <a href="<?php echo esc_url( alluvia_cat_url( 'medical-peptides' ) ); ?>" class="cat-card reveal" style="--cat-color:#0eaf9f;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><rect x="26" y="8" width="12" height="48" rx="4" fill="currentColor" fill-opacity="0.1" stroke="currentColor" stroke-width="2"/><rect x="8" y="26" width="48" height="12" rx="4" fill="currentColor" fill-opacity="0.1" stroke="currentColor" stroke-width="2"/><circle cx="32" cy="11.5" r="4" fill="currentColor"/><circle cx="32" cy="52.5" r="4" fill="currentColor"/><circle cx="11.5" cy="32" r="4" fill="currentColor"/><circle cx="52.5" cy="32" r="4" fill="currentColor"/><circle cx="32" cy="32" r="7" fill="currentColor" fill-opacity="0.15"/><circle cx="32" cy="32" r="3.5" fill="currentColor"/></svg></div>
        <h3 class="cat-name">Medical Peptides</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'skincare-peptides' ) ); ?>" class="cat-card reveal reveal-delay-1" style="--cat-color:#c6a253;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path d="M 8 20 C 18 14 26 26 40 20 C 48 16 54 20 56 20" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/><path d="M 8 32 C 18 26 26 38 40 32 C 48 28 54 32 56 32" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none" stroke-opacity=".75"/><path d="M 8 44 C 18 38 26 50 40 44 C 48 40 54 44 56 44" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none" stroke-opacity=".5"/><circle cx="30" cy="12" r="4" fill="currentColor"/><line x1="30" y1="16" x2="30" y2="20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="30" cy="23" r="3" fill="currentColor" fill-opacity=".7"/><line x1="30" y1="26" x2="30" y2="32" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="30" cy="35" r="2.5" fill="currentColor" fill-opacity=".5"/><line x1="30" y1="37.5" x2="30" y2="43" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-dasharray="2.5 2"/><circle cx="30" cy="46" r="2" fill="currentColor" fill-opacity=".3"/></svg></div>
        <h3 class="cat-name">Skincare Peptides</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'collagen-peptides' ) ); ?>" class="cat-card reveal reveal-delay-2" style="--cat-color:#6aa6c6;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path d="M 28 6 C 28 14 44 14 44 22 C 44 30 28 30 28 38 C 28 46 44 46 44 54 C 44 60 36 62 32 58" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/><path d="M 36 10 C 36 18 20 18 20 26 C 20 34 36 34 36 42 C 36 50 20 50 20 58" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-opacity=".65"/><path d="M 32 8 C 32 16 46 20 44 28 C 42 36 26 36 26 44 C 26 52 40 52 38 58" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-opacity=".35"/><circle cx="36" cy="22" r="3" fill="currentColor"/><circle cx="28" cy="38" r="2.5" fill="currentColor" fill-opacity=".7"/><circle cx="36" cy="46" r="2" fill="currentColor" fill-opacity=".5"/></svg></div>
        <h3 class="cat-name">Collagen Peptides</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'sports-recovery' ) ); ?>" class="cat-card reveal reveal-delay-3" style="--cat-color:#d4663c;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><polygon points="32,5 54,18 54,43 32,56 10,43 10,18" stroke="currentColor" stroke-width="2" fill="currentColor" fill-opacity="0.07"/><path d="M 37 14 L 26 34 L 33 34 L 27 50 L 42 28 L 35 28 Z" fill="currentColor" stroke="none"/><circle cx="32" cy="5" r="3" fill="currentColor"/><circle cx="54" cy="18" r="3" fill="currentColor" fill-opacity=".5"/><circle cx="10" cy="43" r="3" fill="currentColor" fill-opacity=".5"/></svg></div>
        <h3 class="cat-name">Sports &amp; Recovery</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'weight-loss-metabolic' ) ); ?>" class="cat-card reveal reveal-delay-4" style="--cat-color:#8a60c1;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path d="M 32 10 A 22 22 0 1 1 54 32" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/><path d="M 47 22 L 54 32 L 44 34" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/><circle cx="32" cy="32" r="8" stroke="currentColor" stroke-width="1.5" fill="currentColor" fill-opacity="0.08"/><circle cx="32" cy="26" r="3" fill="currentColor"/><circle cx="37.2" cy="34.5" r="3" fill="currentColor" fill-opacity=".7"/><circle cx="26.8" cy="34.5" r="3" fill="currentColor" fill-opacity=".7"/><line x1="32" y1="29" x2="35.5" y2="32.5" stroke="currentColor" stroke-width="1.5"/><line x1="32" y1="29" x2="28.5" y2="32.5" stroke="currentColor" stroke-width="1.5"/><line x1="35" y1="34.5" x2="29" y2="34.5" stroke="currentColor" stroke-width="1.5"/></svg></div>
        <h3 class="cat-name">Weight-Loss &amp; Metabolic</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'hormone-anti-aging' ) ); ?>" class="cat-card reveal reveal-delay-5" style="--cat-color:#c6a253;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path d="M 14 8 L 50 8 L 34 30 L 50 56 L 14 56 L 30 30 Z" stroke="currentColor" stroke-width="2" fill="currentColor" fill-opacity="0.07" stroke-linejoin="round"/><circle cx="32" cy="31" r="3.5" fill="currentColor"/><path d="M 23 15 Q 32 19 41 15" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round"/><path d="M 21 22 Q 32 26 43 22" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-opacity=".7"/><path d="M 21 40 Q 32 44 43 40" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-opacity=".7"/><path d="M 23 48 Q 32 52 41 48" stroke="currentColor" stroke-width="1.8" fill="none" stroke-linecap="round"/></svg></div>
        <h3 class="cat-name">Hormone &amp; Anti-Aging</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'hair-growth-peptides' ) ); ?>" class="cat-card reveal reveal-delay-6" style="--cat-color:#58b488;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><ellipse cx="32" cy="54" rx="16" ry="7" stroke="currentColor" stroke-width="2" fill="currentColor" fill-opacity="0.1"/><circle cx="32" cy="54" r="3" fill="currentColor" fill-opacity=".5"/><path d="M 22 54 C 22 46 15 38 19 26 C 21 18 25 14 24 9" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-opacity=".5"/><path d="M 32 54 C 32 44 25 36 28 24 C 30 15 33 10 32 7" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round"/><path d="M 42 54 C 42 46 49 38 45 26 C 43 18 39 14 40 9" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-opacity=".5"/><circle cx="30" cy="34" r="3" fill="currentColor"/><circle cx="31" cy="20" r="2.5" fill="currentColor" fill-opacity=".7"/><circle cx="32" cy="10" r="2" fill="currentColor" fill-opacity=".5"/></svg></div>
        <h3 class="cat-name">Hair Growth Peptides</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'research-peptides' ) ); ?>" class="cat-card reveal reveal-delay-7" style="--cat-color:#0eaf9f;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><path d="M 24 8 L 24 25 L 10 48 C 8 53 12 57 17 57 L 47 57 C 52 57 56 53 54 48 L 40 25 L 40 8 Z" stroke="currentColor" stroke-width="2" fill="currentColor" fill-opacity="0.07"/><line x1="20" y1="8" x2="44" y2="8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><circle cx="25" cy="47" r="3.5" fill="currentColor" fill-opacity=".6"/><line x1="28.5" y1="47" x2="35.5" y2="47" stroke="currentColor" stroke-width="1.8"/><circle cx="39" cy="47" r="3.5" fill="currentColor" fill-opacity=".6"/><circle cx="28" cy="38" r="2.5" fill="currentColor" fill-opacity=".75"/><line x1="30" y1="36.5" x2="34" y2="31" stroke="currentColor" stroke-width="1.5" stroke-opacity=".5"/><circle cx="36" cy="29" r="3" fill="currentColor"/><line x1="35" y1="26.5" x2="31" y2="20" stroke="currentColor" stroke-width="1.5" stroke-opacity=".4"/><circle cx="30" cy="17" r="2" fill="currentColor" fill-opacity=".5"/></svg></div>
        <h3 class="cat-name">Research Peptides</h3>
      </a>

      <a href="<?php echo esc_url( alluvia_cat_url( 'lab-supplies-accessories' ) ); ?>" class="cat-card reveal" style="--cat-color:#5b7186;">
        <div class="cat-icon-wrap"><svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="28"><rect x="24" y="16" width="16" height="40" rx="4" fill="currentColor" fill-opacity="0.1" stroke="currentColor" stroke-width="2"/><rect x="26" y="9" width="12" height="8" rx="2" fill="currentColor"/><line x1="24" y1="40" x2="40" y2="40" stroke="currentColor" stroke-width="2" stroke-opacity="0.6"/><line x1="24" y1="47" x2="40" y2="47" stroke="currentColor" stroke-width="1.5" stroke-opacity="0.4"/><path d="M 50 14 C 50 14 46 20 46 23.5 A 4 4 0 1 0 54 23.5 C 54 20 50 14 50 14 Z" fill="currentColor" fill-opacity="0.75"/></svg></div>
        <h3 class="cat-name">Lab Supplies &amp; Accessories</h3>
      </a>

    </div>
  </div>
</section>


<!-- HOW IT WORKS -->
<section class="hiw-section" id="how-it-works">
  <div class="container">
    <div class="hiw-header reveal">
      <p class="section-label">From Lab to Your Door</p>
      <h2 class="section-title">How Every Peptide<br>Is <em>Built &amp; Verified</em></h2>
      <p class="section-desc">Pharmaceutical-grade quality is a process, not a claim. Here is exactly what happens before any Alluvia peptide reaches you.</p>
    </div>
    <div class="hiw-steps">

      <div class="hiw-step reveal">
        <div class="hiw-step-top">
          <div class="hiw-icon-ring">
            <i data-lucide="flask-conical" style="width:44px;height:44px;stroke-width:1.3"></i>
          </div>
          <span class="hiw-step-num">01</span>
          <i data-lucide="chevron-right" class="hiw-arrow" style="width:22px;height:22px;stroke-width:2"></i>
        </div>
        <h3 class="hiw-step-title">Solid-Phase Synthesis</h3>
        <p class="hiw-step-desc">Peptides are assembled amino acid by amino acid via cGMP-compliant SPPS, guaranteeing exact sequence fidelity and &gt;96% crude purity before purification.</p>
      </div>

      <div class="hiw-step reveal reveal-delay-1">
        <div class="hiw-step-top">
          <div class="hiw-icon-ring">
            <i data-lucide="microscope" style="width:44px;height:44px;stroke-width:1.3"></i>
          </div>
          <span class="hiw-step-num">02</span>
          <i data-lucide="chevron-right" class="hiw-arrow" style="width:22px;height:22px;stroke-width:2"></i>
        </div>
        <h3 class="hiw-step-title">HPLC &amp; Mass-Spec Testing</h3>
        <p class="hiw-step-desc">Every batch is independently tested by an ISO-accredited third-party lab — HPLC purity, mass spectrometry identity confirmation, and microbiological screening before release.</p>
      </div>

      <div class="hiw-step reveal reveal-delay-2">
        <div class="hiw-step-top">
          <div class="hiw-icon-ring">
            <i data-lucide="thermometer-snowflake" style="width:44px;height:44px;stroke-width:1.3"></i>
          </div>
          <span class="hiw-step-num">03</span>
          <i data-lucide="chevron-right" class="hiw-arrow" style="width:22px;height:22px;stroke-width:2"></i>
        </div>
        <h3 class="hiw-step-title">Cold-Chain Packaging</h3>
        <p class="hiw-step-desc">Lyophilised peptides are sealed under inert atmosphere in amber vials, placed inside insulated cold-packs, and packed to maintain 2–8 °C throughout transit.</p>
      </div>

      <div class="hiw-step reveal reveal-delay-3">
        <div class="hiw-step-top">
          <div class="hiw-icon-ring">
            <i data-lucide="package-check" style="width:44px;height:44px;stroke-width:1.3"></i>
          </div>
          <span class="hiw-step-num">04</span>
        </div>
        <h3 class="hiw-step-title">Delivery to Your Lab</h3>
        <p class="hiw-step-desc">Discreet, tracked, and insured — orders dispatch within 24 hours. Your Certificate of Analysis arrives digitally the moment your order ships.</p>
      </div>

    </div>
  </div>
</section>


<!-- SCIENCE -->
<section class="science-section" id="science">
  <div class="container">
    <div class="science-grid">
      <div>
        <div class="reveal">
          <p class="section-label">Our Process</p>
          <h2 class="section-title">Precision at Every<br><em>Step</em></h2>
          <p class="section-desc">From synthesis to your door, Alluvia maintains a rigorous quality chain that no shortcut can bypass.</p>
        </div>
        <div class="process-steps">
          <div class="process-step reveal">
            <div class="process-step-line"><div class="process-step-num">01</div><div class="process-connector"></div></div>
            <div class="process-content"><h4 class="process-title">Synthesis &amp; Sourcing</h4><p class="process-text">Peptides are synthesised via solid-phase peptide synthesis (SPPS) in cGMP-compliant facilities, ensuring sequence accuracy and minimal impurities.</p></div>
          </div>
          <div class="process-step reveal reveal-delay-1">
            <div class="process-step-line"><div class="process-step-num">02</div><div class="process-connector"></div></div>
            <div class="process-content"><h4 class="process-title">Independent Laboratory Testing</h4><p class="process-text">Every batch is tested by a third-party ISO-accredited lab using HPLC, mass spectrometry, and microbiological screening before release.</p></div>
          </div>
          <div class="process-step reveal reveal-delay-2">
            <div class="process-step-line"><div class="process-step-num">03</div><div class="process-connector"></div></div>
            <div class="process-content"><h4 class="process-title">Cold-Chain Preservation</h4><p class="process-text">Lyophilised peptides are sealed under inert atmosphere and shipped in temperature-controlled packaging to preserve full bioactivity.</p></div>
          </div>
          <div class="process-step reveal reveal-delay-3">
            <div class="process-step-line"><div class="process-step-num">04</div><div class="process-connector"></div></div>
            <div class="process-content"><h4 class="process-title">Transparent Documentation</h4><p class="process-text">Certificate of Analysis and full batch records available for every product — no hidden formulas, no proprietary blends.</p></div>
          </div>
        </div>
      </div>
      <div class="science-certs">
        <div class="cert-card reveal"><i data-lucide="building-2" class="icon-xl cert-icon"></i><div class="cert-title">GMP Certified</div><p class="cert-text">Manufactured in Good Manufacturing Practice certified facilities to pharmaceutical standards.</p></div>
        <div class="cert-card reveal reveal-delay-1"><i data-lucide="microscope" class="icon-xl cert-icon"></i><div class="cert-title">HPLC Verified</div><p class="cert-text">High-Performance Liquid Chromatography confirms peptide sequence, purity, and concentration on every batch.</p></div>
        <div class="cert-card reveal reveal-delay-2"><i data-lucide="file-check-2" class="icon-xl cert-icon"></i><div class="cert-title">Full COA</div><p class="cert-text">Certificate of Analysis with every order — including mass spec data, purity percentage, and lot number.</p></div>
        <div class="cert-card reveal reveal-delay-3"><i data-lucide="thermometer-snowflake" class="icon-xl cert-icon"></i><div class="cert-title">Cold-Chain Intact</div><p class="cert-text">Temperature-monitored shipping ensures peptides arrive as potent as they left the lab.</p></div>
      </div>
    </div>
  </div>
</section>


<!-- TESTIMONIALS -->
<section class="testimonials-section" id="testimonials">
  <div class="container">
    <div class="testimonials-header">
      <p class="section-label">Real Results</p>
      <h2 class="section-title">What Our Customers<br><em>Are Saying</em></h2>
      <p class="section-desc">From biohackers to dermatologists — Alluvia is trusted by people who demand results they can measure.</p>
    </div>
    <div class="testimonials-grid">
      <article class="testi-card reveal">
        <div class="testi-stars">
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
        </div>
        <span class="quote-open">"</span>
        <p class="testi-quote">After 8 weeks on BPC-157 I saw measurable improvement in my shoulder tendon pain that I had been managing for two years. The COA gave me real confidence in the product.</p>
        <footer class="testi-author">
          <div class="testi-avatar">MK</div>
          <div><div class="testi-name">Marcus K.</div><div class="testi-meta">Strength &amp; Conditioning Coach</div></div>
          <span class="testi-product">Medical</span>
        </footer>
      </article>
      <article class="testi-card reveal reveal-delay-1">
        <div class="testi-stars">
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
        </div>
        <span class="quote-open">"</span>
        <p class="testi-quote">The skincare peptides are the real deal. Matrixyl and GHK-Cu together genuinely changed the texture and firmness of my skin within 6 weeks. I'm completely hooked.</p>
        <footer class="testi-author">
          <div class="testi-avatar">SP</div>
          <div><div class="testi-name">Sophie P.</div><div class="testi-meta">Aesthetics Practitioner</div></div>
          <span class="testi-product">Skincare</span>
        </footer>
      </article>
      <article class="testi-card reveal reveal-delay-2">
        <div class="testi-stars">
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
          <i data-lucide="star" style="width:15px;height:15px;fill:var(--gold);stroke:none"></i>
        </div>
        <span class="quote-open">"</span>
        <p class="testi-quote">I use the Ipamorelin/CJC stack for sleep and recovery. Delivery was fast, product arrived cold, and the results on deep sleep quality were immediate. Top tier.</p>
        <footer class="testi-author">
          <div class="testi-avatar">RJ</div>
          <div><div class="testi-name">Ryan J.</div><div class="testi-meta">Longevity Researcher</div></div>
          <span class="testi-product">Anti-Aging</span>
        </footer>
      </article>
    </div>
  </div>
</section>


<!-- CTA -->
<section class="cta-section" id="contact-cta">
  <div class="cta-inner">
    <p class="section-label">Join the Community</p>
    <h2 class="section-title">Start Your<br><span class="gold">Peptide Journey</span></h2>
    <p class="section-desc">Subscribe for early access to new peptides, exclusive science content, and first-time customer offers.</p>
    <form class="email-form" onsubmit="handleSub(event)">
      <input type="email" placeholder="Your email address" required>
      <button type="submit" id="sub-btn">
        <i data-lucide="send" style="width:14px;height:14px"></i>
        Join Now
      </button>
    </form>
    <p class="cta-note">
      <i data-lucide="lock" style="width:13px;height:13px;color:rgba(255,255,255,.3)"></i>
      No spam, ever. Unsubscribe anytime. We respect your privacy.
    </p>
  </div>
</section>


<!-- FOOTER -->
<?php get_template_part('partials/footer-alluvia'); ?>

<script>
// Init Lucide
lucide.createIcons();

// Particle Canvas
(function(){
  var c=document.getElementById('hero-canvas');if(!c)return;
  var ctx=c.getContext('2d'),P=[],W,H;
  function resize(){W=c.width=c.offsetWidth;H=c.height=c.offsetHeight;}
  resize();window.addEventListener('resize',resize);
  function Pt(){this.x=Math.random()*W;this.y=Math.random()*H;this.r=Math.random()*1.4+.3;this.vx=(Math.random()-.5)*.3;this.vy=(Math.random()-.5)*.3;this.a=Math.random()*.4+.1;this.col=Math.random()>.6?'#0eaf9f':'#c6a253';}
  Pt.prototype.u=function(){this.x+=this.vx;this.y+=this.vy;if(this.x<-5)this.x=W+5;if(this.x>W+5)this.x=-5;if(this.y<-5)this.y=H+5;if(this.y>H+5)this.y=-5;};
  for(var i=0;i<80;i++)P.push(new Pt());
  function draw(){
    ctx.clearRect(0,0,W,H);
    for(var a=0;a<P.length;a++)for(var b=a+1;b<P.length;b++){var dx=P[a].x-P[b].x,dy=P[a].y-P[b].y,d=Math.sqrt(dx*dx+dy*dy);if(d<100){ctx.beginPath();ctx.strokeStyle='rgba(14,175,159,'+(0.07*(1-d/100))+')';ctx.lineWidth=.5;ctx.moveTo(P[a].x,P[a].y);ctx.lineTo(P[b].x,P[b].y);ctx.stroke();}}
    P.forEach(function(p){p.u();ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);ctx.fillStyle=p.col;ctx.globalAlpha=p.a;ctx.fill();ctx.globalAlpha=1;});
    requestAnimationFrame(draw);
  }
  draw();
})();

// Typewriter
(function(){
  var el=document.querySelector('.hero-typewriter');if(!el)return;
  var words=['Younger','Stronger','Healthier','Vibrant','Radiant'],idx=0,ci=0,del=false,delay=100;
  function t(){var w=words[idx];if(!del){el.textContent=w.substring(0,ci+1);ci++;if(ci===w.length){del=true;delay=2200;}else delay=90;}
  else{el.textContent=w.substring(0,ci-1);ci--;if(ci===0){del=false;idx=(idx+1)%words.length;delay=300;}else delay=50;}
  setTimeout(t,delay);}
  setTimeout(t,1000);
})();

// Hero slider (5 slides, autoplay, dots + arrows, pause on hover)
(function(){
  var slides=[].slice.call(document.querySelectorAll('.hero-slide'));
  var dotsWrap=document.getElementById('heroDots');
  if(slides.length<2||!dotsWrap)return;
  var i=0,timer;
  slides.forEach(function(_,idx){
    var b=document.createElement('button');
    b.className='hero-dot'+(idx===0?' active':'');
    b.setAttribute('aria-label','Go to slide '+(idx+1));
    b.addEventListener('click',function(){go(idx);reset();});
    dotsWrap.appendChild(b);
  });
  var dots=[].slice.call(dotsWrap.children);
  var accents=['#11b6a3','#1fb074','#e76f93','#ef8246','#d4b566'];
  var glows=['rgba(17,182,163,.28)','rgba(31,176,116,.26)','rgba(231,111,147,.24)','rgba(239,130,70,.24)','rgba(212,181,102,.26)'];
  var glowEl=document.getElementById('heroGlow');
  var navEl=document.querySelector('.hero-slider-nav');
  function applyAccent(){
    if(glowEl)glowEl.style.setProperty('--hero-accent',glows[i%glows.length]);
    if(navEl)navEl.style.setProperty('--accent',accents[i%accents.length]);
  }
  var vslides=[].slice.call(document.querySelectorAll('.hero-vslide'));
  function syncVisual(){
    vslides.forEach(function(v){
      var f=(v.getAttribute('data-for')||'').split(',');
      v.classList.toggle('active', f.indexOf(String(i))>-1);
    });
  }
  function go(n){
    slides[i].classList.remove('active');dots[i].classList.remove('active');
    i=(n+slides.length)%slides.length;
    slides[i].classList.add('active');dots[i].classList.add('active');
    applyAccent();syncVisual();
    if(window.lucide&&lucide.createIcons)lucide.createIcons();
  }
  applyAccent();syncVisual();
  function next(){go(i+1);}
  document.querySelectorAll('.hero-arrow').forEach(function(a){
    a.addEventListener('click',function(){go(i+parseInt(a.getAttribute('data-dir'),10));reset();});
  });
  function reset(){clearInterval(timer);timer=setInterval(next,6000);}
  reset();
  var slider=document.getElementById('heroSlider');
  if(slider){slider.addEventListener('mouseenter',function(){clearInterval(timer);});slider.addEventListener('mouseleave',reset);}
})();

// DNA Rungs
(function(){
  var c=document.getElementById('dna-anim');if(!c)return;
  var tops=[22,42,62,82,102,122,142,162,182,202,222];
  var widths=[56,74,68,80,60,76,64,78,58,72,66];
  for(var i=0;i<tops.length;i++){var r=document.createElement('div');r.className='dna-rung';r.style.top=tops[i]+'px';r.style.width=widths[i]+'px';r.style.left='calc(50% - '+(widths[i]/2)+'px)';r.style.animationDelay=(i*.2)+'s';c.appendChild(r);}
  // re-init lucide for new elements - not needed here
})();

// Scroll Reveal
var ro=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){e.target.classList.add('reveal-done');ro.unobserve(e.target);}});},{threshold:.1,rootMargin:'0px 0px -30px 0px'});
document.querySelectorAll('.reveal,.cat-card,.testi-card,.cert-card,.stats-item').forEach(function(el){ro.observe(el);});

// Counters
var co=new IntersectionObserver(function(entries){entries.forEach(function(e){if(e.isIntersecting){var el=e.target,t=parseInt(el.getAttribute('data-count')),s=el.getAttribute('data-suffix')||'',st=null;function step(ts){if(!st)st=ts;var p=Math.min((ts-st)/1600,1),v=Math.floor((1-Math.pow(1-p,3))*t);el.textContent=v+s;if(p<1)requestAnimationFrame(step);else el.textContent=t+s;}requestAnimationFrame(step);co.unobserve(el);}});},{threshold:.5});
document.querySelectorAll('[data-count]').forEach(function(el){co.observe(el);});

// Form
function handleSub(e){e.preventDefault();var b=document.getElementById('sub-btn');var input=e.target.querySelector('input[type=email]');var reset=function(){b.innerHTML='<i data-lucide="send" style="width:14px;height:14px"></i> Join Now';lucide.createIcons();};var cfg=window.alluviaAjax||{};var body=new URLSearchParams({action:'alluvia_subscribe',nonce:cfg.sub_nonce||'',email:input.value});fetch(cfg.ajax_url||'/wp-admin/admin-ajax.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:body}).then(function(r){return r.json();}).then(function(res){var msg=(res&&res.data&&res.data.message)||'Subscribed!';b.innerHTML='<i data-lucide="check" style="width:14px;height:14px"></i> '+msg;lucide.createIcons();if(res&&res.success){input.value='';}setTimeout(reset,3500);}).catch(function(){reset();});}

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(function(a){a.addEventListener('click',function(e){var t=document.querySelector(this.getAttribute('href'));if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});}});});
</script>
<?php get_footer( 'alluvia' ); ?>
