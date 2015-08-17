<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Models\TextDomain as Testee;
use WP_Mock\Tools\TestCase;

class TextDomainModelTest extends TestCase {

	public function test___construct() {

		$file = '/path/to/default-post-date.php';

		WP_Mock::wpPassthruFunction( 'plugin_basename', array( 'times' => 1 ) );

		$testee = new Testee( $file );

		$this->assertAttributeSame( 'default-post-date', 'domain', $testee );

		$path = dirname( $file ) . '/languages';

		$this->assertAttributeSame( $path, 'path', $testee );
	}

	public function test_load() {

		$file = '/path/to/default-post-date.php';

		WP_Mock::wpPassthruFunction( 'plugin_basename', array( 'times' => 1 ) );

		$testee = new Testee( $file );

		$dir = dirname( $file );

		WP_Mock::wpFunction(
			'load_plugin_textdomain',
			array(
				'args'  => array(
					'default-post-date',
					FALSE,
					$dir . '/languages',
				),
				'times' => 1,
			)
		);

		$testee->load();

		$this->assertConditionsMet();
	}

}
