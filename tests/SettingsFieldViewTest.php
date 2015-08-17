<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\SettingsField as Testee;
use WP_Mock\Tools\TestCase;

class SettingsFieldViewTest extends TestCase {

	public function test___construct() {

		$option_name = '_default_post_date';

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get_option_name' )
			->andReturn( $option_name );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		$this->assertAttributeSame( 'default-post-date', 'id', $testee );

		$this->assertAttributeSame( $option_name, 'option_name', $testee );

		$this->assertAttributeSame( $settings, 'settings', $testee );
	}

	public function test_add() {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get_option_name' )
			->andReturn( '_default_post_date' );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

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

		$this->assertConditionsMet();
	}

	public function test_render() {

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get_option_name' )
			->andReturn( '_default_post_date' );
		$settings->shouldReceive( 'get' )
			->andReturn( '1984-05-02' );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

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

		$this->assertConditionsMet();
	}

}
