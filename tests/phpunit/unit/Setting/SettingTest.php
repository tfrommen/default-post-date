<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\Setting;

use Mockery;
use tfrommen\DefaultPostDate\Setting\Option;
use tfrommen\DefaultPostDate\Setting\Sanitizer;
use tfrommen\DefaultPostDate\Setting\Setting as Testee;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the setting model.
 */
class SettingTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Setting\Setting::register
	 *
	 * @return void
	 */
	public function test_register() {

		$option_group = 'option_group';

		$option_name = 'plugin_option';

		/** @var Option $option */
		$option = Mockery::mock( 'tfrommen\DefaultPostDate\Setting\Option' )
			->shouldReceive( 'get_group' )
			->andReturn( $option_group )
			->shouldReceive( 'get_name' )
			->andReturn( $option_name )
			->getMock();

		/** @var Sanitizer $sanitizer */
		$sanitizer = Mockery::mock( 'tfrommen\DefaultPostDate\Setting\Sanitizer' );

		$testee = new Testee( $option, $sanitizer );

		WP_Mock::wpFunction(
			'register_setting',
			array(
				'args' => array(
					$option_group,
					$option_name,
					array( $sanitizer, 'sanitize' ),
				),
			)
		);

		$testee->register();

		$this->assertConditionsMet();
	}
}
