<?php # -*- coding: utf-8 -*-

use tfrommen\DefaultPostDate\Models\Settings as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the SettingsModel class.
 */
class SettingsModelTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Models\Settings::register
	 *
	 * @return void
	 */
	public function test_register() {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'register_setting',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					array( $testee, 'sanitize' ),
				),
			)
		);

		$testee->register();

		$this->assertConditionsMet();
	}

	/**
	 * @covers       tfrommen\DefaultPostDate\Models\Settings::sanitize
	 * @dataProvider provide_sanitize_data
	 *
	 * @param string $expected
	 * @param string $value
	 */
	public function test_sanitize( $expected, $value ) {

		$testee = new Testee();

		$this->assertSame( $expected, $testee->sanitize( $value ) );
	}

	/**
	 * @return array
	 */
	public function provide_sanitize_data() {

		$value = '1984-05-02';

		return array(
			'default'       => array(
				'expected' => $value,
				'value'    => $value,
			),
			'empty_value'   => array(
				'expected' => '',
				'value'    => '',
			),
			'invalid_date'  => array(
				'expected' => '',
				'value'    => 'foo',
			),
			'invalid_month' => array(
				'expected' => '',
				'value'    => '1984-05-32',
			),
			'invalid_day'   => array(
				'expected' => '',
				'value'    => '1984-13-02',
			),
		);
	}

	/**
	 * @covers tfrommen\DefaultPostDate\Models\Settings::get
	 *
	 * @return void
	 */
	public function test_get() {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'get_option',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
					'',
				),
			)
		);

		$testee->get();

		$this->assertConditionsMet();
	}

}
