<?php
/**
 * Theme hook API: all 14 documented do_action() / apply_filters() calls,
 * their default render callbacks, and supporting utility filters.
 *
 * HOOK API OVERVIEW (Section 2.4)
 * ─────────────────────────────────────────────────────────────────────────────
 * Action hooks (10 content + 2 enqueue slots):
 *   uppa_before_header    uppa_header_open      uppa_after_branding
 *   uppa_nav_primary      uppa_header_close     uppa_before_content
 *   uppa_after_content    uppa_before_footer    uppa_footer_widgets
 *   uppa_footer_credits   uppa_enqueue_styles*  uppa_enqueue_scripts*
 *
 * Filter hooks (2):
 *   uppa_body_classes     uppa_post_classes
 *
 * * uppa_enqueue_styles and uppa_enqueue_scripts are fired in inc/enqueue.php
 *   immediately after the parent assets are enqueued. No default callback is
 *   needed — they are pure child-theme extension slots.
 *
 * TEMPLATE WIRING
 * ─────────────────────────────────────────────────────────────────────────────
 * Template files call the named wrapper functions (e.g. uppa_before_header())
 * rather than bare do_action() calls. This keeps hook names in one place and
 * makes IDEs and grep tools find all call-sites trivially.
 *
 * CHILD THEME OVERRIDE PATTERN
 * ─────────────────────────────────────────────────────────────────────────────
 * remove_action( 'uppa_nav_primary', 'uppa_render_nav_primary' );
 * add_action(    'uppa_nav_primary', 'my_custom_nav' );
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// =============================================================================
// Utility filters (not template-position hooks)
// =============================================================================

/**
 * Sets the global content width, used by WordPress for embedded media.
 *
 * Priority 0 so it is available to any callback added at default priority.
 *
 * @since  1.0.0
 * @global int $content_width
 * @return void
 */
function uppa_base_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'uppa_base_content_width', 1280 );
}
add_action( 'after_setup_theme', 'uppa_base_content_width', 0 );

/**
 * Truncates the default "…" more string for excerpts.
 *
 * @since  1.0.0
 * @return string
 */
function uppa_base_excerpt_more() {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'uppa_base_excerpt_more' );

// =============================================================================
// Hook 11 — uppa_body_classes (filter)
// =============================================================================

/**
 * Passes the body_class() array through the uppa_body_classes filter.
 *
 * Child themes modify body classes by hooking uppa_body_classes rather than
 * body_class directly, ensuring consistent priority relative to the parent:
 *
 *   add_filter( 'uppa_body_classes', function( $classes ) {
 *     $classes[] = 'my-custom-class';
 *     return $classes;
 *   } );
 *
 * The parent also adds 'singular' for single-post views. Remove it:
 *
 *   add_filter( 'uppa_body_classes', function( $classes ) {
 *     return array_diff( $classes, array( 'singular' ) );
 *   } );
 *
 * @since  1.0.0
 * @hook   uppa_body_classes
 * @param  string[] $classes Existing body classes from WordPress core.
 * @return string[]
 */
function uppa_filter_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	/**
	 * Filters the array of body classes.
	 *
	 * @since 1.0.0
	 * @param string[] $classes Body class names.
	 */
	return apply_filters( 'uppa_body_classes', $classes );
}
add_filter( 'body_class', 'uppa_filter_body_classes', 10 );

// =============================================================================
// Hook 12 — uppa_post_classes (filter)
// =============================================================================

/**
 * Passes the post_class() array through the uppa_post_classes filter.
 *
 * Child themes modify post classes by hooking uppa_post_classes:
 *
 *   add_filter( 'uppa_post_classes', function( $classes ) {
 *     $classes[] = 'card';
 *     return $classes;
 *   } );
 *
 * @since  1.0.0
 * @hook   uppa_post_classes
 * @param  string[] $classes Existing post classes from WordPress core.
 * @return string[]
 */
