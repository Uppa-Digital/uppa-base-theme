<?php
/**
 * Template part: site branding — custom logo, site title, and tagline.
 *
 * When a custom logo is set, the logo is the only visual branding element;
 * the site title is output as screen-reader text for assistive technology.
 * When no logo is set, the site title is output visibly.
 *
 * Title tag rules (avoids duplicate h1 on paginated/archive pages):
 *   - <h1> only on the static front page or the blog index (is_front_page()
 *     or is_home() when it IS the front page).
 *   - <p> everywhere else — the in-template page title is the h1.
 *
 * @package uppa-base
 * @since   1.0.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="site-branding">

	<?php if ( has_custom_logo() ) : ?>

		<div class="site-logo">
			<?php the_custom_logo(); ?>
		</div>

		<p class="site-title screen-reader-text">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</p>

	<?php elseif ( is_front_page() && is_home() ) : ?>

		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h1>

	<?php else : ?>

		<p class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</p>

	<?php endif; ?>

	<?php
	$uppa_description = get_bloginfo( 'description', 'display' );
	if ( $uppa_description || is_customize_preview() ) :
		?>
		<p class="site-description">
			<?php echo esc_html( $uppa_description ); ?>
		</p>
	<?php endif; ?>

</div><!-- .site-branding -->
