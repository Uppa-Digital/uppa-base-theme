<?php
/**
 * Reusable template helper functions.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs the post thumbnail with a consistent wrapper.
 *
 * @param string $size Registered image size. Default 'post-thumbnail'.
 */
function uppa_base_post_thumbnail( $size = 'post-thumbnail' ) {
	if ( ! has_post_thumbnail() ) {
		return;
	}
	?>
	<div class="post-thumbnail">
		<?php the_post_thumbnail( $size ); ?>
	</div>
	<?php
}

/**
 * Outputs post meta: author, date, and categories.
 */
function uppa_base_entry_meta() {
	?>
	<div class="entry-meta">
		<span class="byline">
			<?php
			printf(
				/* translators: %s: post author. */
				esc_html_x( 'by %s', 'post author', 'uppa-base' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);
			?>
		</span>
		<span class="posted-on">
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</a>
		</span>
	</div>
	<?php
}

/**
 * Returns true when the site has more than one author with published posts.
 *
 * @return bool
 */
function uppa_base_is_multi_author() {
	$authors = get_users(
		array(
			'fields'       => 'ID',
			'who'          => 'authors',
			'has_published_posts' => true,
			'number'       => 2,
		)
	);

	return count( $authors ) > 1;
}
