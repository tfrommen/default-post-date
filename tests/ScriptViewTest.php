<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\Script as Testee;
use WP_Mock\Tools\TestCase;

class ScriptViewTest extends TestCase {

	public function test___construct() {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		$this->assertAttributeSame( $settings, 'settings', $testee );
	}

	public function test_render_early_return() {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get' )
			->andReturn( '' );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		$this->expectOutputString( '' );

		$testee->render();
	}

	public function test_render() {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get' )
			->andReturn( '1984-05-02' );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		WP_Mock::wpPassthruFunction( '__', array( 'times' => 1 ) );

		WP_Mock::wpFunction(
			'date_i18n',
			array(
				'times'  => 1,
				'return' => '1984-05-02',
			)
		);

		WP_Mock::wpPassthruFunction( 'esc_js', array( 'times' => 1 ) );

		$output = <<<'HTML'
		<script>
			( function( $ ) {
				'use strict';

				var $timestampdiv = $( '#timestampdiv' );

				if ( $timestampdiv.length ) {
					$timestampdiv
						.find( '#jj' ).attr( 'value', '02' )
						.end()
						.find( '#mm' )
						.find( 'option[selected="selected"]' ).removeAttr( 'selected' )
						.end()
						.find( 'option[value="05"]' ).attr( 'selected', 'selected' )
						.end()
						.end()
						.find( '#a' ).attr( 'value', '1984' );
				}

				var $timestamp = $( '#timestamp' ).find( 'b' );

				if ( $timestamp.length ) {
					$timestamp.html( '1984-05-02' );
				}
			} )( jQuery );
		</script>
HTML;

		$this->expectOutputString( $output );

		$testee->render();

		$this->assertConditionsMet();
	}

}
