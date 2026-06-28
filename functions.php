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
