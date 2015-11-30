<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\Asset;

use Mockery;
use tfrommen\DefaultPostDate\Asset\Controller as Testee;
use tfrommen\DefaultPostDate\Asset\Script;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the asset controller.
 */
class ControllerTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Asset\Controller::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		/** @var Script $script */
		$script = Mockery::mock( 'tfrommen\DefaultPostDate\Asset\Script' );

		$testee = new Testee( $script );

		WP_Mock::expectActionAdded( 'admin_head-post-new.php', array( $script, 'enqueue' ) );

		$testee->initialize();

		$this->assertConditionsMet();
	}
}
