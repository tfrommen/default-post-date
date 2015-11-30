<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\Setting;

use Mockery;
use tfrommen\DefaultPostDate\Setting\Sanitizer as Testee;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the sanitizer model.
 */
class SanitizerTest extends TestCase {

	/**
	 * @covers       tfrommen\DefaultPostDate\Setting\Sanitizer::sanitize
	 * @dataProvider provide_sanitize_data
	 *
	 * @param string $expected
	 * @param string $data
	 *
	 * @return void
	 */
	public function test_sanitize( $expected, $data ) {

		$testee = new Testee();

		$this->assertSame( $expected, $testee->sanitize( $data ) );

		$this->assertConditionsMet();
	}

	/**
	 * Data provider for test_sanitize().
	 *
	 * @return array[]
	 */
	public function provide_sanitize_data() {

		$data = '1984-05-02';

		return array(
			'empty_data'   => array(
				'expected' => '',
				'data'     => '',
			),
			'invalid_data' => array(
				'expected' => '',
				'data'     => 'invalid',
			),
			'valid_data'   => array(
				'expected' => $data,
				'data'     => $data,
			),
		);
	}

}
