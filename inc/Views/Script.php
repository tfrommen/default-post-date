<?php # -*- coding: utf-8 -*-

namespace tf\DefaultPostDate\Views;

use tf\DefaultPostDate\Models\Settings;

/**
 * Class Script
 *
 * @package tf\DefaultPostDate\Views
 */
class Script {

	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Settings $settings Settings model.
	 */
	public function __construct( Settings $settings ) {

		$this->settings = $settings;
	}

	/**
	 * Render the script tag to set the post date according to the saved default date.
	 *
	 * @wp-hook post_submitbox_misc_actions
	 *
	 * @return void
	 */
	public function render() {

		$value = $this->settings->get();
		if ( $value === '' ) {
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
