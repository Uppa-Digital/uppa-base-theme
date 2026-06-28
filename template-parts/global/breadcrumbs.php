<?php
/**
 * Template part: breadcrumb navigation.
 *
 * Outputs a basic breadcrumb trail. Child themes or the uppa-core plugin
 * may replace this with a richer implementation (e.g. Yoast SEO breadcrumbs).
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( is_front_page() ) {
	return;
}
?>

<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'uppa-base' ); ?>">
	<ol class="breadcrumb-list">
		<li class="breadcrumb-item">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'uppa-base' ); ?></a>
		</li>
		<?php if ( is_singular() ) : ?>
			<li class="breadcrumb-item current" aria-current="page">
				<?php the_title(); ?>
			</li>
		<?php elseif ( is_archive() ) : ?>
			<li class="breadcrumb-item current" aria-current="page">
				<?php the_archive_title(); ?>
			</li>
		<?php elseif ( is_search() ) : ?>
			<li class="breadcrumb-item current" aria-current="page">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search results for: %s', 'uppa-base' ),
					get_search_query()
				);
				?>
			</li>
		<?php endif; ?>
	</ol>
</nav>
