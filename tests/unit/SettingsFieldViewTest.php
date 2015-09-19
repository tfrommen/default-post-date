<?php # -*- coding: utf-8 -*-

use tfrommen\DefaultPostDate\Views\SettingsField as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the SettingsFieldView class.
 */
class SettingsFieldViewTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Views\SettingsField::add
	 *
	 * @return void
	 */
	public function test_add() {

		/** @var tfrommen\DefaultPostDate\Models\Settings $settings */
		$settings = Mockery::mock( 'tfrommen\DefaultPostDate\Models\Settings' )
			->shouldReceive( 'get_option_name' )
			->andReturn( 'option_name' )
			->getMock();

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
					'writing',
				),
			)
		);

		$testee->add();

		$this->assertConditionsMet();
	}

	/**
	 * @covers tfrommen\DefaultPostDate\Views\SettingsField::render
	 *
	 * @return void
	 */
	public function test_render() {

		$option_name = 'option_name';

		$value = '1984-05-02';

		/** @var tfrommen\DefaultPostDate\Models\Settings $settings */
		$settings = Mockery::mock( 'tfrommen\DefaultPostDate\Models\Settings' )
			->shouldReceive( 'get_option_name' )
			->andReturn( $option_name )
			->getMock()
			->shouldReceive( 'get' )
			->andReturn( $value )
			->getMock();

		$testee = new Testee( $settings );

		WP_Mock::wpPassthruFunction(
			'esc_html__',
			array(
				'times' => 1,
				'args' => array(
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
			value="%s" maxlength="10"
			placeholder="YYYY-MM-DD">
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
