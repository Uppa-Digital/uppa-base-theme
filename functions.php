<?php
/**
 * UPPA Base functions and definitions.
 *
 * Loads all feature files from the /inc directory.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'UPPA_BASE_VERSION', '1.0.0' );
define( 'UPPA_BASE_DIR', get_template_directory() );
define( 'UPPA_BASE_URI', get_template_directory_uri() );

$uppa_base_includes = array(
	'/inc/setup.php',
	'/inc/enqueue.php',
	'/inc/nav-walkers.php',
	'/inc/template-tags.php',
	'/inc/accessibility.php',
	'/inc/hooks.php',
	'/inc/compat.php',
);

foreach ( $uppa_base_includes as $file ) {
	require_once UPPA_BASE_DIR . $file;
}
