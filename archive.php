<?php
/**
 * The template for displaying archive pages.
 *
 * @package uppa-base
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content/content', get_post_format() );
		endwhile;

		the_posts_navigation();
	else :
		get_template_part( 'template-parts/content/content', 'none' );
	endif;
	?>
</main>

<?php
get_sidebar();
get_footer();
