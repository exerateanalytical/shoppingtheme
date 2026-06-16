/**
 * Alluvia — product review reactions.
 * Increments a reaction count via admin-ajax and locks that reaction per
 * browser (localStorage) so a visitor can't spam the same one.
 */
( function () {
	'use strict';

	if ( typeof AlluviaReact === 'undefined' ) {
		return;
	}

	var STORE_KEY = 'alluvia_reactions';

	function reacted() {
		try {
			return JSON.parse( localStorage.getItem( STORE_KEY ) || '{}' );
		} catch ( e ) {
			return {};
		}
	}

	function remember( commentId, reaction ) {
		var data = reacted();
		data[ commentId + ':' + reaction ] = 1;
		try {
			localStorage.setItem( STORE_KEY, JSON.stringify( data ) );
		} catch ( e ) {}
	}

	function markActive() {
		var data = reacted();
		document.querySelectorAll( '.review-reactions' ).forEach( function ( wrap ) {
			var commentId = wrap.getAttribute( 'data-comment' );
			wrap.querySelectorAll( '.review-reaction' ).forEach( function ( btn ) {
				var key = commentId + ':' + btn.getAttribute( 'data-reaction' );
				if ( data[ key ] ) {
					btn.classList.add( 'reacted' );
					btn.disabled = true;
				}
			} );
		} );
	}

	function onClick( e ) {
		var btn = e.target.closest( '.review-reaction' );
		if ( ! btn || btn.disabled ) {
			return;
		}
		var wrap = btn.closest( '.review-reactions' );
		var commentId = wrap.getAttribute( 'data-comment' );
		var reaction = btn.getAttribute( 'data-reaction' );

		btn.disabled = true;
		btn.classList.add( 'reacted' );

		var body = new URLSearchParams();
		body.append( 'action', 'alluvia_react' );
		body.append( 'nonce', AlluviaReact.nonce );
		body.append( 'comment', commentId );
		body.append( 'reaction', reaction );

		fetch( AlluviaReact.ajaxurl, { method: 'POST', credentials: 'same-origin', body: body } )
			.then( function ( r ) { return r.json(); } )
			.then( function ( res ) {
				if ( res && res.success ) {
					var countEl = btn.querySelector( '.reaction-count' );
					if ( countEl ) {
						countEl.textContent = res.data.count;
					}
					remember( commentId, reaction );
				} else {
					btn.disabled = false;
					btn.classList.remove( 'reacted' );
				}
			} )
			.catch( function () {
				btn.disabled = false;
				btn.classList.remove( 'reacted' );
			} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		markActive();
		document.addEventListener( 'click', onClick );
		if ( window.lucide && typeof window.lucide.createIcons === 'function' ) {
			window.lucide.createIcons();
		}
	} );
} )();
