<?php
/**
 * Template part: default post loop item.
 *
 * Used for standard posts in the loop (index.php, archive.php, search.php).
 * In singular context (single.php), the full content is rendered; in list
 * context the excerpt or truncated content is shown via the_content() with
 * a "Continue reading" link that includes a screen-reader post title.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php if ( is_singular() ) : ?>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php else : ?>
			<?php
			the_title(
				sprintf(
					'<h2 class="entry-title"><a href="%s" rel="bookmark">',
					esc_url( get_permalink() )
				),
				'</a></h2>'
			);
			?>
		<?php endif; ?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php uppa_base_entry_meta(); ?>
			</div>
		<?php endif; ?>

	</header><!-- .entry-header -->

	<?php uppa_base_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Continue reading<span class="screen-reader-text"> &ldquo;%s&rdquo;</span>', 'uppa-base' ),
					array( 'span' => array( 'class' => array() ) )
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before'      => '<nav class="page-links" aria-label="' . esc_attr__( 'Post pages', 'uppa-base' ) . '"><span class="page-links__label">' . esc_html__( 'Pages:', 'uppa-base' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-links__item">',
				'link_after'  => '</span>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<?php
	$uppa_tags_list  = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'uppa-base' ) );
	$uppa_has_footer = $uppa_tags_list || current_user_can( 'edit_posts' );
	if ( $uppa_has_footer ) :
		?>
		<footer class="entry-footer">
			<?php if ( $uppa_tags_list ) : ?>
				<span class="tags-links">
					<?php
					printf(
						/* translators: %s: comma-separated tag list */
						esc_html__( 'Tagged: %s', 'uppa-base' ),
						$uppa_tags_list // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_tag_list() returns kses-filtered links
					);
					?>
				</span>
			<?php endif; ?>
			<?php uppa_base_edit_link(); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
