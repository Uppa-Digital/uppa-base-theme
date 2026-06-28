<?php
/**
 * Compatibility layer and safe fallbacks for when uppa-core plugin is absent.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns true if the uppa-core plugin is active.
 *
 * @return bool
 */
function uppa_base_has_core_plugin() {
	return defined( 'UPPA_CORE_VERSION' );
}

/**
 * Provides a no-op shim for any uppa-core function the theme relies on,
 * so the theme never fatals when the plugin is not installed.
 */
if ( ! function_exists( 'uppa_core_get_option' ) ) {
	/**
	 * Fallback for uppa_core_get_option().
	 *
	 * @param  string $key     Option key.
	 * @param  mixed  $default Default value.
	 * @return mixed
	 */
	function uppa_core_get_option( $key, $default = null ) {
		return $default;
	}
}
