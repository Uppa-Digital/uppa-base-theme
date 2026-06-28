<?php
/**
 * Template part: no results / empty state.
 *
 * Rendered by index.php, archive.php, and search.php when the query returns
 * zero posts. Three contexts are handled:
 *
 *   1. Home / blog index with no posts yet — prompt to publish.
 *   2. Search with no results — prompt to refine the query.
 *   3. Any other archive or page with no results — generic message + search.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="no-results not-found">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing found', 'uppa-base' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: URL to new post screen */
						__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'uppa-base' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php
				printf(
					/* translators: %s: the original search query */
					esc_html__( 'No results for &ldquo;%s&rdquo;. Please try different keywords.', 'uppa-base' ),
					'<strong>' . esc_html( get_search_query() ) . '</strong>'
				);
				?>
			</p>

			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'uppa-base' ); ?></p>

			<?php get_search_form(); ?>

		<?php endif; ?>

	</div><!-- .page-content -->

</section><!-- .no-results -->
