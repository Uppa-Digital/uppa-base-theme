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
		<?php
		$uppa_cats = get_the_category_list( esc_html_x( ', ', 'list item separator', 'uppa-base' ) );
		if ( $uppa_cats ) :
			?>
			<span class="cat-links">
				<?php
				printf(
					/* translators: %s: comma-separated category list */
					esc_html__( 'in %s', 'uppa-base' ),
					$uppa_cats // phpcs:ignore WordPress.Security.EscapeOutput -- get_the_category_list() returns kses-safe links
				);
				?>
			</span>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Outputs a "Edit this" link visible to logged-in users with edit capability.
 */
function uppa_base_edit_link() {
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: post title */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'uppa-base' ),
				array( 'span' => array( 'class' => array() ) )
			),
			wp_kses_post( get_the_title() )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Outputs an author bio box for the current post author.
 *
 * Only outputs when the author has a non-empty biography and the post type
 * supports the author field.
 */
function uppa_base_author_box() {
	if ( ! post_type_supports( get_post_type(), 'author' ) ) {
		return;
	}

	$author_id  = get_the_author_meta( 'ID' );
	$author_bio = get_the_author_meta( 'description' );

	if ( ! $author_bio ) {
		return;
	}
	?>
	<div class="author-box">
		<div class="author-box__avatar">
			<?php echo get_avatar( $author_id, 80, '', '', array( 'class' => 'avatar' ) ); ?>
		</div>
		<div class="author-box__info">
			<p class="author-box__name">
				<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
					<?php echo esc_html( get_the_author() ); ?>
				</a>
			</p>
			<div class="author-box__bio">
				<p><?php echo wp_kses_post( $author_bio ); ?></p>
			</div>
			<a class="author-box__link" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
				<?php
				printf(
					/* translators: %s: author display name */
					esc_html__( 'More posts by %s', 'uppa-base' ),
					esc_html( get_the_author() )
				);
				?>
			</a>
		</div>
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
