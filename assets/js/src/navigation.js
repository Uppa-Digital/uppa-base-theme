/**
 * navigation.js
 *
 * Mobile menu toggle with full keyboard accessibility:
 *   - Opens/closes the primary menu on hamburger button click.
 *   - Manages aria-expanded on the toggle button.
 *   - Traps focus within the open menu (Tab / Shift+Tab cycle).
 *   - Closes on Escape and returns focus to the toggle button.
 *   - Closes when the user clicks outside the nav.
 *
 * Wires to markup in template-parts/header/navigation.php:
 *   Toggle button:  .menu-toggle[aria-controls="primary-menu"][aria-expanded]
 *   Menu:           #primary-menu
 *
 * Zero dependencies — vanilla JS only.
 *
 * @package uppa-base
 * @since   1.0.0
 */

( function () {
	'use strict';

	// -------------------------------------------------------------------------
	// Elements
	// -------------------------------------------------------------------------

	const toggle = document.querySelector( '.menu-toggle' );
	const menu   = document.getElementById( 'primary-menu' );
	const nav    = document.getElementById( 'site-navigation' );

	// Bail if the markup is not present (e.g. no primary menu assigned).
	if ( ! toggle || ! menu ) {
		return;
	}

	// -------------------------------------------------------------------------
	// Focusable elements selector
	// Excludes elements with tabindex="-1" and disabled form controls.
	// -------------------------------------------------------------------------

	const FOCUSABLE_SELECTOR = [
		'a[href]',
		'button:not([disabled])',
		'input:not([disabled])',
		'select:not([disabled])',
		'textarea:not([disabled])',
		'[tabindex]:not([tabindex="-1"])',
	].join( ', ' );

	// -------------------------------------------------------------------------
	// State helpers
	// -------------------------------------------------------------------------

	/**
	 * Returns true when the menu is currently open.
	 *
	 * @return {boolean}
	 */
	function isOpen() {
		return 'true' === toggle.getAttribute( 'aria-expanded' );
	}

	/**
	 * Returns an array of all focusable elements inside the open menu.
	 *
	 * Queried fresh each call so dynamically added sub-menu items are included.
	 *
	 * @return {HTMLElement[]}
	 */
	function getFocusableItems() {
		return Array.prototype.slice.call( menu.querySelectorAll( FOCUSABLE_SELECTOR ) );
	}

	// -------------------------------------------------------------------------
	// Open / close
	// -------------------------------------------------------------------------

	/**
	 * Opens the navigation menu.
	 *
	 * Sets aria-expanded, adds the is-open state class, and moves focus to
	 * the first focusable item inside the menu so keyboard users land
	 * immediately in the navigation.
	 *
	 * @return {void}
	 */
	function openMenu() {
		toggle.setAttribute( 'aria-expanded', 'true' );
		menu.classList.add( 'is-open' );

		// Move focus to first menu item so keyboard users don't have to Tab
		// through the rest of the page to reach the navigation.
		const items = getFocusableItems();
		if ( items.length ) {
			items[ 0 ].focus();
		}
	}

	/**
	 * Closes the navigation menu and returns focus to the toggle button.
	 *
	 * @param {boolean} [returnFocus=true] Whether to return focus to the toggle.
	 * @return {void}
	 */
	function closeMenu( returnFocus ) {
		toggle.setAttribute( 'aria-expanded', 'false' );
		menu.classList.remove( 'is-open' );

		if ( false !== returnFocus ) {
			toggle.focus();
		}
	}

	// -------------------------------------------------------------------------
	// Toggle button click
	// -------------------------------------------------------------------------

	toggle.addEventListener( 'click', function () {
		if ( isOpen() ) {
			closeMenu();
		} else {
			openMenu();
		}
	} );

	// -------------------------------------------------------------------------
	// Keyboard: Escape closes the menu
	// -------------------------------------------------------------------------

	document.addEventListener( 'keydown', function ( event ) {
		if ( ! isOpen() ) {
			return;
		}

		if ( 'Escape' === event.key || 'Esc' === event.key ) {
			closeMenu();
		}
	} );

	// -------------------------------------------------------------------------
	// Keyboard: focus trap (Tab / Shift+Tab cycles within open menu)
	// -------------------------------------------------------------------------

	document.addEventListener( 'keydown', function ( event ) {
		if ( ! isOpen() || 'Tab' !== event.key ) {
			return;
		}

		const items   = getFocusableItems();
		const total   = items.length;
		const active  = document.activeElement;

		if ( 0 === total ) {
			// Menu has no focusable children; keep focus on toggle.
			event.preventDefault();
			toggle.focus();
			return;
		}

		const first = items[ 0 ];
		const last  = items[ total - 1 ];

		if ( event.shiftKey ) {
			// Shift+Tab from the first item wraps to the last.
			if ( active === first || active === toggle ) {
				event.preventDefault();
				last.focus();
			}
		} else {
			// Tab from the last item wraps to the first.
			if ( active === last ) {
				event.preventDefault();
				first.focus();
			}
		}
	} );

	// -------------------------------------------------------------------------
	// Click outside the nav: close menu
	// -------------------------------------------------------------------------

	document.addEventListener( 'click', function ( event ) {
		if ( ! isOpen() ) {
			return;
		}

		// nav may be null if the markup differs; fall back to menu + toggle.
		const container = nav || menu;

		if ( ! container.contains( event.target ) && event.target !== toggle ) {
			closeMenu( false ); // Don't steal focus from wherever the user clicked.
		}
	} );

	// -------------------------------------------------------------------------
	// Sub-menu toggles (injected by UPPA_Base_Nav_Walker)
	// Each .sub-menu-toggle button expands/collapses its sibling .sub-menu.
	// -------------------------------------------------------------------------

	if ( nav ) {
		nav.addEventListener( 'click', function ( event ) {
			const btn = event.target.closest( '.sub-menu-toggle' );
			if ( ! btn ) {
				return;
			}

			const expanded = 'true' === btn.getAttribute( 'aria-expanded' );
			const subMenu  = btn.nextElementSibling;

			btn.setAttribute( 'aria-expanded', expanded ? 'false' : 'true' );
			btn.classList.toggle( 'is-active', ! expanded );

			if ( subMenu && subMenu.classList.contains( 'sub-menu' ) ) {
				subMenu.classList.toggle( 'is-open', ! expanded );
			}
		} );

		// Close open sub-menus when focus leaves the nav entirely.
		nav.addEventListener( 'focusout', function ( event ) {
			if ( ! nav.contains( event.relatedTarget ) ) {
				nav.querySelectorAll( '.sub-menu-toggle[aria-expanded="true"]' ).forEach( function ( btn ) {
					btn.setAttribute( 'aria-expanded', 'false' );
					btn.classList.remove( 'is-active' );
					const subMenu = btn.nextElementSibling;
					if ( subMenu ) {
						subMenu.classList.remove( 'is-open' );
					}
				} );
			}
		} );
	}

} )();
