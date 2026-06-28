/**
 * Navigation — mobile menu toggle and keyboard accessibility.
 *
 * @package uppa-base
 * @since   1.0.0
 */

( function () {
	'use strict';

	const toggle = document.querySelector( '.menu-toggle' );
	const menu   = document.getElementById( 'primary-menu' );

	if ( ! toggle || ! menu ) {
		return;
	}

	toggle.addEventListener( 'click', function () {
		const expanded = this.getAttribute( 'aria-expanded' ) === 'true';
		this.setAttribute( 'aria-expanded', String( ! expanded ) );
		menu.classList.toggle( 'is-open', ! expanded );
	} );
} )();
