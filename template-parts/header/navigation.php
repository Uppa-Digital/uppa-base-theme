<?php
/**
 * Template part: primary site navigation.
 *
 * Outputs a <nav> landmark containing:
 *   1. A hamburger toggle <button> (controlled by assets/js/src/navigation.js
 *      via aria-expanded / aria-controls).
 *   2. wp_nav_menu() for the 'primary' location, using UPPA_Base_Nav_Walker
 *      (defined in inc/nav-walkers.php).
 *
 * When no menu is assigned to the 'primary' location, wp_nav_menu() outputs
 * nothing and the <nav> renders empty — no broken markup.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'uppa-base' ); ?>">

	<button
		class="menu-toggle"
		aria-controls="primary-menu"
		aria-expanded="false"
		aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'uppa-base' ); ?>"
	>
		<span class="menu-toggle__bar" aria-hidden="true"></span>
		<span class="menu-toggle__bar" aria-hidden="true"></span>
		<span class="menu-toggle__bar" aria-hidden="true"></span>
		<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'uppa-base' ); ?></span>
	</button>

	<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'menu_id'         => 'primary-menu',
			'menu_class'      => 'nav-menu',
			'container'       => false,
			'depth'           => 3,
			'fallback_cb'     => false,
			'walker'          => new UPPA_Base_Nav_Walker(),
		)
	);
	?>

</nav><!-- #site-navigation -->
