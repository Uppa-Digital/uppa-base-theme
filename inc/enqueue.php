<?php
/**
 * Enqueue front-end scripts and styles.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues the parent theme's front-end stylesheet and script bundle.
 *
 * Handle names are part of the public hook API (Section 2.4). Child themes
 * must depend on 'uppa-base-style' and 'uppa-base-scripts' respectively so
 * WordPress loads them in the correct order.
 *
 * After each asset group is enqueued, a documented action fires so child
 * themes and plugins can append their own assets without overriding core
 * WordPress enqueue hooks:
 *
 *   add_action( 'uppa_enqueue_styles',  'my_child_styles' );
 *   add_action( 'uppa_enqueue_scripts', 'my_child_scripts' );
 *
 * @since  1.0.0
 * @return void
 */
function uppa_base_enqueue_assets() {

	// -------------------------------------------------------------------------
	// Stylesheet
	// -------------------------------------------------------------------------
	wp_enqueue_style(
		'uppa-base-style',
		UPPA_URI . '/assets/css/dist/main.min.css',
		array(),
		UPPA_VERSION
	);

	/**
	 * Fires immediately after the parent stylesheet is enqueued.
	 *
	 * Child themes should enqueue their own stylesheets here, declaring
	 * 'uppa-base-style' as a dependency so the cascade order is guaranteed.
	 *
	 *   add_action( 'uppa_enqueue_styles', function() {
	 *     wp_enqueue_style(
	 *       'my-child-style',
	 *       get_stylesheet_directory_uri() . '/assets/css/client.css',
	 *       array( 'uppa-base-style' ),
	 *       wp_get_theme()->get( 'Version' )
	 *     );
	 *   } );
	 *
	 * @since 1.0.0
	 * @hook  uppa_enqueue_styles
	 */
	do_action( 'uppa_enqueue_styles' );

	// -------------------------------------------------------------------------
	// Script bundle
	// -------------------------------------------------------------------------
	wp_enqueue_script(
		'uppa-base-scripts',
		UPPA_URI . '/assets/js/dist/main.min.js',
		array(),
		UPPA_VERSION,
		true  // Load in footer.
	);

	/**
	 * Fires immediately after the parent script bundle is enqueued.
	 *
	 * Child themes should enqueue their own scripts here, declaring
	 * 'uppa-base-scripts' as a dependency where execution order matters.
	 *
	 *   add_action( 'uppa_enqueue_scripts', function() {
	 *     wp_enqueue_script(
	 *       'my-child-scripts',
	 *       get_stylesheet_directory_uri() . '/assets/js/client.js',
	 *       array( 'uppa-base-scripts' ),
	 *       wp_get_theme()->get( 'Version' ),
	 *       true
	 *     );
	 *   } );
	 *
	 * @since 1.0.0
	 * @hook  uppa_enqueue_scripts
	 */
	do_action( 'uppa_enqueue_scripts' );
}
add_action( 'wp_enqueue_scripts', 'uppa_base_enqueue_assets' );

/**
 * Registers the block editor stylesheet so token overrides and base styles
 * are visible in the editor canvas without a separate compilation step.
 *
 * add_editor_style() paths are relative to the theme root. The compiled
 * (non-minified) build is used so the editor DevTools remain readable.
 *
 * Called on {@see 'after_setup_theme'} because add_editor_style() must run
 * before the editor boots; wp_enqueue_scripts fires too late.
 *
 * @since  1.0.0
 * @return void
 */
function uppa_base_editor_styles() {
	add_editor_style( 'assets/css/dist/main.css' );
}
add_action( 'after_setup_theme', 'uppa_base_editor_styles' );
