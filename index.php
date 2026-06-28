<?php
/**
 * The main template file.
 *
 * WordPress falls back to this file when no more specific template exists in
 * the theme (or active child theme). It is the only required template besides
 * style.css.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main" class="site-main">

	<?php if ( have_posts() ) : ?>

		<?php if ( is_home() && ! is_front_page() ) : ?>
			<header class="page-header">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>
		<?php endif; ?>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', get_post_format() );
		endwhile;
		?>

		<?php the_posts_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

	<?php endif; ?>

</main><!-- #primary -->

<?php
get_sidebar();
get_footer();