function uppa_filter_post_classes( $classes ) {
	/**
	 * Filters the array of post classes.
	 *
	 * @since 1.0.0
	 * @param string[] $classes Post class names.
	 */
	return apply_filters( 'uppa_post_classes', $classes );
}
add_filter( 'post_class', 'uppa_filter_post_classes', 10 );

// =============================================================================
// Hook 1 — uppa_before_header (action)
// =============================================================================

/**
 * Fires immediately before the opening <header> element.
 *
 * Call-site in header.php: uppa_before_header()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_before_header() {
	/**
	 * Fires before the site <header> element.
	 *
	 * Use this slot to inject banners, admin notices, or above-header content.
	 * Safe to add_action() in a child theme without removing the default.
	 *
	 * @since 1.0.0
	 * @hook  uppa_before_header
	 */
	do_action( 'uppa_before_header' );
}

/**
 * Default callback for the uppa_before_header action.
 *
 * No output by default — this is a pure extension slot.
 *
 * Child theme override:
 *   remove_action( 'uppa_before_header', 'uppa_render_before_header' );
 *   add_action(    'uppa_before_header', 'my_above_header_banner' );
 *
 * @since 1.0.0
 * @hook  uppa_before_header
 * @return void
 */
function uppa_render_before_header() {}
add_action( 'uppa_before_header', 'uppa_render_before_header', 10 );

// =============================================================================
// Hook 2 — uppa_header_open (action)
// =============================================================================

/**
 * Fires immediately after the opening <header> tag.
 *
 * Call-site in header.php: uppa_header_open()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_header_open() {
	/**
	 * Fires inside the opening <header> element, before branding.
	 *
	 * @since 1.0.0
	 * @hook  uppa_header_open
	 */
	do_action( 'uppa_header_open' );
}

/**
 * Default callback for the uppa_header_open action.
 *
 * No output by default — pure extension slot.
 *
 * Child theme override:
 *   remove_action( 'uppa_header_open', 'uppa_render_header_open' );
 *   add_action(    'uppa_header_open', 'my_header_open_content' );
 *
 * @since 1.0.0
 * @hook  uppa_header_open
 * @return void
 */
function uppa_render_header_open() {}
add_action( 'uppa_header_open', 'uppa_render_header_open', 10 );

// =============================================================================
// Hook 3 — uppa_after_branding (action)
// =============================================================================

/**
 * Fires after the site branding block (logo + site title).
 *
 * Call-site in template-parts/header/site-branding.php: uppa_after_branding()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_after_branding() {
	/**
	 * Fires after the site logo and title, before the primary nav.
	 *
	 * Good slot for a tagline, search form, or header CTA button.
	 *
	 * @since 1.0.0
	 * @hook  uppa_after_branding
	 */
	do_action( 'uppa_after_branding' );
}

/**
 * Default callback for the uppa_after_branding action.
 *
 * No output by default — pure extension slot.
 *
 * Child theme override:
 *   remove_action( 'uppa_after_branding', 'uppa_render_after_branding' );
 *   add_action(    'uppa_after_branding', 'my_header_search_form' );
 *
 * @since 1.0.0
 * @hook  uppa_after_branding
 * @return void
 */
function uppa_render_after_branding() {}
add_action( 'uppa_after_branding', 'uppa_render_after_branding', 10 );

// =============================================================================
// Hook 4 — uppa_nav_primary (action)
// =============================================================================

/**
 * Fires in the header where the primary navigation should appear.
 *
 * Call-site in header.php: uppa_nav_primary()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_nav_primary() {
	/**
	 * Fires at the primary navigation position inside the site header.
	 *
	 * Remove the default callback to suppress the nav entirely:
	 *   remove_action( 'uppa_nav_primary', 'uppa_render_nav_primary' );
	 *
	 * Replace with a custom navigation:
	 *   remove_action( 'uppa_nav_primary', 'uppa_render_nav_primary' );
	 *   add_action(    'uppa_nav_primary', 'my_custom_nav' );
	 *
	 * @since 1.0.0
	 * @hook  uppa_nav_primary
	 */
	do_action( 'uppa_nav_primary' );
}

