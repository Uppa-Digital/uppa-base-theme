<?php
/**
 * Template part: footer widget area.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'footer-1' ) ) {
	return;
}
?>

<div class="footer-widgets">
	<?php dynamic_sidebar( 'footer-1' ); ?>
</div>
