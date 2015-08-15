<?php # -*- coding: utf-8 -*-

use tf\DefaultPostDate\Controllers\Script as Testee;
use WP_Mock\Tools\TestCase;

class ScriptControllerTest extends TestCase {

	public function test_initialize() {

		$view = Mockery::mock( 'tf\DefaultPostDate\Views\Script' );

		/** @var tf\DefaultPostDate\Views\Script $view */
		$testee = new Testee( $view );

		WP_Mock::expectActionAdded( 'post_submitbox_misc_actions', array( $view, 'render' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
