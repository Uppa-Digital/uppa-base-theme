<?php
/**
 * Accessibility helpers: skip link, screen-reader-text inline styles, ARIA landmark helpers.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Skip link
// =============================================================================

/**
 * Output the skip-link template part immediately after <body> opens.
 *
 * Hooked to wp_body_open at priority 1 so it appears before any other output,
 * ensuring keyboard and screen-reader users can bypass repeated navigation.
 * Child themes may remove this and supply their own implementation:
 *   remove_action( 'wp_body_open', 'uppa_base_output_skip_link', 1 );
 *
 * @since 1.0.0
 * @hook  wp_body_open
 */
function uppa_base_output_skip_link() {
	get_template_part( 'template-parts/global/skip-link' );
}
add_action( 'wp_body_open', 'uppa_base_output_skip_link', 1 );

// =============================================================================
// Screen-reader-text inline styles
// =============================================================================

/**
 * Print minimal inline CSS for the .screen-reader-text utility class.
 *
 * The compiled stylesheet (main.min.css) contains the full ruleset, but
 * outputting a condensed version inline here ensures the skip link is
 * visually hidden even before the external stylesheet loads — preventing
 * a flash of unstyled, visible text at the top of the page.
 *
 * Child themes may remove this if they load a stylesheet that already
 * covers .screen-reader-text before wp_body_open fires:
 *   remove_action( 'wp_head', 'uppa_base_screen_reader_text_styles' );
 *
 * @since 1.0.0
 * @hook  wp_head
 */
function uppa_base_screen_reader_text_styles() {
	?>
	<style id="uppa-screen-reader-text">
	.screen-reader-text{clip:rect(1px,1px,1px,1px);clip-path:inset(50%);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px;word-wrap:normal!important}
	.screen-reader-text:focus{background-color:#fff;clip:auto!important;clip-path:none;color:#1a202c;display:block;font-size:.875rem;font-weight:700;height:auto;left:8px;top:8px;padding:.5rem 1rem;text-decoration:none;width:auto;z-index:100000;outline:2px solid #e8500a;outline-offset:3px}
	</style>
	<?php
}
add_action( 'wp_head', 'uppa_base_screen_reader_text_styles' );

// =============================================================================
// ARIA landmark role helpers
// =============================================================================

/**
 * Return the correct ARIA role attribute string for the site header landmark.
 *
 * Usage in templates: echo uppa_aria_header();
 * HTML5 <header> inside <body> already maps to the "banner" landmark, but
 * the explicit role="banner" attribute improves compatibility with older
 * assistive technologies.
 *
 * @since  1.0.0
 * @return string Safe, pre-escaped attribute string.
 */
function uppa_aria_header() {
	return 'role="banner"';
}

/**
 * Return the correct ARIA role attribute string for the main content landmark.
 *
 * Usage in templates: echo uppa_aria_main();
 * HTML5 <main> carries an implicit role="main", but the explicit attribute
 * broadens screen-reader support.
 *
 * @since  1.0.0
 * @return string Safe, pre-escaped attribute string.
 */
function uppa_aria_main() {
	return 'role="main"';
}

/**
 * Return the correct ARIA role attribute string for the site footer landmark.
 *
 * Usage in templates: echo uppa_aria_footer();
 * HTML5 <footer> inside <body> maps to "contentinfo". The explicit attribute
 * is a belt-and-suspenders measure for AT compatibility.
 *
 * @since  1.0.0
 * @return string Safe, pre-escaped attribute string.
 */
function uppa_aria_footer() {
	return 'role="contentinfo"';
}