/**
 * Default callback for the uppa_nav_primary action.
 *
 * Renders the primary navigation via its dedicated template part so that
 * child themes can override the markup by copying the file into their own
 * template-parts/header/navigation.php without touching this hook.
 *
 * Child theme hook override (replaces markup entirely):
 *   remove_action( 'uppa_nav_primary', 'uppa_render_nav_primary' );
 *   add_action(    'uppa_nav_primary', 'my_custom_nav' );
 *
 * @since 1.0.0
 * @hook  uppa_nav_primary
 * @return void
 */
function uppa_render_nav_primary() {
	get_template_part( 'template-parts/header/navigation' );
}
add_action( 'uppa_nav_primary', 'uppa_render_nav_primary', 10 );

// =============================================================================
// Hook 5 — uppa_header_close (action)
// =============================================================================

/**
 * Fires immediately before the closing </header> tag.
 *
 * Call-site in header.php: uppa_header_close()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_header_close() {
	/**
	 * Fires before the closing </header> element.
	 *
	 * @since 1.0.0
	 * @hook  uppa_header_close
	 */
	do_action( 'uppa_header_close' );
}

/**
 * Default callback for the uppa_header_close action.
 *
 * No output by default — pure extension slot.
 *
 * Child theme override:
 *   remove_action( 'uppa_header_close', 'uppa_render_header_close' );
 *   add_action(    'uppa_header_close', 'my_header_bottom_bar' );
 *
 * @since 1.0.0
 * @hook  uppa_header_close
 * @return void
 */
function uppa_render_header_close() {}
add_action( 'uppa_header_close', 'uppa_render_header_close', 10 );

// =============================================================================
// Hook 6 — uppa_before_content (action)
// =============================================================================

/**
 * Fires before the main content wrapper opens.
 *
 * Call-site in index.php / page.php etc.: uppa_before_content()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_before_content() {
	/**
	 * Fires before the main #primary content wrapper.
	 *
	 * Useful for breadcrumbs, page-title bars, or hero sections that sit
	 * outside the content area but inside the page body.
	 *
	 * @since 1.0.0
	 * @hook  uppa_before_content
	 */
	do_action( 'uppa_before_content' );
}

/**
 * Default callback for the uppa_before_content action.
 *
 * No output by default — pure extension slot.
 *
 * Child theme override:
 *   remove_action( 'uppa_before_content', 'uppa_render_before_content' );
 *   add_action(    'uppa_before_content', 'my_page_title_bar' );
 *
 * @since 1.0.0
 * @hook  uppa_before_content
 * @return void
 */
function uppa_render_before_content() {}
add_action( 'uppa_before_content', 'uppa_render_before_content', 10 );

// =============================================================================
// Hook 7 — uppa_after_content (action)
// =============================================================================

/**
 * Fires after the main content wrapper closes.
 *
 * Call-site in index.php / page.php etc.: uppa_after_content()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_after_content() {
	/**
	 * Fires after the main #primary content wrapper.
	 *
	 * @since 1.0.0
	 * @hook  uppa_after_content
	 */
	do_action( 'uppa_after_content' );
}

/**
 * Default callback for the uppa_after_content action.
 *
 * No output by default — pure extension slot.
 *
 * Child theme override:
 *   remove_action( 'uppa_after_content', 'uppa_render_after_content' );
 *   add_action(    'uppa_after_content', 'my_related_posts_section' );
 *
 * @since 1.0.0
 * @hook  uppa_after_content
 * @return void
 */
function uppa_render_after_content() {}
add_action( 'uppa_after_content', 'uppa_render_after_content', 10 );

// =============================================================================
// Hook 8 — uppa_before_footer (action)
// =============================================================================

/**
 * Fires immediately before the <footer> element.
 *
 * Call-site in footer.php: uppa_before_footer()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_before_footer() {
	/**
	 * Fires before the site <footer> element.
	 *
	 * Good slot for a pre-footer CTA strip or newsletter signup band.
	 *
	 * @since 1.0.0
	 * @hook  uppa_before_footer
	 */
	do_action( 'uppa_before_footer' );
}

