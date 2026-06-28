<?php
/**
 * Accessibility helpers: skip links, ARIA attributes, and keyboard focus fixes.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs the skip-to-content link at the top of every page.
 *
 * Hooked via hooks.php or called directly in header.php via the
 * template-parts/global/skip-link partial.
 */
function uppa_base_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#primary">' . esc_html__( 'Skip to content', 'uppa-base' ) . '</a>';
}
