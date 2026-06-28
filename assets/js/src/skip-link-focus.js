/**
 * skip-link-focus.js
 *
 * Fixes skip-link focus behaviour in WebKit browsers (Safari).
 *
 * The problem:
 *   When a skip link like <a href="#main"> is activated, Chrome and Firefox
 *   move both scroll position AND keyboard focus to the target element.
 *   Safari (WebKit) moves scroll position but does NOT move keyboard focus
 *   to a non-natively-focusable element such as <main id="main">. The next
 *   Tab keypress therefore lands on the first interactive element in the
 *   document, not after the main content — defeating the purpose of the
 *   skip link for keyboard users.
 *
 * The fix:
 *   On skip-link click, find the fragment target, temporarily assign
 *   tabindex="-1" if it is not natively focusable, call .focus(), then
 *   remove the temporary tabindex once the element loses focus so it does
 *   not become a permanent Tab stop.
 *
 * Target: #main — matches the id on <main> in every UPPA Base template file
 *         and the href in template-parts/global/skip-link.php.
 *
 * Zero dependencies — vanilla JS only.
 *
 * @package uppa-base
 * @since   1.0.0
 */

( function () {
	'use strict';

	// -------------------------------------------------------------------------
	// Natively focusable elements do not need a tabindex patch.
	// Everything else (div, main, section, article …) does.
	// -------------------------------------------------------------------------

	var NATIVE_FOCUSABLE = /^(a|button|details|input|select|textarea)$/i;

	/**
	 * Returns true if the element receives focus natively without tabindex.
	 *
	 * @param  {HTMLElement} el
	 * @return {boolean}
	 */
	function isNativelyFocusable( el ) {
		return NATIVE_FOCUSABLE.test( el.nodeName );
	}

	// -------------------------------------------------------------------------
	// Attach to every skip link on the page.
	// (Most themes have one; this handles multiple gracefully.)
	// -------------------------------------------------------------------------

	var skipLinks = document.querySelectorAll( '.skip-link' );

	if ( ! skipLinks.length ) {
		return;
	}

	Array.prototype.forEach.call( skipLinks, function ( link ) {

		link.addEventListener( 'click', function ( event ) { // eslint-disable-line no-unused-vars

			var href = link.getAttribute( 'href' );

			// Only process fragment URLs (e.g. "#main").
			if ( ! href || '#' !== href.charAt( 0 ) ) {
				return;
			}

			var targetId = href.slice( 1 );
			var target   = document.getElementById( targetId );

			if ( ! target ) {
				return;
			}

			// ----------------------------------------------------------------
			// Patch: temporarily make non-focusable elements programmatically
			// focusable, then clean up as soon as focus leaves.
			// ----------------------------------------------------------------

			var addedTabindex = false;

			if ( ! isNativelyFocusable( target ) && ! target.hasAttribute( 'tabindex' ) ) {
				target.setAttribute( 'tabindex', '-1' );
				addedTabindex = true;
			}

			target.focus();

			// Remove the temporary tabindex on blur so the element is not
			// permanently reachable via Tab — it is a content landmark, not a
			// Tab stop, and adding it permanently would confuse screen reader
			// users who do not expect <main> to be in the Tab order.
			if ( addedTabindex ) {
				target.addEventListener( 'blur', function handleBlur() {
					target.removeAttribute( 'tabindex' );
					target.removeEventListener( 'blur', handleBlur );
				} );
			}
		} );

	} );

} )();
