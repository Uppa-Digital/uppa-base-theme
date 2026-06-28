<?php
/**
 * Template part: site branding (logo + site title + tagline).
 *
 * @package uppa-base
 * @since   1.0.0
 */
?>

<div class="site-branding">
	<?php
	the_custom_logo();

	if ( is_front_page() && is_home() ) :
		?>
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php
	else :
		?>
		<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php
	endif;

	$uppa_base_description = get_bloginfo( 'description', 'display' );
	if ( $uppa_base_description || is_customize_preview() ) :
		?>
		<p class="site-description"><?php echo $uppa_base_description; // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
		<?php
	endif;
	?>
</div>
