<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\SettingsField as Testee;
use WP_Mock\Tools\TestCase;

class SettingsFieldViewTest extends TestCase {

	public function test_add() {

		$model = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$model->shouldReceive( 'get_option_name' )
			->andReturn( '_default_post_date' );

		/** @var tf\DefaultPostDate\Models\Settings $model */
		$testee = new Testee( $model );

		WP_Mock::wpPassthruFunction( 'esc_html_x', array( 'times' => 1 ) );

		WP_Mock::wpFunction(
			'add_settings_field',
			array(
				'args'  => array(
					'_default_post_date',
					'<label for="default-post-date">Default Post Date</label>',
					array( $testee, 'render' ),
					'general',
				),
				'times' => 1,
			)
		);

		$testee->add();
	}

	public function test_render() {

		$model = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$model->shouldReceive( 'get_option_name' )
			->andReturn( '_default_post_date' );
		$model->shouldReceive( 'get' )
			->andReturn( '1984-05-02' );

		/** @var tf\DefaultPostDate\Models\Settings $model */
		$testee = new Testee( $model );

		WP_Mock::wpPassthruFunction( 'esc_html_x', array( 'times' => 1 ) );

		WP_Mock::wpPassthruFunction( 'esc_attr', array( 'times' => 1 ) );

		$output = <<<'HTML'
		<input type="text" id="default-post-date" name="_default_post_date"
			value="1984-05-02" maxlength="10" placeholder="YYYY-MM-DD">
		<p class="description">
			Please enter the default post date according to the <code>YYYY-MM-DD</code> date format.
		</p>
HTML;

		$this->expectOutputString( $output );

		$testee->render();
	}

}
