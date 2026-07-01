<?php
/**
 * Custom navigation walker.
 *
 * Extends Walker_Nav_Menu to inject an accessible sub-menu toggle <button>
 * before each dropdown list. The button carries aria-expanded and is wired
 * by navigation.js to open/close the sub-menu on click or keyboard.
 *
 * Child themes may extend or replace this class:
 *   add_filter( 'wp_nav_menu_args', function( $args ) {
 *     $args['walker'] = new My_Custom_Walker();
 *     return $args;
 *   } );
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Accessible navigation walker.
 *
 * Adds a disclosure button before each sub-menu so keyboard and pointer users
 * can expand/collapse dropdowns without following the parent link.
 *
 * Markup produced for a top-level item with children:
 *   <li class="menu-item menu-item-has-children">
 *     <a href="...">Parent</a>
 *     <button class="sub-menu-toggle" aria-expanded="false" aria-label="Expand Parent submenu">
 *       <span aria-hidden="true">▾</span>
 *     </button>
 *     <ul class="sub-menu">…</ul>
 *   </li>
 */
class UPPA_Base_Nav_Walker extends Walker_Nav_Menu {

	/**
	 * Starts the list item output.
	 *
	 * @param string    $output Passed by reference.
	 * @param \WP_Post  $item   Menu item data object.
	 * @param int       $depth  Depth of menu item. Used for padding.
	 * @param \stdClass $args   Object of wp_nav_menu() arguments.
	 * @param int       $id     Current item ID.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = str_repeat( "\t", $depth );

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filters the CSS class(es) applied to a menu item's <li> element.
		 *
		 * @param string[]  $classes Array of CSS classes.
		 * @param \WP_Post  $item    Menu item data object.
		 * @param \stdClass $args    Object of wp_nav_menu() arguments.
		 * @param int       $depth   Depth of menu item.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID attribute applied to a menu item's <li> element.
		 *
		 * @param string    $menu_id Menu item ID.
		 * @param \WP_Post  $item    Menu item data object.
		 * @param \stdClass $args    Object of wp_nav_menu() arguments.
		 * @param int       $depth   Depth of menu item.
		 */
		$id_attr = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id_attr = $id_attr ? ' id="' . esc_attr( $id_attr ) . '"' : '';

		$output .= $indent . '<li' . $id_attr . $class_names . '>';

		$atts = array(
			'title'        => ! empty( $item->attr_title ) ? $item->attr_title : '',
			'target'       => ! empty( $item->target ) ? $item->target : '',
			'rel'          => ! empty( $item->xfn ) ? $item->xfn : '',
			'href'         => ! empty( $item->url ) ? $item->url : '',
			'aria-current' => $item->current ? 'page' : '',
		);

		// Add noopener when link opens in a new tab.
		if ( '_blank' === $atts['target'] ) {
			$atts['rel'] = 'noopener noreferrer' . ( $atts['rel'] ? ' ' . $atts['rel'] : '' );
		}

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @param array     $atts  The element's attributes.
		 * @param \WP_Post  $item  Menu item data object.
		 * @param \stdClass $args  Object of wp_nav_menu() arguments.
		 * @param int       $depth Depth of menu item.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( '' !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/class-walker-nav-menu.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @param string    $title The title of the current menu item.
		 * @param \WP_Post  $item  Menu item data object.
		 * @param \stdClass $args  Object of wp_nav_menu() arguments.
		 * @param int       $depth Depth of menu item.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output  = isset( $args->before ) ? $args->before : '';
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( isset( $args->link_before ) ? $args->link_before : '' ) . $title . ( isset( $args->link_after ) ? $args->link_after : '' );
		$item_output .= '</a>';

		// Inject sub-menu toggle button for items that have children.
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			$item_output .= sprintf(
				'<button class="sub-menu-toggle" aria-expanded="false" aria-label="%s"><span aria-hidden="true">&#9660;</span></button>',
				/* translators: %s: parent menu item title */
				esc_attr( sprintf( __( 'Expand %s submenu', 'uppa-base' ), $title ) )
			);
		}

		$item_output .= isset( $args->after ) ? $args->after : '';

		/**
		 * Filters a menu item's starting output.
		 *
		 * @param string    $item_output The menu item's starting HTML output.
		 * @param \WP_Post  $item        Menu item data object.
		 * @param int       $depth       Depth of menu item.
		 * @param \stdClass $args        Object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
