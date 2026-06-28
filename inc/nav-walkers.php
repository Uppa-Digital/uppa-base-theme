<?php
/**
 * Custom nav walkers for Bootstrap-compatible markup.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bootstrap-compatible navigation walker.
 *
 * Outputs nav items with Bootstrap 5 classes. Child themes can extend or
 * replace this class as needed.
 */
class UPPA_Base_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		// Placeholder — logic added by child theme or future iteration.
		parent::start_el( $output, $item, $depth, $args, $id );
	}
}
