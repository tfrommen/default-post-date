<?php # -*- coding: utf-8 -*-

namespace tfrommen\DefaultPostDate\Views;

use tfrommen\DefaultPostDate\Models\Settings;

/**
 * Script view.
 *
 * @package tfrommen\DefaultPostDate\Views
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
		if ( ! $value ) {
			return;
		}

		$time = strtotime( $value );
		if ( ! $time ) {
			return;
		}

		$datef = _x( 'M j, Y @ G:i', 'skip' );
		$date = date_i18n( $datef, $time );
		?>
		<script>
			( function( $ ) {
				'use strict';

				var $timestampdiv = $( '#timestampdiv' );

				if ( $timestampdiv.length ) {
					$timestampdiv
						.find( '#jj' ).attr( 'value', '<?php echo date( 'd', $time ); ?>' )
						.end()
						.find( '#mm' )
						.find( 'option[selected="selected"]' ).removeAttr( 'selected' )
						.end()
						.find( 'option[value="<?php echo date( 'm', $time ); ?>"]' ).attr( 'selected', 'selected' )
						.end()
						.end()
						.find( '#a' ).attr( 'value', '<?php echo date( 'Y', $time ); ?>' );
				}

				var $timestamp = $( '#timestamp' ).find( 'b' );

				if ( $timestamp.length ) {
					$timestamp.html( '<?php echo esc_js( $date ); ?>' );
				}
			} )( jQuery );
		</script>
		<?php
	}

}
