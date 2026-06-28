<?php
/**
 * Template part: skip-to-content accessibility link.
 *
 * Targets #main — the id on the <main> element in every template file.
 * Visible only on keyboard focus via .screen-reader-text CSS (defined in
 * assets/css/src/_accessibility.scss or _layout.scss in child theme).
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>
<a class="skip-link screen-reader-text" href="#main">
	<?php esc_html_e( 'Skip to content', 'uppa-base' ); ?>
</a>
