<?php
/**
 * Compatibility layer: safe defaults for when the uppa-core plugin is absent.
 *
 * This file is required unconditionally by functions.php. Every constant,
 * function, and hook defined here is guarded so it never conflicts when
 * uppa-core IS active. No errors or warnings are thrown if the plugin is
 * missing — the theme degrades gracefully to its own baseline.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Plugin presence check
// =============================================================================

/**
 * Return true when the uppa-core plugin is active.
 *
 * Presence is detected by the UPPA_CORE_VERSION constant that uppa-core
 * defines on plugins_loaded. Do not rely on is_plugin_active() here because
 * this file is loaded on after_setup_theme, before the admin functions that
 * define is_plugin_active() are guaranteed to be available on the front end.
 *
 * @since  1.0.0
 * @return bool
 */
function uppa_has_core_plugin() {
	return defined( 'UPPA_CORE_VERSION' );
}

// =============================================================================
// Constants uppa-core would normally define
// =============================================================================

/**
 * Minimum uppa-core version this theme edition is designed to work with.
 * Defined here so template code can reference UPPA_CORE_MIN_VERSION without
 * a fatal error when the plugin is absent.
 */
if ( ! defined( 'UPPA_CORE_MIN_VERSION' ) ) {
	define( 'UPPA_CORE_MIN_VERSION', '1.0.0' );
}

/**
 * Plugin directory path — empty string when plugin is not installed.
 * Templates that conditionally include plugin files should check
 * uppa_has_core_plugin() before using this constant.
 */
if ( ! defined( 'UPPA_CORE_DIR' ) ) {
	define( 'UPPA_CORE_DIR', '' );
}

/**
 * Plugin directory URI — empty string when plugin is not installed.
 */
if ( ! defined( 'UPPA_CORE_URI' ) ) {
	define( 'UPPA_CORE_URI', '' );
}

/**
 * Version string — '0.0.0' signals "not installed" to any version checks.
 */
if ( ! defined( 'UPPA_CORE_VERSION' ) ) {
	define( 'UPPA_CORE_VERSION', '0.0.0' );
}

// =============================================================================
// Function shims
// =============================================================================

/**
 * Retrieve a theme option managed by uppa-core's options framework.
 *
 * When uppa-core is absent this shim always returns $default, so callers
 * receive a safe value without needing to check for plugin presence themselves.
 *
 * @since  1.0.0
 * @param  string $key     Option key registered with uppa-core.
 * @param  mixed  $default Value to return when the option or plugin is absent.
 * @return mixed
 */
if ( ! function_exists( 'uppa_core_get_option' ) ) {
	function uppa_core_get_option( $key, $default = null ) {
		return $default;
	}
}

/**
 * Return whether a named uppa-core feature flag is enabled.
 *
 * Defaults to false when the plugin is absent — theme behaviour stays
 * conservative rather than activating features that need plugin support.
 *
 * @since  1.0.0
 * @param  string $feature Feature flag key.
 * @return bool
 */
if ( ! function_exists( 'uppa_core_feature_enabled' ) ) {
	function uppa_core_feature_enabled( $feature ) {
		return false;
	}
}

/**
 * Retrieve a CPT or taxonomy label string managed by uppa-core.
 *
 * Returns an empty string when the plugin is absent; callers should treat
 * an empty return as "not available" and suppress the related UI.
 *
 * @since  1.0.0
 * @param  string $label_key Label key (e.g. 'service', 'project').
 * @param  string $default   Fallback string.
 * @return string
 */
if ( ! function_exists( 'uppa_core_get_label' ) ) {
	function uppa_core_get_label( $label_key, $default = '' ) {
		return $default;
	}
}

// =============================================================================
// Admin notice when plugin version is outdated (not absent — absent is silent)
// =============================================================================

/**
 * Show a one-time admin notice when uppa-core is active but below the
 * minimum compatible version.
 *
 * Only displayed to administrators; silently skipped on the front end.
 * No notice is shown when the plugin is absent — that is an expected state.
 *
 * @since 1.0.0
 * @hook  admin_notices
 */
function uppa_base_core_version_notice() {
	if ( ! uppa_has_core_plugin() ) {
		return;
	}

	if ( version_compare( UPPA_CORE_VERSION, UPPA_CORE_MIN_VERSION, '>=' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	printf(
		'<div class="notice notice-warning"><p>%s</p></div>',
		wp_kses_post(
			sprintf(
				/* translators: 1: installed version, 2: required version */
				__( '<strong>UPPA Base</strong> requires uppa-core %2$s or later. You are running %1$s. Please update the plugin.', 'uppa-base' ),
				esc_html( UPPA_CORE_VERSION ),
				esc_html( UPPA_CORE_MIN_VERSION )
			)
		)
	);
}
add_action( 'admin_notices', 'uppa_base_core_version_notice' );
