<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Models\TextDomain as Testee;
use WP_Mock\Tools\TestCase;

class TextDomainModelTest extends TestCase {

	public function test_load() {

		$file = '/path/to/file.php';

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
