<?php # -*- coding: utf-8 -*-

use tfrommen\DefaultPostDate\Controllers\Script as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the ScriptController class.
 */
class ScriptControllerTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\Controllers\Script::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		/** @var tfrommen\DefaultPostDate\Views\Script $view */
		$view = Mockery::mock( 'tfrommen\DefaultPostDate\Views\Script' );

		$testee = new Testee( $view );

		WP_Mock::expectActionAdded( 'post_submitbox_misc_actions', array( $view, 'render' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
