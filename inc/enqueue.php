<?php
/**
 * Enqueue scripts and styles.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues front-end assets.
 */
function uppa_base_scripts() {

	wp_enqueue_style(
		'uppa-base-style',
		UPPA_BASE_URI . '/assets/css/dist/main.min.css',
		array(),
		UPPA_BASE_VERSION
	);

	wp_enqueue_script(
		'uppa-base-main',
		UPPA_BASE_URI . '/assets/js/dist/main.min.js',
		array(),
		UPPA_BASE_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'uppa_base_scripts' );

/**
 * Enqueues block editor assets.
 */
function uppa_base_block_editor_assets() {

	wp_enqueue_style(
		'uppa-base-editor-style',
		UPPA_BASE_URI . '/assets/css/dist/main.css',
		array(),
		UPPA_BASE_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'uppa_base_block_editor_assets' );
