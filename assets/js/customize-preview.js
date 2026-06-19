/**
 * Alluvia — live Customizer preview for Theme Colors.
 * Binds the three color settings to the site's CSS custom properties so changes
 * in Appearance → Customize → Theme Colors update the preview instantly (no
 * reload). The derived shades use the same color-mix() formulas as the PHP
 * output in functions.php so the live preview matches the saved result exactly.
 */
( function () {
	function setVars( map ) {
		var root = document.documentElement;
		for ( var key in map ) {
			if ( Object.prototype.hasOwnProperty.call( map, key ) ) {
				root.style.setProperty( key, map[ key ] );
			}
		}
	}

	wp.customize( 'alluvia_color_primary', function ( value ) {
		value.bind( function ( c ) {
			setVars( {
				'--teal': c,
				'--teal-dark': 'color-mix(in srgb,' + c + ',#000 26%)',
				'--teal-glow': 'color-mix(in srgb,' + c + ' 18%,transparent)'
			} );
		} );
	} );

	wp.customize( 'alluvia_color_accent', function ( value ) {
		value.bind( function ( c ) {
			setVars( {
				'--gold': c,
				'--gold-light': 'color-mix(in srgb,' + c + ',#fff 28%)'
			} );
		} );
	} );

	wp.customize( 'alluvia_color_bg', function ( value ) {
		value.bind( function ( c ) {
			setVars( {
				'--navy': c,
				'--navy-deep': 'color-mix(in srgb,' + c + ',#000 45%)',
				'--navy-mid': 'color-mix(in srgb,' + c + ',#fff 12%)',
				'--navy-soft': 'color-mix(in srgb,' + c + ',#fff 26%)'
			} );
		} );
	} );
} )();
