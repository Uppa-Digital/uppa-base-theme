<?php
/**
 * The footer template.
 *
 * Closes the #content wrapper opened in header.php, fires all footer action
 * hooks, closes the page wrapper, and calls wp_footer().
 *
 * Hook call-sites (see inc/hooks.php for callback definitions):
 *   uppa_before_footer()    — before <footer>
 *   uppa_footer_widgets()   — footer widget area position
 *   uppa_footer_credits()   — copyright / credits line
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

	</div><!-- #content -->

	<?php uppa_before_footer(); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php uppa_footer_widgets(); ?>

		<?php uppa_footer_credits(); ?>

	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
