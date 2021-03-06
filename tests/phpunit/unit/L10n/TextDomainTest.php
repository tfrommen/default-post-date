<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\L10n;

use tfrommen\DefaultPostDate\L10n\TextDomain as Testee;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the text domain model.
 */
class TextDomainTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\L10n\TextDomain::load
	 *
	 * @return void
	 */
	public function test_load() {

		$file = '/path/to/file.php';

		$text_domain = 'text-domain';

		$domain_path = '/domain';

		$plugin_data = compact(
			'text_domain',
			'domain_path'
		);

		WP_Mock::wpPassthruFunction(
			'plugin_basename',
			array(
				'args' => array(
					$file,
				),
			)
		);

		$testee = new Testee( $plugin_data, $file );

		$domain_path = dirname( $file ) . $domain_path;

		WP_Mock::wpFunction(
			'load_plugin_textdomain',
			array(
				'args' => array(
					$text_domain,
					false,
					$domain_path,
				),
			)
		);

		$testee->load();

		$this->assertConditionsMet();
	}

}
