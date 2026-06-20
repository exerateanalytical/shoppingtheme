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
<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon.svg' ); ?>" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://unpkg.com" crossorigin>
<link rel="dns-prefetch" href="https://unpkg.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
<?php wp_head(); ?>
<!-- Lucide icons: loaded deferred (non-render-blocking). The stub keeps any inline
     lucide.createIcons() calls safe until the library + DOM are ready, then we render once. -->
<script>window.lucide={createIcons:function(){}};</script>
<script defer src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script defer>document.addEventListener('DOMContentLoaded',function(){window.lucide&&window.lucide.createIcons&&window.lucide.createIcons();});</script>
</head>
<body <?php body_class( 'alluvia-site' ); ?>>
<?php wp_body_open(); ?>
