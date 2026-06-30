<?php
/**
 * Template part: search result item.
 *
 * Used by search.php. Shows excerpt rather than full content, and includes
 * the post type label so users can distinguish posts from pages.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		the_title(
			sprintf(
				'<h2 class="entry-title"><a href="%s" rel="bookmark">',
				esc_url( get_permalink() )
			),
			'</a></h2>'
		);
		?>

		<div class="entry-meta">
			<?php if ( 'post' === get_post_type() ) : ?>
				<span class="posted-on">
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					</a>
				</span>
			<?php else : ?>
				<span class="post-type-label"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
			<?php endif; ?>
		</div>

	</header><!-- .entry-header -->

	<?php uppa_base_post_thumbnail( 'uppa-card' ); ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<a class="read-more" href="<?php the_permalink(); ?>">
			<?php
			printf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Read more<span class="screen-reader-text"> about %s</span>', 'uppa-base' ),
					array( 'span' => array( 'class' => array() ) )
				),
				wp_kses_post( get_the_title() )
			);
			?>
		</a>
		<?php uppa_base_edit_link(); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
