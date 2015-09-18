<?php # -*- coding: utf-8 -*-

use tfrommen\DefaultPostDate\Models\TextDomain as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the TextDomainModel class.
 */
class TextDomainModelTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Models\TextDomain::load
	 *
	 * @return void
	 */
	public function test_load() {

		$file = '/path/to/file.php';

		WP_Mock::wpPassthruFunction(
			'plugin_basename',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$testee = new Testee( $file );

		$path = dirname( $file ) . '/languages';

		WP_Mock::wpFunction(
			'load_plugin_textdomain',
			array(
				'times' => 1,
				'args'  => array(
					'default-post-date',
					FALSE,
					$path,
				),
			)
		);

		$testee->load();

		$this->assertConditionsMet();
	}

}
