<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\Update;

use Mockery;
use tfrommen\DefaultPostDate\Update\Updater as Testee;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the updater.
 */
class UpdaterTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Update\Updater::get_option_name
	 *
	 * @return void
	 */
	public function test_get_option_name() {

		$testee = new Testee();

		$this->assertSame( 'default_post_date_version', $testee->get_option_name() );
	}

	/**
	 * @covers       tfrommen\DefaultPostDate\Update\Updater::update
	 * @dataProvider provide_update_data
	 *
	 * @param bool   $expected
	 * @param string $version
	 * @param string $old_version
	 *
	 * @return void
	 */
	public function test_update( $expected, $version, $old_version ) {

		$testee = new Testee( $version );

		$option_name = 'default_post_date_version';

		WP_Mock::wpFunction(
			'get_option',
			array(
				'args'   => array(
					Mockery::type( 'string' ),
				),
				'return' => $old_version,
			)
		);

		WP_Mock::wpFunction(
			'update_option',
			array(
				'args' => array(
					$option_name,
					$version,
				),
			)
		);

		$this->assertSame( $expected, $testee->update() );

		$this->assertConditionsMet();
	}

	/**
	 * Provider for the test_update() method.
	 *
	 * @return array[]
	 */
	public function provide_update_data() {

		$version = '9.9.9';

		return array(
			'no_version'      => array(
				'expected'    => true,
				'version'     => $version,
				'old_version' => '',
			),
			'old_version'     => array(
				'expected'    => true,
				'version'     => $version,
				'old_version' => '0',
			),
			'current_version' => array(
				'expected'    => false,
				'version'     => $version,
				'old_version' => $version,
			),
		);
	}
}
