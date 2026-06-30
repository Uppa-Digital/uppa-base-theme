<?php
/**
 * The template for displaying all single posts.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content/content', get_post_type() );

		the_post_navigation(
			array(
				'prev_text' => sprintf(
					/* translators: %s: post title */
					'<span class="nav-subtitle">%1$s</span> <span class="nav-title">%2$s</span>',
					esc_html__( 'Previous:', 'uppa-base' ),
					'%title'
				),
				'next_text' => sprintf(
					/* translators: %s: post title */
					'<span class="nav-subtitle">%1$s</span> <span class="nav-title">%2$s</span>',
					esc_html__( 'Next:', 'uppa-base' ),
					'%title'
				),
			)
		);

		uppa_base_author_box();

		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile;
	?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
