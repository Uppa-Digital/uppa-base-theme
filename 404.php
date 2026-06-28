<?php
/**
 * The template for displaying 404 (not found) pages.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main" class="site-main">

	<section class="error-404 not-found">

		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page not found', 'uppa-base' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">

			<p><?php esc_html_e( 'It looks like nothing was found at this location. Try searching below.', 'uppa-base' ); ?></p>

			<?php get_search_form(); ?>

		</div><!-- .page-content -->

	</section><!-- .error-404 -->

</main><!-- #primary -->

<?php
get_footer();
