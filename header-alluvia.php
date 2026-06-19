<?php
/**
 * Alluvia site header. Loaded by every template via get_header('alluvia').
 * Self-contained — the theme is standalone (no parent framework).
 *
 * @package Shopping
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
/* Fonts + Lucide are enqueued in functions.php (alluvia_global_assets) so they
   are version-controlled and not render-blocking. preconnect stays here as an
   early resource hint for the Google Fonts host. */
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'alluvia-site' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'alluvia' ); ?></a>
