<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\SettingsField as Testee;
use WP_Mock\Tools\TestCase;

class SettingsFieldViewTest extends TestCase {

	public function test_add() {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get_option_name' )
			->andReturn( 'option_name' );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		WP_Mock::wpFunction(
			'esc_html_x',
			array(
				'times'  => 1,
				'args' => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					'default-post-date',
				),
			)
		);

		WP_Mock::wpFunction(
			'add_settings_field',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					array( $testee, 'render' ),
					'general',
				),
			)
		);

		$testee->add();

		$this->assertConditionsMet();
	}

	public function test_render() {

		$option_name = 'option_name';

		$value = '1984-05-02';

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get_option_name' )
			->andReturn( $option_name );
		$settings->shouldReceive( 'get' )
			->andReturn( $value );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		WP_Mock::wpPassthruFunction(
			'esc_html_x',
			array(
				'times' => 1,
				'args' => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					'default-post-date',
				),
			)
		);

		WP_Mock::wpPassthruFunction(
			'esc_attr',
			array(
				'times' => 1,
				'args' => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$output = <<<'HTML'
		<input type="text" id="default-post-date" name="%s"
			value="%s" maxlength="10" placeholder="YYYY-MM-DD">
		<p class="description">
			Please enter the default post date according to the <code>YYYY-MM-DD</code> date format.
		</p>
HTML;
		$output = sprintf( $output, $option_name, $value );

		$this->expectOutputString( $output );

		$testee->render();

		$this->assertConditionsMet();
	}

}
