<?php
/**
 * Alluvia custom header — bypasses Omega's default header/nav completely.
 * Used by all Alluvia page templates via get_header('alluvia').
 *
 * @package Shopping
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '—', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'alluvia-site' ); ?>>
<?php wp_body_open(); ?>
