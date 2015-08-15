<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\Script as Testee;
use WP_Mock\Tools\TestCase;

class ScriptViewTest extends TestCase {

	public function test_render_early_return() {

		$model = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$model->shouldReceive( 'get' )
			->andReturn( '' );

		/** @var tf\DefaultPostDate\Models\Settings $model */
		$testee = new Testee( $model );

		$this->expectOutputString( '' );

		$testee->render();
	}

	public function test_render() {

		$model = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$model->shouldReceive( 'get' )
			->andReturn( '1984-05-02' );

		/** @var tf\DefaultPostDate\Models\Settings $model */
		$testee = new Testee( $model );

		WP_Mock::wpPassthruFunction( '__', array( 'times' => 1 ) );

		WP_Mock::wpFunction(
			'date_i18n',
			array(
				'times'  => 1,
				'return' => '1984-05-02',
			)
		);

		WP_Mock::wpPassthruFunction( 'esc_js', array( 'times' => 1 ) );

		$output = <<<HTML
		<script>
			( function( \$ ) {
				'use strict';

				var \$timestampdiv = \$( '#timestampdiv' );

				if ( \$timestampdiv.length ) {
					\$timestampdiv
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

				var \$timestamp = \$( '#timestamp' ).find( 'b' );

				if ( \$timestamp.length ) {
					\$timestamp.html( '1984-05-02' );
				}
			} )( jQuery );
		</script>
HTML;

		$this->expectOutputString( $output );

		$testee->render();
	}

}
