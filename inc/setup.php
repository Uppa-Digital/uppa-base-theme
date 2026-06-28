<?php
/**
 * Theme setup: add_theme_support() declarations, nav menus, and widget areas.
 *
 * @package uppa-base
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Called on the {@see 'after_setup_theme'} hook. The hook fires before the
 * init hook, so it runs before any plugin can call add_theme_support().
 *
 * @since 1.0.0
 * @return void
 */
function uppa_base_setup() {

	/*
	 * Make the theme available for translation.
	 * Translations are filed in /languages/. The text domain must match the
	 * Theme Name slug from style.css exactly.
	 */
	load_theme_textdomain( 'uppa-base', UPPA_DIR . '/languages' );

	/*
	 * Let WordPress manage the document <title> tag.
	 * Removes the need for a <title> element in header.php.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for post thumbnails (featured images) on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Add support for a custom logo with defined display constraints.
	 * Child themes can override --color-primary token instead of replacing the logo markup.
	 */
	add_theme_support(
		'custom-logo',
		array(
			'width'       => 300,
			'height'      => 100,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	/*
	 * Switch default core markup to output valid HTML5 for the listed elements.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	/*
	 * Opt into styled core blocks (adds .is-style-* classes).
	 */
	add_theme_support( 'wp-block-styles' );

	/*
	 * Enable wide and full-width alignment options in the block editor.
	 */
	add_theme_support( 'align-wide' );

	/*
	 * Let the block editor scale embedded content to the container width.
	 */
	add_theme_support( 'responsive-embeds' );

	/*
	 * Tell the block editor to load the theme's editor stylesheet so token
	 * overrides are visible while editing. The stylesheet is enqueued via
	 * uppa_base_block_editor_assets() in inc/enqueue.php.
	 */
	add_theme_support( 'editor-styles' );

	/*
	 * Register navigation menu locations.
	 * Child themes can register additional locations without removing these.
	 */
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Navigation', 'uppa-base' ),
			'footer'  => esc_html__( 'Footer Navigation', 'uppa-base' ),
		)
	);
}
add_action( 'after_setup_theme', 'uppa_base_setup' );

/**
 * Registers the theme's sidebar and footer widget areas.
 *
 * Called on the {@see 'widgets_init'} hook so the sidebars are available
 * to both the Customizer and the block-based widget editor.
 *
 * @since 1.0.0
 * @return void
 */
function uppa_base_widgets_init() {

	/**
	 * Main sidebar widget area.
	 *
	 * Displayed via get_sidebar() in single.php, page.php, and archive.php.
	 * Visibility is controlled in sidebar.php with is_active_sidebar().
	 */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'uppa-base' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in the sidebar.', 'uppa-base' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	/**
	 * Footer widget area.
	 *
	 * Displayed via the template-parts/footer/footer-widgets.php partial.
	 * Hidden automatically by that partial when no widgets are assigned.
	 */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area', 'uppa-base' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in the footer.', 'uppa-base' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'uppa_base_widgets_init' );