/**
 * Default callback for the uppa_before_footer action.
 *
 * No output by default — pure extension slot.
 *
 * Child theme override:
 *   remove_action( 'uppa_before_footer', 'uppa_render_before_footer' );
 *   add_action(    'uppa_before_footer', 'my_prefooter_cta' );
 *
 * @since 1.0.0
 * @hook  uppa_before_footer
 * @return void
 */
function uppa_render_before_footer() {}
add_action( 'uppa_before_footer', 'uppa_render_before_footer', 10 );

// =============================================================================
// Hook 9 — uppa_footer_widgets (action)
// =============================================================================

/**
 * Fires at the footer widget area position inside the <footer> element.
 *
 * Call-site in footer.php: uppa_footer_widgets()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_footer_widgets() {
	/**
	 * Fires at the footer widget area position.
	 *
	 * Remove the default callback to suppress footer widgets entirely:
	 *   remove_action( 'uppa_footer_widgets', 'uppa_render_footer_widgets' );
	 *
	 * @since 1.0.0
	 * @hook  uppa_footer_widgets
	 */
	do_action( 'uppa_footer_widgets' );
}

/**
 * Default callback for the uppa_footer_widgets action.
 *
 * Delegates to the footer-widgets template part, which checks
 * is_active_sidebar( 'footer-1' ) and returns silently when no widgets
 * are assigned — no empty markup is output.
 *
 * Child theme hook override:
 *   remove_action( 'uppa_footer_widgets', 'uppa_render_footer_widgets' );
 *   add_action(    'uppa_footer_widgets', 'my_custom_footer_columns' );
 *
 * Child theme template override (markup only):
 *   Copy template-parts/footer/footer-widgets.php into the child theme at
 *   the same path — WordPress template hierarchy picks it up automatically.
 *
 * @since 1.0.0
 * @hook  uppa_footer_widgets
 * @return void
 */
function uppa_render_footer_widgets() {
	get_template_part( 'template-parts/footer/footer-widgets' );
}
add_action( 'uppa_footer_widgets', 'uppa_render_footer_widgets', 10 );

// =============================================================================
// Hook 10 — uppa_footer_credits (action)
// =============================================================================

/**
 * Fires at the footer credits / copyright position.
 *
 * Call-site in footer.php: uppa_footer_credits()
 *
 * @since 1.0.0
 * @return void
 */
function uppa_footer_credits() {
	/**
	 * Fires at the footer credits position.
	 *
	 * Replace with child theme branding:
	 *   remove_action( 'uppa_footer_credits', 'uppa_render_footer_credits' );
	 *   add_action(    'uppa_footer_credits', 'my_footer_credits' );
	 *
	 * @since 1.0.0
	 * @hook  uppa_footer_credits
	 */
	do_action( 'uppa_footer_credits' );
}

/**
 * Default callback for the uppa_footer_credits action.
 *
 * Outputs a copyright line built entirely from WordPress API functions —
 * no hard-coded strings or URLs. The site name and home URL are read at
 * runtime so the line is always correct after a site migration.
 *
 * Child theme override (replace branding):
 *   remove_action( 'uppa_footer_credits', 'uppa_render_footer_credits' );
 *   add_action(    'uppa_footer_credits', 'my_footer_credits' );
 *
 * @since 1.0.0
 * @hook  uppa_footer_credits
 * @return void
 */
function uppa_render_footer_credits() {
	$site_name = wp_kses_post( get_bloginfo( 'name' ) );
	$site_url  = esc_url( home_url( '/' ) );
	$year      = gmdate( 'Y' );

	printf(
		'<div class="site-credits"><p>&copy; %1$s <a href="%2$s">%3$s</a>. %4$s</p></div>',
		esc_html( $year ),
		$site_url,
		$site_name,
		esc_html__( 'All rights reserved.', 'uppa-base' )
	);
}
add_action( 'uppa_footer_credits', 'uppa_render_footer_credits', 10 );
