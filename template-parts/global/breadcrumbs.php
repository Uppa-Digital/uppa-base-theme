<?php
/**
 * Template part: breadcrumb navigation.
 *
 * A lightweight, plugin-free breadcrumb trail. Handles singular posts/pages,
 * taxonomy/date/author archives, search results, and 404 pages.
 *
 * Child themes can suppress this partial entirely by removing the call-site,
 * or replace the output by copying this file into their own template-parts/
 * directory and swapping in a plugin's breadcrumb function.
 *
 * No output on the front page — a "Home" crumb alone is not useful there.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( is_front_page() ) {
	return;
}

$uppa_crumbs = array();

// Home — always the first crumb.
$uppa_crumbs[] = sprintf(
	'<li class="breadcrumb__item"><a href="%s">%s</a></li>',
	esc_url( home_url( '/' ) ),
	esc_html__( 'Home', 'uppa-base' )
);

if ( is_singular() ) {

	// For standard posts: insert the primary category as an intermediate crumb.
	if ( 'post' === get_post_type() ) {
		$uppa_cats = get_the_category();
		if ( ! empty( $uppa_cats ) ) {
			$uppa_crumbs[] = sprintf(
				'<li class="breadcrumb__item"><a href="%s">%s</a></li>',
				esc_url( get_category_link( $uppa_cats[0]->term_id ) ),
				esc_html( $uppa_cats[0]->name )
			);
		}
	}

	// Current post/page — no link, aria-current.
	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		esc_html( get_the_title() )
	);

} elseif ( is_category() || is_tag() || is_tax() ) {

	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		esc_html( single_term_title( '', false ) )
	);

} elseif ( is_author() ) {

	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		/* translators: %s: author display name */
		sprintf( esc_html__( 'Author: %s', 'uppa-base' ), esc_html( get_the_author() ) )
	);

} elseif ( is_year() ) {

	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		esc_html( get_the_date( 'Y' ) )
	);

} elseif ( is_month() ) {

	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item"><a href="%s">%s</a></li>',
		esc_url( get_year_link( get_the_date( 'Y' ) ) ),
		esc_html( get_the_date( 'Y' ) )
	);
	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		esc_html( get_the_date( 'F' ) )
	);

} elseif ( is_day() ) {

	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item"><a href="%s">%s</a></li>',
		esc_url( get_year_link( get_the_date( 'Y' ) ) ),
		esc_html( get_the_date( 'Y' ) )
	);
	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item"><a href="%s">%s</a></li>',
		esc_url( get_month_link( get_the_date( 'Y' ), get_the_date( 'm' ) ) ),
		esc_html( get_the_date( 'F' ) )
	);
	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		esc_html( get_the_date( 'j' ) )
	);

} elseif ( is_search() ) {

	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		sprintf(
			/* translators: %s: search query */
			esc_html__( 'Search results for: %s', 'uppa-base' ),
			'&ldquo;' . esc_html( get_search_query() ) . '&rdquo;'
		)
	);

} elseif ( is_404() ) {

	$uppa_crumbs[] = sprintf(
		'<li class="breadcrumb__item breadcrumb__item--current" aria-current="page">%s</li>',
		esc_html__( 'Page not found', 'uppa-base' )
	);

}

if ( count( $uppa_crumbs ) <= 1 ) {
	return; // Nothing beyond Home to display.
}
?>

<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'uppa-base' ); ?>">
	<ol class="breadcrumb__list">
		<?php echo implode( "\n\t\t", $uppa_crumbs ); // phpcs:ignore WordPress.Security.EscapeOutput -- every crumb is built with esc_html/esc_url above ?>
	</ol>
</nav><!-- .breadcrumbs -->
