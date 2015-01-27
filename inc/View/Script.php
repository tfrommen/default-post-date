<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\View;

use tf\DefaultPostDate\Model;

/**
 * Class Script
 *
 * @package tf\DefaultPostDate\View
 */
class Script {

	/**
	 * Print script tag to set post date according to saved default.
	 *
	 * @wp-hook admin_footer-post-new.php
	 *
	 * @return void
	 */
	public function render() {

		$value = Model\Option::get();
		if ( ! $value ) {
			return;
		}

		$time = strtotime( $value );

		$day = date( 'd', $time );
		$month = date( 'm', $time );
		$year = date( 'Y', $time );

		$datef = __( 'M j, Y @ G:i' );
		$date = date_i18n( $datef, $time );
		?>
		<script>
			jQuery( function( $ ) {
				'use strict';

				var $timestampdiv = $( '#timestampdiv' );

				if ( $timestampdiv.length ) {
					$timestampdiv
						.find( '#jj' ).attr( 'value', '<?php echo $day; ?>' )
						.end()
						.find( '#mm' )
						.find( 'option[selected="selected"]' ).removeAttr( 'selected' )
						.end()
						.find( 'option[value="<?php echo $month; ?>"]' ).attr( 'selected', 'selected' )
						.end()
						.end()
						.find( '#a' ).attr( 'value', '<?php echo $year; ?>' );
				}

				var $timestamp = $( '#timestamp' ).find( 'b' );

				if ( $timestamp.length ) {
					$timestamp.html( '<?php echo $date; ?>' );
				}
			} );
		</script>
	<?php
	}

}
