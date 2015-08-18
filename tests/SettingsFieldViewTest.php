<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Views\SettingsField as Testee;
use WP_Mock\Tools\TestCase;

class SettingsFieldViewTest extends TestCase {

	public function test_add() {

		$option_name = '_default_post_date';

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get_option_name' )
			->andReturn( $option_name );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		$label_text = 'Label text';

		WP_Mock::wpFunction(
			'esc_html_x',
			array(
				'times'  => 1,
				'return' => $label_text,
			)
		);

		$title = sprintf( '<label for="default-post-date">%s</label>', $label_text );

		WP_Mock::wpFunction(
			'add_settings_field',
			array(
				'args'  => array(
					$option_name = '_default_post_date',
					$title,
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

		$value = '1984-05-02';

		$settings = Mockery::mock( 'tf\DefaultPostDate\Models\Settings' );
		$settings->shouldReceive( 'get_option_name' )
			->andReturn( '_default_post_date' );
		$settings->shouldReceive( 'get' )
			->andReturn( $value );

		/** @var tf\DefaultPostDate\Models\Settings $settings */
		$testee = new Testee( $settings );

		WP_Mock::wpPassthruFunction( 'esc_html_x', array( 'times' => 1 ) );

		WP_Mock::wpPassthruFunction( 'esc_attr', array( 'times' => 1 ) );

		$output = <<<'HTML'
		<input type="text" id="default-post-date" name="_default_post_date"
			value="%s" maxlength="10" placeholder="YYYY-MM-DD">
		<p class="description">
			Please enter the default post date according to the <code>YYYY-MM-DD</code> date format.
		</p>
HTML;
		$output = sprintf( $output, $value );

		$this->expectOutputString( $output );

		$testee->render();

		$this->assertConditionsMet();
	}

}
