<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\SettingsField;

use Mockery;
use tfrommen\DefaultPostDate\Setting\Option;
use tfrommen\DefaultPostDate\SettingsField\View as Testee;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the settings field view.
 */
class ViewTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\SettingsField\View::add
	 *
	 * @return void
	 */
	public function test_add() {

		$option_group = 'option_group';

		$option_name = 'plugin_option';

		/** @var Option $option */
		$option = Mockery::mock( 'tfrommen\DefaultPostDate\Setting\Option' )
			->shouldReceive( 'get_group' )
			->andReturn( $option_group )
			->shouldReceive( 'get_name' )
			->andReturn( $option_name )
			->getMock();

		$testee = new Testee( $option );

		WP_Mock::wpFunction(
			'esc_html_x',
			array(
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
				'args'  => array(
					$option_name,
					WP_Mock\Functions::type( 'string' ),
					array( $testee, 'render' ),
					$option_group,
				),
			)
		);

		$testee->add();

		$this->assertConditionsMet();
	}

	/**
	 * @covers tfrommen\DefaultPostDate\SettingsField\View::render
	 *
	 * @return void
	 */
	public function test_render() {

		$option_value = '1984-05-02';

		$option_name = 'option_name';

		/** @var Option $option */
		$option = Mockery::mock( 'tfrommen\DefaultPostDate\Setting\Option' )
			->shouldReceive( 'get' )
			->andReturn( $option_value )
			->shouldReceive( 'get_name' )
			->andReturn( $option_name )
			->getMock();

		$testee = new Testee( $option );

		WP_Mock::wpPassthruFunction(
			'esc_html__',
			array(
				'args' => array(
					WP_Mock\Functions::type( 'string' ),
					'default-post-date',
				),
			)
		);

		WP_Mock::wpPassthruFunction(
			'esc_attr',
			array(
				'args' => array(
					$option_value,
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
		$output = sprintf( $output, $option_name, $option_value );

		$this->expectOutputString( $output );

		$testee->render();

		$this->assertConditionsMet();
	}
}
