/**
 * Skip-link focus fix for IE/Edge.
 *
 * Ensures that the target of a skip link receives focus correctly in browsers
 * that don't move focus when the URL hash changes.
 *
 * @package uppa-base
 * @since   1.0.0
 */

( function () {
	'use strict';

	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( ! isIe ) {
		return;
	}

	document.addEventListener( 'click', function ( event ) {
		var target = event.target;

		if ( target.className.indexOf( 'skip-link' ) === -1 ) {
			return;
		}

		var id      = target.href.split( '#' )[ 1 ];
		var element = document.getElementById( id );

		if ( element ) {
			element.setAttribute( 'tabindex', '-1' );
			element.focus();
		}
	} );
} )();
