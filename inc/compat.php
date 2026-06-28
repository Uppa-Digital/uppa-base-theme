<?php
/**
 * Compatibility layer: safe defaults for when the uppa-core plugin is absent.
 *
 * This file is required unconditionally by functions.php. Every constant,
 * function, and hook defined here is guarded so it never conflicts when
 * uppa-core IS active. No errors or warnings are thrown if the plugin is
 * missing — the theme degrades gracefully to its own baseline.
 *
 * Detection contract
 * ------------------
 * The canonical check used throughout templates and template-parts is:
 *
 *   if ( function_exists( 'uppa_core_active' ) && uppa_core_active() ) { ... }
 *
 * uppa-core defines uppa_core_active() on plugins_loaded and returns true.
 * This file defines a shim that returns false, so callers never need to
 * wrap calls in function_exists() themselves.
 *
 * For cross-boundary class calls (e.g. UPPA_ACF_Bridge::get_field()), always
 * guard with uppa_core_active() first and provide a scalar fallback:
 *
 *   $value = uppa_core_active()
 *       ? UPPA_ACF_Bridge::get_field( 'hero_title', get_the_ID() )
 *       : get_the_title();
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

// =============================================================================
// Primary presence check — uppa_core_active()
// =============================================================================

/**
 * Return true when the uppa-core plugin is active and fully loaded.
 *
 * uppa-core defines this function itself on plugins_loaded. The shim below
 * is only registered when the plugin has NOT defined it, so the real
 * implementation always wins.
 *
 * Usage in templates:
 *
 *   if ( uppa_core_active() ) {
 *       // plugin-dependent output
 *   }
 *
 * @since  1.0.0
 * @return bool True when uppa-core is active; false when absent or not yet loaded.
 */
if ( ! function_exists( 'uppa_core_active' ) ) {
	function uppa_core_active() {
		return false;
	}
}

// =============================================================================
// Secondary presence helper (internal theme use)
// =============================================================================

/**
 * Return true when the uppa-core plugin is active.
 *
 * Thin wrapper around uppa_core_active() kept for backwards-compatibility with
 * internal theme code written before the public API was established. New code
 * should call uppa_core_active() directly.
 *
 * @since  1.0.0
 * @return bool
 */
function uppa_has_core_plugin() {
	return uppa_core_active();
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
 * Templates that conditionally include plugin files should call
 * uppa_core_active() before using this constant.
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
 * uppa-core overrides this on plugins_loaded with its real version string.
 */
if ( ! defined( 'UPPA_CORE_VERSION' ) ) {
	define( 'UPPA_CORE_VERSION', '0.0.0' );
}

// =============================================================================
// Function shims — safe no-ops when uppa-core is absent
// =============================================================================

/**
 * Retrieve a theme option managed by uppa-core's options framework.
 *
 * When uppa-core is absent this shim always returns $default, so callers
 * receive a safe value without needing to guard with uppa_core_active().
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
 * Returns $default when the plugin is absent; callers should treat an empty
 * return as "not available" and suppress the related UI.
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

/**
 * Safe wrapper around UPPA_ACF_Bridge::get_field().
 *
 * When uppa-core is absent (no ACF bridge class), returns $fallback so
 * template-parts can call uppa_get_field() unconditionally without a
 * class_exists() guard at every call site.
 *
 * Usage:
 *
 *   $title = uppa_get_field( 'hero_title', get_the_ID(), get_the_title() );
 *
 * @since  1.0.0
 * @param  string   $key      ACF field name.
 * @param  int|null $post_id  Post ID; defaults to current post in the loop.
 * @param  mixed    $fallback Value returned when the plugin or field is absent.
 * @return mixed
 */
if ( ! function_exists( 'uppa_get_field' ) ) {
	function uppa_get_field( $key, $post_id = null, $fallback = '' ) {
		if ( uppa_core_active() && class_exists( 'UPPA_ACF_Bridge' ) ) {
			return UPPA_ACF_Bridge::get_field( $key, $post_id );
		}
		return $fallback;
	}
}

// =============================================================================
// Admin notice when plugin version is outdated (not absent — absent is silent)
// =============================================================================

/**
 * Show a one-time admin notice when uppa-core is active but below the
 * minimum compatible version.
 *
 * Only displayed to administrators. Silent when the plugin is absent — that
 * is an expected state for sites that have not yet installed uppa-core.
 *
 * @since 1.0.0
 * @hook  admin_notices
 */
function uppa_base_core_version_notice() {
	if ( ! uppa_core_active() ) {
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
