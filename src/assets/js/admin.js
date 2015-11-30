/* global defaultPostDateSettings */
( function( $, settings ) {
	'use strict';

	var $timestampdiv = $( '#timestampdiv' ),
		$saveTimestamp = $timestampdiv.find( '.save-timestamp' );

	if ( $timestampdiv.length ) {
		$timestampdiv
			.find( '#jj' ).attr( 'value', settings.day )
			.end()
			.find( '#mm' )
			.find( 'option[selected="selected"]' ).removeAttr( 'selected' )
			.end()
			.find( 'option[value="' + settings.month + '"]' ).attr( 'selected', 'selected' )
			.end()
			.end()
			.find( '#a' ).attr( 'value', settings.year );
	}

	if ( $saveTimestamp.length ) {
		$saveTimestamp.trigger( 'click' );
	}

} )( jQuery, defaultPostDateSettings );
