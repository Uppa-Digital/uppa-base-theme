<?php
/**
 * Template part: primary navigation.
 *
 * @package uppa-base
 * @since   1.0.0
 */
?>

<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'uppa-base' ); ?>">
	<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
		<?php esc_html_e( 'Menu', 'uppa-base' ); ?>
	</button>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'container'      => false,
			'walker'         => new UPPA_Base_Nav_Walker(),
		)
	);
	?>
</nav>
