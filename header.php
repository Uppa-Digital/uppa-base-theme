<?php
/**
 * The header template.
 *
 * Displays all of the <head> section and everything up until <div id="content">.
 *
 * @package uppa-base
 * @since   1.0.0
 */
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

	<header id="masthead" class="site-header">
		<?php get_template_part( 'template-parts/header/site-branding' ); ?>
		<?php get_template_part( 'template-parts/header/navigation' ); ?>
	</header>

	<div id="content" class="site-content">
