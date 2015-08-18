<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Models\Settings as Testee;
use WP_Mock\Tools\TestCase;

class SettingsModelTest extends TestCase {

	public function test_register() {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'register_setting',
			array(
				'args'  => array(
					'general',
					'_default_post_date',
					array( $testee, 'sanitize' ),
				),
				'times' => 1,
			)
		);

		$testee->register();

		$this->assertConditionsMet();
	}

	/**
	 * @param string $sanitized_value
	 * @param string $value
	 *
	 * @dataProvider provide_sanitize_data
	 */
	public function test_sanitize( $sanitized_value, $value ) {

		$testee = new Testee();

		$this->assertSame( $sanitized_value, $testee->sanitize( $value ) );
	}

	/**
	 * @return array
	 */
	public function provide_sanitize_data() {

		return array(
			array( '', '' ),
			array( '', 'foo' ),
			array( '', '1984-05-32' ),
			array( '', '1984-13-02' ),
			array( $value = '1984-05-02', $value ),
		);
	}

	public function test_get() {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'get_option',
			array(
				'args'  => array(
					'_default_post_date',
					'',
				),
				'times' => 1,
			)
		);

		$testee->get();

		$this->assertConditionsMet();
	}

}
