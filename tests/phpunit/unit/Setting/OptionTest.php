<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\Setting;

use Mockery;
use tfrommen\DefaultPostDate\Setting\Option as Testee;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the option model.
 */
class OptionTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Setting\Option::get_group
	 *
	 * @return void
	 */
	public function test_get_group() {

		$testee = new Testee();

		$this->assertSame( 'writing', $testee->get_group() );
	}

	/**
	 * @covers tfrommen\DefaultPostDate\Setting\Option::get_name
	 *
	 * @return void
	 */
	public function test_get_name() {

		$testee = new Testee();

		$this->assertSame( 'default_post_date', $testee->get_name() );
	}

	/**
	 * @covers       tfrommen\DefaultPostDate\Setting\Option::get
	 * @dataProvider provide_get_data
	 *
	 * @param string $expected
	 * @param string $default
	 * @param mixed  $option
	 *
	 * @return void
	 */
	public function test_get( $expected, $default, $option ) {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'get_option',
			array(
				'args'   => array(
					Mockery::type( 'string' ),
					$default,
				),
				'return' => $option,
			)
		);

		$this->assertSame( $expected, $testee->get() );
	}

	/**
	 * Data provider for test_get().
	 *
	 * @return array[]
	 */
	public function provide_get_data() {

		$value = 'value';

		return array(
			'no_option' => array(
				'expected' => '',
				'default'  => '',
				'option'   => null,
			),
			'option'    => array(
				'expected' => $value,
				'default'  => '',
				'option'   => $value,
			),
		);
	}
}
