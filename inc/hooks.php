<?php
/**
 * All add_action() and add_filter() registrations that do not belong to a
 * specific feature file.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function uppa_base_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'uppa_base_content_width', 1200 );
}
add_action( 'after_setup_theme', 'uppa_base_content_width', 0 );

/**
 * Adds custom classes to the body element.
 *
 * @param  array $classes Existing body classes.
 * @return array
 */
function uppa_base_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter( 'body_class', 'uppa_base_body_classes' );

/**
 * Removes the default excerpt "more" string and replaces it with a link.
 *
 * @return string
 */
function uppa_base_excerpt_more() {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'uppa_base_excerpt_more' );
