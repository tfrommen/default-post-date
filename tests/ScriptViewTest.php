<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\Script as Testee;
use WP_Mock\Tools\TestCase;

class ScriptViewTest extends TestCase {

	/**
	 * @dataProvider provide_render_data
	 *
	 * @param string $output
	 * @param string $value
	 * @param int    $times
	 */
	public function test_render( $output, $value, $times ) {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get' )
			->andReturn( $value );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		WP_Mock::wpPassthruFunction(
			'__',
			array(
				'times' => $times,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		WP_Mock::wpFunction(
			'date_i18n',
			array(
				'times'  => $times,
				'args'   => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'int' ),
				),
				'return' => $value,
			)
		);

		WP_Mock::wpPassthruFunction(
			'esc_js',
			array(
				'times' => $times,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$this->expectOutputString( $output );

		$testee->render();

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_render_data() {

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

		$year = '1984';
		$month = '05';
		$day = '02';
		$date = "$year-$month-$day";

		return array(
			'valid_set'         => array(
				'output' => sprintf( $output, $day, $month, $year, $date ),
				'value'  => $date,
				'times'  => 1,
			),
			'empty_value'       => array(
				'output' => '',
				'value'  => '',
				'times'  => 0,
			),
			'invalid_timestamp' => array(
				'output' => '',
				'value'  => 'invalid_timestamp',
				'times'  => 0,
			),
		);
	}

}
