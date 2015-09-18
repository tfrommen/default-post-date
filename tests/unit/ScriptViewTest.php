<?php # -*- coding: utf-8 -*-

use tfrommen\DefaultPostDate\Views\Script as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the ScriptView class.
 */
class ScriptViewTest extends TestCase {

	/**
	 * @covers       tfrommen\DefaultPostDate\Views\Script::render
	 * @dataProvider provide_render_data
	 *
	 * @param string $output
	 * @param string $value
	 * @param int    $times
	 */
	public function test_render( $output, $value, $times ) {

		/** @var tfrommen\DefaultPostDate\Models\Settings $settings */
		$settings = Mockery::mock( 'tfrommen\DefaultPostDate\Models\Settings' )
			->shouldReceive( 'get' )
			->andReturn( $value )
			->getMock();

		$testee = new Testee( $settings );

		WP_Mock::wpPassthruFunction(
			'_x',
			array(
				'times' => $times,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
					'skip',
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
			'default'           => array(
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
