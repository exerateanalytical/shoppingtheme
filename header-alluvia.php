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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'alluvia-site' ); ?>>
<?php wp_body_open(); ?>
