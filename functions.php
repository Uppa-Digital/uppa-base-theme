<?php
/**
 * UPPA Base functions and definitions.
 *
 * Loader only — no logic lives here directly. All feature files are required
 * from the /inc directory. Constants are defined here so every inc/ file can
 * reference them without re-computing the theme paths.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'UPPA_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'UPPA_DIR',     get_template_directory() );
define( 'UPPA_URI',     get_template_directory_uri() );

require UPPA_DIR . '/inc/setup.php';
require UPPA_DIR . '/inc/enqueue.php';
require UPPA_DIR . '/inc/nav-walkers.php';
require UPPA_DIR . '/inc/template-tags.php';
require UPPA_DIR . '/inc/accessibility.php';
require UPPA_DIR . '/inc/hooks.php';
require UPPA_DIR . '/inc/compat.php';

/**
 * Cleans up theme options and mods when this theme is deactivated.
 *
 * WordPress has no dedicated theme-delete hook that runs theme PHP. Using
 * switch_theme (fires when a new theme is activated) is the correct pattern:
 * it detects that UPPA Base was the previous theme and removes its stored data
 * so the database is left clean after deletion.
 *
 * @since 1.0.0
 * @param string    $new_name  New theme name.
 * @param \WP_Theme $new_theme New theme object.
 * @param \WP_Theme $old_theme Old (outgoing) theme object.
 * @return void
 */
function uppa_base_cleanup_on_switch( $new_name, $new_theme, $old_theme ) {
	if ( 'UPPA Base' !== $old_theme->get( 'Name' ) ) {
		return;
	}

	remove_theme_mods();
}
add_action( 'switch_theme', 'uppa_base_cleanup_on_switch', 10, 3 );
