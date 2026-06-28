<?php
/**
 * Template part: static page content.
 *
 * Used by page.php. Differs from content.php in that:
 *   - The title is always an <h1> (page.php is always singular).
 *   - No entry-meta (author, date) — not meaningful for static pages.
 *   - No entry-footer tags — pages are not typically tagged.
 *   - wp_link_pages() is included for paginated page content (<!--nextpage-->).
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php uppa_base_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'      => '<nav class="page-links" aria-label="' . esc_attr__( 'Page sections', 'uppa-base' ) . '"><span class="page-links__label">' . esc_html__( 'Pages:', 'uppa-base' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-links__item">',
				'link_after'  => '</span>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
