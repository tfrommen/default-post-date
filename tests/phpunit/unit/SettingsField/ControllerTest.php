<?php # -*- coding: utf-8 -*-

namespace tfrommen\Tests\DefaultPostDate\SettingsField;

use Mockery;
use tfrommen\DefaultPostDate\SettingsField\Controller as Testee;
use tfrommen\DefaultPostDate\SettingsField\View;
use WP_Mock;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the settings field controller.
 */
class ControllerTest extends TestCase {

	/**
	 * @covers tfrommen\DefaultPostDate\SettingsField\Controller::initialize
	 *
	 * @return void
	 */
	public function test_initialize() {

		/** @var View $view */
		$view = Mockery::mock( 'tfrommen\DefaultPostDate\SettingsField\View' );

		$testee = new Testee( $view );

		WP_Mock::expectActionAdded( 'admin_init', array( $view, 'add' ) );

		$testee->initialize();

		$this->assertConditionsMet();
	}
}
