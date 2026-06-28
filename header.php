<?php
/**
 * The header template.
 *
 * Outputs the document <head>, opens the page wrapper, fires all header
 * action hooks, and leaves the #content wrapper open for the calling template.
 *
 * Hook call-sites (see inc/hooks.php for callback definitions):
 *   uppa_before_header()  — before <header>
 *   uppa_header_open()    — first thing inside <header>
 *   uppa_after_branding() — after site-branding template part
 *   uppa_nav_primary()    — primary navigation position
 *   uppa_header_close()   — last thing inside <header>
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<?php get_template_part( 'template-parts/global/skip-link' ); ?>

	<?php uppa_before_header(); ?>

	<header id="masthead" class="site-header" role="banner">

		<?php uppa_header_open(); ?>

		<?php get_template_part( 'template-parts/header/site-branding' ); ?>

		<?php uppa_after_branding(); ?>

		<?php uppa_nav_primary(); ?>

		<?php uppa_header_close(); ?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
