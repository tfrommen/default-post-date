<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\Script as Testee;
use WP_Mock\Tools\TestCase;

class ScriptViewTest extends TestCase {

	/**
	 * @param string $value
	 * @param int    $times
	 * @param string $output
	 *
	 * @dataProvider provide_render_data
	 */
	public function test_render( $value, $times, $output ) {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get' )
			->andReturn( $value );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		WP_Mock::wpPassthruFunction( '__', array( 'times' => $times ) );

		WP_Mock::wpFunction(
			'date_i18n',
			array(
				'times'  => $times,
				'return' => $value,
			)
		);

		WP_Mock::wpPassthruFunction( 'esc_js', array( 'times' => $times ) );

		$this->expectOutputString( $output );

		$testee->render();

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_render_data() {

		$year = '1984';
		$month = '05';
		$day = '02';
		$date = "$year-$month-$day";

		$output = <<<'HTML'
		<script>
			( function( $ ) {
				'use strict';

				var $timestampdiv = $( '#timestampdiv' );

				if ( $timestampdiv.length ) {
					$timestampdiv
						.find( '#jj' ).attr( 'value', '%s' )
						.end()
						.find( '#mm' )
						.find( 'option[selected="selected"]' ).removeAttr( 'selected' )
						.end()
						.find( 'option[value="%s"]' ).attr( 'selected', 'selected' )
						.end()
						.end()
						.find( '#a' ).attr( 'value', '%s' );
				}

				var $timestamp = $( '#timestamp' ).find( 'b' );

				if ( $timestamp.length ) {
					$timestamp.html( '%s' );
				}
			} )( jQuery );
		</script>
HTML;
		$output = sprintf(
			$output,
			$day,
			$month,
			$year,
			$date
		);

		return array(
			array( '', 0, '' ),
			array( $date, 1, $output ),
		);
	}

}
