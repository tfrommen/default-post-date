<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\Asset;

use Mockery;
use tfrommen\DefaultPostDate\Asset\Script as Testee;
use tfrommen\DefaultPostDate\Setting\Option;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the script model.
 */
class ScriptTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Asset\Script::enqueue
	 * @dataProvider provide_enqueue_data
	 *
	 * @param bool         $expected
	 * @param string|false $option_value
	 *
	 * @return void
	 */
	public function test_enqueue( $expected, $option_value ) {

		$file = '/path/to/file.php';

		/** @var Option $option */
		$option = Mockery::mock( 'tfrommen\DefaultPostDate\Setting\Option' )
			->shouldReceive( 'get' )
			->andReturn( $option_value )
			->getMock();

		$testee = new Testee( $file, $option );

		WP_Mock::wpFunction(
			'plugin_dir_url',
			array(
				'args'   => array(
					$file,
				),
				'return' => '',
			)
		);

		WP_Mock::wpPassthruFunction(
			'plugin_dir_path',
			array(
				'args' => array(
					$file,
				),
			)
		);

		$handle = 'default-post-date-admin';

		WP_Mock::wpFunction(
			'wp_enqueue_script',
			array(
				'args' => array(
					$handle,
					Mockery::type( 'string' ),
					array( 'jquery' ),
					Mockery::any(),
					true,
				),
			)
		);

		WP_Mock::wpFunction(
			'wp_localize_script',
			array(
				'args' => array(
					$handle,
					Mockery::type( 'string' ),
					Mockery::type( 'array' ),
				),
			)
		);

		// Error suppression due to filemtime().
		$this->assertSame( $expected, @$testee->enqueue() );

		$this->assertConditionsMet();
	}

	/**
	 * Data provider for test_enqueue().
	 *
	 * @return array[]
	 */
	public function provide_enqueue_data() {

		return array(
			'no_option_value' => array(
				'expected'     => false,
				'option_value' => false,
			),
			'empty_option_value' => array(
				'expected'     => false,
				'option_value' => '',
			),
			'invalid_option_value' => array(
				'expected'     => false,
				'option_value' => 'invalid',
			),
			'valid_option_value' => array(
				'expected'     => true,
				'option_value' => '1984-05-02',
			),
		);
	}
}
